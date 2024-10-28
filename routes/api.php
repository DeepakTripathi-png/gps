<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\LoginController;
use App\Http\Controllers\API;
use App\Http\Controllers\JT701DeviceController;
use App\Http\Controllers\JT709ADeviceController;
use App\Http\Controllers\JT707DeviceController;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/


    //Login,SignUP,Verify
Route::controller('ApiController')->group(function (){
    Route::post('get_trip_list', 'getTripList');
    Route::post("login", 'checkUserLogin');
    Route::post('verify_otp', 'verifyOTP');
    Route::post('sign_up', 'signUp');
    Route::post('resend_otp', 'resendOTP');
    Route::post('vehicle_gps_details', 'vehicleGpsDetails');
    Route::post('trip_details', 'getTripDetails');
    Route::post('get_completed_trip_list', 'getCompletedTripList');
    
    Route::post('push_data', 'push_data');
    Route::post('push_data_event', 'push_data_event');
    Route::post('send_notification', 'send_notification');
    Route::post('update_device_token', 'update_device_token');
    Route::post('get_notification', 'get_notification');
    Route::post('get_trip_notification', 'get_trip_notification');
    Route::post('getStoredSetting', 'getStoredSetting');

    
    
});

Route::post('/handle-socket-data', [JT701DeviceController::class, 'handleSocketData']);

Route::post('/handle-device-jt709a-data', [JT709ADeviceController::class, 'handlRawData']);

Route::post('/handle-jt707a-data', [JT707DeviceController::class, 'handleJT707AData'])->name('handleJT707AData');








