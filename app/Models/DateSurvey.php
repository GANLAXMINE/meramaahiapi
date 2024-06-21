<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DateSurvey extends Model
{
    protected $table = 'date_survey';
    protected $fillable = [
        'user_id',
        'answer_1',
        'answer_2',
        'answer_3',
        'answer_4',
        'answer_5',
        'answer_6',
        'answer_7',
        'answer_8',
        'answer_9'
    ];
}
