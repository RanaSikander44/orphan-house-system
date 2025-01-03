<?php

namespace App\Http\Controllers\donor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DonorController extends Controller
{
    public function dashboard()
    {
        return view('donor.dashboard');
    }
}
