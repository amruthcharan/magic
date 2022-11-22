<?php

namespace App\Listeners;

use App\Events\RemoveScripts;
use App\Services\ShopifyClient;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class RemoveScriptsListener  implements ShouldQueue
{
    use InteractsWithQueue;
    public $event;

    public function __construct(RemoveScripts $event)
    {
        $this->event = $event;
    }

    public function handle($event)
    {
        $shopifyClient = new ShopifyClient($event->shop);

        $scriptTags = $shopifyClient->getScriptTags();

        foreach ($scriptTags as $scriptTag) {
            $shopifyClient->deleteScriptTag($scriptTag->id);
        }

        $event->shop->deleteThemeFiles($event->shop->settings->active_theme_id);
        
        $event->shop->settings()->update([
            'mp_sdk_script_id' => null,
            'active_theme_id' => null,
        ]);
    }
}
