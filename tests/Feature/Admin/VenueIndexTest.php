<?php

namespace Tests\Feature\Admin;

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
                'venue_constraints.filter.name.value' => null,
                'venue_constraints.filter.city.value' => null,
                'venue_constraints.filter.city.options' => Venue::select('city')->distinct()->get(),
                'venue_constraints.filter.state.value' => null,
                'venue_constraints.filter.state.options' => Venue::select('state')->distinct()->get(),
                'venue_constraints.sort.name.value' => null,
                'venue_constraints.sort.name.options' => Venue::sortOptions['name'],
                'venue_constraints.sort.city.value' => null,
                'venue_constraints.sort.city.options' => Venue::sortOptions['city'],
                'venue_constraints.sort.state.value' => null,
                'venue_constraints.sort.state.options' => Venue::sortOptions['state'],
                'venue_constraints.group' => [],
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
