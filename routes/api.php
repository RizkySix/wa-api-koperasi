<?php

use App\Http\Controllers\Koperasi\KoperasiController;
use App\Http\Controllers\User\UserController;
use App\Http\Controllers\WebhookController;
use App\Http\Requests\Authenticate\UserRegisterRequest;
use App\Mail\VerifyEmailUserMail;
use App\Models\Koperasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;
use OpenAPI\Client\Api\ChannelApi;
use OpenAPI\Client\Configuration;
use App\Models\User;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

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

Route::prefix('koperasi')->group(function() {
    Route::post('/webhook', [WebhookController::class , 'koperasiWebhook'])->middleware(['check.regis' , 'check.email' , 'registered.user.koperasi'])->name('webhook.koperasi');

    Route::get('/test' , function(){
        //User::where('email_verified_at' , null)->whereDay('created_at' , '<' , now()->addDays(1)->format('d'))->delete();
        echo  now()->addDays(1)->format('d');
    });


    
});


Route::prefix('auth')->group(function() {
    Route::get('/email/verify' , [UserController::class , 'verifyEmail'])->name('verify.nasabah.email');
});
