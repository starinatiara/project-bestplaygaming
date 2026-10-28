<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfilController;
use App\Http\Controllers\RuanganController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::redirect('/', '/login');

Route::get('/login', function () {
    return session()->has('user') ? redirect('/dashboard') : view('login');
});
Route::post('/login', [AuthController::class, 'login']);
Route::get('/logout', [AuthController::class, 'logout']);
Route::view('/register', 'register');

Route::middleware('cek.login')->group(function () {
    Route::view('/dashboard', 'dashboard')->middleware('no.direct');
    Route::view('/booking', 'booking')->middleware('no.direct');
    Route::view('/ruangan', 'ruangan')->middleware('no.direct');
    Route::view('/laporan', 'laporan')->middleware('no.direct');
    Route::view('/tracking', 'tracking')->middleware('no.direct');
    Route::view('/profil', 'profil')->middleware('no.direct');
    Route::get('/profil/data', [ProfilController::class, 'show']);
    Route::put('/profil', [ProfilController::class, 'update']);

    Route::get('/ruangan/data', [RuanganController::class, 'index']);

    // Khusus superadmin
    Route::middleware('cek.role:superadmin')->group(function () {
        Route::view('/user', 'user')->middleware('no.direct');
        Route::get('/user/data', [UserController::class, 'index']);
        Route::post('/user', [UserController::class, 'store']);
        Route::put('/user/{id}', [UserController::class, 'update']);
        Route::delete('/user/{id}', [UserController::class, 'destroy']);

        Route::view('/ruanganAdmin', 'ruanganAdmin')->middleware('no.direct');
        Route::view('/superadmin/laporan', 'laporan_superadmin')->middleware('no.direct');
        Route::post('/ruangan', [RuanganController::class, 'store']);
        Route::put('/ruangan/{id}', [RuanganController::class, 'update']);
        Route::delete('/ruangan/{id}', [RuanganController::class, 'destroy']);
    });
});