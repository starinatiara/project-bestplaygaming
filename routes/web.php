<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfilController;
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
    Route::view('/dashboard', 'dashboard');
    Route::view('/booking', 'booking');
    Route::view('/ruangan', 'ruangan');
    Route::view('/ruanganAdmin', 'ruanganAdmin');
    Route::view('/laporan', 'laporan');
    Route::view('/tracking', 'tracking');
    Route::view('/profil', 'profil');
    Route::get('/profil/data', [ProfilController::class, 'show']);
    Route::put('/profil', [ProfilController::class, 'update']);

    // Khusus superadmin
    Route::middleware('cek.role:superadmin')->group(function () {
        Route::view('/user', 'user');
        Route::get('/user/data', [UserController::class, 'index']);
        Route::post('/user', [UserController::class, 'store']);
        Route::put('/user/{id}', [UserController::class, 'update']);
        Route::delete('/user/{id}', [UserController::class, 'destroy']);
    });
});