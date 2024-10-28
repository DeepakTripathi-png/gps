<?php

namespace App\Http\Controllers\Admin;
use App\Models\GpsDevice;
use App\Models\Location;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\AssignTrip;
use Illuminate\Support\Str;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Mail\TripCompleteMail;
use App\Mail\AssignTripMail;
use PDF;
use Illuminate\Support\Facades\Mail;
use App\Models\Admin;
use Swift_TransportException;


class TripsController extends Controller
{

    public function assign_trip()
    {

          $pagetitle = "Assign/Add Trip";
          if (auth('admin')->user()->id){
            $admin_id = auth('admin')->id();
            $role_id = auth('admin')->user()->role_id;
          } else {
            $admin_id = 0;
            $role_id = 0;
          }
    
          $locations = Location::where('status','enable')->where(function ($query) use ($role_id, $admin_id) {
            if ($role_id != 0) {
              $query->whereRaw("FIND_IN_SET($admin_id, locations.admin_id)");
            }
          })->get();
    
          if($role_id == 4) {
            $locations_group =  Location::where('status','enable')->where(function ($query) use ($role_id, $admin_id) {
              $query->whereRaw("FIND_IN_SET($admin_id, locations.admin_id)");
            })->groupBy('created_by')->first();
    
            $created_by_id = $locations_group->created_by ?? $locations_group->created_by ?? '';
    
            $gps_devices = GpsDevice::where('admin_id', $created_by_id)->where(function ($query) {
            $query->whereNull('current_trip_id')->orWhere('current_trip_id', '');})->get();
          } else {
            $gps_devices = GpsDevice::where('admin_id', $admin_id)->where(function ($query) {
              $query->whereNull('current_trip_id')->orWhere('current_trip_id', '');})->get();
          }
          
      
         
          return view('admin.trip.assign-trip', compact('pagetitle','gps_devices', 'locations'));
    }

    public function get_assign_trip_details(Request $request) {
      if (auth('admin')->user()->id){
        $admin_id = auth('admin')->id();
        $role_id = auth('admin')->user()->role_id;
      } else {
        $admin_id = 0;
        $role_id = 0;
      }

      $search = $request->search['value'];

      $query = AssignTrip::join('locations as from_locations', 'assign_trips.from_destination', '=', 'from_locations.id')
        ->join('locations as to_locations', 'assign_trips.to_destination', '=', 'to_locations.id')
        ->join('gps_devices as gd', 'assign_trips.gps_devices_id', '=', 'gd.id')
        ->where('assign_trips.trip_status','assign')
        ->where('assign_trips.status','enable')
        ->where(function ($query) use($role_id,$admin_id) {
          if ($role_id == 4) {
            $query->where(function ($query) use ($admin_id) {
              $query->where('assign_trips.admin_id', '=', $admin_id)->orWhereRaw('FIND_IN_SET(?, from_locations.admin_id)', [$admin_id])
              ->orWhereRaw('FIND_IN_SET(?, to_locations.admin_id)', [$admin_id]);
            });
          } else if ($role_id == 5) {
            $query->where(function ($query) use ($admin_id) {
              $query->where('assign_trips.admin_id', '=', $admin_id)->orWhereRaw('FIND_IN_SET(?, from_locations.customs_admin_id)', [$admin_id])
              ->orWhereRaw('FIND_IN_SET(?, to_locations.customs_admin_id)', [$admin_id]);
            });
          } else if ($role_id != 0) {
            $query->where('assign_trips.admin_id', '=', $admin_id);
          }
        });

      $totalRecords = $query->count();

      $query->select('gd.device_id','assign_trips.*', 'from_locations.location_port_name as from_location_name','to_locations.location_port_name as to_location_name');
      if (!empty($search)) {
        $query = $query->where(function ($query) use ($search){
          $query->where('assign_trips.trip_id', 'like', '%' . $search . '%');
          // ->orWhere('admins.mobile_no', 'like', '%' . $search . '%');
        });
      }

      $filteredRecords = $query->count();
      $assign_trip = $query->skip(intval($request->start))->take(intval($request->length))->get();

     $trips = array();
     foreach ($assign_trip as $key => $value) {
       $trip_info = array();
       $trip_info['address'] = '';
       $tc_devices = DB::table('tc_devices')->where('uniqueid',$value->device_id)->first();
       if (isset($tc_devices) && !empty($tc_devices)) {
         $positionid = (isset($tc_devices->positionid)) ? $tc_devices->positionid : 0;
         if (!empty($positionid) && isset($positionid)) {
           $tc_positions = DB::table('tc_positions')->where('id',$positionid)->first();
           if(isset($tc_positions->attributes) && !empty($tc_positions->attributes)){
             $trip_info['address'] = (isset($tc_positions->address) && !empty($tc_positions->address)) ? $tc_positions->address : '';
           }
         } else {
           $trip_info['address'] = '';
         }
       }

       if(isset($value->container_details->driver_name)) {$driver_name = $value->container_details->driver_name; } else { $driver_name ='';}
       if(isset($value->container_details->vehicle_no)) {$vehicle_no = $value->container_details->vehicle_no; } else { $vehicle_no ='';}
       if(isset($value->container_details->mobile_no)) {$mobile_no = $value->container_details->mobile_no; } else { $mobile_no ='';}
       if(isset($value->id)) {$id = $value->id; } else { $id ='';}
       if(isset($value->from_location_name)) {$from_location_name = $value->from_location_name; } else { $from_location_name ='';}
       if(isset($value->trip_id)) {$trip_id = $value->trip_id; } else { $trip_id ='';}
       if(isset($value->to_location_name)) {$to_location_name = $value->to_location_name; } else { $to_location_name ='';}
       if(isset($value->shipping_details->shipment_type)) {$shipment_type = $value->shipping_details->shipment_type; } else { $shipment_type ='';}
       if(isset($value->shipping_details->cargo_type)) {$cargo_type = $value->shipping_details->cargo_type; } else { $cargo_type ='';}
       if(isset($value->trip_start_date)) {$start_trip_date = $value->trip_start_date; } else { $start_trip_date ='';}
       if(isset($value->expected_arrival_time)) {$expected_arrive_time = $value->expected_arrival_time; } else { $expected_arrive_time ='';}
       if(isset($value->completed_trip_time)) {$completed_trip_time = $value->completed_trip_time; } else { $completed_trip_time ='';}  
 
       if(isset($tc_devices->id)) {$tc_device_id = $tc_devices->id; } else { $tc_device_id ='';}
       if(isset($tc_devices->lastupdate)) {$lastupdate = $tc_devices->lastupdate; } else { $lastupdate ='';}
       if(isset($value->trip_status)) { $trip_status = $value->trip_status; } else { $trip_status ='';}
       $device_status = (isset($tc_devices->status) && !empty($tc_devices->status)) ? $tc_devices->status : '';  
     
      $action='';

      if(can(['admin.trips.edit-trip', 'admin.trips.trip-details'])) {
        if(can('admin.trips.edit-trip')) {
          $action .='<a class="" href="'. route("admin.trips.edit-trip", ["id" => $id]) . '"><img class="p-1" data-toggle="tooltip" data-placement="top" title="Edit Trip"  src="'.asset("assets/icon/edit.png").'" /></a>';
        }
        if(can('admin.trips.trip-details')) {
          $action .='<a class="" href="'.route('admin.trips.trip-details', ['id' => $id, 'trip_id' =>  $trip_id ] ).'"><img class="p-1" data-toggle="tooltip" data-placement="top" title="Trip Details"  src="'.asset('assets/icon/trip-summary.png').'" /></a>';
        }
        $action .='<img class="cursor-pointer p-1 dropdown-toggle dropdown-toggle-split js-device-details"  data-device-id="'.$tc_device_id.'" data-bs-toggle="dropdown" src="'.asset('assets/icon/device-detail.png').'" />';
        $action .='<div class="dropdown-menu dropdown-menu-right dropdown-menu-lg-end">
        <div class="container text-center ">
          <div class="text-start">
            <h6 style="font-size:13px;">Device Details</h6>
          </div>
          <div class="col-12">
            <div class="row">
              <div class="col-6 pb-1 px-1 border-end">
                <img  src="'.asset('assets/icon/battery.png').'" />
                  <label class="d-block device-title"> <span class="js-battery-percentage"></span>%</label>
              </div>
              <div class="col-6 pb-1 px-1">
                <img src="'.asset('assets/icon/account-online.png').'" />
                <label class="d-block device-title js-device-status"></label>
              </div>
            </div>
            <hr class="my-0">

            <div class="row">
              <div class="col-6 pt-1 px-1 border-end">
                <img  src="'.asset('assets/icon/round-lock.png').'" />
                  <label class="d-block device-title js-device-lock-status"> Lock</label>
              </div>
              
              <div class="col-6 pt-1 px-1">
                <img  src="'.asset('assets/icon/speedometer.png').'" />
                  <label class="d-block device-title"> <span class="js-vehical-speed"> </span> Km/h</label>
              </div>
            </div>
          </div>
        </div>
      </div>';
      }
      if($trip_status == 'assign') {
        $action .='<img class="p-1 js-ps-trip-completed confirmationBtn cursor-pointer" data-action="'.route('admin.trips.completed-trip-status', ['id' => $id]).'" data-question="Are you sure you want to complete this trip?" data-toggle="tooltip" data-placement="top" title="Trip Complete"  src="'.asset('assets/icon/trip-finish.png').'" />';
      }
      $action .='<a href="'.route('admin.device.live-tracking',["id" => $id]).'"><img class="p-1" src="'.asset('assets/icon/live-tracking.png').'" /></a>';
      $color = '';
      if ($device_status == 'online') {
        $color = 'text--success';
      } elseif ($device_status == 'offline') {
        $color = 'text--danger';
      } else {
        $color = 'text--danger';
      }

       $trips[] = array(
        $action,
        $id,
        $trip_id,
        "<span class=".$color.">".$device_status."</span>",
        $cargo_type,
        $shipment_type,
        $from_location_name.' - '.$to_location_name,
        $trip_info['address'],
        $driver_name,
        $vehicle_no,
        $mobile_no,
        $start_trip_date,
        $expected_arrive_time,
        $completed_trip_time,
        $lastupdate,
        $trip_status
       );
     }

     $output = array(
        "draw" => $_POST['draw'],
        "recordsTotal" => $totalRecords,
        "recordsFiltered" => $filteredRecords,
        "data" => $trips,
      );
    echo json_encode($output);

    }
    public function ongoing_trips()
    {
      if (auth('admin')->user()->id){
        $admin_id = auth('admin')->id();
        $role_id = auth('admin')->user()->role_id;
      } else {
        $admin_id = 0;
        $role_id = 0;
      }
      $pagetitle = "Ongoing Trips";


      return view('admin.trip.ongoing-trips',compact('pagetitle'));
    }

    public function get_ongoing_trips(Request $request) {

      if (auth('admin')->user()->id){
        $admin_id = auth('admin')->id();
        $role_id = auth('admin')->user()->role_id;
      } else {
        $admin_id = 0;
        $role_id = 0;
      }

      $search = $request->search['value'];

      $query = AssignTrip:: join('locations as from_locations', 'assign_trips.from_destination', '=', 'from_locations.id')
      ->join('locations as to_locations', 'assign_trips.to_destination', '=', 'to_locations.id')
      ->join('gps_devices as gd', 'assign_trips.gps_devices_id', '=', 'gd.id')
      ->where(function ($query) use($role_id,$admin_id) {
        if ($role_id == 4) {
          $query->where(function ($query) use ($admin_id) {
            $query->where('assign_trips.admin_id', '=', $admin_id)->orWhereRaw('FIND_IN_SET(?, from_locations.admin_id)', [$admin_id])
            ->orWhereRaw('FIND_IN_SET(?, to_locations.admin_id)', [$admin_id]);
          });
        } else if($role_id == 5) {
          $query->where(function ($query) use ($admin_id) {
            $query->where('assign_trips.admin_id', '=', $admin_id)->orWhereRaw('FIND_IN_SET(?, from_locations.customs_admin_id)', [$admin_id])
            ->orWhereRaw('FIND_IN_SET(?, to_locations.customs_admin_id)', [$admin_id]);
          });
        } else if ($role_id != 0) {
          $query->where('assign_trips.admin_id', '=', $admin_id);
        }
      })->where('trip_status','assign');
      
      $totalRecords = $query->count();
      $query->select('gd.device_id','assign_trips.*', 'from_locations.location_port_name as from_location_name','to_locations.location_port_name as to_location_name');
      if (!empty($search)) {
        $query = $query->where(function ($query) use ($search){
          $query->where('assign_trips.trip_id', 'like', '%' . $search . '%');
          // ->orWhere('admins.mobile_no', 'like', '%' . $search . '%');
        });
      }

      $filteredRecords = $query->count();
      $ongoing_trip = $query->skip(intval($request->start))->take(intval($request->length))->get();
      
     
      $trips = array();
      foreach ($ongoing_trip as $key => $value) {
        $trip_info = array();
        $trip_info['address'] = '';
        $tc_devices = DB::table('tc_devices')->where('uniqueid',$value->device_id)->first();
        if (isset($tc_devices) && !empty($tc_devices)) {
          $positionid = (isset($tc_devices->positionid)) ? $tc_devices->positionid : 0;
          if (!empty($positionid) && isset($positionid)) {
            $tc_positions = DB::table('tc_positions')->where('id',$positionid)->first();
            if(isset($tc_positions->attributes) && !empty($tc_positions->attributes)){
              $trip_info['address'] = (isset($tc_positions->address) && !empty($tc_positions->address)) ? $tc_positions->address : '';
            }
          } else {
            $trip_info['address'] = '';
          }
        }

        if(isset($value->container_details->driver_name)) {$driver_name = $value->container_details->driver_name; } else { $driver_name ='';}
        if(isset($value->container_details->vehicle_no)) {$vehicle_no = $value->container_details->vehicle_no; } else { $vehicle_no ='';}
        if(isset($value->container_details->mobile_no)) {$mobile_no = $value->container_details->mobile_no; } else { $mobile_no ='';}
        if(isset($value->id)) {$id = $value->id; } else { $id ='';}
        if(isset($value->from_location_name)) {$from_location_name = $value->from_location_name; } else { $from_location_name ='';}
        if(isset($value->trip_id)) {$trip_id = $value->trip_id; } else { $trip_id ='';}
        if(isset($value->to_location_name)) {$to_location_name = $value->to_location_name; } else { $to_location_name ='';}
        if(isset($value->shipping_details->shipment_type)) {$shipment_type = $value->shipping_details->shipment_type; } else { $shipment_type ='';}
        if(isset($value->shipping_details->cargo_type)) {$cargo_type = $value->shipping_details->cargo_type; } else { $cargo_type ='';}
        if(isset($value->trip_start_date)) {$start_trip_date = $value->trip_start_date; } else { $start_trip_date ='';}
        if(isset($value->expected_arrival_time)) {$expected_arrive_time = $value->expected_arrival_time; } else { $expected_arrive_time ='';}  
        if(isset($value->completed_trip_time)) {$completed_trip_time = $value->completed_trip_time; } else { $completed_trip_time ='';}  
        if(isset($tc_devices->id)) {$tc_device_id = $tc_devices->id; } else { $tc_device_id ='';}
        if(isset($value->trip_status)) {$trip_status = $value->trip_status; } else { $trip_status ='';}
        if(isset($tc_devices->lastupdate)) {$lastupdate = $tc_devices->lastupdate; } else { $lastupdate ='';}
        $device_status = (isset($tc_devices->status) && !empty($tc_devices->status)) ? $tc_devices->status : '';  

        // $trip_info['device_status'] = (isset($tc_devices->status) && !empty($tc_devices->status)) ? $tc_devices->status : '';  
        // $trip_info['driver_name'] = $driver_name;
        // $trip_info['trip_id'] = $trip_id;
        // $trip_info['from_location_name'] = $from_location_name;
        // $trip_info['to_location_name'] = $to_location_name;
        // $trip_info['vehicle_no'] = $vehicle_no;
        // $trip_info['mobile_no'] = $mobile_no;
        // $trip_info['shipment_type'] = $shipment_type;
        // $trip_info['cargo_type'] = $cargo_type;
        // $trip_info['start_trip_date'] = $start_trip_date;
        // $trip_info['expected_arrive_time'] = $expected_arrive_time;
        // $trip_info['completed_trip_time'] = $completed_trip_time;
        // $trip_info['tc_device_id'] = $tc_device_id;
        // $trip_info['id'] = $id;
        // $trip_info['trip_status'] = $trip_status;
        // $trip_info['lastupdate'] = $lastupdate;
        // $action='';
        // $trips[] = $trip_info;

        $action='';
        if(can(['admin.trips.edit-trip', 'admin.trips.trip-details'])) {
          if(can('admin.trips.edit-trip')) {
            $action .='<a class="" href="'. route("admin.trips.edit-trip", ["id" => $id]) . '"><img class="p-1" data-toggle="tooltip" data-placement="top" title="Edit Trip"  src="'.asset("assets/icon/edit.png").'" /></a>';
          }
          if(can('admin.trips.trip-details')) {
            $action .='<a class="" href="'.route('admin.trips.trip-details',['id' => $id, 'trip_id' =>  $trip_id ] ).'"><img class="p-1" data-toggle="tooltip" data-placement="top" title="Trip Details"  src="'.asset('assets/icon/trip-summary.png').'" /></a>';
          }
          $action .='<img class="cursor-pointer p-1 dropdown-toggle dropdown-toggle-split js-device-details"  data-device-id="'.$tc_device_id.'" data-bs-toggle="dropdown" src="'.asset('assets/icon/device-detail.png').'" />';
          $action .='<div class="dropdown-menu dropdown-menu-right dropdown-menu-lg-end">
          <div class="container text-center ">
            <div class="text-start">
              <h6 style="font-size:13px;">Device Details</h6>
            </div>
            <div class="col-12">
              <div class="row">
                <div class="col-6 pb-1 px-1 border-end">
                  <img  src="'.asset('assets/icon/battery.png').'" />
                    <label class="d-block device-title"> <span class="js-battery-percentage"></span>%</label>
                </div>
                <div class="col-6 pb-1 px-1">
                  <img src="'.asset('assets/icon/account-online.png').'" />
                  <label class="d-block device-title js-device-status"></label>
                </div>
              </div>
              <hr class="my-0">
  
              <div class="row">
                <div class="col-6 pt-1 px-1 border-end">
                  <img  src="'.asset('assets/icon/round-lock.png').'" />
                    <label class="d-block device-title js-device-lock-status"> Lock</label>
                </div>
                
                <div class="col-6 pt-1 px-1">
                  <img  src="'.asset('assets/icon/speedometer.png').'" />
                    <label class="d-block device-title"> <span class="js-vehical-speed"> </span> Km/h</label>
                </div>
              </div>
            </div>
          </div>
        </div>';
        }
        if($trip_status == 'assign') {
          $action .='<img class="p-1 js-ps-trip-completed confirmationBtn cursor-pointer" data-action="'.route('admin.trips.completed-trip-status', ['id' => $id]).'" data-question="Are you sure you want to complete this trip?" data-toggle="tooltip" data-placement="top" title="Trip Complete"  src="'.asset('assets/icon/trip-finish.png').'" />';
        }
        $action .='<a href="'.route('admin.device.live-tracking',["id" => $id]).'"><img class="p-1" src="'.asset('assets/icon/live-tracking.png').'" /></a>';
        $color = '';
        if ($device_status == 'online') {
          $color = 'text--success';
        } elseif ($device_status == 'offline') {
          $color = 'text--danger';
        } else {
          $color = 'text--danger';
        }
  
         $trips[] = array(
          $action,
          $id,
          $trip_id,
          "<span class=".$color.">".$device_status."</span>",
          $cargo_type,
          $shipment_type,
          $from_location_name.' - '.$to_location_name,
          $trip_info['address'],
          $driver_name,
          $vehicle_no,
          $mobile_no,
          $start_trip_date,
          $expected_arrive_time,
          $completed_trip_time,
          $lastupdate,
          $trip_status
         );
      }

      $output = array(
        "draw" => $_POST['draw'],
        "recordsTotal" => $totalRecords,
        "recordsFiltered" => $filteredRecords,
        "data" => $trips,
      );
      echo json_encode($output);
    }


    public function completed_trip()
    {
      $pagetitle = "Completed Trips";

     
      return view('admin.trip.completed-trip',compact('pagetitle'));
    }

    public function get_completed_trips(Request $request) {
      if (auth('admin')->user()->id){
        $admin_id = auth('admin')->id();
        $role_id = auth('admin')->user()->role_id;
      } else {
        $admin_id = 0;
        $role_id = 0;
      }

      $search = $request->search['value'];



      $query = AssignTrip:: join('locations as from_locations', 'assign_trips.from_destination', '=', 'from_locations.id')
      ->join('locations as to_locations', 'assign_trips.to_destination', '=', 'to_locations.id')
      ->join('gps_devices as gd', 'assign_trips.gps_devices_id', '=', 'gd.id')
      ->where(function ($query) use($role_id,$admin_id) {
        if ($role_id == 4) {
          $query->where(function ($query) use ($admin_id) {
            $query->where('assign_trips.admin_id', '=', $admin_id)->orWhereRaw('FIND_IN_SET(?, from_locations.admin_id)', [$admin_id])
            ->orWhereRaw('FIND_IN_SET(?, to_locations.admin_id)', [$admin_id]);
          });
        } else if($role_id == 5) {
          $query->where(function ($query) use ($admin_id) {
            $query->where('assign_trips.admin_id', '=', $admin_id)->orWhereRaw('FIND_IN_SET(?, from_locations.customs_admin_id)', [$admin_id])
            ->orWhereRaw('FIND_IN_SET(?, to_locations.customs_admin_id)', [$admin_id]);
          });
        } else if ($role_id != 0) {
          $query->where('assign_trips.admin_id', '=', $admin_id);
        } 
        })->where('trip_status','completed');
      $totalRecords = $query->count();
      $query->select('gd.device_id','assign_trips.*', 'from_locations.location_port_name as from_location_name','to_locations.location_port_name as to_location_name');
      if (!empty($search)) {
        $query = $query->where(function ($query) use ($search){
          $query->where('assign_trips.trip_id', 'like', '%' . $search . '%');
          // ->orWhere('admins.mobile_no', 'like', '%' . $search . '%');
        });
      }
      $filteredRecords = $query->count();
      $ongoing_trip = $query->skip(intval($request->start))->take(intval($request->length))->get();


     
      $trips = array();
      foreach ($ongoing_trip as $key => $value) {
        $trip_info = array();
        $trip_info['address'] ='';
        $trip_info['latitude'] ='';
        $trip_info['longitude'] ='';

        $tc_devices = DB::table('tc_devices')->where('uniqueid',$value->device_id)->first();
        if (isset($tc_devices) && !empty($tc_devices)) {
          $positionid = (isset($tc_devices->positionid)) ? $tc_devices->positionid : 0;
          $deviceid = $tc_devices->id ?? '';

          if (!empty($positionid) && isset($positionid)) {
            
            $completed_trip_time = $value->completed_trip_time ?? '';
            $adjusted_end_time = Carbon::parse($completed_trip_time)->subHours(5)->subMinutes(30);
           $last_ins_location_time = $adjusted_end_time->format('Y-m-d H:i:s');
            $tc_positions = DB::table('tc_positions')->whereNotNull('address')->where('devicetime', '<=', $last_ins_location_time)->where('deviceid', '=', $deviceid)->orderBy('id', 'desc')->first();
            if(isset($tc_positions->attributes) && !empty($tc_positions->attributes)){
              $trip_info['address'] = (isset($tc_positions->address) && !empty($tc_positions->address)) ? $tc_positions->address : '';
              $trip_info['latitude'] = (isset($tc_positions->latitude) && !empty($tc_positions->latitude)) ? $tc_positions->latitude : '';
              $trip_info['longitude'] = (isset($tc_positions->longitude) && !empty($tc_positions->longitude)) ? $tc_positions->longitude : '';
            }
          } else {
            $trip_info['address'] = '';
          }
        }

        if(isset($value->container_details->driver_name)) {$driver_name = $value->container_details->driver_name; } else { $driver_name ='';}
        if(isset($value->container_details->vehicle_no)) {$vehicle_no = $value->container_details->vehicle_no; } else { $vehicle_no ='';}
        if(isset($value->container_details->mobile_no)) {$mobile_no = $value->container_details->mobile_no; } else { $mobile_no ='';}
        if(isset($value->id)) {$id = $value->id; } else { $id ='';}
        if(isset($value->from_location_name)) {$from_location_name = $value->from_location_name; } else { $from_location_name ='';}
        if(isset($value->trip_id)) {$trip_id = $value->trip_id; } else { $trip_id ='';}
        if(isset($value->to_location_name)) {$to_location_name = $value->to_location_name; } else { $to_location_name ='';}
        if(isset($value->shipping_details->shipment_type)) {$shipment_type = $value->shipping_details->shipment_type; } else { $shipment_type ='';}
        if(isset($value->shipping_details->cargo_type)) {$cargo_type = $value->shipping_details->cargo_type; } else { $cargo_type ='';}
        if(isset($value->trip_start_date)) {$start_trip_date = $value->trip_start_date; } else { $start_trip_date ='';}
        if(isset($value->expected_arrival_time)) {$expected_arrive_time = $value->expected_arrival_time; } else { $expected_arrive_time ='';}  
        if(isset($value->completed_trip_time)) {$completed_trip_time = $value->completed_trip_time; } else { $completed_trip_time ='';}  
        if(isset($tc_devices->id)) {$tc_device_id = $tc_devices->id; } else { $tc_device_id ='';}
        if(isset($value->trip_status)) {$trip_status = $value->trip_status; } else { $trip_status ='';}
        if(isset($tc_devices->lastupdate)) {$lastupdate = $tc_devices->lastupdate; } else { $lastupdate ='';}
        $device_status = (isset($tc_devices->status) && !empty($tc_devices->status)) ? $tc_devices->status : '';  

        $action = '';
        if(can(['admin.trips.edit-trip', 'admin.trips.trip-details'])) {
          // if(can('admin.trips.edit-trip')) {
          //   $action .='<a class="" href="'. route("admin.trips.edit-trip", ["id" => $id]) . '"><img class="p-1" data-toggle="tooltip" data-placement="top" title="Edit Trip"  src="'.asset("assets/icon/edit.png").'" /></a>';
          // }
          if(can('admin.trips.trip-details')) {
            $action .='<a class="" href="'.route('admin.trips.trip-details',['id' => $id, 'trip_id' =>  $trip_id ]).'"><img class="p-1" data-toggle="tooltip" data-placement="top" title="Trip Details"  src="'.asset('assets/icon/trip-summary.png').'" /></a>';
          }
          
        }
        if($trip_status == 'assign') {
          $action .='<img class="p-1 js-ps-trip-completed confirmationBtn cursor-pointer" data-action="'.route('admin.trips.completed-trip-status', ['id' => $id]).'" data-question="Are you sure you want to complete this trip?" data-toggle="tooltip" data-placement="top" title="Trip Complete"  src="'.asset('assets/icon/trip-finish.png').'" />';
        }
        $action .='<a href="'.route('admin.device.live-tracking',["id" => $id]).'"><img class="p-1" src="'.asset('assets/icon/live-tracking.png').'" /></a>';
        $color = '';
        if ($device_status == 'online') {
          $color = 'text--success';
        } elseif ($device_status == 'offline') {
          $color = 'text--danger';
        } else {
          $color = 'text--danger';
        }
  
         $trips[] = array(
          $action,
          $id,
          $trip_id,
          //"<span class=".$color.">".$device_status."</span>",
          $cargo_type,
          $shipment_type,
          $from_location_name.' - '.$to_location_name,
          $trip_info['address'],
          $trip_info['latitude'],
          $trip_info['longitude'],
          $driver_name,
          $vehicle_no,
          $mobile_no,
          $start_trip_date,
          $expected_arrive_time,
          $completed_trip_time,
          $lastupdate,
          // $trip_status
         );
      }

      $output = array(
        "draw" => $_POST['draw'],
        "recordsTotal" => $totalRecords,
        "recordsFiltered" => $filteredRecords,
        "data" => $trips,
      );
      echo json_encode($output);
    }
  
    public function get_location(Request $request)
    {
      $id = (isset($request->id)) ? $request->id : 0;
      $location = location::whereNotIn('id', [$id])->get();
      $data['location'] = $location;
      echo json_encode($data);
    }
    
    public function get_trip_id(){
      $lastId = AssignTrip::latest('id')->pluck('id')->first();
      $nextId = $lastId + 1;
      $uniqueString = Str::upper(Str::random(6));
      $tripId = $uniqueString . $nextId;
      return $tripId;
    }
  
    public function add_trip(Request $request)
    {
  
      $validator = Validator::make($request->all(), [
        'device' => 'required',
        'from_destination' => 'required',
        'to_destination' => 'required',
        'driver_name' => 'required',
        'container_no' => 'required',
        'license_no' => 'required',
        'id_proof_no' => 'required',
        'mobile_no' => 'required',
        'co_driver_name' => 'required',
        'co_driver_license_no' => 'required',
        'co_drive_id_proof_no' => 'required',
        'invoice_no' => 'required',
        'invoice_date' => 'required',
        'customer_cif_inr' => 'required',
        'e_way_bill_no' => 'required',
        'shipping_details' => 'required',
        'exporter_details' => 'required',
        // 'invoice_bill' => 'required',
        // 'unexture_a' => 'required',
        // 'unexture_b' => 'required',
        'start_trip_date'=>'required',
        'expected_arrive_time' => 'required',
        'cargo_type' => 'required',
        'shipment_type' =>'required'
      ]);

      
  
      if ($validator->fails()) {
        return redirect()->back()->withErrors($validator)->withInput();
      }

      $container_details = []; 
      $container_details['driver_name'] = $request->driver_name;
      $container_details['container_no'] = $request->container_no;
      $container_details['vehicle_no'] = $request->vehicle_no;
      $container_details['license_no'] = $request->license_no;
      $container_details['id_proof_no'] = $request->id_proof_no;
      $container_details['mobile_no'] = $request->mobile_no;
      $container_details['co_driver_name'] = $request->co_driver_name;
      $container_details['co_driver_license_no'] = $request->co_driver_license_no;
      $container_details['co_drive_id_proof_no'] = $request->co_drive_id_proof_no;
  
      $shipping_details = [];
      $shipping_details['invoice_no'] = $request->invoice_no;
      $shipping_details['invoice_date'] = $request->invoice_date;
      $shipping_details['customer_cif_inr'] = $request->customer_cif_inr;
      $shipping_details['e_way_bill_no'] = $request->e_way_bill_no;
      $shipping_details['shipping_details'] = $request->shipping_details;
      $shipping_details['exporter_details'] = $request->exporter_details;
      // $shipping_details['start_trip_date'] = $request->start_trip_date;
      // $shipping_details['expected_arrive_time'] = $request->expected_arrive_time;
      $shipping_details['cargo_type'] = $request->cargo_type;
      $shipping_details['shipment_type'] = $request->shipment_type;

      if (auth('admin')->user()->id){
        $admin_id = auth('admin')->id();
      } else {
        $admin_id = 0;
      }

      if (GpsDevice::where('id', $request->device ?? '')->where(function ($query) {
      $query->whereNull('current_trip_id')->orWhere('current_trip_id', '');
      })->exists()) {

        $trip_id = $this->get_trip_id();

        if ($request->hasFile('invoice_bill')) {
          $invoice_bill = $request->file('invoice_bill');
          $invoice_bill_name = time().'.'.$invoice_bill->getClientOriginalExtension();
          $destinationPath = realpath('invoice_bill');
          $invoice_bill->move($destinationPath, $invoice_bill_name);
        } else {
          $invoice_bill_name = '';
        }
    
        if ($request->hasFile('unexture_a')) {
          $unexture_a = $request->file('unexture_a');
          $unexture_a_name = time().'.'.$unexture_a->getClientOriginalExtension();
          $destinationPath = realpath('unexture_a');
          $unexture_a->move($destinationPath, $unexture_a_name);
        } else {
          $unexture_a_name = '';
        }
        if ($request->hasFile('unexture_b')) {
          $unexture_b = $request->file('unexture_b');
          $unexture_b_name = time().'.'.$unexture_a->getClientOriginalExtension();
          $destinationPath = realpath('unexture_b');
          $unexture_b->move($destinationPath, $unexture_b_name);
        } else {
          $unexture_b_name = '';
        }

        if(!empty($request->device) && isset($request->device) && !empty($trip_id)) {
          GpsDevice::where('id', $request->device)->update(['current_trip_id' => $trip_id]);
        }
        if(isset($request->device) && !empty($request->device)) {
          $updated = GpsDevice::where('id', $request->device)->first();
          $device_id = (isset($updated->device_id) && !empty($updated->device_id)) ? $updated->device_id :0;
        } else {
          $device_id = 0;
        }
        $tc_devices = DB::table('tc_devices')->where('uniqueid',$device_id)->first();
      
        if (isset($tc_devices) && !empty($tc_devices)) {
          $positionid = (isset($tc_devices->positionid)) ? $tc_devices->positionid : 0;
          if (!empty($positionid) && isset($positionid)) {
            $tc_positions = DB::table('tc_positions')->where('id',$positionid)->first();
            if(isset($tc_positions->attributes) && !empty($tc_positions->attributes)){
              $device_position_address = (isset($tc_positions->address) && !empty($tc_positions->address)) ? $tc_positions->address : '';
            }
          } else {
            $device_position_address ='';
          }
        }
        
        $assignTrip                    = new AssignTrip();
        $assignTrip->trip_id           = $trip_id;
        $assignTrip->admin_id          = $admin_id;
        $assignTrip->gps_devices_id    = $request->device;

        $assignTrip->device_position_id = $positionid ??'';
        $assignTrip->device_position_address = $device_position_address??'';

        $assignTrip->from_destination  = $request->from_destination;
        $assignTrip->to_destination    = $request->to_destination;
        $assignTrip->container_details = $container_details;
        $assignTrip->shipping_details  = $shipping_details;
        $assignTrip->trip_start_date   = date('Y-m-d H:i:s',strtotime($request->start_trip_date));
        $assignTrip->expected_arrival_time   = date('Y-m-d H:i:s',strtotime($request->expected_arrive_time));;
        $assignTrip->invoice_bill       = $invoice_bill_name;
        $assignTrip->custom_unexture_a  = $unexture_a_name;
        $assignTrip->custom_unexture_b  = $unexture_b_name;
        $assignTrip->created_by  = $admin_id;
        $assignTrip->updated_by  = $admin_id;
        
      
        $assignTrip->save();

        $from_location_id = $request->from_destination ?? '';
        $to_destination_id = $request->to_destination ?? '';


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
        $trip_start_date = date('Y-m-d H:i:s',strtotime($request->start_trip_date));

        $mail_data['trip_id'] = $trip_id;
        $mail_data['trip_start_date'] = $trip_start_date;
        $mail_data['from_location_point'] = $from_location_data->location_port_name ?? '';
        $mail_data['to_location_point'] = $to_location_data->location_port_name ?? '';
        $mail_data['mode_of_transportation'] = $request->cargo_type ?? '';
      
        foreach($uniqueEmailArray as $key => $value) {

          $admin_data = Admin::where('email',$value)->first();

          $company_name = $admin_data->name ?? '';
          $mobile_no = $admin_data->mobile_no ?? '';

          $mail_data['company_name'] = $company_name;
          $mail_data['mobile_no'] = $mobile_no;

          try {
            Mail::to($value)->send(new AssignTripMail($mail_data));
          } catch (\Throwable $th) {
          //   throw $th;
          }
        }
      }
      $msg     = 'Trip assign successfully';
      $notify[] = ['success', $msg];

      return redirect()->back()->withNotify($notify);
    }

    public function edit_trip($id) {
      $pagetitle="Edit Trip";
      $assign_trip_edit = AssignTrip::find($id);
      if (auth('admin')->user()->id) {
        $admin_id = auth('admin')->id();
      } else {
        $admin_id = 0;
      }

      $gps_devices = GpsDevice::where('admin_id', $admin_id)->get();
      $locations = location::get();
      $assign_trip = AssignTrip::select('gd.device_id','assign_trips.*', 'from_locations.location_port_name as from_location_name','to_locations.location_port_name as to_location_name')
      ->join('locations as from_locations', 'assign_trips.from_destination', '=', 'from_locations.id')
      ->join('locations as to_locations', 'assign_trips.to_destination', '=', 'to_locations.id')
      ->join('gps_devices as gd', 'assign_trips.gps_devices_id', '=', 'gd.id')
      // ->where('assign_trips.trip_status','assign')
      ->where('assign_trips.status','enable')
      ->get();

      

      $trip_edit = array();
      if(isset($assign_trip_edit->gps_devices_id)) {$trip_edit['gps_devices_id'] = $assign_trip_edit->gps_devices_id; } else { $trip_edit['gps_devices_id'] ='';}
      if(isset($assign_trip_edit->from_destination)) {$trip_edit['from_destination'] = $assign_trip_edit->from_destination; } else { $trip_edit['from_destination'] ='';}
      if(isset($assign_trip_edit->to_destination)) {$trip_edit['to_destination'] = $assign_trip_edit->to_destination; } else { $trip_edit['to_destination'] ='';}
      if(isset($assign_trip_edit->id)) {$trip_edit['id'] = $assign_trip_edit->id; } else { $trip_edit['id'] ='';}
      if(isset($assign_trip_edit->container_details->driver_name)) { $trip_edit['driver_name'] = $assign_trip_edit->container_details->driver_name; } else { $trip_edit['driver_name'] ='';}
      if(isset($assign_trip_edit->container_details->container_no)) { $trip_edit['container_no'] = $assign_trip_edit->container_details->container_no; } else { $trip_edit['container_no'] ='';}
      if(isset($assign_trip_edit->container_details->vehicle_no)) { $trip_edit['vehicle_no'] = $assign_trip_edit->container_details->vehicle_no; } else { $trip_edit['vehicle_no'] ='';}
      if(isset($assign_trip_edit->container_details->license_no)) { $trip_edit['license_no'] = $assign_trip_edit->container_details->license_no; } else { $trip_edit['license_no'] ='';}
      if(isset($assign_trip_edit->container_details->id_proof_no)) { $trip_edit['id_proof_no'] = $assign_trip_edit->container_details->id_proof_no; } else { $trip_edit['id_proof_no'] ='';}
      if(isset($assign_trip_edit->container_details->mobile_no)) { $trip_edit['mobile_no'] = $assign_trip_edit->container_details->mobile_no; } else { $trip_edit['mobile_no'] ='';}
      if(isset($assign_trip_edit->container_details->co_driver_name)) { $trip_edit['co_driver_name'] = $assign_trip_edit->container_details->co_driver_name; } else { $trip_edit['co_driver_name'] ='';}
      if(isset($assign_trip_edit->container_details->co_driver_license_no)) { $trip_edit['co_driver_license_no'] = $assign_trip_edit->container_details->co_driver_license_no; } else { $trip_edit['co_driver_license_no'] ='';}
      if(isset($assign_trip_edit->container_details->co_drive_id_proof_no)) { $trip_edit['co_drive_id_proof_no'] = $assign_trip_edit->container_details->co_drive_id_proof_no; } else { $trip_edit['co_drive_id_proof_no'] ='';}
      
      if(isset($assign_trip_edit->shipping_details->invoice_no)) { $trip_edit['invoice_no'] = $assign_trip_edit->shipping_details->invoice_no; } else { $trip_edit['invoice_no'] ='';}
      if(isset($assign_trip_edit->shipping_details->invoice_date)) { $trip_edit['invoice_date'] = $assign_trip_edit->shipping_details->invoice_date; } else { $trip_edit['invoice_date'] ='';}
      if(isset($assign_trip_edit->shipping_details->customer_cif_inr)) { $trip_edit['customer_cif_inr'] = $assign_trip_edit->shipping_details->customer_cif_inr; } else { $trip_edit['customer_cif_inr'] ='';}
      if(isset($assign_trip_edit->shipping_details->e_way_bill_no)) { $trip_edit['e_way_bill_no'] = $assign_trip_edit->shipping_details->e_way_bill_no; } else { $trip_edit['e_way_bill_no'] ='';}
      if(isset($assign_trip_edit->shipping_details->shipping_details)) { $trip_edit['shipping_details'] = $assign_trip_edit->shipping_details->shipping_details; } else { $trip_edit['shipping_details'] ='';}
      if(isset($assign_trip_edit->shipping_details->exporter_details)) { $trip_edit['exporter_details'] = $assign_trip_edit->shipping_details->exporter_details; } else { $trip_edit['exporter_details'] ='';}
      if(isset($assign_trip_edit->shipping_details->cargo_type)) { $trip_edit['cargo_type'] = $assign_trip_edit->shipping_details->cargo_type; } else {  $trip_edit['cargo_type'] ='';}
      if(isset($assign_trip_edit->trip_start_date)) {  $trip_edit['start_trip_date'] = $assign_trip_edit->trip_start_date; } else { $start_trip_date ='';}
      if(isset($assign_trip_edit->expected_arrival_time)) { $trip_edit['expected_arrive_time'] = $assign_trip_edit->expected_arrival_time; } else { $expected_arrive_time ='';}  

      // if(isset($assign_trip_edit->shipping_details->start_trip_date)) { $trip_edit['start_trip_date'] = $assign_trip_edit->shipping_details->start_trip_date; } else { $trip_edit['start_trip_date'] ='';}
      // if(isset($assign_trip_edit->shipping_details->expected_arrive_time)) {$trip_edit['expected_arrive_time'] = $assign_trip_edit->shipping_details->expected_arrive_time; } else { $trip_edit['expected_arrive_time'] ='';} 
      if(isset($assign_trip_edit->shipping_details->shipment_type)) { $trip_edit['shipment_type'] = $assign_trip_edit->shipping_details->shipment_type; } else {  $trip_edit['shipment_type'] ='';}
      if(isset($assign_trip_edit->invoice_bill)) { $trip_edit['invoice_bill'] = $assign_trip_edit->invoice_bill; } else { $trip_edit['invoice_bill'] ='';}
      if(isset($assign_trip_edit->custom_unexture_a)) { $trip_edit['custom_unexture_a'] = $assign_trip_edit->custom_unexture_a; } else { $trip_edit['custom_unexture_a'] ='';}
      if(isset($assign_trip_edit->custom_unexture_b)) { $trip_edit['custom_unexture_b'] = $assign_trip_edit->custom_unexture_b; } else { $trip_edit['custom_unexture_b'] ='';}
      
      // echo "<pre>";
      //  print_r($trip_edit);die; 
      return view('admin.trip.assign-trip', compact('gps_devices', 'locations','trip_edit','pagetitle'));
    }


    public function update_trip(Request $request,$id) {

      $validator = Validator::make($request->all(), [
        'device' => 'required',
        'from_destination' => 'required',
        'to_destination' => 'required',
        'driver_name' => 'required',
        'container_no' => 'required',
        'license_no' => 'required',
        'id_proof_no' => 'required',
        'mobile_no' => 'required',
        'co_driver_name' => 'required',
        'co_driver_license_no' => 'required',
        'co_drive_id_proof_no' => 'required',
        'invoice_no' => 'required',
        'invoice_date' => 'required',
        'customer_cif_inr' => 'required',
        'e_way_bill_no' => 'required',
        'shipping_details' => 'required',
        'exporter_details' => 'required',
        // 'invoice_bill' => 'required',
        // 'unexture_a' => 'required',
        // 'unexture_b' => 'required',
        'start_trip_date'=>'required',
        'expected_arrive_time' => 'required',
        'cargo_type' => 'required',
        'shipment_type' =>'required'
      ]);

      
  
      if ($validator->fails()) {
        return redirect()->back()->withErrors($validator)->withInput();
      }

      $container_details = []; 
      $container_details['driver_name'] = $request->driver_name;
      $container_details['container_no'] = $request->container_no;
      $container_details['vehicle_no'] = $request->vehicle_no;
      $container_details['license_no'] = $request->license_no;
      $container_details['id_proof_no'] = $request->id_proof_no;
      $container_details['mobile_no'] = $request->mobile_no;
      $container_details['co_driver_name'] = $request->co_driver_name;
      $container_details['co_driver_license_no'] = $request->co_driver_license_no;
      $container_details['co_drive_id_proof_no'] = $request->co_drive_id_proof_no;
  
      $shipping_details = [];
      $shipping_details['invoice_no'] = $request->invoice_no;
      $shipping_details['invoice_date'] = $request->invoice_date;
      $shipping_details['customer_cif_inr'] = $request->customer_cif_inr;
      $shipping_details['e_way_bill_no'] = $request->e_way_bill_no;
      $shipping_details['shipping_details'] = $request->shipping_details;
      $shipping_details['exporter_details'] = $request->exporter_details;
      // $shipping_details['start_trip_date'] = $request->start_trip_date;
      // $shipping_details['expected_arrive_time'] = $request->expected_arrive_time;
      $shipping_details['cargo_type'] = $request->cargo_type;
      $shipping_details['shipment_type'] = $request->shipment_type;

      if (auth('admin')->user()->id){
        $admin_id = auth('admin')->id();
      } else {
        $admin_id = 0;
      }
      $trip_id = $this->get_trip_id();

            
      if(isset($request->device) && !empty($request->device)) {
        $updated = GpsDevice::where('id', $request->device)->first();
        $device_id = (isset($updated->device_id) && !empty($updated->device_id)) ? $updated->device_id :0;
      } else {
        $device_id = 0;
      }
      $tc_devices = DB::table('tc_devices')->where('uniqueid',$device_id)->first();

      if (isset($tc_devices) && !empty($tc_devices)) {
        $positionid = (isset($tc_devices->positionid)) ? $tc_devices->positionid : 0;
        if (!empty($positionid) && isset($positionid)) {
          $tc_positions = DB::table('tc_positions')->where('id',$positionid)->first();
          if(isset($tc_positions->attributes) && !empty($tc_positions->attributes)){
            $device_position_address = (isset($tc_positions->address) && !empty($tc_positions->address)) ? $tc_positions->address : '';
          }
        } else {
          $device_position_address ='';
        }
      }

  
      $assignTrip                    = AssignTrip::find($id);
      //$assignTrip->trip_id           = $trip_id;
      $assignTrip->admin_id          = $admin_id;
      $assignTrip->gps_devices_id    = $request->device;
      $assignTrip->from_destination  = $request->from_destination;
      $assignTrip->to_destination    = $request->to_destination;
      $assignTrip->container_details = $container_details;
      $assignTrip->shipping_details  = $shipping_details;
      $assignTrip->trip_start_date   = date('Y-m-d H:i:s',strtotime($request->start_trip_date));
      $assignTrip->expected_arrival_time   = date('Y-m-d H:i:s',strtotime($request->expected_arrive_time));
      $assignTrip->device_position_id = $positionid;
      $assignTrip->device_position_address = $device_position_address;
      
      if ($request->hasFile('invoice_bill')) {
        $invoice_bill = $request->file('invoice_bill');
        $invoice_bill_name = time().'.'.$invoice_bill->getClientOriginalExtension();
        $destinationPath = realpath('invoice_bill');
        $invoice_bill->move($destinationPath, $invoice_bill_name);
        if ($assignTrip->invoice_bill) {
          $image_path_bill = realpath('invoice_bill/'.$assignTrip->invoice_bill);
          if (file_exists($image_path_bill)) {
            unlink($image_path_bill);
          }
        }
      } else {
        if (isset($assignTrip->invoice_bill) && !empty($assignTrip->invoice_bill)) {
          $invoice_bill_name = $assignTrip->invoice_bill;
        } else {
          $invoice_bill_name = '';
        } 
      }
  
      if ($request->hasFile('unexture_a')) {
        $unexture_a = $request->file('unexture_a');
        $unexture_a_name = time().'.'.$unexture_a->getClientOriginalExtension();
        $destinationPath = realpath('unexture_a');
        $unexture_a->move($destinationPath, $unexture_a_name);
        if ($assignTrip->custom_unexture_a) {
          $image_path_un_a = realpath('unexture_a/'.$assignTrip->custom_unexture_a);
          if (file_exists($image_path_un_a)) {
            unlink($image_path_un_a);
          }
        }
      } else {
        if (isset($assignTrip->custom_unexture_a) && !empty($assignTrip->custom_unexture_a)) {
          $unexture_a_name = $assignTrip->custom_unexture_a;
        } else {
          $unexture_a_name = '';
        } 
      }

      if ($request->hasFile('unexture_b')) {
        $unexture_b = $request->file('unexture_b');
        $unexture_b_name = time().'.'.$unexture_b->getClientOriginalExtension();
        $destinationPath = realpath('unexture_b');
        $unexture_b->move($destinationPath, $unexture_b_name);
        if ($assignTrip->custom_unexture_b) {
          $image_path_un_b = realpath('unexture_b/'.$assignTrip->custom_unexture_b);
          if (file_exists($image_path_un_b)) {
            unlink($image_path_un_b);
          }
        }
      } else {
        if (isset($assignTrip->custom_unexture_b) && !empty($assignTrip->custom_unexture_b)) {
          $unexture_b_name = $assignTrip->custom_unexture_b;
        } else {
          $unexture_b_name = '';
        } 
      }
      
      $assignTrip->invoice_bill       = $invoice_bill_name;
      $assignTrip->custom_unexture_a  = $unexture_a_name;
      $assignTrip->custom_unexture_b  = $unexture_b_name;
      // $assignTrip->created_by  = $admin_id;
      $assignTrip->updated_by  = $admin_id;
      $assignTrip->save();
      $msg     = 'Trip update successfully';
      $notify[] = ['success', $msg];
      return redirect()->back()->withNotify($notify);
    }

  public function trip_completed(Request $request, $assing_id){

    $data = array();
    
    if (isset($assing_id) && !empty($assing_id)) {
      $assign_trip_record = AssignTrip::find($assing_id);
      if (isset($assign_trip_record) && !empty($assign_trip_record->trip_id)) {

        $gps_devices_id = (!empty($assign_trip_record->gps_devices_id)) ? $assign_trip_record->gps_devices_id : '';
        $trip_id = (!empty($assign_trip_record->trip_id)) ? $assign_trip_record->trip_id : '';
        GpsDevice::where('id', $gps_devices_id)->where('current_trip_id', $trip_id)->update(['current_trip_id' => '']);
        
        $assign_trip_record->completed_trip_time = date('Y-m-d H:i:s');
        $assign_trip_record->trip_status = 'completed';
        $assign_trip_record->save();


          $shipping_details = $assign_trip_record->shipping_details;
          $cargo_type = $shipping_details->cargo_type ?? '';

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
          // $uniqueEmailString = implode(',', $uniqueEmailArray);

          

        if (auth('admin')->user()->id) {
          $admin_id = auth('admin')->id();
          $role_id = auth('admin')->user()->role_id;
        } else {
          $admin_id = 0;
          $role_id = 0;
        }

        $query_d_summary = AssignTrip::select('assign_trips.*', 'admins.gst_no as gstno', 'from_locations.location_port_name as from_location_name',
        'to_locations.location_port_name as to_location_name', 'gps_devices.device_id')
          ->join('locations as from_locations', 'assign_trips.from_destination', '=', 'from_locations.id')
          ->join('locations as to_locations', 'assign_trips.to_destination', '=', 'to_locations.id')
          ->join('admins', 'assign_trips.admin_id', '=', 'admins.id')
          ->join('gps_devices', 'assign_trips.gps_devices_id', '=', 'gps_devices.id')
          ->where(function ($query_d_summary) use ($role_id, $admin_id) {
            if ($role_id != 0) {$query_d_summary->where('assign_trips.admin_id', '=', $admin_id);}
          });
    
          if (isset($trip_id)) {
            if (!empty($trip_id)) {
              $query_d_summary = $query_d_summary->where(function ($q) use ($trip_id) {
                $q->where('assign_trips.trip_id', $trip_id);
              });
            }
          }
          $device_summary = $query_d_summary->first();
        
        $query_alarm = DB::table('tc_data_event')
          ->Join('assign_trips', 'tc_data_event.trip_id', '=', 'assign_trips.trip_id')
          ->leftJoin('locations as from_locations', 'assign_trips.from_destination', '=', 'from_locations.id')
          ->leftJoin('locations as to_locations', 'assign_trips.to_destination', '=', 'to_locations.id')
          ->leftJoin('gps_devices as gd', 'assign_trips.gps_devices_id', '=', 'gd.id')
          ->where('command_word', '!=', '@JT')
          ->whereIn('event_source_type', ['1', '2','3','7','8'])
          ->whereIn('unlock_verification', ['0', '1'])
          ->where(function ($query_alarm) use ($role_id, $admin_id) {
            if ($role_id != 0) {
              $query_alarm->where('assign_trips.admin_id', '=', $admin_id);
            }
          });
    
        $query_alarm->select(
          'tc_data_event.*',
          'from_locations.location_port_name as from_location_name',
          'to_locations.location_port_name as to_location_name',
          'assign_trips.shipping_details as shipping_detail',
          'assign_trips.container_details as container_detail',
          'assign_trips.trip_start_date as trip_start_date',
          'assign_trips.expected_arrival_time as expected_arrival_time'
        );
    
        if (isset($trip_id) && $trip_id !='null') {
          if (!empty($trip_id)) {
          $query = $query_alarm->where(function ($q) use ($trip_id) {
            $q->where('tc_data_event.trip_id', $trip_id);
          });
          }
        }

        $alarms = $query_alarm->get();
       
        $query_events = DB::table('tc_data_event')
          ->Join('assign_trips', 'tc_data_event.trip_id', '=', 'assign_trips.trip_id')
          ->leftJoin('locations as from_locations', 'assign_trips.from_destination', '=', 'from_locations.id')
          ->leftJoin('locations as to_locations', 'assign_trips.to_destination', '=', 'to_locations.id')
          ->leftJoin('gps_devices as gd', 'assign_trips.gps_devices_id', '=', 'gd.id')
          ->where('command_word', '!=', '@JT')
          ->where(function ($query_events) use ($role_id, $admin_id) {
            if ($role_id != 0) {
              $query_events->where('assign_trips.admin_id', '=', $admin_id);
            }
        });
        
        $query_events->select(
          'tc_data_event.*',
          'from_locations.location_port_name as from_location_name',
          'to_locations.location_port_name as to_location_name',
          'assign_trips.shipping_details as shipping_detail',
          'assign_trips.container_details as container_detail',
          'assign_trips.trip_start_date as trip_start_date',
          'assign_trips.expected_arrival_time as expected_arrival_time'
        );
         
      
        if (isset($trip_id) && $trip_id !='null') {
          if (!empty($trip_id)) {
            $query_events = $query_events->where(function ($q) use ($trip_id) {
              $q->where('tc_data_event.trip_id', $trip_id);
            });
          }
        }
        $events = $query_events->get();
        $is_pdf_trip = true;
        $pdf = PDF::loadView('admin.report.device-summary-reports-pdf', compact('device_summary', 'trip_id', 'alarms','events','is_pdf_trip'));
        
        $mail_data = array(
          'trip_id' => $assign_trip_record->trip_id ?? '',
          'trip_start_date' => $assign_trip_record->trip_start_date ?? '',
          'from_location_point' => $from_location_data->location_port_name ?? '',
          'to_location_point' => $to_location_data->location_port_name ?? '',
          'mode_of_transportation' => $cargo_type,
        );


        foreach($uniqueEmailArray as $key => $value) {

          $admin_data = Admin::where('email',$value)->first();

          $company_name = $admin_data->name ?? '';
          $mobile_no = $admin_data->mobile_no ?? '';

          $mail_data['pdf'] = $pdf;
          $mail_data['company_name'] = $company_name;
          $mail_data['mobile_no'] = $mobile_no;

          try {
            Mail::to($value)->send(new TripCompleteMail($mail_data));
          } catch (\Throwable $th) {
         //   throw $th;
          }
        }
        
        $msg     = 'Trip status change successfully';
        $notify[] = ['success', $msg];
      
      }
    
    } else {
      $msg     = 'Trip status change successfully';
      $notify[] = ['error', $msg];
    }

    return redirect()->back()->withNotify($notify);
  }

    public function trip_details(Request $request)
    {
      
      $assign_trip = AssignTrip::select('assign_trips.*', 'admins.gst_no as gstno','from_locations.location_port_name as from_location_name','to_locations.location_port_name as to_location_name')
        ->join('locations as from_locations', 'assign_trips.from_destination', '=', 'from_locations.id')
        ->join('locations as to_locations', 'assign_trips.to_destination', '=', 'to_locations.id')
        ->join('admins', 'assign_trips.admin_id', '=', 'admins.id')
        ->find($request->id);

        $trip_details = array();

        if(isset($assign_trip->from_location_name)) {$trip_details['from_location_name'] = $assign_trip->from_location_name; } else { $trip_details['from_location_name'] ='';}
        if(isset($assign_trip->to_location_name)) {$trip_details['to_location_name'] = $assign_trip->to_location_name; } else { $trip_details['to_location_name'] ='';}
        if(isset($assign_trip->trip_id)) {$trip_details['trip_id'] = $assign_trip->trip_id; } else { $trip_details['trip_id'] ='';}
        if(isset($assign_trip->gstno)) {$trip_details['gstno'] = $assign_trip->gstno; } else { $trip_details['gstno'] ='';}

        if(isset($assign_trip->gps_devices_id)) {$trip_details['gps_devices_id'] = $assign_trip->gps_devices_id; } else { $trip_details['gps_devices_id'] ='';}
        if(isset($assign_trip->id)) {$trip_details['id'] = $assign_trip->id; } else { $trip_details['id'] ='';}
        if(isset($assign_trip->container_details->driver_name)) { $trip_details['driver_name'] = $assign_trip->container_details->driver_name; } else { $trip_details['driver_name'] ='';}
        if(isset($assign_trip->container_details->container_no)) { $trip_details['container_no'] = $assign_trip->container_details->container_no; } else { $trip_details['container_no'] ='';}
        if(isset($assign_trip->container_details->vehicle_no)) { $trip_details['vehicle_no'] = $assign_trip->container_details->vehicle_no; } else { $trip_details['vehicle_no'] ='';}
        if(isset($assign_trip->container_details->license_no)) { $trip_details['license_no'] = $assign_trip->container_details->license_no; } else { $trip_details['license_no'] ='';}
        if(isset($assign_trip->container_details->id_proof_no)) { $trip_details['id_proof_no'] = $assign_trip->container_details->id_proof_no; } else { $trip_details['id_proof_no'] ='';}
        if(isset($assign_trip->container_details->mobile_no)) { $trip_details['mobile_no'] = $assign_trip->container_details->mobile_no; } else { $trip_details['mobile_no'] ='';}
        if(isset($assign_trip->container_details->co_driver_name)) { $trip_details['co_driver_name'] = $assign_trip->container_details->co_driver_name; } else { $trip_details['co_driver_name'] ='';}
        if(isset($assign_trip->container_details->co_driver_license_no)) { $trip_details['co_driver_license_no'] = $assign_trip->container_details->co_driver_license_no; } else { $trip_details['co_driver_license_no'] ='';}
        if(isset($assign_trip->container_details->co_drive_id_proof_no)) { $trip_details['co_drive_id_proof_no'] = $assign_trip->container_details->co_drive_id_proof_no; } else { $trip_details['co_drive_id_proof_no'] ='';}
        
        if(isset($assign_trip->shipping_details->invoice_no)) { $trip_details['invoice_no'] = $assign_trip->shipping_details->invoice_no; } else { $trip_details['invoice_no'] ='';}
        if(isset($assign_trip->shipping_details->invoice_date)) { $trip_details['invoice_date'] = $assign_trip->shipping_details->invoice_date; } else { $trip_details['invoice_date'] ='';}
        if(isset($assign_trip->shipping_details->customer_cif_inr)) { $trip_details['customer_cif_inr'] = $assign_trip->shipping_details->customer_cif_inr; } else { $trip_details['customer_cif_inr'] ='';}
        if(isset($assign_trip->shipping_details->e_way_bill_no)) { $trip_details['e_way_bill_no'] = $assign_trip->shipping_details->e_way_bill_no; } else { $trip_details['e_way_bill_no'] ='';}
        if(isset($assign_trip->shipping_details->shipping_details)) { $trip_details['shipping_details'] = $assign_trip->shipping_details->shipping_details; } else { $trip_details['shipping_details'] ='';}
        if(isset($assign_trip->shipping_details->exporter_details)) { $trip_details['exporter_details'] = $assign_trip->shipping_details->exporter_details; } else { $trip_details['exporter_details'] ='';}
        if(isset($assign_trip->shipping_details->cargo_type)) { $trip_details['cargo_type'] = $assign_trip->shipping_details->cargo_type; } else {  $trip_details['cargo_type'] ='';}
        if(isset($assign_trip->trip_start_date)) {$trip_details['start_trip_date'] = $assign_trip->trip_start_date; } else { $trip_details['start_trip_date'] ='';}
        if(isset($assign_trip->expected_arrival_time)) {$trip_details['expected_arrive_time'] = $assign_trip->expected_arrival_time; } else {$trip_details['expected_arrive_time'] ='';}  
        //if(isset($assign_trip->shipping_details->start_trip_date)) { $trip_details['start_trip_date'] = $assign_trip->shipping_details->start_trip_date; } else { $trip_details['start_trip_date'] ='';}
       // if(isset($assign_trip->shipping_details->expected_arrive_time)) {$trip_details['expected_arrive_time'] = $assign_trip->shipping_details->expected_arrive_time; } else { $trip_details['expected_arrive_time'] ='';} 
        if(isset($assign_trip->shipping_details->shipment_type)) { $trip_details['shipment_type'] = $assign_trip->shipping_details->shipment_type; } else {  $trip_details['shipment_type'] ='';}
        if(isset($assign_trip->invoice_bill)) { $trip_details['invoice_bill'] = $assign_trip->invoice_bill; } else { $trip_details['invoice_bill'] ='';}
        if(isset($assign_trip->custom_unexture_a)) { $trip_details['custom_unexture_a'] = $assign_trip->custom_unexture_a; } else { $trip_details['custom_unexture_a'] ='';}
        if(isset($assign_trip->custom_unexture_b)) { $trip_details['custom_unexture_b'] = $assign_trip->custom_unexture_b; } else { $trip_details['custom_unexture_b'] ='';}
      
        // echo "<pre>";
        // print_r($trip_details);die;

      return view('admin.trip.trip-details',compact('trip_details'));
    }

    public function remove_trip_file(Request $request) {
      
      echo "<pre>";
      print_r($request->all());die;
    }

    public function get_device_details(Request $request) {
      $device_id = (isset($request->deviceId) && !empty($request->deviceId)) ? $request->deviceId: 0;
      $tc_devices = DB::table('tc_devices')->where('id',$device_id)->first();
      $data =array();
      $batteryLevel =0;
      $status ='';
      $speed = 0;
      $lock = '';
      if (isset($tc_devices) && !empty($tc_devices)) {
        $positionid = (isset($tc_devices->positionid)) ? $tc_devices->positionid : 0;
        $status = (isset($tc_devices->status)) ? $tc_devices->status : 0;
        if (!empty($positionid) && isset($positionid)) {
          $tc_positions = DB::table('tc_positions')->where('id',$positionid)->first();
          $attributes = json_decode($tc_positions->attributes);
          if(isset($attributes->batteryLevel) && !empty($attributes->batteryLevel)){$batteryLevel = $attributes->batteryLevel;} else { $batteryLevel =0;}
          if(isset($tc_positions->speed) && !empty($tc_positions->speed)){$speed = $tc_positions->speed;} else { $speed =0;}
          if(isset($attributes->lock) && !empty($attributes->lock)){$lock = $attributes->lock;} else { $lock ='';}
        } 
      }
      $data['batteryLevel'] = $batteryLevel;
      $data['status'] = $status;
      $data['speed'] = $speed;
      $data['lock'] = $lock;
     
      echo json_encode($data);

    }

    public function get_trip_report() {

    }

   
  
}
