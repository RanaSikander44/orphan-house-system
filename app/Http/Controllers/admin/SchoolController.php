<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\AssingedGradesToSchool;
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
            'fees' => 'required|numeric',
            'address' => 'required|string|max:500',
        ]);

        // Check if validation fails
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $school = new Schools();
        $school->name = $request->name;
        $school->fees = $request->fees;
        $school->address = $request->address;
        $school->save();

        if ($request->has('grade')) {
            if (is_array($request->grade)) {
                $gradesString = $request->grade[0];
                $grades = explode(',', $gradesString);

                foreach ($grades as $gradeId) {
                    $data = new AssingedGradesToSchool();
                    $data->school_id = $school->id;
                    $data->grade_id = $gradeId;
                    $data->save();
                }
            }
        }

        return redirect()->route('schools.index')->with('success', 'School added!');
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
        $grades = school_grades::all();
        $assignedGrades = AssingedGradesToSchool::where('school_id', $school->id)->pluck('grade_id')->toArray();

        return view('admin.schools.edit', compact('school', 'grades', 'assignedGrades'));
    }

    public function update(Request $request, string $id)
    {

        $validator = \Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'fees' => 'required|numeric', // changed to numeric for a fee amount
            'address' => 'required|string|max:500', // assuming address is a string with a max length
        ]);

        // Check if validation fails
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }


        $school = Schools::find($id);
        $school->name = $request->name;
        $school->fees = $request->fees;
        $school->address = $request->address;
        $school->update();


        if ($request->has('grade')) {

            AssingedGradesToSchool::where('school_id', $id)->delete();

            if ($request->has('grade')) {
                if (is_array($request->grade)) {
                    $gradesString = $request->grade[0];
                    $grades = explode(',', $gradesString);

                    foreach ($grades as $gradeId) {
                        $data = new AssingedGradesToSchool();
                        $data->school_id = $school->id;
                        $data->grade_id = $gradeId;
                        $data->save();
                    }
                }
            }
        }


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

    public function findSchool(Request $request)
    {
        $school_id = $request->input('school_id');

        $assignedGrades = AssingedGradesToSchool::where('school_id', $school_id)->get();

        $gradeIds = $assignedGrades->pluck('grade_id');

        $grades = school_grades::whereIn('id', $gradeIds)->get(['id', 'grade']);  // Assuming 'title' is the column for grade name/title

        $gradeData = $grades->map(function ($grade) {
            return [
                'grade_id' => $grade->id,
                'grade' => $grade->grade
            ];
        });

        return response()->json([
            'grades' => $gradeData
        ]);
    }

}
