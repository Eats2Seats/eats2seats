<?php

namespace Tests\Feature\Volunteer;

use App\Models\Reservation;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class ReservationDeleteTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function a_user_can_cancel_their_claimed_reservation()
    {
        $this->withoutExceptionHandling();

        // Arrange
        $user = User::factory()->create();
        $reservation = Reservation::factory()->claimedBy($user)->create();

        // Act
        $response = $this->actingAs($user)
            ->from('/volunteer/reservations/' . $reservation->id)
            ->delete('/volunteer/reservations/' . $reservation->id);

        // Assert
        $response->assertStatus(302)
            ->assertRedirect('/volunteer/reservations');
        $this->assertNull($reservation->fresh()->user_id);
    }

    /** @test */
    public function a_user_cannot_cancel_a_reservation_claimed_by_another_user()
    {
        // Arrange
        $userA = User::factory()->create();
        $userB = User::factory()->create();
        $reservation = Reservation::factory()->claimedBy($userB)->create();

        // Act
        $response = $this->actingAs($userA)
            ->from('/volunteer/reservations/' . $reservation->id)
            ->delete('/volunteer/reservations/' . $reservation->id);

        // Assert
        $response->assertStatus(403);
        $this->assertEquals($userB->id, $reservation->fresh()->user_id);
    }

    /** @test */
    public function a_user_cannot_delete_a_reservation_that_does_not_exist()
    {
        // Arrange
        $user = User::factory()->create();

        // Act
        $response = $this->actingAs($user)
            ->from('/volunteer/reservations/1')
            ->delete('/volunteer/reservations/1');

        // Assert
        $response->assertStatus(404);
    }

    /** @test */
    public function an_unauthenticated_user_cannot_cancel_a_reservation()
    {
        // Arrange
        $reservation = Reservation::factory()->claimed()->create();

        // Act
        $response = $this->delete('/volunteer/reservations/' . $reservation->id);

        // Assert
        $response->assertStatus(302)
            ->assertRedirect('/login');
    }
}
