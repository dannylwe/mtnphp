<?php

namespace App\Key;
require '../../vendor/autoload.php';

header('Content-Type: application/json');

use GuzzleHttp\Client;
use GuzzleHttp\RequestOptions;
use GuzzleHttp\Exception\ClientException;
use Dotenv;

$dotenv = Dotenv\Dotenv::createMutable("../../");
$dotenv->load();

function getApiKey() {
    $refId = getenv('REFID');
    $subscriptionKey = getenv('OCPKEY');
    $clientKey = new Client([
        // Base URI is used with relative requests
        'base_uri' => getenv('BASEURI'),
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
