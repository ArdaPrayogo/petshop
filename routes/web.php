<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PetController;
use App\Http\Controllers\BillController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ProfilController;
use App\Http\Controllers\BookingController;


use App\Http\Controllers\ServiceController;
use App\Http\Controllers\RegisterController;

Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [ProfilController::class, 'index'])->name('profile.index');
    Route::get('/profile/edit', [ProfilController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfilController::class, 'update'])->name('profile.update');
    Route::get('/profile/password', [ProfilController::class, 'editPassword'])->name('profile.password.edit');
    Route::put('/profile/password', [ProfilController::class, 'updatePassword'])->name('profile.password.update');
});


// Register
Route::get('/register', [RegisterController::class, 'index'])->middleware('guest');
Route::post('/register', [RegisterController::class, 'store']);


// LOGIN
Route::get('/login', [LoginController::class, 'index'])->name('login')->middleware('guest');
Route::post('/login', [LoginController::class, 'authenticate']);
Route::post('/logout', [LoginController::class, 'logout'])->middleware('auth');

Route::get('/admin', function () {
    return view('dashboards/admin');
});
Route::get('/', function () {
    return view('dashboards/customer');
});

Route::resource('service', ServiceController::class)->middleware('auth');
Route::resource('pelanggan', UserController::class)->middleware('auth');
Route::resource('pets', PetController::class)->middleware('auth');
Route::resource('bills', BillController::class)->middleware('auth');
Route::resource('bookings', BookingController::class)->middleware('auth');

Route::get('/bills/{bill}/pay', [BillController::class, 'payForm'])->name('bills.pay.form')->middleware('auth');
Route::post('/bills/{bill}/pay', [BillController::class, 'processPayment'])->name('bills.pay.process')->middleware('auth');
