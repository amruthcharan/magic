<?php

namespace App\Jobs;

use App\Models\Shop;
use App\Services\ShopifyClient;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SetupUninstallWebhook implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $shop;

    public function __construct(Shop $shop)
    {
        $this->shop = $shop;
    }

    
    public function handle()
    {
        // plugin uninstalled webhook
        try {
            (new ShopifyClient($this->shop))->newWebhook(
                'app/uninstalled',
                route('shopify.app-uninstalled', ['shopId' => $this->shop->id])
            );
        } catch (\Exception $e) {
            logger($e->getMessage());
        }
    }
}
