<?php

require '../vendor/autoload.php';

header('Content-Type: application/json');

use GuzzleHttp\Client;
use GuzzleHttp\RequestOptions;
use GuzzleHttp\Exception\ClientException;

$client = new Client([
    // Base URI is used with relative requests
    'base_uri' => 'https://sandbox.momodeveloper.mtn.com/',
    // You can set any number of default request options.
    'timeout'  => 20.0,
]);
$token = "eyJ0eXAiOiJKV1QiLCJhbGciOiJSMjU2In0.eyJjbGllbnRJZCI6ImYzMDE0OGQ2LTk5NmQtNGUyNy04MTI1LTNmN2JlYjBkYWViZSIsImV4cGlyZXMiOiIyMDIwLTA0LTE5VDE1OjAyOjI3LjE3MyIsInNlc3Npb25JZCI6IjAyNDEwYzUxLWUxNGItNGQzZi05ZjMyLTY3MTIwYzgyOWVjYyJ9.TpqRKtfc1LZuRpJTwCPhfUfACxtAJH2Dumbx5BJnK9EazzEsunbRVHJ9fQwSniw4FM7aZuILdFXgZRpKmz3zs9tjh64gtltVxCcLYUoFiQi69gWrTx5R-1OYPsm6pGd9I-Ry9nVeFOFQbPw5_tEmwIlUxMCZLn0fc9nnJKA5g9JoNPqdrOura0EBYKjmBqGE5KoqUbWgbVYIUchoSR_AF4Z0SzcDQSHbbypf0Ybr8QawqOljasIr8cuF8rpzYis8GQzGI6LTNivtPmWANjCcQe0nce9ILML3SQUsABlfRgmM4ppZujkO8ChlMwLig5YJTdhz-gVqMsRduvEzz-7Wyg";
$options = [
    'json' => [
        "amount" => "5000.0",
        "currency" => "EUR",
        "externalId" => "1241235246039",
        "payee" => array(
            "partyIdType" => "MSISDN",
            "partyId" => "2379524"
        ),
        "payerMessage" => "Make bulk payment",
        "payeeNote" => "yeah",
    ]
]; 
echo "------------------------------";

$response = $client->post("/disbursement/v1_0/transfer", 
    ['headers' => [
        'Accept' => 'application/json',
        "Ocp-Apim-Subscription-Key" => "819f567702324c2d9b2f2a143a1fd591",
        'X-Reference-Id' => 'eaa87847-7d0c-4c38-99c7-112199d52e13',
        'X-Target-Environment' => 'sandbox',
        'Authorization' => 'Bearer ' . $token,
    ]
    ], $options,);

echo "------------------------------";
echo $response->getStatusCode();
echo $response->getBody();
echo $response->getHeader('application/json');
echo "------------------------------";
