<?php


namespace App\Queries\Admin;


use App\Models\UserDocument;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Storage;

class UserDocumentsTable
{
    public static function generateResponse(string $uid, int $rows, array $request): array
    {
        // Define helpful variables
        $constraints = $request[$uid] ?? null;
        $filter = $request[$uid]['filter'] ?? null;
        $sort = $request[$uid]['sort'] ?? null;
        $query = UserDocument::query();

        // Apply user document filters
        $query
            ->filter([
                'review_status' => $filter['review_status'] ?? null,
                'created_at' => $filter['submitted'] ?? null,
                'reviewed_at' => $filter['reviewed'] ?? null,
            ]);

        // Select necessary columns
        $query
            ->addSelect([
                'user_documents.id',
                'user_documents.user_id',
                'user_documents.liability_file_name',
                'user_documents.tax_file_name',
                'user_documents.review_status',
                'user_documents.review_message',
                'user_documents.reviewed_at',
                'user_documents.created_at'
            ]);

        // Apply user filters
        $query
            ->whereHas('user', function (Builder $query) use ($filter) {
                $query->filter([
                    'first_name' => $filter['user_first_name'] ?? null,
                    'last_name' => $filter['user_last_name'] ?? null,
                ]);
            });

        // Join users onto user documents and select necessary columns
        $query
            ->join('users', 'user_documents.user_id', '=', 'users.id')
            ->addSelect([
                'users.first_name as user_first_name',
                'users.last_name as user_last_name',
            ]);

        // Sort the data
        foreach ($constraints['sort_priority'] ?? [] as $field) {
            $query
                ->orderBy($field, $sort[$field]);
        }

        // Paginate the query
        $paginated = $query
            ->paginate($constraints['display_row'] ?? $rows, ['*'], $uid . '_page')
            ->appends($request);

        // Transform the paginated data
        $paginated
            ->getCollection()
            ->transform(function ($document) {
                $document->liability_file = Storage::disk('s3')
                    ->temporaryUrl("user-documents/{$document->liability_file_name}", now()->addMinutes(5));
                $document->tax_file = Storage::disk('s3')
                    ->temporaryUrl("user-documents/{$document->tax_file_name}", now()->addMinutes(5));
                $document->reviewed = Carbon::parse($document->reviewed_at)->isoFormat('MMM Do, h:mm a');
                $document->submitted = Carbon::parse($document->created_at)->isoFormat('MMM Do, h:mm a');
                return $document;
            });

        // Construct the response data
        return [
            'uid' => $uid,
            'pagination' => $paginated,
            'filter' => [
                'user_first_name' => [
                    'value' => $filter['user_first_name'] ?? null,
                    'options' => null,
                ],
                'user_last_name' => [
                    'value' => $filter['user_last_name'] ?? null,
                    'options' => null,
                ],
                'review_status' => [
                    'value' => $filter['review_status'] ?? null,
                    'options' => [
                        'Pending',
                        'Approved',
                        'Rejected',
                    ],
                ],
                'reviewed' => [
                    'value' => $filter['reviewed'] ?? null,
                    'options' => null,
                ],
                'submitted' => [
                    'value' => $filter['submitted'] ?? null,
                    'options' => null,
                ],
            ],
            'sort' => [
                'priority' => $constraints['sort_priority'] ?? [],
                'direction' => [
                    'user_first_name' => $sort['user_first_name'] ?? null,
                    'user_last_name' => $sort['user_last_name'] ?? null,
                    'review_status' => $sort['review_status'] ?? null,
                    'reviewed' => $sort['reviewed'] ?? null,
                    'submitted' => $sort['submitted'] ?? null,
                ],
            ],
            'display' => [
                'column' => [
                    'user_first_name' => [
                        'value' => true,
                        'default' => true,
                    ],
                    'user_last_name' => [
                        'value' => true,
                        'default' => true,
                    ],
                    'review_status' => [
                        'value' => $constraints['display_column']['review_status'] ?? true,
                        'default' => true,
                    ],
                    'liability_file' => [
                        'value' => $constraints['display_column']['liability_file'] ?? true,
                        'default' => true,
                    ],
                    'tax_file' => [
                        'value' => $constraints['display_column']['tax_file'] ?? true,
                        'default' => true,
                    ],
                    'reviewed' => [
                        'value' => $constraints['display_column']['reviewed'] ?? true,
                        'default' => true,
                    ],
                    'submitted' => [
                        'value' => $constraints['display_column']['submitted'] ?? true,
                        'default' => true,
                    ],
                ],
                'row' => [
                    'value' => $constraints['display_row'] ?? $rows,
                    'default' => $rows,
                ]
            ]
        ];
    }
}
