<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\academicyear;

class AcademicYearController extends Controller
{
   public function index()
   {
      $year = academicyear::orderBy('id', 'desc')->paginate(7);
      return view('admin.academicyears.index', compact('year'));
   }

   public function save(Request $req)
   {
      $year = new academicyear();
      $year->year = $req->year;
      $year->title = $req->title;
      $year->starting_date = $req->starting_date;
      $year->ending_date = $req->ending_date;

      if ($year->save()) {
         return redirect()->route('academic-year')->with('success', 'Academic Year Added!');
      } else {
         return redirect()->back()->with('error', 'Failed to add Academic Year. Please try again.');
      }

   }


   public function delete($id)
   {
      $year = academicyear::find($id);  // Retrieve the academic year by its ID

      if ($year) {  // Check if the record was found
         if ($year->delete()) {
            return redirect()->route('academic-year')->with('success', 'Academic Year deleted!');
         } else {
            return redirect()->back()->with('error', 'Failed to delete Academic Year. Please try again.');
         }
      } else {
         return redirect()->back()->with('error', 'Academic Year not found.');
      }

   }


   public function edit($id)
   {
      $year = academicyear::orderBy('id', 'desc')->paginate(7);
      $rowforedit = academicyear::where('id', $id)->first();
      return view('admin.academicyears.edit', compact('year', 'rowforedit'));
   }


   public function update(Request $req, $id)
   {
      $year = academicyear::find($id);

      if (!$year) {
         return redirect()->route('academic-year')->with('error', 'Academic Year not found.');
      }

      // Update fields
      $year->year = $req->year;
      $year->title = $req->title;
      $year->starting_date = $req->starting_date;
      $year->ending_date = $req->ending_date;

      // Save the updated model
      if ($year->save()) {
         return redirect()->route('academic-year')->with('success', 'Academic Year Updated!');
      } else {
         return redirect()->back()->with('error', 'Failed to update Academic Year. Please try again.');
      }
   }
}
