<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProfileController as AdminProfileController;
use App\Http\Controllers\Admin\UsersController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Non-admin profile routes removed to avoid redirecting to /profile after login

require __DIR__.'/auth.php';

// Admin area
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/profile', [AdminProfileController::class, 'edit'])->name('profile.edit');
    Route::post('/profile', [AdminProfileController::class, 'update'])->name('profile.update');

    // Account security (password change) view within admin layout
    Route::get('/security/password', function () {
        return view('admin.security.password');
    })->name('security.password');

    // Admin user management: create new user
    Route::get('/users/create', [UsersController::class, 'create'])->name('users.create');
    Route::post('/users', [UsersController::class, 'store'])->name('users.store');

    // Single consolidated Account Management page
    Route::get('/account', function () {
        return view('admin.account.index');
    })->name('account.index');
});
