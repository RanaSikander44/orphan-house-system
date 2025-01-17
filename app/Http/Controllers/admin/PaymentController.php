<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Payment_renewal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\payment;

class PaymentController extends Controller
{

    public function index()
    {
        $payments = payment::orderBy('id', 'desc')->get();
        return view('admin.payments.index', compact('payments'));
    }

}
