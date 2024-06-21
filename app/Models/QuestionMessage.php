<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QuestionMessage extends Model
{
    protected $table = 'question_messages';
    protected $fillable = ['receiver_id', 'sender_id', 'message_type', 'content', 'conversation_id'];

}
