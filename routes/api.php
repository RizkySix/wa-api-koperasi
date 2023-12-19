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
    Route::post('/webhook', [WebhookController::class , 'koperasiWebhook'])->name('webhook.koperasi');

    Route::post('/test' , function(UserRegisterRequest $request){
        $validatedData = $request->validated();

        $validatedData['password'] = Hash::make($validatedData['nik'] . rand(123,999));

        $user = User::create($validatedData);

        //buat token dan endpoint
        $token = Str::uuid();

        // cache here
        Cache::remember('verify-email' . $validatedData['email'] , now()->addHour(1) , function() {
            return null;
        });

        Cache::put('verify-email' . $validatedData['email'] , $token, now()->addHour(1));

        $data = [
            'url' => 'http://api-koperasi.test/api/v1/auth/email/verify?email=' . str_replace( '@' ,'%40' , $validatedData['email']) . '&token=' . $token,
            'name' => $validatedData['name']
        ];

        Mail::to($validatedData['email'])->send(new VerifyEmailUserMail($data));

        return $user;
    });


    
});


Route::prefix('auth')->group(function() {
    Route::get('/email/verify' , [UserController::class , 'verifyEmail'])->name('verify.nasabah.email');
});
