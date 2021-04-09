<?php

namespace Tests\Unit;

use App\Models\Event;
use App\Models\Reservation;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class EventTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function events_with_a_published_at_date_are_published()
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

    /** @test */
    public function events_with_unclaimed_reservations_are_available()
    {
        // Arrange
        $eventA = Event::factory()
            ->published()
            ->future()
            ->has(Reservation::factory()->count(1))
            ->has(Reservation::factory()->claimed()->count(3))
            ->create();
        $eventB = Event::factory()
            ->published()
            ->future()
            ->has(Reservation::factory()->claimed()->count(3))
            ->create();
        $eventC = Event::factory()
            ->published()
            ->future()
            ->has(Reservation::factory()->count(2))
            ->create();

        // Act
        $availableEvents = Event::available()->get();

        // Assert
        $availableEvents->assertContains($eventA->fresh());
        $availableEvents->assertNotContains($eventB->fresh());
        $availableEvents->assertContains($eventC->fresh());
    }
}
