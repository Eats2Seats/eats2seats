<?php

namespace Tests\Feature\Volunteer;

use App\Models\Event;
use App\Models\Stand;
use App\Models\Reservation;
use App\Models\User;
use App\Models\Venue;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class ViewEventDetailsTest extends TestCase
{
    use DatabaseMigrations;

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
        $stand = Stand::factory()->create([
            'venue_id' => $venue->id,
            'location' => 'Stand 1',
        ]);
        $reservationA = Reservation::factory()->create([
            'event_id' => $event->id,
            'stand_id' => $stand->id,
            'user_id' => null,
            'stand_name' => 'Bob\'s Burgers',
            'position_type' => 'Alcohol Sales',
        ]);
        $reservationB = Reservation::factory()->create([
            'event_id' => $event->id,
            'stand_id' => $stand->id,
            'user_id' => null,
            'stand_name' => 'Sally\'s Subs',
            'position_type' => 'Food Sales',
        ]);
        $reservationC = Reservation::factory()->create([
            'event_id' => $event->id,
            'stand_id' => $stand->id,
            'user_id' => User::factory()->create()->id,
            'stand_name' => 'Holly\'s Hotdogs',
            'position_type' => 'Alcohol Sales',
        ]);

        // Act
        $response = $this->actingAs($user)
            ->get('/volunteer/events/' . $event->id);

        // Assert
        $response->assertStatus(200)
            ->assertPropCount('event', 4)
            ->assertPropValue('event', function ($actual) use ($event) {
                $this->assertEquals($event->id, $actual['id']);
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
            ->assertPropCount('reservations', 2)
            ->assertPropValue('reservations', function ($actual) use ($reservationA, $reservationB, $reservationC) {
                $reservationA = $reservationA->fresh('stand')->toArray();
                $reservationB = $reservationB->fresh('stand')->toArray();
                $reservationC = $reservationC->fresh('stand')->toArray();
                $this->assertContains([
                    'id' => $reservationA['id'],
                    'stand_name' => $reservationA['stand_name'],
                    'position_type' => $reservationA['position_type'],
                    'location' => $reservationA['stand']['location']
                ], $actual);
                $this->assertContains([
                    'id' => $reservationB['id'],
                    'stand_name' => $reservationB['stand_name'],
                    'position_type' => $reservationB['position_type'],
                    'location' => $reservationB['stand']['location']
                ], $actual);
                $this->assertNotContains([
                    'id' => $reservationC['id'],
                    'stand_name' => $reservationC['stand_name'],
                    'position_type' => $reservationC['position_type'],
                    'location' => $reservationC['stand']['location']
                ], $actual);
            });
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
