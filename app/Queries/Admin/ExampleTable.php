<?php


namespace App\Queries\Admin;


use App\Models\Reservation;
use Illuminate\Database\Eloquent\Builder;

class ExampleTable
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
                '' => $filter[''] ?? null,
            ]);

        // Select required columns
        $query
            ->addSelect([
                '',
            ]);

        // Apply  filters, join  onto , and select required columns
        $query
            ->whereHas('', function (Builder $query) use ($filter) {
                $query->filter([
                    '' => $filter[''] ?? null,
                ]);
            })
            ->join('', '', '=', '')
            ->addSelect([
                ' as ',
            ]);

        // Sort reservations table by priority
        foreach ($constraints['sort_priority'] ?? [] as $field) {
            $query->orderBy($field, $sort[$field]);
        }

        // Paginate reservations table
        $paginated = $query
            ->paginate($rows, ['*'], $uid . '_page')
            ->appends($request);

        // Transform paginated data

        // Construct response
        return [
            'uid' => $uid,
            'pagination' => $paginated,
            'filter' => [
                '' => [
                    'value' => $filter[''] ?? null,
                    'options' => null,
                ],
            ],
            'sort' => [
                'priority' => $constraints['sort_priority'] ?? [],
                'direction' => [
                    '' => $sort[''] ?? null,
                ],
            ],
            'display' => [
                'column' => [
                    '' => [
                        'value' => $constraints['display_column'][''],
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
