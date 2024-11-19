<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\academicyear;

class AcademicYearController extends Controller
{
   public function index()
   {
      $year = academicyear::orderBy('id', 'desc')->paginate(10);
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
}
