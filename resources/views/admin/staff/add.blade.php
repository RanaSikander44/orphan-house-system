@extends('admin.default')


@section('Page-title', 'Add New Staff')

@section('content')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">


<div class="container-fluid px-4">
    <!-- <h3 class="mt-4">Add New Application</h3> -->

    <div class="card bg-white p-3 mt-4 border-0 shadow-sm rounded">
        <div class="student-buttons pt-3">
            <!-- Centered Pills -->
            <ul class="nav nav-pills nav-justified flex-wrap" id="menuTabs" style="white-space: nowrap;">
                <li class="nav-item">
                    <a class="nav-link active" id="homeTab" data-bs-toggle="pill" href="#home">Personal Info</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="menu2Tab" data-bs-toggle="pill" href="#menu2">Documents </a>
                </li>
            </ul>
            <hr class="w-100 my-4" style="font-weight : 200px;">
        </div>
        <!-- Tab Content -->
        <form method="post" action="{{route('staff.store')}}" enctype="multipart/form-data">
            @csrf
            <div class="tab-content">

                <!-- Home Tab -->
                <div class="tab-pane fade show active" style="width: 100%;" id="home">
                    <div class="p-3">
                        <div class="row d-flex">

                            <!-- Personal Information -->
                            <div class="col-12">
                                <div class="card bg-light border-0 shadow-none">
                                    <div class="card-header border-0 bg-light pb-0 pl-3 pr-3 pt-3">
                                        <p class="text-muted fw-bold">Personal Information </p>
                                        <hr class="w-100" style="font-weight: 200px;">
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <!-- First Name -->
                                            <div class="col-4 mb-2">
                                                <label for="" class="text-muted mb-2">First Name <span
                                                        class="text-danger">*</span></label>
                                                <input type="text" class="form-control" name="first_name"
                                                    value="{{ old('first_name') }}">
                                                @error('first_name')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>

                                            <!-- Last Name -->
                                            <div class="col-4 mb-2">
                                                <label for="" class="text-muted mb-2">Last Name <span
                                                        class="text-danger">*</span></label>
                                                <input type="text" class="form-control" name="last_name"
                                                    value="{{ old('last_name') }}">
                                                @error('last_name')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>

                                            <!-- Date of Birth -->
                                            <div class="col-4">
                                                <label for="" class="text-muted mb-2">Date Of Birth <span
                                                        class="text-danger">*</span></label>
                                                <input type="text" class="form-control dateselector" name="dob"
                                                    value="{{ old('dob') }}">
                                                @error('dob')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>

                                            <!-- Gender -->
                                            <div class="col-4 mt-3">
                                                <label for="" class="text-muted mb-2">Gender <span
                                                        class="text-danger">*</span></label>
                                                <div class="cp_wrappergender">
                                                    <select class="select2gender" name="gender">
                                                        <option value="Male">Male</option>
                                                        <option value="Female">Female</option>
                                                        <option value="other">Others</option>
                                                    </select>
                                                </div>
                                                @error('gender')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>

                                            <!-- Caste -->
                                            <div class="col-4 mt-3">
                                                <label for="" class="text-muted mb-2">Caste</label>
                                                <input type="text" class="form-control" name="caste"
                                                    value="{{ old('caste') }}">
                                            </div>

                                            @error('caste')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror


                                            <div class="col-4 mt-3 mb-2">
                                                <label for="" class="text-muted mb-2">Email Address
                                                    <span class="text-danger">*</span>
                                                </label>
                                                <input type="email" class="form-control" name="email"
                                                    value="{{ old('email') }}">

                                                @error('email')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>


                                            <!-- Role -->
                                            <div class="col-4 mb-2 mt-3">
                                                <label for="" class="text-muted mb-2">Select Role<span
                                                        class="text-danger">*</span></label>
                                                <div class="cp_wrapper">
                                                    <select class="select2" name="role_id">
                                                        @forelse($roles as $list)
                                                            <option value="{{ $list->id }}">{{ $list->name }}</option>
                                                        @empty
                                                            <option value="">No Data Found !</option>
                                                        @endforelse
                                                    </select>
                                                </div>
                                                @error('role_id')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>

                                            <!-- Phone Number -->
                                            <div class="col-4 mt-3">
                                                <label for="" class="text-muted mb-2">Phone Number <span
                                                        class="text-danger">*</span>
                                                </label>
                                                <input type="number" class="text-muted form-control" name="phone_no"
                                                    value="{{ old('phone_no') }}">
                                            </div>

                                            @error('phone_no')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror

                                            <div class="col-4 mt-3"></div>

                                            <!-- Religion -->
                                            <div class="col-4 mt-3">
                                                <label for="" class="text-muted mb-2">Religion <span
                                                        class="text-danger">*</span></label>
                                                <div class="cp_wrapperreg">
                                                    <select class="select2reg" name="religion">
                                                        <option value="Islam">Islam</option>
                                                        <option value="Hinduism">Hinduism</option>
                                                        <option value="Sikhism">Sikhism</option>
                                                        <option value="Other">Others</option>
                                                    </select>
                                                </div>
                                                @error('religion')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>



                                            <div class="col-4 mt-4">
                                                <label for="" class="text-muted mb-2">Staff Image</label>
                                                <div class="image-input">
                                                    <input type="file" accept="image/*" id="imageInput"
                                                        name="staff_image" class="d-none">
                                                    <label for="imageInput" class="image-button"><i
                                                            class="far fa-image"></i> Choose image</label>
                                                </div>
                                            </div>


                                            <div class="col-4">
                                                <img src="" class="image-preview"
                                                    style="width : 100px; height: 80px; display : none; margin-left : 40px;">
                                            </div>

                                            <div class="col-6 mt-3">
                                                <label for="" class="text-muted mb-2">Current Address</label>
                                                <textarea id="permanentAddress" style="resize: none;"
                                                    name="current_address" class="form-control" rows="3">
                                                 {{ old('current_address') }}
                                                </textarea>
                                            </div>

                                            <div class="col-6 mt-3">
                                                <label for="permanentAddress" class="text-muted mb-2">Permanent
                                                    Address</label>
                                                <textarea id="permanentAddress" style="resize: none;"
                                                    name="permanent_address" class="form-control" rows="3">
                                                 {{ old('permanent_address') }}
                                                </textarea>
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
                                            <div class="row">
                                                @foreach ($staff_docs as $index => $list)
                                                    <div class="col-md-6">
                                                        <label for="file_{{ $index }}"
                                                            class="mb-2 mt-2 text-muted">{{ $list->title }}</label>
                                                        <input type="text" class="d-none" name="document_titles[]"
                                                            value="{{ $list->id }}">
                                                        <input type="file" class="form-control" name="document_names[]"
                                                            id="file_{{ $index }}">
                                                    </div>
                                                @endforeach
                                            </div>
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

<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script>
    $(".dateselector").flatpickr({
        dateFormat: "Y-m-d", // Define the desired date format
    });
</script>

@endsection