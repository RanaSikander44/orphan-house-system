<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\settings;
use App\Models\documents_title;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    public function index()
    {
        $settings = settings::first();
        $child_documents = documents_title::where('document_for', 'child')->get();
        $staff_documents = documents_title::where('document_for', 'staff')->get();
        return view('admin.settings.index', compact('settings', 'child_documents', 'staff_documents'));
    }

    public function store(Request $req)
    {

        // Update or create the settings record
        $settings = settings::updateOrCreate(
            ['id' => 1],  // Assuming you're updating the first record
            [
                'min_age_of_child' => $req->min_age_of_child,
                'max_age_of_child' => $req->max_age_of_child,
            ]
        );

        // Handle document titles (create new documents for the child if provided)
        if ($req->has('student_document_title') && is_array($req->student_document_title)) {
            foreach ($req->student_document_title as $id => $title) {
                // Skip empty titles
                if (!empty($title)) {
                    if ($id) {
                        // Update existing document if an ID exists
                        documents_title::updateOrCreate(
                            ['id' => $id],  // If document ID exists, it will update
                            [
                                'document_for' => 'child',
                                'title' => $title,
                            ]
                        );
                    } else {
                        // Create new document if no ID exists (empty string passed)
                        documents_title::create([
                            'document_for' => 'child',
                            'title' => $title,
                        ]);
                    }
                }
            }
        }


        // Stafff Titles


        if ($req->has('staff_document_title') && is_array($req->staff_document_title)) {
            foreach ($req->staff_document_title as $id => $title) {
                // Skip empty titles
                if (!empty($title)) {
                    if ($id) {
                        // Update existing document if an ID exists
                        documents_title::updateOrCreate(
                            ['id' => $id],  // If document ID exists, it will update
                            [
                                'document_for' => 'staff',
                                'title' => $title,
                            ]
                        );
                    } else {
                        // Create new document if no ID exists (empty string passed)
                        documents_title::create([
                            'document_for' => 'staff',
                            'title' => $title,
                        ]);
                    }
                }
            }
        }

        // Redirect with success message
        return redirect()->route('settings')->with('success', 'Settings has been saved');
    }


    public function delete($id)
    {
        $doc = documents_title::findOrFail($id);
        $doc->delete();

        return response()->json([

            'success' => 'Document has been delete !',

        ]);
    }

}
