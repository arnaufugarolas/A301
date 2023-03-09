<?php

use App\Http\Controllers\BookingController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

const BOOKING_AND_ID = '/bookings/{id}';

Route::get('/bookings', [BookingController::class, 'index']);
Route::post('/bookings', [BookingController::class, 'store']);
Route::get(BOOKING_AND_ID, [BookingController::class, 'show']);
Route::put(BOOKING_AND_ID, [BookingController::class, 'update']);
Route::delete(BOOKING_AND_ID, [BookingController::class, 'destroy']);
Route::post('/availability', [BookingController::class, 'getAvailability']);
