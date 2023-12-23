<?php

namespace App\Helper;

class HelperMethod
{
    public static function phoneUserFormat(string $rawPhone)
    {
        return explode('@' , $rawPhone)[0];
    }


    public static function makeAllStringLowerCase(string $string)
    {
        return strtolower($string);
    }
}