<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WebController;
use App\Http\Controllers\MessageWebSocketController;
use App\Events\SendMessageToClientEvent;
use App\Http\Controllers\SocketController;
use App\Http\Controllers\ParserController;





Route::get('clear', function () {
    \Artisan::call('route:clear');
    \Artisan::call('cache:clear');
    \Artisan::call('view:clear');
    \Artisan::call('config:clear');
    return 'clear';
});





// Route::get('/clear', function () {
//     \Illuminate\Support\Facades\Artisan::call('optimize:clear');
// });

//frontend

// Route::get('/', function (){
//     // return redirect()->route('admin.login');

//     return redirect('https://gpspackseal.in/index.html');

// });



Route::get('/', function () {
    return view('front.index');
});




Route::get('/about-us', function () {
    return view('front.about_us');
});



Route::get('/solutions', function () {
    return view('front.solutions');
});


Route::get('/products', function () {
    return view('front.products');
});


Route::get('/our-client', function () {
    return view('front.our_client');
});

Route::get('/plateform', function () {
    return view('front.plateform');
});


Route::get('/contact-us', function () {
    return view('front.contact_us');
});











