<?php

namespace App\Traits;

use App\Helper\AuthorizationWaApi;
use App\Mail\VerifyEmailUserMail;
use Exception;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use SebastianBergmann\Type\NullType;

trait AuthenticationTrait
{
    /**
     * Cache and send email payload
     */
    public function setVerifyEmailPayload(array $data)
    {
        //mail action below start
        $token = Str::uuid();

        // cache here
        Cache::remember('verify-email' . $data['email'] , now()->addHour(1) , function() {
            return null;
        });


        Cache::put('verify-email' . $data['email'] , [
            'token' => $token,
            'receiverPhone' => $data['phone'],
            'koperasi' => $data['koperasi_name'],
            'name' => $data['name'],
        ], now()->addHour(1));

        $emailPayload = [
            'url' => env('APP_URL') .'/api/v1/auth/email/verify?email=' . str_replace( '@' ,'%40' , $data['email']) . '&token=' . $token ,
            'name' => $data['name'],
            'koperasi' => $data['koperasi_name']
        ];

        Mail::to($data['email'])->send(new VerifyEmailUserMail($emailPayload));
    }


    /**
     * Cache and data for single sign on ipaymu
     */
    public function setPayloadIpaymu(array $data)
    {
        Cache::remember('single-sign-on-' . $data['email'] , 60*60*24 , function(){
            return null;
        });

        Cache::put('single-sign-on-' . $data['email'] , $data, 60*60*24);

    }


    /**
     * Send message success or failure register
     */
    public function sendRegisterMessage(mixed $data, string $appKey , string $receiverPhone)
    {
            
        if(is_array($data) && empty($data) || $data instanceof Exception){
            AuthorizationWaApi::seeBotSendMessage($appKey , $receiverPhone, 'Terjadi kesalahan saat registrasi');
            return false;
       }else{
            AuthorizationWaApi::seeBotSendMessage($appKey , $receiverPhone, 'Kamu berhasil registrasi');
            return true;
       }
    }
}