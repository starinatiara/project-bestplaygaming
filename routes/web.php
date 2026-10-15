<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfilController;
use Illuminate\Support\Facades\Route;

Route::redirect('/', '/login');
Route::view('/login', 'login');
Route::post('/login', [AuthController::class, 'login']);
Route::view('/register', 'register');
Route::view('/dashboard', 'dashboard');
Route::view('/booking', 'booking');
Route::view('/ruangan', 'ruangan');
Route::view('/ruanganAdmin', 'ruanganAdmin');
Route::view('/laporan', 'laporan');
Route::view('/tracking', 'tracking');
Route::view('/user', 'user');
Route::view('/profil', 'profil');
Route::get('/profil/data', [ProfilController::class, 'show']);
Route::put('/profil', [ProfilController::class, 'update']);