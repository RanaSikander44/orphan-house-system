<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\school_grades;
use App\Models\Schools;
use Illuminate\Http\Request;

class SchoolController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $schools = Schools::paginate();
        return view('admin.schools.index', compact('schools'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $grade = school_grades::all();
        return view('admin.schools.add', compact('grade'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'fees' => 'required|numeric', // changed to numeric for a fee amount
            'grade' => 'required|string|max:255', // assuming grade is a string
            'address' => 'required|string|max:500', // assuming address is a string with a max length
        ]);

        // Check if validation fails
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }


        $school = new Schools();
        $school->name = $request->name;
        $school->fees = $request->fees;
        $school->grade = $request->grade;
        $school->address = $request->address;
        $school->save();


        return redirect()->route('schools.index')->with('success', 'School added !');

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
        $school = Schools::find($id);
        $grade = school_grades::all();
        return view('admin.schools.edit', compact('school', 'grade'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {

        $validator = \Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'fees' => 'required|numeric', // changed to numeric for a fee amount
            'grade' => 'required|string|max:255', // assuming grade is a string
            'address' => 'required|string|max:500', // assuming address is a string with a max length
        ]);

        // Check if validation fails
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }


        $school = Schools::find($id);
        $school->name = $request->name;
        $school->fees = $request->fees;
        $school->grade = $request->grade;
        $school->address = $request->address;
        $school->update();


        return redirect()->route('schools.index')->with('success', 'School updated !');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $school = Schools::find($id);
        $school->delete();

        return redirect()->route('schools.index')->with('success', 'School deleted !');

    }
}
