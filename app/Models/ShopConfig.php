<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShopConfig extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'shop_id',
        'is_active',
        'sdk_url',
        'is_identity_enabled',
        'is_idl_aync',
        'is_idl_optimised',
        'identity_url',
        'cookie_key',
        'cache_time',
        'default_currency_code',
        'default_country_code',
        'id_type',

    ];

    public function shop()
    {
        return $this->belongsTo(Shop::class);
    }
}
