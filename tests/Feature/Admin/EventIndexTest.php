<?php

namespace Tests\Feature\Admin;

use App\Models\Event;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Collection;
use Inertia\Testing\Assert;
use Tests\TestCase;

class EventIndexTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function a_user_can_view_a_list_events()
    {
        $this->withoutExceptionHandling();
        // Arrange
        $eventA = Event::factory()->create([
            'title' => 'Event One',
        ]);
        $eventB = Event::factory()->create([
            'title' => 'Event Two',
        ]);
        $eventC = Event::factory()->create([
            'title' => 'Event Three',
        ]);

        // Act
        $response = $this->get(route('admin.events.index'));

        // Assert
        $response->assertInertia(fn (Assert $page) => $page
            ->component('Admin/Event/Index')
            ->hasAll([
                'events.current_page',
                'events.first_page_url',
                'events.from',
                'events.last_page',
                'events.last_page_url',
                'events.links',
                'events.next_page_url',
                'events.path',
                'events.per_page',
                'events.prev_page_url',
                'events.to',
                'events.total',
            ])
            ->whereAll([
                'event_constraints.fields.title.filter_value' => null,
                'event_constraints.fields.title.sort_value' => null,
                'event_constraints.fields.start.filter_value' => null,
                'event_constraints.fields.start.sort_value' => null,
                'event_constraints.fields.end.filter_value' => null,
                'event_constraints.fields.end.sort_value' => null,
                'event_constraints.fields.published_at.filter_value' => null,
                'event_constraints.fields.published_at.sort_value' => null,
                'event_constraints.fields.venue_name.filter_value' => null,
                'event_constraints.fields.venue_name.filter_options' => Event::with('venue')->get()
                    ->pluck('venue.name')->unique(),
                'event_constraints.fields.venue_name.sort_value' => null,
            ])
            ->where('events.data', function (Collection $events) use ($eventA, $eventB, $eventC) {
                $format = function ($event) {
                    return [
                        'id' => $event->id,
                        'venue_id' => $event->venue_id,
                        'title' => $event->title,
                        'start' => $event->start,
                        'end' => $event->end,
                        'published_at' => $event->published_at,
                        'venue_name' => $event->venue->name,
                    ];
                };

                $events->assertHas($format($eventA));
                $events->assertHas($format($eventB));
                $events->assertHas($format($eventC));
            })
        );
    }
}
