<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PersonalityQuestion extends Model
{
    protected $table = 'personality_questions';
    protected $fillable = [
        'option_1',
        'option_1_slug',
        'option_2',
        'option_2_slug',
        'group',
    ]; 
}
