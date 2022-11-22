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
        'active_theme_id',
        'id_type',
        'mp_sdk_script_id',
    ];

    public function shop()
    {
        return $this->belongsTo(Shop::class);
    }
}
