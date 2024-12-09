<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\academicyear;
use App\Models\documents_title;
use App\Models\enquiry_types;
use App\Models\settings;
use App\Models\child;
use App\Models\student;
use App\Models\ParentModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use App\Models\StudentDocuments;




class AdoptionController extends Controller
{
    public function index()
    {
        $childrens = child::orderBy('id', 'desc')->paginate(10);
        return view('admin.adoptions.index', compact('childrens'));
    }


    public function add()
    {
        $years = academicyear::all();
        $lastEnquiryID = child::max('enquiry_no');
        $newEnquiryId = $lastEnquiryID ? $lastEnquiryID + 1 : 1;
        $docs = documents_title::where('document_for', 'child')->get();
        $settings = settings::first();
        $enquiry_types = enquiry_types::where('status', '1')->get();
        return view('admin.adoptions.add', compact('years', 'newEnquiryId', 'docs', 'settings', 'enquiry_types'));
    }

    public function store(Request $req)
    {



        $validator = Validator::make($req->all(), [
            'enquiry_type_id' => 'required',
            'compaign_id' => 'required',
            'enquiry_no' => 'required',
            'source_of_information' => 'required',
            'status_of_adoption' => 'required',
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'caste' => 'nullable|string',
            'adoption_date' => 'required|date',
            'gender' => 'required|string|in:Male,Female,Others',
            'dob' => 'required|date',
            'religion' => 'nullable|string',
            'email' => 'nullable|email|unique:children,email',
            'phone_no' => 'nullable|string',
            'current_address' => 'nullable|string',
            'permanent_address' => 'nullable|string',
            'blood_group' => 'nullable|string',
            'height' => 'nullable|numeric',
            'weight' => 'nullable|numeric',
            'age' => 'required',
            'city_id' => 'nullable|integer',
        ]);


        if ($validator->fails()) {
            return redirect()->route('enquiry.add')
                ->withErrors($validator)
                ->withInput();
        }


        $application = new child();
        $application->campaign_id = $req->compaign_id;
        $application->enquiry_id = $req->enquiry_type_id;
        $application->enquiry_no = $req->enquiry_no;
        $application->source_of_information = $req->source_of_information;
        $application->status_of_adoption = $req->status_of_adoption;
        $application->adoption_date = $req->adoption_date;
        $application->first_name = $req->first_name;
        $application->last_name = $req->last_name;
        $application->gender = $req->gender;
        $application->dob = $req->dob;
        $application->age = $req->age;
        $application->religion = $req->religion;
        $application->caste = $req->caste;
        $application->email = $req->email;
        $application->phone_no = $req->phone_no;
        $application->current_address = $req->current_address;
        $application->permanent_address = $req->permanent_address;
        $application->blood_group = $req->blood_group;
        $application->height = $req->height;
        $application->weight = $req->weight;
        $application->city_id = $req->city_id;
        $application->age = $req->age;

        if ($image = $req->file('child_image')) {
            $uniqueName = uniqid() . '.' . $image->getClientOriginalExtension();
            $destinationPath = public_path('backend/images/students');
            $image->move($destinationPath, $uniqueName);
            $application->child_image = $uniqueName ? $uniqueName : 'null';
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


        $titles = $req->input('document_titles');
        $documents = $req->file('document_names');

        foreach ($titles as $index => $title) {
            if (isset($documents[$index])) {
                $uniqueName = uniqid() . '.' . $documents[$index]->getClientOriginalExtension();

                $uploadPath = public_path('backend/documents');

                if (!file_exists($uploadPath)) {
                    mkdir($uploadPath, 0777, true);
                }

                $documents[$index]->move($uploadPath, $uniqueName);

                StudentDocuments::create([
                    'student_id' => $application->id,
                    'title' => $title,
                    'name' => $uniqueName,
                ]);
            } else {
                StudentDocuments::create([
                    'student_id' => $application->id,
                    'title' => $title,
                    'name' => null,
                ]);
            }
        }

        if ($application->save()) {
            return redirect()->route('adoptions')->with('success', 'Student Added !');
        }

    }


    public function studentView($id)
    {
        $student = student::where('id', $id)->first();
        $parents = ParentModel::where('student_id', $student->id)->first();
        $documents = StudentDocuments::where('student_id', $student->id)->whereNotNull('name')->get();
        return view('admin.adoptions.student_view', compact('student', 'parents', 'documents'));
    }

    public function studentEdit($id)
    {

        $years = academicyear::all();
        $lastAdmissionNumber = Student::max('admission_no');
        $newAdmissionNumber = $lastAdmissionNumber ? $lastAdmissionNumber + 1 : 1;
        $student = student::where('id', $id)->first();
        $parents = ParentModel::where('student_id', $student->id)->first();
        $documents = StudentDocuments::where('student_id', $student->id)->get();
        return view('admin.adoptions.student_edit', compact('student', 'parents', 'documents', 'years', 'newAdmissionNumber'));

    }

    public function studentUpdate(Request $req, $id)
    {
        $validator = Validator::make($req->all(), [
            'first_name' => 'nullable|string',
            'last_name' => 'nullable|string',
            'year_id' => 'nullable|integer',
            'admission_date' => 'nullable|date',
            'caste' => 'nullable|string',
            'admission_no' => 'nullable|string',
            'gender' => 'nullable|string',
            'dob' => 'nullable|date',
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
            return redirect()->route('application.edit', ['id' => $id])
                ->withErrors($validator)
                ->withInput();
        }

        $application = Student::findOrFail($id);

        $fieldsToUpdate = [
            'first_name',
            'last_name',
            'year_id',
            'admission_date',
            'caste',
            'admission_no',
            'gender',
            'dob',
            'religion',
            'email',
            'phone_no',
            'current_address',
            'permanent_address',
            'blood_group',
            'height',
            'weight'
        ];

        foreach ($fieldsToUpdate as $field) {
            if ($req->filled($field)) {
                $application->$field = $req->$field;
            }
        }

        if ($image = $req->file('student_image')) {
            $uniqueName = uniqid() . '.' . $image->getClientOriginalExtension();
            $destinationPath = public_path('backend/images/students');
            $image->move($destinationPath, $uniqueName);
            $application->student_image = $uniqueName;
        }

        $application->save();

        $data = ParentModel::where('student_id', $id)->firstOrNew();

        if ($req->parent_status === 'guardian') {
            $data->guardian_name = $req->guardian_name ?? $data->guardian_name;
            $data->guardian_last_name = $req->guardian_last_name ?? $data->guardian_last_name;
            $data->guardian_gender = $req->guardian_gender ?? $data->guardian_gender;
            $data->guardian_email = $req->guardian_email ?? $data->guardian_email;
            $data->guardian_occupation = $req->guardian_occupation ?? $data->guardian_occupation;
            $data->guardian_phone_no = $req->guardian_phone_no ?? $data->guardian_phone_no;
        } elseif ($req->parent_status === 'mother') {
            $data->mother_name = $req->mother_name ?? $data->mother_name;
            $data->mother_last_name = $req->mother_last_name ?? $data->mother_last_name;
            $data->mother_email = $req->mother_email ?? $data->mother_email;
            $data->mother_occupation = $req->mother_occupation ?? $data->mother_occupation;
            $data->mother_phone_no = $req->mother_phone_no ?? $data->mother_phone_no;
        } elseif ($req->parent_status === 'father') {
            $data->father_name = $req->father_name ?? $data->father_name;
            $data->father_last_name = $req->father_last_name ?? $data->father_last_name;
            $data->father_email = $req->father_email ?? $data->father_email;
            $data->father_occupation = $req->father_occupation ?? $data->father_occupation;
            $data->father_phone_no = $req->father_phone_no ?? $data->father_phone_no;
        }
        $data->student_id = $application->id;
        $data->save();



        if ($req->has('document_titles')) {
            $titles = $req->input('document_titles');
            $documents = $req->file('document_names');

            foreach ($titles as $index => $title) {
                if (isset($documents[$index])) {
                    $uniqueName = uniqid() . '.' . $documents[$index]->getClientOriginalExtension();

                    $uploadPath = public_path('backend/documents');

                    if (!file_exists($uploadPath)) {
                        mkdir($uploadPath, 0777, true);
                    }

                    $documents[$index]->move($uploadPath, $uniqueName);

                    StudentDocuments::where('title', $title)->update([
                        'name' => $uniqueName
                    ]);
                }
            }
        }


        return redirect()->route('adoptions')->with('success', 'Student details updated successfully.');
    }


    public function studentDelete($id)
    {
        $student = student::find($id);
        $student->name = 'null';
        $student->save();
        return redirect()->route('adoptions')->with('success', 'Student Deleted Successfully');
    }


    public function deldoc($id)
    {
        $documents = StudentDocuments::findOrFail($id);
        $documents->name = Null;
        $documents->update();

        return response()->json([
            'success' => 'Document has deleted !',
        ]);
    }


}
