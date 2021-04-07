<?php

namespace Tests\Unit;

use App\Models\Event;
<<<<<<< HEAD
<<<<<<< HEAD
=======
use App\Models\Reservation;
>>>>>>> bf1bfff9f0da675f67a0776a5b23c6842dd10ea2
=======
use App\Models\Reservation;
>>>>>>> bf1bfff9f0da675f67a0776a5b23c6842dd10ea2
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
<<<<<<< HEAD
<<<<<<< HEAD
            'published_at' => Carbon::parse('-1 week'),
        ]);
        $publishedEventB = Event::factory()->create([
            'published_at' => Carbon::parse('-3 days'),
        ]);
        $publishedEventC = Event::factory()->create([
            'published_at' => null,
=======
=======
>>>>>>> bf1bfff9f0da675f67a0776a5b23c6842dd10ea2
            'published_at' => Carbon::parse('-3 weeks'),
        ]);
        $publishedEventB = Event::factory()->create([
            'published_at' => null,
        ]);
        $publishedEventC = Event::factory()->create([
            'published_at' => Carbon::parse('now'),
<<<<<<< HEAD
>>>>>>> bf1bfff9f0da675f67a0776a5b23c6842dd10ea2
=======
>>>>>>> bf1bfff9f0da675f67a0776a5b23c6842dd10ea2
        ]);

        // Act
        $publishedEvents = Event::published()->get();

        // Assert
        $this->assertTrue($publishedEvents->contains($publishedEventA));
<<<<<<< HEAD
<<<<<<< HEAD
        $this->assertTrue($publishedEvents->contains($publishedEventB));
        $this->assertFalse($publishedEvents->contains($publishedEventC));
=======
=======
>>>>>>> bf1bfff9f0da675f67a0776a5b23c6842dd10ea2
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
<<<<<<< HEAD
>>>>>>> bf1bfff9f0da675f67a0776a5b23c6842dd10ea2
=======
>>>>>>> bf1bfff9f0da675f67a0776a5b23c6842dd10ea2
    }
}
