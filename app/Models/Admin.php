<?php

namespace App\Models;

// use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Auth;

class Admin extends Authenticatable
{
    // use HasFactory;

    protected $guard = "admin";

    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    public static function getAuthenticatedAdminId()
    {
        $admin = Auth::guard('admin')->user();
        // dd($admin);

        if ($admin) {
            return $admin->id;
        } else {
            return null;
        }
    }
}
