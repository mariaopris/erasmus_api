<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RecommendationCriterion extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'year',
        'duration',
        'university',
        'degree',
        'preferred_countries',
        'study_language',
        'recommendation',
        'status'
    ];

    public function university()
    {
        return $this->belongsTo(University::class, 'university');
    }

}
