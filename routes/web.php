<?php

use App\Events\TestEvent;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

use Illuminate\Support\Facades\Broadcast;



Route::get('/app', function () {
    return view('welcome');
});



Route::get('/app/{any}', function () {
    return view('welcome');
});



Route::get('/testevent', function () {

    Broadcast::event(new TestEvent('Hello from Reverb!'));


    return response()->json(['status' => 'event broadcasted']);


});



// Auth::routes();


