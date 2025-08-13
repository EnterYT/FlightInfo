<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/flight-passengers', [FlightPassengerController::class, 'index']);
