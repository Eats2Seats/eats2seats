<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Venue extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $guarded = [];

    public function scopeFilter($query, Array $filters)
    {
        $query
            ->when($filters['name'] ?? null, function ($query, $name) {
                $query->where('name', 'LIKE','%'.$name.'%');
            })
            ->when($filters['city'] ?? null, function ($query, $city) {
                $query->where('city', 'LIKE','%'.$city.'%');
            })
            ->when($filters['state'] ?? null, function ($query, $state) {
                $query->where('state', 'LIKE','%'.$state.'%');
            });
    }

    public function events()
    {
        return $this->hasMany(Event::class);
    }

    public function stands()
    {
        return $this->hasMany(Stand::class);
    }
}
