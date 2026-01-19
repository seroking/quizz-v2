<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserAnswer extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'question_id', 'choice_ids', 'is_correct', 'points_earned'];

    protected $casts = [
        'choice_ids' => 'array', // automatically converts JSON <-> array
    ];
}
