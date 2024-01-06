<?php
use Illuminate\Support\Facades\Route;
use App\Http\App\Controllers\AppRegistrationController;



Route::post('/fetch-club', [AppRegistrationController::class, 'clubFetch']);

