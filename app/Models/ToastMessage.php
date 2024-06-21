<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ToastMessage extends Model
{
    protected $table = 'toast_messages';
    protected $fillable = [
        'message_type',
        'message_en',
        'message_hi',
        'message_ja',
        'message_es',
        'message_de', 
        'message_fr',  
        'message_it',     
        'message_ru	',
    ];
}
