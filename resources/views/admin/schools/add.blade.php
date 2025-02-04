@extends('admin.default')

@section('Page-title', 'Add School')

@section('content')
<div class="container-fluid px-4">

    <div class="card bg-white px-4 py-3 mt-4 border-0 shadow-sm rounded">
        <div class="card-body">
            <form method="POST" action="{{ route('schools.store') }}">
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <label for="name" class="form-label">School Name</label>
                        <input type="text" name="name" id="name" class="form-control" placeholder="Enter school name"
                            required>
                    </div>

                    <div class="col-md-6">
                        <label for="address" class="form-label">Address</label>
                        <textarea name="address" class="form-control" id="" rows="4" cols="50"></textarea>
                    </div>

                    <div class="col-md-6 mt-3">
                        <label for="grade" class="form-label">Select Grade</label>
                        <div class="custom-multi-select">
                            <div class="select-box form-control">Select Grades</div>
                            <ul class="dropdown-list list-unstyled border rounded shadow-sm mt-1">
                                @foreach ($grade as $list)
                                    <li data-value="{{ $list->id }}" class="px-3 py-2">{{ $list->grade }}</li>
                                @endforeach
                            </ul>
                            <div class="selected-options mt-2"></div>
                            <input type="hidden" name="grade[]" id="selected_grades" value="">
                        </div>
                    </div>



                </div>

                <div class="d-flex justify-content-end mt-4">
                    <button type="submit" class="btn btn-primary">Add School</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection



<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

<script>
    $(document).ready(function () {
        const gradeSelectBox = $('.custom-multi-select .select-box');
        const gradeDropdownList = $('.custom-multi-select .dropdown-list');
        const gradeSelectedOptionsContainer = $('.custom-multi-select .selected-options');
        const gradeSelectedValues = [];

        // Toggle dropdown visibility
        gradeSelectBox.on('click', function () {
            gradeDropdownList.toggle();
        });

        // Select grade
        gradeDropdownList.on('click', 'li', function () {
            const value = $(this).data('value');
            const text = $(this).text();

            // Check if the grade is already selected
            if (!gradeSelectedValues.includes(value)) {
                gradeSelectedValues.push(value);

                // Add selected option to the container
                gradeSelectedOptionsContainer.append(`
                    <span class="bg-success text-white px-2 py-1 rounded mx-1 mb-1" data-value="${value}">
                        ${text} <span class="remove-option text-white">&times;</span>
                    </span>
                `);

                // Update the hidden input field with the selected values
                $('#selected_grades').val(gradeSelectedValues.join(','));
            }

            // Hide the dropdown after selection
            gradeDropdownList.hide();
        });

        // Remove selected grade
        gradeSelectedOptionsContainer.on('click', '.remove-option', function () {
            const value = $(this).parent().data('value');
            gradeSelectedValues.splice(gradeSelectedValues.indexOf(value), 1);
            $(this).parent().remove();

            // Update the hidden input field with the selected values
            $('#selected_grades').val(gradeSelectedValues.join(','));
        });

        // Hide dropdown when clicking outside
        $(document).on('click', function (event) {
            if (!$(event.target).closest('.custom-multi-select').length) {
                gradeDropdownList.hide();
            }
        });
    });
</script>