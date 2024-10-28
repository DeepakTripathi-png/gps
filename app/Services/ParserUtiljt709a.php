<?php

namespace App\Services;

use App\Helpers\Constantjt709a;
use App\Helpers\AlarmTypeEnumjt709a;
use App\Helpers\LockEventjt709a;
use App\Helpers\Resultjt709a;
use App\Services\PacketUtiljt709a;
use App\Services\NumberUtiljt709a;
use App\Services\CommonUtiljt709a;
use App\Helpers\LocationDatajt709a;
use DateTimeZone;

class ParserUtiljt709a
{
    
    public static function decodeBinaryMessage(string $in)
    {
        $msg = PacketUtiljt709a::decodePacket($in);
        if ($msg === null) {
            return null;
        }
    
        $msgLen = strlen($msg);
        $msg = substr($msg, 1);
    
        $msgId = unpack('n', substr($msg, 0, 2))[1];
        $msgBodyAttr = unpack('n', substr($msg, 2, 2))[1];
    
        $msgBodyLen = $msgBodyAttr & 0x03FF;
        $multiPacket = ($msgBodyAttr & 0x2000) > 0;
    
        $baseLen = Constantjt709a::BINARY_MSG_BASE_LENGTH;
        $ensureLen = $multiPacket ? $baseLen + $msgBodyLen + 4 : $baseLen + $msgBodyLen;
    
        if ($msgLen != $ensureLen) {
            return null;
        }
    
        $terminalNumArr = substr($msg, 4, 6);
        $terminalNumber = ltrim(bin2hex($terminalNumArr), '0');
        $msgFlowId = unpack('n', substr($msg, 10, 2))[1];
    
        $packetTotalCount = 0;
        $packetOrder = 0;
        if ($multiPacket) {
            $packetTotalCount = unpack('n', substr($msg, 12, 2))[1];
            $packetOrder = unpack('n', substr($msg, 14, 2))[1];
        }
    
        $msgBodyArr = substr($msg, $multiPacket ? 16 : 12, $msgBodyLen);
    
        $result = new Resultjt709a();
        $result->setDeviceID($terminalNumber);
    
        if ($msgId === 0x0200) {
            $locationData = self::parseLocationBody($msgBodyArr);
            $locationData['msgFlowId'] = $msgFlowId;
            $locationData['msgBodyLen'] = $msgBodyLen;
    
            $replyMsg = PacketUtiljt709a::replyBinaryMessage($terminalNumArr, $msgFlowId);
    
            $result->setMsgType('Location');
            $result->setDataBody($locationData);
            $result->setReplyMsg($replyMsg);
    
            return [
                'DeviceID' => $result->getDeviceID(),
                'DataBody' => $result->getDataBody()['DataBody'],
                'ReplyMsg' => $result->getReplyMsg(),
                'MsgType' => $result->getMsgType()
            ];
        } else {
            $result->setMsgType('heartbeat');
            $result->setDataBody(null);
    
            return [
                'DeviceID' => $result->getDeviceID(),
                'MsgType' => $result->getMsgType(),
                'DataBody' => null
            ];
        }
    }




    public static function decodeTextMessage($in)
    {
        $tailIndex = strpos($in,  Constantjt709a::TEXT_MSG_TAIL);
        if ($tailIndex === false) {
            return null;
        }
    
        $model = new Resultjt709();
    
        $in = substr($in, 1);
    
        $itemList = [];
        while (!empty($in)) {
            $index = strpos($in,  Constantjt709a::TEXT_MSG_SPLITER);
            $itemLen = $index > 0 ? $index : strlen($in) - 1;
            $byteArr = substr($in, 0, $itemLen);
            $in = substr($in, $itemLen + 1);
            $itemList[] = $byteArr;
        }
    
        $msgType = '';
        if (count($itemList) >= 5) {
            $msgType = $itemList[3] . $itemList[4];
        }
    
        $dataBody = null;
        if (!empty($itemList)) {
            $dataBody = '(';
            foreach ($itemList as $item) {
                $dataBody .= $item . ',';
            }
            $dataBody = rtrim($dataBody, ',');
            $dataBody .= ')';
        }
    
        $replyMsg = '';
        if ($msgType === 'BASE2' && strtoupper($itemList[5]) === 'TIME') {
            $replyMsg = PacketUtiljt709a::replyBASE2Message($itemList);
        }
    
        $model->setDeviceID($itemList[0]);
        $model->setMsgType($msgType);
        $model->setDataBody($dataBody);
        $model->setReplyMsg($replyMsg);
    
        return $model;
    }


    
  public static function parseLocationBody($msgBodyBuf)
  {
        $alarmFlag = unpack('N', substr($msgBodyBuf, 0, 4))[1];
        $msgBodyBuf = substr($msgBodyBuf, 4);
    
        $status = unpack('N', substr($msgBodyBuf, 0, 4))[1];
        $msgBodyBuf = substr($msgBodyBuf, 4);
    
        $lat = NumberUtiljt709a::multiply(unpack('N', substr($msgBodyBuf, 0, 4))[1], NumberUtiljt709a::COORDINATE_PRECISION);
        $msgBodyBuf = substr($msgBodyBuf, 4);
    
        $lon = NumberUtiljt709a::multiply(unpack('N', substr($msgBodyBuf, 0, 4))[1], NumberUtiljt709a::COORDINATE_PRECISION);
        $msgBodyBuf = substr($msgBodyBuf, 4);
    
        $altitude = unpack('s', substr($msgBodyBuf, 0, 2))[1];
        $msgBodyBuf = substr($msgBodyBuf, 2);
    
        $speed = NumberUtiljt709a::multiply(unpack('n', substr($msgBodyBuf, 0, 2))[1], NumberUtiljt709a::ONE_PRECISION);
        $msgBodyBuf = substr($msgBodyBuf, 2);
    
        $direction = unpack('s', substr($msgBodyBuf, 0, 2))[1];
        $msgBodyBuf = substr($msgBodyBuf, 2);
    
        $timeArr = substr($msgBodyBuf, 0, 6);
        $bcdTimeStr = bin2hex($timeArr);
        $gpsZonedDateTime = CommonUtiljt709a::parseBcdTime($bcdTimeStr);
        $msgBodyBuf = substr($msgBodyBuf, 6);
    
        if (NumberUtiljt709a::getBitValue($status, 2) == 1) {
            $lat = -$lat;
        }
        if (NumberUtiljt709a::getBitValue($status, 3) == 1) {
            $lon = -$lon;
        }
    
        $locationType = NumberUtiljt709a::getBitValue($status, 18);
    
        if ($locationType == 0) {
            $locationType = NumberUtiljt709a::getBitValue($status, 1);
        }
        if ($locationType == 0) {
            $locationType = NumberUtiljt709a::getBitValue($status, 6) > 0 ? 2 : 0;
        }
    
        $lockRope = NumberUtiljt709a::getBitValue($status, 20);
    
        $lockMotor = NumberUtiljt709a::getBitValue($status, 21);
    
        $lockStatus = ($lockRope == 1 || $lockMotor == 1) ? 1 : 0;
    
        $backCover = NumberUtiljt709a::getBitValue($status, 7);
    
        $awaken = ($status >> 24) & 0b00001111;
    
        $alarm = self::parseAlarm($alarmFlag);
    
        $locationData = [
            'GpsTime' => $gpsZonedDateTime->format('c'),
            'Latitude' => $lat,
            'Longitude' => $lon,
            'Altitude' => $altitude,
            'Speed' => (int)$speed,
            'Direction' => $direction,
            'LocationType' => $locationType,
            'LockStatus' => $lockStatus,
            'LockRope' => $lockRope,
            'BackCover' => $backCover,
            'Awaken' => (int)$awaken,
            'Alarm' => $alarm
        ];
        
      
        if (strlen($msgBodyBuf) > 0) {
          self::parseExtraInfo($msgBodyBuf, $locationData);
        }
    
        return ['DataBody' => $locationData];
}



    private static function parseExtraInfo($msgBodyBuf, &$locationData)
    {
        $offset = 0;
    
        while (strlen($msgBodyBuf) > $offset + 1) {
            $extraInfoId = ord($msgBodyBuf[$offset++]);
            $extraInfoLen = ord($msgBodyBuf[$offset++]);
    
            if (strlen($msgBodyBuf) < $offset + $extraInfoLen) {
                break;
            }
    
            // Extract the extra info slice
            $extraInfoBuf = substr($msgBodyBuf, $offset, $extraInfoLen);
            $offset += $extraInfoLen;
    
            switch ($extraInfoId) {
                case 0x0B:
                    $type = ord($extraInfoBuf[0]);
                    $extraInfoBuf = substr($extraInfoBuf, 1);
                    
                     $locationData['LockEvent']['Type'] =  $type;
    
                    if (in_array($type, [0x01, 0x02, 0x03, 0x05, 0x1E, 0x1F])) {
                        $password = substr($extraInfoBuf, 0, 6);
                        $locationData['LockEvent']['Password'] = $password;
                        $unlockStatus = ord($extraInfoBuf[6]);
                        $locationData['LockEvent']['UnLockStatus'] = $unlockStatus == 0xFF ? 0 : 1;
                        if ($unlockStatus > 0 && $unlockStatus < 100) {
                            $locationData['LockEvent']['FenceId'] = $unlockStatus;
                        }
                    } elseif (in_array($type, [0x06, 0x07, 0x08, 0x10, 0x11, 0x18, 0x19, 0x20, 0x28, 0x29])) {
                        $password = substr($extraInfoBuf, 0, 6);
                        $locationData['LockEvent']['Password'] = $password;
                        $locationData['LockEvent']['UnLockStatus'] = 0;
                    } elseif ($type == 0x22) {
                        $cardId = unpack('N', substr($extraInfoBuf, 0, 4))[1];
                        if ($cardId != 0) {
                            $locationData['LockEvent']['CardNo'] = sprintf('%010d', $cardId);
                        }
                        if (strlen($extraInfoBuf) > 4) {
                            $unlockStatus = ord($extraInfoBuf[4]);
                            $locationData['LockEvent']['UnLockStatus'] = $unlockStatus == 0xFF ? 0 : 1;
                            if ($unlockStatus > 0 && $unlockStatus < 100) {
                                $locationData['LockEvent']['FenceId'] = $unlockStatus;
                            }
                        } else {
                            $locationData['LockEvent']['UnLockStatus'] = 1;
                        }
                    } elseif (in_array($type, [0x23, 0x2A, 0x2B])) {
                        $cardId = unpack('N', substr($extraInfoBuf, 0, 4))[1];
                        if ($cardId != 0) {
                            $locationData['LockEvent']['CardNo'] = sprintf('%010d', $cardId);
                        }
                    }
                    break;
    
                case 0x30:
                    $locationData['GSMSignal'] = ord($extraInfoBuf[0]);
                    break;
    
                case 0x31:
                    $locationData['GpsSignal'] = ord($extraInfoBuf[0]);
                    break;
    
                case 0xD4:
                    $locationData['Battery'] = ord($extraInfoBuf[0]);
                    break;
    
                case 0xD5:
                    $locationData['Voltage'] = number_format(unpack('n', substr($extraInfoBuf, 0, 2))[1] * 0.01, 2);
                    break;
    
                case 0xF9:
                    $locationData['ProtocolVersion'] = unpack('n', substr($extraInfoBuf, 0, 2))[1];
                    break;
    
                case 0xFD:
                    $locationData['MCC'] = unpack('n', substr($extraInfoBuf, 0, 2))[1];
                    $locationData['MNC'] = ord($extraInfoBuf[2]);
                    $locationData['CELLID'] = unpack('N', substr($extraInfoBuf, 3, 4))[1];
                    $locationData['LAC'] = unpack('n', substr($extraInfoBuf, 7, 2))[1];
                    break;
    
                case 0xFC:
                    $locationData['FenceId'] = ord($extraInfoBuf[0]);
                    break;
    
                case 0xFE:
                    $locationData['Mileage'] = unpack('N', substr($extraInfoBuf, 0, 4))[1];
                    break;
    
                default:
                  
                    break;
            }
            
            
        }
    }


    




    


 

    
    
    private static function parseAlarm($alarmFlag)
    {
        
        $alarm = -1;

       
        if (NumberUtiljt709a::getBitValue($alarmFlag, 1) == 1) {
            $alarm = 1;
        } elseif (NumberUtiljt709a::getBitValue($alarmFlag, 7) == 1) {
            $alarm = 2;
        } elseif (NumberUtiljt709a::getBitValue($alarmFlag, 16) == 1) {
            $alarm = 3;
        } elseif (NumberUtiljt709a::getBitValue($alarmFlag, 17) == 1) {
            $alarm = 4;
        } elseif (NumberUtiljt709a::getBitValue($alarmFlag, 18) == 1) {
            $alarm = 5;
        }

        return $alarm;
    }


}

