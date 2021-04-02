<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Event extends Model
{
    use HasFactory;

    public function scopePublished($query)
    {
        return $query->whereNotNull('published_at');
    }

    public function venue()
    {
        return $this->belongsTo(Venue::class);
    }

    public function tickets()
    {
        return $this->hasMany(Reservation::class);
    }
}
