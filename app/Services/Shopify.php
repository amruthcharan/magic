<?php

namespace App\Services;

use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

class Shopify
{
    protected $secret;
    protected $api_key;

    public function __construct()
    {
        $this->secret = env('SHOPIFY_CLIENT_SECRET');
        $this->api_key = env('SHOPIFY_CLIENT_ID');
    }

    public function verify($request)
    {
        if (!$request->get('hmac')) {
            abort(403, 'Unauthorized action');
        }
        $hmac = $request->get('hmac');
        $params = $request->except('hmac');
        ksort($params);
        $computed_hmac = hash_hmac('sha256', http_build_query($params), $this->secret);
        if (!hash_equals($hmac, $computed_hmac)) {
            abort(403, 'Unauthorized action');
        }
    }

    public function getInstallUrl($shop)
    {
        $scopes = "write_script_tags,read_customers,read_checkouts,read_orders,read_themes,write_themes";
        $redirect = route('shopify.generate-token');
        return "https://{$shop}/admin/oauth/authorize?client_id={$this->api_key}&scope={$scopes}&redirect_uri={$redirect}";
    }

    public function getAccessToken($shop, $code)
    {
        $url = "https://{$shop}/admin/oauth/access_token";
        $client = new Client();
        try {
            $response = $client->request('POST', $url, [
                'form_params' => [
                    'client_id' => $this->api_key,
                    'client_secret' => $this->secret,
                    'code' => $code
                ]
            ]);
        } catch (RequestException $e) {
            return $e->getMessage();
        }
        return json_decode($response->getBody(), true)['access_token'] ?? null;
    }
}