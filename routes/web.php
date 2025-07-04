<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PetController;
use App\Http\Controllers\BillController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ServiceController;

Route::get('/', function () {
    return view('welcome');
});
Route::resource('service', ServiceController::class);
Route::resource('pelanggan', UserController::class);
Route::resource('pets', PetController::class);
Route::resource('bills', BillController::class);
Route::resource('bookings', BookingController::class);
