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
        $shop->settings->update($request->validated());
        return redirect()->back()->with('success', 'Settings updated successfully');
    }
  }
