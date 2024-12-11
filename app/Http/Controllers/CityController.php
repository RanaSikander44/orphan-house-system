<?php

namespace App\Http\Controllers;

use App\Models\City;
use Illuminate\Http\Request;

class CityController extends Controller
{
    public function index()
    {
        $cities = City::all();
        return view('cities.index', compact('cities'));
    }

    public function create()
    {
        return view('cities.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',

        ]);

        City::create($request->all());
        return redirect()->route('cities.index')->with('success', 'City created successfully.');
    }

    public function show(City $city)
    {
        return view('cities.show', compact('city'));
    }

    public function edit(City $city)
    {
        return view('cities.edit', compact('city'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);
      $city = City::findOrFail($id);
     $city->update($request->only('name'));
     return redirect()->route('cities.index')->with('success', 'City updated successfully.');
    }

    public function destroy($id)
    {  $city = City::findOrFail($id);
     $city->delete();
      return redirect()->route('cities.index')->with('success', 'City deleted successfully.');
    }

}
