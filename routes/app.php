<?php
use Illuminate\Support\Facades\Route;
use App\Http\App\Controllers\AppLoginController;
use App\Http\App\Controllers\AppRegistrationController;


Route::post('/log-in', [AppLoginController::class, 'logIn']);

Route::post('/fetch-club', [AppRegistrationController::class, 'clubFetch']);
Route::post('/registration', [AppRegistrationController::class, 'register']);
Route::post('/registration-finish', [AppRegistrationController::class, 'registerFinish']);

