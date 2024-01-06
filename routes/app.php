<?php
use Illuminate\Support\Facades\Route;
use App\Http\App\Controllers\AppRegistrationController;



Route::post('/fetch-club', [AppRegistrationController::class, 'clubFetch']);
Route::post('/registration', [AppRegistrationController::class, 'register']);
Route::post('/registration-finish', [AppRegistrationController::class, 'registerFinish']);

