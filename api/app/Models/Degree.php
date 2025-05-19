<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Degree extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'university_id',
        'department_id',
        'name',
        'level'
    ];

    public function university()
    {
        return $this->belongsTo(University::class, 'university_id');
    }

    public function department()
    {
        return $this->belongsTo(Department::class, 'department_id');
    }


    public function courses()
    {
        return $this->hasMany(Course::class);
    }
}
