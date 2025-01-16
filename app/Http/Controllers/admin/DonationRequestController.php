<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\child;
use App\Models\donorChildReq;
use Illuminate\Http\Request;
use App\Models\notifications;

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
        try {
            $detail = donorChildReq::findOrFail($id);
            $child = child::findOrFail($detail->child_id);

            $detail->req_status = '1';
            $detail->save();

            $child->donor_id = $detail->donor_id;
            $child->save();

            $notify = new notifications();
            $notify->message = 'Congratulations! Your donation request for ' . $child->first_name . ' ' . $child->last_name . ' has been successfully accepted on ' . '. You can now proceed with the payment process.';
            $notify->notification_for = $detail->donor_id;
            $notify->save();

            return redirect()->route('admin.donations.req')->with('success', 'Donation Request Accepted!');

        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return redirect()->route('admin.donations.req')->with('error', 'Donation Request or Child not found!');
        }
    }

    public function reject($id)
    {
        $detail = donorChildReq::findOrFail($id);

        $child = child::where('id', $detail->child_id)->first();
        $child->donor_req_donation_status = 0;
        $child->update();

        $notify = new notifications();
        $notify->message = ' Your donation request for ' . $child->first_name . ' ' . $child->last_name . ' has been rejected' . '.';
        $notify->notification_for = $detail->donor_id;
        $notify->save();

        $detail->delete();

        return redirect()->route('admin.donations.req')->with('success', 'Donation Request rejected!');
    }


}
