<?php

namespace App\Http\Controllers;

use App\Models\enquiry_types;
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
        $data = enquiry_types::findOrFail($id);
        $data->delete();

        return redirect()->route('enquiry-types.index')->with('success', 'Enquiry Type deleted!');
    }
}
