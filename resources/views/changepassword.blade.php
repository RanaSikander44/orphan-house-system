@extends('admin.default')
@section('Page-title', 'Change Password')

@section('content')
<style>
    .form-container .btn-primary {
        background-color: #007bff; /* Bootstrap blue */
        border-color: #007bff;
        padding: 10px 20px;
        font-size: 16px;
        display: block;
        margin: 0 auto;
    }

    .form-container .btn-primary:hover {
        background-color: #0056b3; /* Darker blue on hover */
        border-color: #004085;
    }
</style>

<div class="container-fluid px-4">
    <div class="card bg-white px-4 py-3 mt-4 border-0 shadow-sm rounded">
        <div class="card-body">
            <!-- Display error messages if there are any -->
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('password.update') }}">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="col-md-6">
                        <label for="current_password" class="form-label">Current Password</label>
                        <input type="password" name="current_password" id="current_password" class="form-control" placeholder="Enter your current password" required>
                    </div>

                    <div class="col-md-6">
                        <label for="new_password" class="form-label">New Password</label>
                        <input type="password" name="new_password" id="new_password" class="form-control" placeholder="Enter a new password" required>
                    </div>

                    <div class="col-md-6 mt-3">
                        <label for="new_password_confirmation" class="form-label">Confirm New Password</label>
                        <input type="password" name="new_password_confirmation" id="new_password_confirmation" class="form-control" placeholder="Re-enter your new password" required>
                    </div>
                </div>
                <div class="d-flex justify-content-end mt-4">
                    <button type="submit" class="btn btn-primary">Update Password</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
