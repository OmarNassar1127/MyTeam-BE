<?php

use Illuminate\Support\Facades\Route;
use App\Http\Dashboard\Controllers\CreateController;
use App\Http\Dashboard\Controllers\DashboardController;
use App\Http\Dashboard\Auth\Controllers\LoginController;
use App\Http\Dashboard\Auth\Controllers\LogoutController;

Route::post('/login', [LoginController::class, 'adminLogin']);

Route::middleware('auth:admins')->group(function () {
  //Logout
  Route::post('/logout', [LogoutController::class, 'adminLogout']);
  
  /*
  * Dashboard Get Routes
  */
  Route::get('/statistics', [DashboardController::class, 'statistics']);
  Route::get('/clubs', [DashboardController::class, 'clubs']);
  Route::get('/users', [DashboardController::class, 'users']);
  Route::get('/teams', [DashboardController::class, 'teams']);

  //Posts
  Route::post('/clubs', [CreateController::class, 'storeClub']);
  Route::post('/presidents', [CreateController::class, 'storePresident']);
  Route::post('/managers', [CreateController::class, 'storeManager']);
  Route::post('/teams', [CreateController::class, 'storeTeam']);

  //Add logo to club
  Route::post('/clubs/{clubId}/upload-logo', [DashboardController::class, 'uploadLogo']);

  //creation of admin
  // Route::post('/admin', [DashboardController::class, 'createAdmin']);
});