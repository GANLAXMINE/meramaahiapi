<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SurveyQuestion extends Model
{
    protected $table = 'survey_question';
    protected $fillable = [
        'category',
        'description',
        'questions',
        'option_1',
        'option_2',
        'option_3',
        'option_4',
        'option_5',
        'option_types'
    ];
}
