<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class BlockUser extends Model
{
    protected $table = 'block_user';
    protected $fillable = [
        'blocked_by',
        'blocked_user',
     ];
    public function user()
    {
        try {
            return $this->belongsTo(User::class, 'blocked_user', 'id');
        } catch (\Exception $ex) {
            return $ex->getMessage();
        }
    }
}