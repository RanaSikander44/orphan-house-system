@extends('admin.default')

@section('Page-title', 'Edit Role')

@section('content')
<div class="container-fluid px-4">
    <div class="card bg-white px-4 py-3 mt-4 border-0 shadow-sm rounded">
        <h5 class="mb-4">Edit Role</h5>

        <form action="{{ route('roles.update', $role->id) }}" method="POST">
            @csrf
            @method('PUT') <!-- Required for updating resources -->

            <!-- Role Name -->
            <div class="col-6 mb-3">
                <label for="roleName" class="form-label fw-bold">Role Name</label>
                <input type="text" class="form-control @error('name') is-invalid @enderror" id="roleName" name="name"
                    placeholder="Enter role name" value="{{ old('name', $role->name) }}" required>
                @error('name')
                    <div class="text-danger mt-1">{{ $message }}</div>
                @enderror
            </div>


            <!-- Permissions -->
            <div class="col-12 mt-4">
                <h5 class="mt-4 mb-3">Assign Permissions</h5>

                <div class="row">
                    @foreach ($permissions as $permission)
                        <div class="col-md-4 mb-2">
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="permission_{{ $permission->id }}"
                                    name="permissions[]" value="{{ $permission->id }}" {{ $role->permissions->contains('id', $permission->id) ? 'checked' : '' }}>
                                <label class="form-check-label" for="permission_{{ $permission->id }}">
                                    {{ ucfirst($permission->name) }}
                                </label>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Submit Button -->
            <div class="col-12 mt-4">
                <button type="submit" class="btn btn-primary">Update Role</button>
            </div>
        </form>
    </div>
</div>
@endsection