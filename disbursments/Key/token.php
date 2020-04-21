<?php

namespace App\Key;
require '../../vendor/autoload.php';
require_once '../key/apikey.php';

header('Content-Type: application/json');

use App\Key;
use GuzzleHttp\Client;
use GuzzleHttp\RequestOptions;
use GuzzleHttp\Exception\ClientException;

function getDisbursmentToken() {
    $refId = "f30148d6-996d-4e27-8125-3f7beb0daebe";
    $subscriptionKey = "819f567702324c2d9b2f2a143a1fd591";
    $apiKey = Key\getApiKey();
    $clientKey = new Client([
        // Base URI is used with relative requests
        'base_uri' => 'https://sandbox.momodeveloper.mtn.com/',
        // You can set any number of default request options.
        'timeout'  => 20.0,
    ]);
    $response = $clientKey->request("POST","disbursement/token/", [
        RequestOptions::HEADERS => [
            'Accept' => 'application/json',
            "Ocp-Apim-Subscription-Key" => $subscriptionKey,
            'X-Reference-Id' => $refId,            
        ],
        RequestOptions::AUTH => [
            $refId, $apiKey
        ]
    ]);
    if($response->getStatusCode() == 200){
        $tokenBody = json_decode($response->getBody());
        $token = $tokenBody->access_token;
        return $token;
    }
}

echo getDisbursmentToken();