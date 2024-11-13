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
        'description'
    ];

    public function applications()
    {
        return $this->hasMany(Application::class, 'university_id');
    }
}
