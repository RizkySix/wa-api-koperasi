<?php

namespace App\Ipaymu;

use Illuminate\Support\Facades\Http;

class IpaymuTransactions
{
    public static string $url = '/history';

    /**
     * Ipaymu get transaction list
     */
    public static function checkHistoryTransaction(array $data)
    {
        $payload = [
            'account' => $data['ipaymu_va'],
            'orderBy' => 'id',
            'order' => 'DESC',
            'limit' => 5
        ];

        $headers = IpaymuSignature::generateSignature($payload, 'POST');

        $endpoint = IpaymuProperty::$ipaymuUrl . self::$url;

        $response = Http::withHeaders($headers)->post($endpoint , $payload);
        
        return $response->json();
    }
}