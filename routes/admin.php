<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CustomersController;
use App\Http\Controllers\ChatController;




Route::namespace('Auth')->group(function () {
    Route::controller('LoginController')->group(function () {
        Route::get('/', 'showLoginForm')->name('login');
        Route::post('/', 'login')->name('login');
        Route::get('logout', 'logout')->name('logout');
    });

    // Admin Password Reset
    Route::controller('ForgotPasswordController')->prefix('password')->name('password.')->group(function () {
        Route::get('reset', 'showLinkRequestForm')->name('reset');
        Route::post('reset', 'sendResetCodeEmail');
        Route::get('code-verify', 'codeVerify')->name('code.verify');
        Route::post('verify-code', 'verifyCode')->name('verify.code');
    });

    Route::controller('ResetPasswordController')->group(function () {
        Route::get('password/reset/{token}', 'showResetForm')->name('password.reset.form');
        Route::post('password/reset/change', 'reset')->name('password.change');
    });
});


    



Route::middleware('admin', 'adminPermission')->group(function () {
    
    
       Route::get('/websockets', function (){
        return view('websockets');
    });


    Route::get('/chatapp', function (){
        return view('chat');
    });


    Route::post('send-message', [ChatController::class, 'sendMessage'])->name('send-message');
    
    
 
    
  

    Route::get('test', function (){
        return view('admin.test');
    });

    Route::controller('AdminController')->group(function () {
        Route::get('dashboard', 'dashboard')->name('dashboard');
        Route::get('profile', 'profile')->name('profile');
        Route::post('profile', 'profileUpdate')->name('profile.update');
        Route::get('password', 'password')->name('password');
        Route::post('password', 'passwordUpdate')->name('password.update');

        Route::post('dashboard-event-alert', 'dashboard_event_alert')->name('dashboard-event-alert');
        Route::post('dashboard-added-trips', 'dashboard_added_trips')->name('dashboard-added-trips');
        Route::get('show-alert', 'showAlert')->name('show-alert');
        Route::post('event-notify', 'get_event_notify')->name('event-notify');
        Route::post('live-location', 'get_device_live_location')->name('live-location');
    });

    Route::controller('AdminController')->prefix('notification')->name('notification.')->group(function () {
        Route::get('view-all-notification', 'view_all_notification')->name('view-all-notification');
        Route::post('notification-event-alert', 'notification_event_alert')->name('notification-event-alert');
    });

    Route::controller('RolesController')->prefix('roles')->name('roles.')->group(function () {
        Route::get('', 'index')->name('index');
        Route::get('add', 'add')->name('add');
        Route::get('edit/{id}', 'edit')->name('edit');
        Route::post('save/{id?}', 'save')->name('save');
    });
    Route::controller('DeviceController')->prefix('device')->name('device.')->group(function () {
        Route::get('map-device-to-customer',  'map_device_to_customer')->name('map-device-to-customer');
        Route::get('unlink-device-from-customer','unlink_device_from_customer')->name('unlink-device-from-customer');
        Route::get('unlink-map-device-to-customer/{id}', 'edit_map_device_to_customer')->name('unlink-map-device-to-customer');
        Route::post('save-unlink-device-from-customer', 'save_unlink_device_from_customer')->name('save-unlink-device-to-customer');


        Route::get('get-customer/{id}',  'get_customer_details')->name('get-customer');
        Route::post('save-maptocustomer',  'save_map_to_customer')->name('save-maptocustomer');
        Route::post('status-mapdevice/{id}',  'status_map_device')->name('status-mapdevice');
        Route::get('my-device',  'my_device')->name('my-device');
        Route::get('import',  'index')->name('import');
        Route::get('live-tracking/{id}',  'live_tracking')->name('live-tracking');
        Route::get('live-tracking-trip-completed/{id}',  'live_tracking_trip_completed')->name('live-tracking-trip-completed');
        Route::post('import-exel', 'import_device_exel')->name('import_exel');
        Route::post('get-trip-alert', 'get_trip_alert')->name('get-trip-alert');
        Route::post('get-live-device-location',  'get_live_device_location')->name('live-location-tracking');

    });

    Route::controller('CustomerController')->prefix('customers')->name('customers.')->group(function () {
        Route::get('add-customer', 'add_customer')->name('add-customer');
        Route::post('save-customer', 'save_customer')->name('save-customer');
        Route::get('edit-customer/{id}', 'edit_customer')->name('edit-customer');
        Route::patch('update-customer/{id}', 'update_customer')->name('update-customer');
        Route::post('status-customer/{id}', 'status_customer')->name('status-customer');

        Route::get('add-customer-user', 'add_customer_user')->name('add-customer-user');
        Route::post('save-customer-user', 'save_customer_user')->name('save-customer-user');
        Route::get('edit-customer-user/{id}', 'edit_customer_user')->name('edit-customer-user');
        Route::patch('update-customer-user/{id}', 'update_customer_user')->name('update-customer-user');
        Route::post('status-customer-user/{id}', 'status_customer_user')->name('status-customer-user');

        Route::get('send-emails', 'send_emails')->name('send-emails');
        Route::get('customer-confirm-emails', 'customer_confirm_emails')->name('customer-confirm-emails');

    });

    Route::controller('LocationController')->prefix('locations')->name('locations.')->group(function () {
        Route::get('add-location', 'add_location')->name('add-location');
        Route::post('save-location', 'save_location')->name('save-location');
        Route::post('status-location/{id}', 'status_location')->name('status-location');
        Route::get('edit-location/{id}', 'edit_location')->name('edit-location');
        Route::patch('update-location/{id}', 'update_location')->name('update-location');
    });

    Route::controller('TripsController')->prefix('trips')->name('trips.')->group(function () {
        Route::get('assign-trip',  'assign_trip')->name('assign-trip');
        Route::get('ongoing-trips',  'ongoing_trips')->name('ongoing-trips');
        Route::get('completed-trip',  'completed_trip')->name('completed-trip');
        Route::post('add-trip', 'add_trip')->name('add-trip');
        Route::get('trip-details',  'trip_details')->name('trip-details');
        Route::get('edit-trip/{id}', 'edit_trip')->name('edit-trip');
        Route::post('update-trip/{id}', 'update_trip')->name('update-trip');
        Route::post('trip-completed-status/{id}', 'trip_completed')->name('completed-trip-status');
        Route::post('remove-file', 'remove_trip_file')->name('remove-trip-file');
        Route::post('get_device_details', 'get_device_details')->name('device-details');
        Route::post('get_assign_trip_details', 'get_assign_trip_details')->name('assign.trips');
        Route::post('get_ongoing_trips', 'get_ongoing_trips')->name('get.ongoing.trips');
        Route::post('get_completed_trips', 'get_completed_trips')->name('get.completed.trips');

    });

    Route::controller('ReportController')->prefix('reports')->name('reports.')->group(function () {
        Route::get('trip-reports',  'trip_reports')->name('trip-reports');
        Route::post('get_trip_report',  'get_trip_report')->name('get.trip-report');


        Route::get('route-reports',  'route_reports')->name('route-reports');
        Route::post('route-trips',  'route_trips')->name('route-trips');
        Route::get('pdf-route-reports',  'pdf_route_reports')->name('pdf-route-reports');
        Route::get('excel-route-reports',  'excel_route_reports')->name('excel-route-reports');


        Route::get('lock-and-unlock-reports',  'lock_and_unlock_reports')->name('lock-and-unlock-reports');
        Route::post('lock-and-unlock-trips',  'lock_and_unlock_trips')->name('lock-and-unlock-trips');
        Route::get('excel-lock-unlock-reports',  'excel_lock_unlock_report')->name('excel-lock-unlock-reports');
        Route::get('pdf-lock-unlock-reports',  'pdf_lock_unlock_report')->name('pdf-lock-unlock-reports');

        Route::get('stop-reports',  'stop_reports')->name('stop-reports');

        Route::get('device-summary-reports',  'device_summary_reports')->name('device-summary-reports');
        Route::post('get-device-summary', 'get_device_summary')->name('get-device-summary');
        Route::get('excel-device-summary-reports',  'excel_device_summary_reports')->name('excel-device-summary-reports');
        Route::get('pdf-device-summary-reports',  'pdf_device_summary_report')->name('pdf-device-summary-reports');

        Route::get('replay',  'replay')->name('replay');
        Route::post('replay-trips', 'reply_trips')->name('get-replay-trips');



        Route::get('events-reports',  'events_reports')->name('events-reports');

        Route::get('alarm-reports',  'alarm_reports')->name('alarm-reports');
        Route::post('get_alrams_trip_details', 'get_alrams_trip_details')->name('alrams.trips');
        Route::get('excel-alarm-reports',  'excel_alarm_report')->name('excel-alarm-reports');
        Route::get('pdf-alarm-reports',  'pdf_alarm_report')->name('pdf-alarm-reports');

        Route::get('events-reports',  'events_reports')->name('events-reports');
        Route::post('get_events_trip_details', 'get_events_trip_details')->name('events.trips');
        Route::get('excel-events-reports',  'excel_events_report')->name('excel-events-reports');
        Route::get('pdf-events-reports',  'pdf_events_report')->name('pdf-events-reports');

        Route::post('get-device-per-trip',  'get_device_per_trip')->name('get-device-per-trip');
        Route::get('excel-trips-reports',  'excel_trips_report')->name('excel-trips-reports');
        Route::get('pdf-trips-reports', 'pdf_trips_report')->name('pdf-trips-reports');


    });
    Route::controller('MapController')->prefix('maps')->name('maps.')->group(function () {
        Route::get('/map',  'index')->name('map');
        Route::get('/car-position',  'getCarPosition')->name('getCarPosition');

    });
});
