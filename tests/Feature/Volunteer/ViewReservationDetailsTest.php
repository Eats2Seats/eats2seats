<?php

namespace Tests\Feature\Volunteer;

use App\Models\Event;
use App\Models\Reservation;
use App\Models\Stand;
use App\Models\User;
use App\Models\Venue;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class ViewReservationDetailsTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function a_user_can_view_their_claimed_reservation_for_a_future_event()
    {
        $this->withoutExceptionHandling();
        // Arrange
        $user = User::factory()->create();
        $venue = Venue::factory()->create([
            'name' => 'Kenan Memorial Stadium',
            'street' => '445 Paul Hardin Drive',
            'city' => 'Chapel Hill',
            'state' => 'NC',
            'zip' => '28147',
        ]);
        $event = Event::factory()->published()->create([
            'venue_id' => $venue->id,
            'title' => 'UNC vs Duke',
            'start' => Carbon::parse('+1 day 5:00 PM'),
            'end' => Carbon::parse('+1 day 8:00 PM'),
        ]);
        $stand = Stand::factory()->create([
            'venue_id' => $venue->id,
            'location' => 'Stand #1',
        ]);
        $reservation = Reservation::factory()->create([
            'event_id' => $event->id,
            'stand_id' => $stand->id,
            'user_id' => $user->id,
            'stand_name' => 'Bob\'s Burgers',
            'position_type' => 'Food Sales',
        ]);

        // Act
        $response = $this->actingAs($user)->get('/volunteer/reservations/' . $reservation->id);

        // Assert
        $response->assertStatus(200)
            ->assertPropCount('event', 3)
            ->assertPropValue('event', function ($actual) use ($event) {
                $this->assertEquals($event['title'], $actual['title']);
                $this->assertEquals($event['start'], $actual['start']);
                $this->assertEquals($event['end'], $actual['end']);
            })
            ->assertPropCount('venue', 5)
            ->assertPropValue('venue', function ($actual) use ($venue) {
                $this->assertEquals($venue['name'], $actual['name']);
                $this->assertEquals($venue['street'], $actual['street']);
                $this->assertEquals($venue['city'], $actual['city']);
                $this->assertEquals($venue['state'], $actual['state']);
                $this->assertEquals($venue['zip'], $actual['zip']);
            })
            ->assertPropCount('reservation', 4)
            ->assertPropValue('reservation', function ($actual) use ($reservation, $stand) {
                $this->assertEquals($reservation->id, $actual['id']);
                $this->assertEquals($reservation['stand_name'], $actual['stand_name']);
                $this->assertEquals($stand['location'], $actual['stand_location']);
                $this->assertEquals($reservation['position_type'], $actual['position_type']);
            });
    }

    /** @test */
    public function a_user_cannot_view_a_reservation_that_they_have_not_claimed()
    {
        // Arrange
        $userA = User::factory()->create();
        $userB = User::factory()->create();
        $reservation = Reservation::factory()->claimedBy($userA)->create();

        // Act
        $response = $this->actingAs($userB)->get('/volunteer/reservations/' . $reservation->id);

        // Assert
        $response->assertStatus(403);
    }

    /** @test */
    public function a_user_cannot_view_a_reservation_that_does_not_exist()
    {
        // Arrange

        // Act
        $response = $this->get('/volunteer/reservations/1');

        // Assert
        $response->assertStatus(404);
    }
}
