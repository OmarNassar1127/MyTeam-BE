<?php
use Illuminate\Support\Facades\Route;
use App\Http\App\Controllers\AppLoginController;
use App\Http\App\Controllers\AppRegistrationController;

//Login to the app
Route::post('/log-in', [AppLoginController::class, 'logIn']);

//Register to the app
Route::post('/fetch-club', [AppRegistrationController::class, 'clubFetch']);
Route::post('/registration', [AppRegistrationController::class, 'register']);
Route::post('/registration-finish', [AppRegistrationController::class, 'registerFinish']);


