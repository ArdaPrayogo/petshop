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

// Profile
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

// CRUD Admin
Route::resource('service', ServiceController::class)->middleware('auth');
Route::resource('pelanggan', UserController::class)->middleware('auth');
Route::resource('pets', PetController::class)->middleware('auth');
Route::resource('bills', BillController::class)->middleware('auth');
Route::resource('bookings', BookingController::class)->middleware('auth');

Route::patch('/bookings/{booking}/cancel', [BookingController::class, 'cancel'])->name('bookings.cancel');
Route::put('/bookings/{booking}/status/{status}', [BookingController::class, 'updateStatus'])
    ->name('bookings.updateStatus');



// Transaksi by admin
Route::get('/bills/{bill}/pay', [BillController::class, 'payForm'])->name('bills.pay.form')->middleware('auth');
Route::post('/bills/{bill}/pay', [BillController::class, 'processPayment'])->name('bills.pay.process')->middleware('auth');

// Transaksi by customer
Route::get('/bookings/{booking}/pay', [BookingController::class, 'createbillcustomer'])->name('bookings.pay');

Route::post('/bookings/{booking}/pay', [BookingController::class, 'storebillcustomer'])->name('bookings.pay.process');

// CRUD CUSTOMER
Route::get('/ourservice', [ServiceController::class, 'indexcustomer']);

Route::get('/mypet', [PetController::class, 'indexcustomer']);
Route::get('/mypet/create', [PetController::class, 'createcustomer']);
Route::post('/mypet', [PetController::class, 'storecustomer']);

Route::get('/mybooking', [BookingController::class, 'indexcustomer']);
Route::get('/mybooking/create', [BookingController::class, 'createcustomer']);
Route::post('/mybooking', [BookingController::class, 'storecustomer']);
Route::get('/mybooking/history', [BookingController::class, 'indexHistoryCustomer'])->name('mybooking.history');

Route::get('/mybill', [BillController::class, 'indexcustomer']);
