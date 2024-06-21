<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\UserChat;

class UserMatch extends Model
{
    protected $table = 'user_match';
    protected $fillable = ['user_id','match_user','is_read'];

    public function user()
    {
        try {
            return $this->belongsTo(User::class, 'match_user', 'id');
        } catch (\Exception $ex) {
            return $ex->getMessage();
        }
    }
    public function like()
    {
        try {
            return $this->belongsTo(UserLike::class, 'match_user', 'like_user');
        } catch (\Exception $ex) {
            return $ex->getMessage();
        }
    }
    public function chat()
    {
        try {
            return $this->belongsTo(UserChat::class, 'match_user', 'sender_id');
        } catch (\Exception $ex) {
            return $ex->getMessage();
        }
    }
}
