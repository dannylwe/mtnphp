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
use Dotenv;

$client = new Client([
    // Base URI is used with relative requests
    'base_uri' => getenv('BASEURI'),
    // You can set any number of default request options.
    'timeout'  => 20.0,
]);
$uuid = Uuid::uuid4();
$token = Key\getDisbursmentToken();

$dotenv = Dotenv\Dotenv::createMutable("../../");
$dotenv->load();

$subscriptionKey = getenv('OCPKEY');

try {
    $response = $client->request("POST","/disbursement/v1_0/transfer", [
        RequestOptions::HEADERS => [
            'Accept' => 'application/json',
            "Ocp-Apim-Subscription-Key" => $subscriptionKey,
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
    
    if($response->getStatusCode() == 202) {
        echo json_encode(
            array(
                "status" => "payment posted successfully", 
                "statusCode" => $response->getStatusCode(),
                "paymentId" => $uuid->toString()
            )
        );
    }  
} catch (ClientException $e) {
    echo json_encode(array("statusError" => "token has expired"));
}
