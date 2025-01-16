<?php

namespace App\Http\Controllers\donor;

use App\Http\Controllers\Controller;
use App\Models\donorChildReq;
use App\Models\Payment_renewal;
use App\Models\settings;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Models\child;
use App\Models\payment;
use Carbon\Carbon;

class DonorPaymentController extends Controller
{
    public function index($id)
    {
        $data = Child::where('id', $id)->first();
        $child_charges = settings::first('charges_of_a_child');
        return view('donor.payment.index', compact('data', 'child_charges'));
    }


    public function makePayment(Request $req)
    {

        $validate = Validator::make($req->all(), [
            'amount' => 'required|integer',
            'cardNumber' => 'required|integer',
            'expiryMonth' => 'required|integer',
            'expiryYear' => 'required|integer',
            'cvc' => 'required|integer',
            'cardHolderName' => 'required',
        ]);


        if ($validate->fails()) {
            return redirect()->back()->withErrors($validate)->withInput();
        }

        $insert = new payment();
        $insert->amount_paid = $req->amount;
        $insert->card_number = $req->cardNumber;
        $insert->exp_month = $req->expiryMonth;
        $insert->exp_year = $req->expiryYear;
        $insert->cvc = $req->cvc;
        $insert->cardholder_name = $req->cardHolderName;
        $insert->paid_by = auth()->user()->id;
        $insert->child_id = $req->child_id;
        $insert->save();


        $renewal = new Payment_renewal();
        $renewal->payment_id = $insert->id;

        if ($req->paymentSchedule === 'monthly') {
            $renewal->renewal_type = 'Monthly';
            $renewal->start_date = Carbon::now();
            $renewal->end_date = Carbon::parse($insert->start_date)->addMonth();
            $renewal->total_dayes = Carbon::parse($renewal->start_date)->diffInDays($renewal->end_date);
        }

        $renewal->save();




























        $donationReq = donorChildReq::where('child_id', $req->child_id)->first();
        $donationReq->payment_id = $insert->id;
        $donationReq->save();

        return redirect()->route('donor.reqs')->with('success', 'Payment has been successfully processed.');
    }
}
