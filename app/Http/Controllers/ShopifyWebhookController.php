<?php

namespace App\Http\Controllers;

use App\Models\Shop;
use App\Services\MagicPixel;
use Illuminate\Http\Request;

class ShopifyWebhookController extends Controller
{
    public function newCustomer(Request $request, $shopId)
    {
        $shop = Shop::find($shopId);
        if (!$shop) {
            logger()->error('Shop not found', ['shopId' => $shopId]);
            return response()->json(['error' => 'Shop not found'], 200);
        }
        try {
            $data = (object)[
                'method'=> 'USER_NAME_PWD',
                'user.profile.em' => $request->input('email'),
                'user.profile.profileID' => $request->input('id'),
            ];
            
            (new MagicPixel($shop))->postWebhook('ss-user-registartion', $data);
        } catch (\Exception $e) {
            logger()->error($e->getMessage());
        }
        return response()->json(['success' => true]);
    }

    public function newCheckout(Request $request, $shopId)
    {
        $shop = Shop::find($shopId);
        if (!$shop) {
            logger()->error('Shop not found', ['shopId' => $shopId]);
            return response()->json(['error' => 'Shop not found'], 200);
        }
        $id_type = Shop::ID_TYPE_PRODUCT_ID;
        try {
            $data = (object)[
                "currency" => $request->input('currency'),
                "value" => floatVal($request->input('subtotal_price')),
                "coupon" => $request->input('discount_codes')[0]->code ?? "",
                "items" => []
            ];
            foreach ($request->input('line_items') as $index => $item) {
                $i = (object) [
                    "index" => $index,
                    "item_name" => $item['title'],
                    "item_id" => [$item['product_id'], $item['sku'], $item['variant_id']][$id_type],
                    "item_brand" => $item['vendor'],
                    "price" => floatval($item['price']),
                    "quantity" => $item['quantity'],
                ];
                array_push($data->items, $i);
            }
            (new MagicPixel($shop))->postWebhook('ss-initiate-check-out', $data);
        } catch (\Exception $e) {
            logger()->error($e->getMessage());
        }
        return response()->json(['success' => true]);
    }

    public function appUninstalled(Request $request, $shopId)
    {
        $shop = Shop::find($shopId);
        if (!$shop) {
            logger()->error('Shop not found', ['shopId' => $shopId]);
            return response()->json(['error' => 'Shop not found'], 200);
        }
        try {
            $shop->update(['access_token' => null]);
            $shop->settings()->update([
                'is_active' => false,
                'mp_sdk_script_id' => null,
                'active_theme_id' => null,
            ]);
        } catch (\Exception $e) {
            logger()->error($e->getMessage());
        }
        return response()->json(['success' => true]);
    }

    public function themeChanged(Request $request, $shopId)
    {
        $shop = Shop::find($shopId);
        if (!$shop) {
            return response()->json(['error' => 'Shop not found'], 200);
        }
        try {
            $oldTheme = $shop->settings->active_theme_id;
            $shop->settings()->update([
                'active_theme_id' => $request->input('id')
            ]);
            
            dispatch(new \App\Jobs\DeleteThemeFiles($shop, $oldTheme));
            dispatch(new \App\Jobs\UpdateThemeFiles($shop));

        } catch (\Exception $e) {
            logger()->error($e->getMessage());
        }
        return response()->json(['success' => true], 200);
    }
}
