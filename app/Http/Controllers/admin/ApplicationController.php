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
        $students = Student::orderBy('id' , 'desc'  )->paginate(10);
        return view('admin.applications.index', compact('students'));
    }


    public function add()
    {
        $years = academicyear::all();
        $lastAdmissionNumber = Student::max('admission_no');
        $newAdmissionNumber = $lastAdmissionNumber ? $lastAdmissionNumber + 1 : 1;
        return view('admin.applications.add', compact('years', 'newAdmissionNumber'));
    }

    public function store(Request $req)
    {
        //  dd($req->all());
         $application =  new Student();
         $application->first_name =  $req->first_name;
         $application->last_name =  $req->last_name;
         $application->year_id =  $req->year_id;
         $application->admission_date =  $req->admission_date;
         $application->caste =  $req->caste;
         $application->admission_no =  $req->admission_no;
         $application->gender =  $req->admission_no;
         $application->dob =  $req->dob;
         $application->religion =  $req->religion;
         $application->email =  $req->email;
         $application->phone_no =  $req->phone_no;
         $application->current_address =  $req->current_address;
         $application->permanent_address =  $req->permanent_address;
         $application->blood_group =  $req->blood_group;
         $application->height =  $req->height;
         $application->weight =  $req->weight;

        if($application->save()){
            return redirect()->route('applications')->with('success' , 'Student Added !');
        }
        
    }

}
