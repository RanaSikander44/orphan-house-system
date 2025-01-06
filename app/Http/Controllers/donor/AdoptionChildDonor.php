<?php

namespace App\Http\Controllers\donor;

use App\Http\Controllers\Controller;
use App\Models\child;
use App\Models\donorChildReq;
use App\Models\Schools;
use App\Models\User;
use Illuminate\Http\Request;

class AdoptionChildDonor extends Controller
{
    public function index()
    {
        $childrens = child::orderBy('enquiry_no', 'desc')->where('donor_id', null)->where('donor_req_donation_status', '0')->paginate(10);
        return view('donor.adoption.index', compact('childrens'));
    }

    public function view($id)
    {
        $child = child::where('id', $id)->first();
        return view('donor.adoption.view', compact('child'));
    }


    public function requestAdoption(Request $req)
    {
        $selectedIds = $req->selectedValues;


        foreach ($selectedIds as $list) {
            $data = new donorChildReq();
            $data->child_id = $list;
            $data->donor_id = auth()->user()->id;
            $data->save();
        }

        foreach ($selectedIds as $list) {
            $users = child::where('id', $list)->get();

            foreach ($users as $user) {
                $user->donor_req_donation_status = 1;
                $user->save();
            }
        }

        // $children = Child::whereIn('id', $selectedIds)->get();



        // $totalFees = 0;

        // foreach ($children as $child) {
        //     $school = Schools::find($child->school_id);
        //     if ($school) {
        //         $totalFees += $school->fees;
        //     }

        // }

        return response()->json([
            'message' => 'Children processed successfully',
            // 'total_fees' => $totalFees
        ]);
    }


    public function requests()
    {
        $donor_id = auth()->user()->id;
        $child = child::where('donor_id', $donor_id)->orderBy('id' , 'desc')->paginate(10);
        $pendingReq = donorChildReq::where('donor_id', $donor_id)->where('req_status', '0')->orderBy('id', 'desc')->paginate(10);
        return view('donor.adoption.request', compact('child', 'pendingReq'));
    }



}
