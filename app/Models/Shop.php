<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shop extends Model
{
    use HasFactory;

    const ID_TYPE_PRODUCT_ID = 0;
    const ID_TYPE_SKU = 1;
    const ID_TYPE_VARIANT_ID = 2;

    protected $fillable = [
        'shopify_url',
        'access_token'
    ];

    public function getName()
    {
        return ucwords(str_replace('-', ' ', str_replace('.myshopify.com', '', $this->shopify_url)));
    }
}
