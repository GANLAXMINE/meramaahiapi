<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{

    protected $table = 'coupons';
    protected $fillable = [
        'name',
        'description',
        'code',
        'type',
        'discount_amount',
        'min_amount',
        'start_date',
        'end_date',
        'usage_limit',
        'usage_count',
        'status',
    ];
}
