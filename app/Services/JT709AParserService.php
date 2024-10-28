<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;

class JT709AParser
{
    private $rawData;

    public function __construct($rawData)
    {
        $this->rawData = $rawData;
    }
    
    public function parse()
    {
        $this->removePacketHeaderAndEnd();
        $this->restoreEscapeCharacters();
        $response = $this->parseMessage();
        return  $response;
    }

    private function removePacketHeaderAndEnd()
    {
        $this->rawData = substr($this->rawData, 1, -1);
    }

    private function restoreEscapeCharacters()
    {
        $this->rawData = str_replace('7D 02', '7E', $this->rawData);
        $this->rawData = str_replace('7D 01', '7D', $this->rawData);
    }

    private function parseMessage()
    {
        $messageId = substr($this->rawData, 0, 4);
        $this->rawData = substr($this->rawData, 4);

        switch ($messageId) {
            case '0002':
                $response = $this->parseHeartbeatMessage();
                break;
            case '0200':
                $response = $this->parsePositionMessage();
                break;
            case '0300':
                $response = $this->parseAlarmMessage();
                break;
            case '0400':
                $response = $this->parseCommandMessage();
                break;
            default:
                Log::info('Unknown message ID: ' . $messageId);
                 $response=null;
                break;
        }
        
        return $response;
    }

    private function parseHeartbeatMessage()
    {
        $deviceId = substr($this->rawData, 0, 12);
        $this->rawData = substr($this->rawData, 12);

        $response = [
            'DeviceID' => $deviceId,
            'MsgType' => 'heartbeat',
        ];

      return  $response;
    }

    private function parsePositionMessage()
    {
        $deviceId = substr($this->rawData, 0, 12);
        $this->rawData = substr($this->rawData, 12);

        $gpsTime = substr($this->rawData, 0, 14);
        $this->rawData = substr($this->rawData, 14);

        $latitude = substr($this->rawData, 0, 8);
        $this->rawData = substr($this->rawData, 8);

        $longitude = substr($this->rawData, 0, 8);
        $this->rawData = substr($this->rawData, 8);

        $mcc = substr($this->rawData, 0, 2);
        $this->rawData = substr($this->rawData, 2);

        $mnc = substr($this->rawData, 0, 2);
        $this->rawData = substr($this->rawData, 2);

        $lac = substr($this->rawData, 0, 4);
        $this->rawData = substr($this->rawData, 4);

        $cellId = substr($this->rawData, 0, 4);
        $this->rawData = substr($this->rawData, 4);

        $fenceId = substr($this->rawData, 0, 2);
        $this->rawData = substr($this->rawData, 2);

        $backCover = substr($this->rawData, 0, 1);
        $this->rawData = substr($this->rawData, 1);

        $index = substr($this->rawData, 0, 4);
        $this->rawData = substr($this->rawData, 4);

        $awaken = substr($this->rawData, 0, 1);
        $this->rawData = substr($this->rawData, 1);

        $protocolVersion = substr($this->rawData, 0, 1);
        $this->rawData = substr($this->rawData, 1);

        $direction = substr($this->rawData, 0, 3);
        $this->rawData = substr($this->rawData, 3);

        $battery = substr($this->rawData, 0, 2);
        $this->rawData = substr($this->rawData, 2);

        $gpsSignal = substr($this->rawData, 0, 1);
        $this->rawData = substr($this->rawData, 1);

        $voltage = substr($this->rawData, 0, 4);
        $this->rawData = substr($this->rawData, 4);

        $speed = substr($this->rawData, 0, 3);
        $this->rawData = substr($this->rawData, 3);

        $lockStatus = substr($this->rawData, 0, 1);
        $this->rawData = substr($this->rawData, 1);

        $lockRope = substr($this->rawData, 0, 1);
        $this->rawData = substr($this->rawData, 1);

        $mileage = substr($this->rawData, 0, 8);
        $this->rawData = substr($this->rawData, 8);

        $alarm = substr($this->rawData, 0, 2);
        $this->rawData = substr($this->rawData, 2);

        $dataLength = substr($this->rawData, 0, 2);
        $this->rawData = substr($this->rawData, 2);

        $locationType = substr($this->rawData, 0, 1);
        $this->rawData = substr($this->rawData, 1);

        $altitude = substr($this->rawData, 0, 4);
        $this->rawData = substr($this->rawData, 4);

        $gsmSignal = substr($this->rawData, 0, 2);
        $this->rawData = substr($this->rawData, 2);

        $response = [
            'DeviceID' => $deviceId,
            'DataBody' => [
                'GpsTime' => $gpsTime,
                'Latitude' => $latitude,
                'Longitude' => $longitude,
                'MCC' => $mcc,
                'MNC' => $mnc,
                'LAC' => $lac,
                'CELLID' => $cellId,
                'FenceId' => $fenceId,
                'BackCover' => $backCover,
                'Index' => $index,
                'Awaken' => $awaken,
                'ProtocolVersion' => $protocolVersion,
                'Direction' => $direction,
                'Battery' => $battery,
                'GpsSignal' => $gpsSignal,
                'Voltage' => $voltage,
                'Speed' => $speed,
                'LockStatus' => $lockStatus,
                'LockRope' => $lockRope,
                'Mileage' => $mileage,
                'Alarm' => $alarm,
                'DataLength' => $dataLength,
                'LocationType' => $locationType,
                'Altitude' => $altitude,
                'GSMSignal' => $gsmSignal,
            ],
            'ReplyMsg' => $this->generatePlatformResponseForLocation($deviceId, 0200),
            'MsgType' => 'Location',
        ];

       return $response;
    }

    private function parseAlarmMessage()
    {
        $deviceId = substr($this->rawData, 0, 12);
        $this->rawData = substr($this->rawData, 12);

        $alarmType = substr($this->rawData, 0, 2);
        $this->rawData = substr($this->rawData, 2);

        $alarmData = substr($this->rawData, 0, 8);
        $this->rawData = substr($this->rawData, 8);

        $response = [
            'DeviceID' => $deviceId,
            'DataBody' => [
                'AlarmType' => $alarmType,
                'AlarmData' => $alarmData,
            ],
            'ReplyMsg' => $this->generatePlatformResponse($deviceId, $alarmType),
            'MsgType' => 'Alarm',
        ];

     return $response;
    }

    private function parseCommandMessage()
    {
        $deviceId = substr($this->rawData, 0, 12);
        $this->rawData = substr($this->rawData, 12);

        $commandType = substr($this->rawData, 0, 2);
        $this->rawData = substr($this->rawData, 2);

        $commandData = substr($this->rawData, 0, 8);
        $this->rawData = substr($this->rawData, 8);

        $response = [
            'DeviceID' => $deviceId,
            'DataBody' => [
                'CommandType' => $commandType,
                'CommandData' => $commandData,
            ],
            'ReplyMsg' => $this->generatePlatformResponse($deviceId, $commandType),
            'MsgType' => 'Command',
        ];

       return $response;
    }

    private function generatePlatformResponse($deviceId, $msgType)
    {
        $platformResponse = [
            'MessageID' => '8001',
            'DeviceID' => $deviceId,
            'SerialNumber' => '0001',
            'Result' => '0',
            'ReplyMessageID' => $msgType,
        ];

        return $this->encodePlatformResponse($platformResponse);
    }


    private function encodePlatformResponse($platformResponse)
    {
        $encodedResponse = '7E' . $platformResponse['MessageID'] . $platformResponse['DeviceID'] . $platformResponse['SerialNumber'] . $platformResponse['Result'] . $platformResponse['ReplyMessageID'] . '7E';

        return $encodedResponse;
    }



    private function generatePlatformResponseForLocation($deviceId, $messageId)
    {
        $platformResponse = [
            'MessageID' => '8001',
            'DeviceID' => $deviceId,
            'SerialNumber' => '0001',
            'Result' => '00',
            'ReplyMessageID' => $messageId,
        ];

        return $this->encodePlatformResponseForLocation($platformResponse);
    }

    private function encodePlatformResponseForLocation($platformResponse)
    {
        $encodedResponse = '7E' . $platformResponse['MessageID'] . $platformResponse['DeviceID'] . $platformResponse['SerialNumber'] . $platformResponse['Result'] . '7D7E' . $platformResponse['ReplyMessageID'] . '00' . $this->calculateXORChecksum($platformResponse) . '7E';

        return $encodedResponse;
    }

    private function calculateXORChecksum($platformResponse)
    {
        $checksum = 0;
        $data = $platformResponse['MessageID'] . $platformResponse['DeviceID'] . $platformResponse['SerialNumber'] . $platformResponse['Result'] . '7D7E' . $platformResponse['ReplyMessageID'] . '00';
        for ($i = 0; $i < strlen($data); $i++) {
            $checksum ^= ord($data[$i]);
        }
        return sprintf('%02X', $checksum);
    }
}