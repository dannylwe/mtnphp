<?php

namespace App\Request;

require '../../vendor/autoload.php';

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
$token = "eyJ0eXAiOiJKV1QiLCJhbGciOiJSMjU2In0.eyJjbGllbnRJZCI6ImYzMDE0OGQ2LTk5NmQtNGUyNy04MTI1LTNmN2JlYjBkYWViZSIsImV4cGlyZXMiOiIyMDIwLTA0LTIxVDE1OjA3OjMxLjQwNCIsInNlc3Npb25JZCI6Ijc3ZGM4ZDZjLWFiZmYtNDI3MC1iNDU5LTQ0NzllMmExMTk5OCJ9.jzQPf2kYloAsNDLsxEikq5aTiEb1rgQ3QOx3V5Ztb17YHLUJr6ULhF863Weuz0Ab3A7_fmw6-HbOXO9Be2Z7PJQEcvZ1QZS48-398lPM6CeZVFhuS_KPEoCNoIT2O5X8b6KfTlINeQ1EHXiX7JcVlGjMja7Rd15MAi_dvDtiCxPAOzN4pTDALyw08WN45gF_ry_p-h3kI764bI42qKLfmVtDujOjTeItlmrEJ_AuyFQYBoE2-RDGNCon8ZBhKs_I0SbYFIHmYW6FCiD7hskc8Z0HqyspKbILoFiHXmGsHxOiEWB5x8KWumKa4ICEQK7hlHIzin_1QVvpnV4WZgcJVQ";

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
