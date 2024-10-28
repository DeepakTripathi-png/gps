<?php

namespace App\Http\Controllers\Admin;
use App\Constants\Status;
use App\Models\Role;
use App\Models\Admin;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Mail\MyMail;
use App\Mail\CustomerMail;

use Illuminate\Support\Facades\Mail;
class CustomerController extends Controller
{
    public function add_customer(){
        $pagetitle = "Add Customer";
        $customers = Admin::join('roles', 'admins.role_id', '=', 'roles.id')
        ->where('roles.name', '=', 'Customer')
        ->select('admins.*')
        ->get();
        $roles = Role::where('id', '<>', 5)->get(['id', 'name']);
        return view('admin.customer.add-customer',compact('pagetitle','roles','customers'));
     }
     public function save_customer(Request $request,$id=0)
     {
        $validator = Validator::make($request->all(), [
          'customer_name' => 'required',
          'customer_email' => 'required|email',
          'customer_mobileno' => 'required|digits:10',
          'role_id' => 'required',
          'related_company' => 'required',
          'gst_no' => 'required',
          'username' => 'required|unique:admins,username', 
          // 'password' => 'required|confirm_password|min:8',
          'password' => 'min:6|required_with:confirm_password|same:confirm_password',
          // 'password_confirmation' => 'min:6'
          'start_date' => 'required|date', 
          'date_of_expiry' => 'required|date|after:start_date',
          'address' => 'required',
          'license_number' => 'required',
          'description' => 'required',
        ], [
          'username.unique' => 'The username already exists. Please choose a different username.',
          'password.confirmed' => 'The password confirmation does not match.',

      ]);
        if ($validator->fails()) {
          return redirect()->back()->withErrors($validator)->withInput();
        }
       
        if ($id) {
         $customers         = Admin::findOrFail($id);
         $notification     = 'Customer updated successfully';
        } else {
            $customers         = new Admin();
            $notification     = 'Customer added successfully';
        } 
       
      $password = $request->password ? Hash::make($request->password) : $customers->password;

       $customers->role_id = $request->role_id;
       $customers->name = $request->customer_name;
       $customers->email = $request->customer_email;
       $customers->secondary_email = $request->secondary_email;
       $customers->mobile_no = $request->customer_mobileno;
       $customers->related_company = $request->related_company;
       $customers->gst_no = $request->gst_no;
       $customers->username = $request->username;
       $customers->password    = $password;
       $customers->start_date = $request->start_date;
       $customers->date_of_expiry = $request->date_of_expiry;
       $customers->address = $request->address;
       $customers->license_number = $request->license_number;
       $customers->description = $request->description;
       $customers->save();

      if($request->customer_email) {
        $mail_data = array(
          'customer_name' =>$request->customer_name ?? '',
          'username' => $request->username ?? '',
          'password' => $request->password ?? '',
        );

        try {

          Mail::to($request->customer_email ?? '')->send(new CustomerMail($mail_data));
          
          if(!empty($request->secondary_email) && isset($request->secondary_email)) {
            Mail::to($request->secondary_email ?? '')->send(new CustomerMail($mail_data));
          }

        } catch (\Throwable $th) {
        //   throw $th;
        }
       
      }

       $notify[] = ['success', $notification];
       return redirect()->route('admin.customers.add-customer')->withNotify($notify);
     }
  
     public function edit_customer($id) {
      $pagetitle = "Edit Customer";
      $roles = Role::get(['id', 'name']);
      $customers = Admin::join('roles', 'admins.role_id', '=', 'roles.id')
      ->where('roles.name', '=', 'Customer')
      ->select('admins.*')
      ->get();
      $customer = Admin::find($id);
      return view('admin.customer.add-customer', compact('pagetitle','roles','customers','customer'));
  }
  
  public function update_customer(Request $request, $id) {
        $validator = Validator::make($request->all(), [
          'customer_name' => 'required',
          'customer_mobileno' => 'required|digits:10',
          'customer_email' => 'required|email',
          'role_id' => 'nullable',
          'related_company' => 'nullable',
          'gst_no' => 'required',
          'start_date' => 'required|date', 
          'expiry_date' => 'nullable',
          'date_of_expiry' => 'required|date|after:start_date',
          'address' => 'nullable',
          'license_number' => 'nullable',
          'description' => 'nullable',
      ]);
  
      if ($validator->fails()) {
          return redirect()->back()->withErrors($validator)->withInput();
      }
      
      $customers = Admin::find($id);
      $customers->name = $request->customer_name;
      $customers->mobile_no = $request->customer_mobileno;
      $customers->email = $request->customer_email;
      $customers->secondary_email = $request->secondary_email;
      $customers->role_id = $request->role_id;
      $customers->related_company = $request->related_company;
      $customers->gst_no = $request->gst_no;
      $customers->username = $request->username;
      $customers->start_date = $request->start_date;
      $customers->date_of_expiry = $request->date_of_expiry;
      $customers->address = $request->address;
      $customers->license_number = $request->license_number;
      $customers->description = $request->description;
      $customers->save();

     
      // if($request->customer_email) {
      //   $mail_data = array(
      //     'customer_name' =>$request->customer_name ?? '',
      //     'username' =>$request->username ?? '',
      //     'password' =>$request->password ?? '',
      //   );
      //   Mail::to($request->customer_email ?? '')->send(new CustomerMail($mail_data));
      // }

  
      $notify[] = ['success','Customer updated successfully'];
      return redirect()->route('admin.customers.add-customer')->withNotify($notify);
  }
  
    public function status_customer($custId) {
      $customers     = Admin::find($custId);

      if ($customers) {
          if ($customers->status =='1') {
            $customers->status = '0';
            $notification     = 'Customers Status Disable successfully';
  
          } 
        elseif ($customers->status =='0') {
            $customers->status = '1';
            $notification     = 'Customers Status Enable successfully';
          } 
      }
      $customers->save();
      $notify[] = ['success',  $notification];
      return back()->withNotify($notify);
    }


    public function add_customer_user(){
      if (auth('admin')->user()->id) {
        $admin_id = auth('admin')->id();
        $role_id = auth('admin')->user()->role_id;
    } else {
        $admin_id = 0;
        $role_id = 0;
    }
      $pageTitle = "Add Port/Customs Officer User";
      $query = Admin::join('roles', 'admins.role_id', '=', 'roles.id')
      ->where('roles.id', '=', '4');
      if ($role_id == 0 || $role_id == 3) {
        $query->orWhere('roles.id', '=', '5');
      }
      $query->select('admins.*','roles.name as role_name');

      if ($role_id != 0) {
        $query->where('admins.created_by', '=', $admin_id);
      }
      $customers = $query->get();
      
      // $roles = Role::where('id', '=', '4')->orWhere('roles.id', '=', '5')->get(['id', 'name']);
      $query1 = Role::where('id', '=', '4');
        if ($role_id == 0 || $role_id == 3) {
            $query1->orWhere('roles.id', '=', '5');
        }
        $roles = $query1->get(['id', 'name']);

      return view('admin.customer.add-customer-user',compact('pageTitle','roles','customers'));
   }

   public function save_customer_user(Request $request,$id=0)
   {
      $validator = Validator::make($request->all(), [
        'customer_name' => 'required',
        'customer_email' => 'required|email',
        'customer_mobileno' => 'required|digits:10',
        'role_id' => 'required',
        'username' => 'required|unique:admins,username', 
        'password' => 'min:6|required_with:confirm_password|same:confirm_password',
      ], [
        'username.unique' => 'The username already exists. Please choose a different username.',
        'password.confirmed' => 'The password confirmation does not match.',
        'password' => 'The password and confirm password must be match.',

    ]);
      if ($validator->fails()) {
        return redirect()->back()->withErrors($validator)->withInput();
      }
      if (auth('admin')->user()->id){
        $admin_id = auth('admin')->id();
      } else {
        $admin_id = 0;
      }

      if ($id) {
       $customers         = Admin::findOrFail($id);
       $notification      = 'Port user updated successfully';
      } else {
          $customers     = new Admin();
          $notification  = 'Port user added successfully';
      } 
     

     $customers->role_id = $request->role_id;
     $customers->name = $request->customer_name;
     $customers->email = $request->customer_email;
     $customers->secondary_email = $request->secondary_email;
     $customers->mobile_no = $request->customer_mobileno;
     $customers->username = $request->username;
     $customers->password    = $request->password ? Hash::make($request->password) : $customers->password;
     $customers->created_by  = $admin_id;
     $customers->save();



     try {

      $mail_data = array(
        'customer_name' =>$request->customer_name ?? '',
        'username' => $request->username ?? '',
        'password' => $request->password ?? '',
      );

      Mail::to($request->customer_email ?? '')->send(new CustomerMail($mail_data));
      
      if(!empty($request->secondary_email) && isset($request->secondary_email)) {
        Mail::to($request->secondary_email ?? '')->send(new CustomerMail($mail_data));
      }

    } catch (\Throwable $th) {
    //   throw $th;
    }

     $notify[] = ['success', $notification];
     return redirect()->route('admin.customers.add-customer-user')->withNotify($notify);
   }


   
   public function edit_customer_user($id) {
    if (auth('admin')->user()->id) {
      $admin_id = auth('admin')->id();
      $role_id = auth('admin')->user()->role_id;
  } else {
      $admin_id = 0;
      $role_id = 0;
  }
    $pageTitle = "Edit Port User";
    $roles = Role::get(['id', 'name']);
    $query = Admin::join('roles', 'admins.role_id', '=', 'roles.id')
      ->where('roles.name', '=', 'Port User')
      ->select('admins.*');
      if ($role_id != 0) {
        $query->where('admins.created_by', '=', $admin_id);
    }
      $customers = $query->get();
    $customer = Admin::find($id);
    return view('admin.customer.add-customer-user', compact('pageTitle','roles','customers','customer'));
}

public function update_customer_user(Request $request, $id) {
    $validator = Validator::make($request->all(), [
      'customer_name' => 'required',
      'customer_email' => 'required|email',
      'customer_mobileno' => 'required|digits:10',
      'role_id' => 'required',
      'username' => 'required', 
   
  ]);

    if ($validator->fails()) {
        return redirect()->back()->withErrors($validator)->withInput();
    }
    
    $customers = Admin::find($id);
    $customers->name = $request->customer_name;
    $customers->mobile_no = $request->customer_mobileno;
    $customers->email = $request->customer_email;
    $customers->secondary_email = $request->secondary_email;
    $customers->role_id = $request->role_id;
    $customers->username = $request->username;
    $customers->save();

    $notify[] = ['success','User updated successfully'];
    return redirect()->route('admin.customers.add-customer-user')->withNotify($notify);
}
public function status_customer_user ($custId) {
  $customers     = Admin::find($custId);

  if ($customers) {
      if ($customers->status =='1') {
        $customers->status = '0';
        $notification     = 'User Status Disable successfully';

      } 
    elseif ($customers->status =='0') {
        $customers->status = '1';
        $notification     = ' User Status Enable successfully';
      } 
  }
  $customers->save();
  $notify[] = ['success',  $notification];
  return back()->withNotify($notify);
}

public function send_emails() {
  $data = ['name' => 'John Doe']; 
  $mail = Mail::to('arokade22@gmail.com')->send(new MyMail($data));
}

public function customer_confirm_emails() {
 
  $data =    $mail_data = array(
      'customer_name' =>'Test',
      'username' => 'test@12344',
      'password' => 'daasxasadswwawfawf',
    );

    $mail_data = array();
    $mail_data['trip_id'] = '';
    $mail_data['type'] = '';
    $mail_data['created_at'] = '';
    $mail_data['address'] = '';
    $mail_data['alert_naration'] = '';
    $mail_data['company_name'] = '';
    
  // $mail=Mail::to('ttestmail84@gmail.com')->send(new CustomerMail($data));

  return view('admin.emails.alert_email',$mail_data);

}

}
