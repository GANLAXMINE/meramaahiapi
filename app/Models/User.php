<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Contracts\Auth\MustVerifyEmail;
// use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable, HasRoles;


    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    public static $_imagePublicPath = 'uploads/users';
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'password',
        'latitude',
        'longitude',
        'profile_image',
        'apple_id',
        'google_id',
        'social_type',
        'social_id',
        'status',
        'otp',
        'gender',
        'dob',
        'password_otp',
        'is_verify',
        'address',
        'profile_image',
        'is_deactivate',
    ];



    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'otp',
        'otp_time'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    public function userDeatil()
    {
        try {
            return $this->hasOne(UserDetail::class, 'user_id', 'id')->select('*');
        } catch (\Exception $ex) {
            return $ex->getMessage();
        }
    }
    public function Images()
    {
        try {
            return $this->hasMany(UserImage::class, 'user_id', 'id');
        } catch (\Exception $ex) {
            return $ex->getMessage();
        }
    }
}
