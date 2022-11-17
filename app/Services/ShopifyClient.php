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

    
    public function __construct(Shop $shop)
    {
        $this->store_url = $shop->shopify_url;
        $this->api_password = $shop->getAccessToken();
        $this->api_version = env('SHOPIFY_API_VERSION', "2022-10");
        $this->url = "https://{$this->store_url}/admin/api/{$this->api_version}/";
        $this->secret = "";
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