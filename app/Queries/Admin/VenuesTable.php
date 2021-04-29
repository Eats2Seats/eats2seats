<?php

namespace App\Queries\Admin;

use App\Models\Venue;

/**
 * Class EventsTable
 * @package App\Queries\Admin
 */
class VenuesTable
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
        $query = Venue::query();

        // Apply event filters
        $query
            ->filter([
                'name' => $constraints['filter']['name'] ?? null,
                'city' => $constraints['filter']['city'] ?? null,
                'state' => $constraints['filter']['state'] ?? null,
            ]);

        // Select necessary columns
        $query
            ->addSelect([
                'venues.id',
                'venues.name',
                'venues.street',
                'venues.city',
                'venues.state',
                'venues.zip',
            ]);

        // Get count of venue's related events
        $query
            ->withCount('events as events_count');

        // Get count of venue's related stands
        $query
            ->withCount('stands as stands_count');

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
                'name' => [
                    'value' => $constraints['filter']['name'] ?? null,
                    'options' => null,
                ],
                'city' => [
                    'value' => $constraints['filter']['city'] ?? null,
                    'options' => Venue::all()
                        ->pluck('city')
                        ->unique(),
                ],
                'state' => [
                    'value' => $constraints['filter']['state'] ?? null,
                    'options' => Venue::all()
                        ->pluck('state')
                        ->unique(),
                ],
            ],
            'sort' => [
                'priority' => $constraints['sort_priority'] ?? [],
                'direction' => [
                    'name' => $constraints['sort']['name'] ?? null,
                    'street' => $constraints['sort']['street'] ?? null,
                    'city' => $constraints['sort']['city'] ?? null,
                    'state' => $constraints['sort']['state'] ?? null,
                    'zip' => $constraints['sort']['zip'] ?? null,
                    'events_count' => $constraints['sort']['events_count'] ?? null,
                    'stands_count' => $constraints['sort']['stands_count'] ?? null,
                ]
            ],
            'display' => [
                'column' => [
                    'name' => [
                        'value' => true,
                        'default' => true,
                    ],
                    'street' => [
                        'value' => $constraints['display_column']['street'] ?? true,
                        'default' => true,
                    ],
                    'city' => [
                        'value' => $constraints['display_column']['city'] ?? true,
                        'default' => true,
                    ],
                    'state' => [
                        'value' => $constraints['display_column']['state'] ?? true,
                        'default' => true,
                    ],
                    'zip' => [
                        'value' => $constraints['display_column']['zip'] ?? true,
                        'default' => true,
                    ],
                    'events_count' => [
                        'value' => $constraints['display_column']['events_count'] ?? true,
                        'default' => true,
                    ],
                    'stands_count' => [
                        'value' => $constraints['display_column']['stands_count'] ?? true,
                        'default' => true,
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
