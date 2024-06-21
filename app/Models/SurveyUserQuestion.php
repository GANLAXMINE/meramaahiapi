<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SurveyUserQuestion extends Model
{
    protected $table = 'survey_user_questions';
    protected $fillable = [
        'receiver_id',
        'sender_id',
        'questions',
    ];
}
