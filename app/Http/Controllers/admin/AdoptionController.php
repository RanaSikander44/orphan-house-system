<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\ChildFormData;
use App\Models\documents_title;
use App\Models\DocumentTitleChild;
use App\Models\Dormitory;
use App\Models\enquiry_types;
use App\Models\enquiryFormData;
use App\Models\enquiryForms;
use App\Models\nannyChilds;
use App\Models\school_grades;
use App\Models\settings;
use App\Models\child;
use App\Models\student;
use App\Models\ParentModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;
use App\Models\child_documents;
use App\Models\Schools;
use App\Models\City;
use App\Models\Staff;
use App\Models\User;
use App\Models\Role;


class AdoptionController extends Controller
{
    public function index()
    {

        $roles = Role::where('name', 'Nanny')->pluck('id');
        $nannies = User::whereIn('role_id', $roles)->get();
        $schools = Schools::all();

        $childrens = child::orderBy('id', 'desc')->where('is_approved', '0')->paginate(10);
        return view('admin.adoptions.index', compact('childrens', 'roles', 'nannies', 'schools'));
    }


    public function approvedChilds()
    {
        $roles = Role::where('name', 'Nanny')->pluck('id');
        $nannies = User::whereIn('role_id', $roles)->get();
        $schools = Schools::all();

        $childrens = child::orderBy('id', 'desc')->where('is_approved', '1')->paginate(10);
        return view('admin.adoptions.childList', compact('childrens', 'roles', 'nannies', 'schools'));

    }


    public function approveInquiery($id)
    {
        $child = child::find($id);
        $child->is_approved = 1;
        $child->update();


        return redirect()->route('adoptions')->with('success', 'Inquiry Approved !');
    }


    public function add()
    {
        $lastEnquiryID = child::max('enquiry_no');
        $newEnquiryId = $lastEnquiryID ? $lastEnquiryID + 1 : 1;
        $docs = DocumentTitleChild::all();
        $settings = settings::first();
        $enquiry_types = enquiry_types::where('status', '1')->get();
        $schools = Schools::get();
        $cities = City::all();
        $rooms = Dormitory::all();
        $forms = enquiryForms::where('status', '1')->get();
        $enquiryFormsIDs = enquiryForms::pluck('id');
        $enquiryFormsData = enquiryFormData::whereIn('form_id', $enquiryFormsIDs)->orderBy('order')->get();
        return view('admin.adoptions.add', compact('newEnquiryId', 'docs', 'settings', 'enquiry_types', 'cities', 'schools', 'rooms', 'forms', 'enquiryFormsData'));
    }

    public function store(Request $req)
    {

        $validator = Validator::make($req->all(), [
            'enquiry_type_id' => 'required',
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
                Rule::unique('children', 'email'),
                Rule::unique('users', 'email'),
            ],
            'phone_no' => 'nullable|string',
            'current_address' => 'nullable|string',
            'permanent_address' => 'nullable|string',
            'blood_group' => 'nullable|string',
            'height' => 'nullable|numeric',
            'weight' => 'nullable|numeric',
            'age' => 'required',
            'city_id' => 'required',
            'school_id' => 'required',
            'room_id' => 'required',
            'grade_id' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->route('enquiry.add')
                ->withErrors($validator)
                ->withInput();
        }


        $application = new child();
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
        $application->school_id = $req->school_id;
        if ($req->has('room_id')) {
            // Count the number of children currently assigned to the room
            $totalChildInRoom = child::where('room_id', $req->room_id)->count();

            // Fetch the dormitory details for the given room ID
            $roomDetails = Dormitory::find($req->room_id);

            // Check if the room exists and has a valid max number of beds
            if ($roomDetails && $totalChildInRoom >= $roomDetails->max_number_bed) {
                return redirect()->back()->withInput()->with('error', 'This room is full. Please choose a different room.');
            } else {
                $application->room_id = $req->room_id;
            }
        }

        $application->grade_id = $req->grade_id;

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


        if ($req->has('forms')) {
            foreach ($req->forms as $form) {
                foreach ($form['inputs'] as $input_name => $input_value) {
                    $formsData = new ChildFormData();
                    $formsData->form_id = $form['form_id'];
                    $formsData->child_id = $application->id;

                    // Extract the part of the input_name after the last underscore
                    $lastUnderscorePos = strrpos($input_name, '_');
                    $inputId = $lastUnderscorePos !== false ? substr($input_name, $lastUnderscorePos + 1) : $input_name;
                    $formsData->input_id = $inputId;

                    // Check if the input value is an uploaded file
                    if ($input_value instanceof \Illuminate\Http\UploadedFile) {
                        $uniqueName = uniqid() . '.' . $input_value->getClientOriginalExtension();
                        $destinationPath = public_path('backend/documents/childs/dynamicFields');
                        $input_value->move($destinationPath, $uniqueName);
                        $formsData->input_value = 'backend/documents/childs/dynamicFields/' . $uniqueName;
                    } else {
                        // Handle non-file inputs
                        if (is_array($input_value)) {
                            $input_value = json_encode($input_value); // Convert array to JSON string
                        }
                        $formsData->input_value = $input_value;
                    }

                    $formsData->save();
                }
            }
        }



        // child dynamic forms data saving here 

        // if ($req->has('forms')) {
        //     foreach ($req->forms as $form) {
        //         foreach ($form['inputs'] as $input_name => $input_value) {
        //             $formsData = new ChildFormData();
        //             $formsData->form_id = $form['form_id'];
        //             $formsData->child_id = $application->id;

        //             // Extract the part of the input_name after the last underscore
        //             $lastUnderscorePos = strrpos($input_name, '_');
        //             $inputId = $lastUnderscorePos !== false ? substr($input_name, $lastUnderscorePos + 1) : $input_name;
        //             $formsData->input_id = $inputId;

        //             // Handle input_value
        //             if (is_array($input_value)) {
        //                 $input_value = json_encode($input_value); // Convert array to JSON string
        //             }
        //             $formsData->input_value = $input_value;

        //             $formsData->save();
        //         }
        //     }

        // }


        if ($req->document_titles && $req->document_names) {

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

        $nanny = nannyChilds::where('child_id', $child->id)->first();

        if ($nanny) {
            $nannyID = staff::where('id', $nanny->nanny_id)->first();

            if ($nannyID) {
                $nannyDetails = User::where('id', $nannyID->user_id)->first();
            } else {
                $nannyDetails = null;
            }
        } else {
            $nannyDetails = null;
        }


        $forms = enquiryForms::where('status', '1')->get();
        $formsData = ChildFormData::where('child_id', $id)->get();
        return view('admin.adoptions.view', compact('child', 'parents', 'documents', 'nannyDetails', 'formsData', 'forms'));
    }

    public function studentEdit($id)
    {
        $cities = City::all();
        // $years = academicyear::all();
        $settings = settings::first();
        $schools = Schools::get();
        $enquiry_types = enquiry_types::where('status', '1')->get();
        $child = child::where('id', $id)->first();
        $parents = ParentModel::where('child_id', $child->id)->first();
        $documents = child_documents::where('child_id', $child->id)->get();
        $rooms = Dormitory::all();
        $grades = school_grades::all();

        $forms = enquiryForms::where('status', '1')->get();

        // Fetch inputs for forms
        $formData = EnquiryFormData::whereIn('form_id', $forms->pluck('id'))->get();

        // Fetch saved values for the specific child
        $childInputs = ChildFormData::where('child_id', $id)->get()->keyBy('input_id');

        return view('admin.adoptions.edit', compact('child', 'cities', 'settings', 'parents', 'documents', 'schools', 'enquiry_types', 'rooms', 'grades', 'forms', 'formData', 'childInputs'));
    }


    public function update(Request $req, $id)
    {
        $validator = Validator::make($req->all(), [
            'enquiry_type_id' => 'required',
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
                Rule::unique('children')->ignore($id),
                Rule::unique('Users', 'email'),
            ],
            'phone_no' => 'nullable|string',
            'current_address' => 'nullable|string',
            'permanent_address' => 'nullable|string',
            'blood_group' => 'nullable|string',
            'height' => 'nullable|numeric',
            'weight' => 'nullable|numeric',
            'age' => 'required',
            'city_id' => 'required',
            'school_id' => 'required',
            'room_id' => 'required',
            'grade_id' => 'required'
        ]);

        if ($validator->fails()) {
            return redirect()->route('enquiry.edit', $id)
                ->withErrors($validator)
                ->withInput();
        }

        $application = child::findOrFail($id);
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
        $application->school_id = $req->school_id;
        $application->room_id = $req->room_id;
        $application->grade_id = $req->grade_id;

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


        if ($req->has('forms')) {
            foreach ($req->forms as $form) {
                // Ensure 'inputs' key exists in the form array
                if (isset($form['inputs']) && is_array($form['inputs'])) {
                    foreach ($form['inputs'] as $input_name => $input_value) {
                        // Extract the input ID from the name
                        $lastUnderscorePos = strrpos($input_name, '_');
                        $inputId = $lastUnderscorePos !== false ? substr($input_name, $lastUnderscorePos + 1) : $input_name;

                        // Check if an entry already exists for this input ID and child
                        $formsData = ChildFormData::where('form_id', $form['form_id'])
                            ->where('child_id', $application->id)
                            ->where('input_id', $inputId)
                            ->first();

                        if (!$formsData) {
                            $formsData = new ChildFormData(); // Create a new instance if not found
                            $formsData->form_id = $form['form_id'];
                            $formsData->child_id = $application->id;
                            $formsData->input_id = $inputId;
                        }

                        // Handle file uploads
                        if ($input_value instanceof \Illuminate\Http\UploadedFile) {
                            $uniqueName = uniqid() . '.' . $input_value->getClientOriginalExtension();
                            $destinationPath = public_path('backend/documents/childs/dynamicFields');
                            $input_value->move($destinationPath, $uniqueName);
                            $formsData->input_value = 'backend/documents/childs/dynamicFields/' . $uniqueName;
                        } else {
                            // Handle non-file inputs
                            if (is_array($input_value)) {
                                $input_value = json_encode($input_value); // Convert array to JSON string
                            }
                            $formsData->input_value = $input_value;
                        }

                        $formsData->save(); // Save the updated or new record
                    }
                } else {
                    // Optionally, log or handle forms without 'inputs' key
                    \Log::warning('Form missing "inputs" key', ['form' => $form]);
                }
            }
        }


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

                    child_documents::where('title', $title)->where('child_id', $id)->update([
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




    public function filter(Request $req)
    {
        // Helper function to map child data consistently
        $mapChildData = function ($child) {
            return [
                'id' => $child->id ?? null,
                'enquiry_no' => $child->enquiry_no ?? 'N/A',
                'first_name' => $child->first_name ?? 'N/A',
                'last_name' => $child->last_name ?? 'N/A',
                'adoption_date' => $child->adoption_date ?? null,
                'status_of_adoption' => $child->status_of_adoption ?? 'N/A',
                'age' => $child->age ?? 'Unknown Age',
                'school_name' => $child->school->name ?? 'No School',
            ];
        };

        // Initialize the result collection
        $result = collect();

        // Case: Both `nanny_id` and `school_id` are provided
        if ($req->nanny_id !== 'null' && $req->school_id !== 'null') {
            $nanny = Staff::where('user_id', $req->nanny_id)->first();

            if ($nanny) {
                $children = NannyChilds::with(['child.school',])
                    ->where('nanny_id', $nanny->id)
                    ->whereHas('child', function ($query) use ($req) {
                        $query->where('school_id', $req->school_id);
                    })
                    ->get();

                $result = $children->map(fn($nannyChild) => $mapChildData($nannyChild->child));
            }
        }

        // Case: Only `nanny_id` is provided
        if ($req->nanny_id !== 'null' && $req->school_id === 'null') {
            $nanny = Staff::where('user_id', $req->nanny_id)->first();

            if ($nanny) {
                $children = NannyChilds::with(['child.school'])
                    ->where('nanny_id', $nanny->id)
                    ->get();

                $result = $children->map(fn($nannyChild) => $mapChildData($nannyChild->child));
            }
        }

        // Case: Only `school_id` is provided
        if ($req->school_id !== 'null' && $req->nanny_id === 'null') {
            $children = Child::with(['school'])
                ->where('school_id', $req->school_id)
                ->get();

            $result = $children->map(fn($child) => $mapChildData($child));
        }

        // Case: No filters or both filters are null
        if ($req->nanny_id === 'null' && $req->school_id === 'null') {
            $children = Child::with(['school'])->get();
            $result = $children->map(fn($child) => $mapChildData($child));
        }

        // Return filtered data or all data if no filters matched
        return response()->json($result);
    }











}
