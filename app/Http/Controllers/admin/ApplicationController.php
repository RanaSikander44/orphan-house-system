<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\academicyear;
use App\Models\student;
use Illuminate\Http\Request;


class ApplicationController extends Controller
{
    public function index()
    {
        $students = Student::all();
        return view('admin.applications.index' , compact('students'));
    }


    public function add()
    {
        $years = academicyear::all();
        $lastAdmissionNumber = Student::max('admission_no');
        $newAdmissionNumber = $lastAdmissionNumber ? $lastAdmissionNumber + 1 : 1;
        return view('admin.applications.add', compact('years', 'newAdmissionNumber'));
    }
}
