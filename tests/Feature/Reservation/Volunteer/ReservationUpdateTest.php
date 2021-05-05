<?php

namespace Tests\Feature\Reservation\Volunteer;

use App\Models\Event;
use App\Models\Reservation;
use App\Models\Stand;
use App\Models\User;
use App\Models\Venue;
use Inertia\Testing\Assert;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class ReservationUpdateTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function a_user_can_claim_a_reservation()
    {
        // Arrange
        $user = User::factory()->create();
        $reservation = Reservation::factory()->unclaimed()->create();

        // Act
        $response = $this->actingAs($user)
            ->from('/volunteer/reservations/' . $reservation->id . '/claim')
            ->put('/volunteer/reservations/' . $reservation->id);

        // Assert
        $response->assertStatus(302)
            ->assertRedirect('/volunteer/reservations/' . $reservation->id);
        $this->assertEquals($user->id, $reservation->fresh()->user_id);
    }

    /** @test */
    public function a_user_cannot_claim_a_reservation_already_claimed_by_another_user()
    {
        // Arrange
        $userA = User::factory()->create();
        $userB = User::factory()->create();
        $reservation = Reservation::factory()->claimedBy($userB)->create();

        // Act
        $response =$this->actingAs($userA)
            ->from('/volunteer/reservations/' . $reservation->id . '/claim')
            ->put('/volunteer/reservations/' . $reservation->id);

        // Assert
        $response->assertStatus(403);
        $this->assertEquals($userB->id, $reservation->fresh()->user_id);
    }

    /** @test */
    public function a_user_cannot_claim_more_than_one_reservation_per_event()
    {
        // Arrange
        $user = User::factory()->create();
        $event = Event::factory()->published()->future()->create();
        $reservationA = Reservation::factory()->claimedBy($user)->create([
            'event_id' => $event->id,
        ]);
        $reservationB = Reservation::factory()->unclaimed()->create([
            'event_id' => $event->id,
        ]);

        // Act
        $response = $this->actingAs($user)
            ->from('/volunteer/reservations/' . $reservationB->id . '/claim')
            ->put('/volunteer/reservations/' . $reservationB->id);

        // Assert
        $response->assertStatus(403);
        $this->assertNull($reservationB->fresh()->user_id);
    }

    /** @test */
    public function a_user_cannot_claim_a_reservation_if_it_conflicts_with_their_other_claimed_reservations()
    {
        // Arrange

        // Act

        // Assert
        $this->fail('NEED TO IMPLEMENT');
    }

    /** @test */
    public function a_user_cannot_claim_a_reservation_that_does_not_exist()
    {
        // Arrange
        $user = User::factory()->create();

        // Act
        $response = $this->actingAs($user)
            ->from('/volunteer/reservations/1/claim')
            ->put('/volunteer/reservations/1');

        // Assert
        $response->assertStatus(404);
    }

    /** @test */
    public function an_unauthenticated_user_cannot_claim_a_reservation()
    {
        // Arrange
        $reservation = Reservation::factory()->unclaimed()->create();

        // Act
        $response = $this->put('/volunteer/reservations/' . $reservation->id);

        // Assert
        $response->assertStatus(302)
            ->assertRedirect('/login');
    }
}
