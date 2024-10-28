<?php

namespace App\Utils;

class CommonUtil
{
    private function __construct()
    {
        // Prevent instantiation
    }


    public static function unescape(&$in, $bodyLen)
    {
        $frame = '';
        $i = 0;

        while ($i < $bodyLen) {
            $b = ord($in[$i]);

            if ($b == 0x3D) {
                $nextByte = ord($in[++$i]);

                if ($nextByte == 0x14) {
                    $frame .= chr(0x3D ^ 0x14);
                } elseif ($nextByte == 0x15) {
                    $frame .= chr(0x3D ^ 0x15);
                } elseif ($nextByte == 0x00) {
                    $frame .= chr(0x3D ^ 0x00);
                } elseif ($nextByte == 0x11) {
                    $frame .= chr(0x3D ^ 0x11);
                } else {
                    $frame .= chr($b);
                    $frame .= chr($nextByte);
                }
                $i++;
            } else {
                $frame .= chr($b);
            }
            $i++;
        }

        return $frame;
    }


    public static function trimEnd($inStr, $suffix)
    {
        while (substr($inStr, -strlen($suffix)) === $suffix) {
            $inStr = substr($inStr, 0, -strlen($suffix));
        }

        return $inStr;
    }


    public static function hexStr2Byte($hex)
    {
        $bf = [];
        for ($i = 0; $i < strlen($hex); $i += 2) {
            $hexStr = substr($hex, $i, 2);
            $bf[] = hexdec($hexStr);
        }

        return $bf;
    }
}
