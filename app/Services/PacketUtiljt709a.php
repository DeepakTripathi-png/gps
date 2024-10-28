<?php

namespace App\Services;
use App\Helpers\Constantjt709a;
class PacketUtiljt709a
{
    
    public static function decodePacket(string $in): ?string {
        
        $inLength = strlen($in);

        if ($inLength < Constantjt709a::BINARY_MSG_BASE_LENGTH) {
            return null;
        }

        if ($inLength > Constantjt709a::BINARY_MSG_MAX_LENGTH) {
            return null;
        }
        
        $headerIndex = strpos($in, chr(Constantjt709a::BINARY_MSG_HEADER));
        if ($headerIndex === false) {
            return null;
        }

        $bodyLen = $headerIndex;
        $frame = chr(Constantjt709a::BINARY_MSG_HEADER);
        $frame .= self::unescape(substr($in, 1, $bodyLen - 1));
        $frame .= chr(Constantjt709a::BINARY_MSG_HEADER);
        
        if (strlen($frame) < Constantjt709a::BINARY_MSG_BASE_LENGTH) {
            return null;
        }

        return $frame;
    }

  
    public static function unescape(string $in): string {
        $len = strlen($in);
        $i = 0;
        $frame = '';

        while ($i < $len) {
            $b = ord($in[$i]);
            if ($b == 0x7D) {
                $i++;
                if ($i >= $len) break;
                $nextByte = ord($in[$i]);
                if ($nextByte == 0x01) {
                    $frame .= chr(0x7D);
                } elseif ($nextByte == 0x02) {
                    $frame .= chr(0x7E);
                } else {
                    // Abnormal data
                    $frame .= chr($b) . chr($nextByte);
                }
                $i++;
            } else {
                $frame .= chr($b);
                $i++;
            }
        }

        return $frame;
    }
    
    
//   public static function escape(&$out, $bodyBuf) {
//         $out = ''; 
//         for ($i = 0; $i < strlen($bodyBuf); $i++) {
//             $b = ord($bodyBuf[$i]);
//             if ($b == 0x7E) {
//                 $out .= chr(0x7D) . chr(0x02); 
//             } elseif ($b == 0x7D) {
//                 $out .= chr(0x7D) . chr(0x01); 
//             } else {
//                 $out .= chr($b); 
//             }
//         }
//     }

//     public static function replyBinaryMessage($terminalNumArr, $msgFlowId) {
//         $bodyBuf = '';
//         try {
//             $bodyBuf .= pack('n', 0x8001); 
//             $bodyBuf .= pack('n', 0x0005); 
//             $bodyBuf .= $terminalNumArr; 

//             $random = rand(1, 65534); 
//             $bodyBuf .= pack('n', $random); 
//             $bodyBuf .= pack('n', $msgFlowId); 
//             $bodyBuf .= pack('n', 0x0200);
//             $bodyBuf .= chr(0x00); 

//             $checkCode = self::xor($bodyBuf); 
//             $bodyBuf .= chr($checkCode); 

//             $replyBuf = chr(Constantjt709a::BINARY_MSG_HEADER); 

//             self::escape($escapedBuf, $bodyBuf);
//             $replyBuf .= $escapedBuf; 
//             $replyBuf .= chr(Constantjt709a::BINARY_MSG_HEADER); 

//             return bin2hex($replyBuf); 
//         } catch (Exception $e) {
//             return ''; 
//         }
//     }

//     private static function xor($bodyBuf) {
//         $checkCode = 0;
//         for ($i = 0; $i < strlen($bodyBuf); $i++) {
//             $checkCode ^= ord($bodyBuf[$i]); 
//         }
//         return $checkCode;
//     }


    public static function escape(&$out, $bodyBuf) {
        $out = ''; 
        for ($i = 0; $i < strlen($bodyBuf); $i++) {
            $b = ord($bodyBuf[$i]);
            if ($b == 0x7E) {
                $out .= chr(0x7D) . chr(0x02); 
            } elseif ($b == 0x7D) {
                $out .= chr(0x7D) . chr(0x01); 
            } else {
                $out .= chr($b); 
            }
        }
    }
    
    public static function replyBinaryMessage($terminalNumArr, $msgFlowId) {
        $bodyBuf = '';
        try {
            $bodyBuf .= pack('n', 0x8001); 
            $bodyBuf .= pack('n', 0x0005); 
            $bodyBuf .= $terminalNumArr; 
    
            $random = rand(1, 65534); 
            $bodyBuf .= pack('n', $random); 
            $bodyBuf .= pack('n', $msgFlowId); 
            $bodyBuf .= pack('n', 0x0200);
            $bodyBuf .= chr(0x00); 
    
            $checkCode = self::xor($bodyBuf); 
            $bodyBuf .= chr($checkCode); 
    
            $replyBuf = chr(Constantjt709a::BINARY_MSG_HEADER); 
            
            $escapedBuf = '';
            self::escape($escapedBuf, $bodyBuf);
            $replyBuf .= $escapedBuf; 
            $replyBuf .= chr(Constantjt709a::BINARY_MSG_HEADER); 
    
            return bin2hex($replyBuf); 
        } catch (Exception $e) {
            error_log($e->getMessage());
            return ''; 
        }
    }
    
    private static function xor($bodyBuf) {
        $checkCode = 0;
        for ($i = 0; $i < strlen($bodyBuf); $i++) {
            $checkCode ^= ord($bodyBuf[$i]); 
        }
        return $checkCode;
    }


   
    public static function replyBASE2Message($itemList)
    {
        try {
            $currentDateTime = date('YmdHis');
            $strBase2Reply = sprintf("(%s,%s,%s,%s,%s,%s)", $itemList[0], $itemList[1], $itemList[2], $itemList[3], $itemList[4], $currentDateTime);
            return $strBase2Reply;
        } catch (Exception $e) {
            return '';
        }
    }
}
