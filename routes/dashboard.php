<?php

use Illuminate\Support\Facades\Route;
use App\Http\Dashboard\Controllers\DashboardController;
use App\Http\Dashboard\Auth\Controllers\LoginController;
use App\Http\Dashboard\Auth\Controllers\LogoutController;

Route::post('/login', [LoginController::class, 'adminLogin']);

/*
* Dashboard Get Routes
*/

Route::get('/statistics', [DashboardController::class, 'statistics']);
Route::get('/clubs', [DashboardController::class, 'clubs']);
Route::post('/clubs/{clubId}/upload-logo', [DashboardController::class, 'uploadLogo']);
Route::post('/admin', [DashboardController::class, 'createAdmin']);



Route::middleware('auth:admins')->group(function () {

  Route::post('/logout', [LogoutController::class, 'adminLogout']);
});