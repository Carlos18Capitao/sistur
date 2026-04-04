<?php

use App\Http\Controllers\Admin;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\TourController;
use Illuminate\Support\Facades\Route;

// Public routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/tours', [TourController::class, 'index'])->name('tours.index');
Route::get('/tours/{tour:slug}', [TourController::class, 'show'])->name('tours.show');

// Authenticated routes
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', fn () => redirect()->route('home'))->middleware('verified')->name('dashboard');

    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Bookings
    Route::get('/reservas', [BookingController::class, 'index'])->name('bookings.index');
    Route::post('/reservas', [BookingController::class, 'store'])->name('bookings.store');
    Route::get('/reservas/{reference}', [BookingController::class, 'show'])->name('bookings.show');
    Route::post('/reservas/{reference}/cancelar', [BookingController::class, 'cancel'])->name('bookings.cancel');

    // Reviews
    Route::post('/avaliacoes', [ReviewController::class, 'store'])->name('reviews.store');
});

// Admin routes
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [Admin\DashboardController::class, 'index'])->name('dashboard');

    // Tours CRUD
    Route::resource('tours', Admin\TourController::class);

    // Bookings
    Route::get('/reservas', [Admin\BookingController::class, 'index'])->name('bookings.index');
    Route::get('/reservas/{booking}', [Admin\BookingController::class, 'show'])->name('bookings.show');
    Route::post('/reservas/{booking}/confirmar', [Admin\BookingController::class, 'confirm'])->name('bookings.confirm');
    Route::post('/reservas/{booking}/cancelar', [Admin\BookingController::class, 'cancel'])->name('bookings.cancel');

    // Reviews
    Route::get('/avaliacoes', [Admin\ReviewController::class, 'index'])->name('reviews.index');
    Route::post('/avaliacoes/{review}/aprovar', [Admin\ReviewController::class, 'approve'])->name('reviews.approve');
    Route::delete('/avaliacoes/{review}', [Admin\ReviewController::class, 'destroy'])->name('reviews.destroy');
});

require __DIR__.'/auth.php';
