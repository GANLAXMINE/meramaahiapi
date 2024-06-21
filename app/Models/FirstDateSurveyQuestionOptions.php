<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FirstDateSurveyQuestionOptions extends Model
{
    protected $table = 'first_date_survey_question_options';

    protected $fillable = [
        'question_id',
        'option',
        'option_hi',
        'option_ja',
        'option_es',
        'option_de',
        'option_fr',
        'option_it',
        'option_ru',
        'created_at',
        'updated_at',
    ];
    public function question()
    {
        return $this->belongsTo(FirstDateSurveyQuestions::class, 'question_id');
    }
}
