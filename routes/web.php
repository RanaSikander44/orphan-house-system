<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\admin\DashboardController;
use App\Http\Controllers\admin\ApplicationController;
use App\Http\Controllers\admin\AcademicYearController;


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

// Define the routes for the RoleController
Route::resource('roles', RoleController::class);

// Custom delete route for roles
Route::delete('/roles/{role}', [RoleController::class, 'destroy'])->name('roles.destroy');

// Custom update route for roles
Route::put('/roles/{role}', [RoleController::class, 'update'])->name('roles.update');
 







Route::middleware(['auth'])->group(function () {


    Route::get('/dashboard', [DashboardController::class, 'dashboard'])->name('dashboard');


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
    Route::get('applications/student-view/{id}', [ApplicationController::class, 'studentView'])->name('student.view');



     // Users Routes
    Route::get('/users', [UserController::class, 'index'])->name('users');    // List users
    Route::get('/users/create', [UserController::class, 'create'])->name('users.create');  // Show create user form
    Route::post('/users', [UserController::class, 'store'])->name('users.store');    // Store new user
    Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('users.edit'); // Edit user
    Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update'); // Update user

    
    
    // Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::put('/users/{id}/update-role', [UserController::class, 'updateRole'])->name('users.updateRole');

    Route::delete('users/{user}', [UserController::class, 'destroy'])->name('users.destroy');
    // Route::get('users/{user}/edit', [UserController::class, 'edit'])->name('users.edit');


    // Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::get('/dashboard', [UserController::class, 'dashboard'])->name('dashboard');
});

