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
    <div class="d-flex justify-content-between align-items-center mt-4 mb-3">
        <h3 class="fw-bold">Add New User</h3>
        <a href="{{ route('users') }}" class="btn btn-sm btn-secondary">Back to Users</a>
    </div>

    <div class="card bg-white border-0 shadow-sm rounded">
        <div class="card-body p-4">
            <form action="{{ route('users.store') }}" method="POST">
                @csrf

                <!-- Name -->
                <div class="mb-3">
                    <label for="name" class="form-label fw-semibold">Name</label>
                    <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" required
                        placeholder="Enter user name">
                </div>

                <!-- Email -->
                <div class="mb-3">
                    <label for="email" class="form-label fw-semibold">Email</label>
                    <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" required
                        placeholder="Enter email address">
                </div>

                <!-- Password -->
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="password" class="form-label fw-semibold">Password</label>
                        <input type="password" class="form-control" id="password" name="password" required
                            placeholder="Enter password">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="password_confirmation" class="form-label fw-semibold">Confirm Password</label>
                        <input type="password" class="form-control" id="password_confirmation"
                            name="password_confirmation" required placeholder="Re-enter password">
                    </div>
                </div>

                <!-- Role -->
                <div class="mb-3">
                    <label for="role" class="form-label fw-semibold">Role</label>
                    <select class="form-select" id="role" name="role_id" required>
                        <option value="" disabled selected>Select a role</option>
                        @foreach ($roles as $list)

                        <option value="{{ $list->id }}">{{ $list->role }}</option>
                        
                        @endforeach
                        
                    </select>
                </div>

                <!-- Submit Button -->
                <div class="d-flex justify-content-end">
                    <button type="submit" class="btn btn-sm btn-primary px-4 py-2">
                        <i class="fa fa-check"></i> Save
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection