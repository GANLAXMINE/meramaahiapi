<?php

namespace App\Models;

// use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserBookmark extends Model
{
    // use HasFactory;
    protected $table = 'user_bookmark';
    protected $fillable = [
        'bookmark_by',
        'bookmark_user',
        ];
    public function user()
    {
        try {
            return $this->belongsTo(User::class, 'bookmark_user', 'id');
        } catch (\Exception $ex) {
            return $ex->getMessage();
        }
    }
    public function whoBookmarked()
    {
        try {
            return $this->belongsTo(User::class, 'bookmark_by', 'id');
        } catch (\Exception $ex) {
            return $ex->getMessage();
        }
    }
    
}
