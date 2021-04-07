<?php

namespace Tests\Feature\Volunteer;

use App\Models\Event;
use App\Models\Reservation;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class ViewEventListTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function a_user_can_view_a_list_of_published_future_available_events()
    {
        $this->withoutExceptionHandling();

        // Arrange
        $eventA = Event::factory()->published()->future()->available()->create();
        $eventB = Event::factory()->published()->future()->unavailable()->create();

        $eventC = Event::factory()->published()->past()->available()->create();
        $eventD = Event::factory()->published()->past()->unavailable()->create();

        $eventE = Event::factory()->unpublished()->future()->available()->create();
        $eventF = Event::factory()->unpublished()->future()->unavailable()->create();

        $eventG = Event::factory()->unpublished()->past()->available()->create();
        $eventH = Event::factory()->unpublished()->past()->unavailable()->create();

        $eventI = Event::factory()->published()->future()->available()->create();

        // Act
        $response = $this->get('/volunteer/events');

        // Assert
        $response->assertStatus(200)
            ->assertPropCount('events', 2)
            ->assertPropValue('events', function ($events) use ($eventA, $eventB, $eventC, $eventD, $eventE,
                $eventF, $eventG, $eventH, $eventI)
            {
                $this->assertContains($eventA->fresh()->only(['id', 'title', 'start', 'end']), $events);
                $this->assertNotContains($eventB->fresh()->only(['id', 'title', 'start', 'end']), $events);
                $this->assertNotContains($eventC->fresh()->only(['id', 'title', 'start', 'end']), $events);
                $this->assertNotContains($eventD->fresh()->only(['id', 'title', 'start', 'end']), $events);
                $this->assertNotContains($eventE->fresh()->only(['id', 'title', 'start', 'end']), $events);
                $this->assertNotContains($eventF->fresh()->only(['id', 'title', 'start', 'end']), $events);
                $this->assertNotContains($eventG->fresh()->only(['id', 'title', 'start', 'end']), $events);
                $this->assertNotContains($eventH->fresh()->only(['id', 'title', 'start', 'end']), $events);
                $this->assertContains($eventI->fresh()->only(['id', 'title', 'start', 'end']), $events);
            });
    }
}
