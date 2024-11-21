<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\admin\DashboardController;
use App\Http\Controllers\admin\ApplicationController;
use App\Http\Controllers\admin\AcademicYearController;

Route::get('/', function () {
    return view('welcome');
});


Route::post('/logout', [LogoutController::class, 'logout'])->name('logout');



Route::get('dashboard', [DashboardController::class, 'dashboard'])->name('dashboard');

// Academic Year 
Route::get('academic-year', [AcademicYearController::class, 'index'])->name('academic-year');
Route::post('academic-year/save', [AcademicYearController::class, 'save'])->name('academic-year.save');
Route::get('academic-year/edit/{id}', [AcademicYearController::class, 'edit'])->name('academic-year.edit');
Route::post('academic-year/update/{id}', [AcademicYearController::class, 'update'])->name('academic-year.update');
Route::get('academic-year/delete/{id}', [AcademicYearController::class, 'delete'])->name('academic-year.delete');



// Students Applications
Route::get('applications', [ApplicationController::class, 'index'])->name('applications');
Route::get('applications/add', [ApplicationController::class, 'add'])->name('application.add');
Route::post('applications/store', [ApplicationController::class, 'store'])->name('application.store');
