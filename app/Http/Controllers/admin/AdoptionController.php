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
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;
use App\Models\child_documents;
use App\Models\City;




class AdoptionController extends Controller
{
    public function index()
    {
        $childrens = child::orderBy('id', 'desc')->paginate(10);
        return view('admin.adoptions.index', compact('childrens'));
    }


    public function add()
    {
        $years = academicyear::where('status', '1')->get();
        $lastEnquiryID = child::max('enquiry_no');
        $newEnquiryId = $lastEnquiryID ? $lastEnquiryID + 1 : 1;
        $docs = documents_title::where('document_for', 'child')->get();
        $settings = settings::first();
        $enquiry_types = enquiry_types::where('status', '1')->get();
        $cities = City::all();
        return view('admin.adoptions.add', compact('years', 'newEnquiryId', 'docs', 'settings', 'enquiry_types', 'cities'));
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
            'email' => [
                'nullable',
                'email',
                Rule::unique('users', 'email'),
                Rule::unique('staff', 'email'),
                Rule::unique('children', 'email'),
            ],
            'phone_no' => 'nullable|string',
            'current_address' => 'nullable|string',
            'permanent_address' => 'nullable|string',
            'blood_group' => 'nullable|string',
            'height' => 'nullable|numeric',
            'weight' => 'nullable|numeric',
            'age' => 'required',
            'city_id' => 'required',
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
            $destinationPath = public_path('backend/images/childs');
            $image->move($destinationPath, $uniqueName);
            $application->child_image = $uniqueName ? $uniqueName : 'null';
        }

        $application->save();


        if ($req->parent_status === 'guardian') {
            $data = new ParentModel();
            $data->child_id = $application->id;
            $data->guardian_name = $req->guardian_name;
            $data->guardian_last_name = $req->guardian_last_name;
            $data->guardian_gender = $req->guardian_gender;
            $data->guardian_email = $req->guardian_email;
            $data->guardian_occupation = $req->guardian_occupation;
            $data->guardian_phone_no = $req->guardian_phone_no;
            $data->save();
        } elseif ($req->parent_status === "mother") {

            $data = new ParentModel();
            $data->child_id = $application->id;
            $data->mother_name = $req->guardian_name;
            $data->mother_last_name = $req->guardian_last_name;
            $data->mother_email = $req->mother_email;
            $data->mother_occupation = $req->mother_occupation;
            $data->mother_phone_no = $req->mother_phone_no;
            $data->save();

        } elseif ($req->parent_status === "father") {

            $data = new ParentModel();
            $data->child_id = $application->id;
            $data->father_name = $req->father_name;
            $data->father_last_name = $req->father_last_name;
            $data->father_email = $req->father_email;
            $data->father_occupation = $req->father_occupation;
            $data->father_phone_no = $req->father_phone_no;
            $data->save();
        } else {
            $data = new ParentModel();
            $data->child_id = $application->id;
            $data->save();
        }


        $titles = $req->input('document_titles');
        $documents = $req->file('document_names');

        foreach ($titles as $index => $title) {
            if (isset($documents[$index])) {
                $uniqueName = uniqid() . '.' . $documents[$index]->getClientOriginalExtension();

                $uploadPath = public_path('backend/documents/childs/');

                if (!file_exists($uploadPath)) {
                    mkdir($uploadPath, 0777, true);
                }

                $documents[$index]->move($uploadPath, $uniqueName);

                child_documents::create([
                    'child_id' => $application->id,
                    'title' => $title,
                    'name' => $uniqueName,
                ]);
            } else {
                child_documents::create([
                    'child_id' => $application->id,
                    'title' => $title,
                    'name' => null,
                ]);
            }
        }

        if ($application->save()) {
            return redirect()->route('adoptions')->with('success', 'Inquiry Added !');
        }

    }


    public function studentView($id)
    {
        $child = child::where('id', $id)->first();
        $parents = ParentModel::where('child_id', $child->id)->first();
        $documents = child_documents::where('child_id', $child->id)->whereNotNull('name')->get();
        return view('admin.adoptions.view', compact('child', 'parents', 'documents'));
    }

    public function studentEdit($id)
    {
        $cities = City::all();
        $years = academicyear::all();
        $settings = settings::first();
        $enquiry_types = enquiry_types::where('status', '1')->get();
        $child = child::where('id', $id)->first();
        $parents = ParentModel::where('child_id', $child->id)->first();
        $documents = child_documents::where('child_id', $child->id)->get();
        return view('admin.adoptions.edit', compact('child', 'cities', 'settings', 'parents', 'documents', 'years', 'enquiry_types'));

    }


    public function update(Request $req, $id)
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
            'email' => [
                'nullable',
                'email',
                Rule::unique('children')->ignore($id),  // Check 'children' table, excluding current record
                Rule::unique('staff')->ignore($id),     // Check 'staff' table, excluding current record
                Rule::unique('users')->ignore($id),     // Check 'users' table, excluding current record
            ],
            'phone_no' => 'nullable|string',
            'current_address' => 'nullable|string',
            'permanent_address' => 'nullable|string',
            'blood_group' => 'nullable|string',
            'height' => 'nullable|numeric',
            'weight' => 'nullable|numeric',
            'age' => 'required',
            'city_id' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->route('enquiry.edit', $id)
                ->withErrors($validator)
                ->withInput();
        }

        $application = child::findOrFail($id);
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

        if ($image = $req->file('child_image')) {
            $uniqueName = uniqid() . '.' . $image->getClientOriginalExtension();
            $destinationPath = public_path('backend/images/childs');
            $image->move($destinationPath, $uniqueName);
            $application->child_image = $uniqueName;
        }

        $application->save();

        $parent = ParentModel::where('child_id', $application->id)->first();

        if (!$parent) {
            $parent = new ParentModel();
            $parent->child_id = $application->id;
        }

        if ($req->parent_status === 'guardian') {
            $parent->guardian_name = $req->guardian_name;
            $parent->guardian_last_name = $req->guardian_last_name;
            $parent->guardian_gender = $req->guardian_gender;
            $parent->guardian_email = $req->guardian_email;
            $parent->guardian_occupation = $req->guardian_occupation;
            $parent->guardian_phone_no = $req->guardian_phone_no;
        } elseif ($req->parent_status === 'mother') {
            $parent->mother_name = $req->guardian_name;
            $parent->mother_last_name = $req->guardian_last_name;
            $parent->mother_email = $req->mother_email;
            $parent->mother_occupation = $req->mother_occupation;
            $parent->mother_phone_no = $req->mother_phone_no;
        } elseif ($req->parent_status === 'father') {
            $parent->father_name = $req->father_name;
            $parent->father_last_name = $req->father_last_name;
            $parent->father_email = $req->father_email;
            $parent->father_occupation = $req->father_occupation;
            $parent->father_phone_no = $req->father_phone_no;
        }

        $parent->save();

        if ($req->has('document_titles')) {
            $titles = $req->input('document_titles');
            $documents = $req->file('document_names');

            foreach ($titles as $index => $title) {
                if (isset($documents[$index])) {
                    $uniqueName = uniqid() . '.' . $documents[$index]->getClientOriginalExtension();

                    $uploadPath = public_path('backend/documents/childs/');

                    if (!file_exists($uploadPath)) {
                        mkdir($uploadPath, 0777, true);
                    }

                    $documents[$index]->move($uploadPath, $uniqueName);

                    child_documents::where('title', $title)->update([
                        'name' => $uniqueName
                    ]);
                }
            }
        }
        return redirect()->route('adoptions')->with('success', 'Inquiry Updated!');
    }


    public function studentDelete($id)
    {
        $student = child::find($id);
        $student->delete();
        return redirect()->route('adoptions')->with('success', 'child Deleted Successfully');
    }


    public function deldoc($id)
    {
        $documents = child_documents::findOrFail($id);
        $documents->name = Null;
        $documents->update();

        return response()->json([
            'success' => 'Document has deleted !',
        ]);
    }


}
