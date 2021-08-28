<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\ThrottleGuestUser;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\WeatherController;
use App\Http\Middleware\ThrottleIdenticalRequest;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Public routes
Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);
Route::get('weather', WeatherController::class)
    ->middleware([ThrottleGuestUser::class, ThrottleIdenticalRequest::class]);

// Protected routes
Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::post('logout', [AuthController::class, 'logout']);
    Route::post('weather', WeatherController::class)
        ->middleware(ThrottleIdenticalRequest::class);
});
