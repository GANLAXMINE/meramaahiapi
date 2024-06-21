<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SubscriptionHistory extends Model
{
    protected $table = 'subscription_history';

    protected $primaryKey = 'id';
    protected $fillable = ['id','email','json_responce'];
}
