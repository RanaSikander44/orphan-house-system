<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\enquiryFormData;
use App\Models\enquiryFormOptions;
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

        // Save the main form
        $form = new enquiryForms();
        $form->name = $req->form_name;
        $form->status = '1';
        $form->save();

        // Decode the form data
        $formElements = json_decode($req->form_data, true);

        if ($formElements) {
            foreach ($formElements as $element) {
                // Save the form field
                $newField = enquiryFormData::create([
                    'form_id' => $form->id,
                    'form_data' => json_encode($element),
                    'type' => $element['type'] ?? null,
                    'sub_type' => $element['subtype'] ?? null,
                    'access' => $element['access'] ?? null,
                    'name' => "field_{$form->id}",
                    'label' => $element['label'] ?? null,
                    'className' => $element['className'] ?? null,
                    'multiple' => !empty($element['multiple']) ? '1' : '0',
                    'required' => !empty($element['required']) ? '1' : null,
                ]);

                // Check if the element has options (for select or checkbox group)
                if ($element['type'] === 'select' && isset($element['values'])) {
                    foreach ($element['values'] as $option) {
                        enquiryFormOptions::create([
                            'field_id' => $newField->id, // Associate the option with the field
                            'label' => $option['label'],
                            'value' => $option['value'],
                            'selected' => $option['selected'] ?? false,
                        ]);
                    }
                }

                // Handle checkbox group (saving selected values)
                if ($element['type'] === 'checkbox-group' && isset($element['values'])) {
                    foreach ($element['values'] as $option) {
                        enquiryFormOptions::create([
                            'field_id' => $newField->id,
                            'label' => $option['label'],
                            'value' => $option['value'],
                            'selected' => $option['selected'] ?? false, // Store selected value
                        ]);
                    }
                }

                if ($element['type'] === 'radio-group' && isset($element['values'])) {
                    foreach ($element['values'] as $option) {
                        enquiryFormOptions::create([
                            'field_id' => $newField->id,
                            'label' => $option['label'], // Save label for the radio option
                            'value' => $option['value'], // Save value for the radio option
                            'selected' => $option['selected'] ?? false, // Store whether the option is selected
                        ]);
                    }
                }
            }
        }

        return redirect()->route('settings')->with('success', 'Enquiry Form Added!');
    }



    public function editForm($id)
    {
        $form = enquiryForms::findOrFail($id); // Fetch the form by ID
        $formFields = enquiryFormData::where('form_id', $id)->get(); // Get all fields for the form

        $formFieldsJson = $formFields->map(function ($field) {
            // Map the fields and include options for `select` and `checkbox-group`
            $fieldData = [
                'type' => $field->type,
                'subtype' => $field->sub_type,
                'access' => $field->access === 0 ? false : true,
                'name' => "field_{$field->id}",
                'label' => $field->label,
                'className' => $field->className ?? '',
                'multiple' => $field->multiple == '1' ? true : false,
                'required' => $field->required ? true : false,
            ];

            // Add options if the field type is `select`
            if ($field->type === 'select') {
                $fieldData['values'] = enquiryFormOptions::where('field_id', $field->id)->get()->map(function ($option) {
                    return [
                        'id' => $option->id,
                        'label' => $option->label,
                        'value' => $option->value,
                        'selected' => $option->selected ? true : false,
                    ];
                })->toArray();
            }

            // Add options if the field type is `checkbox-group`
            if ($field->type === 'checkbox-group') {
                $fieldData['values'] = enquiryFormOptions::where('field_id', $field->id)->get()->map(function ($option) {
                    return [
                        'id' => $option->id,
                        'label' => $option->label,
                        'value' => $option->value,
                        'selected' => $option->selected ? true : false,
                    ];
                })->toArray();
            }

            // Add options if the field type is `radio-group`
            if ($field->type === 'radio-group') {
                $fieldData['values'] = enquiryFormOptions::where('field_id', $field->id)->get()->map(function ($option) {
                    return [
                        'id' => $option->id, // Option ID
                        'label' => $option->label, // Option label
                        'value' => $option->value, // Option value
                        'selected' => $option->selected ? true : false, // Selected status
                    ];
                })->toArray();
            }



            return $fieldData;
        });

        return view('admin.settings.enquiryForms.edit', [
            'form' => $form,
            'formFieldsJson' => $formFieldsJson->toJson(), // Pass the fields and options as JSON
        ]);
    }



    public function updateForm(Request $request, $id)
    {
        $form = enquiryForms::findOrFail($id);
        $form->name = $request->input('form_name');
        $form->save();

        $fields = json_decode($request->input('form_data'), true);

        if (is_array($fields)) {
            $requestFieldIds = [];
            $newlyCreatedFieldIds = [];

            foreach ($fields as $field) {
                $fieldId = isset($field['name']) ? str_replace('field_', '', $field['name']) : null;
                $requestFieldIds[] = $fieldId;

                $formField = $fieldId ? enquiryFormData::find($fieldId) : null;

                if ($formField) {
                    // Update existing field
                    $formField->form_id = $id;
                    $formField->form_data = json_encode($field);
                    $formField->type = $field['type'] ?? null;
                    $formField->sub_type = $field['subtype'] ?? null;
                    $formField->access = $field['access'] ?? null;

                    $formField->label = $field['label'] ?? null;
                    $formField->className = $field['className'] ?? null;
                    $formField->multiple = isset($field['multiple']) ? ($field['multiple'] ? '1' : '0') : null;
                    $formField->required = isset($field['required']) ? ($field['required'] ? '1' : null) : null;
                    $formField->save();

                    // Update options for `select` and `checkbox-group` fields
                    if (in_array($formField->type, ['select', 'checkbox-group']) && isset($field['values'])) {
                        $existingOptions = enquiryFormOptions::where('field_id', $formField->id)->pluck('id')->toArray();
                        $requestOptionIds = [];

                        foreach ($field['values'] as $option) {
                            $optionId = $option['id'] ?? null;
                            $requestOptionIds[] = $optionId;

                            if ($optionId && in_array($optionId, $existingOptions)) {
                                // Update existing option
                                $formOption = enquiryFormOptions::find($optionId);
                                $formOption->label = $option['label'];
                                $formOption->value = $option['value'];
                                $formOption->selected = $option['selected'] ?? false;
                                $formOption->save();
                            } else {
                                // Create new option
                                enquiryFormOptions::create([
                                    'field_id' => $formField->id,
                                    'label' => $option['label'],
                                    'value' => $option['value'],
                                    'selected' => $option['selected'] ?? false,
                                ]);
                            }
                        }

                        // Delete options that are no longer in the request
                        $optionsForDelete = array_diff($existingOptions, $requestOptionIds);
                        if (!empty($optionsForDelete)) {
                            enquiryFormOptions::whereIn('id', $optionsForDelete)->delete();
                        }
                    }
                } else {

                    // Create new field
                    $newField = enquiryFormData::create([
                        'form_id' => $form->id,
                        'form_data' => json_encode($field),
                        'type' => $field['type'] ?? null,
                        'sub_type' => $field['subtype'] ?? null,
                        'access' => $field['access'] ?? null,
                        'name' => isset($field['name']) ? "field_{$field['name']}" : null,
                        'label' => $field['label'] ?? null,
                        'className' => $field['className'] ?? '',
                        'multiple' => isset($field['multiple']) ? ($field['multiple'] ? '1' : '0') : null,
                        'required' => isset($field['required']) ? ($field['required'] ? '1' : null) : null,
                    ]);

                    $newlyCreatedFieldIds[] = $newField->id;

                    // Assign name
                    $newField->name = "field_{$newField->id}";
                    $newField->save();

                    // Add options for the new `select` field
                    if ($field['type'] === 'select' && isset($field['values'])) {
                        foreach ($field['values'] as $option) {
                            enquiryFormOptions::create([
                                'field_id' => $newField->id,
                                'label' => $option['label'],
                                'value' => $option['value'],
                                'selected' => $option['selected'] ?? false,
                            ]);
                        }
                    }

                    // Add options for checkboxes
                    if ($field['type'] === 'checkbox-group' && isset($field['values'])) {
                        foreach ($field['values'] as $checkboxOption) {
                            // Assuming $checkboxOption is an array with 'label', 'value', and 'selected'
                            enquiryFormOptions::create([
                                'field_id' => $newField->id,
                                'label' => $checkboxOption['label'], // Access label correctly
                                'value' => $checkboxOption['value'], // Access value correctly
                                'selected' => $checkboxOption['selected'] ?? false, // Use selected or false as default
                            ]);
                        }
                    }


                    // Add options for the new `radio-group` field
                    if ($field['type'] === 'radio-group' && isset($field['values'])) {
                        foreach ($field['values'] as $radioOption) {
                            enquiryFormOptions::create([
                                'field_id' => $newField->id,
                                'label' => $radioOption['label'], // Access label from the radio option
                                'value' => $radioOption['value'], // Access value from the radio option
                                'selected' => $radioOption['selected'] ?? false, // Use selected or false as default
                            ]);
                        }
                    }




                }
            }

            // Delete fields that are no longer in the request
            $existingFieldIds = enquiryFormData::where('form_id', $id)->pluck('id')->toArray();
            $idsForDelete = array_diff($existingFieldIds, $requestFieldIds, $newlyCreatedFieldIds);

            if (!empty($idsForDelete)) {
                enquiryFormData::whereIn('id', $idsForDelete)->delete();
            }
        }

        return redirect()->route('settings')->with('success', 'Form updated successfully!');
    }















    // public function editForm($id)
    // {
    //     $form = enquiryForms::findOrFail($id);
    //     $formFields = enquiryFormData::where('form_id', $id)->get();

    //     $formFieldsJson = $formFields->map(function ($field) {
    //         return [
    //             'type' => $field->type,
    //             'subtype' => $field->sub_type,
    //             'access' => $field->access === 0 ? false : true,
    //             'name' => "field_{$field->id}",
    //             'label' => $field->label,
    //             'className' => $field->className ?? 'form-control',
    //             'multiple' => $field->multiple == '1' ? true : false,
    //             'required' => $field->required ? true : false,
    //         ];
    //     });

    //     return view('admin.settings.enquiryForms.edit', [
    //         'form' => $form,
    //         'formFieldsJson' => $formFieldsJson->toJson(),
    //     ]);
    // }


    // public function updateForm(Request $request, $id)
    // {
    //     $form = enquiryForms::findOrFail($id);
    //     $form->name = $request->input('form_name');
    //     $form->save();

    //     $fields = json_decode($request->input('form_data'), true);

    //     if (is_array($fields)) {
    //         $requestFieldIds = [];
    //         $newlyCreatedFieldIds = [];

    //         foreach ($fields as $field) {
    //             $fieldId = isset($field['name']) ? str_replace('field_', '', $field['name']) : null;
    //             $requestFieldIds[] = $fieldId;

    //             $formField = $fieldId ? enquiryFormData::find($fieldId) : null;

    //             if ($formField) {
    //                 $formField->form_id = $id;
    //                 $formField->form_data = json_encode($field);
    //                 $formField->type = $field['type'] ?? null;
    //                 $formField->sub_type = $field['subtype'] ?? null;
    //                 $formField->access = $field['access'] ?? null;
    //                 $formField->name = "field_{$fieldId}";
    //                 $formField->label = $field['label'] ?? null;
    //                 $formField->className = $field['className'] ?? null;
    //                 $formField->multiple = isset($field['multiple']) ? ($field['multiple'] ? '1' : '0') : null;
    //                 $formField->required = isset($field['required']) ? ($field['required'] ? '1' : null) : null;
    //                 $formField->save();





    //             } else {
    //                 $newField = enquiryFormData::create([
    //                     'form_id' => $form->id,
    //                     'form_data' => json_encode($field),
    //                     'type' => $field['type'] ?? null,
    //                     'sub_type' => $field['subtype'] ?? null,
    //                     'access' => $field['access'] ?? null,
    //                     'name' => "field_{$field['name']}",
    //                     'label' => $field['label'] ?? null,
    //                     'className' => $field['className'] ?? 'form-control',
    //                     'multiple' => isset($field['multiple']) ? ($field['multiple'] ? '1' : '0') : null,
    //                     'required' => isset($field['required']) ? ($field['required'] ? '1' : null) : null,
    //                 ]);

    //                 $newlyCreatedFieldIds[] = $newField->id;

    //                 $newField->name = "field_{$newField->id}";
    //                 $newField->save();

    //                 if ($field['type'] === 'select' && isset($field['values'])) {
    //                     foreach ($field['values'] as $option) {
    //                         enquiryFormOptions::create([
    //                             'field_id' => $newField->id,
    //                             'label' => $option['label'],
    //                             'value' => $option['value'],
    //                             'selected' => $option['selected'] ?? false,
    //                         ]);
    //                     }

    //                 }

    //             }
    //         }

    //         $existingFieldIds = enquiryFormData::where('form_id', $id)->pluck('id')->toArray();

    //         $idsForDelete = array_diff($existingFieldIds, $requestFieldIds, $newlyCreatedFieldIds);

    //         if (!empty($idsForDelete)) {
    //             enquiryFormData::whereIn('id', $idsForDelete)->delete();
    //         }
    //     }

    //     return redirect()->route('settings')->with('success', 'Form updated successfully!');
    // }





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
