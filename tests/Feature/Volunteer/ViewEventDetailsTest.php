<?php

namespace Tests\Feature\Volunteer;

use App\Models\Event;
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
        $details = [
            'title' => 'UNC vs Duke',
            'venue' => 'Kenan Memorial Stadium',
            'start' => Carbon::parse('March 23rd 2021 5:00 PM'),
            'end' => Carbon::parse('March 23rd 2021 8:00 PM'),
        ];
        $event = Event::factory()->published()->create($details);

        // Act
        $response = $this->get('/volunteer/events/' . $event->id);

        // Assert
        $response->assertStatus(200);
        $response->assertSee($details['title']);
        $response->assertSee($details['venue']);
        $response->assertSee($details['start']);
        $response->assertSee($details['end']);
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
