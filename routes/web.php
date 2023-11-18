<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClubController;
use App\Http\Controllers\GameController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Web route
Route::get('/clubs/presidents', [ClubController::class, 'getClubInfo']);
Route::get('/presidents', [ClubController::class, 'presidents']);
Route::get('/managers', [ClubController::class, 'managers']);
Route::get('/players', [ClubController::class, 'players']);
Route::get('/games/{game}/participants', [ClubController::class, 'getGameParticipants']);
Route::get('/games/{game}', [ClubController::class, 'game']);


