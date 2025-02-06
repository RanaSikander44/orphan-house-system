@extends('admin.default')

@section('Page-title', 'Create Role')

@section('content')
<div class="container-fluid px-4">
    <div class="card bg-white px-4 py-3 mt-4 border-0 shadow-sm rounded">
        <h5 class="mb-4">Create Role</h5>

        <form action="{{ route('roles.store') }}" method="POST">
            @csrf

            <!-- Role Name -->
            <div class="col-6 mb-3">
                <label for="roleName" class="form-label fw-bold">Role Name</label>
                <input type="text" class="form-control @error('name') is-invalid @enderror" id="roleName" name="name"
                    placeholder="Enter role name" value="{{ old('name') }}" required>
                @error('name')
                    <div class="text-danger mt-1">{{ $message }}</div>
                @enderror
            </div>

            <!-- Permissions Section -->
            <div class="col-12 mt-4">
                <h5 class="mt-4 mb-3">Assign Permissions</h5>

                @if (!empty($sidebarMenus) && count($sidebarMenus) > 0)
                    <div class="form-check mb-3">
                        <input type="checkbox" id="selectAllPermissions" class="form-check-input">
                        <label class="form-check-label fw-bold text-primary" for="selectAllPermissions">
                            Select All Permissions
                        </label>
                    </div>

                    <div class="accordion" id="permissionAccordion">
                        @foreach($sidebarMenus as $menu)
                            @if ($menu->submenus->isEmpty())
                                <div style="border : 1px solid #dee2e6  ;">
                                    <div class="form-check" style="margin-left  : 5%; padding : 10px 0px;">
                                        <input type="checkbox" class="form-check-input permission-checkbox"
                                            id="menu_{{ $menu->id }}" name="permissions[]"
                                            value="{{ $menu->permission }}">
                                        <label class="form-check-label" for="menu_{{ $menu->id }}">
                                            {{ ucfirst($menu->title) }}
                                        </label>
                                    </div>
                                </div>
                            @else
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="heading{{ $menu->id }}">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                            data-bs-target="#collapse{{ $menu->id }}" aria-expanded="false"
                                            aria-controls="collapse{{ $menu->id }}">
                                            <input type="checkbox" class="form-check-input me-2 section-checkbox"
                                                id="menu_{{ $menu->id }}" name="permissions[]"
                                                value="{{ $menu->permission }}">
                                            <label for="menu_{{ $menu->id }}">
                                                {{ ucfirst($menu->title) }}
                                            </label>
                                        </button>
                                    </h2>

                                    <div id="collapse{{ $menu->id }}" class="accordion-collapse collapse"
                                        aria-labelledby="heading{{ $menu->id }}" data-bs-parent="#permissionAccordion">
                                        <div class="accordion-body">
                                            @foreach ($menu->submenus as $submenu)
                                                <div class="form-check">
                                                    <input type="checkbox" class="form-check-input permission-checkbox"
                                                        id="submenu_{{ $submenu->id }}" name="permissions[]"
                                                        value="{{ $submenu->permission }}">
                                                    <label class="form-check-label" for="submenu_{{ $submenu->id }}">
                                                        {{ ucfirst($submenu->title) }}
                                                    </label>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </div>
                @else
                    <p class="text-danger">No permissions available.</p>
                @endif
            </div>

            <!-- Submit Button -->
            <div class="col-12 mt-4">
                <button type="submit" class="btn btn-success">Create Role</button>
            </div>
        </form>
    </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function() {
    const selectAll = document.getElementById("selectAllPermissions");
    const sectionCheckboxes = document.querySelectorAll(".section-checkbox");
    const permissionCheckboxes = document.querySelectorAll(".permission-checkbox");

    selectAll.addEventListener("change", function() {
        let isChecked = this.checked;
        sectionCheckboxes.forEach(checkbox => checkbox.checked = isChecked);
        permissionCheckboxes.forEach(checkbox => checkbox.checked = isChecked);
    });

    sectionCheckboxes.forEach(section => {
        section.addEventListener("change", function() {
            let sectionId = this.id.replace("menu_", "");
            let permissions = document.querySelectorAll(`#collapse${sectionId} .permission-checkbox`);
            permissions.forEach(permission => permission.checked = section.checked);
            updateSectionCheckboxes();
        });
    });

    function updateSectionCheckboxes() {
        sectionCheckboxes.forEach(section => {
            let sectionId = section.id.replace("menu_", "");
            let permissions = document.querySelectorAll(`#collapse${sectionId} .permission-checkbox`);
            let checkedPermissions = [...permissions].filter(perm => perm.checked).length;
            let totalPermissions = permissions.length;

            if (checkedPermissions > 0) {
                section.checked = true;
            } else {
                section.checked = false;
            }
        });

        let allPermissionsChecked = [...permissionCheckboxes].every(perm => perm.checked);
        selectAll.checked = allPermissionsChecked;
    }

    permissionCheckboxes.forEach(permission => {
        permission.addEventListener("change", function() {
            updateSectionCheckboxes();
        });
    });

    updateSectionCheckboxes();
});
</script>
@endsection