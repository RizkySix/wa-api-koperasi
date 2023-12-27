<?php

namespace App\Ipaymu;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class IpaymuRegister
{
    public static string $url = '/register';

    /**
     * Single sign on payload
     */
    public static function singleSignOn(array $data)
    {
        $headers = IpaymuSignature::generateSignature($data, 'POST');

        $endpoint = IpaymuProperty::$ipaymuUrl . self::$url;

        $response = Http::withHeaders($headers)->post($endpoint , $data);
        
        return $response->json();

    }
}