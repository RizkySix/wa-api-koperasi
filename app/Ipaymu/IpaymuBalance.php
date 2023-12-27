<?php

namespace App\Ipaymu;

use Illuminate\Support\Facades\Http;

class IpaymuBalance
{
    public static string $url = '/balance';

    /**
     * check saldo/balance ipaymu
     */
    public static function checkBalance(array $data)
    {
        $payload = [
            'account' => $data['ipaymu_va']
        ];

        $headers = IpaymuSignature::generateSignature($payload, 'POST');

        $endpoint = IpaymuProperty::$ipaymuUrl . self::$url;

        $response = Http::withHeaders($headers)->post($endpoint , $payload);
        
        return $response->json();
    }
}