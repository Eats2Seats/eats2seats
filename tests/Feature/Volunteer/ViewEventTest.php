<?php

namespace Tests\Feature\Volunteer;

use App\Models\Event;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class ViewEventTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function volunteer_can_view_a_published_event()
    {
        $this->withoutExceptionHandling();
        // Arrange
        $details = [
            'title' =>  'UNC vs Duke',
            'venue' => 'Dean Smith Center',
            'start' => Carbon::parse('+1 day 5:00 PM'),
            'end' => Carbon::parse('+1 day 10:00 PM')
        ];
        $event = Event::factory()->published()->create($details);

        // Act
        $response = $this->get('/volunteer/events/' . $event->id);

        // Assert
        $response->assertOk();
        $response->assertSee($details['title']);
        $response->assertSee($details['venue']);
        $response->assertSee($details['start']);
        $response->assertSee($details['end']);
    }

    /** @test */
    public function volunteer_cannot_view_an_unpublished_event()
    {
        // Arrange
        $event = Event::factory()->unpublished()->create();

        // Act
        $response = $this->get('/volunteer/events/' . $event->id);

        // Assert
        $response->assertSee(404);
    }
}
