<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\admin\DashboardController;

Route::get('/', function () {
    return view('welcome');
});



Route::get('dashboard', [DashboardController::class, 'dashboard']);
Route::get('users', [DashboardController::class, 'users']);
