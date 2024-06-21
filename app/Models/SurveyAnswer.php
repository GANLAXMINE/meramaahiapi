<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SurveyAnswer extends Model
{
    protected $table = 'survey_answers';
    protected $fillable = [
        'sender_id',
        'receiver_id',
        'answer_1',
        'answer_2',
        'answer_3',
        'answer_4',
        'answer_5',
        'answer_6',
        'answer_7',
        'answer_8',
        'answer_9',
        'answer_10',
        'answer_11',
        'answer_12',
        'answer_13',
        'answer_14',
        'answer_15',
        'answer_16',
        'answer_17',
        'answer_18',
        'answer_19',
        'answer_20',
        'answer_21',
        'answer_22',
        'answer_23',
        'answer_24',
        'answer_25'
    ];
}
