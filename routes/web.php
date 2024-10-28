<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WebController;
use App\Http\Controllers\MessageWebSocketController;
use App\Events\SendMessageToClientEvent;
use App\Http\Controllers\SocketController;
use App\Http\Controllers\ParserController;


Route::get('/clear', function () {
    \Illuminate\Support\Facades\Artisan::call('optimize:clear');
});

//frontend

// Route::get('/', function (){
//     // return redirect()->route('admin.login');

//     return redirect('https://gpspackseal.in/index.html');

// });











