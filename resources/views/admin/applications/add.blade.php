@extends('admin.default')
@section('content')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<div class="container-fluid px-4">
    <h3 class="mt-4">Add New Application</h3>

    <div class="card bg-white p-3 mt-4 border-0 shadow-sm rounded">
        <div class="student-buttons pt-3">
            <!-- Centered Pills -->
            <ul class="nav nav-pills nav-justified flex-wrap" id="menuTabs" style="white-space: nowrap;">
                <li class="nav-item">
                    <a class="nav-link active" id="homeTab" data-bs-toggle="pill" href="#home">Personal Info</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="menu1Tab" data-bs-toggle="pill" href="#menu1">Parents & Guardian Info</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="menu2Tab" data-bs-toggle="pill" href="#menu2">Documents </a>
                </li>
            </ul>
            <hr class="w-100 my-4" style="font-weight : 200px;">
        </div>
        <!-- Tab Content -->
        <form method="post" action="{{route('application.store')}}">
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
                                                <input type="text" class="form-control" placeholder="Enter First Name"
                                                    name="first_name">
                                                @error('first_name')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>

                                            <!-- Last Name -->
                                            <div class="col-6 mb-2">
                                                <label for="" class="text-muted mb-2">Last Name <span
                                                        class="text-danger">*</span></label>
                                                <input type="text" class="form-control" placeholder="Enter Last Name"
                                                    name="last_name">
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
                                                        <option value="Male">Male</option>
                                                        <option value="Female">Female</option>
                                                        <option value="other">Others</option>
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
                                                    placeholder="Select Admission Date">
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

                                            <!-- Caste -->
                                            <div class="col-6 mt-3">
                                                <label for="" class="text-muted mb-2">Caste</label>
                                                <input type="text" class="form-control" name="caste"
                                                    placeholder="caste">
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
                                                            <option value="{{$list->id}}">
                                                                {{$list->title . ' [' . $list->year . ']'}}
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
                                                    value="{{$newAdmissionNumber}}" readonly>

                                                @error('admission_no')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>

                                            <!-- Admission Date -->
                                            <div class="col-6 mt-3">
                                                <label for="" class="text-muted mb-2">Admission Date <span
                                                        class="text-danger">*</span></label>
                                                <input type="text" class="form-control dateselector"
                                                    name="admission_date" placeholder="Select Admission Date">

                                                @error('admission_date')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
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
                                                <input type="email" class="form-control" name="email"
                                                    placeholder="Enter email address">
                                            </div>

                                            <!-- Admission Number -->
                                            <div class="col-6">
                                                <label for="" class="text-muted mb-2">Phone Number</label>
                                                <input type="number" class="text-muted form-control"
                                                    placeholder="Enter phone number">
                                            </div>

                                            <!-- Admission Date -->
                                            <div class="col-6 mt-3">
                                                <label for="" class="text-muted mb-2">Current Address</label>
                                                <textarea id="permanentAddress" style="resize: none;"
                                                    name="current_address" class="form-control" rows="3"
                                                    placeholder="Enter your permanent address"></textarea>
                                            </div>
                                            <div class="col-6 mt-3">
                                                <label for="permanentAddress" class="text-muted mb-2">Permanent
                                                    Address</label>
                                                <textarea id="permanentAddress" style="resize: none;"
                                                    name="permanent_address" class="form-control" rows="3"
                                                    placeholder="Enter your permanent address"></textarea>
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

                <!-- Other Tabs -->
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
                                            <!-- Academic Year -->
                                            <div class="col-6 mb-2">
                                                <label for="" class="text-muted mb-2">Father Status</label>
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
                                                <input type="email" class="form-control" name="father_name"
                                                    placeholder="Enter Father Name">
                                            </div>

                                            <!-- Admission Number -->
                                            <div class="col-6">
                                                <label for="" class="text-muted mb-2">Last Name</label>
                                                <input type="text" class="text-muted form-control"
                                                    placeholder="Enter Occupation">
                                            </div>

                                            <!-- Admission Date -->
                                            <div class="col-6 mt-3">
                                                <label for="" class="text-muted mb-2">Gender</label>
                                                <div class="cp_wrapperGg">
                                                    <select class="select2Gg form-control" name="religion">
                                                        <option value="Male">Male</option>
                                                        <option value="Female">Female</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-6 mt-3">
                                                <label for="" class="text-muted mb-2">Email</label>
                                                <input type="email" class="form-control" name="email">
                                            </div>


                                            <div class="col-6 mt-3">
                                                <label for="" class="text-muted mb-2">Occupation</label>
                                                <input type="email" class="form-control" name="email">
                                            </div>

                                            <div class="col-6 mt-3">
                                                <label for="" class="text-muted mb-2">Phone Number</label>
                                                <input type="email" class="form-control" name="email">
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
                                                <input type="text" class="form-control" name="mother_first_name"
                                                    id="mother_first_name" placeholder="Enter Mother's First Name">
                                            </div>

                                            <!-- Last Name -->
                                            <div class="col-6">
                                                <label for="mother_last_name" class="text-muted mb-2">Last Name</label>
                                                <input type="text" class="form-control" name="mother_last_name"
                                                    id="mother_last_name" placeholder="Enter Mother's Last Name">
                                            </div>

                                            <!-- Email -->
                                            <div class="col-6 mt-3">
                                                <label for="mother_email" class="text-muted mb-2">Email</label>
                                                <input type="email" class="form-control" name="mother_email"
                                                    id="mother_email" placeholder="Enter Mother's Email">
                                            </div>

                                            <!-- Occupation -->
                                            <div class="col-6 mt-3">
                                                <label for="mother_occupation"
                                                    class="text-muted mb-2">Occupation</label>
                                                <input type="text" class="form-control" name="mother_occupation"
                                                    id="mother_occupation" placeholder="Enter Mother's Occupation">
                                            </div>

                                            <!-- Phone Number -->
                                            <div class="col-6 mt-3">
                                                <label for="mother_phone" class="text-muted mb-2">Phone Number</label>
                                                <input type="text" class="form-control" name="mother_phone"
                                                    id="mother_phone" placeholder="Enter Mother's Phone Number">
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
                                                <input type="text" class="form-control" name="father_first_name"
                                                    id="father_first_name" placeholder="Enter Father's First Name">
                                            </div>

                                            <!-- Last Name -->
                                            <div class="col-6">
                                                <label for="father_last_name" class="text-muted mb-2">Last Name</label>
                                                <input type="text" class="form-control" name="father_last_name"
                                                    id="father_last_name" placeholder="Enter Father's Last Name">
                                            </div>

                                            <!-- Email -->
                                            <div class="col-6 mt-3">
                                                <label for="father_email" class="text-muted mb-2">Email</label>
                                                <input type="email" class="form-control" name="father_email"
                                                    id="father_email" placeholder="Enter Father's Email">
                                            </div>

                                            <!-- Occupation -->
                                            <div class="col-6 mt-3">
                                                <label for="father_occupation"
                                                    class="text-muted mb-2">Occupation</label>
                                                <input type="text" class="form-control" name="father_occupation"
                                                    id="father_occupation" placeholder="Enter Father's Occupation">
                                            </div>

                                            <!-- Phone Number -->
                                            <div class="col-6 mt-3">
                                                <label for="father_phone" class="text-muted mb-2">Phone Number</label>
                                                <input type="text" class="form-control" name="father_phone"
                                                    id="father_phone" placeholder="Enter Father's Phone Number">
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
                        <h5>Menu 2</h5>
                        <p>This is some demo content for Menu 2.</p>
                    </div>
                </div>
                <div class="tab-pane fade" id="menu3">
                    <div class="p-3">
                        <h5>Menu 3</h5>
                        <p>This is some demo content for Menu 3.</p>
                    </div>
                </div>
                <div class="tab-pane fade" id="menu4">
                    <div class="p-3">
                        <h5>Menu 4</h5>
                        <p>This is some demo content for Menu 4.</p>
                    </div>
                </div>
                <div class="tab-pane fade" id="menu5">
                    <div class="p-3">
                        <h5>Menu 5</h5>
                        <p>This is some demo content for Menu 5.</p>
                    </div>
                </div>
                <div class="tab-pane fade" id="menu6">
                    <div class="p-3">
                        <h5>Menu 6</h5>
                        <p>This is some demo content for Menu 6.</p>
                    </div>
                </div>
                <div class="tab-pane fade" id="menu7">
                    <div class="p-3">
                        <h5>Menu 7</h5>
                        <p>This is some demo content for Menu 7.</p>
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

<!-- Add JavaScript for Toggling -->
<script>
document.querySelectorAll('input[name="parent_status"]').forEach(radio => {
    radio.addEventListener('change', function() {
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