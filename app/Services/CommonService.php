<?php

namespace App\Services;

class CommonService
{
    private static $ipAddress = null;

    public static function getClientIp()
    {
        if (self::$ipAddress) {
            return self::$ipAddress;
        }
        if (isset($_SERVER['HTTP_CLIENT_IP'])) {
            self::$ipAddress = $_SERVER['HTTP_CLIENT_IP'];
        }
        else if(isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            self::$ipAddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
        }
        else if(isset($_SERVER['HTTP_X_FORWARDED'])) {
            self::$ipAddress = $_SERVER['HTTP_X_FORWARDED'];
        }
        else if(isset($_SERVER['HTTP_FORWARDED_FOR'])) {
            self::$ipAddress = $_SERVER['HTTP_FORWARDED_FOR'];
        }
        else if(isset($_SERVER['HTTP_FORWARDED'])) {
            self::$ipAddress = $_SERVER['HTTP_FORWARDED'];
        }
        else if(isset($_SERVER['REMOTE_ADDR'])) {
            self::$ipAddress = $_SERVER['REMOTE_ADDR'];
        }
        else {
            self::$ipAddress = null;
        }

        return self::$ipAddress;
    }

    public static function getPercent($total, $percent)
    {
        return round(($percent / 100) * $total);
    }

    public static function percentCalculation($smallAmount, $bigAmount)
    {
        if(empty($smallAmount) || empty($bigAmount)){
            return 0;
        }

        if($bigAmount > $smallAmount){
            $diffPercent = ($smallAmount / $bigAmount) * 100;
        }
        else{
            $diffPercent = ($bigAmount / $smallAmount) * 100;
        }

        return number_format($diffPercent, 2);
    }

}
