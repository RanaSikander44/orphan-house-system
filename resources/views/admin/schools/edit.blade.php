@extends('admin.default')

@section('Page-title', 'Edit School')

@section('content')
<div class="container-fluid px-4">

    <div class="card bg-white px-4 py-3 mt-4 border-0 shadow-sm rounded">
        <div class="card-body">
            <form method="POST" action="{{ route('schools.update', $school->id) }}">
                @csrf
                @method('put')
                <div class="row">
                    <div class="col-md-6">
                        <label for="name" class="form-label">School Name</label>
                        <input type="text" name="name" id="name" class="form-control" value="{{ $school->name }}"
                            placeholder="Enter school name" required>
                    </div>

                    <div class="col-md-6">
                        <label for="address" class="form-label">Address</label>
                        <textarea name="address" class="form-control" id="" rows="4" cols="50">
                            {{ $school->address }}
                        </textarea>
                    </div>

                    <div class="col-md-6 mt-3">
                        <label for="grade" class="form-label">Select Grade</label>
                        <div class="custom-multi-select">
                            <div class="select-box form-control">Select Grades</div>
                            <ul class="dropdown-list list-unstyled border rounded shadow-sm mt-1">
                                @foreach ($grades as $list)
                                    <li data-value="{{ $list->id }}"
                                        class="px-3 py-2 {{ in_array($list->id, $assignedGrades) ? 'selected' : '' }}">
                                        {{ $list->grade }}
                                    </li>
                                @endforeach
                            </ul>
                            <div class="selected-options mt-2">
                                @foreach ($assignedGrades as $assignedGrade)
                                                                @php
                                                                    $grade = $grades->firstWhere('id', $assignedGrade);
                                                                @endphp
                                                                <span class="bg-success text-white px-2 py-1 rounded mx-1 mb-1"
                                                                    data-value="{{ $grade->id }}">
                                                                    {{ $grade->grade }} <span class="remove-option text-white">&times;</span>
                                                                </span>
                                @endforeach
                            </div>

                            <input type="hidden" name="grade[]" id="selected_grades"
                                value="{{ implode(',', $assignedGrades) }}">
                        </div>
                    </div>

                </div>

                <div class="d-flex justify-content-end mt-4">
                    <button type="submit" class="btn btn-primary">Update School</button>
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
        let gradeSelectedValues = $('#selected_grades').val() ? $('#selected_grades').val().split(',') : [];

        // Mark already assigned grades with a tick
        gradeSelectedValues.forEach(value => {
            const listItem = $('li[data-value="' + value + '"]');
            if (listItem.length) {
                listItem.append('<span class="tick-mark text-success float-end">✔</span>');
            }
        });

        // Toggle dropdown visibility
        gradeSelectBox.on('click', function () {
            gradeDropdownList.toggle();
        });

        // Select grade
        gradeDropdownList.on('click', 'li', function (event) {
            event.stopPropagation(); // Prevent dropdown from closing

            const value = $(this).data('value');
            const text = $(this).text();

            if (!gradeSelectedValues.includes(value.toString())) {
                gradeSelectedValues.push(value.toString());

                // Add selected option to the container
                gradeSelectedOptionsContainer.append(`
                <span class="bg-success text-white px-2 py-1 rounded mx-1 mb-1" data-value="${value}">
                    ${text} <span class="remove-option text-white">&times;</span>
                </span>
            `);

                // Show tick mark for selected grade
                $(this).append('<span class="tick-mark text-success float-end">✔</span>');
            } else {
                // Remove from selected values
                gradeSelectedValues = gradeSelectedValues.filter(item => item !== value.toString());

                // Remove from selected container
                gradeSelectedOptionsContainer.find(`[data-value="${value}"]`).remove();

                // Remove tick mark
                $(this).find('.tick-mark').remove();
            }

            // Update the hidden input field
            $('#selected_grades').val(gradeSelectedValues.join(','));
        });

        // Remove selected grade when clicking on remove button (×)
        gradeSelectedOptionsContainer.on('click', '.remove-option', function (event) {
            event.stopPropagation(); // Prevent dropdown from closing

            const value = $(this).parent().data('value');

            // Remove from selected values
            gradeSelectedValues = gradeSelectedValues.filter(item => item !== value.toString());
            $(this).parent().remove();

            // Remove tick mark from the dropdown list
            gradeDropdownList.find(`li[data-value="${value}"] .tick-mark`).remove();

            // Update the hidden input field
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