@extends('admin.default')

@section('Page-title', 'Add Child Activity')

@section('content')

<div class="container-fluid px-4">

    <div class="card mt-4 shadow-sm border-0">
        <div class="card-body px-4">
            <div class="row">
                <!-- Nanny Filter -->
                <div class="col-md-4 mb-3">
                    <label for="select-nanny" class="fw-bold mb-3">Filter by Nanny</label>
                    <select name="nanny" id="select-nanny" class="form-control select2">
                        <option value=""> -- Select Nanny -- </option>
                        @foreach ($nannies as $list)
                            <option value="{{ $list->id }}">{{ $list->first_name }} {{ $list->last_name }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- School Filter -->
                <div class="col-md-4 mb-3">
                    <label for="select-school" class="fw-bold mb-3">Filter by School</label>
                    <select name="school" id="select-school" class="form-control select2">
                        <option value="">-- Select School --</option>
                        @foreach ($schools as $list)
                            <option value="{{ $list->id }}">{{ $list->name }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Clear Filters -->
                <div class="col-md-4 mb-3 d-flex align-items-end">
                    <a href="" class="btn btn-sm btn-primary">
                        Clear All
                    </a>
                </div>
            </div>
        </div>
    </div>



    <div class="card mt-4 border-0 shadow-sm rounded">
        <form action="{{ route('activity.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="card-body">
                <div class="row gy-3">
                    <div class="col-md-6">
                        <label for="select-user" class="form-label">Select Child</label>
                        <select name="child_id" id="" class="form-control" required>
                            @foreach ($children as $list)
                                <option value="{{ $list->id }}">{{ $list->first_name }} {{ $list->last_name }}</option>
                            @endforeach
                        </select>

                        @error('child_id')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label for="activity-name" class="form-label">Activity Name</label>
                        <input type="text" id="activity-name" name="name" class="form-control"
                            placeholder="Enter activity name">

                        @error('name')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror

                    </div>

                    <div class="col-md-6">
                        <label for="date" class="form-label">Activity Date</label>
                        <input type="date" id="date" name="activity_date" class="form-control">

                        @error('activity_date')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label for="description" class="form-label">Activity Description</label>
                        <textarea id="description" name="desc" class="form-control" rows="3"
                            placeholder="Enter activity details"></textarea>

                        @error('desc')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label for="images" class="form-label">Upload Images</label>
                        <input type="file" id="images" name="images[]" class="form-control" accept="image/*" multiple>
                        <small class="text-muted">You can upload multiple images (JPEG, PNG, etc.).</small>

                        <div id="image-preview-container" class="mt-3 d-flex flex-wrap gap-2"></div>
                        @error('images')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror

                    </div>
                </div>
            </div>
            <div class="card-footer text-end bg-white">
                <button type="submit" class="btn btn-sm btn-primary">Save Activity</button>
            </div>
        </form>
    </div>
</div>


<script>
    document.addEventListener('DOMContentLoaded', () => {
        const imageInput = document.getElementById('images');
        const previewContainer = document.getElementById('image-preview-container');
        const selectedFiles = new DataTransfer(); // Custom DataTransfer for managing files

        imageInput.addEventListener('change', function (event) {
            Array.from(event.target.files).forEach((file, index) => {
                selectedFiles.items.add(file); // Add new file to DataTransfer
                displayPreview(file, selectedFiles.items.length - 1);
            });

            imageInput.files = selectedFiles.files;
        });

        function displayPreview(file, index) {
            const reader = new FileReader();

            reader.onload = function (e) {
                const wrapper = document.createElement('div');
                wrapper.classList.add('position-relative');
                wrapper.style.width = '100px';
                wrapper.style.height = '100px';

                const img = document.createElement('img');
                img.src = e.target.result;
                img.style.width = '100%';
                img.style.height = '100%';
                img.style.objectFit = 'cover';
                img.classList.add('rounded', 'border');

                const removeButton = document.createElement('button');
                removeButton.innerHTML = '&times;';
                removeButton.classList.add('btn', 'btn-info', 'btn-sm', 'position-absolute', 'top-0', 'end-0', 'p-0', 'd-flex', 'align-items-center', 'justify-content-center');
                removeButton.style.width = '20px';
                removeButton.style.height = '20px';
                removeButton.style.borderRadius = '50%';
                removeButton.style.transform = 'translate(50%, -50%)';
                removeButton.style.fontSize = '14px';


                removeButton.addEventListener('click', () => {
                    selectedFiles.items.remove(index);
                    imageInput.files = selectedFiles.files;
                    wrapper.remove();
                });

                wrapper.appendChild(img);
                wrapper.appendChild(removeButton);

                previewContainer.appendChild(wrapper);
            };

            reader.readAsDataURL(file);
        }
    });
</script>

<script>
    $(document).ready(function () {
        $('.select2').select2({
            placeholder: "Select an option",
            allowClear: true
        });
    });
</script>

<script>
    $(document).ready(function () {
        // Attach change event to both Nanny and School selects
        $('#select-nanny, #select-school').on('change', function () {
            let nannyId = $('#select-nanny').val(); // Get selected Nanny value
            let schoolId = $('#select-school').val(); // Get selected School value

            // Ensure null is sent for unselected values
            nannyId = nannyId ? nannyId : null;
            schoolId = schoolId ? schoolId : null;

            sendAjaxRequest(nannyId, schoolId); // Send AJAX request
        });

        // Function to send AJAX request
        function sendAjaxRequest(nannyId, schoolId) {
            $.ajax({
                url: '{{ route('filter.child') }}', // Replace with your endpoint
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}', // Include CSRF token
                    nannyId: nannyId,
                    schoolId: schoolId,
                },
                success: function (response) {
                    // Handle successful response
                    console.log('Response:', response);
                },
                error: function (xhr, status, error) {
                    // Handle error
                    console.error('Error:', error);
                },
            });
        }
    });
</script>


@endsection