<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Dormitory;


class DormitoryController extends Controller
{
    public function index()
    {
        $dormitory = Dormitory::all();
        return view('admin.dormitory.index', compact('dormitory'));
    }


    public function add()
    {
        $nanny = User::where('role_id', '18')->get();
        return view('admin.dormitory.add', compact('nanny'));
    }


    public function store(Request $req)
    {
        $dormitory = new Dormitory();
        $dormitory->title = $req->title;
        $dormitory->max_number_bed = $req->max_number_bed;
        $dormitory->total_booked = '0';
        $dormitory->total_available = $req->max_number_bed;
        $dormitory->nanny_id = $req->nanny_id;
        $dormitory->save();
        return redirect()->route('room-list')->with('success', 'New Room Added !');
    }
    public function edit($id)
    {
        $dormitory = Dormitory::findOrFail($id);
        $nanny = User::where('role_id', '18')->get();
        return view('admin.dormitory.edit', compact('dormitory' , 'nanny'));
    }
    public function update(Request $req, $id)
    {
        $dormitory = Dormitory::where('id', $id)->first();
        $dormitory->title = $req->title;
        $dormitory->max_number_bed = $req->max_number_bed;
        $dormitory->total_booked = '0';
        $dormitory->total_available = $req->max_number_bed;
        $dormitory->nanny_id = $req->nanny_id;
        $dormitory->update();
        return redirect()->route('room-list')->with('success', 'Room Updated !');
    }


    public function delete($id)
    {
        $dormitory = Dormitory::where('id', $id)->first();
        $dormitory->delete();
        return redirect()->route('room-list')->with('success', 'Room deleted !');
    }


}