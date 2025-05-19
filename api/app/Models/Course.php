<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;

    protected $fillable = [
        'university_id',
        'department_id',
        'degree_id',
        'name',
        'level',
        'year',
        'semester',
        'no_credits',
        'description',
        'tags',
        'language',
        'link',
    ];

    public function university()
    {
        return $this->belongsTo(University::class, 'university_id');
    }

    public function department()
    {
        return $this->belongsTo(Department::class, 'department_id');
    }

    public function degree()
    {
        return $this->belongsTo(Degree::class, 'degree_id');
    }
}
