<?php
use Illuminate\Support\Facades\Route;
use App\Http\App\Controllers\ProfileController;
use App\Http\App\Controllers\AppLoginController;
use App\Http\App\Controllers\AppRegistrationController;

//Login to the app
Route::post('/log-in', [AppLoginController::class, 'logIn']);

//Register to the app
Route::post('/fetch-club', [AppRegistrationController::class, 'clubFetch']);
Route::post('/registration', [AppRegistrationController::class, 'register']);
Route::post('/registration-finish', [AppRegistrationController::class, 'registerFinish']);
Route::get('/club/{clubId}/teams', [AppRegistrationController::class, 'getTeams']);
Route::get('/club/{club}/teams/{team}/link', [AppRegistrationController::class, 'linkUser']);

Route::middleware('auth:users')->group(function () {

  Route::post('/log-out', [AppLoginController::class, 'logOut']);
  //profile
  Route::get('/profile', [ProfileController::class, 'profile']);
  Route::get('/profile/team-stats', [ProfileController::class, 'getTeamStats']);
  

});
