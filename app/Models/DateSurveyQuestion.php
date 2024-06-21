<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DateSurveyQuestion extends Model
{
    protected $table = 'date_survey_questions';
    protected $fillable = [
        'questions_en',
        'questions_es',
        'questions_ja',
        'questions_de',
        'option_1_en',
        'option_1_es',
        'option_1_ja',
        'option_1_de',
        'option_2_en',
        'option_2_es',
        'option_2_ja',
        'option_2_de',
        'option_3_en',
        'option_3_es',
        'option_3_ja',
        'option_3_de'
    ];
}
