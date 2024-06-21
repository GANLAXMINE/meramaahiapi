<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reason extends Model
{
    protected $table = 'reason';
    protected $fillable = [
        'text',
        'text_hi',
        'text_ja',
        'text_es',
        'text_de',
        'text_fr',
        'text_it',
        'text_ru',
        'question',
        'question_hi',
        'question_ja',
        'question_es',
        'question_de',
        'question_fr',
        'question_it',
        'question_ru'
    ];
    public function reasonQuestion()
    {
        try {
            return $this->hasMany(ReasonQuestion::class, 'reason_id', 'id');
        } catch (\Exception $ex) {
            return $ex->getMessage();
        }
    }
}
