<?php

namespace Tests\Feature\Reservation\Volunteer;

use App\Models\Reservation;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Inertia\Testing\Assert;
use Tests\TestCase;

class ReservationIndexTest extends TestCase
{
    use DatabaseMigrations;

    public function setUp(): void
    {
        parent::setUp();

        Collection::macro('hasReservation', function ($reservation) {
            \PHPUnit\Framework\Assert::assertTrue(
                $this->contains([
                    'id' => $reservation->id,
                    'event_title' => $reservation->event->title,
                    'event_start' => $reservation->event->start,
                    'event_end' => $reservation->event->end,
                    'venue_name' => $reservation->event->venue->name,
                    'position_type' => $reservation->position_type,
                ]),
                'Failed asserting that the response contains the reservation.'
            );
        });

        Collection::macro('missingReservation', function ($reservation) {
            \PHPUnit\Framework\Assert::assertFalse(
                $this->contains([
                    'id' => $reservation->id,
                    'event_title' => $reservation->event->title,
                    'event_start' => $reservation->event->start,
                    'event_end' => $reservation->event->end,
                    'venue_name' => $reservation->event->venue->name,
                    'position_type' => $reservation->position_type,
                ]),
                'Failed asserting that the response does not contain the reservation.'
            );
        });

    }

    /** @test */
    public function a_user_can_view_a_list_of_their_claimed_reservations()
    {
        $this->withoutExceptionHandling();

        // Arrange
        $user = User::factory()->create();
        $reservationA = Reservation::factory()->claimedBy($user)->create();
        $reservationB = Reservation::factory()->unclaimed()->create();
        $reservationC = Reservation::factory()->claimedBy($user)->create();

        // Act
        $response = $this->actingAs($user)->get('/volunteer/reservations');

        // Assert
        $reservationA = $reservationA->fresh(['event', 'event.venue']);
        $reservationB = $reservationB->fresh(['event', 'event.venue']);
        $reservationC = $reservationC->fresh(['event', 'event.venue']);

        $response->assertInertia(fn (Assert $page) => $page
            ->component('Volunteer/Reservation/Index')
            ->hasAll([
                'filters.fields.event_title',
                'filters.fields.event_start',
                'filters.fields.event_end',
                'filters.fields.venue_name',
                'filters.fields.position_type',
                'reservations.current_page',
                'reservations.first_page_url',
                'reservations.from',
                'reservations.last_page',
                'reservations.last_page_url',
                'reservations.links',
                'reservations.next_page_url',
                'reservations.path',
                'reservations.per_page',
                'reservations.prev_page_url',
                'reservations.to',
                'reservations.total',
            ])
            ->whereAll([
                'filters.options.venue_name' => Reservation::claimedBy($user)
                    ->with(['event', 'event.venue'])
                    ->get()
                    ->pluck('event.venue.name')
                    ->unique()
                    ->values(),
                'filters.options.position_type' => Reservation::claimedBy($user)
                    ->with(['event', 'event.venue'])
                    ->get()
                    ->pluck('position_type')
                    ->unique()
                    ->values(),
                'next.id' => $reservationA->id,
                'next.event.title' => $reservationA->event->title,
                'next.event.start' => $reservationA->event->start,
                'next.event.end' => $reservationA->event->end,
                'next.venue.name' => $reservationA->event->venue->name,
                'next.venue.street' => $reservationA->event->venue->street,
                'next.venue.city' => $reservationA->event->venue->city,
                'next.venue.state' => $reservationA->event->venue->state,
                'next.venue.zip' => $reservationA->event->venue->zip,
            ])
            ->where('reservations.data', function (Collection $reservations) use ($reservationA, $reservationB, $reservationC) {
                $reservations->hasReservation($reservationA);
                $reservations->missingReservation($reservationB);
                $reservations->hasReservation($reservationC);
                return true;
            })
            ->etc()
        );
    }

    /** @test */
    public function an_unauthenticated_user_cannot_view_a_list_of_reservations()
    {
        // Arrange

        // Act
        $response = $this->get('/volunteer/reservations');

        // Assert
        $response->assertStatus(302)
            ->assertRedirect('/login');
    }
}
