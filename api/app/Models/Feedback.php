<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
    protected $table = 'feedbacks';

    use HasFactory;

    protected $fillable = [
        'recommendation_id',
        'score',
        'comment'
    ];
}
