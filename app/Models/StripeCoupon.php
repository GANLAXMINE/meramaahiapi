<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StripeCoupon extends Model
{
    protected $table = 'stripe_coupons';
    protected $fillable = [
        'user_id',
        'coupon_code',
        'coupon_price',
        'unit_amount_after_coupon'
    ];
}
