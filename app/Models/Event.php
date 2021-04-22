<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    public function scopePublished($query)
    {
        return $query->whereNotNull('published_at');
    }

    public function scopeAvailable($query)
    {
        return $query->whereHas('reservations', function (Builder $query) {
           $query->unclaimed();
        });
    }

    public function scopeFilter($query) {
        if (request('title')) {
            $query->where('title', 'LIKE', '%'.request('title').'%');
        }
        if (request('start')) {
            $query->where('start', '>=', Carbon::parse(request('start')));
        }
        if (request('end')) {
            $query->where('end', '<=', Carbon::parse(request('end')));
        }
        return $query;
    }

    public function venue()
    {
        return $this->belongsTo(Venue::class);
    }

    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }
}
