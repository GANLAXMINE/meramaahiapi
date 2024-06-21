<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FirstDateSurveyQuestions extends Model
{
    protected $table = 'first_date_survey_questions';

    protected $fillable = [
        'questions',
        'questions_hi',
        'questions_ja',
        'questions_es',
        'questions_de',
        'questions_fr',
        'questions_it',
        'questions_ru',
        'created_at',
        'updated_at',
    ];
    public function options()
    {
        return $this->hasMany(FirstDateSurveyQuestionOptions::class, 'question_id');
    }
}
