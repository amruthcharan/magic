<?php

namespace App\Services;

use App\Models\Shop;
use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;


class MagicPixel
{
    private $url;

    public function __construct(Shop $shop)
    {
        $this->url = "https://mbuy-collector.stg-mp.magicpixel.io/web-hook/mbuy/g0hocbsphz/pcav9w9t54/s/";
    }

    public function postWebhook($event, $data) 
    {
        logger()->info('postWebhook', ['event' => $event, 'data' => $data]);
        try {
            $res = $this->post($this->url . $event, $data);
            logger()->info('postWebhook', ['response' => $res]);
            logger()->info('after response');
        } catch (Exception $e) {
            logger()->error("coming to logger");
            logger()->error($e->getMessage());
        }
    }

    private function get($url, $body)
    {
        try {
            return $this->parseResponse($this->request($url));
        } catch (Exception $e) {
            throw $e;
        }
    }

    private function post($url, $body)
    {
        try {
            return $this->parseResponse($this->request($url, 'post', $body));
        } catch (Exception $e) {
            throw $e;
        }
    }

    private function put($url, $body)
    {
        try {
            return $this->parseResponse($this->request($url, 'put', $body));
        } catch (Exception $e) {
            throw $e;
        }
    }


    private function request($url, $type = 'get', $body = [])
    {
        try {
            $client = new Client([
                'headers' => [
                    'Content-Type'  => 'application/json',
                ]
            ]);

            switch ($type) { 
                case 'get':
                    return $client->get($url);
                case 'post' :
                    return $client->post($url, ['body' => json_encode($body)]);
                case 'put':
                    return $client->put($url, ['body' => json_encode($body)]);
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
}