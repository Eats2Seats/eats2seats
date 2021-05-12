<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Stand extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $guarded = [];

    public function scopeFilter($query, Array $filters)
    {
        $query
            ->when($filters['default_name'] ?? null, function ($query, $defaultName) {
                $query->where('default_name', 'LIKE', '%'.$defaultName.'%');
            })
            ->when($filters['location'] ?? null, function ($query, $location) {
                $query->where('location', 'LIKE', '%'.$location.'%');
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
