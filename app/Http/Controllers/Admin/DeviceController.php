<?php

namespace App\Http\Controllers\Admin;

use App\Models\Role;
use App\Models\GpsDevice;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use App\Imports\DevicesImport;
use App\Models\AssignTrip;
use Carbon\Carbon;
use Excel;
use DateTime;
use DateTimeZone;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class DeviceController extends Controller
{

  public function map_device_to_customer()
  {
    $pageTitle = 'Map Device to customer';
    $gpsdevices = GpsDevice::whereNull('gps_devices.admin_id')->where('status', 'enable')->get(['id', 'device_id']);
    $customersWithRole = Admin::join('roles', 'admins.role_id', '=', 'roles.id')
      ->where('roles.name', '=', 'Customer')
      ->select('admins.*', 'admins.id as cid', 'roles.id as rid')
      ->get();


    $mapdevices = GpsDevice::join('admins', 'gps_devices.admin_id', '=', 'admins.id')
      ->leftjoin('assign_trips', 'assign_trips.trip_id', '=', 'gps_devices.current_trip_id')
      ->select('gps_devices.*', 'admins.name as customername', 'admins.mobile_no as customer_no', 'admins.date_of_expiry as expirydate','assign_trips.id as asid')
      ->get();
      
      // echo "<pre>";
      // print_r( $mapdevices );die;
    return view('admin.device.map-device-to-customer', compact('pageTitle', 'customersWithRole', 'gpsdevices', 'mapdevices'));
  }

  public function edit_map_device_to_customer($id){
    $pageTitle = 'Unlink Device from Customer';
   

    $customersWithRole = Admin::join('roles', 'admins.role_id', '=', 'roles.id')
      ->where('roles.name', '=', 'Customer')
      ->select('admins.*', 'admins.id as cid', 'roles.id as rid')
      ->get();


    $mapdevices = GpsDevice::join('admins', 'gps_devices.admin_id', '=', 'admins.id')
      ->leftjoin('assign_trips', 'assign_trips.trip_id', '=', 'gps_devices.current_trip_id')
      ->select('gps_devices.*', 'admins.name as customername', 'admins.mobile_no as customer_no', 'admins.date_of_expiry as expirydate','assign_trips.id as asid')
      ->get();

      $gpsdeviceedit = GpsDevice::find($id);

      $admin_id_device = $gpsdeviceedit->admin_id ?? 0;
      $current_trip_id = $gpsdeviceedit->current_trip_id ?? '';


      $customer = Admin::find($admin_id_device);
      if(!empty($current_trip_id)) {
        $notify[] = ['error', 'The device is currently in use on a trip. Please finish or cancel the trip before attempting to unlink.'];
        return back()->withNotify($notify);
      }

      $gpsdevices = $gpsdevices = GpsDevice::where(function($query) {
        $query->whereNull('current_trip_id')
        ->orWhere('current_trip_id', '');
      })->where('status', 'enable')->where('admin_id', $admin_id_device)->get(['id', 'device_id']);
     
    //  echo "string";die;
      // echo '<pre>';
      // print_r($gpsdevices);die;
    return view('admin.device.unlink-device-from-customer', compact('pageTitle', 'customersWithRole', 'gpsdevices', 'mapdevices','gpsdeviceedit','customer'));
  }

  public function unlink_device_from_customer($id=0){
    $pageTitle = 'Unlink Device from Customer';
    $gpsdevices = GpsDevice::whereNull('gps_devices.admin_id')->where('status', 'enable')->get(['id', 'device_id']);

    $customersWithRole = Admin::join('roles', 'admins.role_id', '=', 'roles.id')
      ->where('roles.name', '=', 'Customer')
      ->select('admins.*', 'admins.id as cid', 'roles.id as rid')
      ->get();


    $mapdevices = GpsDevice::join('admins', 'gps_devices.admin_id', '=', 'admins.id')
      ->leftjoin('assign_trips', 'assign_trips.trip_id', '=', 'gps_devices.current_trip_id')
      ->select('gps_devices.*', 'admins.name as customername', 'admins.mobile_no as customer_no', 'admins.date_of_expiry as expirydate','assign_trips.id as asid')
      ->get();
      
    return view('admin.device.unlink-device-from-customer', compact('pageTitle', 'customersWithRole', 'gpsdevices', 'mapdevices'));
  }

  public function save_unlink_device_from_customer(Request $request)
  {
    
    $old_device_id = $request->gps_device_id ?? '';
 

    $old_device = GpsDevice::find($old_device_id);
    $old_device->admin_id = NULL;
    $old_device->save();

    // echo "<pre>";
    // print_r($request->all());die;

    $device_ids = $request->device_id;
    foreach ($device_ids as $id) {
      $gps_device = GpsDevice::find($id);
      if ($gps_device) {
        $gps_device->admin_id = NULL;
        $gps_device->save();
      }
    }
    $notify[] = ['success', 'Unmap Device from Customer Successfully'];
    return redirect()->route('admin.device.map-device-to-customer')->withNotify($notify);
  }

  

  public function get_customer_details($id)
  {
    $customer = Admin::find($id);
    if (!$customer) {
      return response()->json(['error' => 'Customer not found'], 404);
    }
    return response()->json([
      'related_company' => $customer->related_company,
      'customer_mobileno' => $customer->mobile_no,
      'customer_email' => $customer->email,
      'gst_no' => $customer->gst_no,

    ]);
  }
  public function save_map_to_customer(Request $request)
  {
    $device_ids = $request->device_id;
    foreach ($device_ids as $id) {
      $gps_device = GpsDevice::find($id);
      if ($gps_device) {
        $gps_device->admin_id = $request->customer_id;
        $gps_device->save();
      }
    }
    $notify[] = ['success', 'Device Map To Customer Successfully'];
    return redirect()->route('admin.device.map-device-to-customer')->withNotify($notify);
  }
  public function status_map_device($id)
  {
    $mapdevices     = GpsDevice::find($id);
    if ($mapdevices) {
      if ($mapdevices->status == 'enable') {
        $mapdevices->status = 'disable';
        $notification     = 'Map Device To Customer Status Disable successfully';
      } elseif ($mapdevices->status == 'disable') {
        $mapdevices->status = 'enable';
        $notification     = 'Map Device To Customer Status Enable successfully';
      }
    }
    $mapdevices->save();
    $notify[] = ['success', $notification];
    return back()->withNotify($notify);
  }

  public function my_device()
  {
    $pageTitle = 'My Device';
    if (auth('admin')->user()->id) {
      $admin_id = auth('admin')->id();
    } else {
      $admin_id = 0;
    }
    $mapdevices = GpsDevice::join('admins', 'gps_devices.admin_id', '=', 'admins.id')
      ->join('roles', 'admins.role_id', '=', 'roles.id')
      ->leftjoin('tc_devices', 'gps_devices.device_id', '=', 'tc_devices.uniqueid')
      ->leftjoin('assign_trips', 'assign_trips.trip_id', '=', 'gps_devices.current_trip_id');;
    if (auth('admin')->user()->role_id != 0) {
      $mapdevices = $mapdevices->where('admins.id', '=', $admin_id);
    }
    $mapdevices = $mapdevices->select('gps_devices.*', 'admins.name as customername', 'admins.mobile_no as customer_no', 'admins.date_of_expiry as expirydate','assign_trips.id as asid')
      ->get();
    return view('admin.device.my-device', compact('pageTitle', 'mapdevices'));
  }

  public function index()
  {
    if (auth('admin')->user()->id) {
      $admin_id = auth('admin')->id();
    } else {
      $admin_id = 0;
    }

    $pageTitle = 'Import Device List';
    $import = GpsDevice::leftjoin('tc_devices', 'gps_devices.device_id', '=', 'tc_devices.uniqueid')
    ->leftjoin('assign_trips', 'assign_trips.trip_id', '=', 'gps_devices.current_trip_id');
    if (auth('admin')->user()->role_id != 0) {
      $imports = $import->where('admins.id', '=', $admin_id);
    }
    $imports = $import->select('gps_devices.*', 'tc_devices.status as device_status','assign_trips.id as asid')
      ->get();
    
    // echo "<pre>";
    // print_r($imports);die;
    return view('admin.device.import-device-list', compact('pageTitle', 'imports'));
  }

  public function import_device_exel(Request $request)
  {
    try {
      $file = $request->file('device_upload');

      $validator = $request->validate([
        'device_upload' => 'required|mimes:xlx,xls,xlsx'
      ]);
      Excel::import(new DevicesImport, $file);
      return back();
    } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
      $failures = $e->failures();
      $notify[] = ['error',  $failure->errors()];
    }
  }

  public function live_tracking($id)
  {
    $pageTitle = 'Live Tracking';

    $longitude_data = DB::select("SELECT latitude,longitude FROM `tc_positions` WHERE `id` > 6 and id < 140 and deviceid=1");

    $assign_trip = AssignTrip::select('assign_trips.*', 'admins.gst_no as gstno','from_locations.location_port_name as from_location_name',
    'to_locations.location_port_name as to_location_name','gd.device_id')
    ->join('locations as from_locations', 'assign_trips.from_destination', '=', 'from_locations.id')
    ->join('locations as to_locations', 'assign_trips.to_destination', '=', 'to_locations.id')
    ->join('gps_devices as gd', 'assign_trips.gps_devices_id', '=', 'gd.id')
    ->join('admins', 'assign_trips.admin_id', '=', 'admins.id')
    ->find($id);
    
   
    $trip_details = array();
    $trip_complete_data = array();

    if(isset($assign_trip->from_location_name)) {$trip_details['from_location_name'] = $assign_trip->from_location_name; } else { $trip_details['from_location_name'] ='';}
    if(isset($assign_trip->to_location_name)) {$trip_details['to_location_name'] = $assign_trip->to_location_name; } else { $trip_details['to_location_name'] ='';}
    if(isset($assign_trip->trip_id)) {$trip_details['trip_id'] = $assign_trip->trip_id; } else { $trip_details['trip_id'] ='';}

    if(isset($assign_trip->gps_devices_id)) {$trip_details['gps_devices_id'] = $assign_trip->gps_devices_id; } else { $trip_details['gps_devices_id'] ='';}
    if(isset($assign_trip->id)) {$trip_details['id'] = $assign_trip->id; } else { $trip_details['id'] ='';}
    if(isset($assign_trip->trip_start_date)) { $trip_details['start_trip_date'] = $assign_trip->trip_start_date; } else { $trip_details['start_trip_date'] ='';}
    if(isset($assign_trip->expected_arrival_time)) {$trip_details['expected_arrive_time'] = $assign_trip->expected_arrival_time; } else {$trip_details['expected_arrive_time'] ='';}  

    if(isset($assign_trip->trip_status)) { $trip_status = $assign_trip->trip_status; } else { $trip_status ='';}  
    $trip_details['trip_status'] = $trip_status;
    if(isset($assign_trip->device_id)) { $device_id = $assign_trip->device_id; } else { $device_id =''; }  
    $trip_details['device_id'] = $device_id;

    if(!empty($device_id) && isset($device_id)) {
      $tc_devices = DB::table('tc_devices')->where('uniqueid',$device_id)->first();
      
      if (isset($tc_devices) && !empty($tc_devices)) {
        $positionid = (isset($tc_devices->positionid)) ? $tc_devices->positionid : 0;
        if (!empty($positionid) && isset($positionid)) {
          $deviceid = $tc_devices->id ?? '';
          $trip_start_date = $assign_trip->trip_start_date ?? '';
          $adjusted_start_date = Carbon::parse($trip_start_date)->subHours(5)->subMinutes(30);
          $first_ins_location_time = $adjusted_start_date->format('Y-m-d H:i:s');
          $devicedata = DB::table('tc_positions')->whereNotNull('address')->where('devicetime', '>=', $first_ins_location_time)->orderBy('id', 'asc')->where('deviceid',$deviceid)->first();

          if($trip_status == 'completed') {
            $completed_trip_time = $assign_trip->completed_trip_time ?? '';
            $adjusted_end_time = Carbon::parse($completed_trip_time)->subHours(5)->subMinutes(30);
           $last_ins_location_time = $adjusted_end_time->format('Y-m-d H:i:s');
            $tc_positions = DB::table('tc_positions')->whereNotNull('address')->where('devicetime', '<=', $last_ins_location_time)->orderBy('id', 'desc')->where('deviceid',$deviceid)->first();
          } else {
            $tc_positions = DB::table('tc_positions')->whereNotNull('address')->where('id',$positionid)->first();
          }

          
          if ($trip_status == 'completed') {
            $trip_complete_position = DB::table('tc_positions')
            ->whereNotNull('address')->where('devicetime', '>=', $first_ins_location_time)
            ->where('devicetime', '<=', $last_ins_location_time)
            ->orderBy('id', 'asc')
            ->where('deviceid',$deviceid)
            // ->groupBy('latitude', 'longitude')
            ->get();
            foreach ($trip_complete_position as $key => $value) {
              $trip_latitude = $value->latitude ?? '';
              $trip_longitude = $value->longitude ?? '';
              $speed = $value->speed ?? '';
              $trip_address = $value->address ?? '';

              $tc_positions_info = array();
              if(isset($value->attributes) && !empty($value->attributes)){
                $trip_attributes = json_decode($value->attributes);
                if(isset($trip_attributes->batteryLevel) && !empty($trip_attributes->batteryLevel)){
                  $tc_positions_info['battery'] = $trip_attributes->batteryLevel ?? '';    
                } else {
                  $tc_positions_info['battery'] = '';    
                }
              }
              $tc_positions_info['lat'] = $trip_latitude;
              $tc_positions_info['lng'] = $trip_longitude;
              $tc_positions_info['speed'] = $speed;
              $tc_positions_info['address'] = $trip_address;
              $trip_complete_data[] =$tc_positions_info;
            }  
          }
          
          $trip_details['start_address'] = (isset($devicedata->address) && !empty($devicedata->address)) ? $devicedata->address : '';
          $trip_details['address'] = (isset($tc_positions->address) && !empty($tc_positions->address)) ? $tc_positions->address : '';
          $trip_details['latitude'] = (isset($tc_positions->latitude) && !empty($tc_positions->latitude)) ? $tc_positions->latitude : '';
          $trip_details['longitude'] = (isset($tc_positions->longitude) && !empty($tc_positions->longitude)) ? $tc_positions->longitude : '';

          if(isset($tc_positions->attributes) && !empty($tc_positions->attributes)){
            $attributes = json_decode($tc_positions->attributes);
            if(isset($attributes->batteryLevel) && !empty($attributes->batteryLevel)){
              $trip_details['battery'] = $attributes->batteryLevel ?? '';    
            } else {
              $trip_details['battery'] = '';    
            }
          }
        }
      }
      $trip_details['device_status'] =  $tc_devices->status ?? '';
    } else {
      $trip_details['device_status'] =  '';
      $trip_details['battery'] =  '';
      $trip_details['address'] =  '';
    }

    $g_map_data = $this->get_device_data($id);
    
    // echo "<pre>";
    // print_r($trip_details);die;

    return view('admin.device.live-tracking', compact('id','longitude_data', 'pageTitle','trip_details','g_map_data','trip_complete_data'));
  }

  public function live_tracking_trip_completed($id) {
    $pageTitle = 'Live Tracking';

    $longitude_data = DB::select("SELECT latitude,longitude FROM `tc_positions` WHERE `id` > 6 and id < 140 and deviceid=1");

    $assign_trip = AssignTrip::select('assign_trips.*', 'admins.gst_no as gstno','from_locations.location_port_name as from_location_name',
    'to_locations.location_port_name as to_location_name','gd.device_id')
    ->join('locations as from_locations', 'assign_trips.from_destination', '=', 'from_locations.id')
    ->join('locations as to_locations', 'assign_trips.to_destination', '=', 'to_locations.id')
    ->join('gps_devices as gd', 'assign_trips.gps_devices_id', '=', 'gd.id')
    ->join('admins', 'assign_trips.admin_id', '=', 'admins.id')
    ->find($id);

    $trip_details = array();
    

    if(isset($assign_trip->from_location_name)) {$trip_details['from_location_name'] = $assign_trip->from_location_name; } else { $trip_details['from_location_name'] ='';}
    if(isset($assign_trip->to_location_name)) {$trip_details['to_location_name'] = $assign_trip->to_location_name; } else { $trip_details['to_location_name'] ='';}
    if(isset($assign_trip->trip_id)) {$trip_details['trip_id'] = $assign_trip->trip_id; } else { $trip_details['trip_id'] ='';}

    if(isset($assign_trip->gps_devices_id)) {$trip_details['gps_devices_id'] = $assign_trip->gps_devices_id; } else { $trip_details['gps_devices_id'] ='';}
    if(isset($assign_trip->id)) {$trip_details['id'] = $assign_trip->id; } else { $trip_details['id'] ='';}
    if(isset($assign_trip->trip_start_date)) { $trip_details['start_trip_date'] = $assign_trip->trip_start_date; } else { $trip_details['start_trip_date'] ='';}
    if(isset($assign_trip->expected_arrival_time)) {$trip_details['expected_arrive_time'] = $assign_trip->expected_arrival_time; } else {$trip_details['expected_arrive_time'] ='';}  

    if(isset($assign_trip->trip_status)) { $trip_status = $assign_trip->trip_status; } else { $trip_status ='';}  
    $trip_details['trip_status'] = $trip_status;
    if(isset($assign_trip->device_id)) { $device_id = $assign_trip->device_id; } else { $device_id =''; }  
    $trip_details['device_id'] = $device_id;

    if(!empty($device_id) && isset($device_id)) {
      $tc_devices = DB::table('tc_devices')->where('uniqueid',$device_id)->first();
      
      if (isset($tc_devices) && !empty($tc_devices)) {
        $positionid = (isset($tc_devices->positionid)) ? $tc_devices->positionid : 0;
        if (!empty($positionid) && isset($positionid)) {
          $deviceid = $tc_devices->id ?? '';
          $trip_start_date = $assign_trip->trip_start_date ?? '';
          $adjusted_start_date = Carbon::parse($trip_start_date)->subHours(5)->subMinutes(30);
          $first_ins_location_time = $adjusted_start_date->format('Y-m-d H:i:s');
          $devicedata = DB::table('tc_positions')->whereNotNull('address')->where('devicetime', '>=', $first_ins_location_time)->orderBy('id', 'asc')->where('deviceid',$deviceid)->first();
          

          if($trip_status == 'completed') {
            $completed_trip_time = $assign_trip->completed_trip_time ?? '';
            $adjusted_end_time = Carbon::parse($completed_trip_time)->subHours(5)->subMinutes(30);
           $last_ins_location_time = $adjusted_end_time->format('Y-m-d H:i:s');
            $tc_positions = DB::table('tc_positions')->whereNotNull('address')->where('devicetime', '<=', $last_ins_location_time)->orderBy('id', 'desc')->where('deviceid',$deviceid)->first();
          } else {
            $tc_positions = DB::table('tc_positions')->whereNotNull('address')->where('id',$positionid)->first();
          }

          if ($trip_status == 'completed') {
            $trip_complete_position = DB::table('tc_positions')
            ->whereNotNull('address')->where('devicetime', '>=', $first_ins_location_time)
            ->where('devicetime', '<=', $last_ins_location_time)
            ->orderBy('id', 'asc')
            ->where('deviceid',$deviceid)
            ->groupBy('latitude', 'longitude')
            ->get();
          } else {
            $trip_complete_position = '';
          }
        
          $trip_complete_data = array();
          foreach ($trip_complete_position as $key => $value) {
            $trip_latitude = $value->latitude;
            $trip_longitude = $value->longitude;
            $tc_positions_info = array();
            $tc_positions_info['lat'] = $trip_latitude;
            $tc_positions_info['lng'] = $trip_longitude;
            $trip_complete_data[] =$tc_positions_info;
          }
          // echo '<pre>';
          // print_r($trip_complete_data);die;
          $trip_details['start_address'] = (isset($devicedata->address) && !empty($devicedata->address)) ? $devicedata->address : '';
          $trip_details['address'] = (isset($tc_positions->address) && !empty($tc_positions->address)) ? $tc_positions->address : '';
          $trip_details['latitude'] = (isset($tc_positions->latitude) && !empty($tc_positions->latitude)) ? $tc_positions->latitude : '';
          $trip_details['longitude'] = (isset($tc_positions->longitude) && !empty($tc_positions->longitude)) ? $tc_positions->longitude : '';

          if(isset($tc_positions->attributes) && !empty($tc_positions->attributes)){
            $attributes = json_decode($tc_positions->attributes);
            if(isset($attributes->batteryLevel) && !empty($attributes->batteryLevel)){
              $trip_details['battery'] = $attributes->batteryLevel ?? '';    
            } else {
              $trip_details['battery'] = '';    
            }
          }
        }
      }
      $trip_details['device_status'] =  $tc_devices->status ?? '';
    } else {
      $trip_details['device_status'] =  '';
      $trip_details['battery'] =  '';
      $trip_details['address'] =  '';
    }

    $g_map_data = $this->get_device_data($id);
    
    // echo "<pre>";
    // print_r($trip_complete_data);die;

    return view('admin.device.live-tracking-trip-completed', compact('id','longitude_data', 'pageTitle','trip_details','g_map_data','trip_complete_data'));
  }

  public function get_trip_alert(Request $request)
  {
    if (auth('admin')->user()->id) {
      $admin_id = auth('admin')->id();
      $role_id = auth('admin')->user()->role_id;
    } else {
      $admin_id = 0;
      $role_id = 0;
    }
    $tripId = $request->tripId;

    $query = DB::table('tc_data_event')
      ->Join('assign_trips', 'tc_data_event.trip_id', '=', 'assign_trips.trip_id')
      ->join('locations as from_locations', 'assign_trips.from_destination', '=', 'from_locations.id')
      ->join('locations as to_locations', 'assign_trips.to_destination', '=', 'to_locations.id')
      ->leftJoin('gps_devices as gd', 'assign_trips.gps_devices_id', '=', 'gd.id')
      ->where('command_word', '!=', '@JT')
      ->where('assign_trips.id', $tripId)
      ->where(function ($query) use ($role_id, $admin_id) {
        // if ($role_id != 0) {
        //   $query->where('assign_trips.admin_id', '=', $admin_id);
        // }
        if ($role_id == 4) {
          $query->where(function ($query) use ($admin_id) {
            $query->where('assign_trips.admin_id', '=', $admin_id)->orWhereRaw('FIND_IN_SET(?, from_locations.admin_id)', [$admin_id])
            ->orWhereRaw('FIND_IN_SET(?, to_locations.admin_id)', [$admin_id]);
          });
        } else if ($role_id != 0) {
          $query->where('assign_trips.admin_id', '=', $admin_id);
        }
      })->select(
        'tc_data_event.*',
      )
      ->orderBy('tc_data_event.id', 'desc');

    $alarm_trip = $query->get();
    $alert = array();
    foreach ($alarm_trip as $key => $value) {
      $trip_info = array();

      $tc_devices = DB::table('tc_devices')->where('uniqueid', $value->device_id)->first();
      if (isset($tc_devices) && !empty($tc_devices)) {
        $positionid = (isset($tc_devices->positionid)) ? $tc_devices->positionid : 0;
        if (!empty($positionid) && isset($positionid)) {
          $tc_positions = DB::table('tc_positions')->where('id', $positionid)->first();
          if (isset($tc_positions->attributes) && !empty($tc_positions->attributes)) {
            $trip_info['address'] = (isset($tc_positions->address) && !empty($tc_positions->address)) ? $tc_positions->address : '';
          }
        } else {
          $trip_info['address'] = '';
        }
      }

      if (isset($value->alert_title)) {
        $alert_title = $value->alert_title;
      } else {
        $alert_title = '';
      }
      if (isset($value->address)) {
        $address = $value->address;
      } else {
        $address = '';
      }
      if (isset($value->time)) {
        $utcDateTime = new DateTime($value->time, new DateTimeZone('UTC'));
    
        $utcDateTime->setTimezone(new DateTimeZone('Asia/Kolkata'));
    
        $time = $utcDateTime->format('d-m-Y H:i:s');
    } else {
        $time = '';
    }
      if (isset($value->rfid_card_number)) {
        $rfid_card_number = $value->rfid_card_number;
    } else {
        $rfid_card_number = '';
    }
  
      $trip_info['date'] = $time;
      $trip_info['address'] = $address;
      $trip_info['alert_title'] = $alert_title;
      $trip_info['rf_card_number']=$rfid_card_number;

      $alert[] =$trip_info;
      
    }
    echo json_encode($alert);
  }


  public function get_device_data($id) {
    if (auth('admin')->user()->id) {
      $admin_id = auth('admin')->id();
      $role_id = auth('admin')->user()->role_id;
    } else {
      $admin_id = 0;
      $role_id = 0;
    }

    $mapdevices = GpsDevice::join('admins', 'gps_devices.admin_id', '=', 'admins.id')
    ->join('roles', 'admins.role_id', '=', 'roles.id')
    ->join('tc_devices', 'gps_devices.device_id', '=', 'tc_devices.uniqueid')
    ->join('assign_trips', 'assign_trips.gps_devices_id', '=', 'gps_devices.id')
    ->join('locations as from_locations', 'assign_trips.from_destination', '=', 'from_locations.id')
    ->join('locations as to_locations', 'assign_trips.to_destination', '=', 'to_locations.id');
      // if (auth('admin')->user()->role_id != 0) {
      //   $mapdevices = $mapdevices->where('admins.id', '=', $admin_id);
      // }
    // if ($role_id == 4) {
    //   $mapdevices->where(function ($query) use ($admin_id) {
    //     $query->where('FIND_IN_SET(?, from_locations.admin_id)', [$admin_id])
    //     ->orWhereRaw('FIND_IN_SET(?, to_locations.admin_id)', [$admin_id]);
    //   });
    // } else if ($role_id != 0) {
    //   $mapdevices = $mapdevices->where('admins.id', '=', $admin_id);
    // }
    $mapdevices = $mapdevices->where('assign_trips.id', '=', $id);
    $mapdevices = $mapdevices->select('gps_devices.*', 'admins.name as customername','admins.mobile_no as customer_no', 
    'admins.date_of_expiry as expirydate','from_locations.location_port_name as from_location_name', 'to_locations.location_port_name as to_location_name')->get();
    
    
  
    
    $trip_info = array();
    foreach ($mapdevices as $key => $value) {
        
        $device_id = $value->device_id ?? '';
        $gps_device_id = $value->id ?? ''; //gps devices table primary key
      
        
       
        if (!empty($device_id) && isset($device_id)) {
            $last_lat ='';
            $last_lon ='';
            $speed = '';
            $address = '';
            $device_status = '';
            $lock = '';
            $batteryLevel = '';

            $tc_devices = DB::table('tc_devices')->where('uniqueid',$device_id)->first();
            $assign_trip = AssignTrip::where('id',$id)->first();
            $tc_event_data = DB::table('tc_data_event')->where('device_id',$device_id)->latest('id')->first();
  
            if(isset($tc_devices->status) && !empty($tc_devices->status)){
                $device_status = $tc_devices->status;  
            }

            if(isset($tc_devices->lastupdate) && !empty($tc_devices->lastupdate)){
                $lastupdate = $tc_devices->lastupdate;
                if(!empty($lastupdate)) {
                    $lastupdateadded = date('Y-m-d H:i:s A', strtotime($lastupdate . ' +5 hours +30 minutes'));
                } else {
                    $lastupdateadded ='';
                }
            }

            if (isset($tc_devices) && !empty($tc_devices)) {
                
                $positionid = (isset($tc_devices->positionid)) ? $tc_devices->positionid : 0;
                $deviceid = (isset($tc_devices->id)) ? $tc_devices->id : 0;

                if (!empty($positionid) && isset($positionid)) {
                    $tc_positions = DB::table('tc_positions')->where('id',$positionid)->where('deviceid',$deviceid)->latest('id')->first();
                    
                    if(isset($tc_positions->latitude) && !empty($tc_positions->latitude)){
                        $last_lat = $tc_positions->latitude;
                    }
                    if(isset($tc_positions->latitude) && !empty($tc_positions->latitude)){
                        $last_lon = $tc_positions->longitude;  
                    }
                    if(isset($tc_positions->speed) && !empty($tc_positions->speed)){
                        $speed = $tc_positions->speed;  
                    }
                    if(isset($tc_positions->address) && !empty($tc_positions->address)){
                        $address = $tc_positions->address;  
                    }

                    if(isset($tc_positions->attributes) && !empty($tc_positions->attributes)){
                        $attributes = json_decode($tc_positions->attributes);
                        if(isset($attributes->lock) && !empty($attributes->lock)){
                          $lock = $attributes->lock;  
                        }
                        if(isset($attributes->batteryLevel) && !empty($attributes->batteryLevel)){
                          $batteryLevel = $attributes->batteryLevel ?? '';    
                        } 
                    }
                }
            }
           
            if(isset($assign_trip->container_details) && !empty($assign_trip->container_details)){
                $container_no = (isset($assign_trip->container_details->container_no) && !empty($assign_trip->container_details->container_no)) ? $assign_trip->container_details->container_no : '';
                $vehicle_no = (isset($assign_trip->container_details->vehicle_no) && !empty($assign_trip->container_details->vehicle_no)) ? $assign_trip->container_details->vehicle_no : '';
            } else {
                $vehicle_no = "";
                $container_no = "";
            }

            if(isset($assign_trip->expected_arrival_time) && !empty($assign_trip->expected_arrival_time)){
                $expected_arrival_time = date('Y-m-d H:i:s A',strtotime($assign_trip->expected_arrival_time));
            } else {
                $expected_arrival_time = "";
            }

            if(isset($assign_trip->trip_start_date) && !empty($assign_trip->trip_start_date)){
                $trip_start_date = date('Y-m-d H:i:s A',strtotime($assign_trip->trip_start_date));
            } else {
                $trip_start_date = "";
            }

            if (isset($value->from_location_name)) { $from_location_name = $value->from_location_name;} else {$from_location_name = '';}
            if (isset($value->to_location_name)) {$to_location_name = $value->to_location_name;} else {$to_location_name = '';}

            
            $primary_id = $assign_trip->id ?? '';
            $position = array();
            $position['lat'] = bcadd($last_lat,'0',6);    
            $position['lng'] = bcadd($last_lon,'0',6); 
            
            $trip_info['device_id'] = $device_id;
            $trip_info['from_location_name'] = $from_location_name;
            $trip_info['to_location_name'] = $to_location_name;
            $trip_info['position'] = $position;
            $trip_info['trip_id'] = $assign_trip->trip_id ?? '';
            $trip_info['vehicle_no'] = $vehicle_no ?? '';
            $trip_info['container_no'] = $container_no ?? '';
            $trip_info['speed'] = $speed ?? '';
            $trip_info['trip_start_date'] = $trip_start_date ?? '';
            $trip_info['expected_arrival_time'] = $expected_arrival_time ?? '';
            $trip_info['address'] = $address ?? '';
            $trip_info['assign_trip_id'] = $primary_id ?? '';
            $trip_info['device_status'] = $device_status ?? '';
            $trip_info['lastupdate'] = $lastupdateadded ?? '';
            $trip_info['lock'] = $lock ?? '';
            $trip_info['battery_level'] = $batteryLevel ?? '';
            
            // $device_data[] = $trip_info;
        }
    }
     
    // $data['device_data'] = $device_data;
  
    return $trip_info;
}


  public function get_live_device_location(Request $request) {

    // $request->
    $id = $request->trip_id ?? '';

    $assign_trip = AssignTrip::select('assign_trips.*','gd.device_id', 'admins.gst_no as gstno','from_locations.location_port_name as from_location_name','to_locations.location_port_name as to_location_name')
    ->join('locations as from_locations', 'assign_trips.from_destination', '=', 'from_locations.id')
    ->join('locations as to_locations', 'assign_trips.to_destination', '=', 'to_locations.id')
    ->join('admins', 'assign_trips.admin_id', '=', 'admins.id')
    ->join('gps_devices as gd', 'assign_trips.gps_devices_id', '=', 'gd.id')
    ->find($id);

  

    $device_id = $assign_trip->device_id ?? '';

    $trip_info = array();
    $latitude ='';
    $longitude ='';
    $address = '';
    $speed ='';
    $batteryLevel ='';
    $odometer ='';
    
    $tc_devices = DB::table('tc_devices')->where('uniqueid',$device_id)->first();
      if (isset($tc_devices) && !empty($tc_devices)) {
        $positionid = (isset($tc_devices->positionid)) ? $tc_devices->positionid : 0;
        if (!empty($positionid) && isset($positionid)) {
          $tc_positions = DB::table('tc_positions')->where('id',$positionid)->latest('id')->first();

          if(isset($tc_positions->latitude) && !empty($tc_positions->latitude)){
            $latitude = $tc_positions->latitude;
          }

          if(isset($tc_positions->longitude) && !empty($tc_positions->longitude)){
            $longitude = $tc_positions->longitude;  
          }
          
          if(isset($tc_positions->speed) && !empty($tc_positions->speed)){
            $speed = $tc_positions->speed;  
          }
          
          if(isset($tc_positions->address) && !empty($tc_positions->address)){
            $address = $tc_positions->address;  
          }

          if(isset($tc_positions->attributes) && !empty($tc_positions->attributes)){
            $attributes = json_decode($tc_positions->attributes);
            if(isset($attributes->batteryLevel) && !empty($attributes->batteryLevel)){
              $batteryLevel = $attributes->batteryLevel;  
            }

            if(isset($attributes->odometer) && !empty($attributes->odometer)){
              $odometer = $attributes->odometer ?? '';    
            } 
          }

        } 

        $trip_info['latitude'] = $latitude;
        $trip_info['longitude'] = $longitude;
        $trip_info['speed'] = $speed;
        $trip_info['address'] = $address;
        $trip_info['batteryLevel'] = $batteryLevel;
        $trip_info['odometer'] = $odometer;
      } else {
        $trip_info['latitude'] ='';
        $trip_info['longitude'] = '';
        $trip_info['speed'] = '';
        $trip_info['address'] ='';
        $trip_info['batteryLevel'] = '';
        $trip_info['odometer'] = '';

      }

      echo json_encode($trip_info);
  }


}
