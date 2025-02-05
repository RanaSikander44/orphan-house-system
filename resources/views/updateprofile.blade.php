@extends('admin.default')
@section('Page-title', 'Update Profile')

@section('content')
<style>
    .profile-container {
        text-align: center;
        position: relative;
        display: inline-block;
        width: 120px;
        

    }

    .profile-photo {
        width: 120px;
        height: 120px;
        border-radius: 0px;
        object-fit: cover;
        border: 2px solid #ddd;
        background-color: #f8f9fa;
        

    }

    .edit-icon {
        position: absolute;
        top: 20px;
        right: -5px;
        background: white;
        border-radius: 50%;
        padding: 5px;
        cursor: pointer;
        box-shadow: 0px 0px 5px rgba(0, 0, 0, 0.3);
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .form-row {
        display: flex;
        gap: 20px;
        justify-content: center;
        margin-bottom: 20px;
    }

    .form-row .form-group {
        flex: 1;
    }

    .form-actions {
        display: flex;
        justify-content: flex-end;
        gap: 10px;
        margin-top: 20px;
    }

    .btn-primary {
        background-color: #007bff;
        border-color: #007bff;
        padding: 10px 20px;
        font-size: 16px;
    }

    .btn-primary:hover {
        background-color: #0056b3;
        border-color: #004085;
    }

    .btn-secondary {
        background-color: #6c757d;
        border-color: #6c757d;
        padding: 10px 20px;
        font-size: 16px;
    }

    .btn-secondary:hover {
        background-color: #5a6268;
        border-color: #545b62;
    }

    .form-label {
        font-weight: bold;
        
    }

    .profile-container label {
        font-weight: bold;
        display: block;
        /* margin-top: 4px; */
        margin-left: -10px; /* Moves the label a little to the left */
    }

</style>

<div class="container-fluid px-4">
    <div class="card bg-white px-4 py-3 mt-4 border-0 shadow-sm rounded">
        <div class="card-body">
            <!-- Display error messages  -->
            @if ($errors->any())
            <div class="alert alert-danger p-2">
                @foreach ($errors->all() as $error)
                    <p class="mb-1">{{ $error }}</p>
                @endforeach
            </div>
            @endif

            <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
                @csrf
                @method('PUT') 
                <!-- Profile Photo -->
                <div class="form-group ">
                <div class="profile-container mx-auto">
                    <label for="profile_photo" class="form-label">Profile Photo</label>
                    <img src="{{ $user->profile_photo ? asset( $user->profile_photo) : asset('default-profile.png') }}" 
                         alt="" class="profile-photo" id="profilePreview">
                    <label for="profile_photo" class="edit-icon">
                        <i class="fa fa-pencil"></i>
                    </label>
                </div>
                    <!-- Hidden file input -->
                    <input type="file" id="profile_photo" name="profile_photo" style="display: none;" accept="image/*">
                    @error('profile_photo')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
            
                <!-- Form Fields -->
                <div class="form-row mt-4">
                    <!-- Full Name -->
                    <div class="form-group ">
                        <label for="full_name" class="form-label">Full Name</label>
                        <input type="text" name="full_name" class="form-control" value="{{ old('full_name', $fullName) }}" required>
                        @error('full_name')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
            
                    <!-- Email -->
                    <div class="form-group">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" name="email" class="form-control" value="{{ old('email', $user->email) }}" required>
                        @error('email')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            
                <!-- Action Buttons -->
                <div class="form-actions">
                    <button type="submit" class="btn btn-primary">Save</button>
                    <button type="button" class="btn btn-secondary" onclick="window.location.href='{{ route('dashboard') }}'">Cancel</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    // preview box updates when a file is selected
    document.getElementById('profile_photo').addEventListener('change', function(event) {
        const file = event.target.files[0];
        const preview = document.getElementById('profilePreview');

        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.src = e.target.result; // Update the preview box
            }
            reader.readAsDataURL(file); // Read the image file
        }
    });

    // image preview is retained on page load if a photo is available
    window.addEventListener('DOMContentLoaded', function() {
        const preview = document.getElementById('profilePreview');
        if (!preview.src || preview.src.includes('default-profile.png')) {
            preview.style.display = 'block'; // Ensure the box is visible
        }
    });
</script>
@endsection
