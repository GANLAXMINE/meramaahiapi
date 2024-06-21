<?php

namespace App\Models;

// use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Carbon;
class Notification extends Model
{
    // use HasFactory;
   
    protected $table = 'notifications';
    protected $fillable = ['title', 'body', 'message', 'target_id', 'is_read', 'created_by','created_at'];
    // public static $_imagePublicPath = '/uploads/restaurant';

      

    public function createdByDetail()
    {
        return $this->hasOne(User::class, 'id', 'created_by')->select('id', 'name', 'image');
    }
    public function targetByDetail()
    {
        return $this->hasOne(User::class, 'id', 'target_id')->select('id', 'name', 'image');
    }

 

    // function getMessageAttribute($value)
    // {
    //     $data = json_decode($value);
    //     $restaurant_data = DB::table('restaurants')->where('id',$data->restaurant_id)->first();
    //     // dd($restaurant_image);
    //     if($restaurant_data){
    //     $data->restaurant_image = config('app.APP_BASE_URL').  self::$_imagePublicPath . '/' .$restaurant_data->restaurant_image;
    //     }
    //     else{
    //         $data->image= null;
    //     }

    //     if($restaurant_data){
    //         $data->restaurant_address = $restaurant_data->address;
    //         }
    //         else{
    //             $data->restaurant_address= null;
    //         }

    //     if($restaurant_data){
    //         $data->restaurant_name = $restaurant_data->name;
    //         }
    //         else{
    //             $data->image= null;
    //         }
    //     return $data;
    // }


    public function getCreatedAtAttribute($date)    
    {
         return Carbon::parse($date)->setTimezone('UTC');
    }
}
