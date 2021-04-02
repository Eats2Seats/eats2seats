<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    use HasFactory;

    public function scopeClaimedBy($query, $user)
    {
        return $query->where('user_id', $user->id);
    }
}
