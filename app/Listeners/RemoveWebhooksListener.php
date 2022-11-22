<?php

namespace App\Listeners;

use App\Events\RemoveWebhooks;
use App\Services\ShopifyClient;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class RemoveWebhooksListener  implements ShouldQueue
{
    use InteractsWithQueue;
    public $event;

    public function __construct(RemoveWebhooks $event)
    {
        $this->event = $event;
    }

    
    public function handle($event)
    {
        $shopifyClient = new ShopifyClient($event->shop);

        $webhooks = $shopifyClient->getWebhooks();

        foreach ($webhooks as $webhook) {
            if ($webhook->topic == 'app/uninstalled') {
                continue;
            }
            $shopifyClient->deleteWebhook($webhook->id);
        }
    }
}
