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

    public function scopeFilter($query, Array $filters) {
        $query
            ->when($filters['title'] ?? null, function ($query, $title) {
                $query->where('title', 'LIKE', '%'.$title.'%');
            })
            ->when($filters['start'] ?? null, function ($query, $start) {
                $query->where('start', '>=', Carbon::parse($start));
            })
            ->when($filters['end'] ?? null, function ($query, $end) {
                $query->where('end', '<=', Carbon::parse($end));
            });
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
