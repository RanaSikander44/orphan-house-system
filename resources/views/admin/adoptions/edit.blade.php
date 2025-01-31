@extends('admin.default')

<!-- 
<h3 class="mt-4">Edit Application</h3>
-->
@section('content')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

<div class="container-fluid px-4">

    <div class="card bg-white p-3 mt-4 border-0 shadow-sm rounded">

        <div class="pt-3">
            <div class="row" style="width : 100%;">
                <ul class="nav nav-pills d-flex flex-wrap" id="menuTabs" style="white-space: nowrap; padding-left: 0;">
                    <!-- Personal Info Tab -->
                    <li class="nav-item col-3 text-center">
                        <a class="nav-link active" id="homeTab" data-bs-toggle="pill" href="#home">
                            Personal Info
                        </a>
                    </li>

                    <!-- Parents & Guardian Info Tab -->
                    <li class="nav-item col-3 text-center">
                        <a class="nav-link" id="menu1Tab" data-bs-toggle="pill" href="#menu1">
                            Parents & Guardian Info
                        </a>
                    </li>

                    <!-- Documents Tab -->
                    <li class="nav-item col-3  text-center">
                        <a class="nav-link" id="menu2Tab" data-bs-toggle="pill" href="#menu2">
                            Documents
                        </a>
                    </li>

                    <!-- Dynamic Tabs from Forms -->
                    @foreach ($forms as $key => $list)
                        <li class="nav-item col-3 text-center">
                            <a class="nav-link" id="formTab{{ $key }}" data-bs-toggle="pill" href="#form{{ $key }}">
                                {{ $list->name }}
                            </a>
                        </li>
                    @endforeach

                </ul>
                <hr class="w-100 my-4" style="font-weight : 200px;">
            </div>
        </div>

        <!-- Tab Content -->
        <form method="post" action="{{route('enquiry.update', $child->id)}}" enctype="multipart/form-data">
            @csrf
            <div class="tab-content">
                <!-- Home Tab -->
                <div class="tab-pane fade show active" style="width: 100%;" id="home">
                    <div class="p-3">
                        <div class="row d-flex">

                            <!-- Adoption Information -->
                            <div class="col-6">
                                <div class="card bg-light border-0 shadow-none" style="height : 450px;">
                                    <div class="card-header border-0 bg-light pb-0 pl-3 pr-3 pt-3">
                                        <p class="text-muted fw-bold">Adoption Badge</p>
                                        <hr class="w-100" style="font-weight: 200px;">
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <!-- Campaign Year -->

                                            <div class="cp_wrapper">

                                            </div>


                                            <!-- Enquiry Type -->
                                            <div class="col-6 mt-3">
                                                <label for="" class="text-muted mb-2">Enquiry Type <span
                                                        class="text-danger">*</span></label>
                                                <select class="select2" name="enquiry_type_id" required>
                                                    @forelse($enquiry_types as $list)
                                                        <option value="{{ $list->id }}" {{$child->enquiry_id == $list->id ? 'selected' : ''   }}>
                                                            {{ $list->title }}
                                                        </option>
                                                    @empty
                                                        <option value="">Please add at least one enquiry type
                                                        </option>
                                                    @endforelse
                                                </select>
                                                @error('enquiry_type_id')
                                                    <span class="text-danger">This Field is Required</span>
                                                @enderror
                                            </div>

                                            <!-- Enquiry Number -->
                                            <div class="col-6 mt-3">
                                                <label for="" class="text-muted mb-2">Enquiry Number <span
                                                        class="text-danger">*</span></label>
                                                <input type="text" class="form-control bg-light" name="enquiry_no"
                                                    value="{{ $child->enquiry_no}}" required readonly>

                                                @error('enquiry_no')
                                                    <span class="text-danger">This Field is Required.</span>
                                                @enderror
                                            </div>

                                            <!-- Source Of Information -->
                                            <div class="col-6 mt-3">
                                                <label for="source_of_information" class="text-muted mb-2">
                                                    Source of Information <span class="text-danger">*</span>
                                                </label>
                                                <select class="select2" name="source_of_information"
                                                    id="source_of_information" required>
                                                    <option value="Website" {{ (old('source_of_information', $child->source_of_information) == 'Website') ? 'selected' : '' }}>
                                                        Website
                                                    </option>
                                                    <option value="Personal Reference" {{ (old('source_of_information', $child->source_of_information) == 'Personal Reference') ? 'selected' : '' }}>
                                                        Personal Reference
                                                    </option>
                                                    <option value="Member Shared" {{ (old('source_of_information', $child->source_of_information) == 'Member Shared') ? 'selected' : '' }}>
                                                        Member Shared
                                                    </option>
                                                    <option value="Referral Case" {{ (old('source_of_information', $child->source_of_information) == 'Referral Case') ? 'selected' : '' }}>
                                                        Referral Case
                                                    </option>
                                                    <option value="Other" {{ (old('source_of_information', $child->source_of_information) == 'Other') ? 'selected' : '' }}>
                                                        Other
                                                    </option>
                                                </select>
                                                @error('source_of_information')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>


                                            <!-- Adoption Date -->
                                            <div class="col-6 mt-3">
                                                <label for="" class="text-muted mb-2">Adoption Date <span
                                                        class="text-danger">*</span></label>
                                                <input type="text" required class="form-control dateselector"
                                                    name="adoption_date"
                                                    value="{{ old('adoption_date', $child->adoption_date) }}">
                                                @error('adoption_date')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>

                                            <!-- City -->
                                            <div class="col-6 mt-3">
                                                <label for="" class="text-muted mb-2">City<span
                                                        class="text-danger">*</span></label>
                                                <select class="select2" name="city_id" required>
                                                    @forelse ($cities as $list)
                                                        <option value="{{ $list->id }}" {{$child->city_id == $list->id ? 'selected' : ''  }}>
                                                            {{ $list->name}}
                                                        </option>
                                                    @empty
                                                        <option value="">No Cities are available</option>
                                                    @endforelse
                                                </select>
                                                @error('city_id')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>

                                            <!-- Status of Adoption -->
                                            <!-- Status of Adoption -->
                                            <div class="col-6 mt-3">
                                                <label for="status_of_adoption" class="text-muted mb-2">
                                                    Status of Adoption <span class="text-danger">*</span>
                                                </label>
                                                <select class="select2" name="status_of_adoption"
                                                    id="status_of_adoption" required>
                                                    <option value="Forwarded" {{ old('status_of_adoption', $child->status_of_adoption) == 'Forwarded' ? 'selected' : '' }}>
                                                        Forwarded
                                                    </option>
                                                    <option value="Not Processed" {{ old('status_of_adoption', $child->status_of_adoption) == 'Not Processed' ? 'selected' : '' }}>
                                                        Not Processed
                                                    </option>
                                                    <option value="Rejected" {{ old('status_of_adoption', $child->status_of_adoption) == 'Rejected' ? 'selected' : '' }}>
                                                        Rejected
                                                    </option>
                                                    <option value="Reserved" {{ old('status_of_adoption', $child->status_of_adoption) == 'Reserved' ? 'selected' : '' }}>
                                                        Reserved
                                                    </option>
                                                    <option value="Forward for Consideration" {{ old('status_of_adoption', $child->status_of_adoption) == 'Forward for Consideration' ? 'selected' : '' }}>
                                                        Forward for Consideration
                                                    </option>
                                                </select>
                                                @error('status_of_adoption')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>

                                        </div>

                                    </div>
                                </div>
                            </div>

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
                                                    value="{{ old('first_name', $child->first_name) }}" required>
                                                @error('first_name')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>

                                            <!-- Last Name -->
                                            <div class="col-6 mb-2">
                                                <label for="" class="text-muted mb-2">Last Name <span
                                                        class="text-danger">*</span></label>
                                                <input type="text" class="form-control" name="last_name"
                                                    value="{{ old('last_name', $child->last_name) }}" required>
                                                @error('last_name')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>

                                            <!-- Date of Birth -->
                                            <div class="col-6 mt-3">
                                                <label for="" class="text-muted mb-2">Date Of Birth <span
                                                        class="text-danger">*</span></label>
                                                <input type="text" class="form-control dateselector" name="dob"
                                                    id="DateOfBirth" value="{{ old('dob', $child->dob) }}" required>
                                                @error('dob')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>

                                            <!-- Age -->
                                            <div class="col-6 mb-2 mt-3">
                                                <label for="" class="text-muted mb-2">Age <span
                                                        class="text-danger">*</span></label>
                                                <input type="text" class="form-control bg-light" name="age"
                                                    id="ChildAge" readonly value="{{ old('age', $child->age) }}"
                                                    required>
                                                <input type="text" class="d-none"
                                                    value="{{ $settings->min_age_of_child }}" id="minAge">
                                                <input type="text" class="d-none"
                                                    value="{{ $settings->max_age_of_child }}" id="maxAge">
                                                @error('age')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>

                                            <!-- Gender -->
                                            <div class="col-6 mt-3">
                                                <label for="" class="text-muted mb-2">Gender <span
                                                        class="text-danger">*</span></label>
                                                <div class="cp_wrappergender">
                                                    <select class="select2gender" name="gender" required>
                                                        <option value="Male" {{ old('gender', $child->gender) == 'Male' ? 'selected' : '' }}>Male</option>
                                                        <option value="Female" {{ old('gender', $child->gender) == 'Female' ? 'selected' : '' }}>Female
                                                        </option>
                                                        <option value="other" {{ old('gender', $child->gender) == 'other' ? 'selected' : '' }}>Others</option>
                                                    </select>

                                                </div>
                                                @error('gender')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>

                                            <!-- Caste -->
                                            <div class="col-6 mt-3">
                                                <label for="" class="text-muted mb-2">Caste</label>
                                                <input type="text" class="form-control" name="caste"
                                                    value="{{ old('caste', $child->caste) }}">
                                            </div>

                                            <!-- Religion -->
                                            <div class="col-6 mt-3">
                                                <label for="" class="text-muted mb-2">Religion <span
                                                        class="text-danger">*</span></label>
                                                <div class="cp_wrapperreg">
                                                    <select class="select2reg" name="religion" required>
                                                        <option value="Islam" {{ old('religion', $child->religion ?? '') == 'Islam' ? 'selected' : '' }}>Islam</option>
                                                        <option value="Hinduism" {{ old('religion', $child->religion ?? '') == 'Hinduism' ? 'selected' : '' }}>Hinduism</option>
                                                        <option value="Sikhism" {{ old('religion', $child->religion ?? '') == 'Sikhism' ? 'selected' : '' }}>Sikhism</option>
                                                        <option value="Other" {{ old('religion', $child->religion ?? '') == 'Other' ? 'selected' : '' }}>Others</option>
                                                    </select>
                                                </div>
                                                @error('religion')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>

                                            <!-- Child Image -->
                                            <div class="col-6 mt-3">
                                                <label for="" class="text-muted mb-2">Child Image</label>
                                                <div class="image-input">
                                                    <input type="file" accept="image/*" id="imageInput"
                                                        name="child_image" class="d-none">
                                                    <label for="imageInput" class="image-button"><i
                                                            class="far fa-image"></i> Choose image</label>
                                                </div>
                                            </div>

                                            <div class="col-6">
                                                <img src="{{  asset('backend/images/childs/' . $child->child_image)}}"
                                                    class="image-preview"
                                                    style="width: 100px; height: 80px; display:{{ $child->child_image ? 'block' : 'none' }}; margin-left: 40px;">
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
                                                    value="{{ old('email', $child->email) }}">


                                                @error('email')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>

                                            <!-- Admission Number -->
                                            <div class="col-6">
                                                <label for="" class="text-muted mb-2">Phone Number</label>
                                                <input type="number" name="phone_no" value="{{ $child->phone_no }}"
                                                    class="text-muted form-control">
                                            </div>

                                            <!-- Admission Date -->
                                            <div class="col-6 mt-3">
                                                <label for="" class="text-muted mb-2">Current Address</label>
                                                <textarea id="permanentAddress" style="resize: none;"
                                                    name="current_address" class="form-control" rows="3">
                                                 {{ $child->current_address }}
                                                </textarea>
                                            </div>
                                            <div class="col-6 mt-3">
                                                <label for="permanentAddress" class="text-muted mb-2">Permanent
                                                    Address</label>
                                                <textarea id="permanentAddress" style="resize: none;"
                                                    name="permanent_address" class="form-control" rows="3">
                                                 {{ $child->permanent_address }}
                                                </textarea>
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
                                                        <option value="A+" {{ old('blood_group', $child->blood_group ?? '') == 'A+' ? 'selected' : '' }}>A+</option>
                                                        <option value="B+" {{ old('blood_group', $child->blood_group ?? '') == 'B+' ? 'selected' : '' }}>B+</option>
                                                        <option value="AB+" {{ old('blood_group', $child->blood_group ?? '') == 'AB+' ? 'selected' : '' }}>AB+</option>
                                                        <option value="O+" {{ old('blood_group', $child->blood_group ?? '') == 'O+' ? 'selected' : '' }}>O+</option>
                                                        <option value="A-" {{ old('blood_group', $child->blood_group ?? '') == 'A-' ? 'selected' : '' }}>A-</option>
                                                        <option value="B-" {{ old('blood_group', $child->blood_group ?? '') == 'B-' ? 'selected' : '' }}>B-</option>
                                                        <option value="AB-" {{ old('blood_group', $child->blood_group ?? '') == 'AB-' ? 'selected' : '' }}>AB-</option>
                                                    </select>

                                                </div>
                                            </div>



                                            <!-- Admission Date -->
                                            <div class="col-6">
                                                <label for="" class="text-muted mb-2">Height (In)</label>
                                                <input type="number" class="form-control" name="height"
                                                    value="{{ $child->height }}">
                                            </div>
                                            <div class="col-6 mt-3">
                                                <label for="permanentAddress" class="text-muted mb-2">Weight
                                                    (Kg)</label>
                                                <input type="number" class="form-control" name="weight"
                                                    value="{{ $child->weight }}">
                                            </div>

                                        </div>
                                    </div>

                                </div>
                            </div>

                            <!-- School -->

                            <div class="col-6 mt-4">
                                <div class="card bg-light border-0 shadow-none">
                                    <div class="card-header border-0 bg-light pb-0 pl-3 pr-3 pt-3">
                                        <p class="text-muted fw-bold">School Information </p>
                                        <hr class="w-100" style="font-weight: 200px;">
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <!-- Religion -->
                                            <div class="col-6">
                                                <label for="" class="text-muted mb-2">Select School<span
                                                        class="text-danger">*</span></label>
                                                <div class="cp_wrapperSchool">
                                                    <select class="select2School" id="SchoolSelect" name="school_id"
                                                        required>
                                                        <option value="" class="form-control">--Select School--</option>
                                                        @foreach ($schools as $list)
                                                            <option value="{{ $list->id }}" {{ old('school_id', $list->id ? 'selected' : '') }}>
                                                                {{ $list->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                @error('school_id')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>

                                            <div class="col-6">
                                                <label for="" class="text-muted mb-2">Select Grade<span
                                                        class="text-danger">*</span></label>
                                                <div class="cp_wrapperGrade">
                                                    <select class="select2Grade" id="SchoolGrade" name="grade_id"
                                                        required>
                                                        <option value="">--Select Grade--</option>
                                                    </select>
                                                </div>
                                                @error('grade_id')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Dormitory -->
                            <div class="col-6 mt-4">
                                <div class="card bg-light border-0 shadow-none">
                                    <div class="card-header border-0 bg-light pb-0 pl-3 pr-3 pt-3">
                                        <p class="text-muted fw-bold">Dormitory Information </p>
                                        <hr class="w-100" style="font-weight: 200px;">
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-6">
                                                <label for="" class="text-muted mb-2">Select Room<span
                                                        class="text-danger">*</span></label>
                                                <div class="cp_wrapperDormitory">
                                                    <select class="select2Dormitory form-control" id="DormitorySelect"
                                                        name="room_id" required>
                                                        @foreach ($rooms as $list)
                                                            <option value="{{ $list->id }}" {{ old('room_id', $list->room_id ? 'selected' : '') }}>
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
                                                            id="father" class="form-check-input"
                                                            @if(!empty($parents->father_name)) checked @endif>
                                                        Father
                                                    </label>
                                                </div>
                                                <div>
                                                    <label for="mother" class="form-check-label">
                                                        <input type="radio" name="parent_status" value="mother"
                                                            id="mother" class="form-check-input"
                                                            @if(!empty($parents->mother_name)) checked @endif>
                                                        Mother
                                                    </label>
                                                </div>
                                                <div>
                                                    <label for="guardian" class="form-check-label">
                                                        <input type="radio" name="parent_status" value="guardian"
                                                            id="guardian" class="form-check-input"
                                                            @if(!empty($parents->guardian_email)) checked @endif>
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
                                                <input type="text" class="form-control" name="guardian_name"
                                                    value="{{ $parents->guardian_name }}">
                                            </div>

                                            <!-- Admission Number -->
                                            <div class="col-6">
                                                <label for="" class="text-muted mb-2">Last Name</label>
                                                <input type="text" class="text-muted form-control"
                                                    name="guardian_last_name"
                                                    value="{{ $parents->guardian_last_name }}">
                                            </div>

                                            <!-- Admission Date -->
                                            <div class="col-6 mt-3">
                                                <label for="" class="text-muted mb-2">Gender</label>
                                                <div class="cp_wrapperGg">
                                                    <select class="select2Gg form-control" name="guardian_gender">
                                                        <option value="">--Select--</option>
                                                        <option value="Male" {{ old('guardian_gender', $parents->guardian_gender ?? '') == 'Male' ? 'selected' : '' }}>Male</option>
                                                        <option value="Female" {{ old('guardian_gender', $parents->guardian_gender ?? '') == 'Female' ? 'selected' : '' }}>Female</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-6 mt-3">
                                                <label for="" class="text-muted mb-2">Email</label>
                                                <input type="email" class="form-control" name="guardian_email"
                                                    value="{{ $parents->email }}">
                                            </div>


                                            <div class="col-6 mt-3">
                                                <label for="" class="text-muted mb-2">Occupation</label>
                                                <input type="text" class="form-control" name="guardian_occupation"
                                                    value="{{ $parents->guardian_occupation }}">
                                            </div>

                                            <div class="col-6 mt-3">
                                                <label for="" class="text-muted mb-2">Phone Number</label>
                                                <input type="text" class="form-control" name="guardian_phone_no"
                                                    value="{{ $parents->guardian_phone_no }}">
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
                                                    id="mother_first_name" value="{{ $parents->mother_first_name }}">
                                            </div>

                                            <!-- Last Name -->
                                            <div class="col-6">
                                                <label for="mother_last_name" class="text-muted mb-2">Last
                                                    Name</label>
                                                <input type="text" class="form-control" name="mother_last_name"
                                                    id="mother_last_name" value="{{ $parents->mother_last_name }}">
                                            </div>

                                            <!-- Email -->
                                            <div class="col-6 mt-3">
                                                <label for="mother_email" class="text-muted mb-2">Email</label>
                                                <input type="email" class="form-control" name="mother_email"
                                                    id="mother_email" value="{{ $parents->mother_email }}">
                                            </div>

                                            <!-- Occupation -->
                                            <div class="col-6 mt-3">
                                                <label for="mother_occupation"
                                                    class="text-muted mb-2">Occupation</label>
                                                <input type="text" class="form-control" name="mother_occupation"
                                                    id="mother_occupation" value="{{ $parents->mother_occupation }}">
                                            </div>

                                            <!-- Phone Number -->
                                            <div class="col-6 mt-3">
                                                <label for="mother_phone" class="text-muted mb-2">Phone
                                                    Number</label>
                                                <input type="text" class="form-control" name="mother_phone_no"
                                                    id="mother_phone" value="{{ $parents->mother_phone }}">
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
                                                    id="father_first_name" value="{{ $parents->father_name }}">
                                            </div>

                                            <!-- Last Name -->
                                            <div class="col-6">
                                                <label for="father_last_name" class="text-muted mb-2">Last
                                                    Name</label>
                                                <input type="text" class="form-control" name="father_last_name"
                                                    id="father_last_name" value="{{ $parents->father_last_name }}">
                                            </div>

                                            <!-- Email -->
                                            <div class="col-6 mt-3">
                                                <label for="father_email" class="text-muted mb-2">Email</label>
                                                <input type="email" class="form-control" name="father_email"
                                                    id="father_email" value="{{ $parents->father_email }}">
                                            </div>

                                            <!-- Occupation -->
                                            <div class="col-6 mt-3">
                                                <label for="father_occupation"
                                                    class="text-muted mb-2">Occupation</label>
                                                <input type="text" class="form-control" name="father_occupation"
                                                    id="father_occupation" value="{{ $parents->father_occupation }}">
                                            </div>

                                            <!-- Phone Number -->
                                            <div class="col-6 mt-3">
                                                <label for="father_phone" class="text-muted mb-2">Phone
                                                    Number</label>
                                                <input type="text" class="form-control" name="father_phone_no"
                                                    id="father_phone" value="{{ $parents->father_phone_no }}">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

                <!-- documents -->
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
                                                @foreach ($documents as $index => $list)

                                                    <div class="col-md-6">
                                                        <label for="file_{{ $index }}"
                                                            class="mb-2 mt-2 text-muted">{{ $list->documentTitle->title }}
                                                            @if($list->documentTitle->required === 1)<span
                                                            class="text-danger">*</span> @endif </label>
                                                        <input type="text" class="d-none" name="document_titles[]"
                                                            value="{{ $list->documentTitle->id}}">
                                                        <input type="file" class="form-control" name="document_names[]"
                                                            id="file_{{ $index }}" @if(empty($list->name) && ($list->documentTitle->required === 1)) required @endif>
                                                        <div class="docs">
                                                            <!-- Display the existing document name with a link to the file -->
                                                            @if($list->name)
                                                                <p class="text-muted">
                                                                    <a href="{{ asset('backend/documents/childs/' . $list->name) }}"
                                                                        target="_blank">Current Document</a>
                                                                </p>
                                                            @else
                                                                <p class="text-muted">No document uploaded yet</p>
                                                            @endif
                                                        </div>
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


                <!-- dynamic tabs -->
                @foreach ($forms as $key => $list)
                    <div class="tab-pane fade" id="form{{ $key }}" role="tabpanel">
                        <div class="row">
                            <div class="col-12 mb-3">
                                <input type="hidden" name="forms[{{ $key }}][form_id]" value="{{ $list->id }}">
                                <div class="card bg-light border-0 shadow-none" style="height: auto;">
                                    <div class="card-header border-0 bg-light pb-0 pl-3 pr-3 pt-3">
                                        <p class="text-muted fw-bold">{{ $list->name }}</p>
                                        <hr class="w-100" style="border-width: 2px;">
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            @foreach ($formData as $enquiryKey => $formDatum)
                                                                        @if ($formDatum->form_id === $list->id)
                                                                                                    @if ($formDatum->type === 'header')
                                                                                                        <div class="col-md-6">
                                                                                                            <{{ $formDatum->sub_type }} class="text-muted">{{ $formDatum->label }}</{{ $formDatum->sub_type }}>
                                                                                                        </div>
                                                                                                    @elseif ($formDatum->type === 'text' || $formDatum->type === 'autocomplete')
                                                                                                        <div class="col-md-6">
                                                                                                            <label for="{{ $formDatum->name }}" class="form-label">
                                                                                                                {{ $formDatum->label }}
                                                                                                                @if ($formDatum->required) <span class="text-danger">*</span> @endif
                                                                                                            </label>
                                                                                                            <input type="text" class="form-control mb-2" id="{{ $formDatum->id }}"
                                                                                                                name="forms[{{ $key }}][inputs][{{ $formDatum->name }}_{{ $formDatum->id }}]"
                                                                                                                @if ($formDatum->required) required @endif
                                                                                                                placeholder="{{ $formDatum->label }}"
                                                                                                                value="{{ old('forms.' . $key . '.inputs.' . $formDatum->name . '_' . $formDatum->id, $childInputs[$formDatum->id]->input_value ?? '') }}">
                                                                                                        </div>
                                                                                                    @elseif ($formDatum->type === 'date')
                                                                                                        <div class="col-md-6">
                                                                                                            <label for="{{ $formDatum->name }}" class="form-label">
                                                                                                                {{ $formDatum->label }}
                                                                                                                @if ($formDatum->required) <span class="text-danger">*</span> @endif
                                                                                                            </label>
                                                                                                            <input type="date" class="form-control mb-2" id="{{ $formDatum->id }}"
                                                                                                                name="forms[{{ $key }}][inputs][{{ $formDatum->name }}_{{ $formDatum->id }}]"
                                                                                                                @if ($formDatum->required) required @endif
                                                                                                                placeholder="{{ $formDatum->label }}"
                                                                                                                value="{{ old('forms.' . $key . '.inputs.' . $formDatum->name . '_' . $formDatum->id, $childInputs[$formDatum->id]->input_value ?? '') }}">
                                                                                                        </div>
                                                                                                    @elseif ($formDatum->type === 'file')
                                                                                                                                <div class="col-md-6">
                                                                                                                                    <label for="{{ $formDatum->name }}" class="form-label">
                                                                                                                                        {{ $formDatum->label }}
                                                                                                                                        @if ($formDatum->required) <span class="text-danger">*</span> @endif
                                                                                                                                    </label>
                                                                                                                                    <input type="file" class="form-control mb-2" id="{{ $formDatum->name }}"
                                                                                                                                        name="forms[{{ $key }}][inputs][{{ $formDatum->name }}_{{ $formDatum->id }}]"
                                                                                                                                        @if (empty($childInputs[$formDatum->id]->input_value) && $formDatum->required) required @endif
                                                                                                                                        value="{{ old('forms.' . $key . '.inputs.' . $formDatum->name . '_' . $formDatum->id, $childInputs[$formDatum->id]->input_value ?? '') }}"
                                                                                                                                        {{ $formDatum->multiple == 1 ? "multiple" : '' }}>

                                                                                                                                    @php
                                                                                                                                        $files = $childInputs[$formDatum->id]->input_value ?? '';
                                                                                                                                        $files = is_json($files) ? json_decode($files, true) : [$files]; // Ensure it's an array
                                                                                                                                    @endphp

                                                                                                                                    @if (!empty($files) && is_array($files))
                                                                                                                                        <div class="mt-2">
                                                                                                                                            <strong>Uploaded Document{{ count($files) > 1 ? 's' : '' }}:</strong>
                                                                                                                                            <span>{{ count($files) }}</span>
                                                                                                                                        </div>
                                                                                                                                    @endif


                                                                                                                                </div>
                                                                                                    @elseif ($formDatum->type === 'number')
                                                                                                        <div class="col-md-6">
                                                                                                            <label for="{{ $formDatum->name }}" class="form-label">
                                                                                                                {{ $formDatum->label }}
                                                                                                                @if ($formDatum->required) <span class="text-danger">*</span> @endif
                                                                                                            </label>
                                                                                                            <input type="number" class="form-control mb-2" id="{{ $formDatum->id }}"
                                                                                                                name="forms[{{ $key }}][inputs][{{ $formDatum->name }}_{{ $formDatum->id }}]"
                                                                                                                @if ($formDatum->required) required @endif
                                                                                                                placeholder="{{ $formDatum->label }}"
                                                                                                                value="{{ old('forms.' . $key . '.inputs.' . $formDatum->name . '_' . $formDatum->id, $childInputs[$formDatum->id]->input_value ?? '') }}">
                                                                                                        </div>
                                                                                                    @elseif ($formDatum->type === 'button')
                                                                                                        <div class="col-md-6">
                                                                                                            <button
                                                                                                                class="btn mt-2 {{ $formDatum->className }} mb-2">{{ $formDatum->label }}</button>
                                                                                                        </div>
                                                                                                    @elseif ($formDatum->type === 'textarea')
                                                                                                        <div class="col-md-6">
                                                                                                            <label for="{{ $formDatum->name }}" class="form-label">
                                                                                                                {{ $formDatum->label }}
                                                                                                                @if ($formDatum->required) <span class="text-danger">*</span> @endif
                                                                                                            </label>
                                                                                                            <textarea
                                                                                                                name="forms[{{ $key }}][inputs][{{ $formDatum->name }}_{{ $formDatum->id }}]"
                                                                                                                id="{{ $formDatum->id }}" class="form-control mb-2" @if ($formDatum->required) required
                                                                                                                @endif>{{ old("forms.$key.inputs.$formDatum->name", $childInputs[$formDatum->id]->input_value ?? '') }}</textarea>
                                                                                                        </div>
                                                                                                    @elseif ($formDatum->type === 'select')
                                                                                                        <div class="col-md-6">
                                                                                                            <label for="{{ $formDatum->name }}" class="form-label">
                                                                                                                {{ $formDatum->label }}
                                                                                                                @if ($formDatum->required) <span class="text-danger">*</span> @endif
                                                                                                            </label>
                                                                                                            <select class="form-control mb-2" id="{{ $formDatum->id }}"
                                                                                                                name="forms[{{ $key }}][inputs][{{ $formDatum->name }}_{{ $formDatum->id }}]"
                                                                                                                @if ($formDatum->required) required @endif>
                                                                                                                <option value="" disabled selected>Select {{ $formDatum->label }}
                                                                                                                </option>
                                                                                                                @foreach ($formDatum->optionsForm as $option)
                                                                                                                    <option value="{{ $option->value }}" @if ($childInputs[$formDatum->id]->input_value == $option->value) selected
                                                                                                                    @endif>
                                                                                                                        {{ $option->label }}
                                                                                                                    </option>
                                                                                                                @endforeach
                                                                                                            </select>
                                                                                                        </div>
                                                                                                    @elseif ($formDatum->type === 'checkbox-group' || $formDatum->type === 'radio-group')
                                                                                                                                <div class="col-md-6">
                                                                                                                                    <label for="{{ $formDatum->name }}" class="form-label">
                                                                                                                                        {{ $formDatum->label }}
                                                                                                                                        @if ($formDatum->required) <span class="text-danger">*</span> @endif
                                                                                                                                    </label>
                                                                                                                                    <div class="mb-2">
                                                                                                                                        @php
                                                                                                                                            // Check if the key exists before accessing it
                                                                                                                                            $storedValues = isset($childInputs[$formDatum->id]) && $childInputs[$formDatum->id]->input_value
                                                                                                                                                ? json_decode($childInputs[$formDatum->id]->input_value, true)
                                                                                                                                                : [];
                                                                                                                                        @endphp


                                                                                                                                        @foreach ($formDatum->optionsForm as $option)
                                                                                                                                            <div class="form-check">
                                                                                                                                                @if ($formDatum->type === 'checkbox-group')
                                                                                                                                                    <!-- Checkbox Group -->
                                                                                                                                                    <input
                                                                                                                                                        class="form-check-input {{ $formDatum->required ? 'required-group' : '' }}"
                                                                                                                                                        type="checkbox"
                                                                                                                                                        name="forms[{{ $key }}][inputs][{{ $formDatum->name }}_{{ $formDatum->id }}][]"
                                                                                                                                                        value="{{ $option->value }}"
                                                                                                                                                        id="{{ $formDatum->name }}_{{ $option->value }}" @if (in_array($option->value, $storedValues)) checked @endif>
                                                                                                                                                @elseif ($formDatum->type === 'radio-group')
                                                                                                                                                    <!-- Radio Group (only allow one selection) -->
                                                                                                                                                    <input
                                                                                                                                                        class="form-check-input {{ $formDatum->required ? 'required-group' : '' }}"
                                                                                                                                                        type="radio"
                                                                                                                                                        name="forms[{{ $key }}][inputs][{{ $formDatum->name }}_{{ $formDatum->id }}]"
                                                                                                                                                        value="{{ $option->value }}"
                                                                                                                                                        id="{{ $formDatum->name }}_{{ $option->value }}" @if (isset($childInputs[$formDatum->id]) && $childInputs[$formDatum->id]->input_value === $option->value)
                                                                                                                                                        checked @endif>
                                                                                                                                                @endif

                                                                                                                                                <label class="form-check-label"
                                                                                                                                                    for="{{ $formDatum->name }}_{{ $option->value }}">
                                                                                                                                                    {{ $option->label }}
                                                                                                                                                </label>
                                                                                                                                            </div>
                                                                                                                                        @endforeach

                                                                                                                                        @if ($formDatum->required)
                                                                                                                                            <small class="text-danger d-none" id="checkboxGroupError">Please select
                                                                                                                                                at least one option.</small>
                                                                                                                                        @endif
                                                                                                                                    </div>
                                                                                                                                </div>


                                                                                                    @elseif ($formDatum->type === 'paragraph')
                                                                                                        <div class="col-md-6">
                                                                                                            <label for="{{ $formDatum->name }}" class="form-label">
                                                                                                                {{ $formDatum->label }}
                                                                                                                @if ($formDatum->required)
                                                                                                                    <span class="text-danger">*</span>
                                                                                                                @endif
                                                                                                            </label>
                                                                                                            <textarea class="form-control mb-2"
                                                                                                                name="forms[{{ $key }}][inputs][{{ $formDatum->name }}_{{ $formDatum->id }}]"
                                                                                                                id="{{ $formDatum->name }}" rows="6"
                                                                                                                placeholder="Enter your paragraph here..." @if ($formDatum->required)
                                                                                                                    required
                                                                                                                @endif>{{ old("forms.$key.inputs.$formDatum->name", $childInputs[$formDatum->id]->input_value ?? '') }}</textarea>
                                                                                                        </div>
                                                                                                    @endif
                                                                        @endif
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach

            </div>

            <div class="text-end mt-3">
                <button class="btn btn-sm btn-primary" type="button" id="UpdateNextBtn">Next</button>
                <button class="btn btn-success btn-sm d-none" id="adoptionFormBtn" type="submit">
                    <i class="fa fa-save"></i> Update
                </button>
            </div>
        </form>
    </div>
</div>


<!--form validation -->

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const requiredGroups = document.querySelectorAll(".required-group");

        requiredGroups.forEach((group) => {
            const groupName = group.name;
            const errorElement = document.getElementById(`checkboxGroupError`);

            group.closest("form").addEventListener("submit", function (event) {
                const groupInputs = document.querySelectorAll(`[name="${groupName}"]`);
                const isChecked = Array.from(groupInputs).some((input) => input.checked);

                if (!isChecked) {
                    event.preventDefault();
                    errorElement.classList.remove("d-none");
                } else {
                    errorElement.classList.add("d-none");
                }
            });
        });
    });
</script>


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

        $('.select2School').select2({
            dropdownParent: $('.cp_wrapperSchool')
        })

        $('.select2Dormitory').select2({
            dropdownParent: $('.cp_wrapperDormitory')
        })

        $('.select2Grade').select2({
            dropdownParent: $('.cp_wrapperGrade')
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
    function toggleSectionsBasedOnSelection() {
        const selectedValue = document.querySelector('input[name="parent_status"]:checked')?.value;

        document.getElementById('father-info').classList.add('d-none');
        document.getElementById('mother-info').classList.add('d-none');
        document.getElementById('guardian-info').classList.add('d-none');

        if (selectedValue === 'father') {
            document.getElementById('father-info').classList.remove('d-none');
        } else if (selectedValue === 'mother') {
            document.getElementById('mother-info').classList.remove('d-none');
        } else if (selectedValue === 'guardian') {
            document.getElementById('guardian-info').classList.remove('d-none');
        }
    }

    // Trigger the logic on radio button change
    document.querySelectorAll('input[name="parent_status"]').forEach(radio => {
        radio.addEventListener('change', toggleSectionsBasedOnSelection);
    });

    // Initial trigger on page load
    document.addEventListener('DOMContentLoaded', toggleSectionsBasedOnSelection);
</script>



<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script>
    $(".dateselector").flatpickr({
        dateFormat: "Y-m-d", // Define the desired date format
    });
</script>

<script>
    $(document).ready(function () {

        // Function to fetch grades based on the selected school
        function fetchGrades(school_id, selectedGradeId = null) {
            $.post({
                url: '{{ route('find.school') }}',
                data: {
                    '_token': '{{ csrf_token() }}',
                    school_id: school_id
                },

                success: function (response) {
                    let select = $('#SchoolGrade');
                    select.empty();  // Clear the existing options
                    // Add an option for selecting grade
                    select.append('<option value="" class="form-control">--Select Grade--</option>');
                    $.each(response.grades, function (index, grade) {
                        // Check if the grade matches the selected grade_id (if provided)
                        let selected = (grade.grade_id == selectedGradeId) ? 'selected' : '';
                        select.append(`<option value="${grade.grade_id}" ${selected}>${grade.grade}</option>`);
                    });
                },

                error: function (xhr, status, error) {
                    alert('An error occurred: ' + error);
                }
            });
        }

        // Fetch grades based on the selected school when the select changes
        $('#SchoolSelect').on('change', function () {
            let school_id = $(this).val();
            fetchGrades(school_id);
        });

        // Trigger the change event on page load to fetch grades for the pre-selected school (if any)
        let selectedSchoolId = $('#SchoolSelect').val();  // Get the selected school ID
        let selectedGradeId = '{{ $child->grade_id ?? '' }}';  // Pass the selected grade_id dynamically
        if (selectedSchoolId) {
            fetchGrades(selectedSchoolId, selectedGradeId);  // Fetch grades for the selected school and pre-select the grade
        }
    });
</script>


<script src="{{ asset('backend/js/adoption.js') }}"></script>
@endsection