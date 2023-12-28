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
            'orderBy' => 'created_at',
            'order' => 'DESC',
            'status' => 1,
            //'type' => 0,
            'limit' => 5
        ];

        $headers = IpaymuSignature::generateSignature($payload, 'POST');

        $endpoint = IpaymuProperty::$ipaymuUrl . self::$url;

        $response = Http::withHeaders($headers)->post($endpoint , $payload);
        
        return $response->json();
    }
}