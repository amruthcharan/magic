<?php

namespace App\Http\Controllers;

use App\Jobs\SetupUninstallWebhook;
use App\Models\Shop;
use App\Services\Shopify;
use Illuminate\Http\Request;

class ShopifyController extends Controller
{
    public $shopifyService;

    public function __construct(Shopify $shopifyService)
    {
        $this->shopifyService = $shopifyService;
    }

    public function home()
    {

        // verify the integrity of the request
        $this->shopifyService->verify(request());

        $shop = Shop::where('shopify_url', request()->get('shop'))->first();
        
        // if shop is not in database, redirect to install
        if (!$shop  || !$shop->access_token) {
            return redirect($this->shopifyService->getInstallUrl(request()->get('shop')));
        }

        // if shop is in database, redirect to dashboard
        authenticateShop($shop);
        return redirect()->route('shopify.dashboard');
    }

    public function generateToken()
    {
        $shop_url = request()->get('shop');

        // verify the integrity of the request
        $this->shopifyService->verify(request());

        $shop = Shop::where('shopify_url', $shop_url)->first();

        if (!$shop || !$shop->access_token) {
            // get the access token
            try {
                $token = $this->shopifyService->getAccessToken($shop_url, request()->get('code'));
            } catch (\Exception $e) {
                return $e->getMessage();
            }

            // create or update the shop
            $shop = Shop::updateOrCreate(
                    ['shopify_url' => $shop_url],
                    ['access_token' => $token]
                );
            $shop->settings()->updateOrCreate(['shop_id' => $shop->id]);

            // setup uninstall webhook
            dispatch(new SetupUninstallWebhook($shop));
        }

        authenticateShop($shop);
        return redirect()->route('shopify.dashboard');
    }

    public function dashboard()
    {
        $shop = shop();
        return view('shopify.dashboard', compact('shop'));
    }

    public function showInstall()
    {
        return view('shopify.install');
    }

    public function install(Request $request)
    {
        $shop_url = getCleanURL($request->input('store_url'));
        if (!checkdnsrr($shop_url)) {
            return redirect()->route('shopify.showInstall')->with('error', 'Invalid shopify url');
        }
        return redirect($this->shopifyService->getInstallUrl($shop_url));
    }

    public function logout()
    {
        unauthenticateShop();
        return redirect()->route('shopify.showInstall');
    }
}
