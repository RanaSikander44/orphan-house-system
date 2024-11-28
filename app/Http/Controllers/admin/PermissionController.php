<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionController extends Controller
{
    public function index()
    {
        $permissions = Permission::paginate(10);
        return view('admin.permissions.index', compact('permissions'));
    }

    public function store(Request $req)
    {
        $permissions = new permission();
        $permissions->name = $req->name;
        $permissions->save();
        return redirect()->route('permissions.index')->with('success', 'Permission has been added !');
    }

    public function update($id, Request $req)
    {
        $permission = Permission::findOrFail($id);
        $permission->name = $req->input('name');
        $permission->save();
        return redirect()->route('permissions.index')->with('success', 'Permission has been updated!');
    }

    public function delete($id)
    {

        $permission = Permission::findOrFail($id);
        $permission->delete();
        return redirect()->route('permissions.index')->with('success', 'Permission has been deleted!');

    }

    public function assign($id)
    {
        // Debug Role
        $role = Role::find(id: $id);
        if (!$role) {
            return "Not found Role";
        }

        // Debug Permission
        $permission = Permission::find(6); // Replace '6' with your actual permission ID
        if (!$permission) {
            return "Not Found Permission";
        }
 
        // Sync Permissions
        $role->syncPermissions([$permission->name]);
        return "done";

        // return redirect()->back()->with('success', 'Permissions assigned to the role successfully!');
    }



}
