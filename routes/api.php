<?php

use App\Http\Controllers\WebhookController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;
use OpenAPI\Client\Api\ChannelApi;
use OpenAPI\Client\Configuration;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});


Route::post('/webhook', [WebhookController::class , 'webhook'])->name('webhook');

Route::post('/send', function() {
//https://sandbox.1msg.io/FRO948034957/sendTemplate

$token = 'link_Gdy9VT6nlr4iTzFHLd9wc3ihuTS6lPIQ';
$channel = 'https://sandbox.1msg.io/FRO948034957/';

$config = Configuration::getDefaultConfiguration()->setApiKey('token', $token)->setHost($channel);

$apiInstance = new ChannelApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
        new GuzzleHttp\Client(),
        $config
    );
    
    try {
        $result = $apiInstance->getMe();
        Log::debug($result);
        return 'ok';
    } catch (Exception $e) {
        echo 'Exception when calling ChannelApi->getMe: ', $e->getMessage(), PHP_EOL;
    }
});


Route::post('/sent', function() {
    //https://sandbox.1msg.io/FRO948034957/sendTemplate
    
   try {
    $token = 'link_Gdy9VT6nlr4iTzFHLd9wc3ihuTS6lPIQ';
    $channel = 'https://sandbox.1msg.io/FRO948034957/';
    
    $data = [
        "token" => $token,
        'phone' => '6287762582176',
        "body" => "Please choose option",
        "action" => "List",
        "header" => 'Ini adalah pesan header',
        "footer" => 'Ya ini footer',
        "sections" => [
            [
                "title" => "Simpan Data",
                "rows" => [
                    [
                        "id" => "1",
                        "title" => "Registrasikan Member",
                        "description" => "Registrasikan member koperasi mu"
                    ]
                ]
            ],
            [
                "title" => "Dapatkan Data",
                "rows" => [
                    [
                        "id" => "2",
                        "title" => "Cek Saldo",
                        "description" => "Dapatkan jumlah saldo saat ini"
                    ],
                    [
                        "id" => "3",
                        "title" => "Cek Transaksi Terakhir",
                        "description" => "Dapatkan informasi traksaksi terakhir"
                    ]
                ]
            ]
        ]
    ];

    $result = Http::post($channel . 'sendList' , $data);
   
    return 'Ok';
   } catch (\Exception $e) {
        return $e;
        Log::debug($e->getMessage());
   }
    
   
    });
