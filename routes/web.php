<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ParkController;

Route::get('/', function () {
    return view('welcome');
});



// Kullanıcı Arayüzü
Route::get('/', [ParkController::class, 'index'])->name('home');
Route::post('/submit', [ParkController::class, 'store'])->name('store');

// Admin Arayüzü (Gerçek projede buraya auth middleware eklemelisiniz)
