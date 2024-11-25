@extends('admin.default')
@section('content')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

<div class="container-fluid px-4">
    <h3 class="mt-4">Edit Application</h3>

    <div class="card bg-white p-3 mt-4 border-0 shadow-sm rounded">
        <div class="student-buttons pt-3">
            <!-- Centered Pills -->
            <ul class="nav nav-pills nav-justified flex-wrap" id="menuTabs" style="white-space: nowrap;">
                <li class="nav-item">
                    <a class="nav-link active" id="homeTab" data-bs-toggle="pill" href="#home">Personal Info</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="menu1Tab" data-bs-toggle="pill" href="#menu1">Parents & Guardian
                        Info</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="menu2Tab" data-bs-toggle="pill" href="#menu2">Documents </a>
                </li>
            </ul>
            <hr class="w-100 my-4" style="font-weight : 200px;">
        </div>
        <!-- Tab Content -->
        <form method="post" action="{{route('application.store')}}" enctype="multipart/form-data">
            @csrf
            <div class="tab-content">

                <!-- Home Tab -->
                <div class="tab-pane fade show active" style="width: 100%;" id="home">
                    <div class="p-3">
                        <div class="row d-flex">

                            <!-- Personal Information -->
                            <div class="col-6">
                                <div class="card bg-light border-0 shadow-none">
                                    <div class="card-header border-0 bg-light pb-0 pl-3 pr-3 pt-3">
                                        <p class="text-muted fw-bold">Personal Information </p>
                                        <hr class="w-100" style="font-weight: 200px;">
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <!-- First Name -->
                                            <div class="col-6 mb-2">
                                                <label for="" class="text-muted mb-2">First Name <span
                                                        class="text-danger">*</span></label>
                                                <input type="text" class="form-control" name="first_name"
                                                    value="{{ $student->first_name }}">
                                                @error('first_name')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>

                                            <!-- Last Name -->
                                            <div class="col-6 mb-2">
                                                <label for="" class="text-muted mb-2">Last Name <span
                                                        class="text-danger">*</span></label>
                                                <input type="text" class="form-control" name="last_name"
                                                    value="{{ $student->last_name }}">
                                                @error('last_name')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>

                                            <!-- Gender -->
                                            <div class="col-6 mt-3">
                                                <label for="" class="text-muted mb-2">Gender <span
                                                        class="text-danger">*</span></label>
                                                <div class="cp_wrappergender">
                                                    <select class="select2gender" name="gender">
                                                        <option value="Male" {{ $student->gender == 'Male' ? 'selected' : '' }}>Male</option>
                                                        <option value="Female" {{ $student->gender == 'Female' ? 'selected' : '' }}>Female</option>
                                                        <option value="other" {{ $student->gender == 'other' ? 'selected' : '' }}>Others</option>
                                                    </select>

                                                </div>
                                                @error('gender')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>

                                            <!-- Date of Birth -->
                                            <div class="col-6 mt-3">
                                                <label for="" class="text-muted mb-2">Date Of Birth <span
                                                        class="text-danger">*</span></label>
                                                <input type="text" class="form-control dateselector" name="dob"
                                                    value="{{ $student->dob }}">
                                                @error('dob')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>

                                            <!-- Religion -->
                                            <div class="col-6 mt-3">
                                                <label for="" class="text-muted mb-2">Religion <span
                                                        class="text-danger">*</span></label>
                                                <div class="cp_wrapperreg">
                                                    <select class="select2reg" name="religion">
                                                        <option value="Islam" {{ $student->gender == 'Islam' ? 'selected' : '' }}>Islam</option>
                                                        <option value="Hinduism" {{ $student->gender == 'Hinduism' ? 'selected' : '' }}>Hinduism</option>
                                                        <option value="Sikhism" {{ $student->gender == 'Sikhism' ? 'selected' : '' }}>Sikhism</option>
                                                        <option value="Other" {{ $student->gender == 'Other' ? 'selected' : ''  }}>Others</option>
                                                    </select>
                                                </div>
                                                @error('religion')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>

                                            <!-- Caste -->
                                            <div class="col-6 mt-3">
                                                <label for="" class="text-muted mb-2">Caste</label>
                                                <input type="text" class="form-control" name="caste"
                                                    value="{{ $student->caste }}">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Academic Information -->
                            <div class="col-6">
                                <div class="card bg-light border-0 shadow-none" style="height : 350px;">
                                    <div class="card-header border-0 bg-light pb-0 pl-3 pr-3 pt-3">
                                        <p class="text-muted fw-bold">Academic Information</p>
                                        <hr class="w-100" style="font-weight: 200px;">
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <!-- Academic Year -->
                                            <div class="col-6 mb-2">
                                                <label for="" class="text-muted mb-2">Academic Year <span
                                                        class="text-danger">*</span></label>
                                                <div class="cp_wrapper">
                                                    <select class="select2" name="year_id">
                                                        @forelse ($years as $list)
                                                            <option value="{{ $list->id }}" {{ $student->year_id === $list->id ? 'selected' : '' }}>
                                                                {{ $list->title . ' [' . $list->year . ']' }}
                                                            </option>
                                                        @empty
                                                            <option value="">No Years available</option>
                                                        @endforelse
                                                    </select>

                                                </div>
                                                @error('year_id')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>

                                            <!-- Admission Number -->
                                            <div class="col-6">
                                                <label for="" class="text-muted mb-2">Admission Number <span
                                                        class="text-danger">*</span></label>
                                                <input type="text" class="form-control" name="admission_no"
                                                    value="{{ $student->admission_no }}" readonly>

                                                @error('admission_no')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>

                                            <!-- Admission Date -->
                                            <div class="col-6 mt-3">
                                                <label for="" class="text-muted mb-2">Admission Date <span
                                                        class="text-danger">*</span></label>
                                                <input type="text" class="form-control dateselector"
                                                    name="admission_date" value="{{ $student->admission_date }}">
                                                @error('admission_date')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>

                                            <div class="col-6"></div>

                                            <div class="col-6 mt-3">
                                                <label for="" class="text-muted mb-2">Student Image</label>
                                                <div class="image-input">
                                                    <input type="file" accept="image/*" id="imageInput"
                                                        name="student_image" class="d-none">
                                                    <label for="imageInput" class="image-button"><i
                                                            class="far fa-image"></i> Choose image</label>
                                                </div>
                                            </div>

                                            <div class="col-6">
                                                <img src="{{ asset('backend/images/students/' . $student->student_image)}}"
                                                    class="image-preview"
                                                    style="width : 100px; height: 80px; display:{{ $student->student_image ? 'block' : 'none' }}; margin-left : 40px;">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Contact Information -->
                            <div class="col-6 mt-4">
                                <div class="card bg-light border-0 shadow-none">
                                    <div class="card-header border-0 bg-light pb-0 pl-3 pr-3 pt-3">
                                        <p class="text-muted fw-bold">Contact Information</p>
                                        <hr class="w-100" style="font-weight: 200px;">
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <!-- Academic Year -->
                                            <div class="col-6 mb-2">
                                                <label for="" class="text-muted mb-2">Email Address</label>
                                                <input type="email" class="form-control" name="email">
                                            </div>

                                            <!-- Admission Number -->
                                            <div class="col-6">
                                                <label for="" class="text-muted mb-2">Phone Number</label>
                                                <input type="number" class="text-muted form-control">
                                            </div>

                                            <!-- Admission Date -->
                                            <div class="col-6 mt-3">
                                                <label for="" class="text-muted mb-2">Current Address</label>
                                                <textarea id="permanentAddress" style="resize: none;"
                                                    name="current_address" class="form-control" rows="3"></textarea>
                                            </div>
                                            <div class="col-6 mt-3">
                                                <label for="permanentAddress" class="text-muted mb-2">Permanent
                                                    Address</label>
                                                <textarea id="permanentAddress" style="resize: none;"
                                                    name="permanent_address" class="form-control" rows="3"></textarea>
                                            </div>

                                        </div>
                                    </div>

                                </div>
                            </div>

                            <!-- Medical Information -->
                            <div class="col-6 mt-4">
                                <div class="card bg-light border-0 shadow-none" style="height : 315px;">
                                    <div class="card-header border-0 bg-light pb-0 pl-3 pr-3 pt-3">
                                        <p class="text-muted fw-bold">Medical Information</p>
                                        <hr class="w-100" style="font-weight: 200px;">
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <!-- Academic Year -->
                                            <div class="col-6 mb-2">
                                                <label for="" class="text-muted mb-2">Blood Group</label>
                                                <div class="cp_wrapperblgroup">
                                                    <select class="select2blgroup" name="blood_group">
                                                        <option value="Islam">A+</option>
                                                        <option value="Islam">B+</option>
                                                        <option value="Islam">AB+</option>
                                                        <option value="Islam">O+</option>
                                                        <option value="Islam">A-</option>
                                                        <option value="Islam">B-</option>
                                                        <option value="Islam">AB-</option>
                                                    </select>
                                                </div>
                                            </div>



                                            <!-- Admission Date -->
                                            <div class="col-6">
                                                <label for="" class="text-muted mb-2">Height (In)</label>
                                                <input type="number" class="form-control" name="height">
                                            </div>
                                            <div class="col-6 mt-3">
                                                <label for="permanentAddress" class="text-muted mb-2">Weight
                                                    (Kg)</label>
                                                <input type="number" class="form-control" name="weight">
                                            </div>

                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Guardain Tab -->
                <div class="tab-pane fade" id="menu1">
                    <div class="p-3">
                        <div class="row">
                            <div class="col-6">
                                <div class="card bg-light border-0 shadow-none">
                                    <div class="card-header border-0 bg-light pb-0 pl-3 pr-3 pt-3">
                                        <p class="text-muted fw-bold">Guardian Information</p>
                                        <hr class="w-100" style="font-weight: 200px;">
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <!-- Guardain Type -->
                                            <div class="col-6 mb-2">
                                                <label for="" class="text-muted mb-2">Guardain Type</label>
                                                <div>
                                                    <label for="father" class="form-check-label">
                                                        <input type="radio" name="parent_status" value="father"
                                                            id="father" class="form-check-input">
                                                        Father
                                                    </label>
                                                </div>
                                                <div>
                                                    <label for="mother" class="form-check-label">
                                                        <input type="radio" name="parent_status" value="mother"
                                                            id="mother" class="form-check-input">
                                                        Mother
                                                    </label>
                                                </div>
                                                <div>
                                                    <label for="guardian" class="form-check-label">
                                                        <input type="radio" name="parent_status" value="guardian"
                                                            id="guardian" class="form-check-input">
                                                        Guardian
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <!-- Guardian Information -->
                            <div class="col-6 d-none" id="guardian-info">
                                <div class="card bg-light border-0 shadow-none">
                                    <div class="card-header border-0 bg-light pb-0 pl-3 pr-3 pt-3">
                                        <p class="text-muted fw-bold">Guardian Information</p>
                                        <hr class="w-100" style="font-weight: 200px;">
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <!-- Academic Year -->
                                            <div class="col-6 mb-2">
                                                <label for="" class="text-muted mb-2">First Name</label>
                                                <input type="text" class="form-control" name="guardian_name">
                                            </div>

                                            <!-- Admission Number -->
                                            <div class="col-6">
                                                <label for="" class="text-muted mb-2">Last Name</label>
                                                <input type="text" class="text-muted form-control"
                                                    name="guardian_last_name">
                                            </div>

                                            <!-- Admission Date -->
                                            <div class="col-6 mt-3">
                                                <label for="" class="text-muted mb-2">Gender</label>
                                                <div class="cp_wrapperGg">
                                                    <select class="select2Gg form-control" name="guardian_gender">
                                                        <option value=""> --Select-- </option>
                                                        <option value="Male">Male</option>
                                                        <option value="Female">Female</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-6 mt-3">
                                                <label for="" class="text-muted mb-2">Email</label>
                                                <input type="email" class="form-control" name="guardian_email">
                                            </div>


                                            <div class="col-6 mt-3">
                                                <label for="" class="text-muted mb-2">Occupation</label>
                                                <input type="text" class="form-control" name="guardian_occupation">
                                            </div>

                                            <div class="col-6 mt-3">
                                                <label for="" class="text-muted mb-2">Phone Number</label>
                                                <input type="text" class="form-control" name="guardian_phone_no">
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Mother Information -->
                            <div class="col-6 d-none" id="mother-info">
                                <div class="card bg-light border-0 shadow-none">
                                    <div class="card-header border-0 bg-light pb-0 pl-3 pr-3 pt-3">
                                        <p class="text-muted fw-bold">Mother Information</p>
                                        <hr class="w-100" style="font-weight: 200px;">
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <!-- First Name -->
                                            <div class="col-6 mb-2">
                                                <label for="mother_first_name" class="text-muted mb-2">First
                                                    Name</label>
                                                <input type="text" class="form-control" name="mother_name"
                                                    id="mother_first_name">
                                            </div>

                                            <!-- Last Name -->
                                            <div class="col-6">
                                                <label for="mother_last_name" class="text-muted mb-2">Last
                                                    Name</label>
                                                <input type="text" class="form-control" name="mother_last_name"
                                                    id="mother_last_name">
                                            </div>

                                            <!-- Email -->
                                            <div class="col-6 mt-3">
                                                <label for="mother_email" class="text-muted mb-2">Email</label>
                                                <input type="email" class="form-control" name="mother_email"
                                                    id="mother_email">
                                            </div>

                                            <!-- Occupation -->
                                            <div class="col-6 mt-3">
                                                <label for="mother_occupation"
                                                    class="text-muted mb-2">Occupation</label>
                                                <input type="text" class="form-control" name="mother_occupation"
                                                    id="mother_occupation">
                                            </div>

                                            <!-- Phone Number -->
                                            <div class="col-6 mt-3">
                                                <label for="mother_phone" class="text-muted mb-2">Phone
                                                    Number</label>
                                                <input type="text" class="form-control" name="mother_phone_no"
                                                    id="mother_phone">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Father Information -->
                            <div class="col-6 d-none" id="father-info">
                                <div class="card bg-light border-0 shadow-none">
                                    <div class="card-header border-0 bg-light pb-0 pl-3 pr-3 pt-3">
                                        <p class="text-muted fw-bold">Father Information</p>
                                        <hr class="w-100" style="font-weight: 200px;">
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <!-- First Name -->
                                            <div class="col-6 mb-2">
                                                <label for="father_first_name" class="text-muted mb-2">First
                                                    Name</label>
                                                <input type="text" class="form-control" name="father_name"
                                                    id="father_first_name">
                                            </div>

                                            <!-- Last Name -->
                                            <div class="col-6">
                                                <label for="father_last_name" class="text-muted mb-2">Last
                                                    Name</label>
                                                <input type="text" class="form-control" name="father_last_name"
                                                    id="father_last_name">
                                            </div>

                                            <!-- Email -->
                                            <div class="col-6 mt-3">
                                                <label for="father_email" class="text-muted mb-2">Email</label>
                                                <input type="email" class="form-control" name="father_email"
                                                    id="father_email">
                                            </div>

                                            <!-- Occupation -->
                                            <div class="col-6 mt-3">
                                                <label for="father_occupation"
                                                    class="text-muted mb-2">Occupation</label>
                                                <input type="text" class="form-control" name="father_occupation"
                                                    id="father_occupation">
                                            </div>

                                            <!-- Phone Number -->
                                            <div class="col-6 mt-3">
                                                <label for="father_phone" class="text-muted mb-2">Phone
                                                    Number</label>
                                                <input type="text" class="form-control" name="father_phone_no"
                                                    id="father_phone">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

                <div class="tab-pane fade" id="menu2">
                    <div class="p-3">
                        <div class="row">
                            <div class="col-12">
                                <div class="card bg-light border-0 shadow-sm">
                                    <div class="card-header border-0 bg-light pb-0 pl-3 pr-3 pt-3">
                                        <p class="text-muted fw-bold">Upload Documents</p>
                                        <hr class="w-100">
                                    </div>
                                    <div class="card-body">

                                        <div class="form-group">
                                            @for($i = 1; $i <= 4; $i++)
                                                <div class="row mb-3">
                                                    <div class="col-md-6">
                                                        <label for="title{{ $i }}" class="text-muted mb-2">Title
                                                            {{ $i }}</label>
                                                        <input type="text" name="document_titles[]" id="title{{ $i }}"
                                                            class="form-control" placeholder="Enter document title">
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label for="fileUpload{{ $i }}" class="text-muted mb-2">Document
                                                            {{ $i }}</label>
                                                        <input type="file" name="document_names[]" id="fileUpload{{ $i }}"
                                                            class="form-control">
                                                    </div>
                                                </div>
                                            @endfor
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <div class="text-end mt-3">
                <button class="btn btn-primary btn-sm" type="submit">
                    <i class="fa fa-save"></i> Save
                </button>
            </div>
        </form>
    </div>
</div>




<script>
    $(document).ready(function () {
        $('.select2').select2({
            dropdownParent: $('.cp_wrapper')
        });

        $('.select2gender').select2({
            dropdownParent: $('.cp_wrappergender')
        })

        $('.select2reg').select2({
            dropdownParent: $('.cp_wrapperreg')
        })

        $('.select2blgroup').select2({
            dropdownParent: $('.cp_wrapperblgroup')
        })

        $('.fatherStatusSelect2').select2({
            dropdownParent: $('.fatherStatus')
        })

        $('.select2Gg').select2({
            dropdownParent: $('.cp_wrapperGg')
        })
    });
</script>


<script>
    $('#imageInput').on('change', function () {
        $input = $(this);
        if ($input.val().length > 0) {
            fileReader = new FileReader();
            fileReader.onload = function (data) {
                $('.image-preview').attr('src', data.target.result);
            }
            fileReader.readAsDataURL($input.prop('files')[0]);
            $('.image-preview').css('display', 'block');
            $('.change-image').css('display', 'block');
        }
    });

    $('.change-image').on('click', function () {
        $control = $(this);
        $('#imageInput').val('');
        $preview = $('.image-preview');
        $preview.attr('src', '');
        $preview.css('display', 'none');
        $control.css('display', 'none');
        $('.image-button').css('display', 'block');
    });
</script>

<!-- Add JavaScript for Toggling -->
<script>
    document.querySelectorAll('input[name="parent_status"]').forEach(radio => {
        radio.addEventListener('change', function () {
            if (this.value === 'father') {
                document.getElementById('father-info').classList.remove('d-none');
                document.getElementById('mother-info').classList.add('d-none');
                document.getElementById('guardian-info').classList.add('d-none');
            } else if (this.value === 'mother') {
                document.getElementById('mother-info').classList.remove('d-none');
                document.getElementById('father-info').classList.add('d-none');
                document.getElementById('guardian-info').classList.add('d-none');
            } else if (this.value === 'guardian') {
                document.getElementById('guardian-info').classList.remove('d-none');
                document.getElementById('father-info').classList.add('d-none');
                document.getElementById('mother-info').classList.add('d-none');
            } else {
                document.getElementById('father-info').classList.add('d-none');
                document.getElementById('mother-info').classList.add('d-none');
                document.getElementById('guardian-info').classList.add('d-none');
            }
        });
    });
</script>


<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script>
    $(".dateselector").flatpickr({
        dateFormat: "Y-m-d", // Define the desired date format
    });
</script>

@endsection