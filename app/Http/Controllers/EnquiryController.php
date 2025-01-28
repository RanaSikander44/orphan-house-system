<?php

namespace App\Http\Controllers;

use App\Models\child;
use App\Models\child_documents;
use App\Models\ChildActivity;
use App\Models\enquiry_types;
use App\Models\nannyChilds;
use App\Models\ParentModel;
use Illuminate\Http\Request;

class EnquiryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $enquiry = enquiry_types::paginate(10);
        return view('admin.enquiry-types.index', compact('enquiry'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = new enquiry_types();
        $data->title = $request->title;
        $data->status = $request->status;
        $data->save();

        return redirect()->route('enquiry-types.index')->with('success', 'Enquiry Type Added!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $enquiry = enquiry_types::paginate(10);
        $enquiryEdit = enquiry_types::where('id', $id)->first();

        return view('admin.enquiry-types.edit', compact('enquiry', 'enquiryEdit'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {

        $data = enquiry_types::findOrFail($id);
        $data->title = $request->title;
        $data->status = $request->status;
        $data->update();

        return redirect()->route('enquiry-types.index')->with('success', 'Enquiry Type Updated!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {

        // it will delete all the childs , their parents data , documents , activities , also will remove it 
        //  nanny assigned table

        $children = child::where('enquiry_id', $id)->get(); // Retrieve the children records

        foreach ($children as $child) {
            // Check if related child_documents exist before deleting
            if (child_documents::where('child_id', $child->id)->exists()) {
                child_documents::where('child_id', $child->id)->delete();
            }

            // Check if related ParentModel records exist before deleting
            if (ParentModel::where('child_id', $child->id)->exists()) {
                ParentModel::where('child_id', $child->id)->delete();
            }

            // Check if related ChildActivity records exist before deleting
            if (ChildActivity::where('child_id', $child->id)->exists()) {
                ChildActivity::where('child_id', $child->id)->delete();
            }

            // Check if related nannyChilds records exist before deleting
            if (nannyChilds::where('child_id', $child->id)->exists()) {
                nannyChilds::where('child_id', $child->id)->delete();
            }
        }

        // Check if any children exist before attempting to delete
        if ($children->isNotEmpty()) {
            child::where('enquiry_id', $id)->delete();
        }

        // Check if the enquiry_type exists before attempting to delete
        $data = enquiry_types::find($id); // Using find() instead of findOrFail to prevent exceptions if not found
        if ($data) {
            $data->delete();
        } else {
            return redirect()->route('enquiry-types.index')->with('error', 'Enquiry Type not found!');
        }

        return redirect()->route('enquiry-types.index')->with('success', 'Enquiry Type deleted!');

    }
}
