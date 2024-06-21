<?php

namespace App\Models;

// use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Configuration extends Model
{
    // use HasFactory;
    protected $table = 'configurations';
    protected $fillable = [
        'terms_of_use',
        'privacy_policy',
        'about_us',
        'terms_of_use_hi',
        'terms_of_use_ja',
        'terms_of_use_es',
        'terms_of_use_de',
        'terms_of_use_fr',
        'terms_of_use_it',
        'terms_of_use_ru',
        'privacy_policy_hi',
        'privacy_policy_ja',
        'privacy_policy_es',
        'privacy_policy_de',
        'privacy_policy_fr',
        'privacy_policy_it',
        'privacy_policy_ru',
        'about_us_hi',
        'about_us_ja',
        'about_us_es',
        'about_us_de',
        'about_us_fr',
        'about_us_it',
        'about_us_ru'
    ];
}
