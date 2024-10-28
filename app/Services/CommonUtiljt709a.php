<?php

namespace App\Services;

use DateTime;
use DateTimeZone;

class CommonUtiljt709a
{
   
    public static function trimEnd($inStr, $suffix)
    {
        while (substr($inStr, -strlen($suffix)) === $suffix) {
            $inStr = substr($inStr, 0, -strlen($suffix));
        }
        return $inStr;
    }

  
    public static function hexStr2Byte($hex)
    {
        $bytes = [];
        for ($i = 0; $i < strlen($hex); $i += 2) {
            $hexStr = substr($hex, $i, 2);
            $bytes[] = hexdec($hexStr);
        }
        return $bytes;
    }

  
    public static function parseBcdTime($bcdTimeStr)
    {
        $dateString = substr($bcdTimeStr, 0, 2) . '-' . substr($bcdTimeStr, 2, 2) . '-' . substr($bcdTimeStr, 4, 2) . ' ' . substr($bcdTimeStr, 6, 2) . ':' . substr($bcdTimeStr, 8, 2) . ':' . substr($bcdTimeStr, 10, 2);
        $dateTime = DateTime::createFromFormat('y-m-d H:i:s', $dateString, new DateTimeZone('UTC'));
        return $dateTime;
    }

  
    public static function xorChecksum($buf)
    {
        $checksum = 0;
        foreach ($buf as $byte) {
            $checksum ^= $byte;
        }
        return $checksum;
    }
}

?>
