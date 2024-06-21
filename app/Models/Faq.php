<?php

namespace App\Models;

// use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Faq extends Model
{
    // use HasFactory;
    protected $table = 'faq';
    protected $fillable = [
        'question',
        'answer',
        'question_hi',
        'question_ja',
        'question_es',
        'question_fr',
        'question_it',
        'question_ru',
        'question_de',
        'answer_hi',
        'answer_ja',
        'answer_es',
        'answer_de',
        'answer_fr',
        'answer_it',
        'answer_ru',
    ];
}
