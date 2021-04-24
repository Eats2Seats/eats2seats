<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Venue extends Model
{
    use HasFactory;

    public function scopeFilter($query, Array $filters)
    {
        $query
            ->when($filters['name'] ?? null, function ($query, $name) {
                $query->where('name', $name);
            });
    }

    public function events()
    {
        return $this->hasMany(Event::class);
    }
}
