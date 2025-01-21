<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\enquiryFormData;
use App\Models\enquiryForms;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class FormsController extends Controller
{
    public function create()
    {
        return view('admin.settings.enquiryForms.create');
    }

    public function save(Request $req)
    {
        $validate = validator::make($req->all(), [
            'form_name' => 'required',
            'form_data' => 'required|json',
        ]);

        if ($validate->fails()) {
            return back()->withInput()->withErrors($validate);
        }


        $form = new enquiryForms();
        $form->name = $req->form_name;
        $form->status = '1';
        $form->save();


        $formData = new enquiryFormData();
        $formData->form_id = $form->id;
        $formData->form_data = $req->form_data;
        $formData->save();


        return redirect()->route('settings')->with('success', 'Enquiry Form Added !');

    }
}
