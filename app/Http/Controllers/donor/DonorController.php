<?php

namespace App\Http\Controllers\donor;

use App\Http\Controllers\Controller;
use App\Models\donorChildReq;
use Illuminate\Http\Request;
use App\Models\child;
use App\Models\ChildActivity;
class DonorController extends Controller
{
    public function dashboard()
    {
        $child = child::count();
        return view('donor.dashboard', compact('child'));
    }

    public function donorChildAct()
    {
        $donorId = auth()->user()->id;
        $childIds = donorChildReq::where('donor_id', $donorId)
            ->where('payment_id', '!=', null)
            ->pluck('child_id');

        $activity = ChildActivity::with(['child', 'images'])
            ->whereIn('child_id', $childIds)
            ->orderBy('id', 'desc')
            ->paginate(10);
        return view('donor.child.activities', compact('activity'));
    }

    public function index()
    {
        dd('Adopt a Child');
    }


}
