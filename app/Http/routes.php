<?php

use Omnipay\Omnipay;
use Omnipay\Common\CreditCard;
use Guzzle\Http\Client;
use Guzzle\Http\Exception\BadResponseException;
use Illuminate\Http\Response;
use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$app->get('/', function () use ($app) {
    // return $app->version();
    return view('dashboard');
});

/*
 *-------------------------------------
 * PIN Payments API
 *-------------------------------------
 */
$cGateway = Omnipay::create('Pin');
$cGateway->initialize(array(
    'secretKey' => env('PIN_PAYMENTS_SECRET'),
    'testMode'  => true
));
$oHttpClient = new Client(env('PIN_PAYMENTS_ENV') == 'test' ? env('PIN_PAYMENTS_TEST_ENDPOINT') : env('PIN_PAYMENTS_LIVE_ENDPOINT'));

// GET /charges
$app->get('charges', function () use ($oHttpClient) {
    $cRequest = $oHttpClient->get(
        env('PIN_PAYMENTS_API_VERSION') . '/charges',
        [
            'Authorization' => 'Basic ' . base64_encode(env('PIN_PAYMENTS_SECRET') . ':')
        ]
    );

    try {
        $oResponse = $cRequest->send();
        return (
            new Response($oResponse->json(), $oResponse->getStatusCode())
        );
    } catch (BadResponseException $e) {
        $cErrorArr = array(
            'url' => $e->getRequest()->getUrl(),
            'reason' => $e->getResponse()->getReasonPhrase()
        );
        return (
            new Response(json_encode($cErrorArr), $e->getResponse()->getStatusCode())
        );
    }
});

// POST /charges
$app->post('charges', function (Request $request) use ($cGateway) {
    $cCard = new CreditCard(array(
        'firstName'         => $request->card['firstname'],
        'lastName'          => $request->card['lastname'],
        'number'            => $request->card['number'],
        'expiryMonth'       => $request->card['expiry_month'],
        'expiryYear'        => $request->card['expiry_year'],
        'cvv'               => $request->card['cvc'],
        'email'             => $request->email,
        'billingAddress1'   => $request->card['address_line1'],
        'billingCountry'    => $request->card['address_country'],
        'billingCity'       => $request->card['address_city'],
        'billingPostcode'   => $request->card['address_postcode'],
        'billingState'      => $request->card['address_state']
    ));
    $oTransaction = $cGateway->purchase(array(
        'description'   => $request->description,
        'amount'        => $request->amount,
        'currency'      => $request->currency,
        'clientIp'      => $_SERVER['REMOTE_ADDR'],
        'card'          => $cCard
    ));
    $oResponse = $oTransaction->send();
    return json_encode($oResponse->getData());
});