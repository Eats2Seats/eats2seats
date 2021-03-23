<?php

namespace Tests\Feature\Volunteer;

use App\Models\Event;
use App\Models\Venue;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class ViewEventDetailsTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function a_volunteer_can_view_the_details_of_a_published_event()
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
        $response = $this->get('/volunteer/events/' . $event->id);

        // Assert
        $response->assertStatus(200);
        $response->assertPropValue('event', function ($event) {
            $this->assertEquals('UNC vs Duke', $event['title']);
            $this->assertEquals(Carbon::parse('March 23rd 2021 5:00 PM'), $event['start']);
            $this->assertEquals(Carbon::parse('March 23rd 2021 8:00 PM'), $event['end']);
        });
        $response->assertPropValue('venue', function ($venue) {
            $this->assertEquals('Kenan Memorial Stadium', $venue['name']);
            $this->assertEquals('104 Stadium Drive', $venue['street']);
            $this->assertEquals('Chapel Hill', $venue['city']);
            $this->assertEquals('North Carolina', $venue['state']);
            $this->assertEquals('27514', $venue['zip']);
        });
    }

    /** @test */
    public function a_volunteer_cannot_view_the_details_of_an_unpublished_event()
    {
        // Arrange
        $event = Event::factory()->unpublished()->create();

        // Act
        $response = $this->get('/volunteer/events/' . $event->id);

        // Assert
        $response->assertStatus(404);
    }
}
