<?php

namespace Tests\Unit;

use App\Models\Event;
use App\Models\Reservation;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class ReservationTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function reservations_with_a_user_id_are_claimed_by_that_user()
    {
        // Arrange
        $user = User::factory()->create();
        $reservation = Reservation::factory()->create([
            'user_id' => $user->id,
        ]);

        // Act
        $claimedReservation = Reservation::claimedBy($user)->first();

        // Assert
        $this->assertEquals($reservation->id, $claimedReservation->id);
    }

    /** @test */
    public function reservations_without_a_user_id_are_unclaimed()
    {
        // Arrange
        $reservationA = Reservation::factory()->create();
        $reservationB = Reservation::factory()->claimed()->create();
        $reservationC = Reservation::factory()->create();

        // Act
        $availableReservations = Reservation::unclaimed()->get()->toArray();

        // Assert
        $this->assertContains($reservationA->fresh()->attributesToArray(), $availableReservations);
        $this->assertNotContains($reservationB->fresh()->attributesToArray(), $availableReservations);
        $this->assertContains($reservationC->fresh()->attributesToArray(), $availableReservations);
    }
}
