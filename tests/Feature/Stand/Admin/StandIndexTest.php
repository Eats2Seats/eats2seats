<?php

namespace Tests\Feature\Stand\Admin;

use App\Models\Stand;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Collection;
use Inertia\Testing\Assert;
use Tests\TestCase;

class StandIndexTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function a_user_can_view_a_list_of_stands()
    {
        $this->withoutExceptionHandling();
        // Arrange
        $standA = Stand::factory()->create([
            'default_name' => 'Stand One',
        ]);
        $standB = Stand::factory()->create([
            'default_name' => 'Stand Two',
        ]);
        $standC = Stand::factory()->create([
            'default_name' => 'Stand Three',
        ]);

        // Act
        $response = $this->get(route('admin.stands.index'));

        // Assert
        $response->assertInertia(fn (Assert $page) => $page
            ->component('Admin/Stand/Index')
            ->hasAll([
                'stands.current_page',
                'stands.first_page_url',
                'stands.from',
                'stands.last_page',
                'stands.last_page_url',
                'stands.links',
                'stands.next_page_url',
                'stands.path',
                'stands.per_page',
                'stands.prev_page_url',
                'stands.to',
                'stands.total',
            ])
            ->whereAll([
                'stand_constraints.fields.default_name.filter_value' => null,
                'stand_constraints.fields.default_name.sort_value' => null,
                'stand_constraints.fields.venue_name.filter_value' => null,
                'stand_constraints.fields.venue_name.filter_options' => Stand::with('venue')->get()
                    ->pluck('venue.name')->unique(),
                'stand_constraints.fields.venue_name.sort_value' => null,
                'stand_constraints.fields.stand_location.filter_value' => null,
                'stand_constraints.fields.stand_location.sort_value' => null,
                'stand_constraints.sort' => [],
            ])
            ->where('stands.data', function (Collection $stands) use ($standA, $standB, $standC) {
                $format = function ($stand) {
                    return [
                        'id' => $stand->id,
                        'venue_id' => $stand->venue_id,
                        'default_name' => $stand->default_name,
                        'stand_location' => $stand->location,
                        'venue_name' => $stand->venue->name,
                    ];
                };

                $stands->assertHas($format($standA));
                $stands->assertHas($format($standB));
                $stands->assertHas($format($standC));
                return true;
            })
            ->etc()
        );
    }
}
