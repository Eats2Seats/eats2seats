<?php

namespace Tests\Unit;

use App\Models\Event;
use App\Models\Reservation;
use App\Models\Stand;
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
        $reservationA = Reservation::factory()->unclaimed()->create();
        $reservationB = Reservation::factory()->claimed()->create();
        $reservationC = Reservation::factory()->unclaimed()->create();

        // Act
        $availableReservations = Reservation::unclaimed()->get()->toArray();

        // Assert
        $this->assertContains($reservationA->fresh()->attributesToArray(), $availableReservations);
        $this->assertNotContains($reservationB->fresh()->attributesToArray(), $availableReservations);
        $this->assertContains($reservationC->fresh()->attributesToArray(), $availableReservations);
    }

    /** @test */
    public function reservations_can_be_filtered_by_position_type()
    {
        // Arrange
        $reservationA = Reservation::factory()->create([
            'position_type' => 'Food Sales',
        ]);
        $reservationB = Reservation::factory()->create([
            'position_type' => 'Food Sales',
        ]);
        $reservationC = Reservation::factory()->create([
            'position_type' => 'Alcohol Sales',
        ]);

        // Act
        $filteredReservations = Reservation::filter([
            'position_type' => 'Food Sales'
        ])->get()->toArray();

        // Assert
        $this->assertContains($reservationA->fresh()->toArray(), $filteredReservations);
        $this->assertContains($reservationB->fresh()->toArray(), $filteredReservations);
        $this->assertNotContains($reservationC->fresh()->toArray(), $filteredReservations);
    }
}
