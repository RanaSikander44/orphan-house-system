<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\child;
use App\Models\child_documents;
use App\Models\DocumentTitlesStaff;
use App\Models\donorSettings;
use App\Models\enquiryForms;
use App\Models\settings;
use App\Models\DocumentTitleChild;
use App\Models\documents_title;
use App\Models\Staff;
use App\Models\StaffDocuments;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    public function index()
    {
        $settings = settings::first();
        $donorSetting = donorSettings::first();
        $child_documents = DocumentTitleChild::all();
        $staff_documents = DocumentTitlesStaff::all();
        $forms = enquiryForms::orderBy('id', 'desc')->paginate(5);
        return view('admin.settings.index', compact('settings', 'child_documents', 'donorSetting', 'staff_documents', 'forms'));
    }

    public function store(Request $req)
    {
        // Update or create the settings record
        $settings = settings::updateOrCreate(
            ['id' => 1],  // Assuming you're updating the first record
            [
                'min_age_of_child' => $req->min_age_of_child,
                'max_age_of_child' => $req->max_age_of_child,
                'charges_of_a_child' => $req->charges_of_a_child
            ]
        );



        if ($req->has('child_documents_title') && is_array($req->child_documents_title)) {
            $children = Child::all(); // Fetch all children once

            foreach ($req->child_documents_title as $id => $title) {
                if (strpos($id, 'new_') !== false) {
                    // Create new document
                    $document = DocumentTitleChild::create([
                        'title' => $title,
                        'required' => isset($req->child_documents_required[$id]) ? '1' : '0'
                    ]);
                } else {
                    // Update existing document
                    $document = DocumentTitleChild::find($id);
                    if ($document) {
                        $document->update([
                            'title' => $title,
                            'required' => isset($req->child_documents_required[$id]) ? '1' : '0'
                        ]);
                    }
                }

                foreach ($children as $child) {
                    if (!child_documents::where('child_id', $child->id)->where('title', $document->id)->exists()) {
                        child_documents::create([
                            'child_id' => $child->id,
                            'title' => $document->id,
                            'name' => null,
                        ]);
                    }
                }
            }
        }


        // this code will add new document title and allows also to the already added childs to add new documents 

        // if ($req->has('child_documents_title') && is_array($req->child_documents_title)) {
        //     foreach ($req->child_documents_title as $id => $title) {
        //         if (!empty($title)) {
        //             // Determine if the document is required (default to 0 if not specified)
        //             $isRequired = isset($req->child_documents_required[$id]) && $req->child_documents_required[$id] == 'on' ? 1 : 0;

        //             if ($id) {
        //                 // Update or create the document
        //                 $document = DocumentTitleChild::updateOrCreate(
        //                     ['id' => $id],
        //                     ['title' => $title, 'required' => $isRequired]
        //                 );  

        //                 // Link document to all children
        //                 $children = Child::all();
        //                 foreach ($children as $child) {
        //                     if (!child_documents::where('child_id', $child->id)->where('title', $document->id)->exists()) {
        //                         child_documents::create([
        //                             'child_id' => $child->id,
        //                             'title' => $document->id,
        //                             'name' => null,
        //                         ]);
        //                     }
        //                 }
        //             } else {
        //                 // Create a new document
        //                 $document = DocumentTitleChild::create([
        //                     'title' => $title,
        //                     'required' => $isRequired,
        //                 ]);

        //                 // Link document to all children
        //                 $children = Child::all();
        //                 foreach ($children as $child) {
        //                     if (!child_documents::where('child_id', $child->id)->where('title', $document->id)->exists()) {
        //                         child_documents::create([
        //                             'child_id' => $child->id,
        //                             'title' => $document->id,
        //                             'name' => null,
        //                         ]);
        //                     }
        //                 }
        //             }
        //         }
        //     }
        // }



        // child new documents end here code by Rana Sikander





        // Staff Titles


        if ($req->has('staff_document_title') && is_array($req->staff_document_title)) {
            foreach ($req->staff_document_title as $id => $title) {
                if (!empty($title)) {
                    if (strpos($id, 'new_') !== false) {
                        // Create new document (for IDs starting with "new_")
                        $document = DocumentTitlesStaff::create(['title' => $title]);
                    } else {
                        // Update existing document
                        $document = DocumentTitlesStaff::updateOrCreate(
                            ['id' => $id],
                            ['title' => $title]
                        );
                    }

                    // Now, link this title to all staff who don't already have it
                    $staffMembers = Staff::all();
                    foreach ($staffMembers as $staff) {
                        if (!StaffDocuments::where('staff_id', $staff->id)->where('title', $document->id)->exists()) {
                            StaffDocuments::create([
                                'staff_id' => $staff->id,
                                'title' => $document->id,
                                'name' => null,
                            ]);
                        }
                    }
                }
            }
        }



        // Settings of donors 

        // if ($req->has('min_dayes_for_req_donors')) {

        //     $donorSettings = donorSettings::updateOrCreate(
        //         ['id' => 1],
        //         [
        //             'min_dayes_for_req_donors' => $req->min_dayes_for_req_donors,
        //         ]
        //     );
        // }

        // Redirect with success message
        return redirect()->route('settings')->with('success', 'Settings has been saved');
    }

    public function ChildDocDelete($id)
    {
        $doc = DocumentTitleChild::findOrFail($id);
        $doc->delete();

        $childDocuments = child_documents::where('title', $id)->delete();

        return response()->json([

            'success' => 'Document has been delete !',

        ]);
    }


    public function ChildStaffDelete($id)
    {
        $doc = DocumentTitlesStaff::findOrFail($id);
        $doc->delete();

        return response()->json([

            'success' => 'Document has been delete !',

        ]);
    }

}
