<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesController extends Controller
{
    public function index()
    {
        $roles = Role::paginate(10);
        return view('admin.role.index', compact('roles'));
    }

    public function create()
    {
        $permissions = Permission::all();
        return view('admin.role.create', compact('permissions'));
    }

    public function store(Request $req)
    {
        // Validate the input
        $validated = $req->validate([
            'name' => 'required|string|unique:roles,name',
            'permissions' => 'nullable|array',
            'permissions.*' => 'exists:permissions,id',
        ]);

        $role = Role::create([
            'name' => $validated['name'],
            'guard_name' => 'web',
        ]);

        if (!empty($validated['permissions'])) {
            $permissions = \Spatie\Permission\Models\Permission::whereIn('id', $validated['permissions'])->pluck('name');
            $role->givePermissionTo($permissions);
        }

        return redirect()->route('roles.index')->with('success', 'Role created successfully!');
    }


    public function edit($id)
    {
        $role = Role::findOrFail($id); 
        $permissions = Permission::all();

        return view('admin.role.edit', compact('role', 'permissions'));
    }

    public function update(Request $req, $id)
    {
        $validated = $req->validate([
            'name' => 'required|string|unique:roles,name,' . $id,
            'permissions' => 'nullable|array',
            'permissions.*' => 'exists:permissions,id', 
        ]);

        $role = Role::findOrFail($id);

        $role->update(['name' => $validated['name']]);

        if (!empty($validated['permissions'])) {
            $permissions = \Spatie\Permission\Models\Permission::whereIn('id', $validated['permissions'])->pluck('name');
            $role->syncPermissions($permissions);
        } else {
            $role->syncPermissions([]);
        }

        return redirect()->route('roles.index')->with('success', 'Role updated successfully!');
    }


    public  function destroy($id)
    {
        $role = Role::findOrFail($id);
        $role->delete();

        return redirect()->route('roles.index')->with('success', 'Role deleted successfully!');

    }


}
