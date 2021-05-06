<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserDocument extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $dates = [

    ];

    public function scopeFilter($query, Array $filters) {
        $query
            ->when($filters['review_status'] ?? null, function ($query, $status) {
                $query->where('review_status', 'LIKE', '%'.$status.'%');
            })
            ->when($filters['reviewed_at'] ?? null, function ($query, $reviewedAt) {
                $query->whereDay('reviewed_at', Carbon::parse($reviewedAt));
            })
            ->when($filters['created_at'] ?? null, function ($query, $createdAt) {
                $query->whereDay('user_documents.created_at', Carbon::parse($createdAt));
            });
    }

    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function reviewer(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class, 'reviewed_by');
    }
}
