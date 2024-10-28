<?php

namespace App\Utils;

use Illuminate\Support\Str;
use App\Models\Result;
use App\Models\SensorData;
use App\Models\LockEvent;
use DateTime;
use DateTimeZone;
use Carbon\Carbon;
use App\Utils\NumberUtil;
use App\Constants\Constant;
use Exception;
use Illuminate\Support\Facades\Log;
use App\Utils\CommonUtil;



class ParserUtil
{
    private function __construct()
    {
        // Private constructor to prevent instantiation
    }

    public static function decodeTextMessage($data)
    {


        $model = new Result();
        $itemList = [];
        $msgBody = null;

        $dataLength = strlen($data);
        $index = 0;

        while ($index < $dataLength) {

            if (count($itemList) >= 6 && $itemList[3] === "WLNET" && in_array($itemList[4], Constant::WLNET_TYPE_LIST)) {
                $lastItemLen = $dataLength - $index - 1;
                $msgBody = substr($data, $index, $lastItemLen);



                $index += $lastItemLen + 1;
            } else {
                $delimiterPos = strpos($data, Constant::TEXT_MSG_SPLITTER, $index);
                $itemLen = $delimiterPos !== false ? $delimiterPos - $index : $dataLength - $index - 1;
                $item = substr($data, $index, $itemLen);
                $itemList[] = $item;
                $index += $itemLen + 1;
            }
        }

        $msgType = $itemList[1];
        if (count($itemList) >= 5 && ($itemList[3] === "WLNET" || $itemList[3] === "OTA")) {
            $msgType = $itemList[3] . $itemList[4];
        }

        $dataBody = null;
        if ($msgType === "WLNET5") {
            $sensorData = self::parseWlnet5($msgBody);
            $dataBody = $sensorData;



            return $dataBody;

            $model->setReplyMsg(self::replyMessageByIndex($msgType, $sensorData->getIndex()));
        } elseif ($msgType === "P45") {
            $dataBody = self::parseP45($itemList);
            $model->setReplyMsg(self::replyMessage($msgType, $itemList));
        } else {
            if (count($itemList) > 0) {
                $dataBody = "(" . implode(",", $itemList) . ")";
            }
        }

        $model->setDeviceID($itemList[0]);
        $model->setMsgType($msgType);
        $model->setDataBody($dataBody);

        return $model;
    }



    private static function parseWlnet5($byteBuf)
    {

        $sensorData = [];

        // Positioning time
        $timeArr = substr($byteBuf, 0, 6);
        $bcdTimeStr = bin2hex($timeArr);
        $gpsZonedDateTime = self::parseBcdTime($bcdTimeStr);

        // Latitude
        $latArr = substr($byteBuf, 6, 4);
        $latHexStr = bin2hex($latArr);
        $latFloat = bcdiv(substr($latHexStr, 2, 2) . '.' . substr($latHexStr, 4), 60, 6);
        $lat = bcadd(substr($latHexStr, 0, 2), $latFloat, 6);

        // Longitude
        $lngArr = substr($byteBuf, 10, 5);
        $lngHexStr = bin2hex($lngArr);
        $intPart = hexdec(substr($lngHexStr, 3, 2));
        $fracPart = hexdec(substr($lngHexStr, 5, 4));
        $lngFloat = bcdiv($intPart . '.' . $fracPart, 60, 6);
        $lngIntPart = hexdec(substr($lngHexStr, 0, 3));
        $lng = bcadd($lngIntPart, $lngFloat, 6);

        // Bit indication
        $bitFlag = hexdec(substr($lngHexStr, 9, 1));

        // Positioning status
        $locationType = ($bitFlag & 0x01) > 0 ? 1 : 0;

        // North/South Latitude
        if (($bitFlag & 0b0010) == 0) {
            $lat = -$lat;
        }

        // East/West Longitude
        if (($bitFlag & 0b0100) == 0) {
            $lng = -$lng;
        }

        // Speed
        $speed = hexdec(substr($byteBuf, 15, 1)) * 1.85;

        // Direction
        $direction = hexdec(substr($byteBuf, 16, 1)) * 2;

        // Slave machine time
        $slaveMachineTimeArr = substr($byteBuf, 17, 6);
        $slaveMachineBcdTimeStr = bin2hex($slaveMachineTimeArr);
        $slaveMachineZonedDateTime = self::parseBcdTime($slaveMachineBcdTimeStr);

        // Slave sensor ID
        $slaveMachineIdArr = substr($byteBuf, 23, 5);
        $slaveMachineId = strtoupper(bin2hex($slaveMachineIdArr));

        // Slave data serial number
        $flowId = hexdec(substr($byteBuf, 28, 1));

        // Slave sensor battery level
        $voltage = bcdiv(hexdec(substr($byteBuf, 29, 2)), 100, 2);

        // Slave sensor battery percentage
        $power = hexdec(substr($byteBuf, 31, 1));

        // RSSI
        $rssi = hexdec(substr($byteBuf, 32, 1));

        // Sensor type
        $sensorType = hexdec(substr($byteBuf, 33, 1));

        // Initialize variables for sensor data
        $temperature = -1000.0;
        $humidity = 0;
        $eventType = -1;
        $terminalStatus = -1;
        $lockTimes = -1;

        // Process sensor data based on sensor type
        if ($sensorType == 1) {
            $temperature = self::parseTemperature(hexdec(substr($byteBuf, 34, 2)));
            $humidity = hexdec(substr($byteBuf, 36, 1));
            $itemCount = hexdec(substr($byteBuf, 37, 2));
            $gatewayStatus = hexdec(substr($byteBuf, 39, 1));
        } elseif ($sensorType == 4 || $sensorType == 5 || $sensorType == 6) {
            $event = hexdec(substr($byteBuf, 34, 2));
            $eventType = self::processEventType($event);
            $terminalStatus = hexdec(substr($byteBuf, 36, 2));
            $lockTimes = hexdec(substr($byteBuf, 38, 2));
            $gatewayStatus = hexdec(substr($byteBuf, 40, 1));
        }

        // Fill sensor data array
        $sensorData['gps_time'] = $gpsZonedDateTime;
        $sensorData['latitude'] = $lat;
        $sensorData['longitude'] = $lng;
        $sensorData['location_type'] = $locationType;
        $sensorData['speed'] = $speed;
        $sensorData['direction'] = $direction;
        $sensorData['sensor_id'] = $slaveMachineId;
        $sensorData['lock_status'] = ($terminalStatus != -1) ? self::getBitValue($terminalStatus, 0) : null;
        $sensorData['lock_rope'] = ($terminalStatus != -1) ? self::getBitValue($terminalStatus, 1) : null;
        $sensorData['lock_times'] = $lockTimes;
        $sensorData['flow_id'] = $flowId;
        $sensorData['voltage'] = $voltage;
        $sensorData['power'] = $power;
        $sensorData['rssi'] = $rssi;
        $sensorData['slave_machine_time'] = $slaveMachineZonedDateTime;
        $sensorData['sensor_type'] = $sensorType;
        $sensorData['temperature'] = $temperature;
        $sensorData['humidity'] = $humidity;
        $sensorData['event'] = $eventType;

        return $sensorData;
    }





    // private static function parseWlnet5($byteBuf){

    //     $sensorData = [];



    //     // Positioning time
    //     $timeArr = substr($byteBuf, 0, 6);

    //     $bcdTimeStr = bin2hex($timeArr);

    //     $gpsZonedDateTime =self::parseBcdTime($bcdTimeStr);

    //     // Latitude
    //     $latArr = substr($byteBuf, 6, 4);
    //     $latHexStr = bin2hex($latArr);
    //     $latFloat = bcdiv(substr($latHexStr, 2, 2) . '.' . substr($latHexStr, 4), 60, 6);
    //     $lat = bcadd(substr($latHexStr, 0, 2), $latFloat, 6);






    //     // Longitude

    //     // $lngArr = substr($byteBuf, 10, 5);
    //     // $lngHexStr = bin2hex($lngArr);
    //     // $lngFloat = bcdiv(substr($lngHexStr, 3, 2) . '.' . substr($lngHexStr, 5, 4), 60, 6);
    //     // $lng = bcadd(substr($lngHexStr, 0, 3), $lngFloat, 6);


    //     $lngArr = substr($byteBuf, 10, 5);
    //     $lngHexStr = bin2hex($lngArr);
    //     $intPart = hexdec(substr($lngHexStr, 3, 2));
    //     $fracPart = hexdec(substr($lngHexStr, 5, 4));
    //     $lngFloat = bcdiv($intPart . '.' . $fracPart, 60, 6);

    //     $lngIntPart = hexdec(substr($lngHexStr, 0, 3));
    //     $lng = bcadd($lngIntPart, $lngFloat, 6);







    //     // Bit indication
    //     $bitFlag = hexdec(substr($lngHexStr, 9, 1));

    //     // Positioning status
    //     $locationType = ($bitFlag & 0x01) > 0 ? 1 : 0;

    //     // North/South Latitude
    //     if (($bitFlag & 0b0010) == 0) {
    //         $lat = -$lat;
    //     }

    //     // East/West Longitude
    //     if (($bitFlag & 0b0100) == 0) {
    //         $lng = -$lng;
    //     }

    //     // Speed
    //     $speed = hexdec(substr($byteBuf, 15, 1)) * 1.85;





    //     // Direction
    //     $direction = hexdec(substr($byteBuf, 16, 1)) * 2;





    //     // Slave machine time
    //     $slaveMachineTimeArr = substr($byteBuf, 17, 6);
    //     $slaveMachineBcdTimeStr = bin2hex($slaveMachineTimeArr);
    //     $slaveMachineZonedDateTime = self::parseBcdTime($slaveMachineBcdTimeStr);






    //     // Slave sensor ID
    //     $slaveMachineIdArr = substr($byteBuf, 23, 5);
    //     $slaveMachineId = strtoupper(bin2hex($slaveMachineIdArr));



    //     // Slave data serial number
    //     $flowId = hexdec(substr($byteBuf, 28, 1));



    //     // Slave sensor battery level
    //     $voltage = bcdiv(hexdec(substr($byteBuf, 29, 2)), 100, 2);



    //     // Slave sensor battery percentage
    //     $power = hexdec(substr($byteBuf, 31, 1));



    //     // RSSI
    //     $rssi = hexdec(substr($byteBuf, 32, 1));



    //     // Sensor type
    //     $sensorType = hexdec(substr($byteBuf, 33, 1));






    //     // Initialize variables for sensor data
    //     $temperature = -1000.0;
    //     $humidity = 0;
    //     $eventType = -1;
    //     $terminalStatus = -1;
    //     $lockTimes = -1;

    //     // Process sensor data based on sensor type
    //     if ($sensorType == 1) {
    //         $temperature = parseTemperature(hexdec(substr($byteBuf, 34, 2)));
    //         $humidity = hexdec(substr($byteBuf, 36, 1));
    //         $itemCount = hexdec(substr($byteBuf, 37, 2));
    //         $gatewayStatus = hexdec(substr($byteBuf, 39, 1));
    //     } elseif ($sensorType == 4){
    //         $event = hexdec(substr($byteBuf, 34, 2));


    //         $eventType = processEventType($event);
    //         $terminalStatus = hexdec(substr($byteBuf, 36, 2));
    //         $lockTimes = hexdec(substr($byteBuf, 38, 2));
    //         $gatewayStatus = hexdec(substr($byteBuf, 40, 1));
    //     }

    //     // Fill sensor data array
    //     $sensorData['gps_time'] = $gpsZonedDateTime;
    //     $sensorData['latitude'] = $lat;
    //     $sensorData['longitude'] = $lng;
    //     $sensorData['location_type'] = $locationType;
    //     $sensorData['speed'] = $speed;
    //     $sensorData['direction'] = $direction;
    //     $sensorData['sensor_id'] = $slaveMachineId;
    //     $sensorData['lock_status'] = ($terminalStatus != -1) ? getBitValue($terminalStatus, 0) : null;
    //     $sensorData['lock_rope'] = ($terminalStatus != -1) ? getBitValue($terminalStatus, 0) : null;
    //     $sensorData['lock_times'] = $lockTimes;
    //     $sensorData['flow_id'] = $flowId;
    //     $sensorData['voltage'] = $voltage;
    //     $sensorData['power'] = $power;
    //     $sensorData['rssi'] = $rssi;
    //     $sensorData['slave_machine_time'] = $slaveMachineZonedDateTime;
    //     $sensorData['sensor_type'] = $sensorType;
    //     $sensorData['temperature'] = $temperature;
    //     $sensorData['humidity'] = $humidity;
    //     $sensorData['event'] = $eventType;

    //     return $sensorData;
    // }

    // function parseBcdTime($bcdTimeStr) {
    //     return Carbon::now();
    // }

    // function parseTemperature($tempHex) {
    //     return $tempHex / 100;
    // }

    // function processEventType($event) {
    //     return 0;
    // }

    // function getBitValue($value, $position) {
    //     return ($value >> $position) & 1;
    // }






    // private static function parseWlnet5($data)
    // {


    //     $parsedData = [];
    //     $offset = 0;
    //     $length = strlen($data);



    //     // Helper function to read a specified number of bytes from data
    //     function readBytes($data, &$offset, $numBytes)
    //     {
    //         $result = substr($data, $offset, $numBytes);
    //         $offset += $numBytes;
    //         return $result;
    //     }



    //     // Helper function to convert bytes to a 32-bit integer (little-endian)
    //     function bytesToInt32($bytes)
    //     {
    //         return unpack('V', $bytes)[1];
    //     }



    //     // Helper function to convert bytes to a 16-bit integer (little-endian)
    //     function bytesToInt16($bytes)
    //     {
    //         return unpack('v', $bytes)[1];
    //     }



    //     // Helper function to convert bytes to a float (little-endian)
    //     function bytesToFloat($bytes)
    //     {
    //         return unpack('f', $bytes)[1];
    //     }




    //     // Read 4 bytes for the length of the data section
    //     $dataLength = bytesToInt32(readBytes($data, $offset, 4));

    //     return 'Hello From Wlnet5';

    //     // Ensure we don't read beyond the available data length
    //     if ($dataLength > $length - $offset){

    //         throw new Exception('Data length exceeds available data.');
    //     }

    //     ///////////////////////Debuging is Done////////////////////////////////////Till This Place///////////////
    //     return 'Hello From Wlnet5';
    //     ///////////////////////Debuging is Done////////////////////////////////////Till This Place///////////////

    //     // Read the data section
    //     $dataSection = readBytes($data, $offset, $dataLength);

    //     // Parse data section (example logic, adjust as needed)
    //     while ($offset < $length) {
    //         // Example: Read an integer (4 bytes)
    //         $intValue = bytesToInt32(readBytes($dataSection, $offset, 4));
    //         $parsedData['integer'] = $intValue;

    //         // Example: Read a short (2 bytes)
    //         $shortValue = bytesToInt16(readBytes($dataSection, $offset, 2));
    //         $parsedData['short'] = $shortValue;

    //         // Example: Read a float (4 bytes)
    //         $floatValue = bytesToFloat(readBytes($dataSection, $offset, 4));
    //         $parsedData['float'] = $floatValue;

    //         // Example: Read a string (null-terminated, 1 byte for length, followed by the string)
    //         $stringLength = ord(readBytes($dataSection, $offset, 1));
    //         $stringValue = readBytes($dataSection, $offset, $stringLength);
    //         $parsedData['string'] = $stringValue;

    //         // Example: Read date (8 bytes for timestamp)
    //         $timestamp = bytesToInt32(readBytes($dataSection, $offset, 8));
    //         $parsedData['date'] = date('Y-m-d H:i:s', $timestamp);
    //     }

    //     return $parsedData;
    // }


    private static function parseP45($itemList)
    {
        $parsedData = [];
        $offset = 0;
        $length = strlen($itemList);

        // Helper function to read a specified number of bytes from the item list
        function readBytes($data, &$offset, $numBytes)
        {
            $result = substr($data, $offset, $numBytes);
            $offset += $numBytes;
            return $result;
        }

        // Helper function to convert bytes to a 32-bit integer (little-endian)
        function bytesToInt32($bytes)
        {
            return unpack('V', $bytes)[1];
        }

        // Helper function to convert bytes to a 16-bit integer (little-endian)
        function bytesToInt16($bytes)
        {
            return unpack('v', $bytes)[1];
        }

        // Helper function to convert bytes to a float (little-endian)
        function bytesToFloat($bytes)
        {
            return unpack('f', $bytes)[1];
        }

        // Example parsing logic: This is based on a common structure, adjust as needed
        while ($offset < $length) {
            // Example: Read a 4-byte identifier
            $identifier = readBytes($itemList, $offset, 4);
            $parsedData['identifier'] = $identifier;

            // Example: Read a 2-byte value
            $value = bytesToInt16(readBytes($itemList, $offset, 2));
            $parsedData['value'] = $value;

            // Example: Read a 4-byte float
            $floatValue = bytesToFloat(readBytes($itemList, $offset, 4));
            $parsedData['float_value'] = $floatValue;

            // Example: Read a string length (1 byte) followed by the string itself
            $stringLength = ord(readBytes($itemList, $offset, 1));
            $stringValue = readBytes($itemList, $offset, $stringLength);
            $parsedData['string'] = $stringValue;

            // Example: Read a 4-byte timestamp and convert to date
            $timestamp = bytesToInt32(readBytes($itemList, $offset, 4));
            $parsedData['date'] = date('Y-m-d H:i:s', $timestamp);

            // Example: Read a byte indicating the end of the current item
            $endByte = ord(readBytes($itemList, $offset, 1));
            if ($endByte !== 0xFF) {
                throw new Exception('Unexpected end byte value.');
            }
        }

        return $parsedData;
    }


    private static function parseTemperature($temperatureInt) {
        if ($temperatureInt == 0xFFFF) {
            return 9999.9;
        }
        $temperature = ((($temperatureInt << 4) >> 4)) * 0.1;
        if (($temperatureInt >> 12) > 0) {
            $temperature = -$temperature;
        }
        return $temperature;
    }

    public static function parseBcdTime($bcdTimeStr) {

        if ($bcdTimeStr === "000000000000") {
            $bcdTimeStr = "010100000000";
        }

        $formatter = \DateTime::createFromFormat('dmyHis', $bcdTimeStr);
        $zonedDateTime = $formatter->setTimezone(new \DateTimeZone('UTC'));
        return $zonedDateTime;
    }



// public static function decodeBinaryMessage($in)
// {
//     return 'Hello Deepak';

//     // Protocol header
//     $in->readByte();



//     // DeviceID
//     $terminalNumArr = $in->readBytes(5);
//     $terminalNum = bin2hex($terminalNumArr);

//     // Protocol version
//     $version = $in->readUnsignedByte();
//     $tempByte = $in->readUnsignedByte();

//     // Device type
//     $terminalType = $tempByte >> 4;

//     // Data type
//     $dataType = $tempByte & 0b00001111;

//     // Data length
//     $dataLen = $in->readUnsignedShort();

//     // GPS time
//     $timeArr = $in->readBytes(6);
//     $bcdTimeStr = bin2hex($timeArr);
//     $gpsZonedDateTime = self::parseBcdTime($bcdTimeStr);

//     // Latitude
//     $latArr = $in->readBytes(4);
//     $latHexStr = bin2hex($latArr);
//     $latFloat = (new BigDecimal(substr($latHexStr, 2, 2) . '.' . substr($latHexStr, 4)))
//         ->divide(new BigDecimal("60"), 6, RoundingMode::HALF_UP);
//     $lat = (new BigDecimal(substr($latHexStr, 0, 2)))->add($latFloat)->toDouble();

//     // Longitude
//     $lngArr = $in->readBytes(5);
//     $lngHexStr = bin2hex($lngArr);
//     $lngFloat = (new BigDecimal(substr($lngHexStr, 3, 2) . '.' . substr($lngHexStr, 5, 4)))
//         ->divide(new BigDecimal("60"), 6, RoundingMode::HALF_UP);
//     $lng = (new BigDecimal(substr($lngHexStr, 0, 3)))->add($lngFloat)->toDouble();

//     // Bit indication
//     $bitFlag = hexdec(substr($lngHexStr, 9, 1));

//     // Positioning status
//     $locationType = ($bitFlag & 0x01) > 0 ? 1 : 0;

//     // North latitude / South latitude
//     if (($bitFlag & 0b0010) == 0) {
//         $lat = -$lat;
//     }

//     // East longitude / West longitude
//     if (($bitFlag & 0b0100) == 0) {
//         $lng = -$lng;
//     }

//     // Speed
//     $speed = (int) ($in->readUnsignedByte() * 1.85);

//     // Direction (Heading)
//     $direction = $in->readUnsignedByte() * 2;

//     // Mileage
//     $mileage = $in->readUnsignedInt();

//     // Number of GPS satellites
//     $gpsSignal = $in->readByte();

//     // Bind vehicle ID
//     $vehicleId = $in->readUnsignedInt();

//     // Device status
//     $terminalStatus = $in->readUnsignedShort();

//     // Base station located?
//     if (NumberUtil::getBitValue($terminalStatus, 0) == 1) {
//         $locationType = 2;
//     }

//     // Battery indicator
//     $batteryPercent = $in->readUnsignedByte();

//     // 2G CELL ID
//     $cellId2G = $in->readUnsignedShort();

//     // LAC
//     $lac = $in->readUnsignedShort();

//     // GSM Signal quality
//     $cellSignal = $in->readUnsignedByte();

//     // Fence Alarm ID
//     $regionAlarmId = $in->readUnsignedByte();

//     // Device status 3
//     $terminalStatus3 = $in->readUnsignedByte();

//     // Wakeup source
//     $fWakeSource = ($terminalStatus3 & 0b00001111);

//     // Reserved
//     $in->readShort();

//     // IMEI No.
//     $imeiArr = $in->readBytes(8);
//     $imei = bin2hex($imeiArr);

//     // 3G CELL ID High 16 bits
//     $cellId3G = $in->readUnsignedShort();
//     $cellId = ($cellId3G > 0) ? ($cellId3G << 16) + $cellId2G : $cellId2G;

//     // MCC
//     $mcc = $in->readUnsignedShort();

//     // MNC
//     $mnc = $in->readUnsignedByte();

//     // Data serial number
//     $flowId = $in->readUnsignedByte();

//     // Parse alarm
//     $fAlarm = self::parseLocationAlarm($terminalStatus);

//     // Create LocationData object
//     $location = new LocationData();
//     $location->setProtocolType($version);
//     $location->setDeviceType($terminalType);
//     $location->setDataType($dataType);
//     $location->setDataLength($dataLen);
//     $location->setGpsTime($gpsZonedDateTime->format('Y-m-d H:i:s'));
//     $location->setLatitude($lat);
//     $location->setLongitude($lng);
//     $location->setLocationType($locationType);
//     $location->setSpeed($speed);
//     $location->setDirection($direction);
//     $location->setMileage($mileage);
//     $location->setGpsSignal($gpsSignal);
//     $location->setGSMSignal($cellSignal);
//     $location->setAlarm($fAlarm);
//     $location->setAlarmArea($regionAlarmId);
//     $location->setBattery($batteryPercent);
//     $location->setLockStatus(NumberUtil::getBitValue($terminalStatus, 7) == 1 ? 0 : 1);
//     $location->setLockRope(NumberUtil::getBitValue($terminalStatus, 6) == 1 ? 0 : 1);
//     $location->setBackCover(NumberUtil::getBitValue($terminalStatus, 13));
//     $location->setMCC($mcc);
//     $location->setMNC($mnc);
//     $location->setLAC($lac);
//     $location->setCELLID($cellId);
//     $location->setIMEI($imei);
//     $location->setAlarm($fWakeSource);
//     $location->setIndex($flowId);

//     // Create Result object
//     $model = new Result();
//     $model->setDeviceID($terminalNum);
//     $model->setMsgType("Location");
//     $model->setDataBody($location);

//     if ($version < 0x19) {
//         $model->setReplyMsg("(P35)");
//     } else {
//         $model->setReplyMsg(sprintf("(P69,0,%s)", $flowId));
//     }

//     return $model;
// }



public static function decodeBinaryMessage($binaryString)
{


    // Use an offset to keep track of position in the binary string
    $offset = 0;

    // Read Protocol Header (1 byte)
    $offset += 1;

    // Read DeviceID (5 bytes)
    $terminalNumArr = substr($binaryString, $offset, 5);
    $offset += 5;
    $terminalNum = bin2hex($terminalNumArr);



    // Read Protocol Version (1 byte)
    $version = ord($binaryString[$offset]);
    $offset += 1;

    // Read Device Type and Data Type (1 byte)
    $tempByte = ord($binaryString[$offset]);
    $offset += 1;
    $terminalType = $tempByte >> 4;
    $dataType = $tempByte & 0x0F;



    // Read Data Length (2 bytes)
    $dataLen = unpack('n', substr($binaryString, $offset, 2))[1];
    $offset += 2;

    // Read GPS Time (6 bytes)
    $timeArr = substr($binaryString, $offset, 6);
    $offset += 6;
    $bcdTimeStr = bin2hex($timeArr);


    $gpsZonedDateTime = self::parseBcdTime($bcdTimeStr);



    // Read Latitude (4 bytes)
    $latArr = substr($binaryString, $offset, 4);



    $offset += 4;
    $latHexStr = bin2hex($latArr);
    $latFloat = bcdiv(substr($latHexStr, 2, 2) . '.' . substr($latHexStr, 4), '60', 6);



    $lat = bcadd(hexdec(substr($latHexStr, 0, 2)), $latFloat, 6);



    // Read Longitude (5 bytes)
    $lngArr = substr($binaryString, $offset, 5);

    $offset += 5;
    $lngHexStr = bin2hex($lngArr);
    $lngFloat = bcdiv(substr($lngHexStr, 3, 2) . '.' . substr($lngHexStr, 5, 4), '60', 6);
    $lng = bcadd(hexdec(substr($lngHexStr, 0, 3)), $lngFloat, 6);

    // Bit Flag (1 nibble for positioning status and latitude/longitude direction)
    $bitFlag = hexdec($lngHexStr[9]);
    $locationType = ($bitFlag & 0x01) > 0 ? 1 : 0;

    // Adjust latitude for North/South
    if (($bitFlag & 0b0010) == 0) {
        $lat = -$lat;
    }

    // Adjust longitude for East/West
    if (($bitFlag & 0b0100) == 0) {
        $lng = -$lng;
    }

    // Read Speed (1 byte)
    $speed = ord($binaryString[$offset]) * 1.85;
    $offset += 1;

    // Read Direction (1 byte)
    $direction = ord($binaryString[$offset]) * 2;
    $offset += 1;

    // Read Mileage (4 bytes)
    $mileage = unpack('N', substr($binaryString, $offset, 4))[1];
    $offset += 4;

    // Read GPS Signal (1 byte)
    $gpsSignal = ord($binaryString[$offset]);
    $offset += 1;

    // Read Vehicle ID (4 bytes)
    $vehicleId = unpack('N', substr($binaryString, $offset, 4))[1];
    $offset += 4;

    // Read Device Status (2 bytes)
    $terminalStatus = unpack('n', substr($binaryString, $offset, 2))[1];
    $offset += 2;




    // Check base station location (bit 0 of terminalStatus)
    if (NumberUtil::getBitValue($terminalStatus, 0) == 1) {
        $locationType = 2;
    }






    // Read Battery Percentage (1 byte)
    $batteryPercent = ord($binaryString[$offset]);
    $offset += 1;

    // Read 2G CELL ID (2 bytes)
    $cellId2G = unpack('n', substr($binaryString, $offset, 2))[1];
    $offset += 2;

    // Read LAC (2 bytes)
    $lac = unpack('n', substr($binaryString, $offset, 2))[1];
    $offset += 2;

    // Read GSM Signal Quality (1 byte)
    $cellSignal = ord($binaryString[$offset]);
    $offset += 1;

    // Read Fence Alarm ID (1 byte)
    $regionAlarmId = ord($binaryString[$offset]);
    $offset += 1;

    // Read Device Status3 (1 byte)
    $terminalStatus3 = ord($binaryString[$offset]);
    $offset += 1;
    $fWakeSource = $terminalStatus3 & 0b00001111;

    // Reserved (2 bytes)
    $offset += 2;

    // Read IMEI (8 bytes)
    $imeiArr = substr($binaryString, $offset, 8);
    $offset += 8;
    $imei = bin2hex($imeiArr);

    // Read 3G CELL ID (2 bytes)
    $cellId3G = unpack('n', substr($binaryString, $offset, 2))[1];
    $offset += 2;

    // Calculate CELL ID
    $cellId = $cellId3G > 0 ? ($cellId3G << 16) + $cellId2G : $cellId2G;

    // Read MCC (2 bytes)
    $mcc = unpack('n', substr($binaryString, $offset, 2))[1];
    $offset += 2;

    // Read MNC (1 byte)
    $mnc = ord($binaryString[$offset]);
    $offset += 1;

    // Read Data Serial Number (1 byte)
    $flowId = ord($binaryString[$offset]);
    $offset += 1;




    // Parse Alarm
    $fAlarm = self::parseLocationAlarm($terminalStatus);





    // Populate location data
    $location = [
        'protocolType' => $version,
        'deviceType' => $terminalType,
        'dataType' => $dataType,
        'dataLength' => $dataLen,
        'gpsTime' => $gpsZonedDateTime->format('Y-m-d H:i:s'),
        'latitude' => $lat,
        'longitude' => $lng,
        'locationType' => $locationType,
        'speed' => $speed,
        'direction' => $direction,
        'mileage' => $mileage,
        'gpsSignal' => $gpsSignal,
        'cellSignal' => $cellSignal,
        'alarm' => $fAlarm,
        'alarmArea' => $regionAlarmId,
        'battery' => $batteryPercent,
        'lockStatus' => NumberUtil::getBitValue($terminalStatus, 7) == 1 ? 0 : 1,
        'lockRope' => NumberUtil::getBitValue($terminalStatus, 6) == 1 ? 0 : 1,
        'backCover' => NumberUtil::getBitValue($terminalStatus, 13),
        'MCC' => $mcc,
        'MNC' => $mnc,
        'LAC' => $lac,
        'CELLID' => $cellId,
        'IMEI' => $imei,
        'wakeSource' => $fWakeSource,
        'index' => $flowId
    ];


    // Prepare final result
    $model = [
        'deviceID' => $terminalNum,
        'msgType' => 'Location',
        'dataBody' => $location,
        'replyMsg' => $version < 0x19 ? '(P35)' : sprintf('(P69,0,%s)', $flowId)
    ];

    return $model;
}


public static function formatGpsTime(array $gpsZonedDateTimeArray)
{
    // Ensure the date is in a Carbon instance
    $dateTime = new Carbon($gpsZonedDateTimeArray['date']);

    // Set the timezone
    $dateTime->setTimezone($gpsZonedDateTimeArray['timezone']);

    // Convert to ISO 8601 format with 'Z' for UTC timezone
    return $dateTime->format('Y-m-d\TH:i:s\Z');
}





private static function parseLocationAlarm($terminalStatus)
{
    // Trigger alarm or not
    $fAlarm = -1;

    // Acknowledge or not
    if (NumberUtil::getBitValue($terminalStatus, 5) == 1) {
        // Judgment alarm
        if (NumberUtil::getBitValue($terminalStatus, 1) == 1) {
            $fAlarm = intval(AlarmTypeEnum::LOCK_ALARM_9->getValue());
        } elseif (NumberUtil::getBitValue($terminalStatus, 2) == 1) {
            $fAlarm = intval(AlarmTypeEnum::LOCK_ALARM_10->getValue());
        } elseif (NumberUtil::getBitValue($terminalStatus, 3) == 1) {
            $fAlarm = intval(AlarmTypeEnum::LOCK_ALARM_1->getValue());
        } elseif (NumberUtil::getBitValue($terminalStatus, 4) == 1) {
            $fAlarm = intval(AlarmTypeEnum::LOCK_ALARM_2->getValue());
        } elseif (NumberUtil::getBitValue($terminalStatus, 8) == 1) {
            $fAlarm = intval(AlarmTypeEnum::LOCK_ALARM_3->getValue());
        } elseif (NumberUtil::getBitValue($terminalStatus, 9) == 1) {
            $fAlarm = intval(AlarmTypeEnum::LOCK_ALARM_4->getValue());
        } elseif (NumberUtil::getBitValue($terminalStatus, 10) == 1) {
            $fAlarm = intval(AlarmTypeEnum::LOCK_ALARM_5->getValue());
        } elseif (NumberUtil::getBitValue($terminalStatus, 11) == 1) {
            $fAlarm = intval(AlarmTypeEnum::LOCK_ALARM_6->getValue());
        } elseif (NumberUtil::getBitValue($terminalStatus, 12) == 1) {
            $fAlarm = intval(AlarmTypeEnum::LOCK_ALARM_7->getValue());
        } elseif (NumberUtil::getBitValue($terminalStatus, 14) == 1) {
            $fAlarm = intval(AlarmTypeEnum::LOCK_ALARM_8->getValue());
        } else {
            $fAlarm = -1;
        }
    }

    return $fAlarm;
}



private static function replyMessage($msgType, $itemList)
{
    $replyContent = null;

    switch ($msgType) {
        case "P22":
            // Current UTC date and time
            $currentDateTime = new DateTime('now', new DateTimeZone('UTC'));
            $formattedDateTime = $currentDateTime->format('dmYHis');
            $replyContent = sprintf("(P22,%s)", $formattedDateTime);
            break;

        case "P43":
            if ($itemList[2] == "0") {
                // Reset password
                $replyContent = "(P44,1,888888)";
            }
            break;

        case "P45":
            $replyContent = sprintf("(P69,0,%s)", $itemList[16]);
            break;

        case "P52":
            if ($itemList[2] == "2") {
                $replyContent = sprintf("(P52,2,%s)", $itemList[3]);
            }
            break;

        default:
            break;
    }

    return $replyContent;
}

/**
 * Command response reply
 * @param string $msgType
 * @param int $index
 * @return string|null
 */
public static function replyMessageByIndex($msgType, $index)
{
    $replyContent = null;

    switch ($msgType) {
        case "WLNET5":
        case "WLNET7":
            $replyContent = sprintf("(P69,0,%d)", $index);
            break;

        default:
            break;
    }

    return $replyContent;
}
















}

