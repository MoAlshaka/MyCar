<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CarController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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
Route::prefix('seller')->group(function () {
    Route::post('register', [AuthController::class, 'register']);
    Route::post('login', [AuthController::class, 'login']);

    Route::middleware("IsApiUser")->group(function(){
        // car
        Route::get('/car',[CarController::class,'index']);
        Route::get('/car-show/{id}',[CarController::class,'show']);
        Route::post('/car-store',[CarController::class,'store']);
        Route::post('/car-update/{id}',[CarController::class,'update']);
        Route::get('/car-delete/{id}',[CarController::class,'delete']);
        // logout
        Route::post('/logout',[AuthController::class,'logout']);

    });
});
