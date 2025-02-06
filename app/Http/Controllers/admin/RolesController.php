<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\menu;
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
        // Get only parent menus
        $sidebarMenus = Menu::whereNull('parent_id')->orderBy('order')->where('status', '1')->get();
        // Attach submenus
        foreach ($sidebarMenus as $menu) {
            $menu->submenus = Menu::where('status'  , '1')->where('parent_id', $menu->id)->orderBy('order')->get();
        }

        return view('admin.role.create', compact('permissions', 'sidebarMenus'));
    }


    public function store(Request $req)
    {
        // Validate the input
        $validated = $req->validate([
            'name' => 'required|string|unique:roles,name',
            'permissions' => 'nullable|array',
            'permissions.*' => 'exists:permissions,name', // Ensure validation matches update function
        ]);

        // Create the role
        $role = Role::create([
            'name' => $validated['name'],
            'guard_name' => 'web',
        ]);

        // Assign permissions (if provided)
        $role->syncPermissions($validated['permissions'] ?? []);

        return redirect()->route('roles.index')->with('success', 'Role created successfully!');
    }


    public function edit($id)
    {
        $role = Role::with('permissions')->findOrFail($id);
        $permissions = Permission::all();

        // Get only parent menus
        $sidebarMenus = Menu::where('status', '1')->whereNull('parent_id')->orderBy('order')->get();

        // Attach submenus
        foreach ($sidebarMenus as $menu) {
            $menu->submenus = Menu::where('status', '1')->where('parent_id', $menu->id)->orderBy('order')->get();
        }

        // Debugging: Log role permissions
        \Log::info('Role Permissions:', $role->permissions->pluck('name')->toArray());

        // Debugging: Log sidebar menus and submenus
        foreach ($sidebarMenus as $menu) {
            \Log::info('Menu:', ['id' => $menu->id, 'title' => $menu->title, 'permission' => $menu->permission]);
            foreach ($menu->submenus as $submenu) {
                \Log::info('Submenu:', ['id' => $submenu->id, 'title' => $submenu->title, 'permission' => $submenu->permission]);
            }
        }

        return view('admin.role.edit', compact('role', 'permissions', 'sidebarMenus'));

    }
    public function update(Request $req, $id)
    {
        $validated = $req->validate([
            'name' => 'required|string|unique:roles,name,' . $id,
            'permissions' => 'nullable|array',
            'permissions.*' => 'exists:permissions,name', // Validate permission names, not IDs
        ]);

        $role = Role::findOrFail($id);

        // Update role name
        $role->update(['name' => $validated['name']]);

        // Assign permissions (handle empty case properly)
        $role->syncPermissions($validated['permissions'] ?? []);

        return redirect()->route('roles.index')->with('success', 'Role updated successfully!');
    }

    public function destroy($id)
    {
        $role = Role::findOrFail($id);
        $role->delete();

        return redirect()->route('roles.index')->with('success', 'Role deleted successfully!');

    }


}
