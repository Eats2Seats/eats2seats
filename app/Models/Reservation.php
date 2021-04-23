<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'event_id' => 'integer',
        'stand_id' => 'integer',
        'user_id' => 'integer',
    ];

    public function scopeClaimedBy($query, $user)
    {
        return $query->where('user_id', $user->id);
    }

    public function scopeUnclaimed($query)
    {
        return $query->where('user_id', null);
    }

    public function scopeForEvent($query, $eventId)
    {
        return $query->where('event_id', $eventId);
    }

    public function scopeFilter($query, Array $filters)
    {
        $query
            ->when($filters['position_type'] ?? null, function ($query, $positionType) {
                $query->where('position_type', $positionType);
            });
    }

    public function event(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Event::class);
    }

    public function stand(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Stand::class);
    }
}
