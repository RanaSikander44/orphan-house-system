<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\documents_title;
use App\Models\StaffDocuments;
use Illuminate\Http\Request;
use App\Models\Staff;
use App\Models\Role;
use Illuminate\Support\Facades\Validator;
use League\CommonMark\Node\Block\Document;

class StaffController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $staff = Staff::paginate(10);
        return view('admin.staff.index', compact('staff'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $roles = Role::where('name', '!=', 'Admin')->get();
        $staff_docs = documents_title::where('document_for', 'staff')->get();
        return view('admin.staff.add', compact('roles', 'staff_docs'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'first_name' => 'required|string',
            'last_name' => 'required',
            'dob' => 'required',
            'gender' => 'required|string',
            'email' => 'required|email|unique:staff,email', // Ensure correct table and column are specified
            'religion' => 'required|string',
            'role_id' => 'required|integer',
            'phone_no' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->route('staff.create')
                ->withErrors($validator)
                ->withInput();
        }



        //  dd($req->all());
        $Staff = new Staff();
        $Staff->first_name = $request->first_name;
        $Staff->last_name = $request->last_name;
        $Staff->dob = $request->dob;
        $Staff->gender = $request->gender;
        $Staff->email = $request->email;
        $Staff->religion = $request->religion;
        $Staff->role_id = $request->role_id;
        $Staff->phone_no = $request->phone_no;
        $Staff->caste = $request->caste;
        $Staff->current_address = $request->current_address;
        $Staff->permanent_address = $request->permanent_address;



        if ($image = $request->file('staff_image')) {
            $uniqueName = uniqid() . '.' . $image->getClientOriginalExtension();
            $destinationPath = public_path('backend/images/staff');
            $image->move($destinationPath, $uniqueName);
            $Staff->staff_image = $uniqueName ? $uniqueName : 'null';
        }

        $Staff->save();


        $titles = $request->input('document_titles');
        $documents = $request->file('document_names');

        foreach ($titles as $index => $title) {
            if (isset($documents[$index])) {
                $uniqueName = uniqid() . '.' . $documents[$index]->getClientOriginalExtension();

                $uploadPath = public_path('backend/documents');

                if (!file_exists($uploadPath)) {
                    mkdir($uploadPath, 0777, true);
                }

                $documents[$index]->move($uploadPath, $uniqueName);

                StaffDocuments::create([
                    'staff_id' => $Staff->id,
                    'title' => $title,
                    'name' => $uniqueName,
                ]);
            } else {
                StaffDocuments::create([
                    'staff_id' => $Staff->id,
                    'title' => $title,
                    'name' => null,
                ]);
            }
        }

        if ($Staff->save()) {
            return redirect()->route('staff.index')->with('success', 'Staff Added !');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $roles = Role::where('name', '!=', 'Admin')->get();
        $staff_docs = documents_title::where('document_for', 'staff')->get();
        $edit = Staff::where('id', $id)->first();
        $documents = StaffDocuments::where('staff_id' , $id)->get();
        return view('admin.staff.edit', compact('edit' , 'roles' , 'staff_docs' , 'documents'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
