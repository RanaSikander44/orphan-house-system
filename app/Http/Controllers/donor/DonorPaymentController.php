<?php

namespace App\Http\Controllers\donor;

use App\Http\Controllers\Controller;
use App\Models\donorChildReq;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Models\child;
use App\Models\payment;

class DonorPaymentController extends Controller
{
    public function index($id)
    {
        $data = Child::where('id', $id)->first();
        return view('donor.payment.index', compact('data'));
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
        $insert->amount = $req->amount;
        $insert->card_number = $req->cardNumber;
        $insert->exp_month = $req->expiryMonth;
        $insert->exp_year = $req->expiryYear;
        $insert->cvc = $req->cvc;
        $insert->cardholder_name = $req->cardHolderName;
        $insert->paid_by = auth()->user()->id;
        $insert->save();


        $donationReq = donorChildReq::where('child_id', $req->child_id)->first();
        $donationReq->payment_id = $insert->id;
        $donationReq->save();

        return redirect()->route('donor.reqs')->with('success', 'Payment has been successfully processed.');
    }
}
