@extends('admin.default')

@section('Page-title', 'Enquiry Forms Create')

@section('content')

<div class="container-fluid px-4">
    <div class="card bg-white px-4 py-3 mt-4 border-0 shadow-sm rounded">
        <div class="card-body">
            <form action="{{ route('enquiry.forms.save') }}" method="POST" id="FormSave">
                @csrf
                <div class="col-md-6 mb-3">
                    <label for="form_name" class="fw-bold mb-2">Form Name</label>
                    <input type="text" name="form_name" class="form-control" value="{{ old('form_name') }}" required>
                    @error('form_name')
                        <p class="text-danger">{{ $message }}</p>
                    @enderror
                </div>
                <hr>
                <div id="fb-editor"></div>
                <input type="hidden" name="form_data" id="form-data">
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
        $(function () {
            // Initialize FormBuilder with options
            const formBuilder = $('#fb-editor').formBuilder({
                onSave: function () {
                    const formData = formBuilder.actions.getData(); // Get form JSON
                    $('#form-data').val(JSON.stringify(formData)); // Set it in a hidden input
                    $('#FormSave').submit(); // Submit the form
                }
            });
        });
    </script>
@endpush

@endsection