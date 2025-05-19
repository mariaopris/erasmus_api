<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    protected $fillable = [
        'name',
        'family_name',
        'email',
        'gender',
        'date_of_birth',
        'nationality',
        'country',
        'address',
        'city',
        'postal_code',
        'phone_number',
        'password',
        'is_complete',
        'home_university',
        'degree',
        'year',
        'identity_no',
        'twofa_secret',
    ];

    public function tickets()
    {
        return $this->hasMany(Ticket::class, 'user_id');
    }

    public function applications()
    {
        return $this->hasMany(Application::class, 'user_id');
    }

    public function documents()
    {
        return $this->hasMany(Document::class, 'user_id');
    }

    public function steps()
    {
        return $this->hasMany(Step::class, 'user_id');
    }


    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
}
