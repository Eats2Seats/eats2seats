<?php

namespace Tests\Feature\Volunteer;

use App\Models\Reservation;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class ClaimReservationTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function a_user_can_claim_a_reservation()
    {
        $this->withoutExceptionHandling();

        // Arrange
        $user = User::factory()->create();
        $reservation = Reservation::factory()->unclaimed()->create();

        // Act
        $response = $this->actingAs($user)->put('/volunteer/reservations/' . $reservation->id, [
            'user_id' => $user->id,
        ]);

        // Assert
        $response->assertStatus(302)
            ->assertRedirect('/volunteer/reservations/' . $reservation->id);
        $this->assertEquals($user->id, $reservation->fresh()->user_id);
    }
}
