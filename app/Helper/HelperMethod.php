<?php

namespace App\Helper;

class HelperMethod
{
    /**
     * Untuk explode karakter @ pada phone number yang diberikan dari response SEEBOT_WA API
     */
    public static function phoneUserFormat(string $rawPhone)
    {
        return explode('@' , $rawPhone)[0];
    }


    public static function makeAllStringLowerCase(string $string)
    {
        return strtolower($string);
    }
}