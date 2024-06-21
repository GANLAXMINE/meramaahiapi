<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Personality extends Model
{
    protected $table = 'personalities';
    protected $fillable = [
        'slug',
        'description_en',
        'description_hi',
        'description_es',
        'description_ja',
        'description_de',
        'description_fr',
        'description_it',
        'description_ru',
        'short_description_en',
        'short_description_hi',
        'short_description_es',
        'short_description_ja',
        'short_description_de',
        'short_description_fr',
        'short_description_it',
        'short_description_ru',
    ];
}
