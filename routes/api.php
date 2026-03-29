<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\BookingController;
use App\Http\Controllers\Api\AccountController;
use App\Http\Controllers\Api\RoomController;
use App\Http\Controllers\Api\TourComboController;
use App\Http\Controllers\Api\ComboBookingController;

// Search available rooms by date range
Route::get('rooms/home', [RoomController::class, 'homeRooms']);
Route::get('rooms/search', [RoomController::class, 'searchAvailable']);
Route::get('room-types', [RoomController::class, 'roomTypes']);

// Tours - Combo Tour + Room booking
Route::get('tours', [TourComboController::class, 'index']);
Route::get('tours/{maTour}/details', [TourComboController::class, 'getTourWithRooms']);
Route::get('tours/departure/{departureScheduleId}/available-rooms', [TourComboController::class, 'getAvailableRoomsForSchedule']);

// Booking
Route::post('bookings', [BookingController::class, 'book']);
Route::get('bookings/customer/{maKh}', [BookingController::class, 'listByCustomer']);
Route::post('bookings/{maHD}/rooms/{maPhong}/cancel', [BookingController::class, 'cancelRoomBooking']);
Route::post('bookings/{maHD}/confirm-payment', [BookingController::class, 'confirmPayment']);
Route::get('bookings/{maHD}/payment-status', [BookingController::class, 'paymentStatus']);
Route::post('webhooks/bank-transfer', [BookingController::class, 'bankTransferWebhook']);
Route::post('webhooks/zalopay', [BookingController::class, 'zaloPayWebhook']);

// Combo Booking (Tour + Room)
Route::post('combo-bookings', [ComboBookingController::class, 'bookCombo']);
Route::get('combo-bookings/{maHD}/payment-status', [ComboBookingController::class, 'paymentStatus']);
Route::post('combo-bookings/{maHD}/confirm-payment', [ComboBookingController::class, 'confirmPayment']);
Route::post('combo-bookings/{maHD}/cancel', [ComboBookingController::class, 'cancelComboBooking']);

// Register
Route::post('register', [AccountController::class, 'register']);

// Login
Route::post('login', [AccountController::class, 'login']);

// Password reset
Route::post('password/forgot', [AccountController::class, 'forgotPassword']);
Route::post('password/reset', [AccountController::class, 'resetPassword']);
