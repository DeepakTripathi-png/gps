<?php

namespace App\Http\Controllers\Admin;
use App\Models\Role;
use App\Models\Admin;
use App\Models\Location;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class LocationController extends Controller
{
    public function add_location() {

      if (auth('admin')->user()->id) {
        $admin_id = auth('admin')->id();
        $role_id = auth('admin')->user()->role_id;
    } else {
        $admin_id = 0;
        $role_id = 0;
    }
      $pagetitle ="Add Location";
      $query = Location::join('admins', function ($join) {
        $join->on(DB::raw('FIND_IN_SET(admins.id, locations.admin_id)'), '>', DB::raw('0'));
      })
      ->join('roles', function ($join) {
        $join->on(DB::raw('FIND_IN_SET(roles.id, admins.role_id)'), '>', DB::raw('0'));
      })
      ->where('roles.id', '=', '4')
      ->groupBy('locations.id')
      ->select('locations.*', DB::raw('GROUP_CONCAT(admins.name) AS customer_name'));
      if ($role_id != 0) {
        $query->where('locations.created_by', '=', $admin_id);
    }
      $locations = $query->get();

      foreach($locations as $key => $value) {
        $customs_admin_id  = $value->customs_admin_id ?? '';
        $location_id  = $value->id ?? '';
        $response = $this->get_customs_user_name($location_id, $customs_admin_id);
        $value->customs_name = $response->customs_name ?? '';
      }
      // ->get();

    $query = Admin::join('roles', 'admins.role_id', '=', 'roles.id')
    ->where('roles.id', '=', '4')
    ->select('admins.*', 'admins.id as cid','roles.id as rid');
    if ($role_id != 0) {
      $query->where('admins.created_by', '=', $admin_id);
    }
    $customersWithRole = $query->get();

    $query1 = Admin::join('roles', 'admins.role_id', '=', 'roles.id')
    ->where('roles.id', '=', '5')
    ->select('admins.*', 'admins.id as cid','roles.id as rid');
    if ($role_id != 0) {
      $query1->where('admins.created_by', '=', $admin_id);
    }
    $customersWithRoleCustoms = $query1->get();
    $isEditMode = false;

      return view('admin.customer.add-location',compact('pagetitle','customersWithRole','locations','customersWithRoleCustoms','isEditMode'));
    }
  
        public function save_location(Request $request,$id=0)
        {
            $validator = Validator::make($request->all(), [
              'location_port_id' => 'required',
              'location_port_name' => 'required',
              'location_address' => 'required',
              'location_lat' => 'required',
              'location_long' => 'required',
              'location_type' => 'required',
              'customer_id' => 'required',
            ], [
              'customer_id.required' => 'The Authorized Person is required.',
            ]);
            
          
            if ($validator->fails()) {
              return redirect()->back()->withErrors($validator)->withInput();
            }
            if (auth('admin')->user()->id){
              $admin_id = auth('admin')->id();
            } else {
              $admin_id = 0;
            }
            $customer_ids = $request->customer_id ?? [];
            $customer_ids[] = $admin_id;
            $imploded_string = implode(',', $customer_ids);


            $custom_office_ids = $request->custom_office_id ?? [];
           // $custom_office_ids[] = $admin_id;
            $imploded_string_custom = implode(',', $custom_office_ids);

            if ($id) {
            $locations         = Location::findOrFail($id);
            $notification     = 'Location Updated Successfully';
            } else {
                $locations         = new Location();
                $notification     = 'Location Added Successfully';
            } 
          $locations->location_port_id   = $request->location_port_id;
          $locations->location_port_name = $request->location_port_name;
          $locations->location_address   = $request->location_address;
          $locations->location_lat       = $request->location_lat;
          $locations->location_long      = $request->location_long;
          $locations->location_type      = $request->location_type;
          $locations->admin_id           = $imploded_string ?? '';
          $locations->customs_admin_id   = $imploded_string_custom ?? '';
          $locations->created_by         = $admin_id;
          $locations->updated_by         = $admin_id;
          
          $locations->save();
          
          $notify[] = ['success', $notification];
          return redirect()->route('admin.locations.add-location')->withNotify($notify);
    }

    public function get_customs_user_name($location_id, $customs_admin_id) {
      
      $query = Location::join('admins', function ($join) {
        $join->on(DB::raw('FIND_IN_SET(admins.id, locations.customs_admin_id)'), '>', DB::raw('0'));
      })
      ->join('roles', function ($join) {
          $join->on(DB::raw('FIND_IN_SET(roles.id, admins.role_id)'), '>', DB::raw('0'));
      })
      ->select('locations.*', DB::raw('GROUP_CONCAT(admins.name) AS customs_name'));
      $locations = $query->find($location_id);

      return $locations;
    }
      
      public function edit_location($id) {

      if (auth('admin')->user()->id) {
        $admin_id = auth('admin')->id();
        $role_id = auth('admin')->user()->role_id;
      } else {
        $admin_id = 0;
        $role_id  = 0;
      }

      $pagetitle = "Edit Location";
      $query = Location::join('admins', function ($join) {
        $join->on(DB::raw('FIND_IN_SET(admins.id, locations.admin_id)'), '>', DB::raw('0'));
      })
      ->join('roles', function ($join) {
          $join->on(DB::raw('FIND_IN_SET(roles.id, admins.role_id)'), '>', DB::raw('0'));
      })
      ->where('roles.id', '=', '4')
      ->groupBy('locations.id')
      ->select('locations.*', DB::raw('GROUP_CONCAT(admins.name) AS customer_name'));
      if ($role_id != 0) {
        $query->where('locations.created_by', '=', $admin_id);
      }
      $locations = $query->get();

      foreach($locations as $key => $value) {
        $customs_admin_id  = $value->customs_admin_id ?? '';
        $location_id  = $value->id ?? '';
        $response = $this->get_customs_user_name($location_id, $customs_admin_id);
        $value->customs_name = $response->customs_name ?? '';
      }

        // echo "<pre>";
        // print_r($locations);die;
  
        $query = Admin::join('roles', 'admins.role_id', '=', 'roles.id')
        ->where('roles.id', '=', '4')
        ->select('admins.*', 'admins.id as cid','roles.id as rid');
           if ($role_id != 0) {
          $query->where('admins.created_by', '=', $admin_id);
      }
      $customersWithRole = $query->get();
      $location = Location::find($id);


      $query1 = Admin::join('roles', 'admins.role_id', '=', 'roles.id')
      ->where('roles.id', '=', '5')
      ->select('admins.*', 'admins.id as cid','roles.id as rid');
      if ($role_id != 0) {
        $query1->where('admins.created_by', '=', $admin_id);
      }
      $customersWithRoleCustoms = $query1->get();
      $isEditMode = true;
         
      return view('admin.customer.add-location',compact('pagetitle','customersWithRole','locations','location','customersWithRoleCustoms','isEditMode'));
    }
  
      public function update_location(Request $request, $id) {
        $validator = Validator::make($request->all(), [
          'location_port_id' => 'required',
          'location_port_name' => 'required',
          'location_address' => 'required',
          'location_lat' => 'required',
          'location_long' => 'required',
          'location_type' => 'required',
          'customer_id' => 'required',
        ], [
          'customer_id.required' => 'The Authorized Person is required.',
        ]);
      if ($validator->fails()) {
          return redirect()->back()->withErrors($validator)->withInput();
      }
      if (auth('admin')->user()->id){
        $admin_id = auth('admin')->id();
      } else {
        $admin_id = 0;
      }
      //$imploded_string = implode(',', $request->customer_id ?? '');

      $customer_ids = $request->customer_id ?? [];
      $customer_ids[] = $admin_id;
      $imploded_string = implode(',', $customer_ids);

      $custom_office_ids = $request->custom_office_id ?? [];
     // $custom_office_ids[] = $admin_id;
      $imploded_string_custom = implode(',', $custom_office_ids);



      $locations = Location::find($id);
      $locations->location_port_id   = $request->location_port_id;
      $locations->location_port_name = $request->location_port_name;
      $locations->location_address   = $request->location_address;
      $locations->location_lat       = $request->location_lat;
      $locations->location_long      = $request->location_long;
      $locations->location_type      = $request->location_type;
      $locations->admin_id           = $imploded_string ?? '';
      $locations->customs_admin_id   = $imploded_string_custom ?? '';
      $locations->updated_by         = $admin_id;
      
      $locations->save();
      $notify[] = ['success', 'Location updated successfully'];
      return redirect()->route('admin.locations.add-location')->withNotify($notify);
  }
  
     public function status_location($id) {
      $locations     = Location::find($id);
      if ($locations) {
          if ($locations->status =='enable') {
            $locations->status = 'disable';
            $notification     = 'Location Status Disable successfully';
  
          } 
        elseif ($locations->status =='disable') {
            $locations->status = 'enable';
            $notification     = 'Location Status Enable successfully';
  
          } 
      }
      $locations->save();
      $notify[] = ['success', $notification];
      return back()->withNotify($notify);
    }
}
