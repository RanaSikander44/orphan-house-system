<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\academicyear;
use App\Models\student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;



class ApplicationController extends Controller
{
    public function index()
    {
        $students = Student::orderBy('id', 'desc')->paginate(10);
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

        $validator = Validator::make($req->all(), [
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'year_id' => 'required|integer',
            'admission_date' => 'required|date',
            'caste' => 'nullable|string',
            'admission_no' => 'required|string',
            'gender' => 'required|string',
            'dob' => 'required|date',
            'religion' => 'nullable|string',
            'email' => 'nullable|email',
            'phone_no' => 'nullable|string',
            'current_address' => 'nullable|string',
            'permanent_address' => 'nullable|string',
            'blood_group' => 'nullable|string',
            'height' => 'nullable|numeric',
            'weight' => 'nullable|numeric',
        ]);

        if ($validator->fails()) {
            return redirect()->route('application.add')
                ->withErrors($validator)
                ->withInput();
        }

        //  dd($req->all());
        $application = new Student();
        $application->first_name = $req->first_name;
        $application->last_name = $req->last_name;
        $application->year_id = $req->year_id;
        $application->admission_date = $req->admission_date;
        $application->caste = $req->caste;
        $application->admission_no = $req->admission_no;
        $application->gender = $req->admission_no;
        $application->dob = $req->dob;
        $application->religion = $req->religion;
        $application->email = $req->email;
        $application->phone_no = $req->phone_no;
        $application->current_address = $req->current_address;
        $application->permanent_address = $req->permanent_address;
        $application->blood_group = $req->blood_group;
        $application->height = $req->height;
        $application->weight = $req->weight;
        $application->save();

        if ($application->save()) {
            return redirect()->route('applications')->with('success', 'Student Added !');
        }

    }

}
