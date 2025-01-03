<?php

namespace App\Http\Controllers\donor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\child;
class DonorController extends Controller
{
    public function dashboard()
    {
        $child = child::count();
        return view('donor.dashboard', compact('child'));
    }

    public function index()
    {
        dd('Adopt a Child');
    }


}
