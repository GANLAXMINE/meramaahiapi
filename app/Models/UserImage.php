<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserImage extends Model
{
    protected $table = 'user_images';
    protected $fillable = ['user_id','user_detail_id','image','thumb_image'];
}
