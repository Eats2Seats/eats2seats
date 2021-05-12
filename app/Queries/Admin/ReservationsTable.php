<?php


namespace App\Queries\Admin;


use App\Models\Event;
use App\Models\Reservation;
use App\Models\Stand;
use App\Models\User;
use App\Models\Venue;
use Illuminate\Database\Eloquent\Builder;

class ReservationsTable
{
    public static function generateResponse(string $uid, int $rows, array $request): array
    {
        // Define helpful variables
        $constraints = $request[$uid] ?? null;
        $filter = $constraints['filter'] ?? null;
        $sort = $constraints['sort'] ?? null;
        $query = Reservation::query();

        // Apply reservation filters
        $query
            ->filter([
                'stand_name' => $filter['stand_name'] ?? null,
                'position_type' => $filter['position_type'] ?? null,
            ]);

        // Select required columns
        $query
            ->addSelect([
                'reservations.id',
                'reservations.event_id',
                'reservations.stand_id',
                'reservations.user_id',
                'reservations.stand_name',
                'reservations.position_type',
            ]);

        // Apply event filters, join events onto reservations, and select required columns
        $query
            ->whereHas('event', function (Builder $query) use ($filter) {
                $query->filter([
                    'title' => $filter['event_title'] ?? null,
                ]);
            })
            ->join('events', 'reservations.event_id', '=', 'events.id')
            ->addSelect([
                'events.venue_id',
                'events.title as event_title',
            ]);

        // Apply venue filters, join venues onto reservations, and select required columns
        $query
//            ->whereHas('venue', function (Builder $query) use ($filter) {
//                $query->filter([
//                    'name' => $filter['venue_name'] ?? null,
//                ]);
//            })
            ->join('venues', 'events.venue_id', '=', 'venues.id')
            ->addSelect([
                'venues.name as venue_name',
            ]);

        // Apply stand filters, join stands onto reservations, and select required columns
        $query
            ->whereHas('stand', function (Builder $query) use ($filter) {
                $query->filter([
                    'location' => $filter['stand_location'] ?? null,
                ]);
            })
            ->join('stands', 'reservations.stand_id', '=', 'stands.id')
            ->addSelect([
                'stands.location as stand_location',
            ]);

        // Apply user filters, join users onto reservations, and select required columns
        $query
//            ->whereHas('user', function (Builder $query) use ($filter) {
//                $query->filter([
//                    'first_name' => $filter['user_first_name'] ?? null,
//                    'last_name' => $filter['user_last_name'] ?? null,
//                ]);
//            })
            ->leftJoin('users', 'reservations.user_id', '=', 'users.id')
            ->addSelect([
                'users.first_name as user_first_name',
                'users.last_name as user_last_name',
            ]);

        // Sort reservations table by priority
        foreach ($constraints['sort_priority'] ?? [] as $field) {
            $query->orderBy($field, $sort[$field]);
        }

        // Paginate reservations table
        $paginated = $query
            ->paginate($constraints['display_row'] ?? $rows, ['*'], $uid . '_page')
            ->appends($request);

        // Transform paginated data

        // Construct response
        return [
            'uid' => $uid,
            'pagination' => $paginated,
            'filter' => [
                'event_title' => [
                    'value' => $filter['event_title'] ?? null,
                    'options' => Event::all()
                        ->pluck('title')
                        ->unique(),
                ],
                'venue_name' => [
                    'value' => $filter['venue_name'] ?? null,
                    'options' => Venue::all()
                        ->pluck('name')
                        ->unique(),
                ],
                'stand_location' => [
                    'value' => $filter['stand_location'] ?? null,
                    'options' => Stand::all()
                        ->pluck('location')
                        ->unique(),
                ],
                'user_first_name' => [
                    'value' => $filter['user_first_name'] ?? null,
                    'options' => User::all()
                        ->pluck('first_name')
                        ->unique(),
                ],
                'user_last_name' => [
                    'value' => $filter['user_last_name'] ?? null,
                    'options' => User::all()
                        ->pluck('last_name')
                        ->unique(),
                ],
                'stand_name' => [
                    'value' => $filter['stand_name'] ?? null,
                    'options' => Reservation::all()
                        ->pluck('stand_name')
                        ->unique(),
                ],
                'position_type' => [
                    'value' => $filter['position_type'] ?? null,
                    'options' => Reservation::all()
                        ->pluck('position_type')
                        ->unique(),
                ],
            ],
            'sort' => [
                'priority' => $constraints['sort_priority'] ?? [],
                'direction' => [
                    'event_title' => $sort['event_title'] ?? null,
                    'venue_name' => $sort['venue_name'] ?? null,
                    'stand_location' => $sort['stand_location'] ?? null,
                    'user_first_name' => $sort['user_first_name'] ?? null,
                    'user_last_name' => $sort['user_last_name'] ?? null,
                    'stand_name' => $sort['stand_name'] ?? null,
                    'position_type' => $sort['position_type'] ?? null,
                ],
            ],
            'display' => [
                'column' => [
                    'event_title' => [
                        'value' => $constraints['display_column']['event_title'] ?? true,
                        'default' => true,
                    ],
                    'venue_name' => [
                        'value' => $constraints['display_column']['venue_name'] ?? true,
                        'default' => true,
                    ],
                    'stand_location' => [
                        'value' => $constraints['display_column']['stand_location'] ?? true,
                        'default' => true,
                    ],
                    'user_first_name' => [
                        'value' => $constraints['display_column']['user_first_name'] ?? true,
                        'default' => true,
                    ],
                    'user_last_name' => [
                        'value' => $constraints['display_column']['user_last_name'] ?? true,
                        'default' => true,
                    ],
                    'stand_name' => [
                        'value' => true,
                        'default' => true,
                    ],
                    'position_type' => [
                        'value' => $constraints['display_column']['position_type'] ?? true,
                        'default' => true,
                    ],
                ],
                'row' => [
                    'value' => $constraints['display_row'] ?? $rows,
                    'default' => $rows,
                ]
            ],
        ];
    }
}
