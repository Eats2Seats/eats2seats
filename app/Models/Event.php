<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

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

    public function scopeFilter($query, Collection $filters) {
        if ($filters->has('title')) {
            $query->where('title', 'LIKE', '%'.$filters['title'].'%');
        }
        if ($filters->has('start')) {
            $query->where('start', '>=', Carbon::parse($filters['start']));
        }
        if ($filters->has('end')) {
            $query->where('end', '<=', Carbon::parse($filters['end']));
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
