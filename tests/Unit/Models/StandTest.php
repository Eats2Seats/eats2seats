<?php

namespace Tests\Unit\Models;

use App\Models\Stand;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class StandTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function stands_can_be_filtered_by_default_name()
    {
        // Arrange
        $standA = Stand::factory()->create([
            'default_name' => 'Default Name One',
        ]);
        $standB = Stand::factory()->create([
            'default_name' => 'Default Name Two',
        ]);
        $standC = Stand::factory()->create([
            'default_name' => 'Default Name Three',
        ]);

        // Act
        $filteredVenues = Stand::filter([
            'default_name' => 'Default Name Two',
        ])
            ->get()
            ->toArray();

        // Assert
        $this->assertNotContains($standA->fresh()->toArray(), $filteredVenues);
        $this->assertContains($standB->fresh()->toArray(), $filteredVenues);
        $this->assertNotContains($standC->fresh()->toArray(), $filteredVenues);
    }

    /** @test */
    public function stands_can_be_filtered_by_location()
    {
        // Arrange
        $standA = Stand::factory()->create([
            'location' => 'Location One',
        ]);
        $standB = Stand::factory()->create([
            'location' => 'Location Two',
        ]);
        $standC = Stand::factory()->create([
            'location' => 'Location Three',
        ]);

        // Act
        $filteredVenues = Stand::filter([
            'location' => 'Location Two',
        ])
            ->get()
            ->toArray();

        // Assert
        $this->assertNotContains($standA->fresh()->toArray(), $filteredVenues);
        $this->assertContains($standB->fresh()->toArray(), $filteredVenues);
        $this->assertNotContains($standC->fresh()->toArray(), $filteredVenues);
    }
}
