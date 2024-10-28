<?php

namespace App\Http\Controllers\API;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use App\Models\Countrie;
class LoginController extends Controller
{
    
    /**
     * Get all provinces.
     *
     * @return JsonResponse
     */
    public function getAllCountry() 
    {
        $countries  = Countrie::all();
        if (!empty($countries)) {
            $result = [
                'status' => 'true',
                'msg' => 'Country List',
                'data' => $countries
            ];
        } else {
            $result = [
                'status' => 'false',
                'msg' => 'No data found',
            ];
    
        }
        return response()->json($result);
    }

    public function checkUserLogin(Request $request) {
      
        $country_code_id = trim($request->input('country_code_id'));
        $mobile_no       = trim($request->input('mobile_no'));
        
       
        $data = User::where('country_code_id', $country_code_id)->where('mobile', $mobile_no)->first();
        if(!empty($data)) {
            $data->country_code = $data->Countrie->telephone_prefix;
        }
       
        if (!empty($data)) {
            $result = [
                'status' => 'true',
                'msg' => 'login successfully',
                'data' => $data
            ];
        } else {
            $result = [
                'status' => 'false',
                'msg' => 'mobile no not registerd with us!',
            ];
    
        }
        return response()->json($result);
    }

    public function verifyOTP(Request $request) {
        $user_id = trim($request->input('user_id'));
        $otp     = trim($request->input('otp'));

        $data = User::where('id', $user_id)->where('ver_code', $otp)->first();
        
        if (!empty($data)) {
            $result = [
                'status' => 'true',
                'msg' => 'otp verified successfully',
                'data' => $data
            ];
        } else {
            $result = [
                'status' => 'false',
                'msg' => 'invalid otp',
            ];
        }
        return response()->json($result);
    }

    public function resendOTP(Request $request) {
        $user_id = trim($request->input('user_id'));

        $otp =  8850;
        $status = User::where('id', $user_id)->update(['ver_code'=> $otp ]);
        
        if ($status == true) {
            $result = [
                'status' => 'true',
                'msg' => 'otp sent successfully',
            ];
        } else {
            $result = [
                'status' => 'false',
                'msg' => 'error msg',
            ];
        }
        return response()->json($result);
    }

    public function signUp(Request $request) {
        $first_name      = trim($request->input('first_name'));
        $last_name       = trim($request->input('last_name'));
        $mobile_no       = trim($request->input('mobile_no'));
        $country_code_id = trim($request->input('country_code_id'));


        $data = User::where('email',$mobile_no)->orWhere('mobile',$mobile_no)->first();
        $otp =  1234;
        if (empty($data)) {
            $user = new User();
            $user->username         = trim($mobile_no);
            $user->mobile           = trim($mobile_no);
            $user->country_code_id  = trim($country_code_id);
            $user->firstname        = trim($first_name);
            $user->lastname         = trim($last_name);
            $user->ver_code         = $otp;
            $user->save();
            $uid = $user->id;

            $user_data = User::where('id', $uid)->first();
            $user_data->country_code = $user_data->Countrie->telephone_prefix;
           
            $result = [
                'status' => 'true',
                'msg' => 'Sign up successfully',
                'data' =>$user_data,

            ];
        } else {
            $result = [
                'status' => 'false',
                'msg' => 'user already exist.please try to log in.',
            ];
        }
        return response()->json($result);
    }

}
