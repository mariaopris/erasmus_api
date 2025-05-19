<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class University extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'country',
        'code',
        'coordinator',
        'mobility_period',
        'isced_codes',
        'years',
        'languages',
        'description',
        'no_required_credits'
    ];

    public function applications()
    {
        return $this->hasMany(Application::class, 'university_id');
    }

    public function departments()
    {
        return $this->hasMany(Department::class);
    }

    public function degrees()
    {
        return $this->hasMany(Degree::class);
    }

    public function courses()
    {
        return $this->hasMany(Course::class);
    }
}
