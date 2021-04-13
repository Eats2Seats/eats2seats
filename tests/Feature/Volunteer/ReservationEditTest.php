<?php

namespace Tests\Feature\Volunteer;

use App\Models\Event;
use App\Models\Reservation;
use App\Models\Stand;
use App\Models\User;
use App\Models\Venue;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Inertia\Testing\Assert;
use Tests\TestCase;

class ReservationEditTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function a_user_can_view_a_reservations_claim_page()
    {
        $this->withoutExceptionHandling();
        // Arrange
        $user = User::factory()->create();
        $venue = Venue::factory()->create();
        $stand = Stand::factory()->create([
            'venue_id' => $venue->id
        ]);
        $event = Event::factory()->published()->future()->create([
            'venue_id' => $venue->id
        ]);
        $reservation = Reservation::factory()->unclaimed()->create([
            'event_id' => $event->id,
            'stand_id' => $stand->id,
        ]);

        // Act
        $response = $this->actingAs($user)
            ->get('/volunteer/reservations/' . $reservation->id . '/claim');

        // Assert
        $response->assertStatus(200)
            ->assertInertia(fn (Assert $page) => $page
                ->component('Volunteer/Reservation/Edit')
                ->has('reservation', fn (Assert $page) => $page
                    ->where('id', $reservation->id)
                    ->where('stand_name', $reservation->stand_name)
                    ->where('stand_location', $stand->location)
                    ->where('position_type', $reservation->position_type)
                )
                ->has('event', fn (Assert $page) => $page
                    ->where('title', $event->title)
                    ->where('start', $event->fresh()->start)
                    ->where('end', $event->fresh()->end)
                )
                ->has('venue', fn (Assert $page) => $page
                    ->where('name', $venue->name)
                    ->where('street', $venue->street)
                    ->where('city', $venue->city)
                    ->where('state', $venue->state)
                    ->where('zip', $venue->zip)
                )
            );
    }

    /** @test */
    public function a_user_cannot_view_a_claimed_reservations_claim_page()
    {
        // Arrange
        $user = User::factory()->create();
        $reservation = Reservation::factory()->claimed()->create();

        // Act
        $response = $this->actingAs($user)
            ->get('/volunteer/reservations/' . $reservation->id . '/claim');

        // Assert
        $response->assertStatus(404);
    }

    /** @test */
    public function a_user_cannot_view_a_reservations_claim_page_if_they_have_claimed_another_reservation_for_the_same_event()
    {
        // Arrange
        $user = User::factory()->create();
        $event = Event::factory()->create();
        $reservationA = Reservation::factory()->claimedBy($user)->create([
            'event_id' => $event->id,
        ]);
        $reservationB = Reservation::factory()->unclaimed()->create([
            'event_id' => $event->id,
        ]);

        // Act
        $response = $this->actingAs($user)
            ->get('/volunteer/reservations/' . $reservationB->id . '/claim');

        // Assert
        $response->assertStatus(403);
        $this->assertNull($reservationB->fresh()->user_id);
    }

    /** @test */
    public function a_user_cannot_view_the_claim_page_for_a_reservation_that_does_not_exist()
    {
        // Arrange
        $user = User::factory()->create();

        // Act
        $response = $this->actingAs($user)
            ->get('/volunteer/reservations/1/claim');

        // Assert
        $response->assertStatus(404);
    }

    /** @test */
    public function an_unauthenticated_user_cannot_view_a_reservations_claim_page()
    {
        // Arrange
        $reservation = Reservation::factory()->unclaimed()->create();

        // Act
        $response = $this->get('/volunteer/reservations/' . $reservation->id . '/claim');

        // Assert
        $response->assertStatus(302)
            ->assertRedirect('/login');
    }
}
