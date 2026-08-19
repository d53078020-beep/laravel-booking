<?php

use App\Http\Controllers\Api\HotelController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\BookingController;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/bookings', [BookingController::class, 'index']);
    Route::post('/bookings', [BookingController::class, 'store']);
    Route::patch('/bookings/{booking}/cancel', [BookingController::class, 'cancel']);
    Route::post('/register', [AuthController::class, 'register']);
});

Route::get('/hotels', [HotelController::class, 'index']);
Route::get('/hotels/{hotel:slug}', [HotelController::class, 'show']);
