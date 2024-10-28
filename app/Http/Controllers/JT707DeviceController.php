<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Services\JT707DeviceService;
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

class JT707DeviceController extends Controller
{
    
    protected $deviceService;

    public function __construct(JT707DeviceService $deviceService)
    {
        $this->deviceService = $deviceService;
    }
    
    
    public function handleJT707AData(Request $request)
    {
        try {
            $result = $this->deviceService->parse($request->input('data'));
            
          
            
            if($result['MsgType']=="Location"){
                
                
            $this->push_data($result);
             
            $this->tc_data($result);
             
             $this->push_data_event($result);
             
             return  $result['ReplyMsg'];
            
                
            }else{
                return "";
            }
            
            
            
           
        } catch (\Exception $e) {
            
             
           return "";
        }
        
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
            $displayName = $responseData['display_name'] ?? null; 
            return $displayName;
        } catch (\Exception $e) {
            \Log::error('Error in reverse geocoding:', ['exception' => $e]);
            return null;
        }
    }
    
    
    
        public function push_data($parsedData)
        {
            if (empty($parsedData['DataBody'])) {
                return response()->json([
                    'status' => false,
                    'message' => 'Failed to store parse raw data.'
                ], 400);
            }
        
            // Determine lock state based on LockStatus
            $lockState = ($parsedData['DataBody']['LockRope'] == 1) ? "lock" : "unlock";
        
            // Prepare the data array to be inserted
            $data = [
                'device_id'    => $parsedData['DeviceID'] ?? 0,
                'latitude'     => $parsedData['DataBody']['Latitude'] ?? null,
                'longitude'    => $parsedData['DataBody']['Longitude'] ?? null,
                'batteryLevel' => $parsedData['DataBody']['Battery'] ?? null,
                'timestamp'    => $parsedData['DataBody']['GpsTime'] ?? null,
                'speed'        => $parsedData['DataBody']['Speed'] ?? null,
                'odometer'     => $parsedData['DataBody']['Mileage'] ?? null,
                'ignition'     => $parsedData['DataBody']['LockStatus'] ?? null,
                'fault'        => $parsedData['DataBody']['Alarm'] ?? '0', // Default to '0' if not set
                'attributes'   => json_encode([
                    'batteryLevel' => $parsedData['DataBody']['Battery'] ?? 0,
                    'odometer'     => $parsedData['DataBody']['Mileage'],
                    'lock'         => $lockState,
                    'ignition'     => $parsedData['DataBody']['LockStatus'] ?? 0,
                    'speed'        => $parsedData['DataBody']['Speed'],
                    'ip'           => $parsedData['DataBody']['ip'] ?? '127.0.0.1',
                    'motion'       => $parsedData['DataBody']['motion'] ?? false,
                    'hours'        => $parsedData['DataBody']['hours'] ?? 0,
                    'temperature'  => $parsedData['DataBody']['Temperature'] ?? null,
                    'direction'    => $parsedData['DataBody']['Direction'] ?? null,
                    'batteryVoltage' => $parsedData['DataBody']['Voltage'] ?? null,
                    'gpsSignal'    => $parsedData['DataBody']['GpsSignal'] ?? null,
                    'cellId'       => $parsedData['DataBody']['CELLID'] ?? null,
                    'mcc'          => $parsedData['DataBody']['MCC'] ?? null,
                    'mnc'          => $parsedData['DataBody']['MNC'] ?? null,
                    'lac'          => $parsedData['DataBody']['LAC'] ?? null,
                    'unlockTime'   => $parsedData['DataBody']['UnLockTime'] ?? null,
                    'runStatus'    => $parsedData['DataBody']['RunStatus'] ?? null,
                    'simStatus'    => $parsedData['DataBody']['SimStatus'] ?? null,
                    'awaken'       => $parsedData['DataBody']['Awaken'] ?? null,
                    'locationType' => $parsedData['DataBody']['LocationType'] ?? null,
                    'dataLength'   => $parsedData['DataBody']['DataLength'] ?? null,
                    'sendDataCount' => $parsedData['DataBody']['SendDataCount'] ?? null,
                    'lockRope'     => $parsedData['DataBody']['LockRope'] ?? null,
                ]),
                'address'      =>  $this->reverseGeocode($parsedData['DataBody']['Latitude'] ?? '', $parsedData['DataBody']['Longitude'] ?? ''),
                'created_at'   => now(),
                'updated_at'   => now(),
            ];
        
            // Insert data into the database
            if (DB::table('tc_data')->insert($data)) {
                return response()->json(['status' => true, 'message' => "Push Data saved successfully"]);
            } else {
                return response()->json(['status' => false, 'message' => "Failed to save push data"]);
            }
        }


        public function tc_data($parsedData)
        {
            // Check if DataBody is present
            if (empty($parsedData['DataBody'])) {
                return response()->json([
                    'status' => false,
                    'message' => 'Failed to store TC Data.'
                ], 400);
            }
        
            $deviceData = $parsedData['DataBody'];
            $id = $parsedData['DeviceID'] ?? 0;
        
            // Retrieve data safely with default values
            $latitude = $deviceData['Latitude'] ?? '';
            $longitude = $deviceData['Longitude'] ?? '';
            $batteryLevel = $deviceData['Battery'] ?? '';
            $timestamp = $deviceData['GpsTime'] ?? now();
            $speed = $deviceData['Speed'] ?? 0;
            $odometer = $deviceData['Mileage'] ?? 0;
            $ignition = $deviceData['LockStatus'] ?? 0;
            $fault = $deviceData['Alarm'] ?? '';
            $altitude = $deviceData['Altitude'] ?? 0;
            $fenceId = $deviceData['FenceId'] ?? '';
        
            // Determine lock state
            $lockState = ($deviceData['LockRope'] == 1) ? "lock" : "unlock";
        
            // Get device ID from database
            $deviceId = DB::table('tc_devices')->where('uniqueid', $id)->value('id');
        
            // If device doesn't exist, insert new device
            if (is_null($deviceId)) {
                $deviceId = DB::table('tc_devices')->insertGetId([
                    'name' => $id, 
                    'uniqueid' => $id,
                    'lastupdate' => now(),
                    'status' => 'online',
                    'attributes' => '{}', 
                ]);
            }
        
            // Prepare position data
            $positionData = [
                'protocol' => 'osmand',
                'deviceid' => $deviceId,
                'servertime' => now(),
                'devicetime' => $timestamp,
                'fixtime' => $timestamp,
                'valid' => 1,
                'attributes' => json_encode([
                    'batteryLevel' => $batteryLevel,
                    'odometer' => $odometer,
                    'lock' => $lockState,
                    'ignition' => $ignition,
                    'speed' => $speed,
                    'ip' => $deviceData['ip'] ?? '127.0.0.1',
                    'motion' => $deviceData['motion'] ?? false,
                    'hours' => $deviceData['hours'] ?? 0
                ]),
                'latitude' => $latitude,
                'longitude' => $longitude,
                'altitude' => $altitude,
                'speed' => $speed,
                'course' => 0,
                'address' => $this->reverseGeocode($latitude, $longitude),
                'accuracy' => 0,
                'network' => null,
                'geofenceids' => $fenceId,
            ];
        
            // Insert position data and get position ID
            $positionId = DB::table('tc_positions')->insertGetId($positionData);
            
            // Check if positionId is successfully obtained
            if (!$positionId) {
                return response()->json(['status' => false, 'message' => 'Failed to save position data.'], 500);
            }
        
            // Update device with new position ID
            $updateStatus = DB::table('tc_devices')
                ->where('uniqueid', $parsedData['DeviceID'])
                ->update([
                    'positionid' => $positionId,
                    'status' => 'online',
                    'lastupdate' => Carbon::now('Asia/Kolkata'),
                ]);
        
            // Check if any rows were updated
            if ($updateStatus === 0) {
                return response()->json(['status' => false, 'message' => 'No device status was updated.'], 500);
            }
        
            // Update assign trips
            $gpsdeviceId = DB::table('gps_devices')->where('device_id', $parsedData['DeviceID'])->value('id');
            if ($gpsdeviceId) {
                DB::table('assign_trips')
                    ->where('trip_status', 'assign')
                    ->where('status', 'enable')
                    ->where('gps_devices_id', $gpsdeviceId)
                    ->update(['device_position_id' => $positionId, 'device_position_address' => $positionData['address']]);
            }
        
            return response()->json([
                'status' => true,
                'message' => 'Data saved successfully.'
            ], 200);
        }



        public function push_data_event($data)
        {
            
            $deviceId = isset($data['DeviceID']) && !empty($data['DeviceID']) ? trim($data['DeviceID']) : null;
            $dataBody = isset($data['DataBody']) && !empty($data['DataBody']) ? $data['DataBody'] : null;
        
            if (!empty($dataBody)) {
                $gpsTime = isset($dataBody['GpsTime']) ? trim($dataBody['GpsTime']) : null;
                $latitude = isset($dataBody['Latitude']) ? trim($dataBody['Latitude']) : null;
                $longitude = isset($dataBody['Longitude']) ? trim($dataBody['Longitude']) : null;
                $speed = isset($dataBody['Speed']) ? trim($dataBody['Speed']) : null;
                $direction = isset($dataBody['Direction']) ? trim($dataBody['Direction']) : null;
                $lockStatus = isset($dataBody['LockStatus']) ? trim($dataBody['LockStatus']) : null;
                $mileage = isset($dataBody['Mileage']) ? trim($dataBody['Mileage']) : null;
                $alarm = isset($dataBody['Alarm']) ? trim($dataBody['Alarm']) : null;
                $battery = isset($dataBody['Battery']) ? trim($dataBody['Battery']) : null;
                $voltage = isset($dataBody['Voltage']) ? trim($dataBody['Voltage']) : null;
                $gpsSignal = isset($dataBody['GpsSignal']) ? trim($dataBody['GpsSignal']) : null;
                $gsmSignal = isset($dataBody['GSMSignal']) ? trim($dataBody['GSMSignal']) : null;
                $fenceId = isset($dataBody['FenceId']) ? trim($dataBody['FenceId']) : null;
                $backCover = isset($dataBody['BackCover']) ? trim($dataBody['BackCover']) : null;
                $index = isset($dataBody['Index']) ? trim($dataBody['Index']) : null;
                $mnc = isset($dataBody['MNC']) ? trim($dataBody['MNC']) : null;
                $mcc = isset($dataBody['MCC']) ? trim($dataBody['MCC']) : null;
                $lac = isset($dataBody['LAC']) ? trim($dataBody['LAC']) : null;
                $cellId = isset($dataBody['CELLID']) ? trim($dataBody['CELLID']) : null;
                $locationType = isset($dataBody['LocationType']) ? trim($dataBody['LocationType']) : null;
                $altitude = isset($dataBody['Altitude']) ? trim($dataBody['Altitude']) : null;
                $dataLength = isset($dataBody['DataLength']) ? trim($dataBody['DataLength']) : null;
                $lockRope = isset($dataBody['LockRope']) ? trim($dataBody['LockRope']) : null;
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
                
                    
                   
        
                    if ($deviceId) {
                        
                  
                        
                        $checkDeviceExist = DB::table('gps_devices')->where('device_id', $deviceId)->first();
                        
                        
                    
                        if (!empty($checkDeviceExist)) {
                            $admin_id = $checkDeviceExist->admin_id ?? '';
                            $current_trip_id = $checkDeviceExist->current_trip_id ?? '';
        
                            $user_data = DB::table('tbl_notification')->where('user_id', $admin_id)->take(3)->orderBy('id', 'DESC')->get();
        
                            foreach ($user_data as $key => $value) {
                                $device_token = $value->device_token ?? '';
                                $notificationData = $this->send_notification($device_token, $data);
                            }
                        } else {
                            $current_trip_id = null;
                        }
                    }
                    
        
                    $formattedDate = \Carbon\Carbon::parse($gpsTime)->format('dmy');
                    
                   
                    
                    if(!empty($notificationData)){
                     
                     if (!empty($notificationData['message']) && !empty($notificationData['title'])) {
                        
                        // Insert data into tc_data_event table
                        if (DB::table('tc_data_event')->insert([
                            'attributes' => $json,
                            'device_id' => $deviceId,
                            'latitude' => $latitude,
                            'longitude' => $longitude,
                            'address' => $this->reverseGeocode($latitude, $longitude),
                            'speed' => $speed,
                            'direction' => $direction,
                            'lock_status' => $lockRope,
                            'mileage' => $mileage,
                            'time' => $gpsTime,
                            'date' => $formattedDate,
                            'rfid_card_number' => $rf_id_Card,
                            'created_at' => now(),
                            'updated_at' => now(),
                            'alert_naration' => $notificationData['message'],
                            'trip_id' => $current_trip_id,
                            'alert_title' => $notificationData['title'],
                        ])) {
                            
        
                            if ($current_trip_id && !empty($current_trip_id)) {
                                $assign_trip_record = AssignTrip::where('trip_id', $current_trip_id)->first();
                                $from_location_id = $assign_trip_record->from_destination ?? null;
                                $to_destination_id = $assign_trip_record->to_destination ?? null;
        
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
                                    'address' => $this->reverseGeocode($latitude, $longitude),
                                    'alert_naration' => $notificationData['message'],
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
            
            if(!empty($data)){
            
            $new_msg = $data['title'] . ' / ' . $data['message'];
            
            // Send notification if conditions are met
                if (!empty($device_token) && !empty($new_msg)) {
                   $this->android($device_token, $data['message'], $data['title']);
                }
                return $data;
            }else{
                return null;
            }
            
            
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
        
            $event = $data['DataBody']['Awaken'] ?? null;
            
            if($event==0 || $event==5){
                return null;
            }
        
            $eventMessages = [
                0 => 'RTC timing report',
                1 => 'Lock rope cut event',
                2 => 'Inserted lock rope',
                3 => 'Open cover',
                4 => 'Close cover',
                5 => 'Charging power/configure',
                6 => 'Temperature alarm report',
            ];
        
           
            $eventMessage = isset($eventMessages[$event]) ? $eventMessages[$event] : 'Unknown event';
        
            $title = "Device Update";
            $message = "Event: " . $eventMessage;
        
           
            return [
                'title' => $title,
                'message' => $message
            ];
        }



    
    
    
    
    
    
}
    

