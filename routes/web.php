<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\admin\DashboardController;
use App\Http\Controllers\admin\ApplicationController;
use App\Http\Controllers\admin\AcademicYearController;
use App\Http\Controllers\UserController;

Route::get('/', function () {
    return view('login');
});


// Register routes
Route::view('register', 'register')->name('register');
Route::post('registerSave', [UserController::class, 'register'])->name('registerSave');

// Login routes
Route::view('login', 'login')->name('login');
Route::post('loginMatch', [UserController::class, 'login'])->name('loginMatch');

// Dashboard route (protected)
Route::get('admin/dashboard', [UserController::class, 'dashboardPage'])->middleware('auth')->name('admin.Dashboard');

// Logout
Route::get('logout', [UserController::class, 'logout'])->middleware('auth')->name('logout');






