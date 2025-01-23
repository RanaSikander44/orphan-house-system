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


        $formElements = json_decode($req->form_data, true);

        if ($formElements) {
            $formDataRecords = []; // Array to batch insert data

            foreach ($formElements as $element) {
                $formDataRecords[] = [
                    'form_id' => $form->id,
                    'form_data' => json_encode($element), // Save the individual element data
                    'type' => $element['type'] ?? null,
                    'sub_type' => $element['subtype'] ?? null,
                    'access' => $element['access'] ?? null,
                    'name' => $element['name'] ?? null,
                    'label' => $element['label'] ?? null,
                    'className' => $element['className'] ?? null,
                    'multiple' => $element['multiple'] ?? null,
                ];
            }

            // Batch insert all elements into enquiryFormData
            enquiryFormData::insert($formDataRecords);
        }


        return redirect()->route('settings')->with('success', 'Enquiry Form Added !');

    }

    public function editForm($id)
    {
        $form = enquiryFormData::where('form_id', $id)->first();
        return view('admin.settings.enquiryForms.edit', ['form' => $form]);
    }

    public function updateForm($id, Request $req)
    {
        $validate = validator::make($req->all(), [
            'form_name' => 'required',
            'form_data' => 'required|json',
        ]);

        if ($validate->fails()) {
            return back()->withInput()->withErrors($validate);
        }


        $FormId = enquiryFormData::where('form_id', $id)->first();

        $form = enquiryForms::where('id', $FormId->id)->first();
        $form->name = $req->form_name;
        $form->update();

        $formData = EnquiryFormData::find($id);
        $formData->form_id = $form->id;
        $formData->form_data = $req->form_data;
        $formData->save();


        return redirect()->route('settings')->with('success', 'Enquiry Form Updated !');

    }

    public function deleteForm($id)
    {
        $form = enquiryForms::where('id', $id)->delete();
        return response()->json(['success', 'Form Deleted !']);
    }

}
