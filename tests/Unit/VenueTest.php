<?php

namespace Tests\Unit;

use App\Models\Venue;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class VenueTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function venues_can_be_filtered_by_name()
    {
        // Arrange
        $venueA = Venue::factory()->create([
            'name' => 'Venue One',
        ]);
        $venueB = Venue::factory()->create([
            'name' => 'Venue Two',
        ]);
        $venueC = Venue::factory()->create([
            'name' => 'Venue Three',
        ]);

        // Act
        $filteredVenues = Venue::filter([
            'name' => 'Two',
        ])
            ->get()
            ->toArray();

        // Assert
        $this->assertNotContains($venueA->fresh()->toArray(), $filteredVenues);
        $this->assertContains($venueB->fresh()->toArray(), $filteredVenues);
        $this->assertNotContains($venueC->fresh()->toArray(), $filteredVenues);
    }

    /** @test */
    public function venues_can_be_filtered_by_city()
    {
        // Arrange
        $venueA = Venue::factory()->create([
            'city' => 'City One',
        ]);
        $venueB = Venue::factory()->create([
            'city' => 'City Two',
        ]);
        $venueC = Venue::factory()->create([
            'city' => 'City Three',
        ]);

        // Act
        $filteredVenues = Venue::filter([
            'city' => 'Two',
        ])
            ->get()
            ->toArray();

        // Assert
        $this->assertNotContains($venueA->fresh()->toArray(), $filteredVenues);
        $this->assertContains($venueB->fresh()->toArray(), $filteredVenues);
        $this->assertNotContains($venueC->fresh()->toArray(), $filteredVenues);
    }

    /** @test */
    public function venues_can_be_filtered_by_state()
    {
        // Arrange
        $venueA = Venue::factory()->create([
            'state' => 'State One',
        ]);
        $venueB = Venue::factory()->create([
            'state' => 'State Two',
        ]);
        $venueC = Venue::factory()->create([
            'state' => 'State Three',
        ]);

        // Act
        $filteredVenues = Venue::filter([
            'state' => 'Two',
        ])
            ->get()
            ->toArray();

        // Assert
        $this->assertNotContains($venueA->fresh()->toArray(), $filteredVenues);
        $this->assertContains($venueB->fresh()->toArray(), $filteredVenues);
        $this->assertNotContains($venueC->fresh()->toArray(), $filteredVenues);
    }
}
