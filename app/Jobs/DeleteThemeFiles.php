<?php

namespace App\Jobs;

use App\Models\Shop;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class DeleteThemeFiles implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $shop;
    public $theme_id;

    public function __construct(Shop $shop, $theme_id)
    {
        $this->shop = $shop;
        $this->theme_id = $theme_id;
    }

    public function handle()
    {
        return $this->shop->deleteThemeFiles($this->theme_id);
    }
}
