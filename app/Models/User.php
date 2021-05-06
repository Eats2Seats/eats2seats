<?php

namespace App\Models;

use App\Notifications\LegalDocumentRejectedNotification;
use App\Notifications\LegalDocumentsApprovedNotification;
use App\Notifications\VerifyEmailNotification;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens;
    use HasFactory;
    use Notifiable;
    use CanResetPassword;
    use TwoFactorAuthenticatable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'profile_photo_url',
    ];

    public function sendEmailVerificationNotification()
    {
        $this->notify(new VerifyEmailNotification());
    }

    public function scopeFilter($query, Array $filters) {
        $query
            ->when($filters['first_name'] ?? null, function ($query, $firstName) {
                $query->where('first_name', 'LIKE', '%'.$firstName.'%');
            })
            ->when($filters['last_name'] ?? null, function ($query, $lastName) {
                $query->where('last_name', 'LIKE', '%'.$lastName.'%');
            });
    }

    public function reservations(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Reservation::class);
    }

    public function documents(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(UserDocument::class);
    }
}
