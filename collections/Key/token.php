<?php

namespace App\Key;
require_once '../../vendor/autoload.php';
require_once '../Key/apikey.php';

header('Content-Type: application/json');

use App\Key;
use GuzzleHttp\Client;
use GuzzleHttp\RequestOptions;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\ServerException;
use Dotenv;

$dotenv = Dotenv\Dotenv::createMutable("../../");
$dotenv->load();

function getCollectionToken() {
    $refId = getenv('REFID');
    $subscriptionKey = getenv('OCPKEYCOLLECTIONS');
    $apiKey = Key\getApiKey();
    $clientKey = new Client([
        // Base URI is used with relative requests
        'base_uri' => getenv('BASEURI'),
        // You can set any number of default request options.
        'timeout'  => 20.0,
    ]);
    try {
        $response = $clientKey->request("POST","collection/token/", [
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
    } catch (ServerException $e) {
        $resp = $e->getResponse();
        $responseBodyAsString = $resp->getBody()->getContents();
        if(json_decode($responseBodyAsString)->error == "login_failed"){
            return "api key expired";
        }
    }
}
//echo getCollectionToken();
