<?php

namespace App\Queries\Admin;

use App\Models\Stand;
use App\Models\Venue;
use Illuminate\Database\Eloquent\Builder;

class StandsTable
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
        $query = Stand::query();

        // Apply event filters
        $query
            ->filter([
                'default_name' => $constraints['filter']['default_name'] ?? null,
                'location' => $constraints['filter']['location'] ?? null,
            ]);

        // Select necessary columns
        $query
            ->addSelect([
                'stands.id',
                'stands.venue_id',
                'stands.default_name',
                'stands.location',
            ]);

        // Apply venue filters
        $query
            ->whereHas('venue', function (Builder $query) use ($constraints) {
                $query->filter([
                    'name' => $constraints['filter']['venue_name'] ?? null,
                ]);
            });

        // Join venues onto events and select necessary columns
        $query
            ->join('venues', 'stands.venue_id', '=', 'venues.id')
            ->addSelect([
                'venues.name as venue_name',
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
                'default_name' => [
                    'value' => $constraints['filter']['default_name'] ?? null,
                    'options' => Venue::all()
                        ->pluck('default_name')
                        ->unique(),
                ],
                'location' => [
                    'value' => $constraints['filter']['location'] ?? null,
                    'options' => null,
                ],
                'venue_name' => [
                    'value' => $constraints['filter']['venue_name'] ?? null,
                    'options' => Venue::all()
                        ->pluck('name')
                        ->unique(),
                ],
            ],
            'sort' => [
                'priority' => $constraints['sort_priority'] ?? [],
                'direction' => [
                    'default_name' => $constraints['sort']['default_name'] ?? null,
                    'location' => $constraints['sort']['location'] ?? null,
                    'venue_name' => $constraints['sort']['venue_name'] ?? null,
                ]
            ],
            'display' => [
                'column' => [
                    'default_name' => [
                        'value' => true,
                        'default' => true,
                    ],
                    'location' => [
                        'value' => $constraints['display_column']['location'] ?? true,
                        'default' => true,
                    ],
                    'venue_name' => [
                        'value' => $constraints['display_column']['venue_name'] ?? true,
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
