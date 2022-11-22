<?php

namespace App\Services;

use App\Models\Shop;
use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Support\Facades\Http;

class ShopifyClient
{
    protected $secret;
    protected $api_password;
    protected $api_version;
    protected $store_url;
    protected $url;
    protected $shop;

    
    public function __construct(Shop $shop)
    {
        $this->store_url = $shop->shopify_url;
        $this->api_password = $shop->getAccessToken();
        $this->api_version = env('SHOPIFY_API_VERSION', "2022-10");
        $this->url = "https://{$this->store_url}/admin/api/{$this->api_version}/";
        $this->secret = "";
        $this->shop = $shop;
    }

    /**
     * Verifiying the integrity of data recived on the route 
     * 
     * This method will abort the request if the integrity check fails
     */
    public function verify(): void
    {
        // data received on the request
        $data = request()->getContent();

        $is_authenticated = hash_equals(
            // hmac header
            request()->server('HTTP_X_SHOPIFY_HMAC_SHA256'),
            // calculated hmac
            base64_encode(hash_hmac('sha256', $data, $this->secret, true))
        );

        //abort if hash_check fails
        if (!$is_authenticated) {
            abort(404, 'You cannot access this');
        }
        return ;
    }

    public function getWebhooks()
    {
        try {
            return $this->parseResponse(
                $this->request($this->url . "webhooks.json")
            )->webhooks ?? null;
        } catch (RequestException $exception) {
            throw $exception;
        }
    }
        

    public function newWebhook($topic, $address, $format = 'json')
    {
        $webhookData = [
            'webhook' => [
                'topic' => $topic,
                'address' => $address,
                'format' => $format
            ]
        ];

        try {
            return $this->parseResponse(
                $this->request($this->url . "webhooks.json", 'post', json_encode($webhookData))
            );
        } catch (RequestException $exception) {
            throw $exception;
        }
    }

    public function deleteWebhook($id)
    {
        try {
            return $this->parseResponse(
                $this->request($this->url . "webhooks/{$id}.json", 'delete')
            );
        } catch (RequestException $exception) {
            throw $exception;
        }
    }

    public function addFile($file, $path, $theme_id = null)
    {
        $theme_id = $theme_id ?? $this->getThemeId();
        $fileData = (object)[
            'asset' => [
                'key' => $path,
                'value' => $file,
                'theme_id' => $theme_id
            ]
        ];

        try {
            return $this->parseResponse(
                $this->request($this->url . "themes/{$theme_id}/assets.json", 'put', json_encode($fileData))
            );
        } catch (RequestException $exception) {
            throw $exception;
        }
    }

    public function deleteFile($path, $theme_id = null)
    {
        $theme_id = $theme_id ?? $this->getThemeId();
        try {
            return $this->parseResponse(
                $this->request($this->url . "themes/{$theme_id}/assets.json?asset[key]={$path}", 'delete')
            );
        } catch (RequestException $exception) {
            throw $exception;
        }
    }

    public function getFile($path, $theme_id = null)
    {
        $theme_id = $theme_id ?? $this->getThemeId();
        try {
            return $this->parseResponse(
                $this->request($this->url . "themes/{$theme_id}/assets.json?asset[key]={$path}")
            )->asset->value;
        } catch (RequestException $exception) {
            throw $exception;
        }
    }

    public function getScriptTags()
    {
        try {
            return $this->parseResponse(
                $this->request($this->url . "script_tags.json")
            )->script_tags ?? null;
        } catch (RequestException $exception) {
            throw $exception;
        }
    }

    public function addScriptTag($path, $scope = 'all')
    {
        try {
            $scriptTagData = (object)[
                'script_tag' => [
                    'event' => 'onload',
                    'display_scope' => $scope,
                    'src' => $path
                ]
            ];
            return $this->parseResponse(
                $this->request($this->url . "script_tags.json", 'post', json_encode($scriptTagData))
            )->script_tag->id ?? null;
        } catch (RequestException $exception) {
            throw $exception;
        }
    }

    public function updateScriptTag($id, $path, $scope = 'all')
    {
        try {
            $scriptTagData = (object)[
                'script_tag' => [
                    'event' => 'onload',
                    'display_scope' => $scope,
                    'src' => $path
                ]
            ];
            return $this->parseResponse(
                $this->request($this->url . "script_tags/{$id}.json", 'put', json_encode($scriptTagData))
            );
        } catch (RequestException $exception) {
            throw $exception;
        }
    }

    public function deleteScriptTag($id)
    {
        try {
            return $this->parseResponse(
                $this->request($this->url . "script_tags/{$id}.json", 'delete')
            );
        } catch (RequestException $exception) {
            throw $exception;
        }
    }

    public function getThemeId()
    {
        if ( $this->shop->settings->active_theme_id) {
            return $this->shop->settings->active_theme_id;
        }
       
        $themes = $this->parseResponse(
            $this->request($this->url . "themes.json")
        );

        foreach ($themes->themes as $theme) {
            if ($theme->role == 'main') {
                $this->shop->settings()->update(['active_theme_id' => $theme->id]);
                return $theme->id;
            }
        }
    }

    public function request($url, $type = 'get', $body = [])
    {
        try {
            $client = new Client([
                'headers' => [
                    'Content-Type'  => 'application/json',
                    'X-Shopify-Access-Token' => $this->api_password
                ]
            ]);

            switch ($type) { 
                case 'get':
                    return $client->get($url);
                case 'post' :
                    return $client->post($url, ['body' => $body]);
                case 'put':
                    return $client->put($url, ['body' => $body]);
                case 'delete':
                    return $client->delete($url);
                default:
                    return $client->get($url);
            }
        } catch (RequestException $exception) {
            throw $exception;
        }
    }

    private function parseResponse($response)
    {
        try{
            $response_json = json_decode( trim($response->getBody()->getContents()) );

            if ($response_json){
                return $response_json;
            }
            abort(400, 'something went wrong!');

        } catch (Exception $exception) {
            throw $exception;
        }
    }

    private function parseResponseWithHeaders($response)
    {
        try{
            $response_json = json_decode( trim($response->getBody()->getContents()) );
            $headers = $response->getHeaders();

            if ($response_json){
                return (object)[
                    "response" => $response_json,
                    "headers" => $headers
                ];
            }
            abort(400, 'something went wrong!');

        } catch (Exception $exception) {
            throw $exception;
        }
    }
}