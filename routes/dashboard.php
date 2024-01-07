<?php

use Illuminate\Support\Facades\Route;
use App\Http\Dashboard\Controllers\CreateController;
use App\Http\Dashboard\Controllers\DashboardController;
use App\Http\Dashboard\Auth\Controllers\LoginController;
use App\Http\Dashboard\Auth\Controllers\LogoutController;
use App\Http\Dashboard\Clubs\Controllers\ClubController;

Route::post('/login', [LoginController::class, 'adminLogin']);

Route::middleware('auth:admins')->group(function () {
  //Logout
  Route::post('/logout', [LogoutController::class, 'adminLogout']);
  
  /*
  * Dashboard Get Routes
  */
  Route::get('/dashboard-statistics', [DashboardController::class, 'statistics']);
  Route::get('/clubs-table', [DashboardController::class, 'clubs']);
  Route::get('/users-table', [DashboardController::class, 'users']);
  Route::get('/teams-table', [DashboardController::class, 'teams']);
  
  //Dashboard Posts requests
  Route::post('/clubs', [CreateController::class, 'storeClub']);
  Route::post('/presidents', [CreateController::class, 'storePresident']);
  Route::post('/managers', [CreateController::class, 'storeManager']);
  Route::post('/teams', [CreateController::class, 'storeTeam']);
  
  //Get requests of users for dropdowns
  Route::get('/get-presidents', [DashboardController::class, 'getPresidents']);
  Route::get('/get-managers', [DashboardController::class, 'getManagers']);
  Route::get('/get-clubs', [DashboardController::class, 'getClubs']);

  /**
   * Clubs 
   */
  


   //Add logo to club
  Route::post('/clubs/{clubId}/upload-logo', [DashboardController::class, 'uploadLogo']);

  //creation of admin
  // Route::post('/admin', [DashboardController::class, 'createAdmin']);
});