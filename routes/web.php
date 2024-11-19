<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\admin\DashboardController;
use App\Http\Controllers\admin\ApplicationController;
use App\Http\Controllers\admin\AcademicYearController;

Route::get('/', function () {
    return view('welcome');
});



Route::get('dashboard', [DashboardController::class, 'dashboard'])->name('dashboard');

// Academic Year 
Route::get('academic-year', [AcademicYearController::class, 'index'])->name('academic-year');
Route::post('academic-year/save', [AcademicYearController::class, 'save'])->name('academic-year.save');



// Students Applications
Route::get('application', [ApplicationController::class, 'index'])->name('applications');
Route::get('application/add', [ApplicationController::class, 'add'])->name('application.add');
