<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\SocketData; 
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;
use Exception;
use Illuminate\Support\Facades\DB;
use App\Models\AssignTrip;
use App\Constants\Status;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;
use App\Mail\AlertMail;
use App\Models\Location;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class JT701DeviceController extends Controller
{
    
     public function handleSocketData(Request $request)
    {
        $rawData = $request->data;
        
        if (Str::startsWith($rawData, '24')) {
            
            $parsedData = $this->parseData($rawData);
            
            $prcessresult= $this->processParsedData($parsedData);
            
            return $prcessresult;
            
        } elseif (Str::startsWith($rawData, '283830')) {
            $asciiData = $this->handleAsciiData($rawData);
            
            return $asciiData;
        }
    }
    

    function convertLatToDecimal($lat) {
        $latDegrees = floor($lat / 1000000);
        $latMinutes = (($lat % 1000000) / 10000) / 60.0;
        return $latDegrees + $latMinutes;
    }

    function convertLonToDecimal($lon) {
        $lonDegrees = floor($lon / 1000000);
        $lonMinutes = (($lon % 1000000) / 10000) / 60.0;
        return $lonDegrees + $lonMinutes;
    }
    
    function parseData($rawData) {
        
        $packetType = substr($rawData, 0, 2);
        $id = substr($rawData, 2, 10);
        $protocolType = substr($rawData, 12, 2);
        $deviceType = substr($rawData, 14, 1);
        $dataType = substr($rawData, 15, 1);
        $packetLength = hexdec(substr($rawData, 16, 4));
        $date = substr($rawData, 20, 6);
        $time = substr($rawData, 26, 6);
        $latitude = substr($rawData, 32, 8);
        $longitude = substr($rawData, 40, 9);
        $directionIndicator = substr($rawData, 49, 1);
        $speed = substr($rawData, 50, 2);
        $direction = substr($rawData, 52, 2);
        $mileage = hexdec(substr($rawData, 54, 8));
        $satellite = substr($rawData, 62, 2);
        $vehicleNumber = substr($rawData, 64, 8);
        $deviceStatus = substr($rawData, 72, 4);
        $batteryLevel = hexdec(substr($rawData, 76, 2));
        $cellID = substr($rawData, 78, 8);
        $gsmSignal = substr($rawData, 86, 2);
        $fenceAlarm = substr($rawData, 88, 2);
        $expandDeviceStatus = substr($rawData, 90, 2);
        $reserved = substr($rawData, 92, 2);
        $imeiReserved = substr($rawData, 94, 18);
        $cellID2 = substr($rawData, 112, 4);
        $mcc = substr($rawData, 116, 4);
        $mnc = substr($rawData, 120, 2);
        $dataFrameNumber = hexdec(substr($rawData, 122, 2));
    
        $latitudeDecimal = $this->convertLatToDecimal((int)$latitude);
        $longitudeDecimal = $this->convertLonToDecimal((int)$longitude);
    
        return [
            'packetType' => $packetType,
            'id' => $id,
            'protocolType' => $protocolType,
            'deviceType' => $deviceType,
            'dataType' => $dataType,
            'packetLength' => $packetLength,
            'date' => $date,
            'time' => $time,
            'latitudeDecimal' => round($latitudeDecimal, 6),
            'latitude' => $latitude,
            'longitudeDecimal' => round($longitudeDecimal, 6),
            'longitude' => $longitude,
            'directionIndicator' => $directionIndicator,
            'speed' => $speed,
            'direction' => $direction,
            'mileage' => $mileage,
            'satellite' => $satellite,
            'vehicleNumber' => $vehicleNumber,
            'deviceStatus' => $deviceStatus,
            'batteryLevel' => $batteryLevel,
            'cellID' => $cellID,
            'gsmSignal' => $gsmSignal,
            'fenceAlarm' => $fenceAlarm,
            'expandDeviceStatus' => $expandDeviceStatus,
            'reserved' => $reserved,
            'imeiReserved' => $imeiReserved,
            'cellID2' => $cellID2,
            'mcc' => $mcc,
            'mnc' => $mnc,
            'dataFrameNumber' => $dataFrameNumber
        ];
    }


    public function processParsedData($parsedData)
    {
       
        $packetType = $parsedData['packetType'];
        $dataFrameNumber = $parsedData['dataFrameNumber'];
        $vin = trim($parsedData['vehicleNumber']);
        $response = "(P69,0,{$dataFrameNumber})";
        
        $rawDate = $parsedData['date']; 
        $rawTime = $parsedData['time']; 
        
        $day = substr($rawDate, 0, 2);   
        $month = substr($rawDate, 2, 2); 
        $year = substr($rawDate, 4, 2);  
        
        $year = '20' . $year; 
        $hours = substr($rawTime, 0, 2);   
        $minutes = substr($rawTime, 2, 2); 
        $seconds = substr($rawTime, 4, 2); 
        
        $formattedDateTime = "{$year}-{$month}-{$day} {$hours}:{$minutes}:{$seconds}";
        
        $timestamp = date('Y-m-d H:i:s', strtotime($formattedDateTime));
        
    
     
        $deviceStatus = (int) base_convert($parsedData['deviceStatus'], 16, 10);
        
       
        $deviceStatusBits = array_map(function ($i) use ($deviceStatus) {
            return ($deviceStatus >> $i) & 1;
        }, range(0, 15));
    
        $mappedData = [
            'id' => $parsedData['id'],
            'latitude' => $parsedData['latitudeDecimal'],
            'longitude' => $parsedData['longitudeDecimal'],
            'batteryLevel' => $parsedData['batteryLevel'],
            'timestamp' => $timestamp,
            'vin' => $vin,
            'speed' => $parsedData['speed'],
            'odometer' => $parsedData['mileage'],
            'geofenceEnter' => $deviceStatusBits[15],
            'geofenceExit' => $deviceStatusBits[14],
            'powerCut' => $deviceStatusBits[13],
            'vibration' => $deviceStatusBits[12],
            'fallDown' => $deviceStatusBits[11],
            'ignition' => $deviceStatusBits[10],
            'jamming' => $deviceStatusBits[9],
            'tow' => $deviceStatusBits[8],
            'removing' => $deviceStatusBits[7],
            'lowBattery' => $deviceStatusBits[6],
            'tampering' => $deviceStatusBits[5],
            'powerRestored' => $deviceStatusBits[4],
            'fault' => $deviceStatusBits[3],
            'bit14' => $deviceStatusBits[2],
            'bit15' => $deviceStatusBits[1],
            'bit16' => $deviceStatusBits[0],
            'address' => $this->reverseGeocode($parsedData['latitudeDecimal'], $parsedData['longitudeDecimal']),
        ];
    
        if ($parsedData['dataType'] == '2') {
             $this->push_data($mappedData);
        }
    
        $lockState = $deviceStatusBits[7] === 0 ? 'unlock' : 'lock';
        $lockAlert = $deviceStatusBits[7] === 0 ? 'true' : 'false';
    
        try {
            $deviceId = DB::table('tc_devices')->where('uniqueid', $parsedData['id'])->value('id');
    
            $positionData = [
                'protocol' => 'osmand',
                'deviceid' => $deviceId,
                'servertime' => Carbon::now(),
                'devicetime' => $timestamp,
                'fixtime' => $timestamp,
                'valid' => $parsedData['valid'] ?? 1,
                'latitude' => $parsedData['latitudeDecimal'],
                'longitude' => $parsedData['longitudeDecimal'],
                'altitude' => $parsedData['altitude'] ?? 0,
                'speed' => $parsedData['speed'] ?? 0,
                'course' => $parsedData['course'] ?? 0,
                'address' => $mappedData['address'],
                'attributes' => json_encode([
                    'batteryLevel' => $parsedData['batteryLevel'],
                    'vin' => $vin,
                    'odometer' => $parsedData['mileage'],
                    'lock' => $lockState,
                    'ignition' => $lockAlert,
                    'distance' => $parsedData['distance'] ?? 0,
                    'totalDistance' => $parsedData['totalDistance'] ?? 0,
                    'ip' => $parsedData['ip'] ?? '127.0.0.1',
                    'motion' => $parsedData['motion'] ?? false,
                    'hours' => $parsedData['hours'] ?? 0
                ]),
                'accuracy' => $parsedData['accuracy'] ?? 0,
                'network' => $parsedData['network'] ?? null,
                'geofenceids' => $parsedData['geofenceids'] ?? null,
            ];
    
        //   if (!empty($parsedData['latitudeDecimal']) && !empty($parsedData['longitudeDecimal']) && $parsedData['latitudeDecimal'] != 0 && $parsedData['longitudeDecimal'] != 0) {
              
                $positionId = DB::table('tc_positions')->insertGetId($positionData);
                
                DB::table('tc_devices')
                ->where('uniqueid', $parsedData['id'])
                ->update([
                    'positionid' => $positionId,
                    'status'=>'online',
                    'lastupdate' => now()
                ]);
                
                $gpsdeviceId = DB::table('gps_devices')->where('device_id', $parsedData['id'])->value('id');
                DB::table('assign_trips')
                    ->where('trip_status', 'assign')
                     ->where('status','enable')
                    ->where('gps_devices_id', $gpsdeviceId)
                    ->update(['device_position_id' => $positionId, 'device_position_address' => $mappedData['address']]);
        // }

    
           
    
            return response()->json(['message' => $response], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error inserting data'], 500);
        }
    }
    
    
    
    public function push_data(Request $request)
    {
        $data = $request->only([
            'id', 'latitude', 'longitude', 'batteryLevel', 'timestamp', 'vin', 'speed', 
            'odometer', 'ignition', 'fault', 'tampering', 'vibration', 'vinDescription', 
            'geofenceEnter', 'geofenceExit', 'powerCut', 'fallDown', 'jamming', 'tow', 
            'removing', 'lowBattery', 'powerRestored', 'bit14', 'bit15', 'bit16', 'address'
        ]);
        
        $data = array_map('trim', $data);
    
        $json = json_encode($data);
    
        $insertStatus = DB::table('tc_data')->insert([
            'attributes' => $json,
            'device_id' => $data['id'],
            'latitude' => $data['latitude'],
            'longitude' => $data['longitude'],
            'address' => $data['address'],
            'batteryLevel' => $data['batteryLevel'],
            'timestamp' => $data['timestamp'],
            'vin' => $data['vin'],
            'speed' => $data['speed'],
            'odometer' => $data['odometer'],
            'ignition' => $data['ignition'],
            'fault' => $data['fault'],
            'tampering' => $data['tampering'],
            'vibration' => $data['vibration'],
            'bit14' => $data['bit14'],
            'bit15' => $data['bit15'],
            'bit16' => $data['bit16'],
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    
        return response()->json([
            'status' => $insertStatus ? 'true' : 'false',
            'data' => json_decode($json),
            'message' => $insertStatus ? 'Data saved successfully.' : 'Failed to save data.',
        ]);
    }

     
    private function handleAsciiData($rawData)
    {
        //$rawData='28383030323430333234322C5034352C3032313032342C3038333531372C32392E3236393337332C532C32362E3137323232352C452C412C31312C34342C322C302C303030303132373839382C302C302C362C343530303029';
        
        $asciiData = hex2bin(substr($rawData, 2, -2));
        $parts = explode(',', $asciiData);
        
        
        $mappedData = [];
        
        $mappedData['id'] = $parts[0] ?? '';
        $mappedData['command_word'] = $parts[1] ?? '';
        $mappedData['date'] = $parts[2] ?? '';
        $mappedData['timestamp'] = $parts[3] ?? '';
        $mappedData['latitude'] = $parts[4] ?? '';
        $mappedData['longitude'] = $parts[6] ?? '';
        $mappedData['speed'] = $parts[9] ?? '';
        $mappedData['direction'] = $parts[10] ?? '';
        $mappedData['event_source_type'] = $parts[11] ?? '';
        $mappedData['unlock_verification'] = $parts[12] ?? '';
        $mappedData['rfid_card_number'] = $parts[13] ?? '';
        $mappedData['password_verification'] = $parts[14] ?? '';
        $mappedData['incorrect_password'] = $parts[15] ?? '';
        $mappedData['event_serial_number'] = $parts[16] ?? '';
        $mappedData['mileage'] = $parts[17] ?? '';
        $mappedData['fenceid'] = $parts[19] ?? '';
    
        if ($mappedData['date'] && $mappedData['timestamp']) {
            $formattedDate = Carbon::createFromFormat('dmy', $mappedData['date'])->format('Y-m-d');
            $formattedTime = Carbon::createFromFormat('His', $mappedData['timestamp'])->format('H:i:s');
            $mappedData['time'] = "{$formattedDate} {$formattedTime}";
        } else {
            $mappedData['time'] = '';
        }
    
        $displayName = $this->reverseGeocode($mappedData['latitude'], $mappedData['longitude']);
        $mappedData['address'] = $displayName ?? null;
        
      
        $request = new \Illuminate\Http\Request();
        $request->replace($mappedData);
        
        $event=$this->push_data_event($request);
        
         if (isset($mappedData['command_word']) && $mappedData['command_word'] == "P45") {
          $response = "(P69,0,{$mappedData['event_serial_number']})";
          return response()->json(['message' => $response], 200);
        }
        
         if (isset($mappedData['command_word']) && $mappedData['command_word'] == "P22") {
          $response = "(P22)";
          return response()->json(['message' => $response], 200);
        }
        
        
    }
    
    
    
      public function push_data_event(Request $request){

        $id = (isset($request->id)) ? trim($request->id) : 0;
        $latitude = (isset($request->latitude)) ? trim($request->latitude) : '';
        $longitude = (isset($request->longitude)) ? trim($request->longitude) : '';
        $speed = (isset($request->speed)) ? trim($request->speed) : '';
        $command_word = (isset($request->command_word)) ? trim($request->command_word) : '';

        $date = (isset($request->date)) ? trim($request->date) : '';
        $time = (isset($request->time)) ? trim($request->time) : '';
        $direction = (isset($request->direction)) ? trim($request->direction) : '';
        $event_source_type = (isset($request->event_source_type)) ? trim($request->event_source_type) : '';
        $unlock_verification = (isset($request->unlock_verification)) ? trim($request->unlock_verification) : '';
        $rfid_card_number = (isset($request->rfid_card_number)) ? trim($request->rfid_card_number) : '';

        $password_verification = (isset($request->password_verification)) ? trim($request->password_verification) : '';
        $incorrect_password = (isset($request->incorrect_password)) ? trim($request->incorrect_password) : '';
        $event_serial_number = (isset($request->event_serial_number)) ? trim($request->event_serial_number) : '';
        $mileage = (isset($request->mileage)) ? trim($request->mileage) : '';
        $fenceid = (isset($request->fenceid)) ? trim($request->fenceid) : '';
        $address = (isset($request->address)) ? trim($request->address) : '';




        $json = json_encode([
            'id' => $id,
            'latitude' => $latitude,
            'longitude' => $longitude,
            'address' => $address,
            'command_word' => $command_word,
            'date' => $date,
            'time' => $time,
            'speed' => $speed,
            'direction' => $direction,
            'event_source_type' => $event_source_type,
            'unlock_verification' => $unlock_verification,
            'rfid_card_number' => $rfid_card_number,
            'password_verification' => $password_verification,
            'incorrect_password'=> $incorrect_password,
            'event_serial_number' => $event_serial_number,
            'mileage' => $mileage,
            'fenceid' => $fenceid,
        ]);

        if(isset($id) && !empty($id)) {

            $title = '';
            $message =  '';
            $new_msg = '';

            if ($event_source_type == 1) {
                if ($unlock_verification == 1) {
                    $title = 'Swaping RFID authorization card';
                    $message =  "Pass the verification allow unlocking ".$rfid_card_number;
                }
                if ($unlock_verification == 0) {
                    $title = 'Swaping RFID authorization card';
                    $message =  "Verification is not passed unlock refused ".$rfid_card_number;
                }
                if ($unlock_verification == 98) {
                    $title = "Device normally unlock";
                    $message =  "Lock is normally unlock";
                }

            } else if($event_source_type == 2) {
                $title = 'Swaping Illegal RFID card ';
                $message =  "Swaping Illegal RFID card ".$rfid_card_number;
            } else if ($event_source_type == 3) {
                $title = 'Swaping the Vehical id card';
            } else if ($event_source_type == 4) {
                $title = 'Remote Static Password Unlocking';
                if ($unlock_verification == 1) {
                    $message =  "Pass the verification allow unlocking ".$rfid_card_number;
                }
                if ($unlock_verification == 0) {
                    $message =  "Verification is not passed unlock refused ".$rfid_card_number;
                }
                if ($unlock_verification == 98) {
                    $message =  "Lock is normally unlock using static password";
                }
                if ($unlock_verification == 99) {
                    $message =  "Refused to unlock outside fence";
                }
            } else if ($event_source_type == 5) {
                $title = 'Device Automatically Locked';
            } else if ($event_source_type == 6) {
                $title = 'Dynamic Password Unlocking';
            } else if ($event_source_type == 7) {
                $title = 'Bluetooth Unlocking';
            } else if ($event_source_type == 8) {
                $title = 'Lock rope pull out event';
            }
            
            // $new_msg = $title.' / '.$message;
            
            
            $title = trim($title);
            $message = trim($message);
            
          
            
            if (empty($title) && !empty($message)) {
                $new_msg = $message; 
            } elseif (!empty($title) && empty($message)) {
                $new_msg = $title; 
            } elseif (!empty($title) && !empty($message)) {
                $new_msg = $title . ' / ' . $message; 
            }
            
            
            $checkDeviceExist = DB::table('gps_devices')->where('device_id', $id)->first();
            if ($checkDeviceExist) {
                $admin_id = $checkDeviceExist->admin_id ?? '';
                $current_trip_id = $checkDeviceExist->current_trip_id ?? '';
                $user_data = DB::table('tbl_notification')->where('user_id',$admin_id)->take(3)->orderBy('id', 'DESC')->get();
                // echo "<pre>";
                // print_r($user_data);die;
                foreach($user_data as $key => $value) {
                    $device_token = $value->device_token ?? '';
                    $this->send_notification($device_token,$id,$event_source_type,$unlock_verification,$rfid_card_number,$password_verification,$incorrect_password);
                }
                // $device_token="duVQdrjGRZuyzd2eXARa38:APA91bEINN9E3hutgfoLvPMIDPRaN9228Je5xPl7DdVcxQvRREMDmFBwUuEvUyXPiaRuVg5E2Ug0bR4SEkJK88RrPdnqd9UKNekXOt2y3wFPSzZav0sCu-SN6sjTAyqAr4hOc9b6YK98";
                // $this->send_notification($device_token,$id,$event_source_type,$unlock_verification,$rfid_card_number,$password_verification,$incorrect_password);
            } else {
                $current_trip_id = '';
            }

            // if ($checkLoginExist) {
            //     // Update the existing record if device token already exists
            //     DB::table('tbl_notification')->where('device_token', $device_token)->update([
            //         'user_id' => $user_id,
            //         'created_date' => date('Y-m-d H:i:s')
            //     ]);
            //     $json = array('status' => 'true', "msg" => "Device token updated successfully!");
            //     echo json_encode($json);
            //     die;
            // } else {
            //     // Insert a new record if device token doesn't exist
            //     if (DB::table('tbl_notification')->insert([
            //         'user_id' => $user_id,
            //         'device_token' => $device_token,
            //         'created_date' => date('Y-m-d H:i:s')
            //     ])) {
            //         $json = array('status' => 'true', "msg" => "Device token inserted successfully!");
            //         echo json_encode($json);
            //         die;
            //     } else {
            //         echo json_encode(array('status' => 'false', 'message' => 'Fail to save Data.'));
            //         die;
            //     }
            // }
        }

        if($command_word != '@JT') {
            if(!empty($title)){
            if(DB::table('tc_data_event')->insert([
                'attributes' => $json,
                'device_id' =>$id,
                'latitude'=> $latitude,
                'longitude' => $longitude,
                'address' => $address,
                'command_word' => $command_word,
                'date' => $date,
                'time' => $time,
                'speed' => $speed,
                'direction' => $direction,
                'event_source_type' => $event_source_type,
                'unlock_verification' => $unlock_verification,
                'rfid_card_number' => $rfid_card_number,
                'password_verification' => $password_verification,
                'incorrect_password'=> $incorrect_password,
                'event_serial_number' => $event_serial_number,
                'mileage' => $mileage,
                'fenceid' => $fenceid,
                'created_at'=>date('Y-m-d H:i:s'),
                'updated_at'=>date('Y-m-d H:i:s'),
                'alert_naration' =>$new_msg,
                'trip_id' => $current_trip_id,
                'alert_title' => $title,

            ])){

                if($current_trip_id && !empty($current_trip_id) && isset($current_trip_id) && $command_word != '@JT') {

                    $assign_trip_record = AssignTrip::where('trip_id',$current_trip_id)->first();

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
                    $to_location_auth =  $to_location_data->customer_email ?? '';

                    $mergedString = $from_location_auth . ',' . $to_location_auth;
                    $emailArray = explode(',', $mergedString);
                    $uniqueEmailArray = array_unique($emailArray);


                    $mail_data = array();
                    $alert_trigger_date = date('Y-m-d H:i:s');

                    $mail_data['trip_id'] = $current_trip_id;
                    $mail_data['type'] = $title;
                    $mail_data['created_at'] = $alert_trigger_date;
                    $mail_data['address'] = $address;
                    $mail_data['alert_naration'] = $new_msg;
                    $mail_data['latitude'] = $latitude;
                    $mail_data['longitude'] = $longitude;

                    foreach($uniqueEmailArray as $key => $value) {
                        $admin_data = Admin::where('email',$value)->first();
                        $company_name = $admin_data->name ?? '';
                        $mail_data['company_name'] = $company_name;
                        try {
                            Mail::to($value)->send(new AlertMail($mail_data));
                        } catch (\Throwable $th) {
                        //   throw $th;
                        }
                    }
                }

               
                
            } else  {
                echo json_encode(array('status' => 'false', 'data' => $json,'message'=> 'Fail to save Data.'));
                die;
            }
            }
        }
    }
    
    
    public function send_notification($device_token,$id,$event_source_type,$unlock_verification,$rfid_card_number,$password_verification,$incorrect_password){
        $title = '';
        $message =  '';
        $new_msg = '';

        if ($event_source_type == 1) {
            if ($unlock_verification == 1) {
                $title = 'Swaping RFID authorization card';
                $message =  "Pass the verification allow unlocking ".$rfid_card_number;
            }
            if ($unlock_verification == 0) {
                $title = 'Swaping RFID authorization card';
                $message =  "Verification is not passed unlock refused ".$rfid_card_number;
            }
            if ($unlock_verification == 98) {
                $title = "Device normally unlock";
                $message =  "Lock is normally unlock";
            }

        } else if($event_source_type == 2) {
            $title = 'Swaping Illegal RFID card ';
            $message =  "Swaping Illegal RFID card ".$rfid_card_number;
        } else if ($event_source_type == 3) {
            $title = 'Swaping the Vehical id card';
        } else if ($event_source_type == 4) {
            $title = 'Remote Static Password Unlocking';
            if ($unlock_verification == 1) {
                $message =  "Pass the verification allow unlocking ".$rfid_card_number;
            }
            if ($unlock_verification == 0) {
                $message =  "Verification is not passed unlock refused ".$rfid_card_number;
            }
            if ($unlock_verification == 98) {
                $message =  "Lock is normally unlock using static password";
            }
            if ($unlock_verification == 99) {
                $message =  "Refused to unlock outside fence";
            }
        } else if ($event_source_type == 5) {
            $title = 'Device Automatically Locked';
        } else if ($event_source_type == 6) {
            $title = 'Dynamic Password Unlocking';
        } else if ($event_source_type == 7) {
            $title = 'Bluetooth Unlocking';
        } else if ($event_source_type == 8) {
            $title = 'Lock rope pull out event';
        }


        $new_msg = $title.' / '.$message;


        $message =  $new_msg;
        $noti_type = 'alarm';
       // $title = 'Ignition On';
        $obj1='';
        $obj2='';
        $obj3='';
       // $device_token ="cmorG1FnQQeC_nbi9O5CTc:APA91bFnTvg2brps5WQ8cO6k__UHkwDjIKiHOTrAxgzIUqfCeDFeLijd3CcAuyoAs-sYtjEiUCbwVVd1bVQG9hOreeKQ-9m8i5MV85yvIwNW5_ZQj6guXcW2EpB4j5pLF-yXp8QqihGa";
        // $json_txt = json_encode(array('token'=>$device_token,'data'=>array('title'=>$message,'body'=>$message,'sound'=>$urlsound,'param1'=>'',
        // 'param2'=>'')));

        if(isset($new_msg) && !empty($new_msg) && isset($message) && !empty($message) && isset($noti_type) && !empty($noti_type) && $event_source_type > 0){
            $this->android($device_token,$message,$new_msg);
        }
    }

    public function android($device_token,$message,$title){
        $url = "https://fcm.googleapis.com/fcm/send";
        $API_key ="AAAAxZXxoec:APA91bHAdKNO-7Ffya8craUklfvGIqhN1jiVfTLwePj7JZvWj7uvpFvo5MOtKxhFF-9-WWshp1DbrCpJbd11XgERra8fGHhPsIgE32lF5HIp2fXZBDBcIqag3qK0yv-3E772-ip-YMEl";
        $msg = array(
            'body'   => $message,
            'message'   => $message,
            'title'     => $title,
            'sound' => 'https://gpspackseal.in/alert/alarm1.mp3'
            // 'notificationType' => $type,
            // 'obj1' => $obj1,
            // 'obj2' => $obj2,
            // 'obj3' => $obj3
        );

        $arrayToSend = array (
        'data' => $msg,
        'to' => $device_token,
        'notification' => array('title'=> $title,'text'=> $message,
        'badge' => '0','priority'=>'high')
        );

        $json = json_encode($arrayToSend);
        // echo "<pre>";
        // print_r( $json);die;
        $headers = array ('Authorization: key='.$API_key, 'Content-Type: application/json');
        $ch = curl_init ();
        curl_setopt ($ch, CURLOPT_URL, $url);
        curl_setopt ($ch, CURLOPT_POST, true);
        curl_setopt ($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt ($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt ($ch, CURLOPT_POSTFIELDS, $json);
        $result = curl_exec($ch);
        curl_close($ch);

    }

    function reverseGeocode($latitude, $longitude)
    {
        if (is_null($latitude) || is_null($longitude)) {
            return null; 
        }
    
        $geocodingUrl = "http://address.markongps.in/nominatim/reverse?format=json&lat={$latitude}&lon={$longitude}";
    
        try {
            $response = Http::get($geocodingUrl);
            $responseData = json_decode($response->body(), true);
            $displayName = $responseData['display_name'] ?? null; 
            return $displayName;
        } catch (\Exception $e) {
            \Log::error('Error in reverse geocoding:', ['exception' => $e]);
            return null;
        }
    }
}
