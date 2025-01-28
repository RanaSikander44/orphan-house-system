@extends('admin.default')

@section('Page-title', 'Edit Enquiry Forms')

@section('content')

<div class="container-fluid px-4">
    <div class="card bg-white px-4 py-3 mt-4 border-0 shadow-sm rounded">
        <div class="card-body">
            <form action="{{ route('enquiry.forms.update', $form->id) }}" method="POST" id="FormUpdate">
                @csrf
                @method('PUT')

                <!-- Form Name -->
                <div class="col-md-6 mb-3">
                    <label for="form_name" class="fw-bold mb-2">Form Name</label>
                    <input type="text" name="form_name" class="form-control" value="{{ old('form_name', $form->name) }}"
                        required>
                    @error('form_name')
                        <p class="text-danger">{{ $message }}</p>
                    @enderror
                </div>
                <hr>

                <!-- Form Builder -->
                <div id="fb-editor">
                </div>

                <!-- Hidden Input for JSON -->
                <input type="hidden" name="form_data" id="form-data" value="{{ $form->form_data }}">
            </form>
        </div>
    </div>
</div>

@push('scripts')
    <!-- jQuery -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

    <!-- jQuery UI -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.13.2/jquery-ui.min.js"></script>

    <!-- FormBuilder -->
    <script src="https://formbuilder.online/assets/js/form-builder.min.js"></script>
    <script src="https://formbuilder.online/assets/js/form-render.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Preload form data from the database
            const formData = @json($formFieldsJson);

            // Initialize the Form Builder
            const fbEditor = document.getElementById('fb-editor');
            const options = {
                formData: formData, // Load existing form fields with IDs
                onSave: function (e, formData) {
                    // Update hidden input when form is saved
                    document.getElementById('form-data').value = formData;
                    $('#FormUpdate').submit(); // Submit the form
                },
            };

            $(fbEditor).formBuilder(options);
        });
    </script>
@endpush

@endsection