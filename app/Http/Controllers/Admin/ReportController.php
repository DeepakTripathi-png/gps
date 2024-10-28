<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AssignTrip;
use App\Models\GpsDevice;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Illuminate\Support\Facades\DB;
use PDF;
use stdClass;
use PhpOffice\PhpSpreadsheet\Style\Border;
use Carbon\Carbon;
use DateTime;
use DateTimeZone;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

class ReportController extends Controller
{
  public function trip_reports(){
    if (auth('admin')->user()->id) {
      $admin_id = auth('admin')->id();
      $role_id = auth('admin')->user()->role_id;
    } else {
      $admin_id = 0;
      $role_id = 0;
    }
   // DB::enableQueryLog();
    $trips = AssignTrip::where('status', 'enable')->where(function ($query) use($role_id,$admin_id) {
      if($role_id != 0) {$query->where('assign_trips.admin_id', '=', $admin_id);
      }
    })->get(['id', 'trip_id']);
    //dd(DB::getQueryLog());
    // echo '<pre>';
    // print_r($trips);
    // die;
    return view('admin.report.trip-reports',compact('trips'));
  }
  
  
  public function get_trip_report(Request $request){
    $trips = array();
    if (auth('admin')->user()->id) {
      $admin_id = auth('admin')->id();
      $role_id = auth('admin')->user()->role_id;
    } else {
      $admin_id = 0;
      $role_id = 0;
    }
    DB::getQueryLog();
    if (!empty($request->trip_id) || !empty($request->from_date) || !empty($request->to_date)) {
      $search = $request->search['value'];
      $query = AssignTrip::join('locations as from_locations', 'assign_trips.from_destination', '=', 'from_locations.id')
        ->join('locations as to_locations', 'assign_trips.to_destination', '=', 'to_locations.id')
        ->join('gps_devices as gd', 'assign_trips.gps_devices_id', '=', 'gd.id')
        ->orderBy('assign_trips.created_at', 'asc');

      $totalRecords = $query->count();
      $query->select('gd.device_id', 'assign_trips.*', 'from_locations.location_port_name as from_location_name', 'to_locations.location_port_name as to_location_name');
      
      if (!empty($search)) {
        $query = $query->where(function ($query) use ($search) {
          $query->where('assign_trips.trip_id', 'like', '%' . $search . '%');
        });
      }
     

     
        $trip_id = $request->trip_id;
        if (!empty($trip_id)) {
          $query = $query->where(function ($q) use ($trip_id) {
            $q->where('assign_trips.trip_id', $trip_id);
          });
        }
        if (!empty($request->from_date)) {
          $query = $query->whereDate('assign_trips.trip_start_date', '>=', $request->from_date);
        }
        if (!empty($request->to_date)) {
          $query = $query->whereDate('assign_trips.trip_start_date', '<=', $request->to_date);
        }

        if ($role_id != 0) {
          $query->where('assign_trips.admin_id', '=', $admin_id);
        }
      $filteredRecords = $query->count();
      $assign_trip = $query->skip(intval($request->start))->take(intval($request->length))->get();

      
      foreach ($assign_trip as $key => $value) {

        $trip_info = array();
        $tc_devices = DB::table('tc_devices')->where('uniqueid', $value->device_id)->first();
        if (isset($tc_devices) && !empty($tc_devices)) {
          $positionid = (isset($tc_devices->positionid)) ? $tc_devices->positionid : 0;
          if (!empty($positionid) && isset($positionid)) {
            $tc_positions = DB::table('tc_positions')->where('id', $positionid)->first();
            if (isset($tc_positions->attributes) && !empty($tc_positions->attributes)) {
              $trip_info['address'] = (isset($tc_positions->address) && !empty($tc_positions->address)) ? $tc_positions->address : '';
            } else {
              $trip_info['address'] = '';
            }
          }
        }
        $device_status = (isset($tc_devices->status) && !empty($tc_devices->status)) ? $tc_devices->status : '';
        $driver_name = $value->container_details->driver_name ?? '';
        $vehicle_no = $value->container_details->vehicle_no ?? '';
        $mobile_no = $value->container_details->mobile_no ?? '';
        $id = $value->id ?? '';
        $from_location_name = $value->from_location_name ?? '';
        $trip_id = $value->trip_id ?? '';
		    $address = $value->address ?? '';
        $to_location_name = $value->to_location_name ?? '';
        $shipment_type = $value->shipping_details->shipment_type ?? '';
        $cargo_type = $value->shipping_details->cargo_type ?? '';
        $start_trip_date = $value->trip_start_date ?? '';
        $expected_arrive_time = $value->expected_arrival_time ?? '';
        $completed_trip_time = $value->completed_trip_time ?? '';

        $tc_device_id = $tc_devices->id ?? '';
        $lastupdate = $tc_devices->lastupdate ?? '';
        $trip_status = $value->trip_status ?? '';

        $action = '';
        if (can(['admin.trips.trip-details'])) {
          if (can('admin.trips.trip-details')) {
            $action .= '<a class="" href="' . route('admin.trips.trip-details', ['id' => $id, 'trip_id' =>  $trip_id ]) . '"><img class="p-1" data-toggle="tooltip" data-placement="top" title="Trips Details"  src="' . asset('assets/icon/trip-summary.png') . '" /></a>';
            $action .= '<a href="' . route('admin.device.live-tracking', ['id' => $id]) . '"><img class="p-1" src="' . asset('assets/icon/live-tracking.png') . '" /></a>';
          }
        }

        $color = '';
        if ($device_status == 'online') {
          $color = 'text--success';
        } elseif ($device_status == 'offline') {
          $color = 'text--danger';
        } else {
          $color = 'text--danger';
        }

        $t_html = '';
        if($trip_status == 'completed') {
          $t_html ="<span> - </span>";
        } else {
          $t_html ="<span class=" . $color . ">" . $device_status . "</span>";
        }

        $trips[] = array(
          $action,
          $id,
          $trip_id,
          $t_html,
          $cargo_type,
          $shipment_type,
          $from_location_name . ' - ' . $to_location_name,
        //  $address,
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
    } else {
      $totalRecords = 0;
      $filteredRecords = 0;
      $trips = array();
    }
    $output = array(
      "draw" => $_POST['draw'],
      "recordsTotal" => $totalRecords,
      "recordsFiltered" => $filteredRecords,
      "data" => $trips,
    );

    echo json_encode($output);
  }
  
  public function excel_trips_report(Request $request){

    if (auth('admin')->user()->id) {
      $admin_id = auth('admin')->id();
      $role_id = auth('admin')->user()->role_id;
    } else {
      $admin_id = 0;
      $role_id = 0;
    }

    if (!empty($request->trip_id) || !empty($request->from_date) || !empty($request->to_date)) {
      $query = AssignTrip::join('locations as from_locations', 'assign_trips.from_destination', '=', 'from_locations.id')
        ->join('locations as to_locations', 'assign_trips.to_destination', '=', 'to_locations.id')
        ->join('gps_devices as gd', 'assign_trips.gps_devices_id', '=', 'gd.id')
        ->orderBy('assign_trips.created_at', 'asc');
      
      $query->select('gd.device_id', 'assign_trips.*', 'from_locations.location_port_name as from_location_name', 'to_locations.location_port_name as to_location_name');
       
        if (isset($request->trip_id) && !empty($request->trip_id) && $request->trip_id !='null' ) {
          $trip_id = $request->trip_id;
          $query = $query->where('assign_trips.trip_id', $trip_id);
        }

        if (!empty($request->from_date)) {
          $query = $query->whereDate('assign_trips.trip_start_date', '>=', $request->from_date);
        }

        if (!empty($request->to_date)) {
          $query = $query->whereDate('assign_trips.trip_start_date', '<=', $request->to_date);
        }
        if ($role_id == 4) {
          $query->where(function ($query) use ($admin_id) {
            $query->where('assign_trips.admin_id', '=', $admin_id)->orWhereRaw('FIND_IN_SET(?, from_locations.admin_id)', [$admin_id])
            ->orWhereRaw('FIND_IN_SET(?, to_locations.admin_id)', [$admin_id]);
          });
        } else if ($role_id != 0) {
          $query->where('assign_trips.admin_id', '=', $admin_id);
        }

        $trips = $query->get();
      }
          $spreadsheet = new Spreadsheet();
          $sheet = $spreadsheet->getActiveSheet();
          if (isset($fromDate) && isset($toDate)) {
           
          } else {
      
          }
         
          $fromDate = request()->from_date;
          $toDate = request()->to_date;

            $dateRange='';
            if(isset($fromDate) && $fromDate != null){
              $dateRange .= date('d-m-Y', strtotime($fromDate)) ;
            }
            if(isset($toDate) &&  $toDate != null){
              $dateRange .= ' To ' . date('d-m-Y', strtotime($toDate));
            } 
          $sheet->setCellValue('C1', 'Trips Reports')->getStyle('C1')->getFont()->setBold(true);
  
          $sheet->setCellValue('A3', 'Trip ID')->getStyle('A3')->getFont()->setBold(true);
          $sheet->setCellValue('A4', 'From Date')->getStyle('A4')->getFont()->setBold(true);
          
          $sheet->setCellValue('B3', ($request->trip_id !== 'null') ? $request->trip_id : '');
          $sheet->setCellValue('B4', $dateRange);

          $sheet->getColumnDimension('A')->setWidth(10); 
          $sheet->getColumnDimension('B')->setWidth(22); 
          $sheet->getColumnDimension('C')->setWidth(15);        
  
          $sheet->setCellValue('A6', 'Sr No')->getStyle('A6')->getFont()->setBold(true);
          $sheet->setCellValue('B6', 'Trip ID')->getStyle('B6')->getFont()->setBold(true);
           $sheet->setCellValue('C6', 'Device Status')->getStyle('C6')->getFont()->setBold(true);
          $sheet->setCellValue('D6', 'Cargo Type')->getStyle('D6')->getFont()->setBold(true);
          $sheet->setCellValue('E6', 'Shipment Type')->getStyle('E6')->getFont()->setBold(true);
          $sheet->setCellValue('F6', 'Location')->getStyle('F6')->getFont()->setBold(true);
           $sheet->setCellValue('G6', 'Current Address')->getStyle('G6')->getFont()->setBold(true);
          $sheet->setCellValue('H6', 'Driver Name')->getStyle('H6')->getFont()->setBold(true);
          $sheet->setCellValue('I6', 'Vehicle No')->getStyle('I6')->getFont()->setBold(true);
          $sheet->setCellValue('J6', 'Contact No')->getStyle('J6')->getFont()->setBold(true);
          $sheet->setCellValue('K6', 'Start Date')->getStyle('K6')->getFont()->setBold(true);
          $sheet->setCellValue('L6', 'Exp Arrival Date')->getStyle('L6')->getFont()->setBold(true);
          $sheet->setCellValue('M6', 'Trip Comp Date')->getStyle('M6')->getFont()->setBold(true);
           $sheet->setCellValue('N6', 'Last Update At')->getStyle('N6')->getFont()->setBold(true);
            $sheet->setCellValue('O6', 'Trip Status')->getStyle('O6')->getFont()->setBold(true);

          $sheet->getStyle('A6:O6')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('c6efce');
          $sheet->getStyle('A6:O6')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

          $row = 7;
          foreach ($trips as $i => $log) {
         
                $trip_info = array();
                $tc_devices = DB::table('tc_devices')->where('uniqueid', $log->device_id)->first();
                if (isset($tc_devices) && !empty($tc_devices)) {
                  $positionid = (isset($tc_devices->positionid)) ? $tc_devices->positionid : 0;
                  if (!empty($positionid) && isset($positionid)) {
                    $tc_positions = DB::table('tc_positions')->where('id', $positionid)->first();
                    if (isset($tc_positions->attributes) && !empty($tc_positions->attributes)) {
                      $trip_info['address'] = (isset($tc_positions->address) && !empty($tc_positions->address)) ? $tc_positions->address : '';
                    } else {
                      $trip_info['address'] = '';
                    }
                  }
                }
                $device_status = (isset($tc_devices->status) && !empty($tc_devices->status)) ? $tc_devices->status : '';
               $lastupdate = $tc_devices->lastupdate ?? '';
               
              $sheet->setCellValue('A' . $row, $i + 1 ?? '');
              $sheet->getStyle('A' . $row)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
              $sheet->setCellValue('B' . $row, $log->trip_id ?? '');
              $sheet->setCellValue('C' . $row, $device_status ?? '');
              $sheet->setCellValue('D' . $row, $log->shipping_details->cargo_type ?? '');
              $sheet->setCellValue('E' . $row, $log->shipping_details->shipment_type ?? '');
              $sheet->setCellValue('F' . $row, $log->from_location_name ?? ''. ' - ' .$log->to_location_name ?? '');
              $sheet->setCellValue('G' . $row, $log->address ?? '') ;
              $sheet->getStyle('G' . $row)->getAlignment()->setWrapText(true);
              $sheet->setCellValue('H' . $row, $log->container_details->driver_name);
              $sheet->setCellValue('I' . $row, $log->container_details->vehicle_no);
              $sheet->setCellValue('J' . $row, $log->container_details->mobile_no);
              $sheet->getStyle('J' . $row)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
              $sheet->setCellValue('K' . $row, $log->trip_start_date);
              $sheet->setCellValue('L' . $row, $log->expected_arrival_time);
              $sheet->setCellValue('M' . $row, $log->completed_trip_time);
              $sheet->setCellValue('N' . $row, $lastupdate);
              $sheet->setCellValue('O' . $row, $log->trip_status);

              $row++;
          }
          
          $sheet->getColumnDimension('D')->setWidth(15); 
          $sheet->getColumnDimension('E')->setWidth(15); 
          $sheet->getColumnDimension('F')->setWidth(20); 
          $sheet->getColumnDimension('G')->setWidth(20); 
          $sheet->getColumnDimension('H')->setWidth(20); 
          $sheet->getColumnDimension('I')->setWidth(15); 
          $sheet->getColumnDimension('J')->setWidth(15); 
          $sheet->getColumnDimension('K')->setWidth(19); 
          $sheet->getColumnDimension('L')->setWidth(19); 
          $sheet->getColumnDimension('M')->setWidth(19); 
          $sheet->getColumnDimension('N')->setWidth(19);          
          $sheet->getColumnDimension('O')->setWidth(10); 
 

          $writer = new Xlsx($spreadsheet);
          $filename = 'trips_report.xlsx';
  
          header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
          header('Content-Disposition: attachment;filename="' . $filename . '"');
          header('Cache-Control: max-age=0');
  
          $writer->save('php://output');
          exit;
  }
  
  public function pdf_trips_report(Request $request){

    if (auth('admin')->user()->id) {
      $admin_id = auth('admin')->id();
      $role_id = auth('admin')->user()->role_id;
    } else {
      $admin_id = 0;
      $role_id = 0;
    }
    $trip_id = ($request->trip_id !== null) ? $request->trip_id : '';
    $fromDate = request()->from_date;
        $toDate = request()->to_date;
        
        $dateRange='';
          if(isset($fromDate) && $fromDate != null){
            $dateRange .= date('d-m-Y', strtotime($fromDate)) ;
          }
          if(isset($toDate) &&  $toDate != null){
            $dateRange .= ' To ' . date('d-m-Y', strtotime($toDate));
          } 
    if (!empty($request->trip_id) || !empty($request->from_date) || !empty($request->to_date)) {
          $query = AssignTrip::join('locations as from_locations', 'assign_trips.from_destination', '=', 'from_locations.id')
            ->join('locations as to_locations', 'assign_trips.to_destination', '=', 'to_locations.id')
            ->join('gps_devices as gd', 'assign_trips.gps_devices_id', '=', 'gd.id')
            ->orderBy('assign_trips.created_at', 'asc');
          
          $query->select('gd.device_id', 'assign_trips.*', 'from_locations.location_port_name as from_location_name', 'to_locations.location_port_name as to_location_name');
    
            if (isset($request->trip_id) && !empty($request->trip_id) && $request->trip_id !='null' ) {
                $trip_id = $request->trip_id;
                $query = $query->where('assign_trips.trip_id', $trip_id);
            }
            if (!empty($request->from_date)) {
              $query = $query->whereDate('assign_trips.trip_start_date', '>=', $request->from_date);
            }
            if (!empty($request->to_date)) {
              $query = $query->whereDate('assign_trips.trip_start_date', '<=', $request->to_date);
            }

            if ($role_id == 4) {
              $query->where(function ($query) use ($admin_id) {
                $query->where('assign_trips.admin_id', '=', $admin_id)->orWhereRaw('FIND_IN_SET(?, from_locations.admin_id)', [$admin_id])
                ->orWhereRaw('FIND_IN_SET(?, to_locations.admin_id)', [$admin_id]);
              });
            } else if ($role_id != 0) {
              $query->where('assign_trips.admin_id', '=', $admin_id);
            }
        
            $trips = $query->get();
            
              
        }

    $pdf = PDF::loadView('admin.report.trips-reports-pdf',compact('trips','trip_id','dateRange'));

    return $pdf->download('trips-reports.pdf');

  }

  public function route_reports(Request $request) {
    if (auth('admin')->user()->id) {
      $admin_id = auth('admin')->id();
      $role_id = auth('admin')->user()->role_id;
    } else {
      $admin_id = 0;
      $role_id = 0;
    }
    $trips = AssignTrip::where('status', 'enable')->where(function ($query) use($role_id,$admin_id) {
      if($role_id != 0) {$query->where('assign_trips.admin_id', '=', $admin_id);
      }
    })->get(['id', 'trip_id']);

    return view('admin.report.route-reports',compact('trips'));
  }

  public function pdf_route_reports(Request $request)
  {
  //   set_time_limit(0);
  // ini_set("memory_limit",-1);
  // ini_set('max_execution_time', 0);

    // ini_set('memory_limit', '-1');
    $route_reports=new stdClass();
    $route_trips=new stdClass();
    $trips=new stdClass();
  

    if (auth('admin')->user()->id) {
      $admin_id = auth('admin')->id();
      $role_id = auth('admin')->user()->role_id;
    } else {
      $admin_id = 0;
      $role_id = 0;
    }
    $trip_id = ($request->trip_id !== null) ? $request->trip_id : '';
    // echo $trip_id;
    // die;
    if (!empty($request->trip_id)) { 
      // $search = $request->search['value'];
      $query = AssignTrip::select('assign_trips.*', 'admins.gst_no as gstno','from_locations.location_port_name as from_location_name',
      'to_locations.location_port_name as to_location_name','gd.device_id')
        ->join('locations as from_locations', 'assign_trips.from_destination', '=', 'from_locations.id')
        ->join('locations as to_locations', 'assign_trips.to_destination', '=', 'to_locations.id')
        ->join('gps_devices as gd', 'assign_trips.gps_devices_id', '=', 'gd.id')
        ->join('admins', 'assign_trips.admin_id', '=', 'admins.id')
        ->where('trip_id',$request->trip_id ?? '');
         $totalRecords = $query->count();
      
          $filteredRecords = $query->count();
          $route_trip = $query->first();
          $route_trips = array();

            //  echo '<pre>';
            //  print_r($route_trip);
            //  die;

      if(isset($route_trip->device_id))
       {
         $device_id = $route_trip->device_id;
       } 
         else 
         {
           $device_id =''; 
          }  

      $tc_devices = DB::table('tc_devices')->where('uniqueid',$device_id)->first();
  
      $deviceid = $tc_devices->id ?? '';
      $trip_start_date = $route_trip->trip_start_date ?? '';
      $adjusted_start_date = Carbon::parse($trip_start_date)->subHours(5)->subMinutes(30);
      $first_ins_location_time = $adjusted_start_date->format('Y-m-d H:i:s');

      $completed_trip_time = $route_trip->completed_trip_time ?? '';
      $adjusted_end_time = Carbon::parse($completed_trip_time)->subHours(5)->subMinutes(30);
      $last_ins_location_time = $adjusted_end_time->format('Y-m-d H:i:s');
  
      // DB::connection()->enableQueryLog();
      $devicedata = DB::table('tc_positions')
        ->whereNotNull('address')
        ->where('devicetime', '>=', $first_ins_location_time)
        ->where('devicetime', '<=', $last_ins_location_time)
        ->where('deviceid', $deviceid) 
        //->limit(390)
        ->orderBy('id', 'asc');
        $totalRecords = $devicedata->count();
        $getdata = $devicedata->get();
        // DB::connection()->disableQueryLog();
        // $queries = DB::getQueryLog();
      //    echo '<pre>';
      //    print_r($getdata);
      //  die;
    }
    // return view('admin.report.route-reports-pdf',compact('device_id','getdata','route_reports','trips','trip_id'));
   $pdf = PDF::loadView('admin.report.route-reports-pdf', compact('device_id','getdata','route_reports','trips','trip_id'));
    // echo "<pre>";
    // print_r( $pdf);die;
    return $pdf->download('route_reports.pdf');
  }

  public function excel_route_reports(Request $request){
    $route_trips=new stdClass();
    if (auth('admin')->user()->id) {
      $admin_id = auth('admin')->id();
      $role_id = auth('admin')->user()->role_id;
    } else {
      $admin_id = 0;
      $role_id = 0;
    }
    if (!empty($request->trip_id)) {
      
    
      $search = $request->search['value'] ?? null;
      

      $query = AssignTrip::select('assign_trips.*', 'admins.gst_no as gstno','from_locations.location_port_name as from_location_name',
      'to_locations.location_port_name as to_location_name','gd.device_id')
      ->join('locations as from_locations', 'assign_trips.from_destination', '=', 'from_locations.id')
      ->join('locations as to_locations', 'assign_trips.to_destination', '=', 'to_locations.id')
      ->join('gps_devices as gd', 'assign_trips.gps_devices_id', '=', 'gd.id')
      ->join('admins', 'assign_trips.admin_id', '=', 'admins.id')
      ->where('trip_id',$request->trip_id ?? '');
      $totalRecords = $query->count();
      
      $query->select(
        'assign_trips.*', 'admins.gst_no as gstno','from_locations.location_port_name as from_location_name',
        'to_locations.location_port_name as to_location_name',
        'gd.device_id'
      );

      $filteredRecords = $query->count();
      $route_trip = $query->first();
      $route_trips = array();
      

      if(isset($route_trip->device_id)) { $device_id = $route_trip->device_id; } else { $device_id =''; }  
      $tc_devices = DB::table('tc_devices')->where('uniqueid',$device_id)->first();

      $deviceid = $tc_devices->id ?? '';
      $trip_start_date = $route_trip->trip_start_date ?? '';
      $adjusted_start_date = Carbon::parse($trip_start_date)->subHours(5)->subMinutes(30);
      $first_ins_location_time = $adjusted_start_date->format('Y-m-d H:i:s');

      $completed_trip_time = $route_trip->completed_trip_time ?? '';
      $adjusted_end_time = Carbon::parse($completed_trip_time)->subHours(5)->subMinutes(30);
      $last_ins_location_time = $adjusted_end_time->format('Y-m-d H:i:s');
    
      $devicedata = DB::table('tc_positions')->whereNotNull('address')
      ->where('devicetime', '>=', $first_ins_location_time)
      ->where('devicetime', '<=', $last_ins_location_time)
      ->orderBy('id', 'asc')->where('deviceid',$deviceid);

      $totalRecords = $devicedata->count();
      $getdata = $devicedata->get();
    }

          $spreadsheet = new Spreadsheet();
          $sheet = $spreadsheet->getActiveSheet();

          $sheet->setCellValue('C1', 'Route Reports')->getStyle('C1')->getFont()->setBold(true);
  
          $sheet->setCellValue('A4', 'Trip ID')->getStyle('A4')->getFont()->setBold(true);
          
          $sheet->setCellValue('B4', ($request->trip_id !== 'null') ? $request->trip_id : '');

          $sheet->getColumnDimension('A')->setWidth(10); 
          $sheet->getColumnDimension('B')->setWidth(22); 
          $sheet->getColumnDimension('C')->setWidth(25); 

          $sheet->setCellValue('A6', 'Sr No')->getStyle('A6')->getFont()->setBold(true);
          $sheet->setCellValue('B6', 'Device ID')->getStyle('B6')->getFont()->setBold(true);
          $sheet->setCellValue('C6', 'Date')->getStyle('C6')->getFont()->setBold(true);
          $sheet->setCellValue('D6', 'Latitude')->getStyle('D6')->getFont()->setBold(true);
          $sheet->setCellValue('E6', 'Longitude')->getStyle('E6')->getFont()->setBold(true);
          $sheet->setCellValue('F6', 'Speed')->getStyle('F6')->getFont()->setBold(true);
          $sheet->setCellValue('G6', 'Current Address')->getStyle('G6')->getFont()->setBold(true);

          $sheet->getStyle('A6:G6')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('c6efce');
          $sheet->getStyle('A6:G6')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
          $row = 7;
          foreach ($getdata as $i => $log) {

            $devicetime = $log->devicetime ?? '';
            $adjusted_time = Carbon::parse($devicetime)->addHours(5)->addMinutes(30);
            $adjusted_time_format = date('Y-m-d H:i:s',strtotime($adjusted_time));
         
              $sheet->setCellValue('A' . $row, $i + 1 ?? '');
              $sheet->getStyle('A' . $row)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
              $sheet->setCellValue('B' . $row, $device_id ?? '');
              $sheet->getStyle('B' . $row)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
              $sheet->setCellValue('C' . $row, $adjusted_time_format ?? '');
              $sheet->getStyle('C' . $row)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
              // $sheet->getStyle('D'  . $row, $log->latitude ?? '');
              $sheet->setCellValue('D' . $row, $log->latitude ?? '');
              $sheet->getStyle('D' . $row)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
              $sheet->setCellValue('E' . $row, $log->longitude ?? '');
              $sheet->getStyle('E' . $row)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
              $sheet->setCellValue('F'  . $row, $log->speed ??'');
              $sheet->getStyle('F' . $row)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
              $sheet->setCellValue('G' . $row, $log->address ?? '');
              $sheet->getStyle('G' . $row)->getAlignment()->setWrapText(true);
            
              // $sheet->getStyle('E' . $row)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
              $row++;
          }
          
          $sheet->getColumnDimension('D')->setWidth(30); 
          $sheet->getColumnDimension('E')->setWidth(15); 
          $sheet->getColumnDimension('F')->setWidth(15); 
          $sheet->getColumnDimension('G')->setWidth(25); 
          $sheet->getColumnDimension('H')->setWidth(15); 
          $sheet->getColumnDimension('I')->setWidth(15); 
          $sheet->getColumnDimension('J')->setWidth(15); 


          $writer = new Xlsx($spreadsheet);
          $filename = 'route-reports.xlsx';
  
          header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
          header('Content-Disposition: attachment;filename="' . $filename . '"');
          header('Cache-Control: max-age=0');
  
          $writer->save('php://output');
          exit;
  }

  public function route_trips(Request $request) {

    if (auth('admin')->user()->id) {
      $admin_id = auth('admin')->id();
      $role_id = auth('admin')->user()->role_id;
    } else {
      $admin_id = 0;
      $role_id = 0;
    }
    
    if (!empty($request->trip_id)) {
      
      $search = $request->search['value'];

      $query = AssignTrip::select('assign_trips.*', 'admins.gst_no as gstno','from_locations.location_port_name as from_location_name',
      'to_locations.location_port_name as to_location_name','gd.device_id')
      ->join('locations as from_locations', 'assign_trips.from_destination', '=', 'from_locations.id')
      ->join('locations as to_locations', 'assign_trips.to_destination', '=', 'to_locations.id')
      ->join('gps_devices as gd', 'assign_trips.gps_devices_id', '=', 'gd.id')
      ->join('admins', 'assign_trips.admin_id', '=', 'admins.id')
      ->where('trip_id',$request->trip_id ?? '');
      $totalRecords = $query->count();
      
      $query->select(
        'assign_trips.*', 'admins.gst_no as gstno','from_locations.location_port_name as from_location_name',
        'to_locations.location_port_name as to_location_name',
        'gd.device_id'
      );

      $filteredRecords = $query->count();
      $route_trip = $query->first();
      $route_trips = array();

      if(isset($route_trip->device_id)) { $device_id = $route_trip->device_id; } else { $device_id =''; }  
      $tc_devices = DB::table('tc_devices')->where('uniqueid',$device_id)->first();

      $deviceid = $tc_devices->id ?? '';
      $trip_start_date = $route_trip->trip_start_date ?? '';
      $adjusted_start_date = Carbon::parse($trip_start_date)->subHours(5)->subMinutes(30);
      $first_ins_location_time = $adjusted_start_date->format('Y-m-d H:i:s');

      $completed_trip_time = $route_trip->completed_trip_time ?? '';
      $adjusted_end_time = Carbon::parse($completed_trip_time)->subHours(5)->subMinutes(30);
      $last_ins_location_time = $adjusted_end_time->format('Y-m-d H:i:s');
    
      $devicedata = DB::table('tc_positions')->whereNotNull('address')
      ->where('devicetime', '>=', $first_ins_location_time)
      ->where('devicetime', '<=', $last_ins_location_time)
      ->orderBy('id', 'asc')->where('deviceid',$deviceid);

      $totalRecords = $devicedata->count();

      $getdata = $devicedata->skip(intval($request->start))->take(intval($request->length))->get();
     

      $i = intval($request->start);

      foreach($getdata as $key1 => $value1) {
          $devicetime = $value1->devicetime ?? '';
          $latitude = $value1->latitude ?? '';
          $longitude = $value1->longitude ?? '';
          $speed = $value1->speed ?? '';
          $address = $value1->address ?? '';
          $i++;

          $adjusted_time = Carbon::parse($devicetime)->addHours(5)->addMinutes(30);
          $adjusted_time_format = date('Y-m-d H:i:s',strtotime($adjusted_time));
          
          $route_trips[] = array(
          $i,
          $device_id,
          $adjusted_time_format,
          $latitude,
          $longitude ,
          $speed,
          $address,
        );
      }
    }else {
      $totalRecords = 0;
      $filteredRecords = 0;
      $route_trips = array();
    }

    $output = array(
      "draw" => $_POST['draw'],
      "recordsTotal" => $filteredRecords,
      "recordsFiltered" =>$totalRecords,
      "data" => $route_trips,
    );
    echo json_encode($output);
  }

  public function lock_and_unlock_reports(Request $request){
    if (auth('admin')->user()->id) {
      $admin_id = auth('admin')->id();
      $role_id = auth('admin')->user()->role_id;
    } else {
      $admin_id = 0;
      $role_id = 0;
    }
    $trips = AssignTrip::where('status', 'enable')->where(function ($query) use($role_id,$admin_id) {
      if($role_id != 0) {$query->where('assign_trips.admin_id', '=', $admin_id);
      }
    })->get(['id', 'trip_id']);

    return view('admin.report.lock-and-unlock-reports', compact('trips'));
  }

  public function lock_and_unlock_trips(Request $request){
    if (auth('admin')->user()->id) {
      $admin_id = auth('admin')->id();
      $role_id = auth('admin')->user()->role_id;
    } else {
      $admin_id = 0;
      $role_id = 0;
    }

    if (!empty($request->trip_id)) {
      $search = $request->search['value'];
      $query = DB::table('tc_data_event')
        ->Join('assign_trips', 'tc_data_event.trip_id', '=', 'assign_trips.trip_id')
        ->leftJoin('gps_devices as gd', 'assign_trips.gps_devices_id', '=', 'gd.id')
        ->where('command_word', '!=', '@JT')
        ->whereIn('event_source_type', ['1', '4','5','6','7'])
        ->where(function ($query) use ($role_id, $admin_id) {
          if ($role_id != 0) {
            $query->where('assign_trips.admin_id', '=', $admin_id);
          }
        });
      $totalRecords = $query->count();
      $query->select(
        'tc_data_event.*'
      );
      if (!empty($search)) {
        $query = $query->where(function ($query) use ($search) {
          $query->where('tc_data_event.trip_id', 'like', '%' . $search . '%');
        });
      }

      if ($request->trip_id) {
        $trip_id = $request->trip_id;
        if (!empty($trip_id)) {
          $query = $query->where(function ($q) use ($trip_id) {
            $q->whereIn('tc_data_event.trip_id', $trip_id);

          });
        }
      } 

      $filteredRecords = $query->count();
      $lock_unlock_trip = $query->skip(intval($request->start))->take(intval($request->length))->get();
      $lock_unlock_trips = array();
      foreach ($lock_unlock_trip as $key => $value) {
        $id = $key + 1 ?? '';


     
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

        if (isset($value->rfid_card_number)) {
          $rfid_card_number = $value->rfid_card_number;
        
        } else {
          $rfid_card_number = '';
        }

        if (isset($value->alert_naration)) {
          $alert_naration = $value->alert_naration;
        
        } else {
          $alert_naration = '';
        }

        if (isset($value->created_at)) {
          $created_at = $value->created_at;
        
        } else {
            $created_at = '';
        }

        if (isset($value->device_id)) {
          $device_id = $value->device_id;
        } else {
          $device_id = '';
        }
        if (isset($value->latitude)) {
          $latitude = $value->latitude;
        } else {
          $latitude = '';
        }
        if (isset($value->longitude)) {
          $longitude = $value->longitude;
        } else {
          $longitude = '';
        }
        
        if (isset($value->speed)) {
          $speed = $value->speed;
        } else {
          $speed = '';
        }
        if (isset($value->address)) {
          $address = $value->address;
        } else {
          $address = '';
        }
        

        $lock_unlock_trips[] = array(
          $id,
          $trip_id, 
          $rfid_card_number,
          $alert_title . '/' . $alert_naration,
          $created_at,
          $device_id,
          $address,
          $latitude,
          $longitude,
          $speed,
        );
      }

    }else {
      $totalRecords = 0;
      $filteredRecords = 0;
      $lock_unlock_trips = array();
    }
    $output = array(
      "draw" => $_POST['draw'],
      "recordsTotal" => $totalRecords,
      "recordsFiltered" => $filteredRecords,
      "data" => $lock_unlock_trips,
    );
    echo json_encode($output);
 
  }

  public function excel_lock_unlock_report(Request $request){
    $lock_unlock_trips=new stdClass();
    if (auth('admin')->user()->id) {
      $admin_id = auth('admin')->id();
      $role_id = auth('admin')->user()->role_id;
    } else {
      $admin_id = 0;
      $role_id = 0;
    }
      if (!empty($request->trip_id)) {
        $query = DB::table('tc_data_event')
            ->join('assign_trips', 'tc_data_event.trip_id', '=', 'assign_trips.trip_id')
            ->leftJoin('gps_devices as gd', 'assign_trips.gps_devices_id', '=', 'gd.id')
            ->where('command_word', '!=', '@JT')
            ->whereIn('event_source_type', ['1', '4','5','6','7'])
            ->where(function ($query) use ($role_id, $admin_id) {
                if ($role_id != 0) {
                    $query->where('assign_trips.admin_id', '=', $admin_id);
                }
            });
    
        $query->select(
            'tc_data_event.*'
        );
    
        if ($request->trip_id) {
          $trip_id = $request->trip_id;
          $trip_ids = explode(',', $trip_id);
          if (isset($trip_ids) && !empty($trip_ids)) {
            $query = $query->where(function ($q) use ($trip_ids) {
              $q->whereIn('tc_data_event.trip_id', $trip_ids);
  
            });
          }
        } 
        
        $lock_unlock_trips = $query->get();
    }

          $spreadsheet = new Spreadsheet();
          $sheet = $spreadsheet->getActiveSheet();

          $sheet->setCellValue('C1', 'Lock Unlock Trips Reports')->getStyle('C1')->getFont()->setBold(true);
  
          $sheet->setCellValue('A4', 'Trip ID')->getStyle('A4')->getFont()->setBold(true);
          
          $sheet->setCellValue('B4', ($request->trip_id !== 'null') ? $request->trip_id : '');

          $sheet->getColumnDimension('A')->setWidth(10); 
          $sheet->getColumnDimension('B')->setWidth(22); 
          $sheet->getColumnDimension('C')->setWidth(25); 

          $sheet->setCellValue('A6', 'Sr No')->getStyle('A6')->getFont()->setBold(true);
          $sheet->setCellValue('B6', 'Trip ID')->getStyle('B6')->getFont()->setBold(true);
          $sheet->setCellValue('C6', 'Rf Id Card Number')->getStyle('C6')->getFont()->setBold(true);
          $sheet->setCellValue('D6', 'Event Type')->getStyle('D6')->getFont()->setBold(true);
          $sheet->setCellValue('E6', 'Event Date')->getStyle('E6')->getFont()->setBold(true);
          $sheet->setCellValue('F6', 'Device ID')->getStyle('F6')->getFont()->setBold(true);
          $sheet->setCellValue('G6', 'Current Address')->getStyle('G6')->getFont()->setBold(true);
          $sheet->setCellValue('H6', 'Latitude')->getStyle('H6')->getFont()->setBold(true);
          $sheet->setCellValue('I6', 'Longitude')->getStyle('I6')->getFont()->setBold(true);
          $sheet->setCellValue('J6', 'Speed')->getStyle('J6')->getFont()->setBold(true);

          $sheet->getStyle('A6:J6')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('c6efce');
          $sheet->getStyle('A6:J6')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
          $row = 7;
          foreach ($lock_unlock_trips as $i => $log) {
         
              $sheet->setCellValue('A' . $row, $i + 1 ?? '');
              $sheet->getStyle('A' . $row)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
              $sheet->setCellValue('B' . $row, $log->trip_id ?? '');
              $sheet->setCellValue('C' . $row, $log->rfid_card_number ?? '');
              $sheet->setCellValue('D' . $row, ($log->alert_title ?? '') . '/' . ($log->alert_naration ?? ''));
              $sheet->getStyle('D' . $row)->getAlignment()->setWrapText(true);
              $sheet->setCellValue('E' . $row, $log->created_at ?? '');
              $sheet->getStyle('E' . $row)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
              $sheet->setCellValue('F' . $row, $log->device_id ?? '');
              $sheet->getStyle('F' . $row)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
              $sheet->setCellValue('G' . $row, $log->address ?? '');
              $sheet->getStyle('G' . $row)->getAlignment()->setWrapText(true);
              $sheet->setCellValue('H' . $row, $log->latitude ?? '');
              $sheet->getStyle('H' . $row)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
              $sheet->setCellValue('I' . $row, $log->longitude ?? '');
              $sheet->getStyle('I' . $row)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
              $sheet->setCellValue('J' . $row, $log->speed ??'');
              $sheet->getStyle('J' . $row)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);


              $row++;
          }
          
          $sheet->getColumnDimension('D')->setWidth(30); 
          $sheet->getColumnDimension('E')->setWidth(15); 
          $sheet->getColumnDimension('F')->setWidth(15); 
          $sheet->getColumnDimension('G')->setWidth(25); 
          $sheet->getColumnDimension('H')->setWidth(15); 
          $sheet->getColumnDimension('I')->setWidth(15); 
          $sheet->getColumnDimension('J')->setWidth(15); 


          $writer = new Xlsx($spreadsheet);
          $filename = 'lock_unlock_reports.xlsx';
  
          header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
          header('Content-Disposition: attachment;filename="' . $filename . '"');
          header('Cache-Control: max-age=0');
  
          $writer->save('php://output');
          exit;
  }

  public function pdf_lock_unlock_report(Request $request){
    $lock_unlock_trips=new stdClass();

    if (auth('admin')->user()->id) {
      $admin_id = auth('admin')->id();
      $role_id = auth('admin')->user()->role_id;
    } else {
      $admin_id = 0;
      $role_id = 0;
    }
    $trip_id = ($request->trip_id !== null) ? $request->trip_id : '';
  
    if (!empty($request->trip_id)) {
      $query = DB::table('tc_data_event')
          ->join('assign_trips', 'tc_data_event.trip_id', '=', 'assign_trips.trip_id')
          ->leftJoin('gps_devices as gd', 'assign_trips.gps_devices_id', '=', 'gd.id')
          ->where('command_word', '!=', '@JT')
          ->whereIn('event_source_type', ['1', '4','5','6','7'])
          ->where(function ($query) use ($role_id, $admin_id) {
              if ($role_id != 0) {
                  $query->where('assign_trips.admin_id', '=', $admin_id);
              }
          });
  
      $query->select(
          'tc_data_event.*'
      );
      
    
      if ($request->trip_id) {
        $trip_id = $request->trip_id;
        $trip_ids = explode(',', $trip_id);
        if (isset($trip_ids) && !empty($trip_ids)) {
          $query = $query->where(function ($q) use ($trip_ids) {
            $q->whereIn('tc_data_event.trip_id', $trip_ids);

          });
        }
      } 
      
      $lock_unlock_trips = $query->get();
    }
    $pdf = PDF::loadView('admin.report.lock-unlock-reports-pdf', compact('lock_unlock_trips','trip_id'));

    return $pdf->download('lock_unlock_report.pdf');

  }

  public function stop_reports(){

    return view('admin.report.stop-reports');
  }
  
  public function device_summary_reports(){
    if (auth('admin')->user()->id) {
      $admin_id = auth('admin')->id();
      $role_id = auth('admin')->user()->role_id;
    } else {
      $admin_id = 0;
      $role_id = 0;
    }
    $gpsdevices = GpsDevice::where('status', 'enable')->where(function ($query) use($role_id,$admin_id) {
      if($role_id != 0) {$query->where('gps_devices.admin_id', '=', $admin_id);
      }
    })->get(['id', 'device_id']);
    $trips = AssignTrip::where('status', 'enable')->where(function ($query) use($role_id,$admin_id) {
      if($role_id != 0) {$query->where('assign_trips.admin_id', '=', $admin_id);
      }
    })->get(['id', 'trip_id']);

    return view('admin.report.device-summary-reports', compact('gpsdevices', 'trips'));
  }
  public function get_device_summary(Request $request){
    $query= new stdClass();
    $device_summary= new stdClass();
    if (auth('admin')->user()->id) {
      $admin_id = auth('admin')->id();
      $role_id = auth('admin')->user()->role_id;
    } else {
      $admin_id = 0;
      $role_id = 0;
    }
    if (!empty($request->device_id) && !empty($request->trip_id)) {
      $query = AssignTrip::select('assign_trips.*', 'admins.gst_no as gstno','from_locations.location_port_name as from_location_name','to_locations.location_port_name as to_location_name','gps_devices.device_id')
      ->join('locations as from_locations', 'assign_trips.from_destination', '=', 'from_locations.id')
      ->join('locations as to_locations', 'assign_trips.to_destination', '=', 'to_locations.id')
      ->join('admins', 'assign_trips.admin_id', '=', 'admins.id')
      ->Join('gps_devices', 'assign_trips.gps_devices_id', '=', 'gps_devices.id')
      ->where(function ($query) use ($role_id, $admin_id) {
        if ($role_id != 0) {
          $query->where('assign_trips.admin_id', '=', $admin_id);
        }
      });

      if ($request->device_id) {
          $device_id = $request->device_id;
          $query = $query->where(function ($q) use ($device_id) {
              $q->where('gps_devices.device_id', $device_id);
          });
      }

      if ($request->trip_id) {
          $trip_id = $request->trip_id;
          $query = $query->where(function ($q) use ($trip_id) {
              $q->where('assign_trips.trip_id', $trip_id);
          });
      }
      $device_summary = $query->first();
      $device_summary->invoice_bill_url= asset('invoice_bill/'.$device_summary->invoice_bill) ??'';
      $device_summary->custom_unexture_A_url= asset('unexture_a/'.$device_summary->custom_unexture_a) ??'';
      $device_summary->custom_unexture_B_url= asset('unexture_b/'.$device_summary->custom_unexture_b) ??'';

    }

    $data =array();
    $data['device_summary'] = $device_summary;
    echo json_encode($data);

  }

  public function excel_device_summary_reports(Request $request){
    
    $query= new stdClass();
    $device_summary= new stdClass();
  
    if (auth('admin')->user()->id) {
      $admin_id = auth('admin')->id();
      $role_id = auth('admin')->user()->role_id;
    } else {
      $admin_id = 0;
      $role_id = 0;
    }
    if ((!empty($request->device_id) && !empty($request->trip_id)) || (!empty($request->trip_id))) {
      $query = AssignTrip::select('assign_trips.*', 'admins.gst_no as gstno','from_locations.location_port_name as from_location_name','to_locations.location_port_name as to_location_name','gps_devices.device_id')
      ->join('locations as from_locations', 'assign_trips.from_destination', '=', 'from_locations.id')
      ->join('locations as to_locations', 'assign_trips.to_destination', '=', 'to_locations.id')
      ->join('admins', 'assign_trips.admin_id', '=', 'admins.id')
      ->Join('gps_devices', 'assign_trips.gps_devices_id', '=', 'gps_devices.id')
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
      });
    

      if ($request->device_id) {
        $device_id = $request->device_id;
        $query = $query->where(function ($q) use ($device_id) {
            $q->where('gps_devices.device_id', $device_id);
        });
    }

    if ($request->trip_id) {
        $trip_id = $request->trip_id;
        $query = $query->where(function ($q) use ($trip_id) {
            $q->where('assign_trips.trip_id', $trip_id);
        });
    }
  
       
          $device_summary = $query->first();

          $tripId = (isset($device_summary->trip_id) && !empty($device_summary->trip_id)) ? $device_summary->trip_id : '';
          $driverName = (isset($device_summary->container_details->driver_name) && !empty($device_summary->container_details->driver_name)) ? $device_summary->container_details->driver_name : '';
          $containerNo = (isset($device_summary->container_details->container_no) && !empty($device_summary->container_details->container_no)) ? $device_summary->container_details->container_no : '';
          $vehicleNo = (isset($device_summary->container_details->vehicle_no) && !empty($device_summary->container_details->vehicle_no)) ? $device_summary->container_details->vehicle_no : '';
          $licenseNo = (isset($device_summary->container_details->license_no) && !empty($device_summary->container_details->license_no)) ? $device_summary->container_details->license_no : '';
          $idProofNo = (isset($device_summary->container_details->id_proof_no) && !empty($device_summary->container_details->id_proof_no)) ? $device_summary->container_details->id_proof_no : '';
          $mobileNo = (isset($device_summary->container_details->mobile_no) && !empty($device_summary->container_details->mobile_no)) ? $device_summary->container_details->mobile_no : '';
          $coDriverName = (isset($device_summary->container_details->co_driver_name) && !empty($device_summary->container_details->co_driver_name)) ? $device_summary->container_details->co_driver_name : '';
          $coDriverLicenseNo = (isset($device_summary->container_details->co_driver_license_no) && !empty($device_summary->container_details->co_driver_license_no)) ? $device_summary->container_details->co_driver_license_no : '';
          $coDriverIdProofNo = (isset($device_summary->container_details->co_drive_id_proof_no) && !empty($device_summary->container_details->co_drive_id_proof_no)) ? $device_summary->container_details->co_drive_id_proof_no : '';
          $invoiceNo = (isset($device_summary->shipping_details->invoice_no) && !empty($device_summary->shipping_details->invoice_no)) ? $device_summary->shipping_details->invoice_no : '';
          $invoiceDate = (isset($device_summary->shipping_details->invoice_date) && !empty($device_summary->shipping_details->invoice_date)) ? $device_summary->shipping_details->invoice_date : '';
          $customerCifInr = (isset($device_summary->shipping_details->customer_cif_inr) && !empty($device_summary->shipping_details->customer_cif_inr)) ? $device_summary->shipping_details->customer_cif_inr : '';
          $eWayBillNo = (isset($device_summary->shipping_details->e_way_bill_no) && !empty($device_summary->shipping_details->e_way_bill_no)) ? $device_summary->shipping_details->e_way_bill_no : '';
          $shippingDetails = (isset($device_summary->shipping_details->shipping_details) && !empty($device_summary->shipping_details->shipping_details)) ? $device_summary->shipping_details->shipping_details : '';
          $exporterDetails = (isset($device_summary->shipping_details->exporter_details) && !empty($device_summary->shipping_details->exporter_details)) ? $device_summary->shipping_details->exporter_details : '';
          $cargoType = (isset($device_summary->shipping_details->cargo_type) && !empty($device_summary->shipping_details->cargo_type)) ? $device_summary->shipping_details->cargo_type : '';
          $shipmentType = (isset($device_summary->shipping_details->shipment_type) && !empty($device_summary->shipping_details->shipment_type)) ? $device_summary->shipping_details->shipment_type : '';
          $tripStartDate = (isset($device_summary->trip_start_date) && !empty($device_summary->trip_start_date)) ? $device_summary->trip_start_date : '';
          $expectedArrivalTime = (isset($device_summary->expected_arrival_time) && !empty($device_summary->expected_arrival_time)) ? $device_summary->expected_arrival_time : '';
          $completedTripTime = (isset($device_summary->completed_trip_time) && !empty($device_summary->completed_trip_time)) ? $device_summary->completed_trip_time : '';
          $gstno = (isset($device_summary->gstno) && !empty($device_summary->gstno)) ? $device_summary->gstno : '';
          $fromLocationName = (isset($device_summary->from_location_name) && !empty($device_summary->from_location_name)) ? $device_summary->from_location_name : '';
          $toLocationName = (isset($device_summary->to_location_name) && !empty($device_summary->to_location_name)) ? $device_summary->to_location_name : '';
          $deviceId = (isset($device_summary->device_id) && !empty($device_summary->device_id)) ? $device_summary->device_id : '';
          $invoice_bill = (isset($device_summary->invoice_bill) && !empty($device_summary->invoice_bill)) ? $device_summary->invoice_bill : '';
          $custom_unexture_a = (isset($device_summary->custom_unexture_a) && !empty($device_summary->custom_unexture_a)) ? $device_summary->custom_unexture_a : '';
          $custom_unexture_b = (isset($device_summary->custom_unexture_b) && !empty($device_summary->custom_unexture_b)) ? $device_summary->custom_unexture_b : '';

    }
          $spreadsheet = new Spreadsheet();
          $sheet = $spreadsheet->getActiveSheet();

          
          $sheet->setCellValue('C1', 'Device Summary Reports')->getStyle('C1')->getFont()->setBold(true);
          if (isset($request->device_id)) {
            
            $sheet->setCellValue('A4', 'Device ID')->getStyle('A4')->getFont()->setBold(true);

          }
          $sheet->setCellValue('A5', 'Trip ID')->getStyle('A5')->getFont()->setBold(true);
          
       
          $sheet->mergeCells('B4:C4')->setCellValue('B4', ($request->device_id !== 'null') ? $request->device_id :'');
          $sheet->getStyle('B4:C4')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
          $sheet->mergeCells('B5:C5')->setCellValue('B5', ($request->trip_id !== 'null') ? $request->trip_id : '');
         
          $sheet->mergeCells('A8:I8')->setCellValue('A8', 'Driver Summary')->getStyle('A8')->getFont()->setBold(true);;

          $sheet->mergeCells('A9:C9')->setCellValue('A9', 'Driver Name: '. $driverName ??'');
          $sheet->mergeCells('D9:F9')->setCellValue('D9', 'Container No: '.$containerNo);
          $sheet->mergeCells('G9:I9')->setCellValue('G9', 'Vehicle No: '.$vehicleNo);
          $sheet->mergeCells('A10:C10')->setCellValue('A10', 'License No: '.$licenseNo);
          $sheet->mergeCells('D10:F10')->setCellValue('D10', 'Id Proof No: '.$idProofNo);
          $sheet->mergeCells('G10:I10')->setCellValue('G10', 'Mobile No: '.$mobileNo);
          $sheet->mergeCells('A11:C11')->setCellValue('A11', 'Co Driver Name: '.$coDriverName);
          $sheet->mergeCells('D11:F11')->setCellValue('D11', 'Co Driver License No: '.$coDriverLicenseNo);
          $sheet->mergeCells('G11:I11')->setCellValue('G11', 'Co Drive Id Proof No: '.$coDriverIdProofNo);

          $borderStyle = ['borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN]]];
          $sheet->getStyle('A8:I11')->applyFromArray($borderStyle);
          $sheet->mergeCells('A12:Z12');
          $sheet->mergeCells('A13:I13')->setCellValue('A13', 'Trip Summary')->getStyle('A13')->getFont()->setBold(true);;

          $sheet->mergeCells('A14:C14')->setCellValue('A14', 'Device ID: '.$deviceId);
          $sheet->mergeCells('D14:F14')->setCellValue('D14', 'Trips ID: '.$tripId);
          $sheet->mergeCells('G14:I14')->setCellValue('G14', 'From Destination: '.$fromLocationName);
          $sheet->mergeCells('A15:C15')->setCellValue('A15', 'To Destination: '.$toLocationName);
          $sheet->mergeCells('D15:F15')->setCellValue('D15', 'Cargo Type: '.$cargoType);
          $sheet->mergeCells('G15:I15')->setCellValue('G15', 'GST No: '.$gstno);
          $sheet->mergeCells('A16:C16')->setCellValue('A16', 'Start Date: '.$tripStartDate);
          $sheet->mergeCells('D16:F16')->setCellValue('D16', 'Expected Date: '.$expectedArrivalTime);
          $sheet->mergeCells('G16:I16')->setCellValue('G16', 'Completed Date: '.$completedTripTime);

          $borderStyle = ['borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN]]];
          $sheet->getStyle('A13:I16')->applyFromArray($borderStyle);
          $sheet->mergeCells('A17:Z17');
          $sheet->mergeCells('A18:I18')->setCellValue('A18', 'Shipping Details')->getStyle('A18')->getFont()->setBold(true);

          $sheet->mergeCells('A19:C19')->setCellValue('A19', 'Invoice No: '.$invoiceNo);
          $sheet->mergeCells('D19:F19')->setCellValue('D19', 'Invoice Date: '.$invoiceDate);
          $sheet->mergeCells('G19:I19')->setCellValue('G19', 'Customer CIF INR: '.$customerCifInr);
          $sheet->mergeCells('A20:C20')->setCellValue('A20', 'E Way Bill No: '.$eWayBillNo);
          $sheet->getStyle('A20:C20')->getAlignment()->setVertical(Alignment::VERTICAL_TOP);
          $sheet->mergeCells('D20:F20')->setCellValue('D20', 'Shipping Details: '.$shippingDetails);
          $sheet->getStyle('D20:F20')->getAlignment()->setVertical(Alignment::VERTICAL_TOP)->setWrapText(true);

          $sheet->mergeCells('G20:I20')->setCellValue('G20', 'Exporter Details: '.$exporterDetails);
          $sheet->getStyle('G20:I20')->getAlignment()->setVertical(Alignment::VERTICAL_TOP)->setWrapText(true);

          $sheet->mergeCells('A21:C21')->setCellValue('A21', 'Start Trip Date: '.$tripStartDate);
          $sheet->mergeCells('D21:F21')->setCellValue('D21', 'Expected Arrive Time: '.$expectedArrivalTime);
          $sheet->mergeCells('G21:I21')->setCellValue('G21', 'Cargo Type: '.$cargoType);
          $sheet->mergeCells('A22:C22')->setCellValue('A22', 'Shipment Type: '.$shipmentType);
          $sheet->mergeCells('D22:F22');
          $sheet->mergeCells('G22:I22');

          $borderStyle = ['borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN]]];
          $sheet->getStyle('A18:I22')->applyFromArray($borderStyle);
          $sheet->mergeCells('A23:Z23');
          $sheet->mergeCells('A24:I24')->setCellValue('A24', 'Documents')->getStyle('A24')->getFont()->setBold(true);

          if (isset($invoice_bill) && !empty($invoice_bill)) {
              $invoiceBillLink = asset('invoice_bill/'.$invoice_bill);
              $sheet->getCell('A25')->getHyperlink()->setUrl($invoiceBillLink);
              $sheet->getStyle('A25')->getFont()->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLUE);
              $sheet->getCell('B25')->getHyperlink()->setUrl($invoiceBillLink);
              $sheet->getStyle('B25')->getFont()->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLUE);
              $sheet->getCell('C25')->getHyperlink()->setUrl($invoiceBillLink);
              $sheet->getStyle('C25')->getFont()->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLUE);

              $sheet->mergeCells('A25:C25')->setCellValue('A25', 'Invoice Bill: '.$invoiceBillLink);
              $sheet->getStyle('A25:C25')->getAlignment()->setWrapText(true);

          }else{
            $sheet->mergeCells('A25:C25')->setCellValue('A25', 'Invoice Bill: '.'');

          }
          

          if (isset($custom_unexture_a) && !empty($custom_unexture_a)) {
            $unexture_aLink = asset('unexture_a/'.$custom_unexture_a);
            $sheet->getCell('D25')->getHyperlink()->setUrl($unexture_aLink);
            $sheet->getStyle('D25')->getFont()->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLUE);
            $sheet->getCell('E25')->getHyperlink()->setUrl($unexture_aLink);
            $sheet->getStyle('E25')->getFont()->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLUE);
            $sheet->getCell('F25')->getHyperlink()->setUrl($unexture_aLink);
            $sheet->getStyle('F25')->getFont()->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLUE);
            $sheet->mergeCells('D25:F25')->setCellValue('D25', 'Custom Unexture-A: '.$unexture_aLink);
            $sheet->getStyle('D25:F25')->getAlignment()->setWrapText(true);

          }else{
            $sheet->mergeCells('D25:F25')->setCellValue('D25', 'Custom Unexture-A:'.'');

          }
        

         if (isset($custom_unexture_b) && !empty($custom_unexture_b)) {
            $unexture_bLink = asset('unexture_b/'.$custom_unexture_b);
            $sheet->getCell('G25')->getHyperlink()->setUrl($unexture_bLink);
            $sheet->getStyle('G25')->getFont()->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLUE);
            $sheet->getCell('H25')->getHyperlink()->setUrl($unexture_bLink);
            $sheet->getStyle('H25')->getFont()->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLUE);
            $sheet->getCell('I25')->getHyperlink()->setUrl($unexture_bLink);
            $sheet->getStyle('I25')->getFont()->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLUE);
            
              $sheet->mergeCells('G25:I25')->setCellValue('G25', 'Custom Unexture-B: '.$unexture_bLink);
              $sheet->getStyle('G25:I25')->getAlignment()->setWrapText(true);

          }else{
            $sheet->mergeCells('G25:I25')->setCellValue('G25', 'Custom Unexture-B:'.'');

          }
        

          

          $borderStyle = ['borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN]]];
          $sheet->getStyle('A24:I25')->applyFromArray($borderStyle);

          $sheet->getColumnDimension('B')->setWidth(20); 
          $sheet->getRowDimension(20)->setRowHeight(60);

          $columnWidths = [
            'A' => 20, 
            'C' => 20,
            'D'=>20,
            'E' => 20,
            'F' => 25,
            'G'=>20,
            'H' => 20,
            'I' => 25,

        ];
        
        foreach ($columnWidths as $column => $width) {
            $sheet->getColumnDimension($column)->setWidth($width);
        }
         
          $writer = new Xlsx($spreadsheet);
          $filename = 'device_summary_reports.xlsx';
  
          header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
          header('Content-Disposition: attachment;filename="' . $filename . '"');
          header('Cache-Control: max-age=0');
  
          $writer->save('php://output');
          exit;
  }

  public function pdf_device_summary_report(Request $request) {
    $device_summary = '';
    $alarms = [];

    if (auth('admin')->user()->id) {
        $admin_id = auth('admin')->id();
        $role_id = auth('admin')->user()->role_id;
    } else {
        $admin_id = 0;
        $role_id = 0;
    }

    $device_id = ($request->device_id !== 'null') ? $request->device_id : '';
    $trip_id = ($request->trip_id !== 'null') ? $request->trip_id : '';

    if ((!empty($request->device_id) && !empty($request->trip_id)) || (!empty($request->trip_id))) {
        $query = AssignTrip::select('assign_trips.*', 'admins.gst_no as gstno', 'from_locations.location_port_name as from_location_name', 'to_locations.location_port_name as to_location_name', 'gps_devices.device_id')
            ->join('locations as from_locations', 'assign_trips.from_destination', '=', 'from_locations.id')
            ->join('locations as to_locations', 'assign_trips.to_destination', '=', 'to_locations.id')
            ->join('admins', 'assign_trips.admin_id', '=', 'admins.id')
            ->join('gps_devices', 'assign_trips.gps_devices_id', '=', 'gps_devices.id')
            ->where(function ($query) use ($role_id, $admin_id) {
                // if ($role_id != 0) {
                //     $query->where('assign_trips.admin_id', '=', $admin_id);
                // }
                if ($role_id == 4) {
                  $query->where(function ($query) use ($admin_id) {
                    $query->where('assign_trips.admin_id', '=', $admin_id)->orWhereRaw('FIND_IN_SET(?, from_locations.admin_id)', [$admin_id])
                    ->orWhereRaw('FIND_IN_SET(?, to_locations.admin_id)', [$admin_id]);
                  });
                } else if ($role_id != 0) {
                  $query->where('assign_trips.admin_id', '=', $admin_id);
                }
            });
            // dd($query);die;
        if (isset($request->device_id)) {
            $device_id = $request->device_id;
            if (!empty($device_id)) {
                $query = $query->where(function ($q) use ($device_id) {
                    $q->where('gps_devices.device_id', $device_id);
                });
            }
        }

        if (isset($request->trip_id)) {
            $trip_id = $request->trip_id;
            if (!empty($trip_id)) {
                $query = $query->where(function ($q) use ($trip_id) {
                    $q->where('assign_trips.trip_id', $trip_id);
                });
            }
        }

        $device_summary = $query->first();
    }

    $dateRange='';
    if(isset($fromDate) && $fromDate != null){
      $dateRange .= date('d-m-Y', strtotime($fromDate)) ;
    }
    if(isset($toDate) &&  $toDate != null){
      $dateRange .= ' To ' . date('d-m-Y', strtotime($toDate));
    } 
    if (!empty($request->device_id) || !empty($request->trip_id) || !empty($request->from_date) || !empty($request->to_date)) {
    $query = DB::table('tc_data_event')
      ->Join('assign_trips', 'tc_data_event.trip_id', '=', 'assign_trips.trip_id')
      ->leftJoin('locations as from_locations', 'assign_trips.from_destination', '=', 'from_locations.id')
      ->leftJoin('locations as to_locations', 'assign_trips.to_destination', '=', 'to_locations.id')
      ->leftJoin('gps_devices as gd', 'assign_trips.gps_devices_id', '=', 'gd.id')
      ->where('command_word', '!=', '@JT')
      ->whereIn('event_source_type', ['1', '2','3','7','8'])
      ->whereIn('unlock_verification', ['0', '1'])
      ->where(function ($query) use ($role_id, $admin_id) {
        if ($role_id != 0) {
          $query->where('assign_trips.admin_id', '=', $admin_id);
        }
      });

    $query->select(
      'tc_data_event.*',
      'from_locations.location_port_name as from_location_name',
      'to_locations.location_port_name as to_location_name',
      'assign_trips.shipping_details as shipping_detail',
      'assign_trips.container_details as container_detail',
      'assign_trips.trip_start_date as trip_start_date',
      'assign_trips.expected_arrival_time as expected_arrival_time'
    );
    // dd($query);die;
    if (isset($request->device_id) && $request->device_id !='null') {
          $device_id = $request->device_id;
          if (!empty($device_id)) {
            $query = $query->where(function ($q) use ($device_id) {
              $q->where('tc_data_event.device_id', $device_id);
            });
          }
        }

        if (isset($request->trip_id) && $request->trip_id !='null') {
          $trip_id = $request->trip_id;
          if (!empty($trip_id)) {
            $query = $query->where(function ($q) use ($trip_id) {
              $q->where('tc_data_event.trip_id', $trip_id);
            });
          }
        }
    
        if (!empty($request->from_date)) {
              $query = $query->whereDate('assign_trips.trip_start_date', '>=', $request->from_date);
            }
        if (!empty($request->to_date)) {
              $query = $query->whereDate('assign_trips.trip_start_date', '<=', $request->to_date);
            }
        $alarms = $query->get();
    }

    $fromDate = request()->from_date;
    $toDate = request()->to_date;
    
    $dateRange='';
    if(isset($fromDate) && $fromDate != null){
      $dateRange .= date('d-m-Y', strtotime($fromDate)) ;
    }
    if(isset($toDate) &&  $toDate != null){
      $dateRange .= ' To ' . date('d-m-Y', strtotime($toDate));
    } 
    if (!empty($request->device_id) || !empty($request->trip_id) || !empty($request->from_date) || !empty($request->to_date)) {
      $query = DB::table('tc_data_event')
        ->Join('assign_trips', 'tc_data_event.trip_id', '=', 'assign_trips.trip_id')
        ->leftJoin('locations as from_locations', 'assign_trips.from_destination', '=', 'from_locations.id')
        ->leftJoin('locations as to_locations', 'assign_trips.to_destination', '=', 'to_locations.id')
        ->leftJoin('gps_devices as gd', 'assign_trips.gps_devices_id', '=', 'gd.id')
        ->where('command_word', '!=', '@JT')
        ->where(function ($query) use ($role_id, $admin_id) {
          if ($role_id != 0) {
            $query->where('assign_trips.admin_id', '=', $admin_id);
          }
        });
      
      $query->select(
        'tc_data_event.*',
        'from_locations.location_port_name as from_location_name',
        'to_locations.location_port_name as to_location_name',
        'assign_trips.shipping_details as shipping_detail',
        'assign_trips.container_details as container_detail',
        'assign_trips.trip_start_date as trip_start_date',
        'assign_trips.expected_arrival_time as expected_arrival_time'
      );
     if (isset($request->device_id) && $request->device_id !='null') {
            $device_id = $request->device_id;
            if (!empty($device_id)) {
              $query = $query->where(function ($q) use ($device_id) {
                $q->where('tc_data_event.device_id', $device_id);
              });
            }
          }
  
          if (isset($request->trip_id) && $request->trip_id !='null') {
            $trip_id = $request->trip_id;
            if (!empty($trip_id)) {
              $query = $query->where(function ($q) use ($trip_id) {
                $q->where('tc_data_event.trip_id', $trip_id);
              });
            }
          }
       
          if (!empty($request->from_date)) {
                $query = $query->whereDate('assign_trips.trip_start_date', '>=', $request->from_date);
              }
          if (!empty($request->to_date)) {
                $query = $query->whereDate('assign_trips.trip_start_date', '<=', $request->to_date);
              }
          $events = $query->get();
    }
    $pdf = PDF::loadView('admin.report.device-summary-reports-pdf', compact('device_summary', 'device_id', 'trip_id', 'alarms','events'));

    return $pdf->download('device_summary_reports.pdf');
  }

  public function replay(){
    if (auth('admin')->user()->id) {
      $admin_id = auth('admin')->id();
      $role_id = auth('admin')->user()->role_id;
    } else {
      $admin_id = 0;
      $role_id = 0;
    }
    $trips = AssignTrip::where('status', 'enable')->where(function ($query) use($role_id,$admin_id) {
      if($role_id != 0) {$query->where('assign_trips.admin_id', '=', $admin_id);
      }
    })->get(['id', 'trip_id']);

    return view('admin.report.replay',compact('trips'));
  }
  
  public function events_reports(){
    if (auth('admin')->user()->id) {
      $admin_id = auth('admin')->id();
      $role_id = auth('admin')->user()->role_id;
    } else {
      $admin_id = 0;
      $role_id = 0;
    }
    $gpsdevices = GpsDevice::where('status', 'enable')->where(function ($query) use($role_id,$admin_id) {
      if($role_id != 0) {$query->where('gps_devices.admin_id', '=', $admin_id);
      }
    })->get(['id', 'device_id']);
    $trips = AssignTrip::where('status', 'enable')->where(function ($query) use($role_id,$admin_id) {
      if($role_id != 0) {$query->where('assign_trips.admin_id', '=', $admin_id);
      }
    })->get(['id', 'trip_id']);
    return view('admin.report.events-reports', compact('gpsdevices', 'trips'));
  }
  
  public function get_events_trip_details(Request $request){
    if (auth('admin')->user()->id) {
      $admin_id = auth('admin')->id();
      $role_id = auth('admin')->user()->role_id;
    } else {
      $admin_id = 0;
      $role_id = 0;
    }
    if (!empty($request->device_id) || !empty($request->trip_id) || !empty($request->from_date) || !empty($request->to_date)) {
      $search = $request->search['value'];
      $query = DB::table('tc_data_event')
        ->Join('assign_trips', 'tc_data_event.trip_id', '=', 'assign_trips.trip_id')
        ->leftJoin('locations as from_locations', 'assign_trips.from_destination', '=', 'from_locations.id')
        ->leftJoin('locations as to_locations', 'assign_trips.to_destination', '=', 'to_locations.id')
        ->leftJoin('gps_devices as gd', 'assign_trips.gps_devices_id', '=', 'gd.id')
        ->whereIn('event_source_type', ['1', '4','5'])
        ->where('command_word', '!=', '@JT')
        ->where(function ($query) use ($role_id, $admin_id) {
          if ($role_id != 0) {
            $query->where('assign_trips.admin_id', '=', $admin_id);
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
          $query->where('tc_data_event.device_id', 'like', '%' . $search . '%');
        });
      }
      
        if ($request->device_id) {
            $device_id = $request->device_id;
            $query = $query->where(function ($q) use ($device_id) {
                $q->where('tc_data_event.device_id', $device_id);
            });
        }

        if ($request->trip_id) {
            $trip_id = $request->trip_id;
            $query = $query->where(function ($q) use ($trip_id) {
                $q->where('tc_data_event.trip_id', $trip_id);
            });
        }
   
          if (!empty($request->from_date)) {
            $query = $query->whereDate('tc_data_event.created_at', '>=', $request->from_date);
          }
      if (!empty($request->to_date)) {
            $query = $query->whereDate('tc_data_event.created_at', '<=', $request->to_date);
          }
      $filteredRecords = $query->count();
      $events_trip = $query->skip(intval($request->start))->take(intval($request->length))->get();

      $events = array();
      foreach ($events_trip as $key => $value) {
        if (isset($value->shipping_detail)) {
          $shipping_details = json_decode($value->shipping_detail, true);
          $cargo_type = isset($shipping_details['cargo_type']) ? $shipping_details['cargo_type'] : '';
          $shipment_type = isset($shipping_details['shipment_type']) ? $shipping_details['shipment_type'] : '';
        } else {
          $cargo_type = '';
          $shipment_type = '';
        }


        if (isset($value->container_detail)) {
          $container_details = json_decode($value->container_detail, true);
          $driver_name = isset($container_details['driver_name']) ? $container_details['driver_name'] : '';
          $vehicle_no = isset($container_details['vehicle_no']) ? $container_details['vehicle_no'] : '';
          $mobile_no = isset($container_details['mobile_no']) ? $container_details['mobile_no'] : '';
        } else {
          $driver_name = '';
          $vehicle_no = '';
          $mobile_no = '';
        }
    
          $id = $key+1 ??'';
       
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
        if (isset($value->time)) {
          $utcDateTime = new DateTime($value->time, new DateTimeZone('UTC'));
      
          $utcDateTime->setTimezone(new DateTimeZone('Asia/Kolkata'));
      
          $time = $utcDateTime->format('d-m-Y H:i:s');
      } else {
          $time = '';
      }
        if (isset($value->address)) {
          $address = $value->address;
        } else {
          $address = '';
        }
        if (isset($value->created_at)) {
          $created_at = date("d-m-Y H:i:s", strtotime($value->created_at));
        } else {
          $created_at = '';
        }
        if (isset($value->alert_title)) {
          $alert_title = $value->alert_title;
        } else {
          $alert_title = '';
        }
        if (isset($value->rfid_card_number)) {
          $rfid_card_number = $value->rfid_card_number;
        
        } else {
          $rfid_card_number = '';
        }

        if (isset($value->alert_naration)) {
          $alert_naration = $value->alert_naration;
        
        } else {
          $alert_naration = '';
        }

        if (isset($value->latitude)) {
          $latitude = $value->latitude;
        
        } else {
          $latitude = '';
        }

        if (isset($value->longitude)) {
          $longitude = $value->longitude;
        
        } else {
          $longitude = '';
        }
        


        $events[] = array(
          $id,
          $trip_id,
          $rfid_card_number,
          $alert_title . '/' . $alert_naration,
          $cargo_type,
          $shipment_type,
          $from_location_name . ' - ' . $to_location_name,
          $address,
          $latitude,
          $longitude,
          $driver_name,
          $vehicle_no,
          $mobile_no,
          $time,
          $created_at,
        );
      }
    } else {
      $totalRecords = 0;
      $filteredRecords = 0;
      $events = array();
    }
    $output = array(
      "draw" => $_POST['draw'],
      "recordsTotal" => $totalRecords,
      "recordsFiltered" => $filteredRecords,
      "data" => $events,
    );
    echo json_encode($output);
  }
  
  public function excel_events_report(Request $request){
    if (auth('admin')->user()->id) {
      $admin_id = auth('admin')->id();
      $role_id = auth('admin')->user()->role_id;
    } else {
      $admin_id = 0;
      $role_id = 0;
    }
    if (!empty($request->device_id) || !empty($request->trip_id) || !empty($request->from_date) || !empty($request->to_date)) {
      $query = DB::table('tc_data_event')
        ->Join('assign_trips', 'tc_data_event.trip_id', '=', 'assign_trips.trip_id')
        ->leftJoin('locations as from_locations', 'assign_trips.from_destination', '=', 'from_locations.id')
        ->leftJoin('locations as to_locations', 'assign_trips.to_destination', '=', 'to_locations.id')
        ->leftJoin('gps_devices as gd', 'assign_trips.gps_devices_id', '=', 'gd.id')
        ->where('command_word', '!=', '@JT')
        ->whereIn('event_source_type', ['1', '4','5'])
        ->where(function ($query) use ($role_id, $admin_id) {
          if ($role_id != 0) {
            $query->where('assign_trips.admin_id', '=', $admin_id);
          }
        });
      
      $query->select(
        'tc_data_event.*',
        'from_locations.location_port_name as from_location_name',
        'to_locations.location_port_name as to_location_name',
        'assign_trips.shipping_details as shipping_detail',
        'assign_trips.container_details as container_detail',
        'assign_trips.trip_start_date as trip_start_date',
        'assign_trips.expected_arrival_time as expected_arrival_time'
      );
       if (isset($request->device_id) && $request->device_id !='null') {
            $device_id = $request->device_id;
            if (!empty($device_id)) {
              $query = $query->where(function ($q) use ($device_id) {
                $q->where('tc_data_event.device_id', $device_id);
              });
            }
          }
  
          if (isset($request->trip_id) && $request->trip_id !='null') {
            $trip_id = $request->trip_id;
            if (!empty($trip_id)) {
              $query = $query->where(function ($q) use ($trip_id) {
                $q->where('tc_data_event.trip_id', $trip_id);
              });
            }
          }
       
          if (!empty($request->from_date)) {
                $query = $query->whereDate('tc_data_event.created_at', '>=', $request->from_date);
              }
          if (!empty($request->to_date)) {
                $query = $query->whereDate('tc_data_event.created_at', '<=', $request->to_date);
              }
       
        $events = $query->get();

    } 
          $spreadsheet = new Spreadsheet();
          $sheet = $spreadsheet->getActiveSheet();

          $fromDate = request()->from_date;
          $toDate = request()->to_date;

          $dateRange='';
          if(isset($fromDate) && $fromDate != null){
            $dateRange .= date('d-m-Y', strtotime($fromDate)) ;
          }
          if(isset($toDate) &&  $toDate != null){
            $dateRange .= ' To ' . date('d-m-Y', strtotime($toDate));
          } 
          $sheet->setCellValue('C1', 'Events Reports')->getStyle('C1')->getFont()->setBold(true);
  
          $sheet->setCellValue('A4', 'Device ID')->getStyle('A4')->getFont()->setBold(true);
          $sheet->setCellValue('A5', 'Trip ID')->getStyle('A5')->getFont()->setBold(true);
          $sheet->setCellValue('A6', 'From Date')->getStyle('A6')->getFont()->setBold(true);
          
       
          $sheet->setCellValue('B4', ($request->device_id !== 'null') ? $request->device_id :'');
          $sheet->getStyle('B4')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
          $sheet->setCellValue('B5', ($request->trip_id !== 'null') ? $request->trip_id : '');
          $sheet->setCellValue('B6', $dateRange);

          $sheet->getColumnDimension('A')->setWidth(10); 
          $sheet->getColumnDimension('B')->setWidth(22); 
          $sheet->getColumnDimension('C')->setWidth(20);        
  
          $sheet->setCellValue('A8', 'Sr No')->getStyle('A8')->getFont()->setBold(true);
          $sheet->setCellValue('B8', 'Trip ID')->getStyle('B8')->getFont()->setBold(true);
          $sheet->setCellValue('C8', 'Rf Id Card Number')->getStyle('C8')->getFont()->setBold(true);
          $sheet->setCellValue('D8', 'Events')->getStyle('D8')->getFont()->setBold(true);
          $sheet->setCellValue('E8', 'Cargo Type')->getStyle('E8')->getFont()->setBold(true);
          $sheet->setCellValue('F8', 'Shipment Type')->getStyle('F8')->getFont()->setBold(true);
          $sheet->setCellValue('G8', 'Location')->getStyle('G8')->getFont()->setBold(true);
          $sheet->setCellValue('H8', 'Current Address')->getStyle('H8')->getFont()->setBold(true);
          $sheet->setCellValue('I8', 'Latitude')->getStyle('I8')->getFont()->setBold(true);
          $sheet->setCellValue('J8', 'Longitude')->getStyle('J8')->getFont()->setBold(true);
          $sheet->setCellValue('K8', 'Driver Name')->getStyle('K8')->getFont()->setBold(true);
          $sheet->setCellValue('L8', 'Vehicle No')->getStyle('L8')->getFont()->setBold(true);
          $sheet->setCellValue('M8', 'Contact No')->getStyle('M8')->getFont()->setBold(true);
          $sheet->setCellValue('N8', 'Events Date')->getStyle('N8')->getFont()->setBold(true);
          $sheet->setCellValue('O8', 'Created Date')->getStyle('O8')->getFont()->setBold(true);

          $sheet->getStyle('A8:O8')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('c6efce');
          $sheet->getStyle('A8:O8')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

          $row = 9;
          foreach ($events as $i => $log) {
             
            
              $sheet->setCellValue('A' . $row, $i + 1 ?? '');
              $sheet->getStyle('A' . $row)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
              $sheet->setCellValue('B' . $row, $log->trip_id ?? '');
              $sheet->setCellValue('C' . $row, $log->rfid_card_number ?? '');
              $sheet->setCellValue('D' . $row, ($log->alert_title ?? '') . '/' . ($log->alert_naration ?? ''));
              $sheet->getStyle('D' . $row)->getAlignment()->setWrapText(true);

              $shipping_details = isset($log->shipping_detail) ? json_decode($log->shipping_detail, true) : null;
              $cargo_type = isset($shipping_details['cargo_type']) ? $shipping_details['cargo_type'] : '';
              $shipment_type = isset($shipping_details['shipment_type']) ? $shipping_details['shipment_type'] : '';

              $sheet->setCellValue('E' . $row, $cargo_type ?? '');
              $sheet->setCellValue('F' . $row, $shipment_type ?? '') ;

              $sheet->setCellValue('G' . $row, $log->from_location_name ?? ''. ' - ' .$log->to_location_name ?? '');
              $sheet->getStyle('G' . $row)->getAlignment()->setWrapText(true);

              $sheet->setCellValue('H' . $row, $log->address ?? '') ;
              $sheet->getStyle('H' . $row)->getAlignment()->setWrapText(true);

              $sheet->setCellValue('I' . $row, $log->latitude ?? '') ;
              $sheet->getStyle('I' . $row)->getAlignment()->setWrapText(true);

              $sheet->setCellValue('J' . $row, $log->longitude ?? '') ;
              $sheet->getStyle('J' . $row)->getAlignment()->setWrapText(true);

              $container_details = isset($log->container_detail) ? json_decode($log->container_detail, true) : null;
              $driver_name = isset($container_details['driver_name']) ? $container_details['driver_name'] : '';
              $vehicle_no = isset($container_details['vehicle_no']) ? $container_details['vehicle_no'] : '';
              $mobile_no = isset($container_details['mobile_no']) ? $container_details['mobile_no'] : '';

              $sheet->setCellValue('K' . $row, $driver_name);
              $sheet->getStyle('K' . $row)->getAlignment()->setWrapText(true);

              $sheet->setCellValue('L' . $row, $vehicle_no);
              $sheet->getStyle('L' . $row)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);

              $sheet->setCellValue('M' . $row, $mobile_no);
              $sheet->getStyle('M' . $row)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);

              $utcTimestamp = $log->time ?? '';
              if (!empty($utcTimestamp)) {
                  $utcDateTime = new DateTime($utcTimestamp, new DateTimeZone('UTC'));
                  $utcDateTime->setTimezone(new DateTimeZone('Asia/Kolkata'));
                  $istDateTime = $utcDateTime->format('d-m-Y H:i:s');
                  $sheet->setCellValue('N' . $row, $istDateTime);
              } else {
                  $sheet->setCellValue('N' . $row, '');
              }
              $sheet->setCellValue('O' . $row, date("d-m-Y H:i:s", strtotime($log->created_at))??'');

              

              $row++;
          }
          
          $sheet->getColumnDimension('D')->setWidth(30); 
          $sheet->getColumnDimension('E')->setWidth(15); 
          $sheet->getColumnDimension('F')->setWidth(18); 
          $sheet->getColumnDimension('G')->setWidth(20); 
          $sheet->getColumnDimension('H')->setWidth(20); 
          $sheet->getColumnDimension('I')->setWidth(20); 
          $sheet->getColumnDimension('J')->setWidth(15); 
          $sheet->getColumnDimension('K')->setWidth(15); 
          $sheet->getColumnDimension('L')->setWidth(20); 
          $sheet->getColumnDimension('M')->setWidth(20); 
          $sheet->getColumnDimension('N')->setWidth(20); 
          $sheet->getColumnDimension('O')->setWidth(20); 
          

          $writer = new Xlsx($spreadsheet);
          $filename = 'events_reports.xlsx';
  
          header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
          header('Content-Disposition: attachment;filename="' . $filename . '"');
          header('Cache-Control: max-age=0');
  
          $writer->save('php://output');
          exit;
  }

  public function pdf_events_report(Request $request){
    if (auth('admin')->user()->id) {
      $admin_id = auth('admin')->id();
      $role_id = auth('admin')->user()->role_id;
    } else {
      $admin_id = 0;
      $role_id = 0;
    }
    $device_id = ($request->device_id !== 'null') ? $request->device_id : '';
    $trip_id = ($request->trip_id !== 'null') ? $request->trip_id : '';
    
    $fromDate = request()->from_date;
    $toDate = request()->to_date;
    
    $dateRange='';
    if(isset($fromDate) && $fromDate != null){
      $dateRange .= date('d-m-Y', strtotime($fromDate)) ;
    }
    if(isset($toDate) &&  $toDate != null){
      $dateRange .= ' To ' . date('d-m-Y', strtotime($toDate));
    } 
    if (!empty($request->device_id) || !empty($request->trip_id) || !empty($request->from_date) || !empty($request->to_date)) {
      $query = DB::table('tc_data_event')
        ->Join('assign_trips', 'tc_data_event.trip_id', '=', 'assign_trips.trip_id')
        ->leftJoin('locations as from_locations', 'assign_trips.from_destination', '=', 'from_locations.id')
        ->leftJoin('locations as to_locations', 'assign_trips.to_destination', '=', 'to_locations.id')
        ->leftJoin('gps_devices as gd', 'assign_trips.gps_devices_id', '=', 'gd.id')
        ->where('command_word', '!=', '@JT')
        ->whereIn('event_source_type', ['1', '4','5'])
        ->where(function ($query) use ($role_id, $admin_id) {
          if ($role_id != 0) {
            $query->where('assign_trips.admin_id', '=', $admin_id);
          }
        });
      
      $query->select(
        'tc_data_event.*',
        'from_locations.location_port_name as from_location_name',
        'to_locations.location_port_name as to_location_name',
        'assign_trips.shipping_details as shipping_detail',
        'assign_trips.container_details as container_detail',
        'assign_trips.trip_start_date as trip_start_date',
        'assign_trips.expected_arrival_time as expected_arrival_time'
      );
     if (isset($request->device_id) && $request->device_id !='null') {
            $device_id = $request->device_id;
            if (!empty($device_id)) {
              $query = $query->where(function ($q) use ($device_id) {
                $q->where('tc_data_event.device_id', $device_id);
              });
            }
          }
  
          if (isset($request->trip_id) && $request->trip_id !='null') {
            $trip_id = $request->trip_id;
            if (!empty($trip_id)) {
              $query = $query->where(function ($q) use ($trip_id) {
                $q->where('tc_data_event.trip_id', $trip_id);
              });
            }
          }
       
          if (!empty($request->from_date)) {
                $query = $query->whereDate('assign_trips.trip_start_date', '>=', $request->from_date);
              }
          if (!empty($request->to_date)) {
                $query = $query->whereDate('assign_trips.trip_start_date', '<=', $request->to_date);
              }
          $events = $query->get();
    }
    $pdf = PDF::loadView('admin.report.events-reports-pdf', compact('events','dateRange','device_id','trip_id'));

    return $pdf->download('events_report.pdf');

          
  }

  public function alarm_reports(Request $request){
    if (auth('admin')->user()->id) {
      $admin_id = auth('admin')->id();
      $role_id = auth('admin')->user()->role_id;
    } else {
      $admin_id = 0;
      $role_id = 0;
    }
    $gpsdevices = GpsDevice::where('status', 'enable')->where(function ($query) use($role_id,$admin_id) {
      if($role_id != 0) {$query->where('gps_devices.admin_id', '=', $admin_id);
      }
    })->get(['id', 'device_id']);
    $trips = AssignTrip::where('status', 'enable')->where(function ($query) use($role_id,$admin_id) {
      if($role_id != 0) {$query->where('assign_trips.admin_id', '=', $admin_id);
      }
    })->get(['id', 'trip_id']);

    return view('admin.report.alarm-reports', compact('gpsdevices', 'trips'));
  }

  public function get_alrams_trip_details(Request $request){
    if (auth('admin')->user()->id) {
      $admin_id = auth('admin')->id();
      $role_id = auth('admin')->user()->role_id;
    } else {
      $admin_id = 0;
      $role_id = 0;
    }
    if (!empty($request->device_id) || !empty($request->trip_id) || !empty($request->from_date) || !empty($request->to_date)) {
      $search = $request->search['value'];
      $query = DB::table('tc_data_event')
        ->Join('assign_trips', 'tc_data_event.trip_id', '=', 'assign_trips.trip_id')
        ->leftJoin('locations as from_locations', 'assign_trips.from_destination', '=', 'from_locations.id')
        ->leftJoin('locations as to_locations', 'assign_trips.to_destination', '=', 'to_locations.id')
        ->leftJoin('gps_devices as gd', 'assign_trips.gps_devices_id', '=', 'gd.id')
        ->where('command_word', '!=', '@JT')
        ->whereIn('event_source_type', ['1', '2','3','7','8'])
        ->whereIn('unlock_verification', ['0', '1'])
        ->where(function ($query) use ($role_id, $admin_id) {
          if ($role_id != 0) {
            $query->where('assign_trips.admin_id', '=', $admin_id);
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
          $query->where('tc_data_event.device_id', 'like', '%' . $search . '%');
        });
      }
  
        if ($request->device_id) {
            $device_id = $request->device_id;
            $query = $query->where(function ($q) use ($device_id) {
                $q->where('tc_data_event.device_id', $device_id);
            });
        }

        if ($request->trip_id) {
            $trip_id = $request->trip_id;
            $query = $query->where(function ($q) use ($trip_id) {
                $q->where('tc_data_event.trip_id', $trip_id);
            });
        }
   
      if (!empty($request->from_date)) {
          $query = $query->whereDate('tc_data_event.created_at', '>=', $request->from_date);
      }

      if (!empty($request->to_date)) {
          $query = $query->whereDate('tc_data_event.created_at', '<=', $request->to_date);
      }

      $filteredRecords = $query->count();
      $alarm_trip = $query->skip(intval($request->start))->take(intval($request->length))->get();

      $alarms = array();
      foreach ($alarm_trip as $key => $value) {
        if (isset($value->shipping_detail)) {
          $shipping_details = json_decode($value->shipping_detail, true);
          $cargo_type = isset($shipping_details['cargo_type']) ? $shipping_details['cargo_type'] : '';
          $shipment_type = isset($shipping_details['shipment_type']) ? $shipping_details['shipment_type'] : '';
        } else {
          $cargo_type = '';
          $shipment_type = '';
        }


        if (isset($value->container_detail)) {
          $container_details = json_decode($value->container_detail, true);
          $driver_name = isset($container_details['driver_name']) ? $container_details['driver_name'] : '';
          $vehicle_no = isset($container_details['vehicle_no']) ? $container_details['vehicle_no'] : '';
          $mobile_no = isset($container_details['mobile_no']) ? $container_details['mobile_no'] : '';
        } else {
          $driver_name = '';
          $vehicle_no = '';
          $mobile_no = '';
        }
    
          $id = $key+1 ??'';
       
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
        if (isset($value->time)) {
          $utcDateTime = new DateTime($value->time, new DateTimeZone('UTC'));
      
          $utcDateTime->setTimezone(new DateTimeZone('Asia/Kolkata'));
      
          $time = $utcDateTime->format('d-m-Y H:i:s');
      } else {
          $time = '';
      }


      
        if (isset($value->created_at)) {
          $created_at = date("d-m-Y H:i:s", strtotime($value->created_at));
        } else {
          $created_at = '';
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

        if (isset($value->rfid_card_number)) {
          $rfid_card_number = $value->rfid_card_number;
        
        } else {
          $rfid_card_number = '';
        }

        if (isset($value->latitude)) {
          $latitude = $value->latitude;
        
        } else {
          $latitude = '';
        }

        if (isset($value->longitude)) {
          $longitude = $value->longitude;
        
        } else {
          $longitude = '';
        }

        

        $alarms[] = array(
          $id,
          $trip_id,
          $rfid_card_number,
          $alert_title . '/' . $alert_naration,
          $cargo_type,
          $shipment_type,
          $from_location_name . ' - ' . $to_location_name,
          $address,
          $latitude,
          $longitude,
          $driver_name,
          $vehicle_no,
          $mobile_no,
          $time, 
          $created_at
          
        );
      }
    } else {
      $totalRecords = 0;
      $filteredRecords = 0;
      $alarms = array();
    }
    $output = array(
      "draw" => $_POST['draw'],
      "recordsTotal" => $totalRecords,
      "recordsFiltered" => $filteredRecords,
      "data" => $alarms,
    );
    echo json_encode($output);
  }

  public function excel_alarm_report(Request $request){
    if (auth('admin')->user()->id) {
      $admin_id = auth('admin')->id();
      $role_id = auth('admin')->user()->role_id;
    } else {
      $admin_id = 0;
      $role_id = 0;
    }
    if (!empty($request->device_id) || !empty($request->trip_id) || !empty($request->from_date) || !empty($request->to_date)) {
      $query = DB::table('tc_data_event')
        ->Join('assign_trips', 'tc_data_event.trip_id', '=', 'assign_trips.trip_id')
        ->leftJoin('locations as from_locations', 'assign_trips.from_destination', '=', 'from_locations.id')
        ->leftJoin('locations as to_locations', 'assign_trips.to_destination', '=', 'to_locations.id')
        ->leftJoin('gps_devices as gd', 'assign_trips.gps_devices_id', '=', 'gd.id')
        ->where('command_word', '!=', '@JT')
        ->whereIn('event_source_type', ['1', '2','3','7','8'])
        ->whereIn('unlock_verification', ['0', '1'])
        ->where(function ($query) use ($role_id, $admin_id) {
          if ($role_id != 0) {
            $query->where('assign_trips.admin_id', '=', $admin_id);
          }
        });
      
      $query->select(
        'tc_data_event.*',
        'from_locations.location_port_name as from_location_name',
        'to_locations.location_port_name as to_location_name',
        'assign_trips.shipping_details as shipping_detail',
        'assign_trips.container_details as container_detail',
        'assign_trips.trip_start_date as trip_start_date',
        'assign_trips.expected_arrival_time as expected_arrival_time'
      );
   
          if (isset($request->device_id) && $request->device_id !='null') {
            $device_id = $request->device_id;
            if (!empty($device_id)) {
              $query = $query->where(function ($q) use ($device_id) {
                $q->where('tc_data_event.device_id', $device_id);
              });
            }
          }
  
          if (isset($request->trip_id) && $request->trip_id !='null') {
            $trip_id = $request->trip_id;
            if (!empty($trip_id)) {
              $query = $query->where(function ($q) use ($trip_id) {
                $q->where('tc_data_event.trip_id', $trip_id);
              });
            }
          }
       
          if (!empty($request->from_date)) {
                $query = $query->whereDate('tc_data_event.created_at', '>=', $request->from_date);
              }
          if (!empty($request->to_date)) {
                $query = $query->whereDate('tc_data_event.created_at', '<=', $request->to_date);
              }
      
        $alarms = $query->get();

    }
          $spreadsheet = new Spreadsheet();
          $sheet = $spreadsheet->getActiveSheet();
  
          $fromDate = request()->from_date;
          $toDate = request()->to_date;
          
          $dateRange='';
          if(isset($fromDate) && $fromDate != null){
            $dateRange .= date('d-m-Y', strtotime($fromDate)) ;
          }
          if(isset($toDate) &&  $toDate != null){
            $dateRange .= ' To ' . date('d-m-Y', strtotime($toDate));
          }       
          $sheet->setCellValue('C1', 'Alarms Reports')->getStyle('C1')->getFont()->setBold(true);
  
          $sheet->setCellValue('A4', 'Device ID')->getStyle('A4')->getFont()->setBold(true);
          $sheet->setCellValue('A5', 'Trip ID')->getStyle('A5')->getFont()->setBold(true);
          $sheet->setCellValue('A6', 'From Date')->getStyle('A6')->getFont()->setBold(true);
          
       
          $sheet->setCellValue('B4', ($request->device_id !== 'null') ? $request->device_id :'');
          $sheet->getStyle('B4')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
          $sheet->setCellValue('B5', ($request->trip_id !== 'null') ? $request->trip_id : '');
          $sheet->setCellValue('B6', $dateRange);

          $sheet->getColumnDimension('A')->setWidth(10); 
          $sheet->getColumnDimension('B')->setWidth(16); 
          $sheet->getColumnDimension('C')->setWidth(20);        
  
          $sheet->setCellValue('A8', 'Sr No')->getStyle('A8')->getFont()->setBold(true);
          $sheet->setCellValue('B8', 'Trip ID')->getStyle('B8')->getFont()->setBold(true);
          $sheet->setCellValue('C8', 'Rf Id Card Number')->getStyle('C8')->getFont()->setBold(true);
          $sheet->setCellValue('D8', 'Alarm Title')->getStyle('D8')->getFont()->setBold(true);
          $sheet->setCellValue('E8', 'Cargo Type')->getStyle('E8')->getFont()->setBold(true);
          $sheet->setCellValue('F8', 'Shipment Type')->getStyle('F8')->getFont()->setBold(true);
          $sheet->setCellValue('G8', 'Location')->getStyle('G8')->getFont()->setBold(true);
          $sheet->setCellValue('H8', 'Current Address')->getStyle('H8')->getFont()->setBold(true);
          $sheet->setCellValue('I8', 'Latitude')->getStyle('I8')->getFont()->setBold(true);
          $sheet->setCellValue('J8', 'Longitude')->getStyle('J8')->getFont()->setBold(true);
          $sheet->setCellValue('K8', 'Driver Name')->getStyle('K8')->getFont()->setBold(true);
          $sheet->setCellValue('L8', 'Vehicle No')->getStyle('L8')->getFont()->setBold(true);
          $sheet->setCellValue('M8', 'Contact No')->getStyle('M8')->getFont()->setBold(true);
          $sheet->setCellValue('N8', 'Alarm Date')->getStyle('N8')->getFont()->setBold(true);
          $sheet->setCellValue('O8', 'Created Date')->getStyle('O8')->getFont()->setBold(true);

          $sheet->getStyle('A8:O8')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('c6efce');
          $sheet->getStyle('A8:O8')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

          $row = 9;
          foreach ($alarms as $i => $log) {
              $sheet->setCellValue('A' . $row, $i + 1 ?? '');
              $sheet->getStyle('A' . $row)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
              $sheet->setCellValue('B' . $row, $log->trip_id ?? '');
              $sheet->setCellValue('C' . $row, $log->rfid_card_number?? '');
              $sheet->setCellValue('D' . $row, ($log->alert_title ?? '') . '/' . ($log->alert_naration ?? ''));
              $sheet->getStyle('D' . $row)->getAlignment()->setWrapText(true);

              $shipping_details = isset($log->shipping_detail) ? json_decode($log->shipping_detail, true) : null;
              $cargo_type = isset($shipping_details['cargo_type']) ? $shipping_details['cargo_type'] : '';
              $shipment_type = isset($shipping_details['shipment_type']) ? $shipping_details['shipment_type'] : '';


              $container_details = isset($log->container_detail) ? json_decode($log->container_detail, true) : null;
              $driver_name = isset($container_details['driver_name']) ? $container_details['driver_name'] : '';
              $vehicle_no = isset($container_details['vehicle_no']) ? $container_details['vehicle_no'] : '';
              $mobile_no = isset($container_details['mobile_no']) ? $container_details['mobile_no'] : '';



              $sheet->setCellValue('E' . $row, $cargo_type ?? '');
              $sheet->setCellValue('F' . $row, $shipment_type ?? '') ;
              $sheet->setCellValue('G' . $row, $log->from_location_name ?? ''. ' - ' .$log->to_location_name ?? '');
              $sheet->getStyle('G' . $row)->getAlignment()->setWrapText(true);

              $sheet->setCellValue('H' . $row, $log->address ?? '');
              $sheet->getStyle('H' . $row)->getAlignment()->setWrapText(true);

              $sheet->setCellValue('I' . $row, $log->latitude ?? '');
              $sheet->getStyle('I' . $row)->getAlignment()->setWrapText(true);

              $sheet->setCellValue('J' . $row, $log->longitude ?? '');
              $sheet->getStyle('J' . $row)->getAlignment()->setWrapText(true);


              $sheet->setCellValue('K' . $row, $driver_name);
              $sheet->getStyle('K' . $row)->getAlignment()->setWrapText(true);

              $sheet->setCellValue('L' . $row, $vehicle_no);
              $sheet->getStyle('L' . $row)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);

              $sheet->setCellValue('M' . $row, $mobile_no);
              $sheet->getStyle('M' . $row)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);

              $utcTimestamp = $log->time ?? '';

              if (!empty($utcTimestamp)) {
                $utcDateTime = new DateTime($utcTimestamp, new DateTimeZone('UTC'));
                $utcDateTime->setTimezone(new DateTimeZone('Asia/Kolkata'));
                $istDateTime = $utcDateTime->format('d-m-Y H:i:s');
                $sheet->setCellValue('N' . $row, $istDateTime);
              } else {
                $sheet->setCellValue('N' . $row, '');
              }
            $sheet->setCellValue('O' . $row, date("d-m-Y H:i:s", strtotime($log->created_at))??'');
            $row++;
          }
          
          $sheet->getColumnDimension('D')->setWidth(30); 
          $sheet->getColumnDimension('E')->setWidth(15); 
          $sheet->getColumnDimension('F')->setWidth(20); 
          $sheet->getColumnDimension('G')->setWidth(25); 
          $sheet->getColumnDimension('H')->setWidth(30); 
          $sheet->getColumnDimension('I')->setWidth(20); 
          $sheet->getColumnDimension('J')->setWidth(15); 
          $sheet->getColumnDimension('K')->setWidth(18); 
          $sheet->getColumnDimension('L')->setWidth(18); 
          $sheet->getColumnDimension('M')->setWidth(18);
          $sheet->getColumnDimension('N')->setWidth(18);  
          $sheet->getColumnDimension('O')->setWidth(18);  

          $writer = new Xlsx($spreadsheet);
          $filename = 'alarms_reports.xlsx';
  
          header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
          header('Content-Disposition: attachment;filename="' . $filename . '"');
          header('Cache-Control: max-age=0');
  
          $writer->save('php://output');
          exit;
  }

  public function pdf_alarm_report(Request $request){
    if (auth('admin')->user()->id) {
      $admin_id = auth('admin')->id();
      $role_id = auth('admin')->user()->role_id;
    } else {
      $admin_id = 0;
      $role_id = 0;
    }
    $device_id = ($request->device_id !== 'null') ? $request->device_id : '';
    $trip_id = ($request->trip_id !== 'null') ? $request->trip_id : '';
    $fromDate = request()->from_date;
    $toDate = request()->to_date;
    
    $dateRange='';
          if(isset($fromDate) && $fromDate != null){
            $dateRange .= date('d-m-Y', strtotime($fromDate)) ;
          }
          if(isset($toDate) &&  $toDate != null){
            $dateRange .= ' To ' . date('d-m-Y', strtotime($toDate));
          } 
    if (!empty($request->device_id) || !empty($request->trip_id) || !empty($request->from_date) || !empty($request->to_date)) {
      $query = DB::table('tc_data_event')
        ->Join('assign_trips', 'tc_data_event.trip_id', '=', 'assign_trips.trip_id')
        ->leftJoin('locations as from_locations', 'assign_trips.from_destination', '=', 'from_locations.id')
        ->leftJoin('locations as to_locations', 'assign_trips.to_destination', '=', 'to_locations.id')
        ->leftJoin('gps_devices as gd', 'assign_trips.gps_devices_id', '=', 'gd.id')
        ->where('command_word', '!=', '@JT')
        ->whereIn('event_source_type', ['1', '2','3','7','8'])
        ->whereIn('unlock_verification', ['0', '1'])
        ->where(function ($query) use ($role_id, $admin_id) {
          if ($role_id != 0) {
            $query->where('assign_trips.admin_id', '=', $admin_id);
          }
        });
      
      $query->select(
        'tc_data_event.*',
        'from_locations.location_port_name as from_location_name',
        'to_locations.location_port_name as to_location_name',
        'assign_trips.shipping_details as shipping_detail',
        'assign_trips.container_details as container_detail',
        'assign_trips.trip_start_date as trip_start_date',
        'assign_trips.expected_arrival_time as expected_arrival_time'
      );
      if (isset($request->device_id) && $request->device_id !='null') {
            $device_id = $request->device_id;
            if (!empty($device_id)) {
              $query = $query->where(function ($q) use ($device_id) {
                $q->where('tc_data_event.device_id', $device_id);
              });
            }
          }
  
          if (isset($request->trip_id) && $request->trip_id !='null') {
            $trip_id = $request->trip_id;
            if (!empty($trip_id)) {
              $query = $query->where(function ($q) use ($trip_id) {
                $q->where('tc_data_event.trip_id', $trip_id);
              });
            }
          }
       
          if (!empty($request->from_date)) {
                $query = $query->whereDate('assign_trips.trip_start_date', '>=', $request->from_date);
              }
          if (!empty($request->to_date)) {
                $query = $query->whereDate('assign_trips.trip_start_date', '<=', $request->to_date);
              }
          $alarms = $query->get();
    }
    $pdf = PDF::loadView('admin.report.alarm-reports-pdf', compact('alarms','dateRange','device_id','trip_id'));

    return $pdf->download('alarm_report.pdf');

          
  }
  
  public function get_device_per_trip(Request $request){
    $device_id = $request->device_id;
    $assign_trips = AssignTrip::join('gps_devices as gd', 'assign_trips.gps_devices_id', '=', 'gd.id')
    ->where('gd.device_id', $device_id)->get();
    $trips = array();
    $trips['trips']=$assign_trips;
    echo json_encode($trips);
  }

  protected function tripData($scope){

    if (auth('admin')->user()->id) {
      $admin_id = auth('admin')->id();
      $role_id = auth('admin')->user()->role_id;
    } else {
      $admin_id = 0;
      $role_id = 0;
    }
    $query = AssignTrip::query();
    $request = request();
    if ($request->search || $request->from_date || $request->to_date) {
      if ($request->search) {
        $search = $request->search;
        $query = $query->where(function ($q) use ($search) {
          $q->where('trip_id', $search);
        });
      } else {
        if ($request->from_date) {
          $query = $query->whereDate('assign_trips.trip_start_date', '>=', $request->from_date);
        }
        if ($request->to_date) {
          $query = $query->whereDate('assign_trips.trip_start_date', '<=', $request->to_date);
        }
      }
      if ($role_id != 0) {
        $query->where('assign_trips.admin_id', '=', $admin_id);
      }

      return $query->select('gd.device_id', 'assign_trips.*', 'from_locations.location_port_name as from_location_name', 'to_locations.location_port_name as to_location_name')
        ->join('locations as from_locations', 'assign_trips.from_destination', '=', 'from_locations.id')
        ->join('locations as to_locations', 'assign_trips.to_destination', '=', 'to_locations.id')
        ->join('gps_devices as gd', 'assign_trips.gps_devices_id', '=', 'gd.id')
        ->orderBy('assign_trips.created_at', 'asc');
    } else {
      return $query;
    }
  }

   public function reply_trips(Request $request) {

      $trip_id = $request->trip_id ?? '';
      $assign_trip = AssignTrip::select('assign_trips.*', 'admins.gst_no as gstno','from_locations.location_port_name as from_location_name',
      'to_locations.location_port_name as to_location_name','gd.device_id')
      ->join('locations as from_locations', 'assign_trips.from_destination', '=', 'from_locations.id')
      ->join('locations as to_locations', 'assign_trips.to_destination', '=', 'to_locations.id')
      ->join('gps_devices as gd', 'assign_trips.gps_devices_id', '=', 'gd.id')
      ->join('admins', 'assign_trips.admin_id', '=', 'admins.id')
      ->where('trip_id',$trip_id)->first();

     

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
            //   DB::enableQueryLog();

              $trip_complete_position = DB::table('tc_positions')
              ->whereNotNull('address')->where('devicetime', '>=', $first_ins_location_time)
              ->where('devicetime', '<=', $last_ins_location_time)
              ->orderBy('id', 'asc')
              ->where('deviceid',$deviceid)
              ->groupBy('latitude', 'longitude')
              ->get();
            // dd(DB::getQueryLog());

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
  
     // $g_map_data = $this->get_device_data($id);

      $data = array();
      $data['trip_complete_data'] = $trip_complete_data;
      echo json_encode($data);
    }


  

}
