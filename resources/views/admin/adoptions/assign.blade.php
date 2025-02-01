@extends('admin.default')

@section('Page-title', 'Assign School And Dormitory')

@section('content')
<div class="container-fluid px-4">
    <div class="card bg-white p-3 mt-4 border-0 shadow-sm rounded">
        <div class="pt-3">
            <form action="{{ route('enquiry.assign', $child->id) }}" method="post">
                <div class="row">
                    @csrf
                    <!-- School Information -->
                    <div class="col-6 mt-4">
                        <div class="card bg-light border-0 shadow-none">
                            <div class="card-header border-0 bg-light pb-0 pl-3 pr-3 pt-3">
                                <p class="text-muted fw-bold">School Information </p>
                                <hr class="w-100">
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-6">
                                        <label class="text-muted mb-2">
                                            Select School<span class="text-danger">*</span>
                                        </label>
                                        <div class="cp_wrapperSchool">
                                            <select class="select2School form-control" id="SchoolSelect"
                                                name="school_id" required>
                                                <option value="">--Select School--</option>
                                                @foreach ($schools as $list)
                                                    <option value="{{ $list->id }}" {{ old('school_id', $child->school_id) == $list->id ? 'selected' : '' }}>
                                                        {{ $list->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <label class="text-muted mb-2">
                                            Select Grade<span class="text-danger">*</span>
                                        </label>
                                        <div class="cp_wrapperGrade">
                                            <select class="select2Grade form-control" id="SchoolGrade" name="grade_id"
                                                required>
                                                <option value="">--Select Grade--</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Dormitory Information -->
                    <div class="col-6 mt-4">
                        <div class="card bg-light border-0 shadow-none">
                            <div class="card-header border-0 bg-light pb-0 pl-3 pr-3 pt-3">
                                <p class="text-muted fw-bold">Dormitory Information</p>
                                <hr class="w-100">
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-12">
                                        <label class="text-muted mb-2">
                                            Select Room<span class="text-danger">*</span>
                                        </label>
                                        <div class="cp_wrapperDormitory">
                                            <select class="select2Dormitory form-control" id="DormitorySelect"
                                                name="room_id" required>
                                                <option value="">--Select Room--</option>
                                                @foreach ($rooms as $list)
                                                    <option value="{{ $list->id }}" {{ old('room_id' , $child->room_id) == $list->id ? 'selected' : '' }}>
                                                        {{ $list->title }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        @error('room_id')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="d-flex justify-content-end mt-4">
                        <a href="{{ route('enquiry.child.list') }}" class="btn btn-sm btn-secondary me-2">Cancel</a>
                        <button type="submit" class="btn btn-sm btn-primary">Save</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

<!-- Include jQuery and Select2 -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<!-- Initialize Select2 on the dropdowns -->
<script>
    $(document).ready(function () {
        $('.select2School').select2({
            dropdownParent: $('.cp_wrapperSchool')
        });

        $('.select2Dormitory').select2({
            dropdownParent: $('.cp_wrapperDormitory')
        });

        $('.select2Grade').select2({
            dropdownParent: $('.cp_wrapperGrade')
        });
    });
</script>

<script>
    $(document).ready(function () {
        function fetchGrades(school_id, selectedGradeId = null) {
            $.post({
                url: '{{ route('find.school') }}',
                data: {
                    '_token': '{{ csrf_token() }}',
                    school_id: school_id
                },
                success: function (response) {
                    let $select = $('#SchoolGrade');
                    $select.empty().append('<option value="">--Select Grade--</option>');

                    $.each(response.grades, function (index, grade) {
                        let isSelected = (grade.grade_id == selectedGradeId);
                        let option = new Option(grade.grade, grade.grade_id, false, isSelected);
                        $select.append(option);
                    });

                    $select.trigger('change'); // Update Select2 UI
                },
                error: function (xhr, status, error) {
                    alert('An error occurred: ' + error);
                }
            });
        }

        $('#SchoolSelect').on('change', function () {
            let school_id = $(this).val();
            if (school_id) {
                fetchGrades(school_id);
            } else {
                $('#SchoolGrade').empty().append('<option value="">--Select Grade--</option>').trigger('change');
            }
        });

        // Fetch the selected school and grade from the database (on page load)
        let selectedSchoolId = $('#SchoolSelect').val();
        let selectedGradeId = '{{ old('grade_id', $child->grade_id ?? '') }}';

        if (selectedSchoolId) {
            fetchGrades(selectedSchoolId, selectedGradeId);
        }
    });

</script>