<?php

namespace Tests\Feature\Venue\Admin;

use App\Models\Venue;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Collection;
use Inertia\Testing\Assert;
use Tests\TestCase;

class VenueIndexTest extends TestCase
{
    use DatabaseMigrations;

    public function setUp(): void
    {
        parent::setUp();

        Collection::macro('assertHas', function ($value) {
            \PHPUnit\Framework\Assert::assertTrue(
                $this->contains($value),
                'Failed asserting that the value is contained in the collection.'
            );
        });
    }

    /** @test */
    public function a_user_can_view_a_list_of_venues()
    {
        $this->withoutExceptionHandling();
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
        $response = $this->get(route('admin.venues.index'));

        // Assert
        $response->assertInertia(fn (Assert $page) => $page
            ->component('Admin/Venue/Index')
            ->hasAll([
                'venues.current_page',
                'venues.first_page_url',
                'venues.from',
                'venues.last_page',
                'venues.last_page_url',
                'venues.links',
                'venues.next_page_url',
                'venues.path',
                'venues.per_page',
                'venues.prev_page_url',
                'venues.to',
                'venues.total',
            ])
            ->whereAll([
                'venue_constraints.fields.name.filter_value' => null,
                'venue_constraints.fields.name.sort_value' => null,
                'venue_constraints.fields.city.filter_value' => null,
                'venue_constraints.fields.city.filter_options' => Venue::all()->pluck('city')->unique(),
                'venue_constraints.fields.city.sort_value' => null,
                'venue_constraints.fields.state.filter_value' => null,
                'venue_constraints.fields.state.filter_options' => Venue::all()->pluck('state')->unique(),
                'venue_constraints.fields.state.sort_value' => null,
                'venue_constraints.sort' => [],
            ])
            ->where('venues.data', function (Collection $venues) use ($venueA, $venueB, $venueC) {
                $venues->assertHas($venueA->toArray());
                $venues->assertHas($venueB->toArray());
                $venues->assertHas($venueC->toArray());
                return true;
            })
            ->etc()
        );
    }
}
