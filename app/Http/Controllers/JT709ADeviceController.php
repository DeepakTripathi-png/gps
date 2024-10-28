<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\DataParserJT709A;
use App\Helpers\Constantjt709a;
use App\Services\ParserUtiljt709a;
use Carbon\Carbon;
use App\Models\AssignTrip;
use Illuminate\Support\Facades\DB;
use App\Constants\Status;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;
use App\Mail\AlertMail;
use App\Models\Location;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Http;
use App\Services\JT709AParser;


class JT709ADeviceController extends Controller
{
        // Method to handle the request based on the message ID
        
        public function handlRawData(Request $request){
            
             $strData= $request->data;
             
             $msgBodyBuf = hex2bin($strData);
            
             $parsedData= self::receiveDataBytes($msgBodyBuf);
            
             $array = json_decode($parsedData, true);
             
             $this->push_data($array);
            
            $this->tc_data($array); 
              
            $this->push_data_event($array);
            
            $response=$this->handleRequest($strData); //Response Mesage Generator
            
            return $response;
        }
        
        
        private function receiveDataBytes($bytes) {
            return  $this->receiveDataBuffer($bytes);
        }

 
        private  function receiveDataBuffer($in) {
            
            $decoded = null;
            $header = ord($in[0]);
            if ($header == Constantjt709a::TEXT_MSG_HEADER) {
                $decoded = ParserUtiljt709a::decodeTextMessage($in);
            } elseif ($header == Constantjt709a::BINARY_MSG_HEADER) {
                $decoded = ParserUtiljt709a::decodeBinaryMessage($in);
            } else {
                return null;
            }
            
            return json_encode($decoded);
        }
        
        
          
        // Method to handle the request based on the message ID
            public function handleRequest($rawData)
            {
                $processedData = $this->processEscapeCharacters($rawData);
                $messageId = substr($processedData, 2, 4);
                $response = '';
                
        
                switch ($messageId) {
                    case '0002':
                        $response = $this->handleHeartbeat($processedData);
                        break;
        
                    case '0200':
                        $response = $this->handlePositionData($processedData);
                        break;
        
                    default:
                        $response="";
                }
                return $response;
            }
        
            private function handleHeartbeat($data)
            {
                $deviceId = substr($data, 10, 12);
        
                $response = '7E8001000575' . $deviceId . '00010001000200';
        
                $xorChecksum = $this->calculateXorChecksum(substr($response, 2)); 
                $response .= $xorChecksum . '7E'; 
                
                return $response;
        
                
            }
    
            private function handlePositionData($data)
            {
                $deviceId = substr($data, 10, 12);
                $serialNumber = substr($data, 22, 4);
                
                $response = '80010005' . $deviceId .'0001' . $serialNumber . '020000';
                $xorChecksum = $this->calculateXorChecksum($response); 
                
                $response = $response.$xorChecksum ; 
                
                $replyMessage = $this->escapeSpecialCharacters($response);
                
                return strtolower('7E'.$replyMessage.'7E');
            }
        
            private function processEscapeCharacters($data)
            {
                $data = str_replace('7D02', '7E', $data);
                $data = str_replace('7D01', '7D', $data);
                return $data;
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
        //Reply Messaged form code End 
        
        
        
        
        
   
        
        
    
         public  function push_data($parsedData)
         {
            if (empty($parsedData['DataBody'])) {
                return response()->json([
                    'status' => false,
                    'message' => 'Failed to store parse raw data.'
                ], 400);
            }
            
            if($parsedData['DataBody']['LockStatus']==0){
                 $lockState="lock";
            }else{
                 $lockState="unlock";
            }
            
            
    
            
            
            
            $data = [
                'device_id'    => $parsedData['DeviceID'] ?? 0,
                'latitude'     => $parsedData['DataBody']['Latitude'] ?? null,
                'longitude'    => $parsedData['DataBody']['Longitude'] ?? null,
                'batteryLevel' => $parsedData['DataBody']['Battery'] ?? null,
                'timestamp'    => $parsedData['DataBody']['GpsTime'] ?? null,
                'speed'        => $parsedData['DataBody']['Speed'] ?? null,
                'odometer'     => $parsedData['DataBody']['Mileage'] ?? null,
                'ignition'     => $parsedData['DataBody']['LockStatus'] ?? null,
                'fault'        => $parsedData['DataBody']['Alarm'] ?? null,
                'attributes' => json_encode([
                    'batteryLevel' =>$parsedData['DataBody']['Battery']??0,
                    'odometer' => $parsedData['DataBody']['Mileage'],
                    'lock' => $lockState,
                    'ignition' => !empty($lockAlert)?$lockAlert:0,
                    'speed'=> $parsedData['DataBody']['Speed'],
                    'ip' => $parsedData['DataBody']['ip'] ?? '127.0.0.1',
                    'motion' => $parsedData['DataBody']['motion'] ?? false,
                    'hours' => $parsedData['DataBody']['hours'] ?? 0
                ]), 
                'address'      =>  $this->reverseGeocode($parsedData['DataBody']['Latitude'] ?? '', $parsedData['DataBody']['Longitude'] ?? ''),
                'created_at'   => now(),
                'updated_at'   => now(),
            ];
            
          
        
            if (DB::table('tc_data')->insert($data)) {
                return response()->json([
                    'status' => true,
                    'message' => 'Push Data saved successfully.'
                ], 200);
            }
        
            return response()->json([
                'status' => false,
                'message' => 'Failed to save push data.'
            ], 500);
        }

    
    
    
       public  function tc_data($parsedData)
       {
           
          
           
            if (empty($parsedData['DataBody'])){
                return response()->json([
                    'status' => false,
                    'message' => 'Failed to store TC Data.'
                ], 400);
            }
            
           
            $deviceData = $parsedData['DataBody'];
            $id = $parsedData['DeviceID'] ?? 0;
            $latitude = $deviceData['Latitude'] ?? '';
            $longitude = $deviceData['Longitude'] ?? '';
            $batteryLevel = $deviceData['Battery'] ?? '';
            $timestamp = $deviceData['GpsTime'] ?? '';
            $speed = $deviceData['Speed'] ?? '';
            $odometer = $deviceData['Mileage'] ?? '';
            $ignition = $deviceData['LockStatus'] ?? '';
            $fault = $deviceData['Alarm'] ?? '';
            $altitude = $deviceData['Altitude'] ?? '';
            $fenceId = $deviceData['FenceId'] ?? '';
           
            
            if($deviceData['LockStatus']==0){
                 $lockState="lock";
            }else{
                 $lockState="unlock";
            }
            
           
            
            
             
        
            $deviceId = DB::table('tc_devices')->where('uniqueid', $id)->value('id');
            
                
        
            if (!$deviceId) {
                return response()->json([
                    'status' => false,
                    'message' => 'Device not found.'
                ], 404);
            }
        
            $positionData = [
                'protocol' => 'osmand',
                'deviceid' => $deviceId,
                'servertime' => now(), 
                'devicetime' => $timestamp,
                'fixtime' => $timestamp,
                'valid' => 1,
                'attributes' => json_encode([
                    'batteryLevel' => $deviceData['Battery']??0,
                    'odometer' => $deviceData['Mileage'],
                    'lock' => $lockState,
                    'ignition' => !empty($lockAlert)?$lockAlert:0,
                    'speed'=> $deviceData['Speed'],
                    'ip' => $deviceData['ip'] ?? '127.0.0.1',
                    'motion' => $deviceData['motion'] ?? false,
                    'hours' => $deviceData['hours'] ?? 0
                ]), 
                'latitude' => $latitude,
                'longitude' => $longitude,
                'altitude' => $altitude,
                'speed' => $speed,
                'course' => 0,
                'address' =>  $this->reverseGeocode($latitude, $longitude),
                'accuracy' => 0,
                'network' => null,
                'geofenceids' => $fenceId,
            
            ];
            
             
             
             
         
             
              
                $positionId = DB::table('tc_positions')->insertGetId($positionData);
                
                
                
                DB::table('tc_devices')
                ->where('uniqueid', $parsedData['DeviceID'])
                ->update([
                    'positionid' => $positionId,
                    'status'=>'online',
                    'lastupdate' => Carbon::now('Asia/Kolkata'),
                ]);
                
                 
                
                $gpsdeviceId = DB::table('gps_devices')->where('device_id', $parsedData['DeviceID'])->value('id');
                DB::table('assign_trips')
                    ->where('trip_status', 'assign')
                     ->where('status','enable')
                    ->where('gps_devices_id', $gpsdeviceId)
                    ->update(['device_position_id' => $positionId, 'device_position_address' => $positionData['address']]);
                    
                    
                    if ($positionId){
                    return response()->json([
                        'status' => true,
                        'message' => 'Data saved successfully.'
                    ], 200);
                }            
            
            
            return response()->json([
                'status' => false,
                'message' => 'Failed to update device position.'
            ], 500);
        }

    
    
    
     public  function  reverseGeocode($latitude, $longitude)
    {
        if (is_null($latitude) || is_null($longitude)) {
            return null; 
        }
    
        $geocodingUrl = "http://address.markongps.in/nominatim/reverse?format=json&lat={$latitude}&lon={$longitude}";
    
        try {
            $response = Http::get($geocodingUrl);
            $responseData = json_decode($response->body(), true);
            $displayName = $responseData['display_name'] ?? null; // Extract display_name from the response
            return $displayName;
        } catch (\Exception $e) {
            \Log::error('Error in reverse geocoding:', ['exception' => $e]);
            return null;
        }
    }
    
    
    
    public  function push_data_event($data)
    {
        
        $deviceId = isset($data['DeviceID']) && !empty($data['DeviceID']) ? trim($data['DeviceID']) : '';
        $dataBody = isset($data['DataBody']) && !empty($data['DataBody']) ? $data['DataBody'] : null;

        if(!empty($dataBody )){
            
            $gpsTime = isset($dataBody['GpsTime']) ? trim($dataBody['GpsTime']) : '';
            $latitude = isset($dataBody['Latitude']) ? trim($dataBody['Latitude']) : '';
            $longitude = isset($dataBody['Longitude']) ? trim($dataBody['Longitude']) : '';
            $speed = isset($dataBody['Speed']) ? trim($dataBody['Speed']) : '';
            $direction = isset($dataBody['Direction']) ? trim($dataBody['Direction']) : '';
            $lockStatus = isset($dataBody['LockStatus']) ? trim($dataBody['LockStatus']) : '';
            $mileage = isset($dataBody['Mileage']) ? trim($dataBody['Mileage']) : '';
            $alarm = isset($dataBody['Alarm']) ? trim($dataBody['Alarm']) : '';
            $battery = isset($dataBody['Battery']) ? trim($dataBody['Battery']) : '';
            $voltage = isset($dataBody['Voltage']) ? trim($dataBody['Voltage']) : '';
            $gpsSignal = isset($dataBody['GpsSignal']) ? trim($dataBody['GpsSignal']) : '';
            $gsmSignal = isset($dataBody['GSMSignal']) ? trim($dataBody['GSMSignal']) : '';
            $fenceId = isset($dataBody['FenceId']) ? trim($dataBody['FenceId']) : '';
            $backCover = isset($dataBody['BackCover']) ? trim($dataBody['BackCover']) : '';
            $index = isset($dataBody['Index']) ? trim($dataBody['Index']) : '';
            $mnc = isset($dataBody['MNC']) ? trim($dataBody['MNC']) : '';
            $mcc = isset($dataBody['MCC']) ? trim($dataBody['MCC']) : '';
            $lac = isset($dataBody['LAC']) ? trim($dataBody['LAC']) : '';
            $cellId = isset($dataBody['CELLID']) ? trim($dataBody['CELLID']) : '';
            $locationType = isset($dataBody['LocationType']) ? trim($dataBody['LocationType']) : '';
            $altitude = isset($dataBody['Altitude']) ? trim($dataBody['Altitude']) : '';
            $dataLength = isset($dataBody['DataLength']) ? trim($dataBody['DataLength']) : '';
            $lockRope = isset($dataBody['LockRope']) ? trim($dataBody['LockRope']) : '';
            $rf_id_Card = isset($dataBody['CardNo']) ? trim($dataBody['CardNo']) : '0000000000';
        
        
        // Prepare JSON data
        $json = json_encode([
            'DeviceID' => $deviceId,
            'GpsTime' => $gpsTime,
            'Latitude' => $latitude,
            'Longitude' => $longitude,
            'Speed' => $speed,
            'Direction' => $direction,
            'LockStatus' => $lockStatus,
            'Mileage' => $mileage,
            'Alarm' => $alarm,
            'Battery' => $battery,
            'Voltage' => $voltage,
            'GpsSignal' => $gpsSignal,
            'GSMSignal' => $gsmSignal,
            'FenceId' => $fenceId,
            'BackCover' => $backCover,
            'Index' => $index,
            'MNC' => $mnc,
            'MCC' => $mcc,
            'LAC' => $lac,
            'CELLID' => $cellId,
            'LocationType' => $locationType,
            'Altitude' => $altitude,
            'DataLength' => $dataLength,
            'LockRope' => $lockRope
        ]);
        
            
    
        if ((isset($dataBody['LockEvent']) && !empty($dataBody['LockEvent'])) || (!empty($dataBody['Alarm']) && $dataBody['Alarm'] != -1)){
            
              
            
            
              
        if ($deviceId){
         
            // Check if the device exists in the database
            $checkDeviceExist = DB::table('gps_devices')->where('device_id', $deviceId)->first();
            
            
            
            if (!empty($checkDeviceExist)) {
                
                $admin_id = $checkDeviceExist->admin_id ?? '';
                
                $current_trip_id = $checkDeviceExist->current_trip_id ?? '';
                
                $user_data = DB::table('tbl_notification')->where('user_id', $admin_id)->take(3)->orderBy('id', 'DESC')->get();
                
                foreach ($user_data as $key => $value){
                    $device_token = $value->device_token ?? '';
                    $notificationData=  $this->send_notification($device_token,$data);
                }  
                
            } else {
                $current_trip_id = '';
            }
            
        }
        
        
      
     
        
         $formattedDate = \Carbon\Carbon::parse($gpsTime)->format('dmy');
         
         
        if(!empty($notificationData['message'])&&!empty($notificationData['title'])){
        // Insert data into tc_data_event table
        if (DB::table('tc_data_event')->insert([
            'attributes' => $json,
            'device_id' => $deviceId,
            'latitude' => $latitude,
            'longitude' => $longitude,
            'speed' => $speed,
            'direction' => $direction,
            'lock_status' => $lockStatus,
            'mileage' => $mileage,
            'time'=> $gpsTime,
            'date' =>$formattedDate,
            'rfid_card_number'=> $rf_id_Card,
            'created_at' => now(),
            'updated_at' => now(),
            'alert_naration' => $notificationData['message'],
            'trip_id' => $current_trip_id,
            'alert_title' => $notificationData['title'],
        ])){
            
             
            if ($current_trip_id && !empty($current_trip_id)) {
                
                $assign_trip_record = AssignTrip::where('trip_id', $current_trip_id)->first();
                $from_location_id = $assign_trip_record->from_destination ?? '';
                $to_destination_id = $assign_trip_record->to_destination ?? '';
                
                 
                
                 

                $query = Location::join('admins', function ($join) { 
                    $join->on(DB::raw('FIND_IN_SET(admins.id, locations.admin_id)'), '>', DB::raw('0'));
                })
                ->select('locations.*', DB::raw('GROUP_CONCAT(admins.email) AS customer_email'));
                $from_location_data = $query->find($from_location_id);
                
              
    
                $query1 = Location::join('admins', function ($join) {
                    $join->on(DB::raw('FIND_IN_SET(admins.id, locations.admin_id)'), '>', DB::raw('0'));
                })
                ->select('locations.*', DB::raw('GROUP_CONCAT(admins.email) AS customer_email'));
                $to_location_data = $query1->find($to_destination_id);
                
                  
    
                $from_location_auth = $from_location_data->customer_email ?? '';
                $to_location_auth = $to_location_data->customer_email ?? '';
    
                $mergedString = $from_location_auth . ',' . $to_location_auth;
                $emailArray = explode(',', $mergedString);
                $uniqueEmailArray = array_unique($emailArray);
                
                $mail_data = [
                    'trip_id' => $current_trip_id,
                    'type' => $notificationData['title'],
                    'created_at' => now(),
                    'address' =>  $this->reverseGeocode($latitude,$longitude),
                    'alert_naration' =>$notificationData['message'],
                    'latitude' => $latitude,
                    'longitude' => $longitude,
                ];
                
                
                foreach ($uniqueEmailArray as $key => $value) {
                    $admin_data = Admin::where('email', $value)->first();
                    $company_name = $admin_data->name ?? '';
                    $mail_data['company_name'] = $company_name;
                    try {
                        Mail::to($value)->send(new AlertMail($mail_data));
                    } catch (\Throwable $th) {
                        // Handle any errors that may occur during sending emails
                    }
                }
            }
            
         }
         
          return response()->json(['status' => true, 'message' => 'Event Data inserted successfully']);
        } 
        }
    
           return response()->json(['status' => false, 'message' => 'Event Data not inserted']);
        }
    }
    

        public  function send_notification($device_token, $data)
        {
            $title = '';
            $message = '';
            $new_msg = '';
            
            $data= $this->generateMessage($data);
            
            $new_msg = $data['title'] . ' / ' . $data['message'];
            
            // Send notification if conditions are met
            if (!empty($device_token) && !empty($new_msg)) {
               $this->android($device_token, $data['message'], $data['title']);
            }
            
            return $data;
        }
        
        
        
        
        public  function android($device_token, $message, $title)
        {
            $url = "https://fcm.googleapis.com/fcm/send";
            $API_key = "AAAAxZXxoec:APA91bHAdKNO-7Ffya8craUklfvGIqhN1jiVfTLwePj7JZvWj7uvpFvo5MOtKxhFF-9-WWshp1DbrCpJbd11XgERra8fGHhPsIgE32lF5HIp2fXZBDBcIqag3qK0yv-3E772-ip-YMEl";
        
            $msg = array(
                'body' => $message,
                'title' => $title,
                'sound' => 'https://gpspackseal.in/alert/alarm1.mp3'
            );
        
            $arrayToSend = array(
                'data' => $msg,
                'to' => $device_token,
                'notification' => array(
                    'title' => $title,
                    'text' => $message,
                    'badge' => '0',
                    'priority' => 'high'
                )
            );
        
            $json = json_encode($arrayToSend);
            $headers = array(
                'Authorization: key=' . $API_key,
                'Content-Type: application/json'
            );
        
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
            $result = curl_exec($ch);
            curl_close($ch);
        }
        
         public function generateMessage($data)
         {
            if (empty($data['DataBody'])) {
                return null;
            }
            
            $message = [];
            $message['DeviceID'] = $data['DeviceID'];
            $message['DataBody'] = [];
        
            // Status Mapping Helper
            $statusMapping = function ($value, $map, $default = 'Unknown status'){
                return isset($map[$value]) ? $map[$value] : $default;
            };
        
            // Maps for Alarm and Event
            $alarmMap = [
                -1 => 'No alarm', 
                1 => 'Overspeed alarm', 
                2 => 'Low power alarm', 
                3 => 'Back cover open alarm', 
                4 => 'Entering the fence alarm', 
                5 => 'Exiting the fence alarm'
            ];
        
           $eventMap = [
                    1 => 'Unlock with a fixed password from a distance',
                    2 => 'Unlock with a changing password from a distance',
                    3 => 'Unlock with a changing password using the app on-site (Bluetooth or WIFI)',
                    5 => 'Unlock with a fixed password using the app on-site (Bluetooth or WIFI)',
                    6 => 'Wrong fixed password for unlocking from a distance',
                    7 => 'Wrong changing password for unlocking from a distance',
                    8 => 'Wrong changing password for unlocking using the app on-site (Bluetooth or WIFI)',
                    11 => 'Long unlock event',
                    12 => 'Event of cutting the lock rope',
                    13 => 'Lock events (automatically locked)',
                    16 => 'Problem with remote unlocking, and unlocking not done without location',
                    17 => 'Problem with remote unlocking, and unlocking not done if outside the area',
                    18 => 'Motor problem',
                    24 => 'Problem with unlocking via Bluetooth, and unlocking not done without location',
                    25 => 'Problem with Bluetooth unlocking, and unlocking not done if outside the area',
                    28 => 'Unlock and pull out the lock rope',
                    30 => 'Unlock with SMS using a fixed password from a distance',
                    31 => 'Unlock with SMS using a changing password from a distance',
                    32 => 'Wrong SMS for changing password',
                    34 => 'Swipe the authorization card to unlock',
                    35 => 'Swipe illegal card to unlock',
                    40 => 'Wrong fixed password for unlocking using the app on-site (Bluetooth or WIFI)',
                    41 => 'Wrong SMS for fixed password unlocking',
                    42 => 'RFID unlocking has a problem and does not unlock without location',
                    43 => 'RFID unlocking has a problem, does not unlock if outside the area'
                ];

        
            // Generate Notification
            return $this->generateNotification([
                'DeviceID' => $data['DeviceID'],
                'DataBody' => [
                    'AlarmData' => [
                        'Alarm' => $statusMapping($data['DataBody']['Alarm'], $alarmMap, 'Alarm triggered')
                    ],
                    'EventData' => [
                        'EventType' => $statusMapping($data['DataBody']['LockEvent']['Type'] ?? null, $eventMap, 'Unknown event type'),
                        'FenceId' => $data['DataBody']['LockEvent']['FenceId'] ?? null,
                        'UnLockStatus' => $data['DataBody']['LockEvent']['UnLockStatus'] ?? null,
                        'Password' => $data['DataBody']['LockEvent']['Password'] ?? null,
                        'CardNo' => $data['DataBody']['LockEvent']['CardNo'] ?? null
                    ]
                ]
            ]);
        }

        public function generateNotification($data)
        {
            if (empty($data['DataBody'])) {
                return ['title' => null, 'message' => null];
            }
        
            $alarm = $data['DataBody']['AlarmData']['Alarm'];
            $event_type = $data['DataBody']['EventData']['EventType'];
            $fence_id = $data['DataBody']['EventData']['FenceId'];
            $unlock_status = $data['DataBody']['EventData']['UnLockStatus'];
            $password = $data['DataBody']['EventData']['Password'];
            $card_no = $data['DataBody']['EventData']['CardNo'];
        
            $title = "";
            $message = "";
        
            if ($alarm !== 'No alarm' && $alarm !== 'Unknown status') {
                $title = 'Alarm Triggered';
                $message = "$alarm";
                if ($fence_id) {
                    $message .= ' at fence ' . $fence_id;
                }
            }
        
            if ($event_type !== 'Unknown event type') {
                $title = 'Event Detected';
                $message = "$event_type";
                if ($fence_id) {
                    $message .= ' at fence ' . $fence_id;
                }
                if ($password) {
                    $message .= ' with password ' . $password;
                }
                if ($card_no) {
                    $message .= ' using card ' . $card_no;
                }
            }
        
            if (empty($title) && empty($message)) {
                return null;
            }
        
            return ['title' => $title, 'message' => $message];
        }






            
        
        
        
}
