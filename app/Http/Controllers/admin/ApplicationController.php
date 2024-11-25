<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\academicyear;
use App\Models\student;
use App\Models\ParentModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use App\Models\StudentDocuments;




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
        $application->gender = $req->gender;
        $application->dob = $req->dob;
        $application->religion = $req->religion;
        $application->email = $req->email;
        $application->phone_no = $req->phone_no;
        $application->current_address = $req->current_address;
        $application->permanent_address = $req->permanent_address;
        $application->blood_group = $req->blood_group;
        $application->height = $req->height;
        $application->weight = $req->weight;
        if ($image = $req->file('student_image')) {
            $uniqueName = uniqid() . '.' . $image->getClientOriginalExtension();
            $destinationPath = public_path('backend/images/students');
            $image->move($destinationPath, $uniqueName);
            $application->student_image = $uniqueName ? $uniqueName : 'null';
        }

        $application->save();


        if ($req->parent_status === 'guardian') {
            $data = new ParentModel();
            $data->student_id = $application->id;
            $data->guardian_name = $req->guardian_name;
            $data->guardian_last_name = $req->guardian_last_name;
            $data->guardian_gender = $req->guardian_gender;
            $data->guardian_email = $req->guardian_email;
            $data->guardian_occupation = $req->guardian_occupation;
            $data->guardian_phone_no = $req->guardian_phone_no;
            $data->save();
        } elseif ($req->parent_status === "mother") {

            $data = new ParentModel();
            $data->student_id = $application->id;
            $data->mother_name = $req->guardian_name;
            $data->mother_last_name = $req->guardian_last_name;
            $data->mother_email = $req->mother_email;
            $data->mother_occupation = $req->mother_occupation;
            $data->mother_phone_no = $req->mother_phone_no;
            $data->save();

        } elseif ($req->parent_status === "father") {

            $data = new ParentModel();
            $data->student_id = $application->id;
            $data->father_name = $req->father_name;
            $data->father_last_name = $req->father_last_name;
            $data->father_email = $req->father_email;
            $data->father_occupation = $req->father_occupation;
            $data->father_phone_no = $req->father_phone_no;
            $data->save();
        } else {
            $data = new ParentModel();
            $data->student_id = $application->id;
            $data->save();
        }


        // Documents start 
        $titles = $req->input('document_titles'); // Document titles from the request
        $documents = $req->file('document_names'); // Uploaded files from the request

        foreach ($titles as $index => $title) {
            if (isset($documents[$index])) {
                // Generate a unique name for the file with its original extension
                $uniqueName = uniqid() . '.' . $documents[$index]->getClientOriginalExtension();

                // Define the destination folder
                $uploadPath = public_path('backend/documents');

                // Ensure the directory exists
                if (!file_exists($uploadPath)) {
                    mkdir($uploadPath, 0777, true);
                }

                // Move the uploaded file to the destination folder
                $documents[$index]->move($uploadPath, $uniqueName);

                // Save the document details to the database
                StudentDocuments::create([
                    'student_id' => $application->id,
                    'title' => $title,
                    'name' => $uniqueName, // Path relative to the public directory
                ]);
            }
        }
        // Documents End

        if ($application->save()) {
            return redirect()->route('applications')->with('success', 'Student Added !');
        }

    }


    public function studentView($id)
    {
        $student = student::where('id', $id)->first();
        $parents = ParentModel::where('student_id', $student->id)->first();
        $documents = StudentDocuments::where('student_id' , $student->id)->get();
        return view('admin.applications.student_view', compact('student' , 'parents' , 'documents'));
    }

}
