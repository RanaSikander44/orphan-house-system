<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\enquiryFormData;
use App\Models\enquiryForms;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;


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
        dd( $formElements);

        if ($formElements) {
            $formDataRecords = []; // Array to batch insert data

            foreach ($formElements as $element) {
                $formDataRecords[] = [
                    'form_id' => $form->id,
                    'form_data' => json_encode($element), // Save the individual element data
                    'type' => $element['type'] ?? null,
                    'sub_type' => $element['subtype'] ?? null,
                    'access' => $element['access'] ?? null,
                    'name' => "field_{$form->id}" ?? null,
                    'label' => $element['label'] ?? null,
                    'className' => $element['className'] ?? null,
                    'multiple' => !empty($element['multiple']) == true ? '1' : '0',
                    'required' => !empty($element['required']) == true ? '1' : null,
                ];


            }

            // Batch insert all elements into enquiryFormData
            enquiryFormData::insert($formDataRecords);
        }


        return redirect()->route('settings')->with('success', 'Enquiry Form Added !');

    }

    public function editForm($id)
    {
        $form = enquiryForms::findOrFail($id);
        $formFields = enquiryFormData::where('form_id', $id)->get();

        $formFieldsJson = $formFields->map(function ($field) {
            return [
                'type' => $field->type,
                'subtype' => $field->sub_type,
                'access' => $field->access === 0 ? false : true,
                'name' => "field_{$field->id}",
                'label' => $field->label,
                'className' => $field->className ?? 'form-control',
                'multiple' => $field->multiple == '1' ? true : false,
                'required' => $field->required ? true : false,
            ];
        });

        return view('admin.settings.enquiryForms.edit', [
            'form' => $form,
            'formFieldsJson' => $formFieldsJson->toJson(),
        ]);
    }



    public function updateForm(Request $request, $id)
    {
        $form = enquiryForms::findOrFail($id);
        $form->name = $request->input('form_name');
        $form->save();

        $fields = json_decode($request->input('form_data'), true);
        $requestFieldIds = [];
        if (is_array($fields)) {
            foreach ($fields as $field) {
                if (!isset($field['name'], $field['label'])) {
                    continue;
                }

                $fieldId = str_replace('field_', '', $field['name']);
                $requestFieldIds[] = $fieldId;

                $formField = enquiryFormData::find($fieldId);

                if ($formField) {
                    $formField->form_id = $id;
                    $formField->form_data = $request->form_data;
                    $formField->type = $field['type'] ?? null;
                    $formField->sub_type = $field['subtype'] ?? null;
                    $formField->access = $field['access'] ?? null;
                    $formField->name = 'field_' . $id;
                    $formField->label = $field['label'];
                    $formField->className = $field['className'] ?? null;
                    $formField->multiple = !empty($field['multiple']) ? '1' : '0';
                    $formField->required = !empty($field['required']) == true ? '1' : null;
                    $formField->save();


                    $existingFieldIds = enquiryFormData::where('form_id', $id)->pluck('id')->toArray();
                    $idsForDelete = array_diff($existingFieldIds, $requestFieldIds);

                    if (!empty($idsForDelete)) {
                        enquiryFormData::whereIn('id', $idsForDelete)->delete();
                    }

                } else {

                    dd($fields);

                    if ($field['type'] === 'paragraph') {
                        dd($field['type']);
                        $data = new enquiryFormData();
                        $data->form_id = 'field_' . $id;
                        $data->data = json_encode($field);
                        $data->type = 'paragraph';
                        $data->subtype = 'p';
                        $data->label = $field['label'];
                        $data->access = false;
                        $data->name = !empty($field['name']) ?? 'field_' . $id;
                        $data->className = 'form-control';
                        $data->multiple = null;
                        $data->required = null;
                    }

                    enquiryFormData::create([
                        'form_id' => $form->id,
                        'form_data' => json_encode($field),
                        'type' => $field['type'] ?? null,
                        'sub_type' => $field['subtype'] ?? null,
                        'access' => $field['access'] ?? null,
                        'name' => !empty('field_' . $id) ?? null,
                        'label' => $field['label'],
                        'className' => !empty($field['className']) ?? null,
                        'multiple' => !empty($field['multiple']) ? '1' : '0',
                        'required' => !empty($field['required']) === true ? '1' : null,
                    ]);
                }
            }
        }

        return redirect()->route('settings')->with('success', 'Form updated successfully!');
    }

    public function deleteForm($id)
    {
        $form = enquiryForms::where('id', $id)->delete();
        return response()->json(['success', 'Form Deleted !']);
    }


    public function FormStatus($id, Request $req)
    {
        if ($req->task === 'Inactive') {
            $form = enquiryForms::where('id', $id)->first();
            $form->status = '0';
            $form->update();

            return response()->json([
                'success' => 'Form has been inactive'
            ]);
        }

        if ($req->task === 'Active') {
            $form = enquiryForms::where('id', $id)->first();
            $form->status = '1';
            $form->update();

            return response()->json([
                'success' => 'Form has been active'  // Fixed this line
            ]);
        }

        return response()->json([
            'error' => 'Invalid task'  // Added a more descriptive error message
        ]);
    }


}
