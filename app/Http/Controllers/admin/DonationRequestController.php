<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\child;
use App\Models\donorChildReq;
use Illuminate\Http\Request;

class DonationRequestController extends Controller
{
    public function index()
    {
        $pendingrequests = donorChildReq::where('req_status', '0')->paginate(10);
        $acceptedrequests = donorChildReq::where('req_status', '1')->paginate(10);
        return view('admin.donations.donationsreq', compact('pendingrequests', 'acceptedrequests'));
    }


    public function view($id)
    {
        $details = donorChildReq::where('id', $id)->first();
        return view('admin.donations.view', compact('details'));
    }


    public function accept($id)
    {
        $detail = donorChildReq::find($id);

        if (!$detail) {
            return redirect()->route('admin.donations.req')->with('error', 'Donation Request not found!');
        }

        $detail->req_status = '1';
        $detail->save();

        $child = child::find($detail->child_id);

        if (!$child) {
            return redirect()->route('admin.donations.req')->with('error', 'Child not found!');
        }

        $child->donor_id = $detail->donor_id;
        $child->save();

        return redirect()->route('admin.donations.req')->with('success', 'Donation Request Accepted!');
    }

}
