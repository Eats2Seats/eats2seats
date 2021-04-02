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

    private $user;

    public function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
    }

    /** @test */
    public function a_volunteer_can_view_details_for_a_published_upcoming_event_without_a_reservation()
    {
        $this->withoutExceptionHandling();

        // Arrange
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

        // Act
        $response = $this->actingAs($this->user)
            ->get('/volunteer/events/' . $event->id);

        // Assert
        $response->assertStatus(200)
            ->assertPropValue('event.is_registered', false)
            ->assertPropValue('event.title', $event['title'])
            ->assertPropValue('event.start', $event['start'])
            ->assertPropValue('event.end', $event['end'])
            ->assertPropValue('venue.name', $venue['name'])
            ->assertPropValue('venue.street', $venue['street'])
            ->assertPropValue('venue.city', $venue['city'])
            ->assertPropValue('venue.state', $venue['state'])
            ->assertPropValue('venue.zip', $venue['zip'])
            ->assertPropValue('reservation', null);
    }

    /** @test */
    public function a_volunteer_can_view_details_for_a_published_upcoming_event_with_a_reservation()
    {
        $this->withoutExceptionHandling();
        // Arrange
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
            'location' => 'Stand 13',
        ]);
        $reservation = Reservation::factory()->create([
            'event_id' => $event->id,
            'stand_id' => $stand->id,
            'user_id' => $this->user->id,
            'stand_name' => 'Bob\'s Burgers',
            'position_type' => 'Alcohol Sales',
        ]);
        // Act
        $response = $this->actingAs($this->user)
            ->get('/volunteer/events/' . $event->id);

        // Assert
        $response->assertStatus(200)
            ->assertPropValue('event.is_registered', true)
            ->assertPropValue('event.title', $event['title'])
            ->assertPropValue('event.start', $event['start'])
            ->assertPropValue('event.end', $event['end'])
            ->assertPropValue('venue.name', $venue['name'])
            ->assertPropValue('venue.street', $venue['street'])
            ->assertPropValue('venue.city', $venue['city'])
            ->assertPropValue('venue.state', $venue['state'])
            ->assertPropValue('venue.zip', $venue['zip'])
            ->assertPropValue('reservation.stand_name', $reservation['stand_name'])
            ->assertPropValue('reservation.position_type', $reservation['position_type']);
    }

    /** @test */
    public function a_volunteer_cannot_view_unpublished_event_details()
    {
        // Arrange
        $event = Event::factory()->unpublished()->create();

        // Act
        $response = $this->get('/volunteer/events/' . $event->id);

        // Assert
        $response->assertStatus(404);
    }
}
