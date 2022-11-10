<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class ShopAuth
{
    public function handle(Request $request, Closure $next)
    {
        $route = $request->route()->getName();

        $routes = [
            'shopify.home',
            'shopify.generate-token',
        ];
        
            
        if (in_array($route, $routes)) {
            if (isAuthenticated()) {
                if ($request->has('shop')) {
                    if (isShopAuthenticated($request->get('shop'))) {
                        return redirect()->route('shopify.dashboard');
                    } else {
                        unauthenticateShop();
                    }
                } else {
                    return redirect()->route('shopify.dashboard');
                }
                
            } else {
                $pattern = "/[a-zA-Z0-9][a-zA-Z0-9\-]*\.myshopify\.com[\/]?/";
                if (!$request->has('shop') || !preg_match($pattern, $request->get('shop'))) {
                    return redirect()->route('shopify.showInstall');
                }
            }
        } else {
            if (!isAuthenticated()) {
                return redirect()->route('shopify.showInstall');
            }
        }

        return $next($request);
    }
}
