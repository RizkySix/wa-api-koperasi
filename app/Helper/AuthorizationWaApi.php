<?php   

namespace App\Helper;

use Exception;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

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
        try {
            $response =  Http::post(env('SEEBOT_URL') , [
                'appkey' => $appKey,
                'authkey' => env('SEEBOT_API_KEY'),
                'to' => $receiverPhone,
                'message' => $message,
                'sandbox' => 'false'
            ]);
          
            return $response;
        } catch (Exception $e) {
            Log::debug($e->getMessage());
        }
    }
}