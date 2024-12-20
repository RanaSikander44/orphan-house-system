<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\student;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Menu;


class DashboardController extends Controller
{
    public function dashboard()
    {
        $users_count = user::count(); 
        $students = student::count(); 
        return view('admin.dashboard' , compact('users_count' , 'students'));
    }
}
