<?php
use Illuminate\Support\Facades\Route;

use App\Http\App\Controllers\GameController;
use App\Http\App\Controllers\SessionController;
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
  Route::get('/user/profile-image', [ProfileController::class, 'getProfileImage'])->name('user.profile-image');
  Route::post('/profile/image', [ProfileController::class, 'image']);
  Route::get('/profile/team-stats', [ProfileController::class, 'getTeamStats']);
  Route::get('/profile/player-stats', [ProfileController::class, 'getPlayerStats']);
  Route::get('/profile/team-members', [ProfileController::class, 'getTeamMembers']);
  
  //trainer game schedueling 
  Route::get('/games', [GameController::class, 'index']);
  Route::get('/games/{gameId}', [GameController::class, 'show']);
  Route::post('/games', [GameController::class, 'store']);
  Route::put('/games/{gameId}/update-players-status', [GameController::class, 'updatePlayersStatus']);
  Route::put('/games/{gameId}/update-players', [GameController::class, 'updatePlayersStatistics']);

  //trainer sessions schedueling
  Route::get('/sessions', [SessionController::class, 'index']);
  Route::post('/sessions', [SessionController::class, 'store']);
  Route::put('/sessions/{sessionId}/update-players', [SessionController::class, 'updatePlayers']);
});
