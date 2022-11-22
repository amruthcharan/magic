<?php

namespace App\Listeners;

use App\Events\SetupWebhooks;
use App\Services\ShopifyClient;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SetupWebhooksListener implements ShouldQueue
{
    use InteractsWithQueue;

    public $event;

    public function __construct(SetupWebhooks $event)
    {
        $this->event = $event;
    }

    public function handle($event)
    {
        // new checkout webhook
        try {
            (new ShopifyClient($event->shop))->newWebhook(
                'checkouts/create',
                route('shopify.new-checkout', ['shopId' => $event->shop->id])
            );
        } catch (\Exception $e) {
            logger($e->getMessage());
        }
        

        // new user registration webhook
        try {
            (new ShopifyClient($event->shop))->newWebhook(
                'customers/create',
                route('shopify.new-customer', ['shopId' => $event->shop->id])
            );
        } catch (\Exception $e) {
            logger($e->getMessage());
        }

        // when active theme changed themes/publish
        try {
            (new ShopifyClient($event->shop))->newWebhook(
                'themes/publish',
                route('shopify.theme-changed', ['shopId' => $event->shop->id])
            );
        } catch (\Exception $e) {
            logger($e->getMessage());
        }
    }
}
