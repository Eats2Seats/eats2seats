<?php

namespace Tests\Feature\Volunteer;

use App\Models\Event;
use App\Models\Reservation;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class ClaimReservationTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function a_user_can_claim_a_reservation_for_themselves()
    {
        // Arrange
        $user = User::factory()->create();
        $reservation = Reservation::factory()->unclaimed()->create();

        // Act
        $response = $this->actingAs($user)
            ->from('/volunteer/reservations/' . $reservation->id . '/claim')
            ->put('/volunteer/reservations/' . $reservation->id, [
                'user_id' => $user->id,
            ]);

        // Assert
        $response->assertStatus(302)
            ->assertRedirect('/volunteer/reservations/' . $reservation->id);
        $this->assertEquals($user->id, $reservation->fresh()->user_id);
    }

    /** @test */
    public function a_user_cannot_claim_a_reservation_for_another_user()
    {
        // Arrange
        $userA = User::factory()->create();
        $userB = User::factory()->create();
        $reservation = Reservation::factory()->unclaimed()->create();

        // Act
        $response =$this->actingAs($userA)
            ->from('/volunteer/reservations/' . $reservation->id . '/claim')
            ->put('/volunteer/reservations/' . $reservation->id, [
                'user_id' => $userB->id,
            ]);

        // Assert
        $response->assertStatus(403);
        $this->assertNull($reservation->fresh()->user_id);
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
            ->put('/volunteer/reservations/' . $reservation->id, [
                'user_id' => $userA->id,
            ]);

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
            ->put('/volunteer/reservations/' . $reservationB->id, [
                'user_id' => $user->id,
            ]);

        // Assert
        $response->assertStatus(403);
        $this->assertNull($reservationB->fresh()->user_id);
    }

    /** @test */
    public function user_id_attribute_is_required()
    {
        // Arrange
        $user = User::factory()->create();
        $reservation = Reservation::factory()->unclaimed()->create();

        // Act
        $response = $this->actingAs($user)
            ->from('/volunteer/reservations/' . $reservation->id . '/claim')
            ->put('/volunteer/reservations/' . $reservation->id, [
            'user_id' => null,
        ]);

        // Assert
        $response->assertStatus(302)
            ->assertRedirect('/volunteer/reservations/' . $reservation->id . '/claim')
            ->assertSessionHasErrors('user_id');
        $this->assertNull($reservation->fresh()->user_id);
    }

    /** @test */
    public function user_id_attribute_must_be_an_integer()
    {
        // Arrange
        $user = User::factory()->create();
        $reservation = Reservation::factory()->unclaimed()->create();

        // Act
        $response = $this->actingAs($user)
            ->from('/volunteer/reservations/' . $reservation->id . '/claim')
            ->put('/volunteer/reservations/' . $reservation->id, [
                'user_id' => 'not an integer',
            ]);

        // Assert
        $response->assertStatus(302)
            ->assertRedirect('/volunteer/reservations/' . $reservation->id . '/claim')
            ->assertSessionHasErrors('user_id');
        $this->assertNull($reservation->fresh()->user_id);
    }

    /** @test */
    public function user_id_attribute_must_exist_in_database()
    {
        // Arrange
        $user = User::factory()->create([
            'id' => 1,
        ]);
        $reservation = Reservation::factory()->unclaimed()->create();

        // Act
        $response = $this->actingAs($user)
            ->from('/volunteer/reservations/' . $reservation->id . '/claim')
            ->put('/volunteer/reservations/' . $reservation->id, [
                'user_id' => 2,
            ]);

        // Assert
        $response->assertStatus(302)
            ->assertRedirect('/volunteer/reservations/' . $reservation->id . '/claim')
            ->assertSessionHasErrors('user_id');
        $this->assertNull($reservation->fresh()->user_id);
    }

    /** @test */
    public function a_user_cannot_claim_a_reservation_that_does_not_exist()
    {
        // Arrange
        $user = User::factory()->create();

        // Act
        $response = $this->actingAs($user)
            ->from('/volunteer/reservations/1/claim')
            ->put('/volunteer/reservations/1', [
                'user_id' => $user->id,
            ]);

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
