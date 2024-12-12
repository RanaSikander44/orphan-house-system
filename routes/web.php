<?php

use App\Http\Controllers\admin\PermissionController;
use App\Http\Controllers\EnquiryController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\admin\RolesController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\admin\DashboardController;
use App\Http\Controllers\admin\AdoptionController;
use App\Http\Controllers\admin\AcademicYearController;
use App\Http\Controllers\admin\SettingsController;
use App\Http\Controllers\admin\StaffController;


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
// Route::get('admin/dashboard', [UserController::class, 'dashboard'])->middleware('auth')->name('admin.Dashboard');



Route::get('logout', [UserController::class, 'logout'])->middleware('auth')->name('logout');



Route::middleware(['auth'])->group(function () {


    Route::get('/admin/dashboard', [DashboardController::class, 'dashboard'])->name('dashboard');


    // Academic Year 
    Route::get('academic-year', [AcademicYearController::class, 'index'])->name('academic-year');
    Route::post('academic-year/save', [AcademicYearController::class, 'save'])->name('academic-year.save');
    Route::get('academic-year/edit/{id}', [AcademicYearController::class, 'edit'])->name('academic-year.edit');
    Route::post('academic-year/update/{id}', [AcademicYearController::class, 'update'])->name('academic-year.update');
    Route::get('academic-year/delete/{id}', [AcademicYearController::class, 'delete'])->name('academic-year.delete');



    // Students Applications
    Route::get('adoptions', [AdoptionController::class, 'index'])->name('adoptions');
    Route::get('enquiry/add', [AdoptionController::class, 'add'])->name('enquiry.add');
    Route::post('enquiry/store', [AdoptionController::class, 'store'])->name('enquiry.store');
    Route::get('enquiry/child-view/{id}', [AdoptionController::class, 'studentView'])->name('enquiry.view');
    Route::get('enquiry/child-edit/{id}', [AdoptionController::class, 'studentEdit'])->name('enquiry.edit');
    Route::post('enquiry/child-update/{id}', [AdoptionController::class, 'studentUpdate'])->name('enquiry.update');
    Route::get('enquiry/child-delete/{id}', [AdoptionController::class, 'studentDelete'])->name('enquiry.delete');
    Route::delete('enquiry/child-view/delete-document/{id}', [AdoptionController::class, 'deldoc'])->name('delete.doc');


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


    // Roles
    Route::get('roles', [RolesController::class, 'index'])->name('roles.index');
    Route::get('roles/add', [RolesController::class, 'create'])->name('roles.create');
    Route::post('roles/store', [RolesController::class, 'store'])->name('roles.store');
    Route::get('roles/edit/{id}', [RolesController::class, 'edit'])->name('roles.edit');
    Route::put('/roles/{role}', [RolesController::class, 'update'])->name('roles.update');
    Route::delete('/roles/{role}', [RolesController::class, 'destroy'])->name('roles.destroy');


    // permission
    Route::get('permissions', [PermissionController::class, 'index'])->name('permissions.index');
    Route::post('permissions/add', [PermissionController::class, 'store'])->name('permissions.store');
    Route::put('/permissions/{id}', [PermissionController::class, 'update'])->name('permissions.update');
    Route::delete('/permissions/{id}', [PermissionController::class, 'delete'])->name('permissions.delete');


    // assign permissions please
    Route::get('assign-roles/{id}', [PermissionController::class, 'assign'])->name('assign');





    // Staffs
    Route::resource('staff', StaffController::class);
    Route::get('staff/delete/{id}', [StaffController::class, 'delete'])->name('staff.delete');
    Route::get('staff/documents/delete/{id}', [StaffController::class, 'deleteStaffDocs'])->name('staff.docs.delete');





    // Enquiry Types 

     Route::resource('enquiry-types' , EnquiryController::class);



    // Settings

    Route::get('settings', [SettingsController::class, 'index'])->name('settings');
    Route::post('settings/stores', [SettingsController::class, 'store'])->name('settings.store');
    Route::put('settings/update/{id}', [SettingsController::class, 'update'])->name('settings.update');
    Route::delete('settings/delete/{id}', [SettingsController::class, 'delete'])->name('settings.delete');

});

