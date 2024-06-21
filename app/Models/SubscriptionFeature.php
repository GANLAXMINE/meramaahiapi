<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SubscriptionFeature extends Model
{
    protected $table = 'subscription_features';
    protected $fillable = [
        'product_id',
        'product_name',
        'product_description',
        'product_name_hi',
        'product_name_ja', // Japanese suffix
        'product_name_es', // Spanish suffix
        'product_name_de', // German suffix
        'product_name_fr', // French suffix
        'product_name_it', // Italian suffix
        'product_name_ru', // Russian suffix
        'product_description_hi',
        'product_description_ja', // Japanese suffix
        'product_description_es', // Spanish suffix
        'product_description_de', // German suffix
        'product_description_fr', // French suffix
        'product_description_it', // Italian suffix
        'product_description_ru', // Russian suffix
    ];
}
