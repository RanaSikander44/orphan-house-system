<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\child;
use App\Models\documents_title;
use App\Models\nannyChilds;
use App\Models\StaffDocuments;
use App\Models\student;
use Illuminate\Http\Request;
use App\Models\Staff;
use App\Models\Schools;
use App\Models\User;
// use App\Models\Role;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use League\CommonMark\Node\Block\Document;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;



class StaffController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $staff = staff::paginate(10);
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
            'age' => 'required',
            'gender' => 'required|string',
            'email' => [
                'required',
                'email',
                Rule::unique('users', 'email'),
            ],
            'password' => 'required|min:8',
            'religion' => 'required|string',
            'role_id' => 'required|integer',
            'phone_no' => 'required',
            'emergency_contact_number' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->route('staff.create')
                ->withErrors($validator)
                ->withInput();
        }

        // Create user
        $user = new User();
        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->email = $request->email;

        $user->password = $request->password; 

        $user->role_id = $request->role_id;
        $user->save();

        // Assign role using Spatie
        $role = Role::findById($request->role_id);
        $user->assignRole($role->name); 

        // Create staff record
        $Staff = new Staff();
        $Staff->user_id = $user->id;
        $Staff->dob = $request->dob;
        $Staff->age = $request->age;
        $Staff->gender = $request->gender;
        $Staff->religion = $request->religion;
        $Staff->phone_no = $request->phone_no;
        $Staff->emergency_contact_number = $request->emergency_contact_number;
        $Staff->caste = $request->caste;
        $Staff->current_address = $request->current_address;
        $Staff->permanent_address = $request->permanent_address;

        if ($image = $request->file('staff_image')) {
            $uniqueName = uniqid() . '.' . $image->getClientOriginalExtension();
            $destinationPath = public_path('backend/images/staff');
            $image->move($destinationPath, $uniqueName);
            $Staff->staff_image = $uniqueName;
        }

        $Staff->save();

        // Store documents
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

        return redirect()->route('staff.index')->with('success', 'Staff Added!');
    }


    public function show(string $id)
    {
        $staff = staff::where('id', $id)->first();
        $documents = StaffDocuments::where('staff_id', $id)->whereNotNull('name')->get();
        $childs = nannyChilds::where('nanny_id', $staff->id)->get();
        return view('admin.staff.view', compact('staff', 'documents', 'childs'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $roles = Role::where('name', '!=', 'Admin')->get();
        $edit = Staff::where('id', $id)->first();
        $documents = StaffDocuments::where('staff_id', $id)->get();
        return view('admin.staff.edit', compact('edit', 'roles', 'documents'));
    }

    /**
     * Update the specified resource in storage.
     */

    public function update(Request $request, $id)
    {
        // Validate the request
        $validator = Validator::make($request->all(), [
            'first_name' => 'required|string',
            'last_name' => 'required',
            'user_id' => 'required|string',
            'dob' => 'required',
            'age' => 'required',
            'gender' => 'required|string',
            'email' => 'required|unique:users,email,' . $request->user_id,
            'password' => 'nullable|string|min:8',
            'religion' => 'required|string',
            'role_id' => 'required|integer',
            'phone_no' => 'required',
            'emergency_contact_number' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->route('staff.edit', $id)
                ->withErrors($validator)
                ->withInput();
        }

        $User = User::where('id', $request->user_id)->first();
        $User->first_name = $request->first_name;
        $User->last_name = $request->last_name;
        $User->email = $request->email;
        $User->role_id = $request->role_id;

        if (!empty($request->password) && $request->password !== 'null') {
            $User->password = Hash::make($request->password); // Hash the password securely
        }

        $role = Role::findById($request->role_id);

        // Reassign the new role to the user
        $User->syncRoles($role);

        $User->save();



        // Find the staff by ID
        $Staff = Staff::findOrFail($id);
        $Staff->dob = $request->dob;
        $Staff->age = $request->age;
        $Staff->gender = $request->gender;

        // Only update password if provided

        $Staff->religion = $request->religion;
        $Staff->phone_no = $request->phone_no;
        $Staff->emergency_contact_number = $request->emergency_contact_number;
        $Staff->caste = $request->caste;
        $Staff->current_address = $request->current_address;
        $Staff->permanent_address = $request->permanent_address;

        // Handle staff image upload
        if ($image = $request->file('staff_image')) {
            $uniqueName = uniqid() . '.' . $image->getClientOriginalExtension();
            $destinationPath = public_path('backend/images/staff');
            $image->move($destinationPath, $uniqueName);
            $Staff->staff_image = $uniqueName ? $uniqueName : $Staff->staff_image; // Keep old image if not uploaded
        }

        $Staff->save();

        // Handle document updates
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

                StaffDocuments::where('title', $title)->update([
                    'name' => $uniqueName
                ]);
            }
        }

        return redirect()->route('staff.index')->with('success', 'Staff Updated Successfully!');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        dd($id);
    }


    public function delete($id)
    {
        $staff = Staff::findOrFail($id)->first();
        $staff->delete();

        $nanny = nannyChilds::where('nanny_id', $id)->get();

        if ($nanny->isNotEmpty()) {
            $nanny = nannyChilds::where('nanny_id', $id)->delete();
            return redirect()->route('staff.index')->with('success', 'Staff Deleted !');
        }

        return redirect()->route('staff.index')->with('success', 'Staff Deleted !');
    }

    public function deleteStaffDocs($id)
    {
        $docs = StaffDocuments::findOrFail($id);
        $docs->name = Null;
        $docs->update();

        return response()->json([
            'success' => 'Document deleted !',
        ]);
    }

    public function assignChilds($id)
    {
        $nanny = Staff::find($id);

        $childs = Child::whereNotIn('id', function ($query) {
            $query->select('child_id')
                ->from('nanny_childs');
        })->get(['first_name', 'id', 'last_name']);

        $assigned = nannyChilds::where('nanny_id', $nanny->id)->paginate(5);

        return view('admin.staff.assignChilds.index', compact('nanny', 'childs', 'assigned'));
    }




    public function assignChildsToNanny(Request $req, $id)
    {
        $selectedChildIds = explode(',', $req->selected_childs);

        // Filter out any empty values
        $selectedChildIds = array_filter($selectedChildIds, function ($value) {
            return !empty($value);
        });

        foreach ($selectedChildIds as $childId) {
            if (is_numeric($childId)) {
                // Get the child record to fetch the school_id
                $child = Child::find($childId);

                if ($child && isset($child->school_id)) {
                    // dd($child->school_id);
                    // Store the nanny-child relationship with school_id
                    nannyChilds::updateOrCreate(
                        [
                            'nanny_id' => $id,
                            'child_id' => $childId,
                            'school_id' => $child->school_id,
                        ],
                        [
                            'nanny_id' => $id,
                            'child_id' => $childId,
                            'school_id' => $child->school_id,
                        ]
                    );
                }
            }
        }

        return redirect()->route('assign.childs', ['id' => $id])
            ->with('success', 'Children assigned to nanny successfully.');
    }



    public function unassignChild(Request $req)
    {
        nannyChilds::where('id', $req->unassign_child)->delete();

        return redirect()->route('assign.childs', ['id' => $req->nanny_id])
            ->with('success', 'The child has been successfully unassigned from this nanny.');
    }





    public function unassignAll($id)
    {

        nannyChilds::where('nanny_id', $id)->delete();
        return redirect()->route('assign.childs', ['id' => $id])
            ->with('success', 'All children have been unassigned from this nanny.');

    }



}
