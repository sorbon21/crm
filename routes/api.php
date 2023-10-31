<?php

use App\Http\Controllers\API\V1\AuthController;
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
Route::prefix('v1')->group(function () {
    Route::controller(AuthController::class)->group(function () {
        Route::post('login', 'login');
    });
    Route::middleware(\App\Http\Middleware\AuthenticateJWT::class)->group(function () {
        Route::resource('user', \App\Http\Controllers\API\V1\UserController::class);
        Route::resource('client', \App\Http\Controllers\API\V1\ClientController::class);
        Route::resource('service', \App\Http\Controllers\API\V1\ServiceController::class);
        Route::resource('request', \App\Http\Controllers\API\V1\RequestController::class);
        Route::resource('request-status', \App\Http\Controllers\API\V1\RequestStatusController::class);
        Route::resource('comment', \App\Http\Controllers\API\V1\CommentController::class);
        Route::resource('phone', \App\Http\Controllers\API\V1\PhoneController::class);
    });
});
