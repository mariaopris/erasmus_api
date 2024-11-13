<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'university_id',
        'status',
        'selection_score',
        'feedback_comments',
        'feedback_admin_id',
        'academic_year',
        'first_name',
        'last_name',
        'email',
        'date_of_birth',
        'phone',
        'id_number',
        'faculty',
        'study_cycle',
        'current_study_year',
        'education_field',
        'gpa',
        'summary',
        'mobility_program',
        'period_of_mobility',
        'mobility_start_date',
        'mobility_end_date',
        'destination_type',
        'destination_1',
        'destination_2',
        'destination_3',
        'placement_country'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function university()
    {
        return $this->belongsTo(University::class);
    }
}
