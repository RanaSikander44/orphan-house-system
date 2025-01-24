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



        // this code will add new document title and allows also to the already added childs to add new documents 

        if ($req->has('child_documents_title') && is_array($req->child_documents_title)) {
            foreach ($req->child_documents_title as $id => $title) {
                if (!empty($title)) {
                    if ($id) {
                        $document = DocumentTitleChild::updateOrCreate(
                            ['id' => $id],
                            ['title' => $title]
                        );

                        $children = child::all();
                        foreach ($children as $child) {
                            if (!child_documents::where('child_id', $child->id)->where('title', $document->id)->exists()) {
                                child_documents::create([
                                    'child_id' => $child->id,
                                    'title' => $document->id,
                                    'name' => null,
                                ]);
                            }
                        }

                    } else {
                        $document = DocumentTitleChild::create([
                            'title' => $title,
                        ]);

                        $children = Child::all();
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
            }
        }


        // child new documents end here code by Rana Sikander





        // Staff Titles


        if ($req->has('staff_document_title') && is_array($req->staff_document_title)) {
            foreach ($req->staff_document_title as $id => $title) {
                // Skip empty titles
                if (!empty($title)) {
                    if ($id) {
                        // Update existing document if an ID exists
                        $document = DocumentTitlesStaff::updateOrCreate(
                            ['id' => $id],  // If document ID exists, it will update
                            ['title' => $title]
                        );

                        // Now, link this title to all staff who don't already have it
                        $staffMembers = Staff::all();
                        foreach ($staffMembers as $staff) {
                            // Check if the document title is not already linked to this staff member
                            if (!StaffDocuments::where('staff_id', $staff->id)->where('title', $document->id)->exists()) {
                                // If not, create an entry for this staff and title
                                StaffDocuments::create([
                                    'staff_id' => $staff->id,
                                    'title' => $document->id,
                                    'name' => null,  // Default file name is null, can be updated later
                                ]);
                            }
                        }

                    } else {
                        // Create new document if no ID exists (empty string passed)
                        $document = DocumentTitlesStaff::create([
                            'title' => $title,
                        ]);

                        // Now, link this new title to all staff who don't already have it
                        $staffMembers = Staff::all();
                        foreach ($staffMembers as $staff) {
                            // Check if the document title is not already linked to this staff member
                            if (!StaffDocuments::where('staff_id', $staff->id)->where('title', $document->id)->exists()) {
                                // If not, create an entry for this staff and title
                                StaffDocuments::create([
                                    'staff_id' => $staff->id,
                                    'title' => $document->id,
                                    'name' => null,  // Default file name is null, can be updated later
                                ]);
                            }
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
