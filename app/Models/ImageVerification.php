<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ImageVerification extends Model
{
    // public static $_imagePublicPath = 'uploads/images';
    protected $table = 'image_verification';
    protected $fillable = [
        'user_id',
        'image',
        'status',
        ];

    // public function getImageAttribute($value)
    // {
    //     try {
    //         if ($value === null || $value == '')
    //             return $value;
    //         return config('app.APP_BASE_URL').  self::$_imagePublicPath . '/' . $value;
    //     } catch (\Exception $ex) {
    //         return $value;
    //     }
    // }
}
