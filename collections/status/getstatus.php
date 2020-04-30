<?php

require_once '../../vendor/autoload.php';
require_once '../Key/token.php';
header('Content-Type: application/json');

use App\Key;

use GuzzleHttp\Client;
use GuzzleHttp\RequestOptions;
use GuzzleHttp\Exception\ClientException;
use Ramsey\Uuid\Uuid;
use Dotenv;

$client = new Client([
    // Base URI is used with relative requests
    'base_uri' => getenv('BASEURI'),
    // You can set any number of default request options.
    'timeout'  => 20.0,
]);
$uuid = Uuid::uuid4();
$token = Key\getCollectionToken();

$dotenv = Dotenv\Dotenv::createMutable("../../");
$dotenv->load();

$subscriptionKey = getenv('OCPKEYCOLLECTIONS');

try {
    $partyId = $_POST['partyId'];

    $response = $client->request("GET","/collection/v1_0/accountholder/MSISDN/$partyId/active", [
        RequestOptions::HEADERS => [
            'Accept' => 'application/json',
            "Ocp-Apim-Subscription-Key" => $subscriptionKey,
            'X-Target-Environment' => 'sandbox',
            'Authorization' => 'Bearer ' . $token
        ]
    ]);

    if($response->getStatusCode() == 200) {
        echo json_encode(
            array(
                "status" => "status retrieved successfully",
                "statusCode" => $response->getStatusCode(),

            )
        );
    }
} catch (ClientException $e) {
    echo json_encode(array("statusError" => "token expired"));
}
