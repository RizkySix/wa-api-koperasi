<?php

namespace App\Ipaymu;

class IpaymuProperty
{
    /**
     * url ipaymu
     */
    public static string $ipaymuUrl = 'https://sandbox.ipaymu.com/api/v2'; 


    /**
     * Set url base on production or local
     */
    private static function setBaseUrl()
    {
        return self::$ipaymuUrl = env('APP_ENV') == 'production' ? 'https://my.ipaymu.com/api/v2' : 'https://sandbox.ipaymu.com/api/v2' ;
    }
}