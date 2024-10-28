<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AssignTrip;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Constants\Status;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;
use App\Mail\AlertMail;
use App\Models\Location;
use Illuminate\Support\Facades\Mail;
class ApiController extends Controller
{
    //

    public function getTripList(Request $request)
    {
        $data_val = array('user_id');
        $validation = param_validation($data_val, $_REQUEST);
        
        if (isset($validation['status']) && $validation['status'] == '0') {
            echo json_encode(array('status' => 'false', 'msg' => $validation['message']));
            die;
        } else {
            $user_id = (isset($request->user_id)) ? trim($request->user_id) : 0;
            // $data    = AssignTrip::where('admin_id',$user_id)->where('status','enable')->where('trip_status','assign')->get();
            $assign_trip = AssignTrip::select('gd.device_id', 'assign_trips.*', 'from_locations.location_port_name as from_location_name', 'to_locations.location_port_name as to_location_name')
                ->join('locations as from_locations', 'assign_trips.from_destination', '=', 'from_locations.id')
                ->join('locations as to_locations', 'assign_trips.to_destination', '=', 'to_locations.id')
                ->join('gps_devices as gd', 'assign_trips.gps_devices_id', '=', 'gd.id')
                ->where('assign_trips.trip_status', 'assign')
                ->where('assign_trips.status', 'enable')
                ->where(function ($query) use ($user_id) {
                    $query->where('assign_trips.admin_id', $user_id)
                    ->orWhereRaw("FIND_IN_SET($user_id, from_locations.admin_id) > 0")
                    ->orWhereRaw("FIND_IN_SET($user_id, to_locations.admin_id) > 0");
                })
                // ->where('assign_trips.admin_id', $user_id)
                // ->orWhere(function ($query) use ($user_id) {
                //     $query->whereRaw("FIND_IN_SET($user_id, from_locations.admin_id) > 0");
                // })
                // ->orWhere(function ($query) use ($user_id) {
                //     $query->whereRaw("FIND_IN_SET($user_id, to_locations.admin_id) > 0");
                // })
                ->get();
            $trip_data = array();
            
            foreach ($assign_trip as $key => $value) {
                $trip = array();

                $trip['admin_id'] = (isset($value->admin_id) && !empty($value->admin_id)) ? $value->admin_id : '';
                $tc_devices_id = DB::table('tc_devices')->where('uniqueid',$value->device_id)->first();

                if(isset($value->container_details) && !empty($value->container_details)){
                    $trip['driver_name'] = (isset($value->container_details->driver_name) && !empty($value->container_details->driver_name)) ? $value->container_details->driver_name : '';
                    $trip['container_no'] = (isset($value->container_details->container_no) && !empty($value->container_details->container_no)) ? $value->container_details->container_no : '';
                    $trip['vehicle_no'] = (isset($value->container_details->vehicle_no) && !empty($value->container_details->vehicle_no)) ? $value->container_details->vehicle_no : '';
                    $trip['license_no'] = (isset($value->container_details->license_no) && !empty($value->container_details->license_no)) ? $value->container_details->license_no : '';
                    $trip['id_proof_no'] = (isset($value->container_details->id_proof_no) && !empty($value->container_details->id_proof_no)) ? $value->container_details->id_proof_no : '';
                    $trip['mobile_no'] = (isset($value->container_details->mobile_no) && !empty($value->container_details->mobile_no)) ? $value->container_details->mobile_no : '';
                    $trip['co_driver_name'] = (isset($value->container_details->co_driver_name) && !empty($value->container_details->co_driver_name)) ? $value->container_details->co_driver_name : '';
                    $trip['co_driver_license_no'] = (isset($value->container_details->co_driver_license_no) && !empty($value->container_details->co_driver_license_no)) ? $value->container_details->co_driver_license_no : '';
                    $trip['co_drive_id_proof_no'] = (isset($value->container_details->co_drive_id_proof_no) && !empty($value->container_details->co_drive_id_proof_no)) ? $value->container_details->co_drive_id_proof_no : '';
                }
                if(isset($value->shipping_details) && !empty($value->shipping_details)){
                    $trip['invoice_no'] = (isset($value->shipping_details->invoice_no) && !empty($value->shipping_details->invoice_no)) ? $value->shipping_details->invoice_no : '';
                    $trip['invoice_date'] = (isset($value->shipping_details->invoice_date) && !empty($value->shipping_details->invoice_date)) ? $value->shipping_details->invoice_date : '';
                    $trip['customer_cif_inr'] = (isset($value->shipping_details->customer_cif_inr) && !empty($value->shipping_details->customer_cif_inr)) ? $value->shipping_details->customer_cif_inr : '';
                    $trip['e_way_bill_no'] = (isset($value->shipping_details->e_way_bill_no) && !empty($value->shipping_details->e_way_bill_no)) ? $value->shipping_details->e_way_bill_no : '';
                    $trip['shipping_details'] = (isset($value->shipping_details->shipping_details) && !empty($value->shipping_details->shipping_details)) ? $value->shipping_details->shipping_details : '';
                    $trip['exporter_details'] = (isset($value->shipping_details->exporter_details) && !empty($value->shipping_details->exporter_details)) ? $value->shipping_details->exporter_details : '';
                    $trip['cargo_type'] = (isset($value->shipping_details->cargo_type) && !empty($value->shipping_details->cargo_type)) ? $value->shipping_details->cargo_type : '';
                    // $trip['start_trip_date'] = (isset($value->shipping_details->start_trip_date) && !empty($value->shipping_details->start_trip_date)) ? $value->shipping_details->start_trip_date : '';
                    // $trip['expected_arrive_time'] = (isset($value->shipping_details->expected_arrive_time) && !empty($value->shipping_details->expected_arrive_time)) ? $value->shipping_details->expected_arrive_time : '';
                    $trip['shipment_type'] = (isset($value->shipping_details->shipment_type) && !empty($value->shipping_details->shipment_type)) ? $value->shipping_details->shipment_type : '';
                }
                
                if(isset($value->trip_start_date)) {$trip['start_trip_date'] = $value->trip_start_date; } else { $trip['start_trip_date'] ='';}
                if(isset($value->expected_arrival_time)) {$trip['expected_arrive_time'] = $value->expected_arrival_time; } else { $trip['expected_arrive_time'] ='';}  

                $trip['trip_id'] = (isset($value->trip_id) && !empty($value->trip_id)) ? $value->trip_id : '';
                $trip['from_destination_id'] = (isset($value->from_destination) && !empty($value->from_destination)) ? $value->from_destination : '';
                $trip['to_destination_id'] = (isset($value->to_destination) && !empty($value->to_destination)) ? $value->to_destination : '';
                $trip['from_location_name'] = (isset($value->from_location_name) && !empty($value->from_location_name)) ? $value->from_location_name : '';
                $trip['to_location_name'] = (isset($value->to_location_name) && !empty($value->to_location_name)) ? $value->to_location_name : '';
                $trip['device_id'] = (isset($value->device_id) && !empty($value->device_id)) ? $value->device_id : '';
                $trip['device_key'] = (isset($tc_devices_id->id) && !empty($tc_devices_id->id)) ? $tc_devices_id->id : '';
                $trip_data[] = $trip;
            }
            if (!empty($trip_data)) {
                echo json_encode(array('status' => 'true', 'data' => $trip_data));
                die;
            } else {
                echo json_encode(array('status' => 'false', 'msg' => 'No data found!'));
                die;
            }
        }
    }


    public function vehicleGpsDetails(Request $request){
        $data_val = array('user_id', 'deviceid');
        $validation = param_validation($data_val, $_REQUEST);
        if (isset($validation['status']) && $validation['status'] == '0') {
            echo json_encode(array('status' => 'false', 'msg' => $validation['message']));
            die;
        } else {
            $user_id  = (isset($request->user_id)) ?  trim($request->user_id) : 0;
            $deviceid = (isset($request->deviceid)) ?  trim($request->deviceid) : 0;
            $user_data = Admin::find($user_id);
            if (isset($user_data) && !empty($user_data)) {
                $tc_devices = DB::table('tc_devices')->where('uniqueid',$deviceid)->first();
                if (isset($tc_devices) && !empty($tc_devices)) {
                    $positionid = (isset($tc_devices->positionid)) ? $tc_devices->positionid : 0;
                    if (!empty($positionid) && isset($positionid)) {
                        $tc_positions = DB::table('tc_positions')->where('id',$positionid)->first();
                        // $tc_positions = DB::table('tc_positions')->where('id',1)->first();
                        
                        
                        $total_km = 0;
                        $speed = 0;
                        $status = '';
                        $last_date_time = '';
                        //$address = '';
                        $operator = '';
                        $is_ignition = 'No';
                        $total_daily_distance = 0;
                        $DeltaDistance = 0;
                        $odo_val = 0;
                        $device_type = '';
                        $battery = 0;
                        $vin = '';
                        $lock = '';
                        $distance = '';
                        $last_lat = 0;
                        $last_lon = 0;
                        $trip_info = array();
                        
                         if(isset($tc_positions->latitude) && !empty($tc_positions->latitude)){
                            $last_lat = $tc_positions->latitude;
                        }
                        if(isset($tc_positions->latitude) && !empty($tc_positions->latitude)){
                            $last_lon = $tc_positions->longitude;  
                        }
                        if(isset($tc_devices->lastupdate) && !empty($tc_devices->lastupdate)){
                            $last_date_time = $tc_devices->lastupdate;  
                        }
                        if(isset($tc_positions->speed) && !empty($tc_positions->speed)){
                            $speed = $tc_positions->speed;  
                        }
                      
                        if(isset($tc_positions->attributes) && !empty($tc_positions->attributes)){
                            $attributes = json_decode($tc_positions->attributes);
                            if(isset($attributes->totalDistance) && !empty($attributes->totalDistance)){
                                $total_km = $attributes->totalDistance;    
                            }
                            if(isset($attributes->operator) && !empty($attributes->operator)){
                                $operator = $attributes->operator;    
                            }
                            if(isset($attributes->ignition) && $attributes->ignition == true){
                                $is_ignition = 'Yes';    
                            }
                            if(isset($attributes->distance) && !empty($attributes->distance)){
                                $total_daily_distance = $attributes->distance;    
                            }
                            if(isset($attributes->totalDistance) && !empty($attributes->totalDistance)){
                                $DeltaDistance = $attributes->totalDistance;    
                            }
                            if(isset($attributes->odometer) && !empty($attributes->odometer)){
                                $odo_val = $attributes->odometer;    
                            }
                            if(isset($attributes->batteryLevel) && !empty($attributes->batteryLevel)){
                                $battery = $attributes->batteryLevel;    
                            }
                            if(isset($attributes->vin) && !empty($attributes->vin)){
                                $vin = $attributes->vin;    
                            }
                            // if(isset($attributes->vin) && !empty($attributes->vin)){
                            //     $lock = $attributes->lock;    
                            // }
                            if(isset($attributes->distance) && !empty($attributes->distance)){
                                $distance = $attributes->distance;    
                            }
                        }
                        $trip_info['address'] = (isset($tc_positions->address) && !empty($tc_positions->address)) ? $tc_positions->address : '';
                        $trip_info['protocol'] = (isset($tc_positions->protocol) && !empty($tc_positions->protocol)) ? $tc_positions->protocol : '';
                        $trip_info['deviceid'] = (isset($tc_positions->deviceid) && !empty($tc_positions->deviceid)) ? $tc_positions->deviceid : '';
                        $trip_info['servertime'] = (isset($tc_positions->servertime) && !empty($tc_positions->servertime)) ? $tc_positions->servertime : '';
                        $trip_info['devicetime'] = (isset($tc_positions->devicetime) && !empty($tc_positions->devicetime)) ? $tc_positions->devicetime : '';
                        $trip_info['fixtime'] = (isset($tc_positions->fixtime) && !empty($tc_positions->fixtime)) ? $tc_positions->fixtime : '';
                        $trip_info['cust_name'] = $user_data['name'];    
                        $trip_info['cust_mobile'] = $user_data['mobile_no'];
                        $trip_info['battery'] =  $battery;
                        $trip_info['last_lat'] = bcadd($last_lat,'0',6);    
                        $trip_info['last_lon'] = bcadd($last_lon,'0',6);    
                        $trip_info['external_battery'] = '';
                        $trip_info['speed'] = $speed;
                        $trip_info['operator_name'] = $operator;
                        $trip_info['last_date_time'] = $last_date_time;
                        $trip_info['is_ignition'] =  $is_ignition;
                        $trip_info['max_speed'] =  0;
                        $trip_info['odo_val'] =  $odo_val;
                        $trip_info['total_daily_distance'] =  bcadd($total_daily_distance,'0',6);
                        $trip_info['vin'] =  $vin;
                        $trip_info['attributes'] =  $attributes;
                        $trip_info['lock'] =  $lock;
                        $trip_info['distance'] =  bcadd($distance,'0',6);
                        $trip_info['status'] =   (isset($tc_devices->status) && !empty($tc_devices->status)) ? $tc_devices->status : '';
                        echo json_encode(array('status' => 'true', 'data' => $trip_info));die;
                    } else {
                        echo json_encode(array('status' => 'false', 'msg' => 'positionid not found.Please check positionid id'));die;
                    }
                } else {
                    echo json_encode(array('status' => 'false', 'msg' => 'Device not found.Please check device id'));die;
                }
            } else {
                echo json_encode(array('status' => 'false', 'msg' => 'Invalid Data!'));die;
            }
        }
    }

    public function checkUserLogin(Request $request) {
        $data_val = array('username', 'password');
        $validation = param_validation($data_val, $_REQUEST);
        if (isset($validation['status']) && $validation['status'] == '0') {
            echo json_encode(array('status' => 'false', 'msg' => $validation['message']));
            die;
        } else {
            $username = trim($request->input('username'));
            $password = trim($request->input('password'));

            $admin = Admin::where('username',$username)->first();
            if(empty($admin)) {
                $result = [
                    'status' => 'false',
                    'msg' => 'user not found',
                ];
                echo json_encode($result);die;
            } else{
                if (!password_verify($password, $admin->password)) 
                {
                    $result = [
                        'status' => 'false',
                        'msg' => 'password is not correct!',
                    ];
                    echo json_encode($result);die;
                } else {
                    $result = [
                        'status' => 'true',
                        'msg' => 'login successfully',
                        'data' => $admin
                    ];
                    echo json_encode($result);die;
                } 
            }
        }
    }

    public function getTripDetails(Request $request) {
        $data_val = array('user_id', 'trip_id');
        $validation = param_validation($data_val, $_REQUEST);
        if (isset($validation['status']) && $validation['status'] == '0') {
            echo json_encode(array('status' => 'false', 'msg' => $validation['message']));
            die;
        } else {
            $user_id = (isset($request->user_id)) ? trim($request->user_id) : 0;
           $trip_id = (isset($request->trip_id)) ? trim($request->trip_id) : 0;
          
            $assign_trip = AssignTrip::select('gd.device_id', 'assign_trips.*', 'from_locations.location_port_name as from_location_name', 'to_locations.location_port_name as to_location_name')
                ->join('locations as from_locations', 'assign_trips.from_destination', '=', 'from_locations.id')
                ->join('locations as to_locations', 'assign_trips.to_destination', '=', 'to_locations.id')
                ->join('gps_devices as gd', 'assign_trips.gps_devices_id', '=', 'gd.id')
                ->where('assign_trips.trip_status', 'assign')
                ->where('assign_trips.status', 'enable')
                ->where('assign_trips.admin_id', $user_id)
                ->where('assign_trips.trip_id', $trip_id)
                ->get();
            $trip_data = array();
            
            foreach ($assign_trip as $key => $value) {
                $trip = array();
                $trip['admin_id'] = (isset($value->admin_id) && !empty($value->admin_id)) ? $value->admin_id : '';
                if(isset($value->container_details) && !empty($value->container_details)){
                    $trip['driver_name'] = (isset($value->container_details->driver_name) && !empty($value->container_details->driver_name)) ? $value->container_details->driver_name : '';
                    $trip['container_no'] = (isset($value->container_details->container_no) && !empty($value->container_details->container_no)) ? $value->container_details->container_no : '';
                    $trip['vehicle_no'] = (isset($value->container_details->vehicle_no) && !empty($value->container_details->vehicle_no)) ? $value->container_details->vehicle_no : '';
                    $trip['license_no'] = (isset($value->container_details->license_no) && !empty($value->container_details->license_no)) ? $value->container_details->license_no : '';
                    $trip['id_proof_no'] = (isset($value->container_details->id_proof_no) && !empty($value->container_details->id_proof_no)) ? $value->container_details->id_proof_no : '';
                    $trip['mobile_no'] = (isset($value->container_details->mobile_no) && !empty($value->container_details->mobile_no)) ? $value->container_details->mobile_no : '';
                    $trip['co_driver_name'] = (isset($value->container_details->co_driver_name) && !empty($value->container_details->co_driver_name)) ? $value->container_details->co_driver_name : '';
                    $trip['co_driver_license_no'] = (isset($value->container_details->co_driver_license_no) && !empty($value->container_details->co_driver_license_no)) ? $value->container_details->co_driver_license_no : '';
                    $trip['co_drive_id_proof_no'] = (isset($value->container_details->co_drive_id_proof_no) && !empty($value->container_details->co_drive_id_proof_no)) ? $value->container_details->co_drive_id_proof_no : '';
                }
                if(isset($value->shipping_details) && !empty($value->shipping_details)){
                    $trip['invoice_no'] = (isset($value->shipping_details->invoice_no) && !empty($value->shipping_details->invoice_no)) ? $value->shipping_details->invoice_no : '';
                    $trip['invoice_date'] = (isset($value->shipping_details->invoice_date) && !empty($value->shipping_details->invoice_date)) ? $value->shipping_details->invoice_date : '';
                    $trip['customer_cif_inr'] = (isset($value->shipping_details->customer_cif_inr) && !empty($value->shipping_details->customer_cif_inr)) ? $value->shipping_details->customer_cif_inr : '';
                    $trip['e_way_bill_no'] = (isset($value->shipping_details->e_way_bill_no) && !empty($value->shipping_details->e_way_bill_no)) ? $value->shipping_details->e_way_bill_no : '';
                    $trip['shipping_details'] = (isset($value->shipping_details->shipping_details) && !empty($value->shipping_details->shipping_details)) ? $value->shipping_details->shipping_details : '';
                    $trip['exporter_details'] = (isset($value->shipping_details->exporter_details) && !empty($value->shipping_details->exporter_details)) ? $value->shipping_details->exporter_details : '';
                    $trip['cargo_type'] = (isset($value->shipping_details->cargo_type) && !empty($value->shipping_details->cargo_type)) ? $value->shipping_details->cargo_type : '';
                    $trip['shipment_type'] = (isset($value->shipping_details->shipment_type) && !empty($value->shipping_details->shipment_type)) ? $value->shipping_details->shipment_type : '';
                }
                $trip['trip_id'] = (isset($value->trip_id) && !empty($value->trip_id)) ? $value->trip_id : '';
                $trip['from_destination_id'] = (isset($value->from_destination) && !empty($value->from_destination)) ? $value->from_destination : '';
                $trip['to_destination_id'] = (isset($value->to_destination) && !empty($value->to_destination)) ? $value->to_destination : '';
                $trip['from_location_name'] = (isset($value->from_location_name) && !empty($value->from_location_name)) ? $value->from_location_name : '';
                $trip['to_location_name'] = (isset($value->to_location_name) && !empty($value->to_location_name)) ? $value->to_location_name : '';
                $trip['device_id'] = (isset($value->device_id) && !empty($value->device_id)) ? $value->device_id : '';
                $trip_data = $trip;
            }
            if (!empty($trip_data)) {
                echo json_encode(array('status' => 'true', 'data' => $trip_data));
                die;
            } else {
                echo json_encode(array('status' => 'false', 'msg' => 'No data found!'));
                die;
            }
        }
    }

    public function getCompletedTripList(Request $request)
    {
        $data_val = array('user_id');
        $validation = param_validation($data_val, $_REQUEST);
        
        if (isset($validation['status']) && $validation['status'] == '0') {
            echo json_encode(array('status' => 'false', 'msg' => $validation['message']));
            die;
        } else {
            $user_id = (isset($request->user_id)) ? trim($request->user_id) : 0;
            $assign_trip = AssignTrip::select('gd.device_id', 'assign_trips.*', 'from_locations.location_port_name as from_location_name', 'to_locations.location_port_name as to_location_name')
                ->join('locations as from_locations', 'assign_trips.from_destination', '=', 'from_locations.id')
                ->join('locations as to_locations', 'assign_trips.to_destination', '=', 'to_locations.id')
                ->join('gps_devices as gd', 'assign_trips.gps_devices_id', '=', 'gd.id')
                ->where('assign_trips.trip_status', 'completed')
                ->where('assign_trips.status', 'enable')
                ->where('assign_trips.admin_id', $user_id)
                ->get();

            $trip_data = array();
            foreach ($assign_trip as $key => $value) {
                $trip = array();
                $trip['admin_id'] = (isset($value->admin_id) && !empty($value->admin_id)) ? $value->admin_id : '';
                if(isset($value->container_details) && !empty($value->container_details)){
                    $trip['driver_name'] = (isset($value->container_details->driver_name) && !empty($value->container_details->driver_name)) ? $value->container_details->driver_name : '';
                    $trip['container_no'] = (isset($value->container_details->container_no) && !empty($value->container_details->container_no)) ? $value->container_details->container_no : '';
                    $trip['vehicle_no'] = (isset($value->container_details->vehicle_no) && !empty($value->container_details->vehicle_no)) ? $value->container_details->vehicle_no : '';
                    $trip['license_no'] = (isset($value->container_details->license_no) && !empty($value->container_details->license_no)) ? $value->container_details->license_no : '';
                    $trip['id_proof_no'] = (isset($value->container_details->id_proof_no) && !empty($value->container_details->id_proof_no)) ? $value->container_details->id_proof_no : '';
                    $trip['mobile_no'] = (isset($value->container_details->mobile_no) && !empty($value->container_details->mobile_no)) ? $value->container_details->mobile_no : '';
                    $trip['co_driver_name'] = (isset($value->container_details->co_driver_name) && !empty($value->container_details->co_driver_name)) ? $value->container_details->co_driver_name : '';
                    $trip['co_driver_license_no'] = (isset($value->container_details->co_driver_license_no) && !empty($value->container_details->co_driver_license_no)) ? $value->container_details->co_driver_license_no : '';
                    $trip['co_drive_id_proof_no'] = (isset($value->container_details->co_drive_id_proof_no) && !empty($value->container_details->co_drive_id_proof_no)) ? $value->container_details->co_drive_id_proof_no : '';
                }
                if(isset($value->shipping_details) && !empty($value->shipping_details)){
                    $trip['invoice_no'] = (isset($value->shipping_details->invoice_no) && !empty($value->shipping_details->invoice_no)) ? $value->shipping_details->invoice_no : '';
                    $trip['invoice_date'] = (isset($value->shipping_details->invoice_date) && !empty($value->shipping_details->invoice_date)) ? $value->shipping_details->invoice_date : '';
                    $trip['customer_cif_inr'] = (isset($value->shipping_details->customer_cif_inr) && !empty($value->shipping_details->customer_cif_inr)) ? $value->shipping_details->customer_cif_inr : '';
                    $trip['e_way_bill_no'] = (isset($value->shipping_details->e_way_bill_no) && !empty($value->shipping_details->e_way_bill_no)) ? $value->shipping_details->e_way_bill_no : '';
                    $trip['shipping_details'] = (isset($value->shipping_details->shipping_details) && !empty($value->shipping_details->shipping_details)) ? $value->shipping_details->shipping_details : '';
                    $trip['exporter_details'] = (isset($value->shipping_details->exporter_details) && !empty($value->shipping_details->exporter_details)) ? $value->shipping_details->exporter_details : '';
                    $trip['cargo_type'] = (isset($value->shipping_details->cargo_type) && !empty($value->shipping_details->cargo_type)) ? $value->shipping_details->cargo_type : '';
                    $trip['shipment_type'] = (isset($value->shipping_details->shipment_type) && !empty($value->shipping_details->shipment_type)) ? $value->shipping_details->shipment_type : '';
                }
                $trip['trip_id'] = (isset($value->trip_id) && !empty($value->trip_id)) ? $value->trip_id : '';
                $trip['from_destination_id'] = (isset($value->from_destination) && !empty($value->from_destination)) ? $value->from_destination : '';
                $trip['to_destination_id'] = (isset($value->to_destination) && !empty($value->to_destination)) ? $value->to_destination : '';
                $trip['from_location_name'] = (isset($value->from_location_name) && !empty($value->from_location_name)) ? $value->from_location_name : '';
                $trip['to_location_name'] = (isset($value->to_location_name) && !empty($value->to_location_name)) ? $value->to_location_name : '';
                $trip['device_id'] = (isset($value->device_id) && !empty($value->device_id)) ? $value->device_id : '';
                $trip_data[] = $trip;
            }
            if (!empty($trip_data)) {
                echo json_encode(array('status' => 'true', 'data' => $trip_data));
                die;
            } else {
                echo json_encode(array('status' => 'false', 'msg' => 'No data found!'));
                die;
            }
        }
    }
    
    public function push_data(Request $request) {

        $id = (isset($request->id)) ? trim($request->id) : 0;
        $latitude = (isset($request->latitude)) ? trim($request->latitude) : '';
        $longitude = (isset($request->longitude)) ? trim($request->longitude) : '';
        $batteryLevel = (isset($request->batteryLevel)) ? trim($request->batteryLevel) : '';
        $timestamp = (isset($request->timestamp)) ? trim($request->timestamp) : '';
        $vin = (isset($request->vin)) ? trim($request->vin) : '';
        $speed = (isset($request->speed)) ? trim($request->speed) : '';
        $odometer = (isset($request->odometer)) ? trim($request->odometer) : '';
        $ignition = (isset($request->ignition)) ? trim($request->ignition) : '';
        $fault = (isset($request->fault)) ? trim($request->fault) : '';
        $tampering = (isset($request->tampering)) ? trim($request->tampering) : '';
        $vibration = (isset($request->vibration)) ? trim($request->vibration) : '';

        $vinDescription = (isset($request->vinDescription)) ? trim($request->vinDescription) : '';
        $geofenceEnter = (isset($request->geofenceEnter)) ? trim($request->geofenceEnter) : '';
        $geofenceExit = (isset($request->geofenceExit)) ? trim($request->geofenceExit) : '';
        $powerCut = (isset($request->powerCut)) ? trim($request->powerCut) : '';
        $fallDown = (isset($request->fallDown)) ? trim($request->fallDown) : '';
        $jamming = (isset($request->jamming)) ? trim($request->jamming) : '';
        $tow = (isset($request->tow)) ? trim($request->tow) : '';
        $removing = (isset($request->removing)) ? trim($request->removing) : '';
        $lowBattery = (isset($request->lowBattery)) ? trim($request->lowBattery) : '';
        $powerRestored = (isset($request->powerRestored)) ? trim($request->powerRestored) : '';

        $bit14 = (isset($request->bit14)) ? trim($request->bit14) : '';
        $bit15 = (isset($request->bit15)) ? trim($request->bit15) : '';
        $bit16 = (isset($request->bit16)) ? trim($request->bit16) : '';

        $address = (isset($request->address)) ? trim($request->address) : '';

        
        
        $json = json_encode([
            'id' => $id,
            'latitude' => $latitude,
            'longitude' => $longitude,
            'address' => $address,
            'batteryLevel' => $batteryLevel,
            'timestamp' => $timestamp,
            'vin' => $vin,
            'speed' => $speed,
            'odometer' => $odometer,
            'ignition' => $ignition,
            'fault' => $fault,
            'tampering' => $tampering,
            'vibration' => $vibration,
            'vinDescription'=> $vinDescription,
            'geofenceEnter' => $geofenceEnter,
            'geofenceExit' => $geofenceExit,

            'powerCut' => $powerCut,
            'fallDown' => $fallDown,
            'jamming' => $jamming,
            'tow' => $tow,
            'removing' => $removing,
            'lowBattery' => $lowBattery,
            'powerRestored' => $powerRestored,
            'bit14' => $bit14,
            'bit15' => $bit15,
            'bit16' => $bit16,
        ]);

        if(DB::table('tc_data')->insert([
            'attributes' => $json,
            'device_id' =>$id,
            'latitude'=> $latitude,
            'longitude' => $longitude,
            'address' => $address,
            'batteryLevel' => $batteryLevel,
            'timestamp' => $timestamp,
            'vin' => $vin,
            'speed' => $speed,
            'odometer' => $odometer,
            'ignition' => $ignition,
            'fault' => $fault,
            'tampering' => $tampering,
            'vibration' => $vibration,
            'bit14' => $bit14,
            'bit15' => $bit15,
            'bit16' => $bit16,
            'created_at'=>date('Y-m-d H:i:s'),
            'updated_at'=>date('Y-m-d H:i:s'),
        ])){
            echo json_encode(array('status' => 'true', 'data' => json_decode($json),'message'=> 'Data save Successfully.'));
            die;
        } else  {
            echo json_encode(array('status' => 'false', 'data' => $json,'message'=> 'Fail to save Data.'));
            die;
        }

    }

    public function push_data_event(Request $request) {

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
            $new_msg = $title.' / '.$message;


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

                echo json_encode(array('status' => 'true', 'data' => json_decode($json),'message'=> 'Data save Successfully.'));
                die;
            } else  {
                echo json_encode(array('status' => 'false', 'data' => $json,'message'=> 'Fail to save Data.'));
                die;
            }
        }
    }

    public function get_notification(Request $request){
        $data_val = array('user_id');
        $validation = param_validation($data_val,$_REQUEST);
        
        if(isset($validation['status']) && $validation['status']=='0'){
            echo json_encode(array('status'=>'false','msg'=>$validation['message']));die;
        } else {
            $user_id=$request->user_id ?? '';
            $checkDeviceExist = DB::table('gps_devices')->where('admin_id', $user_id)->first();
           
            if (!empty($checkDeviceExist)) {
                $device_id = $checkDeviceExist->device_id ?? '';
                $results = DB::table('gps_devices')
                ->join('tc_data_event', 'gps_devices.device_id', '=', 'tc_data_event.device_id')
                ->where('admin_id', '=', $user_id)
                ->where('command_word', '!=', '@JT')
                ->select(
                    'alert_naration',
                    'trip_id',
                    'alert_title',
                    'rfid_card_number',
                    'tc_data_event.event_source_type',
                    DB::raw('IFNULL(tc_data_event.address, "") AS address'),
                    'tc_data_event.created_at',
                    'tc_data_event.unlock_verification',
                    DB::raw('CAST(latitude AS DECIMAL(20, 6)) AS latitude'),
                    DB::raw('CAST(longitude AS DECIMAL(20, 6)) AS longitude')
                )
                //->select('alert_naration', 'trip_id', 'alert_title', 'rfid_card_number', 'latitude', 'longitude')
                ->orderBy('tc_data_event.id', 'DESC')
                ->get();
            
                if(!empty($results)) {
                    echo json_encode(array('status' => 'true', 'data' => $results,'message'=> 'Data fetch Successfully.'));
                } else {
                    echo json_encode(array('status' => 'false', 'data' => '','message'=> 'No data found'));
                }
                die;
            }
        }
    }

    public function get_trip_notification(Request $request){
        $data_val = array('user_id','trip_id','device_id');
        $validation = param_validation($data_val,$_REQUEST);
        
        if(isset($validation['status']) && $validation['status']=='0'){
            echo json_encode(array('status'=>'false','msg'=>$validation['message']));die;
        } else {
            $user_id=$request->user_id ?? '';
            $trip_id=$request->trip_id ?? '';
            $device_id_param = $request->device_id ?? '';
            $checkDeviceExist = DB::table('gps_devices')->where('admin_id', $user_id)->first();
           
            if (!empty($checkDeviceExist)) {
               // $device_id = $checkDeviceExist->device_id ?? '';
                $results = DB::table('gps_devices')
                ->join('tc_data_event', 'gps_devices.device_id', '=', 'tc_data_event.device_id')
                ->where('admin_id', '=', $user_id)
                ->where('gps_devices.device_id', '=', $device_id_param)
                ->where('tc_data_event.trip_id', '=', $trip_id)
                ->where('tc_data_event.command_word', '!=', '@JT')
                ->select(
                    'alert_naration',
                    'trip_id',
                    'alert_title',
                    'rfid_card_number',
                    DB::raw('IFNULL(tc_data_event.address, "") AS address'),
                    'tc_data_event.created_at',
                    'tc_data_event.event_source_type',
                    'tc_data_event.unlock_verification',
                    DB::raw('CAST(latitude AS DECIMAL(20, 6)) AS latitude'),
                    DB::raw('CAST(longitude AS DECIMAL(20, 6)) AS longitude')
                )
                ->orderBy('tc_data_event.id', 'DESC')
                ->get();
            
                if(!empty($results)) {
                    echo json_encode(array('status' => 'true', 'data' => $results,'message'=> 'Data fetch Successfully.'));
                } else {
                    echo json_encode(array('status' => 'false', 'data' => '','message'=> 'No data found'));
                }
                die;
            } else {
                echo json_encode(array('status' => 'false', 'data' => '','message'=> 'Device Not found'));die;
            }
        }
    }

    public function send_notification($device_token,$id,$event_source_type,$unlock_verification,$rfid_card_number,$password_verification,$incorrect_password) {
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

    public function update_device_token(Request $request){
        $current_time=date('Y-m-d H:i:s',time());
        $data_val = array('user_id','device_token');

        $validation = param_validation($data_val,$_REQUEST);
        
        if(isset($validation['status']) && $validation['status']=='0'){
            echo json_encode(array('status'=>'false','msg'=>$validation['message']));die;
        } else {
            $device_token=$_REQUEST['device_token'];
            $user_id=$_REQUEST['user_id'];
            $userDetails = Admin::where('id',$user_id)->first();

            // if(!empty($userDetails)) {
            //     $saveAllLogin = array('user_id'=>$user_id,'device_token'=>$device_token,'created_date'=>$current_time);

            //     $checkLoginExist =  DB::table('tbl_notification')->where('device_token',$device_token)->first();
                
            //     if(DB::table('tbl_notification')->insert([
            //         'user_id' => $user_id,
            //         'device_token' => $device_token,
            //         'created_date' => date('Y-m-d H:i:s')
            //     ])){
            //         $json = array('status'=>'true',"msg"=>"Device token insert successfully!");
            //         echo json_encode($json);
            //         die;
            //     } else  {
            //         echo json_encode(array('status' => 'false','message'=> 'Fail to save Data.'));
            //         die;
            //     }
            // }

            if (!empty($userDetails)) {
                $saveAllLogin = array('user_id' => $user_id, 'device_token' => $device_token, 'created_date' => $current_time);
                $checkLoginExist = DB::table('tbl_notification')->where('device_token', $device_token)->first();
            
                if ($checkLoginExist) {
                    // Update the existing record if device token already exists
                    DB::table('tbl_notification')->where('device_token', $device_token)->update([
                        'user_id' => $user_id,
                        'created_date' => date('Y-m-d H:i:s')
                    ]);
                    $json = array('status' => 'true', "msg" => "Device token updated successfully!");
                    echo json_encode($json);
                    die;
                } else {
                    // Insert a new record if device token doesn't exist
                    if (DB::table('tbl_notification')->insert([
                        'user_id' => $user_id,
                        'device_token' => $device_token,
                        'created_date' => date('Y-m-d H:i:s')
                    ])) {
                        $json = array('status' => 'true', "msg" => "Device token inserted successfully!");
                        echo json_encode($json);
                        die;
                    } else {
                        echo json_encode(array('status' => 'false', 'message' => 'Fail to save Data.'));
                        die;
                    }
                }
            } else {
                echo json_encode(array("status" =>'false',"msg"=>"Invalid user id!"));
                die;
            }
            
        }
    }
    
    public function getStoredSetting()
    {
      	$current_time=date('Y-m-d H:i:s',time());
	    $data_val = array('user_id');
			$validation = param_validation($data_val,$_REQUEST);
        	if(isset($validation['status']) && $validation['status']=='0')
			{echo json_encode(array('status'=>'false','msg'=>$validation['message']));die;
			}else{
			    $user_id=$_REQUEST['user_id'];
				 $userDetails = Admin::where('id',$user_id)->first();
			
			if(isset($userDetails) && !empty($userDetails)){
			    $agent_app_version = DB::table('tbl_app_version')->where('id','1')->first();
                $user_app_version = DB::table('tbl_app_version')->where('id','2')->first();
                
                if(isset($agent_app_version->version) && !empty($agent_app_version->version)){ $agent_app_version1=$agent_app_version->version;}else{$agent_app_version1="";}
                if(isset($user_app_version->version) && !empty($user_app_version->version)){ $user_app_version1=$user_app_version->version;}else{$user_app_version1="";}

                $arr= array('status'=>'true',"user_app_version"=>$user_app_version1,'msg'=>'App Details!');  
                if(isset($arr) && !empty($arr)){
                  echo json_encode($arr);die;
                }else{
                      echo json_encode(array('status'=>'false','msg'=>'No Settings Found'));die;
                }
    		}else{
                echo json_encode(array('status'=>'false','msg'=>'Invalid User Id'));die;
            }
	}
        
  }
    
}
