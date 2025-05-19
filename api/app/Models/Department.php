<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    use HasFactory;

    protected $fillable = [
        'university_id',
        'name'
    ];

    public function university()
    {
        return $this->belongsTo(University::class, 'university_id');
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

