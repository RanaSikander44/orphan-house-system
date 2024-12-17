<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\school_grades;
use Illuminate\Http\Request;

class SchoolGradesController extends Controller
{
    public function index()
    {
        $grades = school_grades::paginate(10);
        return view('admin.schools.grades.index', compact('grades'));
    }

    public function store(Request $req)
    {
        // Validate the incoming request data
        $validator = \Validator::make($req->all(), [
            'grade' => 'required|string|max:255',
            'status' => 'required|boolean',
        ]);

        // If validation fails, return back with input and errors
        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput(); // Keep the input data
        }

        // If validation passes, create a new school grade
        $grades = new school_grades();
        $grades->grade = $req->grade;
        $grades->status = $req->status;
        $grades->save();

        // Optionally, redirect to another page with a success message
        return redirect()->route('add.grades')->with('success', 'Grade saved successfully!');
    }


    public function edit($id)
    {
        // Retrieve the grade to be edited
        $grade = school_grades::find($id);

        // Check if the grade exists
        if (!$grade) {
            return redirect()->route('grades.index')->with('error', 'Grade not found!');
        }

        // Paginate the grades (optional, depending on what you need to display)
        $grades = school_grades::paginate(10);

        // Return the view with the grade and grades list
        return view('admin.schools.grades.edit', compact('grade', 'grades'));
    }


    public function update(Request $req, $id)
    {

        // Validate the incoming request data
        $validator = \Validator::make($req->all(), [
            'grade' => 'required|string|max:255',
            'status' => 'required|boolean',
        ]);

        // If validation fails, return back with input and errors
        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput(); // Keep the input data
        }

        // If validation passes, create a new school grade
        $grades = school_grades::find($id);
        $grades->grade = $req->grade;
        $grades->status = $req->status;
        $grades->update();

        // Optionally, redirect to another page with a success message
        return redirect()->route('add.grades')->with('success', 'Grade update successfully!');
    }

    public function delete($id)
    {
        $grade = school_grades::find($id);
        $grade->delete();
        return redirect()->route('add.grades')->with('success', 'Grade deleted successfully!');
    }

}
