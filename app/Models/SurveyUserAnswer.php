<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SurveyUserAnswer extends Model
{
    protected $table = 'survey_user_answers';
    protected $fillable = [
        'receiver_id',
        'sender_id',
        'answers',
    ];
}
