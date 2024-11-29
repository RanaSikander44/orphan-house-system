@extends('admin.default')

@section('Page-title', 'Roles')

@section('content')
<div class="container-fluid px-4">
    <div class="card bg-white px-4 py-3 mt-4 border-0 shadow-sm rounded">
        <h5 class="mb-4">Create New Role</h5>
        <form action="{{ route('roles.store') }}" method="POST">
            @csrf
            <div class="mb-3 col-6">
                <label for="roleName" class="form-label fw-bold">Role Name</label>
                <input 
                    type="text" 
                    class="form-control @error('name') is-invalid @enderror" 
                    id="roleName" 
                    name="name" 
                    placeholder="Enter role name" 
                    value="{{ old('name') }}"
                    required
                >
                @error('name')
                    <div class="text-danger mt-1">{{ $message }}</div>
                @enderror
            </div>

            <h5 class="mt-4 mb-3">Assign Permissions</h5>
            <div class="row">
                @foreach ($permissions as $permission)
                    <div class="col-md-4 mb-2">
                        <div class="form-check">
                            <input 
                                type="checkbox" 
                                class="form-check-input" 
                                id="permission_{{ $permission->id }}" 
                                name="permissions[]" 
                                value="{{ $permission->id }}"
                                {{ old('permissions') && in_array($permission->id, old('permissions')) ? 'checked' : '' }}
                            >
                            <label class="form-check-label" for="permission_{{ $permission->id }}">
                                {{ ucfirst($permission->name) }}
                            </label>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="mt-4">
                <button type="submit" class="btn btn-primary">Create Role</button>
                <a href="{{ route('roles.index') }}" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection
