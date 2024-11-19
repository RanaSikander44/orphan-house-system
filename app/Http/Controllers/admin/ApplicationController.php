<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ApplicationController extends Controller
{
    public function index()
    {
        return view('admin.applications.index');
    }


    public function add()
    {
        return view('admin.applications.add');
    }
}
