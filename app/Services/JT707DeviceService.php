<?php

namespace App\Services;

class JT707DeviceService
{
    private $dataMap = [
        'heartbeat' => [
            'DeviceID' => 'deviceId',
            'MsgType' => 'heartbeat'
        ],
        'location' => [
            'DeviceID' => 'deviceId',
            'DataBody' => [
                'Index' => 'index',
                'DataLength' => 'dataLength',
                'GpsTime' => 'gpsTime',
                'Latitude' => 'latitude',
                'Longitude' => 'longitude',
                'Temperature' => 'temperature',
                'UnLockTime' => 'unLockTime',
                'RunStatus' => 'runStatus',
                'Awaken' => 'awaken',
                'SimStatus' => 'simStatus',
                'Direction' => 'direction',
                'Battery' => 'battery',
                'GpsSignal' => 'gpsSignal',
                'Voltage' => 'voltage',
                'Speed' => 'speed',
                'LockStatus' => 'lockStatus',
                'LockRope' => 'lockRope',
                'Mileage' => 'mileage',
                'MCC' => 'mcc',
                'MNC' => 'mnc',
                'LAC' => 'lac',
                'CELLID' => 'cellId',
                'LocationType' => 'locationType',
                'SendDataCount' => 'sendDataCount',
                'GSMSignal' => 'gsmSignal'
            ],
            'ReplyMsg' => 'replyMessage',
            'MsgType' => 'Location'
        ],
        'command' => [
            'DeviceID' => 'deviceId',
            'DataBody' => 'commandBody',
            'ReplyMsg' => '',
            'MsgType' => 'commandType'
        ]
    ];

    public function parse($rawData)
    {
        
        $rawData = $this->processEscapeCharacters(strtoupper($rawData));
        
        
       $messageType = $this->identifyMessageType($rawData);
       
        switch ($messageType) {
            case 'heartbeat':
                return $this->parseHeartbeat($rawData);
            case 'location':
                return $this->parseLocation($rawData);
            case 'command':
                return $this->parseCommand($rawData);
            default:
                throw new \Exception('Unknown message type');
        }
    }
    
   private function processEscapeCharacters($data)
   {
        $data = str_replace('7D02', '7E', $data);
        $data = str_replace('7D01', '7D', $data);
        return $data;
    }
    


    private function identifyMessageType($rawData)
    {
        $messageId = substr($rawData, 2, 4);
        
        switch ($messageId) {
            case '0002':
                return 'heartbeat';
            case '0200':
                return 'location';
            default:
                return 'command';
        }
    }

    private function parseHeartbeat($rawData)
    {
        $deviceId = substr($rawData, 10, 12);
        
        return [
            'DeviceID' => $deviceId,
            'MsgType' => 'heartbeat'
        ];
    }

    private function parseLocation($rawData)
    {
       
        
        $deviceId = substr($rawData, 10, 12);
        $dataBody = $this->extractDataBody($rawData);
        $replyMessage = $this->generateReplyMessage($rawData);
        
        return [
            'DeviceID' => $deviceId,
            'DataBody' => $dataBody,
            'ReplyMsg' => $replyMessage,
            'MsgType' => 'Location'
        ];
    }

    private function parseCommand($rawData)
    {
        if (!ctype_xdigit($rawData)) {
            return 'Invalid Hexadecimal Input';
        }
        $commandBody = hex2bin($rawData);
    
        if ($commandBody === false) {
            return 'Failed to convert hex to ASCII';
        }
    
        $commandParts = explode(',', trim($commandBody, '()'));
    
        $deviceId = $commandParts[0] ?? 'Unknown DeviceID';
    
        $dataBody = '(' . implode(',', $commandParts) . ')';
    
        $msgType = isset($commandParts[3], $commandParts[4]) ? $commandParts[3] . $commandParts[4] : 'Unknown MsgType';
        
        return [
            'DeviceID' => $deviceId,
            'DataBody' => $dataBody,
            'ReplyMsg' => '',
            'MsgType' => $msgType
        ];
    }

    // private function extractDataBody($rawData)
    // {
        
    //     $dataBody = [];
    //     $dataLength=hexdec(substr($rawData, 8, 2));
    //     $index=hexdec(substr($rawData, 22, 4));
    //     $rawData = substr($rawData, 26); 
        
    //     $dataBody['Index'] = $index;
    //     $dataBody['DataLength'] = $dataLength;
    //     $dataBody['GpsTime'] = $this->extractGpsTime($rawData);
    //     $dataBody['Latitude'] = $this->extractLatitude($rawData);
    //     $dataBody['Longitude'] = $this->extractLongitude($rawData);
    //     $dataBody['Temperature'] = $this->extractTemperature($rawData);
    //     $dataBody['UnLockTime'] = $this->extractUnLockTime($rawData);
    //                               $this->extractRunstatusSimStatusLockStatusAwaken($rawData)
        
    //     // $dataBody['RunStatus'] = $this->extractRunStatus($rawData);
    //     // $dataBody['Awaken'] = $this->extractAwaken($rawData);
    //     // $dataBody['SimStatus'] = $this->extractSimStatus($rawData);
    //     $dataBody['Direction'] = $this->extractDirection($rawData);
    //     $dataBody['Battery'] = $this->extractBattery($rawData);
    //     $dataBody['GpsSignal'] = $this->extractGpsSignal($rawData);
    //     $dataBody['Voltage'] = $this->extractVoltage($rawData);
    //     $dataBody['Speed'] = $this->extractSpeed($rawData);
    //     // $dataBody['LockStatus'] = $this->extractLockStatus($rawData);
    //     $dataBody['LockRope'] = $this->extractLockRope($rawData);
    //     $dataBody['Mileage'] = $this->extractMileage($rawData);
    //     $dataBody['MCC'] = $this->extractMCC($rawData);
    //     $dataBody['MNC'] = $this->extractMNC($rawData);
    //     $dataBody['LAC'] = $this->extractLAC($rawData);
    //     $dataBody['CELLID'] = $this->extractCELLID($rawData);
    //     $dataBody['LocationType'] = $this->extractLocationType($rawData);
    //     $dataBody['SendDataCount'] = $this->extractSendDataCount($rawData);
    //     $dataBody['GSMSignal'] = $this->extractGSMSignal($rawData);

    //     return $dataBody;
    // }
    
    
    private function extractDataBody($rawData)
    {
        $dataBody = [];
        $dataLength = hexdec(substr($rawData, 8, 2));
        $index = hexdec(substr($rawData, 22, 4));
        $rawData = substr($rawData, 26); 
    
        $dataBody['Index'] = $index;
        $dataBody['DataLength'] = $dataLength;
        $dataBody['GpsTime'] = $this->extractGpsTime($rawData);
        $dataBody['Latitude'] = $this->extractLatitude($rawData);
        $dataBody['Longitude'] = $this->extractLongitude($rawData);
        $dataBody['Temperature'] = $this->extractTemperature($rawData);
        $dataBody['UnLockTime'] = $this->extractUnLockTime($rawData);
    
        // Extracting run status, sim status, lock status, and awaken
        $runStatusData = $this->extractRunstatusSimStatusLockStatusAwaken($rawData);
        $dataBody = array_merge($dataBody, $runStatusData['DataBody']);
    
        $dataBody['Direction'] = $this->extractDirection($rawData);
        $dataBody['Battery'] = $this->extractBattery($rawData);
        $dataBody['GpsSignal'] = $this->extractGpsSignal($rawData);
        $dataBody['Voltage'] = $this->extractVoltage($rawData);
        $dataBody['Speed'] = $this->extractSpeed($rawData);
        $dataBody['LockStatus'] = $this->extractLockStatus($rawData);
        $dataBody['Mileage'] = $this->extractMileage($rawData);
        $dataBody['MCC'] = $this->extractMCC($rawData);
        $dataBody['MNC'] = $this->extractMNC($rawData);
        $dataBody['LAC'] = $this->extractLAC($rawData);
        $dataBody['CELLID'] = $this->extractCELLID($rawData);
        $dataBody['LocationType'] = $this->extractLocationType($rawData);
        $dataBody['SendDataCount'] = $this->extractSendDataCount($rawData);
        $dataBody['GSMSignal'] = $this->extractGSMSignal($rawData);
    
        return $dataBody;
    }
    
    

    private function extractIndex($rawData) {
        return hexdec(substr($rawData, 81, 2)); 
    }
    
    private function extractGpsTime($rawData) {
        $year = "20" . substr($rawData, 44, 2);
        $month = substr($rawData, 46, 2);
        $day = substr($rawData, 48, 2);
        $hour = substr($rawData, 50, 2);
        $minute = substr($rawData, 52, 2);
        $second = substr($rawData, 54, 2);
        return sprintf("%s-%s-%sT%s:%s:%sZ", $year, $month, $day, $hour, $minute, $second);     
    }

        private function extractLatitude($rawData) {
            $latHex = substr($rawData, 16, 8);
           
            return hexdec($latHex) / 1000000;    
        }
    
         private function extractLongitude($rawData) {
            $lonHex = substr($rawData, 24, 8);
      
            return hexdec($lonHex) / 1000000;    
        }

    private function extractTemperature($rawData) {
        return hexdec(substr($rawData, 141, 2));         
    }

    private function extractUnLockTime($rawData) {
        return hexdec(substr($rawData, 86, 4));         
    }

    private function extractRunStatus($rawData) {
        return hexdec(substr($rawData, 110, 2));       
    }

    private function extractAwaken($rawData) {
        return hexdec(substr($rawData, 40, 2));   
    }

    private function extractSimStatus($rawData) {
        return hexdec(substr($rawData, 42, 2));     
    }

    private function extractDirection($rawData) {
        return hexdec(substr($rawData, 40, 4));   
    }

    private function extractBattery($rawData) {
        return hexdec(substr($rawData, 72, 2));   
    }

    private function extractGpsSignal($rawData) {
        return hexdec(substr($rawData, 66, 2));   
    }

    private function extractVoltage($rawData) {
        return hexdec(substr($rawData, 78, 4)) / 100;  
    }

    private function extractSpeed($rawData) {
        $hexSpeed = substr($rawData, 36, 4); 
        $decimalSpeed = hexdec($hexSpeed)/10;   
        return $decimalSpeed;
    }


    private function extractLockStatus($rawData) {
        return hexdec(substr($rawData, 120, 2));    
    }

    private function extractLockRope($rawData) {
        return hexdec(substr($rawData, 122, 2));    
    }

    private function extractMileage($rawData) {
        return hexdec(substr($rawData, 124, 4));   
    }

    private function extractMCC($rawData) {
        return hexdec(substr($rawData, 116, 4));   
    }

    private function extractMNC($rawData) {
        return hexdec(substr($rawData, 120, 2)); 
    }

    private function extractLAC($rawData) {
        return hexdec(substr($rawData, 130, 4));   
    }

    private function extractCELLID($rawData) {
        return hexdec(substr($rawData, 122, 8));  
    }

    private function extractLocationType($rawData) {
        return hexdec(substr($rawData, 80, 2));       
    }

    private function extractSendDataCount($rawData) {
        return hexdec(substr($rawData, 96, 4));       
    }

    private function extractGSMSignal($rawData) {
        return hexdec(substr($rawData, 60, 2));    
    }
    
    
    private function extractRunstatusSimStatusLockStatusAwaken($rawData)
    {
        $hexValue = substr($rawData, 90, 2);
        $binaryValue = str_pad(decbin(hexdec($hexValue)), 8, '0', STR_PAD_LEFT);
    
        $bit0 = $binaryValue[7]; 
        $bit1 = $binaryValue[6]; 
        $bit2 = $binaryValue[5]; 
        $bits_3_5 = bindec(substr($binaryValue, 2, 3)); 
    
        return [
            "DataBody" => [
                "RunStatus" => (int)$bit1, 
                "SimStatus" => (int)$bit2, 
                "LockRope" => (int)$bit0,     
                "Awaken" => $bits_3_5
            ],
        ];
    }
    
    
    

    private function generateReplyMessage($rawData) {
        $deviceId = substr($rawData, 10, 12);
        $serialNumber = substr($rawData, 22, 4);
        $response="8001"."0005".$deviceId."0001".$serialNumber."020000";
        $checkCode = $this->calculateXorChecksum($response);
        
        $replyMessage = $response.$checkCode;
        
        $replyMessage = $this->escapeSpecialCharacters($replyMessage);
        
        return strtolower('7E'.$replyMessage.'7E');
    }
    
    private function calculateXorChecksum($data)
    {
        $bytes = str_split($data, 2); 
        $xor = 0;

        foreach ($bytes as $byte) {
            $xor ^= hexdec($byte); 
        }
        return strtoupper(str_pad(dechex($xor), 2, '0', STR_PAD_LEFT));
    }

   
    private function escapeSpecialCharacters($message) {
        $message = str_replace('7E', '7D02', $message);
        $message = str_replace('7D', '7D01', $message);
        
        return $message;
    }

    private function extractCommandBody($rawData) {
        $commandBody = substr($rawData, 15); 
        
        $commandBody = substr($commandBody, 1, -1);
        
        return $commandBody;
    }

   
}