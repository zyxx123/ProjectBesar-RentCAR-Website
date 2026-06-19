<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AdminBookingController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::middleware([\App\Http\Middleware\AdminMiddleware::class])->group(function () {
        // Admin Booking Routes
        Route::post('/admin/booking/{booking}/verify', [AdminBookingController::class, 'verify'])->name('admin.booking.verify');
        Route::post('/admin/booking/{booking}/reject', [AdminBookingController::class, 'reject'])->name('admin.booking.reject');

        // Admin Reports Routes
        Route::get('/admin/reports/print', [App\Http\Controllers\ReportController::class, 'print'])->name('admin.reports.print');

        // Admin Vehicle Routes
        Route::resource('admin/vehicles', App\Http\Controllers\AdminVehicleController::class)->names([
            'index' => 'admin.vehicles.index',
            'create' => 'admin.vehicles.create',
            'store' => 'admin.vehicles.store',
            'edit' => 'admin.vehicles.edit',
            'update' => 'admin.vehicles.update',
            'destroy' => 'admin.vehicles.destroy',
        ]);

        // Admin User Routes
        Route::resource('admin/users', App\Http\Controllers\AdminUserController::class)->names([
            'index' => 'admin.users.index',
            'create' => 'admin.users.create',
            'store' => 'admin.users.store',
            'edit' => 'admin.users.edit',
            'update' => 'admin.users.update',
            'destroy' => 'admin.users.destroy',
        ]);
    });

    // Booking Routes
    Route::get('/booking/{vehicle}', [BookingController::class, 'create'])->name('booking.create');
    Route::post('/booking/{vehicle}', [BookingController::class, 'store'])->name('booking.store');
    Route::get('/booking/{booking}/payment', [BookingController::class, 'payment'])->name('booking.payment');
    Route::post('/booking/{booking}/payment', [BookingController::class, 'uploadPayment'])->name('booking.uploadPayment');
});

require __DIR__.'/auth.php';
