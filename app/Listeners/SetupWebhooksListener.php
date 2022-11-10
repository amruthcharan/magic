<?php

namespace App\Listeners;

use App\Events\SetupWebhooks;
use App\Services\ShopifyClient;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SetupWebhooksListener
{
    public $event;

    public function __construct(SetupWebhooks $event)
    {
        $this->event = $event;
    }

    public function handle($event)
    {
        // plugin uninstalled webhook


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
    }
}
