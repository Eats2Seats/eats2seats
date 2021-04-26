<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Venue extends Model
{
    use HasFactory;
    public const sortOptions = [
        'name' => ['ASC', 'DESC'],
        'city' => ['ASC', 'DESC'],
        'state' => ['ASC', 'DESC'],
    ];

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
}
