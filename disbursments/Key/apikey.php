<?php

namespace App\Key;
require '../../vendor/autoload.php';

header('Content-Type: application/json');

use GuzzleHttp\Client;
use GuzzleHttp\RequestOptions;
use GuzzleHttp\Exception\ClientException;

function getApiKey() {
    $refId = "f30148d6-996d-4e27-8125-3f7beb0daebe";
    $subscriptionKey = "819f567702324c2d9b2f2a143a1fd591";
    $clientKey = new Client([
        // Base URI is used with relative requests
        'base_uri' => 'https://sandbox.momodeveloper.mtn.com/',
        // You can set any number of default request options.
        'timeout'  => 20.0,
    ]);
    try {
        $response = $clientKey->request("POST","v1_0/apiuser/$refId/apikey", [
            RequestOptions::HEADERS => [
                'Accept' => 'application/json',
                "Ocp-Apim-Subscription-Key" => $subscriptionKey,
                ],
        ]);
        $apiBody = json_decode($response->getBody());
        $key = $apiBody->apiKey;
        if($response->getStatusCode() == 201) {
            return $key;
        }
    } catch (ClientException $e) {
        echo json_encode(array("statusError" => "Connection Error to MTN"));
    }   
}

// echo getApiKey();
// 9a8e6147f229492e86b27b07e8d022ee