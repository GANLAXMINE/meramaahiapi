<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SurveyMatchQuestion extends Model
{
    protected $table = 'survey_questions';
    protected $fillable = [
        'category',
        'category_hi',
        'category_ja',
        'category_es',
        'category_de',
        'category_fr',
        'category_it',
        'category_ru',
        'description',
        'description_hi',
        'description_ja',
        'description_es',
        'description_de',
        'description_fr',
        'description_it',
        'description_ru',
        'question',
        'question_hi',
        'question_ja',
        'question_es',
        'question_de',
        'question_fr',
        'question_it',
        'question_ru',
        'option_1',
        'option_1_hi',
        'option_1_ja',
        'option_1_es',
        'option_1_de',
        'option_1_fr',
        'option_1_it',
        'option_1_ru',
        'option_2',
        'option_2_hi',
        'option_2_ja',
        'option_2_es',
        'option_2_de',
        'option_2_fr',
        'option_2_it',
        'option_2_ru',
        'option_3',
        'option_3_hi',
        'option_3_ja',
        'option_3_es',
        'option_3_de',
        'option_3_fr',
        'option_3_it',
        'option_3_ru',
        'option_4',
        'option_4_hi',
        'option_4_ja',
        'option_4_es',
        'option_4_de',
        'option_4_fr',
        'option_4_it',
        'option_4_ru',
        'option_5',
        'option_5_hi',
        'option_5_ja',
        'option_5_es',
        'option_5_de',
        'option_5_fr',
        'option_5_it',
        'option_5_ru',
        'option_types'
    ];
}
