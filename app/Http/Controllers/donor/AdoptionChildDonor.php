<?php

namespace App\Http\Controllers\donor;

use App\Http\Controllers\Controller;
use App\Models\child;
use App\Models\Schools;
use Illuminate\Http\Request;

class AdoptionChildDonor extends Controller
{
    public function index()
    {
        $childrens = child::orderBy('enquiry_no', 'desc')->paginate(10);
        return view('donor.adoption.index', compact('childrens'));
    }

    public function view($id)
    {
        $child = child::where('id', $id)->first();
        return view('donor.adoption.view', compact('child'));
    }

    public function requestforChild(Request $req)
    {
        $selectedIds = $req->selectedValues;

        // Fetch the selected children
        $children = Child::whereIn('id', $selectedIds)->get();

        $totalFees = 0;

        // Iterate over each child and get the school fee
        foreach ($children as $child) {
            $school = Schools::find($child->school_id);
            if ($school) {
                // Add the fee of the school's current child to the total fee
                $totalFees += $school->fees;
            }
        }

        return response()->json([
            'message' => 'Children processed successfully',
            'total_fees' => $totalFees
        ]);
    }




}
