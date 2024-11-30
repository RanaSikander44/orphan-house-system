<!-- resources/views/users/edit.blade.php -->
@extends('admin.default')

@section('content')


@if ($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif


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

            <!-- change Password -->
            <div class="mb-3">
                <label for="password" class="form-label">Change Password</label>
                <input type="password" class="form-control" id="email" name="change_password">
            </div>


            <!-- Role -->
            <div class="mb-3">
                <label for="role" class="form-label">Role</label>
                <select class="form-select" id="role" name="role_id" required>
                    <option value="" disabled>Select a role</option>
                    @foreach ($roles as $list)
                        <option value="{{ $list->id }}" {{ isset($user) && $list->id == $user->role_id ? 'selected' : '' }}>
                            {{ $list->role }}
                        </option>
                    @endforeach
                </select>

                </select>

            </div>

            <div class="d-flex justify-content-end">
                <button type="submit" class="btn btn-sm btn-primary px-4 py-2">
                    <i class="fa fa-check"></i> Update
                </button>
            </div>
        </div>
    </form>
</div>
@endsection