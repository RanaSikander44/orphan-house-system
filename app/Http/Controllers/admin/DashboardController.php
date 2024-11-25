<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\student;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function dashboard()
    {
        $total_students = student::count();
        return view('admin.dashboard', compact('total_students'));
    }
}
