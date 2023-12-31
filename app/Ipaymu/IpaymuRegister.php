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
        $payload = [
            'name' => $data['name'],
            'email' => $data['email'],
            'phone' => $data['phone'],
            'password' => $data['password']
        ];

        $headers = IpaymuSignature::generateSignature($payload, 'POST');

        $endpoint = IpaymuProperty::$ipaymuUrl . self::$url;

        $response = Http::withHeaders($headers)->post($endpoint , $payload);
        
        return $response->json();

    }
}