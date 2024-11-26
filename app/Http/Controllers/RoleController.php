<?php

namespace App\Http\Controllers;

use App\Models\Role; // Assuming you have a Role model now
use Illuminate\Http\Request;

class RoleController extends Controller
{
    // Display a listing of the roles
    public function index()
    {
        $roles = Role::paginate(10); // Paginate with 10 roles per page
        return view('role.index', compact('roles'));
    }

    // Show the form for creating a new role
    public function create()
    {
        return view('role.create');
    }

    // Store a newly created role in storage
    public function store(Request $request)
    {
        // Validate input - no predefined options for roles
        $request->validate([
            'role' => 'required|string|max:255', // Allow any string, no restrictions
        ]);
    
        // Create a new role
        Role::create([
            'role' => $request->role,
        ]);
    
        // Redirect back with a success message
        return redirect()->route('roles.index')->with('success', 'Role added successfully.');
    }
    
    // Show the form for editing the specified role
    public function edit(Role $role)
    {
        return view('role.edit', compact('role'));
    }

    // Update the specified role in storage
    public function update(Request $request, Role $role)
    {
        // Validate the incoming request - no restrictions
        $request->validate([
            'role' => 'required|string|max:255', // Allow any string, no restrictions
        ]);

        // Update the role's name
        $role->role = $request->input('role');
        $role->save();

        // Redirect back with a success message
        return redirect()->route('roles.index')->with('success', 'Role updated successfully.');
    }

    // Remove the specified role from storage
    public function destroy(Role $role)
    {
        // Delete the role from the database
        $role->delete();

        // Redirect back with a success message
        return redirect()->route('roles.index')->with('success', 'Role deleted successfully.');
    }
}
