<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReasonSubquestion extends Model
{
    protected $table = 'reason_subquestion';
    protected $fillable = [
        'reason_question_id',
        'reason_subquestion',
        'reason_subquestion_hi',
        'reason_subquestion_ja',
        'reason_subquestion_es',
        'reason_subquestion_de',
        'reason_subquestion_fr',
        'reason_subquestion_it',
        'reason_subquestion_ru'
    ];

    public function reasonReports()
    {
        return $this->hasMany(ReasonReport::class, 'reason_subquestion_id');
    }
}
