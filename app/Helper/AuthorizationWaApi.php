<?php   

namespace App\Helper;

use Illuminate\Support\Facades\Http;

class AuthorizationWaApi
{
    public static function authorization()
    {
       return Http::withOptions([
            'query' => [
                'token' => env('TOKEN_WA')
            ],
        ]);
    }


    public static function seeBotSendMessage(string $appKey, string $receiverPhone, string $message)
    {
        $response =  Http::post(env('SEEBOT_URL') , [
            'appkey' => $appKey,
            'authkey' => env('SEEBOT_API_KEY'),
            'to' => $receiverPhone,
            'message' => $message,
            'sandbox' => 'false'
        ]);

        return $response;
    }
}