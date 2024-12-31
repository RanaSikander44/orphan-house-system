<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
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
        return view('admin.dormitory.add');
    }

    public function store(Request $req)
    {
        $dormitory = new Dormitory();
        $dormitory->title = $req->title;
        $dormitory->max_number_bed = $req->max_number_bed;
        $dormitory->total_booked = '0';
        $dormitory->total_available = $req->max_number_bed;
        $dormitory->save();

        return redirect()->route('room-list')->with('success', 'New Room Added !');
    }

    public function edit($id)
    {
        $dormitory = Dormitory::findOrFail($id);
        return view('admin.dormitory.edit', compact('dormitory'));
    }

    public function update(Request $req, $id)
    {
        $dormitory = Dormitory::where('id', $id)->first();
        $dormitory->title = $req->title;
        $dormitory->max_number_bed = $req->max_number_bed;
        $dormitory->total_booked = '0';
        $dormitory->total_available = $req->max_number_bed;
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
