<?php

namespace App\Ipaymu;

class IpaymuSignature
{
    /**
     * Generate Signature ipaymu
     */
    public static function generateSignature(array $bodyParam, string $httpMethod)
    {
        $jsonBody     = json_encode($bodyParam , JSON_UNESCAPED_SLASHES);
        $requestBody  = strtolower(hash('sha256', $jsonBody));
        
        $stringToSign = strtoupper($httpMethod) . ':' . env('IPAYMU_VA') . ':' . $requestBody . ':' . env('IPAYMU_APIKEY');
        $signature    = hash_hmac('sha256', $stringToSign, env('IPAYMU_APIKEY'));
        $timestamp    = now()->format('YmdHis');

        $headers = [
            'Content-Type' => 'application/json',
            'signature' => $signature,
            'va' => env('IPAYMU_VA'),
            'timestamp' => $timestamp
        ];

        return $headers;
    }
}