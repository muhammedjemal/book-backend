<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\AdminController; // <--- THIS WAS MISSING!

// Public Routes
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// Protected Routes
Route::middleware(['auth:sanctum'])->group(function () {
    
    // User Info
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    // User Booking Actions
    Route::post('/bookings', [BookingController::class, 'store']);
    Route::get('/my-bookings', [BookingController::class, 'myBookings']);

    // Admin Actions
    Route::get('/admin/bookings', [AdminController::class, 'getAllBookings']);
    Route::delete('/admin/bookings/{id}', [AdminController::class, 'deleteBooking']);
}); 