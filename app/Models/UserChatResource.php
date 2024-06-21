<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserChatResource extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'user_chat_rersources';
    protected $charset = 'utf8mb4';
    protected $collation = 'utf8mb4_unicode_ci';

    protected $primaryKey = 'id';
    protected $fillable = ['id','user_id','resource_id'];
}
