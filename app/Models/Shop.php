<?php

namespace App\Models;

use App\Services\ShopifyClient;
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

    protected $hidden = [
        'access_token'
    ];

    public function getAccessToken()
    {
        return $this->access_token;
    }

    public function settings()
    {
        return $this->hasOne(ShopConfig::class);
    }

    public function getName()
    {
        return ucwords(str_replace('-', ' ', str_replace('.myshopify.com', '', $this->shopify_url)));
    }

    public function activateShop()
    {
        // setup webhooks
        event(new \App\Events\SetupWebhooks($this));
        // setup scripts
        event(new \App\Events\SetupScripts($this));
        return;
    }

    public function deactivateShop()
    {
        // remove webhooks
        event(new \App\Events\RemoveWebhooks($this));
        // remove scripts
        event(new \App\Events\RemoveScripts($this));
        return;
    }

    public function updateSdkUrl()
    {
        $shopifyClient = new ShopifyClient($this);
        // Load magicpixel sdk
        if ($id = $this->settings->mp_sdk_script_id ?? false) {
            $shopifyClient->updateScriptTag($id, $this->settings->sdk_url);
        } else {
            try {
                $id = $shopifyClient->addScriptTag($this->settings->sdk_url);
                $this->settings()->update([
                    'mp_sdk_script_id' => $id
                ]);
            } catch (\Exception $e) {
                return logger($e->getMessage());
            }
        }
        return;
    }

    public function updateSettingsFile()
    {
        try {
            $shopifyClient = new ShopifyClient($this);
            // copy mp-header.liquid file to shopify theme
            $data = file_get_contents(base_path("resources/mp/liquid/mp-header-default.liquid"));
            $data = $this->getUpdatedFile($data);
            $shopifyClient->addFile($data, 'snippets/mp-header.liquid');
    
            // update idl.js file
            $newData = $this->getUpdatedFile(file_get_contents(public_path("storage/shopify/idl.js")));
            if (!file_exists(storage_path('app/public/shopify'. $this->shopify_url))) {
                mkdir(storage_path('app/public/shopify'. $this->shopify_url), 0755, true);
            }
            
            file_put_contents(storage_path('app/public/shopify'. $this->shopify_url .'/idl.js'), $newData);
        } catch (\Exception $e) {
            return logger($e->getMessage());
        }
        
        return;
    }

    public function updateThemeFiles()
    {
        try {
            $shopifyClient = new ShopifyClient($this);
    
            $this->updateSettingsFile();
    
            // copy mp-body.liquid file to shopify theme
            $shopifyClient->addFile(file_get_contents(base_path("resources/mp/liquid/mp-body-default.liquid")), 'snippets/mp-body.liquid');
    
            // update theme.liquid to include magicpixel.liquid and idl.liquid
            $theme_liquid = $shopifyClient->getFile('layout/theme.liquid');
            str_contains($theme_liquid, 'mp-header') ?: $theme_liquid = str_replace('</head>', '{% include \'mp-header\' %} </head>', $theme_liquid);
            str_contains($theme_liquid, 'mp-body') ?: $theme_liquid = str_replace('</body>', '{% include \'mp-body\' %} </body>', $theme_liquid);
            $shopifyClient->addFile($theme_liquid, 'layout/theme.liquid');
        } catch (\Exception $e) {
            return logger($e->getMessage());
        }
        return;
    }

    public function deleteThemeFiles($theme_id)
    {
        try {
            $shopifyClient = new ShopifyClient($this);
            
            $shopifyClient->deleteFile('snippets/mp-body.liquid', $theme_id);
            $shopifyClient->deleteFile('snippets/mp-header.liquid' , $theme_id);
    
            $theme_liquid = $shopifyClient->getFile('layout/theme.liquid', $theme_id);
            $theme_liquid = str_replace('{% include \'mp-header\' %}', '', $theme_liquid);
            $theme_liquid = str_replace('{% include \'mp-body\' %}', '', $theme_liquid);
            $shopifyClient->addFile($theme_liquid, 'layout/theme.liquid', $theme_id);
        } catch (\Exception $e) {
            return logger($e->getMessage());
        }
        return ;
        
    }

    public function updateScriptTags()
    {
        try {
            $shopifyClient = new ShopifyClient($this);

            // Load helpers.js file 
            $shopifyClient->addScriptTag(env('APP_URL') . '/storage/shopify/helpers.js', 'order_status');
    
            // Load idl.js file
            $shopifyClient->addScriptTag(env('APP_URL') . '/storage/shopify/'. $this->shopify_url .'/idl.js', 'order_status'); 
    
            // Load magicpixel sdk file
            $this->updateSdkUrl();
    
            // Load magicpixel.js file
            $shopifyClient->addScriptTag(env('APP_URL') . '/storage/shopify/magicpixel.js', 'order_status');
        } catch (\Exception $e) {
            return logger($e->getMessage());
        }
        return;
    }

    public function getUpdatedFile($data)
    {
        $idType = $this->settings->id_type ?? 0;
        $data = str_replace("window.MP_ID_TYPE = 0;", "window.MP_ID_TYPE = $idType;", $data);
        $idl_sdk = $this->settings->idl_sdk ?? false;
        $data = str_replace("const idl_sdk = '';", "const idl_sdk = '$idl_sdk';", $data);
        $is_idl_aync = $this->settings->is_idl_aync ? 1 : 0;
        $data = str_replace("var shouldBeAsync = false;", "var shouldBeAsync = $is_idl_aync;", $data);
        $is_idl_optimised = $this->settings->is_idl_optimised ? 1 : 0;
        $data = str_replace("var optimizeIDLCalls = true;", "var optimizeIDLCalls = $is_idl_optimised;", $data);
        $cookie_key = $this->settings->cookie_key ?? '_mplidl';
        $data = str_replace("var cookieKey = '_mplidl';", "var cookieKey = '$cookie_key';", $data);
        return $data;
    }
}
