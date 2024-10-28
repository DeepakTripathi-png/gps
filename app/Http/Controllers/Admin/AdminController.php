<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Lib\CurlRequest;
use App\Models\AdminNotification;
use App\Rules\FileTypeValidate;
use App\Models\Admin;
use App\Models\GpsDevice;
use App\Models\AssignTrip;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Constants\Status;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use DateTime;
use DateTimeZone;
class AdminController extends Controller
{
    public function dashboard()
    {
        if (auth('admin')->user()->id) {
            $admin_id = auth('admin')->id();
            $role_id = auth('admin')->user()->role_id;
        } else {
            $admin_id = 0;
            $role_id = 0;
        }

        $pageTitle = 'Dashboard';
        $query = Admin::join('roles', 'admins.role_id', '=', 'roles.id');
        if ($role_id != 0) {
            $query->where('admins.created_by', '=', $admin_id);
        }
        $query->where('roles.id', '=', 3);

        $totalcustomer = $query->count();

        $query = Admin::join('roles', 'admins.role_id', '=', 'roles.id');
        if ($role_id != 0) {
            $query->where('admins.created_by', '=', $admin_id);
        }
        $query->where('roles.id', '=', 4);

        $totalusers = $query->count();

        $mappeddevicecount = GpsDevice::whereNotNull('admin_id')->where(function ($query) use($role_id,$admin_id) {
            if($role_id != 0) {$query->where('gps_devices.admin_id', '=', $admin_id);
            }
          })->count();
        $availabledevice = GpsDevice::whereNull('current_trip_id')
        ->orWhere('current_trip_id', '')->where(function ($query) use($role_id,$admin_id) {
            if($role_id != 0) {
                $query->where('gps_devices.admin_id', '=', $admin_id);
            }
          })->count();
        $totaltripcount = AssignTrip::where(function ($query) use($role_id,$admin_id) {
            if($role_id != 0) {$query->where('assign_trips.admin_id', '=', $admin_id);
            }
          })->count();
        $totalongoingtrip = AssignTrip::where('trip_status', 'assign')->where(function ($query) use($role_id,$admin_id) {
            if($role_id != 0) {$query->where('assign_trips.admin_id', '=', $admin_id);
            }
          })->count();
        $totalcompletedtrip = AssignTrip::where('trip_status', 'completed')->where(function ($query) use($role_id,$admin_id) {
            if($role_id != 0) {$query->where('assign_trips.admin_id', '=', $admin_id);
            }
          })->count();




        // $longitude_data_obj = DB::table('tc_positions')
        // ->select('latitude', 'longitude')
        // ->where('id', '>', 6)
        // ->where('id', '<', 140)
        // ->where('deviceid', 1)
        // ->get();

    // Convert the result to a PHP array
    // $longitude_data = $longitude_data_obj->toArray();
        // echo "<pre>";
        // print_r($longitude_data);die;

        return view('admin.dashboard', compact('pageTitle', 'totalcustomer', 'mappeddevicecount', 'availabledevice', 'totaltripcount', 'totalongoingtrip', 'totalcompletedtrip'));
    }


    public function get_device_live_location() {
        if (auth('admin')->user()->id) {
            $admin_id = auth('admin')->id();
            $role_id = auth('admin')->user()->role_id;
        } else {
            $admin_id = 0;
            $role_id = 0;
        }
        $device_data = array();
        $mapdevices = GpsDevice::join('admins', 'gps_devices.admin_id', '=', 'admins.id')
            ->join('roles', 'admins.role_id', '=', 'roles.id')
            ->join('tc_devices', 'gps_devices.device_id', '=', 'tc_devices.uniqueid');
            if (auth('admin')->user()->role_id != 0) {
                $mapdevices = $mapdevices->where('admins.id', '=', $admin_id);
            }
        $mapdevices = $mapdevices->select('gps_devices.*', 'admins.name as customername', 'admins.mobile_no as customer_no', 'admins.date_of_expiry as expirydate')->get();

        foreach ($mapdevices as $key => $value) {

            $device_id = $value->device_id ?? '';
            $gps_device_id = $value->id ?? ''; //gps devices table primary key

            $trip_info = array();

            if (!empty($device_id) && isset($device_id)) {
                $last_lat ='';
                $last_lon ='';
                $speed = '';
                $address = '';
                $device_status = '';
                $lock = '';
                $tc_devices = DB::table('tc_devices')->where('uniqueid',$device_id)->first();
                $assign_trip = AssignTrip::where('gps_devices_id',$gps_device_id)->where('status','enable')->where('trip_status','assign')->first();

                $tc_event_data = DB::table('tc_data_event')->where('device_id',$device_id)->latest('id')->first();

                // echo '<pre>';
                // print_r($tc_event_data);die;


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

                    if (!empty($positionid) && isset($positionid)) {
                        $tc_positions = DB::table('tc_positions')->where('id',$positionid)->latest('id')->first();
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


                $primary_id = $assign_trip->id ?? '';
                $position = array();
                $position['lat'] = bcadd($last_lat,'0',6);
                $position['lng'] = bcadd($last_lon,'0',6);
                $trip_info['device_id'] = $device_id;
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

                $device_data[] = $trip_info;
            }
        }
        $data['device_data'] = $device_data;

        echo json_encode($data);
    }


    public function dashboard_added_trips(Request $request)
    {
        
       
        if (auth('admin')->user()->id) {
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
            ->where('assign_trips.trip_status', 'assign')
            ->where('assign_trips.status', 'enable')
            ->where(function ($query) use($role_id,$admin_id) {
                if($role_id != 0) {$query->where('assign_trips.admin_id', '=', $admin_id);
                }
              })
              ->orderBy('assign_trips.id', 'desc');

        $totalRecords = $query->count();
        $query->select('gd.device_id', 'assign_trips.*', 'from_locations.location_port_name as from_location_name', 'to_locations.location_port_name as to_location_name');
        if (!empty($search)) {
            $query = $query->where(function ($query) use ($search) {
                $query->where('assign_trips.trip_id', 'like', '%' . $search . '%');
            });
        }

        $filteredRecords = $query->count();
        $ongoing_trip = $query->skip(intval($request->start))->take(intval($request->length))->get();
        
        
        $trips = array();
        foreach ($ongoing_trip as $key => $value) {
             
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
            if (isset($value->id)) {
                $id = $value->id;
            } else {
                $id = '';
            }
            if (isset($value->trip_id)) {
                $trip_id = $value->trip_id;
            } else {
                $trip_id = '';
            }
            if (isset($value->from_location_name)) {
                $from_location_name = $value->from_location_name;
            } else {
                $from_location_name = '';
            }
            if (isset($value->to_location_name)) {
                $to_location_name = $value->to_location_name;
            } else {
                $to_location_name = '';
            }
            if (isset($value->trip_start_date)) {
                $start_trip_date = $value->trip_start_date;

            } else {
                $start_trip_date = '';
            }
            if (isset($value->trip_status)) {
                $trip_status = $value->trip_status;
            } else {
                $trip_status = '';
            }

            $trips[] = array(
                '<a href="' . route('admin.trips.trip-details', ['id' => $id,'trip_id' =>  $trip_id]) . '">' . $trip_id . '</a>',
                $from_location_name,
                $to_location_name,
                $trip_info['address'],
                $start_trip_date,
                $trip_status === 'assign' ? 'ongoing' : ''

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


    public function dashboard_event_alert(Request $request)
    {
        if (auth('admin')->user()->id) {
            $admin_id = auth('admin')->id();
            $role_id = auth('admin')->user()->role_id;
        } else {
            $admin_id = 0;
            $role_id = 0;
        }
        $search = $request->search['value'];
        $query = DB::table('tc_data_event')
            ->Join('assign_trips', 'tc_data_event.trip_id', '=', 'assign_trips.trip_id')
            ->leftJoin('locations as from_locations', 'assign_trips.from_destination', '=', 'from_locations.id')
            ->leftJoin('locations as to_locations', 'assign_trips.to_destination', '=', 'to_locations.id')
            ->leftJoin('gps_devices as gd', 'assign_trips.gps_devices_id', '=', 'gd.id')
            ->where('command_word', '!=', '@JT')
            ->where(function ($query) use($role_id,$admin_id) {
                if($role_id != 0) {$query->where('assign_trips.admin_id', '=', $admin_id);
                }
              })
              ->orderBy('tc_data_event.id', 'desc');

        $totalRecords = $query->count();
        $query->select(
            'tc_data_event.*',
            'from_locations.location_port_name as from_location_name',
            'to_locations.location_port_name as to_location_name',
            'assign_trips.shipping_details as shipping_detail',
            'assign_trips.container_details as container_detail',
            'assign_trips.trip_start_date as trip_start_date',
            'assign_trips.expected_arrival_time as expected_arrival_time',
            'assign_trips.id as asid',
        );
        if (!empty($search)) {
            $query = $query->where(function ($query) use ($search) {
                $query->where('tc_data_event.trip_id', 'like', '%' . $search . '%');
            });
        }
        $filteredRecords = $query->count();
        $alarm_trip = $query->skip(intval($request->start))->take(intval($request->length))->get();
        $alarms = array();
        foreach ($alarm_trip as $key => $value) {
            if (isset($value->id)) {
                $id = $value->id;
            } else {
                $id = '';
            }

            if (isset($value->time) && !empty($value->time)) {
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
            if (isset($value->trip_id)) {
                $trip_id = $value->trip_id;
            } else {
                $trip_id = '';
            }
            if (isset($value->alert_title)) {
                $alert_title = $value->alert_title;
            } else {
                $alert_title = '';
            }
            if (isset($value->alert_naration)) {
                $alert_naration = $value->alert_naration;
            } else {
                $alert_naration = '';
            }

            if (isset($value->address)) {
                $address = $value->address;
            } else {
                $address = '';
            }

            if (isset($value->asid)) {
                $asid = $value->asid;
            } else {
                $asid= '';
            }
            $alarms[] = array(
                '<p style="font-size:12px;margin-top: 0;margin-bottom: 0;" >Trip ID:<a href="' . route('admin.trips.trip-details', ['id' => $asid,'trip_id' =>  $trip_id]) . '"> ' . $trip_id . '</a>' . '</br>' . 'Alert:<span style="font-size:12px;" > ' . $alert_title . ' </br> ' . $alert_naration  . '</span>' . '</br>' . 'Address:<span style="font-size:12px;">' . $address . '</span>' .  '</br>' . 'Date:<span style="font-size:12px;">' . $time . '<label style="font-size:12px;margin-top:-15px" class="d-flex justify-content-end">'. 'RF ID:' . $rfid_card_number  . '</label>'.'</span>' .'</p>',

            );
        }
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $totalRecords,
            "recordsFiltered" => $filteredRecords,
            "data" => $alarms,
        );
        echo json_encode($output);
    }



    public function profile()
    {
        $pageTitle = 'Profile';
        $admin = auth('admin')->user();

        return view('admin.profile', compact('pageTitle', 'admin'));

       // return view('admin.test', compact('pageTitle', 'admin'));

    }

    public function profileUpdate(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email',
            'image' => ['nullable', 'image', new FileTypeValidate(['jpg', 'jpeg', 'png'])]
        ]);
        $user = auth('admin')->user();

        if ($request->hasFile('image')) {
            try {
                $old = $user->image ?: null;
                $user->image = fileUploader($request->image, getFilePath('adminProfile'), getFileSize('adminProfile'), $old);
            } catch (\Exception $exp) {
                $notify[] = ['error', 'Couldn\'t upload your image'];
                return back()->withNotify($notify);
            }
        }

        $user->name = $request->name;
        $user->email = $request->email;
        $user->save();
        $notify[] = ['success', 'Profile updated successfully'];
        return to_route('admin.profile')->withNotify($notify);
    }


    public function password()
    {
        $pageTitle = 'Password Setting';
        $admin = auth('admin')->user();
        return view('admin.password', compact('pageTitle', 'admin'));
    }

    public function passwordUpdate(Request $request)
    {
        $this->validate($request, [
            'old_password' => 'required',
            'password' => 'required|min:5|confirmed',
        ]);

        $user = auth('admin')->user();
        if (!Hash::check($request->old_password, $user->password)) {
            $notify[] = ['error', 'Password doesn\'t match!!'];
            return back()->withNotify($notify);
        }
        $user->password = bcrypt($request->password);
        $user->save();
        $notify[] = ['success', 'Password changed successfully.'];
        return to_route('admin.password')->withNotify($notify);
    }

    public function requestReport()
    {
        $pageTitle = 'Your Listed Report & Request';
        $arr['app_name'] = systemDetails()['name'];
        $arr['app_url'] = env('APP_URL');
        $arr['PURCHASECODE'] = env('PURCHASECODE');
        $url = "https://license.viserlab.com/issue/get?" . http_build_query($arr);
        $response = CurlRequest::curlContent($url);
        $response = json_decode($response);
        if ($response->status == 'error') {
            return to_route('admin.dashboard')->withErrors($response->message);
        }
        $reports = $response->message[0];
        return view('admin.reports', compact('reports', 'pageTitle'));
    }

    public function reportSubmit(Request $request)
    {
        $request->validate([
            'type' => 'required|in:bug,feature',
            'message' => 'required',
        ]);
        $url = 'https://license.viserlab.com/issue/add';

        $arr['app_name'] = systemDetails()['name'];
        $arr['app_url'] = env('APP_URL');
        $arr['PURCHASECODE'] = env('PURCHASECODE');
        $arr['req_type'] = $request->type;
        $arr['message'] = $request->message;
        $response = CurlRequest::curlPostContent($url, $arr);
        $response = json_decode($response);
        if ($response->status == 'error') {
            return back()->withErrors($response->message);
        }
        $notify[] = ['success', $response->message];
        return back()->withNotify($notify);
    }

    public function downloadAttachment($fileHash)
    {
        $filePath = decrypt($fileHash);
        $extension = pathinfo($filePath, PATHINFO_EXTENSION);
        $title = slug(gs('site_name')) . '- attachments.' . $extension;
        $mimetype = mime_content_type($filePath);
        header('Content-Disposition: attachment; filename="' . $title);
        header("Content-Type: " . $mimetype);
        return readfile($filePath);
    }


    public function showAlert()
    {

        if (auth('admin')->user()->id){
            $admin_id = auth('admin')->id();
            $role_id = auth('admin')->user()->role_id;
        } else {
            $admin_id = 0;
            $role_id = 0;
        }

        $alertMessage = 'This is your alert message.';

        $query = AssignTrip::join('locations as from_locations', 'assign_trips.from_destination', '=', 'from_locations.id')
        ->leftJoin('locations as to_locations', 'assign_trips.to_destination', '=', 'to_locations.id')
        ->join('gps_devices as gd', 'assign_trips.gps_devices_id', '=', 'gd.id')
        ->where('assign_trips.trip_status','assign')
        ->where('assign_trips.status','enable')
        ->where(function ($query) use($role_id,$admin_id) {
          if($role_id != 0) {$query->where('assign_trips.admin_id', '=', $admin_id);
          }
        });
        $query->select(
            'from_locations.location_port_name as from_location_name',
            'to_locations.location_port_name as to_location_name',
            'assign_trips.*',
            'gd.device_id',
        );

        $assign_trip = $query->get();

        $oneMinuteAgo = Carbon::now()->subMinute(1);

        $alert_notification = array();
        foreach ($assign_trip as $key => $value) {
            $icon ='';
            $title ='';
            $device_id = $value->device_id ?? '';

            $sql = 'SELECT * FROM tc_data_event  WHERE created_at >= :oneMinuteAgo AND device_id = :device_id';
            $tc_data = DB::select($sql, [
                'oneMinuteAgo' => $oneMinuteAgo,
                'device_id' => $device_id,
            ]);
            
                   
            
           

            if (!empty($tc_data) && isset($tc_data)) {
                foreach ($tc_data as $key => $tc_data_event) {
                    
                

                    $message = '';
                    $event_source_type = $tc_data_event->event_source_type ?? '';
                    $unlock_verification = $tc_data_event->unlock_verification ?? '';
                    $rfid_card_number = $tc_data_event->rfid_card_number ?? '';
                    $alert_naration = $tc_data_event->alert_naration ?? '';
                    $alert_title = $tc_data_event->alert_title ?? '';
                    $data_event_id = $tc_data_event->id ?? '';


                    // if ($event_source_type && !empty($event_source_type)) {
                        $notification = array();
                        $trip_start_date = date('Y-m-d H:i:s A',strtotime($value->trip_start_date));
                        $expected_arrival_time = date('Y-m-d H:i:s A',strtotime($value->expected_arrival_time));
                        $value->trip_start_date_f = $trip_start_date;
                        $value->expected_arrival_time_f = $expected_arrival_time;

                        $notification['icon'] = $icon;
                        $notification['title'] = $alert_title;
                        $notification['alert_message'] = $alert_naration;
                        $notification['trip'] = $value;
                        $notification['id'] = $data_event_id;

                        $alert_notification[] = $notification;
                    // }
                }
            }
        }


        // $query = DB::table('tc_data_event')
        // ->Join('assign_trips', 'tc_data_event.trip_id', '=', 'assign_trips.trip_id')
        // ->leftJoin('locations as from_locations', 'assign_trips.from_destination', '=', 'from_locations.id')
        // ->leftJoin('locations as to_locations', 'assign_trips.to_destination', '=', 'to_locations.id')
        // ->leftJoin('gps_devices as gd', 'assign_trips.gps_devices_id', '=', 'gd.id')
        // ->where('command_word', '!=', '@JT')
        // ->where(function ($query) use($role_id,$admin_id) {
        //     if($role_id != 0) {
        //         $query->where('assign_trips.admin_id', '=', $admin_id);
        //     }
        // })->orderBy('tc_data_event.id', 'desc');

        // $query->select(
        // 'tc_data_event.*',
        // 'from_locations.location_port_name as from_location_name',
        // 'to_locations.location_port_name as to_location_name',
        // 'assign_trips.shipping_details as shipping_detail',
        // 'assign_trips.container_details as container_detail',
        // 'assign_trips.trip_start_date as trip_start_date',
        // 'assign_trips.expected_arrival_time as expected_arrival_time'
        // );
        // $alarm_trips = $query->take(15)->get();


        return response()->json(
            ['alert_notification' => $alert_notification]
    );
    }


    public function view_all_notification(){
        $pageTitle ="All Notification";

        return view('admin.view_all_notification', compact('pageTitle'));

    }

    public function notification_event_alert(Request $request){
        if (auth('admin')->user()->id) {
            $admin_id = auth('admin')->id();
            $role_id = auth('admin')->user()->role_id;
        } else {
            $admin_id = 0;
            $role_id = 0;
        }
        $search = $request->search['value'];
        $query = DB::table('tc_data_event')
            ->Join('assign_trips', 'tc_data_event.trip_id', '=', 'assign_trips.trip_id')
            ->leftJoin('locations as from_locations', 'assign_trips.from_destination', '=', 'from_locations.id')
            ->leftJoin('locations as to_locations', 'assign_trips.to_destination', '=', 'to_locations.id')
            ->leftJoin('gps_devices as gd', 'assign_trips.gps_devices_id', '=', 'gd.id')
            ->where('command_word', '!=', '@JT')
            ->where(function ($query) use($role_id,$admin_id) {
                if($role_id != 0) {$query->where('assign_trips.admin_id', '=', $admin_id);
                }
              })
              ->orderBy('tc_data_event.id', 'desc');

        $totalRecords = $query->count();
        $query->select(
            'tc_data_event.*',
            'from_locations.location_port_name as from_location_name',
            'to_locations.location_port_name as to_location_name',
            'assign_trips.shipping_details as shipping_detail',
            'assign_trips.container_details as container_detail',
            'assign_trips.trip_start_date as trip_start_date',
            'assign_trips.expected_arrival_time as expected_arrival_time'
        );
        if (!empty($search)) {
            $query = $query->where(function ($query) use ($search) {
                $query->where('tc_data_event.trip_id', 'like', '%' . $search . '%');
            });
        }
        $filteredRecords = $query->count();
        $alarm_trip = $query->skip(intval($request->start))->take(intval($request->length))->get();
        $alarms = array();
        foreach ($alarm_trip as $key => $value) {
            if (isset($value->id)) {
                $id = $value->id;
            } else {
                $id = '';
            }
            if (isset($value->time) && !empty($value->time)) {
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
            if (isset($value->trip_id)) {
                $trip_id = $value->trip_id;
            } else {
                $trip_id = '';
            }
            if (isset($value->alert_title)) {
                $alert_title = $value->alert_title;
            } else {
                $alert_title = '';
            }
            if (isset($value->alert_naration)) {
                $alert_naration = $value->alert_naration;
            } else {
                $alert_naration = '';
            }
            if (isset($value->address)) {
                $address = $value->address;
            } else {
                $address = '';
            }
            $alarms[] = array(
                '<p style="font-size:12px;margin-top: 0;margin-bottom: 0;" >Trip ID:<a href="' . route('admin.trips.trip-details', ['id' => $id,'trip_id' =>  $trip_id]) . '"> ' . $trip_id . '</a>' . '</br>' . 'Alert:<span style="font-size:12px;" > ' . $alert_title . ' </br> ' . $alert_naration  . '</span>' . '</br>' . 'Address:<span style="font-size:12px;">' . $address . '</span>' .  '</br>' . 'Date:<span style="font-size:12px;">' . $time . '<label style="font-size:12px;margin-top:-15px" class="d-flex justify-content-end">'. 'RF ID:' . $rfid_card_number  . '</label>'.'</span>' .'</p>',

            );
        }
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $totalRecords,
            "recordsFiltered" => $filteredRecords,
            "data" => $alarms,
        );
        echo json_encode($output);
    }

    public function get_event_notify(Request $request){
        if (auth('admin')->user()->id) {
            $admin_id = auth('admin')->id();
            $role_id = auth('admin')->user()->role_id;
        } else {
            $admin_id = 0;
            $role_id = 0;
        }
        $search = $request->search['value'];
        $query = DB::table('tc_data_event')
            ->Join('assign_trips', 'tc_data_event.trip_id', '=', 'assign_trips.trip_id')
            ->leftJoin('locations as from_locations', 'assign_trips.from_destination', '=', 'from_locations.id')
            ->leftJoin('locations as to_locations', 'assign_trips.to_destination', '=', 'to_locations.id')
            ->leftJoin('gps_devices as gd', 'assign_trips.gps_devices_id', '=', 'gd.id')
            ->where('command_word', '!=', '@JT')
            ->where(function ($query) use($role_id,$admin_id) {
                if($role_id != 0) {$query->where('assign_trips.admin_id', '=', $admin_id);
                }
            });
        $totalRecords = $query->count();
        $query->select(
            'tc_data_event.*',
            'from_locations.location_port_name as from_location_name',
            'to_locations.location_port_name as to_location_name',
            'assign_trips.shipping_details as shipping_detail',
            'assign_trips.container_details as container_detail',
            'assign_trips.trip_start_date as trip_start_date',
            'assign_trips.expected_arrival_time as expected_arrival_time'
        );
        if (!empty($search)) {
            $query = $query->where(function ($query) use ($search) {
                $query->where('tc_data_event.trip_id', 'like', '%' . $search . '%');
            });
        }
        $filteredRecords = $query->count();
        $alarm_trips = $query->orderBy('tc_data_event.id', 'desc')->take(15)->get();

        $alerts = array();

        foreach ($alarm_trips as $key => $value) {
            if (isset($value->id)) {
                $id = $value->id;
            } else {
                $id = '';
            }


            if (isset($value->time) && !empty($value->time)) {
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
            if (isset($value->trip_id)) {
                $trip_id = $value->trip_id;
            } else {
                $trip_id = '';
            }
            if (isset($value->alert_title)) {
                $alert_title = $value->alert_title;
            } else {
                $alert_title = '';
            }
            if (isset($value->alert_naration)) {
                $alert_naration = $value->alert_naration;
            } else {
                $alert_naration = '';
            }

            if (isset($value->address)) {
                $address = $value->address;
            } else {
                $address = '';
            }
            // $alerts[] = array(
            //     '<p style="font-size:12px;margin-top: 0;margin-bottom: 0;" >Trip ID:<a href="' . route('admin.trips.trip-details', ['id' => $id]) . '"> ' . $trip_id . '</a>' . '</br>' . 'Alert:<span style="font-size:12px;" > ' . $alert_title . ' </br> ' . $alert_naration  . '</span>' . '</br>' . 'Address:<span style="font-size:12px;">' . ' pune Mh ' . '</span>' .  '</br>' . 'Date:<span style="font-size:12px;">' . $created_at . '<label style="font-size:12px;margin-top:-15px" class="d-flex justify-content-end">'. 'RF ID:' . $rfid_card_number  . '</label>'.'</span>' .'</p>',
            // );
            $alerts[] = array(
                '<p style="font-size:12px; margin: 0;">' .
                    'Trip ID: <a href="' . route('admin.trips.trip-details', ['id' => $id,'trip_id' =>  $trip_id]) . '">' . $trip_id . '</a><br>' .
                    'Alert: <span style="font-size:12px;">' . $alert_title . '<br>' . $alert_naration . '</span><br>' .
                    'Address: <span style="font-size:12px;">'.$address.'</span><br>' .
                    'Date: <span style="font-size:12px;">' . $time . '<label style="font-size:12px; margin-top:-15px" class="d-flex justify-content-end">RF ID:' . $rfid_card_number . '</label></span>' .
                '</p>',
            );

        }
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $totalRecords,
            "recordsFiltered" => $filteredRecords,
            "data" => $alerts,
        );
        echo json_encode($output);
    }


    // public function test()
    // {
    //   return view('admin.test');
    // }

}
