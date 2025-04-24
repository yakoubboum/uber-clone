<?php

use App\Models\Trip;
use App\Models\User;
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



Route::get('/test', function () {

    $user=User::find(40);

    // $trip->load('driver.user');

    return $user->driver;


});



// Auth::routes();


