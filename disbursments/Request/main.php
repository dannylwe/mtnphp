<?php

namespace App\Request;

require '../../vendor/autoload.php';
require_once '../key/token.php';

header('Content-Type: application/json');

use App\Key;

use GuzzleHttp\Client;
use GuzzleHttp\RequestOptions;
use GuzzleHttp\Exception\ClientException;
use Ramsey\Uuid\Uuid;

$client = new Client([
    // Base URI is used with relative requests
    'base_uri' => 'https://sandbox.momodeveloper.mtn.com/',
    // You can set any number of default request options.
    'timeout'  => 20.0,
]);
$uuid = Uuid::uuid4();
$token = Key\getDisbursmentToken();

try {
    $response = $client->request("POST","/disbursement/v1_0/transfer", [
        RequestOptions::HEADERS => [
            'Accept' => 'application/json',
            "Ocp-Apim-Subscription-Key" => "819f567702324c2d9b2f2a143a1fd591",
            'X-Reference-Id' => $uuid->toString(),
            'X-Target-Environment' => 'sandbox',
            'Authorization' => 'Bearer ' . $token
            ],
        RequestOptions::JSON => [
            "amount" => "5000.0",
            "currency" => "EUR",
            "externalId" => "1241235246039",
            "payee" => array(
                "partyIdType" => "MSISDN",
                "partyId" => "2379524"
            ),
            "payerMessage" => "Make bulk payment",
            "payeeNote" => "yeah"
        ]
    ]);
    echo $response->getStatusCode();
    if($response->getStatusCode() == 202) {
        echo json_encode(array("message" => "posted successfully"));
    }  
} catch (ClientException $e) {
    echo json_encode(array("statusError" => "token has expired"));
}



