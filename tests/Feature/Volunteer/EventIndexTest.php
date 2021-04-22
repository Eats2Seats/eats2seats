<?php

namespace Tests\Feature\Volunteer;

use App\Models\Event;
use App\Models\Reservation;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Collection;
use Inertia\Testing\Assert;
use Tests\TestCase;

class EventIndexTest extends TestCase
{
    use DatabaseMigrations;

    public function setUp(): void
    {
        parent::setUp();

        Collection::macro('hasEvent', function ($event) {
            \PHPUnit\Framework\Assert::assertTrue($this->contains($event->fresh()->only([
                'id', 'title', 'start', 'end', 'published_at',
            ])), 'Failed asserting that the response does contain the specified event.');
        });

        Collection::macro('missingEvent', function ($event) {
            \PHPUnit\Framework\Assert::assertFalse($this->contains($event->fresh()->only([
                'id', 'title', 'start', 'end', 'published_at',
            ])), 'Failed asserting that the response does not contain the specified event.');
        });

    }

    /** @test */
    public function a_user_can_view_a_list_of_published_future_available_events()
    {
        $this->withoutExceptionHandling();

        // Arrange
        $user = User::factory()->create();

        $eventA = Event::factory()->published()->future()->available()->create();
        $eventB = Event::factory()->published()->future()->unavailable()->create();

        $eventC = Event::factory()->published()->past()->available()->create();
        $eventD = Event::factory()->published()->past()->unavailable()->create();

        $eventE = Event::factory()->unpublished()->future()->available()->create();
        $eventF = Event::factory()->unpublished()->future()->unavailable()->create();

        $eventG = Event::factory()->unpublished()->past()->available()->create();
        $eventH = Event::factory()->unpublished()->past()->unavailable()->create();

        $eventI = Event::factory()->published()->future()->available()->create();

        // Act
        $response = $this->actingAs($user)
            ->get('/volunteer/events');

        // Assert
        $response->assertInertia(fn (Assert $page) => $page
            ->component('Volunteer/Event/Index')
            ->has('next', fn (Assert $page) => $page
                ->whereAll([
                    'id' => $eventA->id,
                    'title' => $eventA->title,
                    'start' => $eventA->fresh()->start,
                    'end' => $eventA->fresh()->end,
                ])
                ->has('venue', fn (Assert $page) => $page
                    ->whereAll([
                        'name' => $eventA->venue->name,
                        'street' => $eventA->venue->street,
                        'city' => $eventA->venue->city,
                        'state' => $eventA->venue->state,
                        'zip' => $eventA->venue->zip,
                    ])
                )
            )
            ->has('events', fn (Assert $page) => $page
                ->has('data', 2)
                ->where('data', function (Collection $events) use ($eventA, $eventB, $eventC, $eventD, $eventE,
                    $eventF, $eventG, $eventH, $eventI)
                {
                    $events->hasEvent($eventA);
                    $events->missingEvent($eventB);
                    $events->missingEvent($eventC);
                    $events->missingEvent($eventD);
                    $events->missingEvent($eventE);
                    $events->missingEvent($eventF);
                    $events->missingEvent($eventG);
                    $events->missingEvent($eventH);
                    $events->hasEvent($eventI);
                    return true;
                })
                ->hasAll([
                    'current_page',
                    'first_page_url',
                    'from',
                    'last_page',
                    'last_page_url',
                    'links',
                    'next_page_url',
                    'path',
                    'per_page',
                    'prev_page_url',
                    'to',
                    'total',
                ])
            )
            ->etc()
        );
    }

    /** @test */
    public function an_unauthenticated_user_cannot_view_a_list_of_events()
    {
        // Arrange

        // Act
        $response = $this->get('/volunteer/events');

        // Assert
        $response->assertStatus(302)
            ->assertRedirect('/login');
    }
}
