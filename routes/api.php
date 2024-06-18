<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TripController;
use App\Http\Controllers\DriverController;




/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });


Route::group(['middleware' => 'api','prefix' => 'auth'], function ($router) {
    Route::post('user/register', [AuthController::class, 'registerUser']);
    Route::post('driver/register', [AuthController::class, 'registerDriver']);
    Route::post('login', [AuthController::class, 'login']);
    Route::post('logout', [AuthController::class, 'logout']);

    });

    Route::middleware(['CekRole:user'])->group(function () {
    Route::post('/user/trip', [TripController::class, 'create']);
    Route::get('/user/trips', [TripController::class, 'viewUserTrips']);
    });

    Route::middleware(['CekRole:driver'])->group(function () {
    Route::get('/driver/trips', [TripController::class, 'viewAvailableTrips']);
    Route::post('/driver/trip/{id}', [TripController::class, 'acceptTrip']);
    });
