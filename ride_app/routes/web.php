<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\RideController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\AiFareController;

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::post('/contact', [ContactController::class, 'send'])->name('contact.send');

Route::middleware('auth')->group(function () {
    Route::get('/', function () {
        return view('index');
    })->name('home');

    Route::get('/rides', [RideController::class, 'index'])->name('rides.index');
    Route::post('/rides', [RideController::class, 'store'])->name('rides.store');
    Route::get('/bookings', [BookingController::class, 'index'])->name('bookings.index');
    Route::post('/bookings', [BookingController::class, 'store'])->name('bookings.store');
    Route::post('/ai/fare-estimate', [AiFareController::class, 'estimate'])->name('ai.fare.estimate');
});

Route::get('/debug/db-check', function () {
    return response()->json([
        'users' => \App\Models\User::count(),
        'rides' => \App\Models\Ride::count(),
        'bookings' => \App\Models\Booking::count(),
        'latest_ride' => \App\Models\Ride::latest()->first(),
        'latest_booking' => \App\Models\Booking::latest()->first(),
    ]);
});