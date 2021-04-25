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
            \PHPUnit\Framework\Assert::assertTrue($this->contains(
                $event->fresh()
                    ->all()
                    ->where('id', '=', $event->id)
                    ->map(function ($item) {
                        return [
                            'id' => $item->id,
                            'venue_id' => $item->venue_id,
                            'title' => $item->title,
                            'start' => $item->start,
                            'end' => $item->end,
                            'published_at' => $item->published_at,
                            'venue' => [
                                'id' => $item->venue->id,
                                'name' => $item->venue->name,
                            ]
                        ];
                    })
                    ->first()
            ), 'Failed asserting that the response does contain the specified event.');
        });

        Collection::macro('missingEvent', function ($event) {
            \PHPUnit\Framework\Assert::assertFalse($this->contains(
                $event->fresh()
                    ->all()
                    ->where('id', '=', $event->id)
                    ->map(function ($item) {
                        return [
                            'id' => $item->id,
                            'venue_id' => $item->venue_id,
                            'title' => $item->title,
                            'start' => $item->start,
                            'end' => $item->end,
                            'published_at' => $item->published_at,
                            'venue' => [
                                'id' => $item->venue->id,
                                'name' => $item->venue->name,
                            ]
                        ];
                    })
                    ->first()
            ), 'Failed asserting that the response does not contain the specified event.');
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
            ->hasAll([
                'filters.fields.title',
                'filters.fields.start',
                'filters.fields.end',
                'filters.fields.venue_name',
                'events.current_page',
                'events.first_page_url',
                'events.from',
                'events.last_page',
                'events.last_page_url',
                'events.links',
                'events.next_page_url',
                'events.path',
                'events.per_page',
                'events.prev_page_url',
                'events.to',
                'events.total',
            ])
            ->whereAll([
                'filters.options.venue_name' => Event::published()->available()->with('venue')->get()
                    ->pluck('venue.name')->unique()->values(),
                'next.id' => $eventA->id,
                'next.title' => $eventA->title,
                'next.start' => $eventA->fresh()->start,
                'next.end' => $eventA->fresh()->end,
                'next.venue.name' => $eventA->venue->name,
                'next.venue.street' => $eventA->venue->street,
                'next.venue.city' => $eventA->venue->city,
                'next.venue.state' => $eventA->venue->state,
                'next.venue.zip' => $eventA->venue->zip,
            ])
            ->where('events.data', function (Collection $events) use ($eventA, $eventB, $eventC, $eventD, $eventE,
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
