<?php

namespace App\Http\Controllers\donor;

use App\Http\Controllers\Controller;
use App\Models\child;
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
}
