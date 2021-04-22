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
            'published_at' => Carbon::parse('-1 week'),
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

    /** @test */
    public function events_can_be_filtered_by_title()
    {
        // Arrange
        $eventA = Event::factory()->create([
            'title' => 'One'
        ]);
        $eventB = Event::factory()->create([
            'title' => 'One'
        ]);
        $eventC = Event::factory()->create([
            'title' => 'Two'
        ]);

        // Act
        $filteredEvents = Event::filter(collect([
            'title' => 'one',
        ]))->get()->toArray();

        // Assert
        $this->assertContains($eventA->fresh()->toArray(), $filteredEvents);
        $this->assertContains($eventB->fresh()->toArray(), $filteredEvents);
        $this->assertNotContains($eventC->fresh()->toArray(), $filteredEvents);
    }

    /** @test */
    public function events_can_be_filtered_by_start_date()
    {
        // Arrange
        $eventA = Event::factory()->create([
            'start' => Carbon::parse('March 23 2022')
        ]);
        $eventB = Event::factory()->create([
            'start' => Carbon::parse('March 24 2022')
        ]);
        $eventC = Event::factory()->create([
            'start' => Carbon::parse('March 25 2022')
        ]);

        // Act
        $filteredEvents = Event::filter(collect([
            'start' => Carbon::parse('March 24 2022')
        ]))->get()->toArray();

        // Assert
        $this->assertNotContains($eventA->fresh()->toArray(), $filteredEvents);
        $this->assertContains($eventB->fresh()->toArray(), $filteredEvents);
        $this->assertContains($eventC->fresh()->toArray(), $filteredEvents);
    }

    /** @test */
    public function events_can_be_filtered_by_end_date()
    {
        // Arrange
        $eventA = Event::factory()->create([
            'end' => Carbon::parse('March 23 2022')
        ]);
        $eventB = Event::factory()->create([
            'end' => Carbon::parse('March 24 2022')
        ]);
        $eventC = Event::factory()->create([
            'end' => Carbon::parse('March 25 2022')
        ]);

        // Act
        $filteredEvents = Event::filter(collect([
            'end' => Carbon::parse('March 24 2022')
        ]))->get()->toArray();

        // Assert
        $this->assertContains($eventA->fresh()->toArray(), $filteredEvents);
        $this->assertContains($eventB->fresh()->toArray(), $filteredEvents);
        $this->assertNotContains($eventC->fresh()->toArray(), $filteredEvents);
    }
}
