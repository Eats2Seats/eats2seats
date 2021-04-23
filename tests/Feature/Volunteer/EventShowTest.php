<?php

namespace Tests\Feature\Volunteer;

use App\Models\Event;
use App\Models\Stand;
use App\Models\Reservation;
use App\Models\User;
use App\Models\Venue;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Collection;
use Inertia\Testing\Assert;
use Tests\TestCase;

class EventShowTest extends TestCase
{
    use DatabaseMigrations;

    public function setUp(): void
    {
        parent::setUp();

        Collection::macro('hasPosition', function ($position) {
            \PHPUnit\Framework\Assert::assertTrue($this->contains($position), 'Failed asserting that the response does contain the specified event.');
        });

    }

    /** @test */
    public function a_user_can_view_details_for_a_published_future_event()
    {
        $this->withoutExceptionHandling();
        // Arrange
        $user = User::factory()->create();
        $venue = Venue::factory()->create([
            'name' => 'Kenan Memorial Stadium',
            'street' => '104 Stadium Drive',
            'city' => 'Chapel Hill',
            'state' => 'North Carolina',
            'zip' => '27514',
        ]);
        $event = Event::factory()->published()->create([
            'title' => 'UNC vs Duke',
            'venue_id' => $venue->id,
            'start' => Carbon::parse('March 23rd 2021 5:00 PM'),
            'end' => Carbon::parse('March 23rd 2021 8:00 PM'),
        ]);
        $standA = Stand::factory()->create([
            'venue_id' => $venue->id,
            'location' => 'Stand A',
        ]);
        $standB = Stand::factory()->create([
            'venue_id' => $venue->id,
            'location' => 'Stand B',
        ]);
        $reservations = collect([
            Reservation::factory()->create([
                'event_id' => $event->id,
                'stand_id' => $standA->id,
                'user_id' => null,
                'stand_name' => 'Bob\'s Burgers',
                'position_type' => 'Food Sales',
            ]),
            Reservation::factory()->create([
                'event_id' => $event->id,
                'stand_id' => $standA->id,
                'user_id' => null,
                'stand_name' => 'Bob\'s Burgers',
                'position_type' => 'Food Sales',
            ]),
            Reservation::factory()->create([
                'event_id' => $event->id,
                'stand_id' => $standA->id,
                'user_id' => User::factory()->create()->id,
                'stand_name' => 'Bob\'s Burgers',
                'position_type' => 'Food Sales',
            ]),
            Reservation::factory()->create([
                'event_id' => $event->id,
                'stand_id' => $standA->id,
                'user_id' => null,
                'stand_name' => 'Bob\'s Burgers',
                'position_type' => 'Alcohol Sales',
            ]),
            Reservation::factory()->create([
                'event_id' => $event->id,
                'stand_id' => $standA->id,
                'user_id' => null,
                'stand_name' => 'Bob\'s Burgers',
                'position_type' => 'Alcohol Sales',
            ]),
            Reservation::factory()->create([
                'event_id' => $event->id,
                'stand_id' => $standB->id,
                'user_id' => null,
                'stand_name' => 'Sally\'s Subs',
                'position_type' => 'Food Sales',
            ]),
            Reservation::factory()->create([
                'event_id' => $event->id,
                'stand_id' => $standB->id,
                'user_id' => null,
                'stand_name' => 'Sally\'s Subs',
                'position_type' => 'Food Sales',
            ]),
            Reservation::factory()->create([
                'event_id' => $event->id,
                'stand_id' => $standB->id,
                'user_id' => null,
                'stand_name' => 'Sally\'s Subs',
                'position_type' => 'Alcohol Sales',
            ]),
            Reservation::factory()->create([
                'event_id' => $event->id,
                'stand_id' => $standB->id,
                'user_id' => null,
                'stand_name' => 'Sally\'s Subs',
                'position_type' => 'Alcohol Sales',
            ])
        ]);

        // Act
        $response = $this->actingAs($user)
            ->get('/volunteer/events/' . $event->id);

        // Assert
        $response->assertInertia(fn (Assert $page) => $page
            ->component('Volunteer/Event/Show')
            ->has('event', fn (Assert $page) => $page
                ->whereAll([
                    'id' => $event->id,
                    'title' => $event->title,
                    'start' => $event->fresh()->start,
                    'end' => $event->fresh()->end,
                ])
            )
            ->has('venue', fn (Assert $page) => $page
                ->whereAll([
                    'name' => $venue->name,
                    'street' => $venue->street,
                    'city' => $venue->city,
                    'state' => $venue->state,
                    'zip' => $venue->zip,
                ])
            )
            ->has('positions', fn (Assert $page) => $page
                ->has('position_types', 2)
                ->where('position_types', function (Collection $positions) {
                    $this->assertContains('Food Sales', $positions);
                    $this->assertContains('Alcohol Sales', $positions);
                    return true;
                })
                ->has('list', fn (Assert $page) => $page
                    ->has('data', 4)
                    ->where('data', function (Collection $positions) use ($event, $standA, $standB, $reservations) {
                        $groupedReservations = $reservations->whereNull('user_id')
                            ->groupBy(['stand_name', 'position_type'])
                            ->map(function ($stand) {
                                return $stand->map(function ($position) {
                                    return [
                                        'event_id' => $position->first()->event_id,
                                        'stand_id' => $position->first()->stand_id,
                                        'stand_name' => $position->first()->stand_name,
                                        'position_type' => $position->first()->position_type,
                                        'remaining' => $position->count(),
                                    ];
                                })
                                    ->values();
                            })
                            ->collapse()
                            ->each(function ($position) use ($positions) {
                                $positions->hasPosition($position);
                            });
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
            )
            ->etc()
        );
    }

    /** @test */
    public function a_user_cannot_view_unpublished_event_details()
    {
        // Arrange
        $user = User::factory()->create();
        $event = Event::factory()->unpublished()->create();

        // Act
        $response = $this->actingAs($user)
            ->get('/volunteer/events/' . $event->id);

        // Assert
        $response->assertStatus(404);
    }

    /** @test */
    public function a_user_cannot_view_an_event_that_does_not_exist()
    {
        // Arrange
        $user = User::factory()->create();

        // Act
        $response = $this->actingAs($user)
            ->get('/volunteer/events/1');
        // Assert
        $response->assertStatus(404);
    }

    /** @test */
    public function an_unauthenticated_user_cannot_view_an_event()
    {
        // Arrange
        $event = Event::factory()->published()->future()->create();

        // Act
        $response = $this->get('/volunteer/events/' . $event->id);

        // Assert
        $response->assertStatus(302)
            ->assertRedirect('/login');
    }
}
