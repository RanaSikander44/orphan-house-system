<?php

use App\Http\Controllers\admin\ChildActiviesController;
use App\Http\Controllers\admin\DonationRequestController;
use App\Http\Controllers\admin\DormitoryController;
use App\Http\Controllers\admin\FormsController;
use App\Http\Controllers\admin\PermissionController;
use App\Http\Controllers\admin\SchoolController;
use App\Http\Controllers\admin\SchoolGradesController;
use App\Http\Controllers\donor\AdoptionChildDonor;
use App\Http\Controllers\donor\DonorController;
use App\Http\Controllers\donor\DonorPaymentController;
use App\Http\Controllers\EnquiryController;
use App\Http\Controllers\CityController;
use App\Http\Middleware\RoleMiddleware;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\admin\RolesController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\admin\DashboardController;
use App\Http\Controllers\admin\AdoptionController;
use App\Http\Controllers\admin\AcademicYearController;
use App\Http\Controllers\admin\SettingsController;
use App\Http\Controllers\admin\StaffController;
use App\Http\Controllers\admin\PaymentController;


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


    Route::middleware('Role:Donor')->group(function () {

        Route::get('donor/adoptchild', [AdoptionChildDonor::class, 'index'])->name('donor.adopt.child');
        Route::get('donor/enquiry/view/{id}', [AdoptionChildDonor::class, 'view'])->name('donor.enquiry.view');
        Route::get('donor/adoption/requests', [AdoptionChildDonor::class, 'requests'])->name('donor.reqs');
        Route::get('donor/adoption/payment/{id}', [DonorPaymentController::class, 'index'])->name('donor.payment.req');
        Route::post('donor/adoption/make/payment', [DonorPaymentController::class, 'makePayment'])->name('donor.payment');



        // Activities of Child Assigned To Donors 

        Route::get('donor/child/activites', [DonorController::class, 'donorChildAct'])->name('donor.child.activity');




        Route::post('/donor/adopt/request', [AdoptionChildDonor::class, 'requestAdoption'])->name('donor.adopt.request');

        Route::post('/donor/payment/process', [AdoptionChildDonor::class, 'processPayment'])->name('donor.payment.process');

    });




    Route::get('/admin/dashboard', [DashboardController::class, 'dashboard'])->name('dashboard')->middleware('Role:Admin');
    Route::get('/donor/dashboard', [DonorController::class, 'dashboard'])->name('donor.dashboard')->middleware('Role:Donor');


    // Academic Year
    Route::get('academic-year', [AcademicYearController::class, 'index'])->name('academic-year');
    Route::post('academic-year/save', [AcademicYearController::class, 'save'])->name('academic-year.save');
    Route::get('academic-year/edit/{id}', [AcademicYearController::class, 'edit'])->name('academic-year.edit');
    Route::post('academic-year/update/{id}', [AcademicYearController::class, 'update'])->name('academic-year.update');
    Route::get('academic-year/delete/{id}', [AcademicYearController::class, 'delete'])->name('academic-year.delete');
    // city route
    Route::get('cities', [CityController::class, 'index'])->name('cities.index');
    Route::post('cities/save', [CityController::class, 'store'])->name('cities.store');
    Route::get('cities/edit/{id}', [CityController::class, 'edit'])->name('cities.edit');
    Route::put('cities/update/{id}', [CityController::class, 'update'])->name('cities.update');
    Route::delete('cities/delete/{id}', [CityController::class, 'destroy'])->name('cities.destroy');


    // Students Applications
    Route::get('enquiries', [AdoptionController::class, 'index'])->name('adoptions');
    Route::get('enquiry/add', [AdoptionController::class, 'add'])->name('enquiry.add');
    Route::get('enquiry/child/list', [AdoptionController::class, 'approvedChilds'])->name('enquiry.child.list');
    Route::get('enquiry/child/approve/{id}', [AdoptionController::class, 'approveInquiery'])->name('enquiry.approve.child');
    Route::get('enquiry/disapprove/{id}', [AdoptionController::class, 'disapprove'])->name('enquiry.disapprove');
    Route::post('enquiry/disapprove/reason/{id}', [AdoptionController::class, 'disapproveEnquiry'])->name('enquiry.disapprove.child');
    Route::get('enquiry/child/assign-school-dormitory/{id}', [AdoptionController::class, 'AssignSchoolDormitory'])->name('enquiry.assign.school.dormitory');
    Route::post('enquiry/child/assign/{id}', [AdoptionController::class, 'assign'])->name('enquiry.assign');
    Route::post('enquiry/store', [AdoptionController::class, 'store'])->name('enquiry.store');
    Route::get('enquiry/child-view/{id}', [AdoptionController::class, 'studentView'])->name('enquiry.view');
    Route::get('enquiry/child-edit/{id}', [AdoptionController::class, 'studentEdit'])->name('enquiry.edit');
    Route::post('enquiry/child-update/{id}', [AdoptionController::class, 'update'])->name('enquiry.update');
    Route::get('enquiry/child-delete/{id}', [AdoptionController::class, 'studentDelete'])->name('enquiry.delete');
    Route::delete('enquiry/child-view/delete-document/{id}', [AdoptionController::class, 'deldoc'])->name('delete.doc');
    Route::post('enquiry/filter/school', [AdoptionController::class, 'schooldata'])->name('filter.school');
    Route::post('childs/filter', [AdoptionController::class, 'filter'])->name('filter.childs');
    Route::post('childs/delete/docs', [AdoptionController::class, 'deleteChildFormDocs'])->name('delete.doc.child');




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

    // Assign Childs to nanny
    Route::get('staff/nanny/assign-childs/{id}', [StaffController::class, 'assignChilds'])->name('assign.childs');
    Route::post('staff/nanny/assign-childs-nanny/{id}', [StaffController::class, 'assignChildsToNanny'])->name('assign.childs.submit');
    Route::get('staff/nanny/unassing-all/{id}', [StaffController::class, 'unassignAll'])->name('unassign.all');
    Route::get('staff/nanny/unassing-child', [StaffController::class, 'unassignChild'])->name('unassign.child');


    // Enquiry Types 
    Route::resource('enquiry-types', EnquiryController::class);


    // Settings
    Route::get('settings', [SettingsController::class, 'index'])->name('settings');
    Route::post('settings/stores', [SettingsController::class, 'store'])->name('settings.store');
    Route::put('settings/update/{id}', [SettingsController::class, 'update'])->name('settings.update');
    Route::delete('settings/delete/child/{id}', [SettingsController::class, 'ChildDocDelete'])->name('settings.child.delete');
    Route::delete('settings/delete/staff/{id}', [SettingsController::class, 'ChildStaffDelete'])->name('settings.staff.delete');


    // Enquiry Forms Settings
    Route::get('settings/forms/create', [FormsController::class, 'create'])->name('enquiry.forms.create');
    Route::post('settings/forms/save', [FormsController::class, 'save'])->name('enquiry.forms.save');
    Route::get('settings/forms/edit/{id}', [FormsController::class, 'editForm'])->name('enquiry.forms.edit');
    Route::put('settings/forms/update/{id}', [FormsController::class, 'updateForm'])->name('enquiry.forms.update');
    Route::get('settings/forms/delete/{id}', [FormsController::class, 'deleteForm'])->name('enquiry.forms.delete');
    Route::post('settings/forms/status/{id}', [FormsController::class, 'FormStatus'])->name('enquiry.forms.status');





    // Schools
    Route::resource('schools', SchoolController::class);
    Route::post('find-school', [SchoolController::class, 'findSchool'])->name('find.school');

    // Schools Grades
    Route::get('grades/schools', [SchoolGradesController::class, 'index'])->name('add.grades');
    Route::post('grades/schools/add', [SchoolGradesController::class, 'store'])->name('grades.store');
    Route::get('grades/schools/edit/{id}', [SchoolGradesController::class, 'edit'])->name('grades.edit');
    Route::post('grades/schools/update/{id}', [SchoolGradesController::class, 'update'])->name('grades.update');
    Route::get('grades/schools/delete/{id}', [SchoolGradesController::class, 'delete'])->name('grades.delete');


    // Child Activities
    Route::get('child/activities', [ChildActiviesController::class, 'index'])->name('activity.index');
    Route::get('child/activities/add', [ChildActiviesController::class, 'add'])->name('activity.add');
    Route::post('child/activities/store', [ChildActiviesController::class, 'store'])->name('activity.store');
    Route::get('child/activities/edit/{id}', [ChildActiviesController::class, 'edit'])->name('activity.edit');
    Route::post('child/activities/update/{id}', [ChildActiviesController::class, 'update'])->name('activity.update');
    Route::get('/delete-image/{imageId}', [ChildActiviesController::class, 'deleteImage'])->name('delete-image');
    Route::get('/child/activities/delete/{id}', [ChildActiviesController::class, 'delete'])->name('activity.delete');
    Route::get('chid/activities/view/{id}', [ChildActiviesController::class, 'view'])->name('activity.view');
    Route::post('notifications/mark-all-as-read', [ChildActiviesController::class, 'markasread']);



    // filter child in activities
    Route::post('chid/activities/filter', [ChildActiviesController::class, 'filter'])->name('filter.activity');


    // Dormitory
    Route::get('room-list', [DormitoryController::class, 'index'])->name('room-list');
    Route::get('add/room', [DormitoryController::class, 'add'])->name('add-room');
    Route::post('add/room/store', [DormitoryController::class, 'store'])->name('room-store');
    Route::get('add/room/edit/{id}', [DormitoryController::class, 'edit'])->name('room.edit');
    Route::post('add/room/update/{id}', [DormitoryController::class, 'update'])->name('room.update');
    Route::get('add/room/delete/{id}', [DormitoryController::class, 'delete'])->name('room.delete');

    // Donation Requests of donors
    Route::get('admin/donation/requests', [DonationRequestController::class, 'index'])->name('admin.donations.req');
    Route::get('admin/donation/requests/{id}', [DonationRequestController::class, 'view'])->name('admin.donations.req.view');
    Route::get('admin/donation/requests/accept/{id}', [DonationRequestController::class, 'accept'])->name('admin.adopt.req.accept');
    Route::get('admin/donation/requests/reject/{id}', [DonationRequestController::class, 'reject'])->name('admin.adopt.req.reject');



    // Payments
    Route::get('admin/payments', [PaymentController::class, 'index'])->name('payments');



    Route::get('/password/change', [UserController::class, 'ChangePasswordForm'])->name('password.change');
    Route::put('/password/update', [UserController::class, 'updatePassword'])->name('password.update');
    //Update Profile
    Route::get('/profile/change', [UserController::class, 'UpdateProfileForm'])->name('profile.change');
    Route::put('/profile/update', [UserController::class, 'updateProfile'])->name('profile.update');
});

