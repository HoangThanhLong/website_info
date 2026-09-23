<?php

use App\Http\Controllers\Admin\AccountController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\ProjectController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

Route::get('/', HomeController::class)->name('home');

Route::middleware('guest')->group(function () {
    Route::get('/dang-nhap', [AuthController::class, 'create'])->name('login');
    Route::post('/dang-nhap', [AuthController::class, 'store'])->name('login.store');
});

Route::post('/dang-xuat', [AuthController::class, 'destroy'])->middleware('auth')->name('logout');

Route::prefix('admin')->name('admin.')->middleware('auth')->group(function () {
    Route::get('/', DashboardController::class)->name('dashboard');
    Route::get('/thong-tin', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/thong-tin', [ProfileController::class, 'update'])->name('profile.update');
    Route::get('/tai-khoan', [AccountController::class, 'edit'])->name('account.edit');
    Route::put('/tai-khoan', [AccountController::class, 'update'])->name('account.update');
    Route::resource('projects', ProjectController::class)->except('show');
});
