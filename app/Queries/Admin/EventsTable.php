<?php

namespace App\Queries\Admin;

use App\Models\Event;
use App\Models\Venue;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

/**
 * Class EventsTable
 * @package App\Queries\Admin
 */
class EventsTable
{
    /**
     * Generate response data for admin events index table
     *
     * @param string $uid
     * @param int $rows
     * @param array $request
     * @return array
     */
    public static function generateResponse(string $uid, int $rows, array $request): array
    {
        // Define helpful variables
        $constraints = $request[$uid] ?? null;
        $query = Event::query();

        // Apply event filters
        $query
            ->filter([
                'title' => $constraints['filter']['title'] ?? null,
                'start' => $constraints['filter']['start'] ?? null,
                'end' => $constraints['filter']['end'] ?? null,
                'published_at' => $constraints['filter']['published_at'] ?? null,
                'is_published' => $constraints['filter']['is_published'] ?? null,
            ]);

        // Select necessary columns
        $query
            ->addSelect([
                'events.id',
                'events.venue_id',
                'events.title',
                'events.start',
                'events.end',
                'events.published_at',
                DB::raw('published_at is not null as is_published'),
            ]);

        // Apply venue filters
        $query
            ->whereHas('venue', function (Builder $query) use ($constraints) {
                $query->filter([
                    'name' => $constraints['filter']['venue_name'] ?? null,
                    'city' => $constraints['filter']['venue_city'] ?? null,
                    'state' => $constraints['filter']['venue_state'] ?? null,
                ]);
            });

        // Join venues onto events and select necessary columns
        $query
            ->join('venues', 'events.venue_id', '=', 'venues.id')
            ->addSelect([
                'venues.name as venue_name',
                'venues.city as venue_city',
                'venues.state as venue_state',
            ]);

        // Sort the data
        foreach ($constraints['sort_priority'] ?? [] as $field) {
            $query
                ->orderBy($field, $constraints['sort'][$field]);
        }

        // Construct the response
        return [
            'uid' => $uid,
            'pagination' => $query
                ->paginate(
                    $constraints['display_row'] ?? $rows,   // Number of rows per page
                    ['*'],  // Columns to include
                    $uid . '_page'   // Query param id
                )
                ->appends($request),
            'filter' => [
                'title' => [
                    'value' => $constraints['filter']['title'] ?? null,
                    'options' => null,
                ],
                'start' => [
                    'value' => $constraints['filter']['start'] ?? null,
                    'options' => null,
                ],
                'end' => [
                    'value' => $constraints['filter']['end'] ?? null,
                    'options' => null,
                ],
                'is_published' => [
                    'value' => $constraints['filter']['is_published'] ?? null,
                    'options' => [
                        'True',
                        'False',
                    ],
                ],
                'published_at' => [
                    'value' => $constraints['filter']['published_at'] ?? null,
                    'options' => null,
                ],
                'venue_name' => [
                    'value' => $constraints['filter']['venue_name'] ?? null,
                    'options' => Venue::all()
                        ->pluck('name')
                        ->unique(),
                ],
                'venue_city' => [
                    'value' => $constraints['filter']['venue_city'] ?? null,
                    'options' => Venue::all()
                        ->pluck('city')
                        ->unique(),
                ],
                'venue_state' => [
                    'value' => $constraints['filter']['venue_state'] ?? null,
                    'options' => Venue::all()
                        ->pluck('state')
                        ->unique(),
                ],
            ],
            'sort' => [
                'priority' => $constraints['sort_priority'] ?? [],
                'direction' => [
                    'title' => $constraints['sort']['title'] ?? null,
                    'start' => $constraints['sort']['start'] ?? null,
                    'end' => $constraints['sort']['end'] ?? null,
                    'is_published' => $constraints['sort']['is_published'] ?? null,
                    'published_at' => $constraints['sort']['published_at'] ?? null,
                    'venue_name' => $constraints['sort']['venue_name'] ?? null,
                    'venue_city' => $constraints['sort']['venue_city'] ?? null,
                    'venue_state' => $constraints['sort']['venue_state'] ?? null,
                ]
            ],
            'display' => [
                'column' => [
                    'title' => [
                        'value' => true,
                        'default' => true,
                    ],
                    'start' => [
                        'value' => $constraints['display_column']['start'] ?? true,
                        'default' => true,
                    ],
                    'end' => [
                        'value' => $constraints['display_column']['end'] ?? true,
                        'default' => true,
                    ],
                    'is_published' => [
                        'value' => $constraints['display_column']['is_published'] ?? true,
                        'default' => true,
                    ],
                    'published_at' => [
                        'value' => $constraints['display_column']['published_at'] ?? false,
                        'default' => false,
                    ],
                    'venue_name' => [
                        'value' => $constraints['display_column']['venue_name'] ?? true,
                        'default' => true,
                    ],
                    'venue_city' => [
                        'value' => $constraints['display_column']['venue_city'] ?? false,
                        'default' => false,
                    ],
                    'venue_state' => [
                        'value' => $constraints['display_column']['venue_state'] ?? false,
                        'default' => false,
                    ],
                ],
                'row' => [
                    'value' => $constraints['display_row'] ?? $rows,
                    'default' => $rows,
                ],
            ],
        ];
    }
}
