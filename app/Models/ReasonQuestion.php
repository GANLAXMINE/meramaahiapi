<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReasonQuestion extends Model
{
    protected $table = 'reason_question';
    protected $fillable = [
        'reason_id',
        'answer',
        'answer_hi',
        'answer_ja',
        'answer_es',
        'answer_de',
        'answer_fr',
        'answer_it',
        'answer_ru',
    ];
    public function reasonSubQuestion()
    {
        try {
            return $this->hasMany(ReasonSubquestion::class, 'reason_question_id', 'id')->select(['id', 'reason_question_id', 'reason_subquestion']);
        } catch (\Exception $ex) {
            return $ex->getMessage();
        }
    }
    public function reasonReports()
    {
        return $this->hasMany(ReasonReport::class, 'reason_question_id');
    }
}
