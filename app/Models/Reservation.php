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

    public function scopeAvailable($query)
    {
        return $query->where('user_id', null);
    }

    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    public function stand()
    {
        return $this->belongsTo(Stand::class);
    }
}
