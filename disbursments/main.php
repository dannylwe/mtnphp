<?php

require '../vendor/autoload.php';

header('Content-Type: application/json');

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
$token = "eyJ0eXAiOiJKV1QiLCJhbGciOiJSMjU2In0.eyJjbGllbnRJZCI6ImYzMDE0OGQ2LTk5NmQtNGUyNy04MTI1LTNmN2JlYjBkYWViZSIsImV4cGlyZXMiOiIyMDIwLTA0LTIxVDE0OjA1OjIwLjE1NyIsInNlc3Npb25JZCI6ImFlOWRlZDBkLWU2MDQtNGM1Mi1hNmQ2LWM3MTIyNDk1NWZkOSJ9.QBAtbkEg3XTTdS3Ut8m7_CnP-6xpkojLBP8-p6206QBvwJjOCkuD-Bq3tH-_Pj_dRb25isw6Q9VYYcvrecIULraoiH1BW61MGN0mcvSnayFpElTOluZImpvGqtP-OC1R7-DRIUkeAlFFuNAdUAh_vowiSnaO8Hzpx6h8JXThhIxI90Jw0o2QHeXXFjb2hIvNE28cBt9vklAX2TZzNTPANsTO-LcWYI6OiNJLyHDuZP5qYOqBR0x0fxL_u0jsMfQN906czffxFdQZZevaz3qWEZL_uwccE5ao04g97puhThOdynqkLGVn42I-1hXR60PjQLj2uR_M9DFtBD9m0pCNtg";

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

echo "------------------------------\n";
echo $response->getStatusCode();
echo $response->getBody();
echo "------------------------------";
