<?php

use Illuminate\Support\Facades\Route;
use App\Http\Dashboard\Controllers\DashboardController;
use App\Http\Dashboard\Auth\Controllers\LoginController;

Route::post('/login', [LoginController::class, 'login']);

/*
 * Dashboard Get Routes
 */
Route::get('/statistics', [DashboardController::class, 'statistics']);
Route::get('/clubs', [DashboardController::class, 'clubs']);
Route::post('/clubs/{clubId}/upload-logo', [DashboardController::class, 'uploadLogo']);
Route::post('/admin', [DashboardController::class, 'createAdmin']);
