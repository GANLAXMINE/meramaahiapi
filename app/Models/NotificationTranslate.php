<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NotificationTranslate extends Model
{
    protected $table = 'notification_translates';
    protected $fillable = [
        'notification_type',
        'title_en',
        'title_hi',
        'title_ja',
        'title_es',
        'title_de', 
        'title_fr',  
        'title_it',     
        'title_ru',
        'body_en',
        'body_hi',
        'body_ja',
        'body_es',
        'body_de',
        'body_fr',
        'body_it',
        'body_ru'

    ];
}
