<!-- resources/views/users/edit.blade.php -->
@extends('admin.default')

@section('content')
<div class="container-fluid px-4">
    <h3 class="mt-4">Edit User</h3>

    <form action="{{ route('users.update', $user->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="card bg-white p-3 mt-5 border-0 shadow-sm rounded">
            <!-- Name -->
            <div class="mb-3">
                <label for="name" class="form-label">Name</label>
                <input type="text" class="form-control" id="name" name="name" value="{{ $user->name }}" required>
            </div>

            <!-- Email -->
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" value="{{ $user->email }}" required>
            </div>

            <!-- Role -->
            <div class="mb-3">
                <label for="role" class="form-label">Role</label>
                <select class="form-select" id="role" name="role" required>
                    <option value="" disabled>Select a role</option>
                    <option value="admin" {{ $user->role === 'admin' ? 'selected' : '' }}>Admin</option>
                    <option value="user" {{ $user->role === 'user' ? 'selected' : '' }}>User</option>
                    <option value="donor" {{ $user->role === 'donor' ? 'selected' : '' }}>Donor</option>
                </select>
            </div>

            <button type="submit" class="btn btn-primary">Update User</button>
        </div>
    </form>
</div>
@endsection
