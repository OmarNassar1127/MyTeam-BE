<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GameController;
use App\Http\Dashboard\Controllers\DashboardController;

/*
 * Dashboard Get Routes
 */
Route::get('/statistics', [DashboardController::class, 'statistics']);
Route::get('/clubs', [DashboardController::class, 'clubs']);
Route::post('/clubs/{clubId}/upload-logo', [DashboardController::class, 'uploadLogo']);
