<?php

namespace App\Http\Controllers;

use App\Http\Requests\SettingsRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ShopConfigController extends Controller
{
    public function showSettings()
    {
        $shop = shop();
        $shop->load('settings');
        return view('shopify.settings', compact('shop'));
    }

    public function updateSettings(SettingsRequest $request)
    {
        $shop = shop();
        $settings = $shop->settings ?? null;
        if ($settings) {
            $settings->update($request->validated());
        } else {
            $shop->settings()->create($request->validated());
        }
        do {
            if ($settings->wasChanged()) {
                if ($settings->wasChanged('is_active')) {
                    if ($settings->is_active) {
                        $shop->activateShop();
                    } else {
                        $shop->deactivateShop();
                    }
                    break;
                }

                if ($settings->wasChanged('sdk_url')) {
                    $shop->updateSdkUrl();
                }

                if ($settings->wasChanged(['id_type', 'is_identity_enabled', 'is_idl_aync', 'is_idl_optimised', 'identity_url', 'cookie_key'])) {
                    $shop->updateSettingsFile();
                }
            }
        } while (0);
        return redirect()->back()->with('success', 'Settings updated successfully');
    }
  }
