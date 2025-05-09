<?php

use Illuminate\Http\Request;
use App\Http\Controllers\AuthController;
// use Illuminate\Routing\Route;

Route::post('/generate-keys', [AuthController::class, 'generateApiCredentials']);
Route::post('/generate-token', [AuthController::class, 'generateToken']);
