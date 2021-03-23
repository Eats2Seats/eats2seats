<?php

namespace Tests\Unit;

use App\Models\Event;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class EventTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function an_events_with_a_published_at_date_are_published()
    {
        // Arrange
        $publishedEventA = Event::factory()->create([
            'published_at' => Carbon::parse('-3 weeks'),
        ]);
        $publishedEventB = Event::factory()->create([
            'published_at' => null,
        ]);
        $publishedEventC = Event::factory()->create([
            'published_at' => Carbon::parse('now'),
        ]);

        // Act
        $publishedEvents = Event::published()->get();

        // Assert
        $this->assertTrue($publishedEvents->contains($publishedEventA));
        $this->assertFalse($publishedEvents->contains($publishedEventB));
        $this->assertTrue($publishedEvents->contains($publishedEventC));
    }
}
