<?php

namespace App\Listeners;

use App\Events\SetupScripts;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SetupScriptsListener implements ShouldQueue
{
    use InteractsWithQueue;
    
    public $event;

    public function __construct(SetupScripts $event)
    {
        $this->event = $event;
    }
    
    public function handle($event)
    {
        if ($event->shop->settings->sdk_url ?? false) {
            $event->shop->updateThemeFiles();
            $event->shop->updateScriptTags();
        }
    }
}
