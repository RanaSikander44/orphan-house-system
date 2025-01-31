@extends('admin.default')

@section('Page-title', 'Enquiry View')
@section('content')
<div class="container-fluid px-4">

    <div class="row mt-4">
        <!-- child Details Section -->
        <div class="col-md-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">

                    <h5 class="text-muted fw-bold text-center mb-4">Enquiry Details</h5>

                    <!-- child Image Section -->
                    <div class="position-relative text-center"
                        style="min-height: 150px; background-color: #7c32ff; border-radius: 8px;">
                        <div class="d-flex justify-content-center align-items-center h-100">
                            <img class="child-meta-img img-fluid rounded-2 shadow"
                                style="width: 100px; height: 100px; object-fit: cover; border: 2px solid #fff; position: absolute; top : 65px;"
                                src="{{ $child->child_image ? asset('backend/images/childs/' . $child->child_image) : asset('backend/images/default.jpg') }}"
                                alt="Child Photo">
                        </div>
                    </div>

                    <!-- Centered Child Information -->
                    <div class="white-box text-muted mt-5 p-4 border rounded shadow-sm text-center">
                        <div class="d-flex justify-content-between align-items-center py-3 border-bottom">
                            <div class="fw-bold text-uppercase">
                                Enquiry No :
                            </div>
                            <div class="text-dark fs-5">
                                {{ $child->enquiry_no }}
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <div class="col-md-9">
            <div class="card border-0 shadow-none rounded-3">
                <div class="card-body p-3">
                    <!-- Add flexbox utilities to the nav -->
                    <ul class="nav nav-pills mb-4 justify-content-around row row-cols-3 g-3" id="infoTabs"
                        role="tablist">
                        <li class="nav-item col" role="presentation">
                            <button class="nav-link custom-btn active w-100" id="academic-tab" data-bs-toggle="pill"
                                data-bs-target="#academic" type="button" role="tab" aria-controls="academic"
                                aria-selected="true">
                                <i class="bi bi-award me-2"></i>Profile
                            </button>
                        </li>
                        <li class="nav-item col" role="presentation">
                            <button class="nav-link custom-btn w-100" id="parents-tab" data-bs-toggle="pill"
                                data-bs-target="#parents-info" type="button" role="tab" aria-controls="parents-info"
                                aria-selected="false">
                                <i class="bi bi-file-earmark-text me-2"></i>Parents Info
                            </button>
                        </li>
                        <li class="nav-item col" role="presentation">
                            <button class="nav-link custom-btn w-100" id="documents" data-bs-toggle="pill"
                                data-bs-target="#other" type="button" role="tab" aria-controls="other"
                                aria-selected="false">
                                <i class="bi bi-calendar-check me-2"></i>Documents
                            </button>
                        </li>

                        @foreach ($forms as $form)
                            <li class="nav-item col" role="presentation">
                                <button class="nav-link custom-btn w-100" id="form-tab-{{ $form->id }}"
                                    data-bs-toggle="pill" data-bs-target="#form-content-{{ $form->id }}" type="button"
                                    role="tab" aria-controls="form-content-{{ $form->id }}" aria-selected="false">
                                    <i class="bi bi-calendar-check me-2"></i>{{ $form->name }}
                                </button>
                            </li>
                        @endforeach
                    </ul>

                    <hr>

                    <div class="tab-content" id="form-tabs-content">
                        @foreach ($formsData->groupBy('form_id') as $formId => $formDataGroup)
                                    <div class="tab-pane fade" id="form-content-{{ $formId }}" role="tabpanel"
                                        aria-labelledby="form-tab-{{ $formId }}">
                                        <div class="pt-0 p-4 rounded-3">
                                            @foreach ($formDataGroup as $formData)
                                                                @if ($formData->inputForm && $formData->inputForm->label)
                                                                                    <div class="row align-items-center py-2 border-bottom">
                                                                                        <div class="col-6">
                                                                                            <p class="fw-bold">{{ $formData->inputForm->label }}</p>
                                                                                        </div>
                                                                                        <div class="col-6 text-muted text-end">
                                                                                            <p class="mb-0">
                                                                                                @if ($formData->inputForm->type === 'file')
                                                                                                                                @php
                                                                                                                                    $filePaths = json_decode($formData->input_value, true);
                                                                                                                                    $isMultiple = is_array($filePaths) && count($filePaths) > 1;
                                                                                                                                @endphp

                                                                                                                                @if ($isMultiple)
                                                                                                                                    <button class="btn btn-link p-0"
                                                                                                                                        onclick="toggleFilesTable(this, 'table-{{ $formData->id }}')"><i
                                                                                                                                            class="fa-regular fa-eye"></i></button>
                                                                                                                                @else
                                                                                                                                    @php $fileUrl = asset($formData->input_value); @endphp
                                                                                                                                    <a href="{{ $fileUrl }}" download class="btn btn-link p-0">Download File</a>
                                                                                                                                @endif
                                                                                                @else
                                                                                                                            {{-- Display value as text --}}
                                                                                                                            {{ is_array(json_decode($formData->input_value, true))
                                                                                                    ? implode(', ', json_decode($formData->input_value, true))
                                                                                                    : $formData->input_value }}
                                                                                                @endif
                                                                                            </p>
                                                                                        </div>
                                                                                    </div>

                                                                                    {{-- Table (Initially Hidden) - Placed Right Below the Row --}}
                                                                                    @if ($isMultiple)
                                                                                        <div class="row d-none" id="table-{{ $formData->id }}">
                                                                                            <div class="col-12">
                                                                                                <table class="table table-striped table-bordered mt-2">
                                                                                                    <thead>
                                                                                                        <tr>
                                                                                                            <th colspan="3" class="text-center">
                                                                                                                {{ $formData->inputForm->label }} Files
                                                                                                            </th>
                                                                                                        </tr>
                                                                                                        <tr>
                                                                                                            <th>#</th>
                                                                                                            <th>File</th>
                                                                                                            <th>Action</th>
                                                                                                        </tr>
                                                                                                    </thead>
                                                                                                    <tbody>
                                                                                                        @foreach ($filePaths as $index => $filePath)
                                                                                                            @php $fileUrl = asset($filePath); @endphp
                                                                                                            <tr  id="file-row-{{ $formData->id }}-{{ $index }}" >
                                                                                                                <td>{{ $index + 1 }}</td>
                                                                                                                <td>{{ basename($filePath) }}</td>
                                                                                                                <td><a href="{{ $fileUrl }}" download
                                                                                                                        class="btn btn-sm btn-primary">Download</a>
                                                                                                                    <button class="btn btn-sm btn-danger"
                                                                                                                        onclick="deleteFile('{{ $formData->id }}', '{{ $index }}', '{{ $filePath }}')">
                                                                                                                        Delete
                                                                                                                    </button>
                                                                                                                </td>
                                                                                                            </tr>
                                                                                                        @endforeach
                                                                                                    </tbody>
                                                                                                </table>
                                                                                            </div>
                                                                                        </div>
                                                                                    @endif
                                                                @endif
                                            @endforeach
                                        </div>
                                    </div>
                        @endforeach
                    </div>

                    <!-- Pills Content -->
                    <div class="tab-content" id="infoTabsContent">
                        <div class="tab-pane fade show active" id="academic" role="tabpanel"
                            aria-labelledby="academic-tab">
                            <div class="pt-0 p-4 rounded-3">
                                <div class="row g-0">
                                    <!-- Row 1 -->
                                    <div class="d-flex align-items-center py-3 border-bottom">
                                        <div class="col-6">
                                            <h6 class="mb-0 text-muted">First Name</h6>
                                        </div>
                                        <div class="col-6 text-muted text-end">
                                            <p class="mb-0">{{ $child->first_name }}</p>
                                        </div>
                                    </div>

                                    <div class="d-flex align-items-center py-3 border-bottom">
                                        <div class="col-6">
                                            <h6 class="mb-0 text-muted">Last Name</h6>
                                        </div>
                                        <div class="col-6 text-muted text-end">
                                            <p class="mb-0">{{ $child->last_name }}</p>
                                        </div>
                                    </div>

                                    <div class="d-flex align-items-center py-3 border-bottom">
                                        <div class="col-6">
                                            <h6 class="mb-0 text-muted">Adoption Date</h6>
                                        </div>
                                        <div class="col-6 text-muted text-end">
                                            <p class="mb-0">{{ $child->adoption_date }}</p>
                                        </div>
                                    </div>

                                    <!-- Row 2 -->
                                    <div class="d-flex align-items-center py-3 border-bottom">
                                        <div class="col-6">
                                            <h6 class="mb-0 text-muted">Date Of Birth</h6>
                                        </div>
                                        <div class="col-6 text-muted text-end">
                                            <p class="mb-0">{{ $child->dob }}</p>
                                        </div>
                                    </div>

                                    <!-- Row 3 -->
                                    <div class="d-flex align-items-center py-3 border-bottom">
                                        <div class="col-6">
                                            <h6 class="mb-0 text-muted">Age</h6>
                                        </div>
                                        <div class="col-6 text-muted text-end">
                                            <p class="mb-0">
                                                {{ $child->age }}
                                            </p>
                                        </div>

                                    </div>

                                    <div class="d-flex align-items-center py-3 border-bottom">
                                        <div class="col-6">
                                            <h6 class="mb-0 text-muted">Religion</h6>
                                        </div>
                                        <div class="col-6 text-muted text-end">
                                            <p class="mb-0">{{ $child->religion }}</p>
                                        </div>
                                    </div>

                                    <div class="d-flex align-items-center py-3 border-bottom">
                                        <div class="col-6">
                                            <h6 class="mb-0 text-muted">City</h6>
                                        </div>
                                        <div class="col-6 text-muted text-end">
                                            <p class="mb-0">{{ $child->city->name ?? '' }}</p>
                                        </div>
                                    </div>

                                    <div class="d-flex align-items-center py-3 border-bottom">
                                        <div class="col-6">
                                            <h6 class="mb-0 text-muted">Phone Number</h6>
                                        </div>
                                        <div class="col-6 text-muted text-end">
                                            <p class="mb-0">{{ $child->phone_number }}</p>
                                        </div>
                                    </div>

                                    <div class="d-flex align-items-center py-3 border-bottom">
                                        <div class="col-6">
                                            <h6 class="mb-0 text-muted">Email Address
                                            </h6>
                                        </div>
                                        <div class="col-6 text-muted text-end">
                                            <p class="mb-0">{{ $child->email }}</p>
                                        </div>
                                    </div>

                                    <div class="d-flex align-items-center py-3 border-bottom">
                                        <div class="col-6">
                                            <h6 class="mb-0 text-muted">Present Address </h6>
                                        </div>
                                        <div class="col-6 text-muted text-end">
                                            <p class="mb-0">{{ $child->current_address }}</p>
                                        </div>
                                    </div>

                                    <div class="d-flex align-items-center py-3 border-bottom">
                                        <div class="col-6">
                                            <h6 class="mb-0 text-muted">Permanent Address</h6>
                                        </div>
                                        <div class="col-6 text-muted text-end">
                                            <p class="mb-0">{{ $child->permanent_address }}</p>
                                        </div>
                                    </div>

                                    <h5 class="text-muted fw-bold text-center pt-5">Enquiry Details</h5>

                                    <!-- Row 1 -->
                                    <div class="d-flex align-items-center py-3 border-bottom">
                                        <div class="col-6">
                                            <h6 class="mb-0 text-muted">Enquiry No</h6>
                                        </div>
                                        <div class="col-6 text-muted text-end">
                                            <p class="mb-0">{{ $child->enquiry_no }}</p>
                                        </div>
                                    </div>

                                    <div class="d-flex align-items-center py-3 border-bottom">
                                        <div class="col-6">
                                            <h6 class="mb-0 text-muted">Enquiry Type</h6>
                                        </div>
                                        <div class="col-6 text-muted text-end">
                                            <p class="mb-0">{{ $child->enquiryType->title ?? ''}}</p>
                                        </div>
                                    </div>

                                    <div class="d-flex align-items-center py-3 border-bottom">
                                        <div class="col-6">
                                            <h6 class="mb-0 text-muted">Source Of Information</h6>
                                        </div>
                                        <div class="col-6 text-muted text-end">
                                            <p class="mb-0">{{ $child->source_of_information  }}</p>
                                        </div>
                                    </div>

                                    <div class="d-flex align-items-center py-3 border-bottom">
                                        <div class="col-6">
                                            <h6 class="mb-0 text-muted">Status of Adoption</h6>
                                        </div>
                                        <div class="col-6 text-muted text-end">
                                            <p class="mb-0">{{ $child->status_of_adoption }}</p>
                                        </div>
                                    </div>

                                    <h5 class="text-muted fw-bold text-center pt-5">Nanny Details</h5>
                                    <div class="d-flex align-items-center py-3 border-bottom">
                                        <div class="col-6">
                                            <h6 class="mb-0 text-muted">Nanny</h6>
                                        </div>
                                        <div class="col-6 text-muted text-end">
                                            <p class="mb-0">{{ $nannyDetails->first_name ?? '' }}
                                                {{ $nannyDetails->last_name ?? 'Nanny Not Assigned' }}
                                            </p>
                                        </div>
                                    </div>

                                    <h5 class="text-muted fw-bold text-center pt-5">School & Dormitory
                                        Information</h5>

                                    <div class="d-flex align-items-center py-3 border-bottom">
                                        <div class="col-6">
                                            <h6 class="mb-0 text-muted">School</h6>
                                        </div>
                                        <div class="col-6 text-muted text-end">
                                            <p class="mb-0">{{ $child->school->name ?? ''}}</p>
                                        </div>
                                    </div>

                                    <div class="d-flex align-items-center py-3 border-bottom">
                                        <div class="col-6">
                                            <h6 class="mb-0 text-muted">Grade</h6>
                                        </div>
                                        <div class="col-6 text-muted text-end">
                                            <p class="mb-0">{{ $child->grade->grade ?? '' }}</p>
                                        </div>
                                    </div>

                                    <div class="d-flex align-items-center py-3 border-bottom">
                                        <div class="col-6">
                                            <h6 class="mb-0 text-muted">Room</h6>
                                        </div>
                                        <div class="col-6 text-muted text-end">
                                            <p class="mb-0">{{ $child->room->title ?? '' }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Tab Content Section -->
                    <div class="tab-content">
                        <div class="tab-pane fade" id="parents-info" role="tabpanel" aria-labelledby="parents-tab">
                            <div class="pt-0 p-4 rounded-3">
                                <div class="row g-0">
                                    <!-- Father Information -->
                                    <div class="d-flex align-items-center py-3 border-bottom">
                                        <div class="col-2">
                                            <img src="http://sms.test/public/uploads/staff/demo/father.png"
                                                style="width : 100%;" alt="">
                                        </div>
                                        <div class="col-4">
                                            <h6 class="ms-3 mb-0 text-muted">Father Name</h6>
                                        </div>
                                        <div class="col-6 text-muted text-end">
                                            <p class="mb-0">
                                                {{ $parents->father_name }} {{ $parents->father_last_name  }}
                                            </p>
                                        </div>
                                    </div>

                                    <!-- Row 2 - Date Of Birth -->
                                    <div class="d-flex align-items-center py-3 border-bottom">
                                        <div class="col-6">
                                            <h6 class="mb-0 text-muted">Father Occupation</h6>
                                        </div>
                                        <div class="col-6 text-muted text-end">
                                            <p class="mb-0">
                                                {{ $parents->father_occupation }}
                                            </p>
                                        </div>
                                    </div>

                                    <!-- Row 3 - Age -->
                                    <div class="d-flex align-items-center py-3 border-bottom">
                                        <div class="col-6">
                                            <h6 class="mb-0 text-muted">Father Email</h6>
                                        </div>
                                        <div class="col-6 text-muted text-end">
                                            <p class="mb-0">
                                                {{ $parents->father_email }}
                                            </p>
                                        </div>
                                    </div>

                                    <div class="d-flex align-items-center py-3 border-bottom">
                                        <div class="col-6">
                                            <h6 class="mb-0 text-muted">Father Phone No</h6>
                                        </div>
                                        <div class="col-6 text-muted text-end">
                                            <p class="mb-0">
                                                {{ $parents->father_phone_no }}
                                            </p>
                                        </div>
                                    </div>


                                    <!-- Mother Information -->

                                    <div class="d-flex align-items-center py-3 border-bottom">
                                        <div class="col-2">
                                            <img src="http://sms.test/public/uploads/staff/demo/father.png"
                                                style="width : 100%;" alt="">
                                        </div>
                                        <div class="col-4">
                                            <h6 class="ms-3 mb-0 text-muted">Mother Name</h6>
                                        </div>
                                        <div class="col-6 text-muted text-end">
                                            <p class="mb-0">
                                                {{ $parents->mother_name }} {{ $parents->mother_last_name }}
                                            </p>
                                        </div>
                                    </div>
                                    <!-- Row 2 - Date Of Birth -->
                                    <div class="d-flex align-items-center py-3 border-bottom">
                                        <div class="col-6">
                                            <h6 class="mb-0 text-muted">Mother Occupation</h6>
                                        </div>
                                        <div class="col-6 text-muted text-end">
                                            <p class="mb-0">
                                                {{ $parents->mother_occupation }}
                                            </p>
                                        </div>
                                    </div>

                                    <div class="d-flex align-items-center py-3 border-bottom">
                                        <div class="col-6">
                                            <h6 class="mb-0 text-muted">Mother Email</h6>
                                        </div>
                                        <div class="col-6 text-muted text-end">
                                            <p class="mb-0">
                                                {{ $parents->mother_email }}
                                            </p>
                                        </div>
                                    </div>

                                    <div class="d-flex align-items-center py-3 border-bottom">
                                        <div class="col-6">
                                            <h6 class="mb-0 text-muted">Mother Phone Number</h6>
                                        </div>
                                        <div class="col-6 text-muted text-end">
                                            <p class="mb-0">
                                                {{ $parents->mother_phone_no }}
                                            </p>
                                        </div>
                                    </div>


                                    <!-- Guardian Information -->
                                    <div class="d-flex align-items-center py-3 border-bottom">
                                        <div class="col-2">
                                            <img src="http://sms.test/public/uploads/staff/demo/father.png"
                                                style="width : 100%;" alt="">
                                        </div>
                                        <div class="col-4">
                                            <h6 class="ms-3 mb-0 text-muted">Guardian Name</h6>
                                        </div>
                                        <div class="col-6 text-muted text-end">
                                            <p class="mb-0">
                                                {{ $parents->guardian_name }} {{ $parents->guardian_last_name }}
                                            </p>
                                        </div>
                                    </div>

                                    <div class="d-flex align-items-center py-3 border-bottom">
                                        <div class="col-6">
                                            <h6 class="mb-0 text-muted">Guardian Occupation</h6>
                                        </div>
                                        <div class="col-6 text-muted text-end">
                                            <p class="mb-0">
                                                {{ $parents->guardian_occupation }}
                                            </p>
                                        </div>
                                    </div>

                                    <div class="d-flex align-items-center py-3 border-bottom">
                                        <div class="col-6">
                                            <h6 class="mb-0 text-muted">Guardian Gender</h6>
                                        </div>
                                        <div class="col-6 text-muted text-end">
                                            <p class="mb-0">
                                                {{ $parents->guardian_gender }}
                                            </p>
                                        </div>
                                    </div>

                                    <div class="d-flex align-items-center py-3 border-bottom">
                                        <div class="col-6">
                                            <h6 class="mb-0 text-muted">Guardian Phone Number</h6>
                                        </div>
                                        <div class="col-6 text-muted text-end">
                                            <p class="mb-0">
                                                {{ $parents->guardian_phone_no }}
                                            </p>
                                        </div>
                                    </div>


                                    <div class="d-flex align-items-center py-3 border-bottom">
                                        <div class="col-6">
                                            <h6 class="mb-0 text-muted">Guardian Email Address</h6>
                                        </div>
                                        <div class="col-6 text-muted text-end">
                                            <p class="mb-0">
                                                {{ $parents->guardian_email }}
                                            </p>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Docs -->
                    <div class="tab-pane fade" id="other" role="tabpanel" aria-labelledby="attendance-tab">
                        <div class="p-4 rounded-3 bg-white">
                            <div class="pt-0 p-4 rounded-3">
                                <div class="row g-0">
                                    <div class="col-12">
                                        <table class="table table-striped">
                                            <thead>
                                                <tr>
                                                    <th>Title</th>
                                                    <th>Name</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($documents as $list)
                                                                                                <tr id="document-row-{{ $list->id }}">
                                                                                                    <!-- Ensure each row has a unique ID -->
                                                                                                    <!-- Display Title -->
                                                                                                    <td>{{ $list->documentTitle->title }}</td>

                                                                                                    <!-- Display File Name -->
                                                                                                    <td>{{ $list->name }}</td>

                                                                                                    <td>
                                                                                                        <!-- PHP block to generate the correct file extension and download filename -->
                                                                                                        @php
                                                                                                            $fileExtension = pathinfo($list->name, PATHINFO_EXTENSION); // Get the file extension
                                                                                                            $downloadFilename = $list->documentTitle->title . '.' . $fileExtension; // Set the download filename with title and extension
                                                                                                        @endphp

                                                                                                        <!-- Download Button with correct file name and extension -->
                                                                                                        <a href="{{ asset('backend/documents/childs/' . $list->name) }}"
                                                                                                            class="btn btn-sm btn-primary rounded-pill"
                                                                                                            download="{{ $downloadFilename }}">
                                                                                                            <i class="fa-solid fa-download"></i> Download
                                                                                                        </a>

                                                                                                        <!-- Delete Button (Trigger AJAX function for deletion) -->
                                                                                                        <button type="button" onclick="deldoc({{ $list->id }})"
                                                                                                            class="btn btn-sm btn-danger rounded-pill">
                                                                                                            <i class="fa fa-trash"></i> Delete
                                                                                                        </button>
                                                                                                    </td>
                                                                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


</div>

<style>
    /* Override default Bootstrap styles for nav-link */
    .nav-pills .nav-link.custom-btn {
        background-color: #cad5f3 !important;
        /* Ensure custom background color */
        color: #415094 !important;
        /* Custom text color */
        border: none;
        border-radius: 0px;
        /* Remove default border */
        border-radius: 8px;
        /* Rounded corners */
        padding: 8px 25px;
        /* Padding for button size */
        text-align: center;
        /* Center text */
        width: 150px;
        /* Fixed width for uniformity */
        transition: all 0.3s ease;
        /* Smooth transition */
    }

    /* Hover effect for buttons */
    .nav-pills .nav-link.custom-btn:hover {
        background-color: #b3c3ef !important;
        /* Slightly darker shade on hover */
        color: #39467b !important;
        /* Slightly darker text on hover */
    }

    /* Styling for active and focused buttons */
    .nav-pills .nav-link.custom-btn.active,
    .nav-pills .nav-link.custom-btn:focus {
        background-color: transparent !important;
        border: 1px solid #cad5f3;

        /* Transparent background for active tab */
        color: #415094 !important;
        /* Maintain text color */
        box-shadow: none;
        /* No shadow for active button */
    }
</style>

<script>
    // CSRF token passed from the server
    let csrf_token = "{{ csrf_token() }}";

    let deldoc = (id) => {
        $.ajax({
            url: 'delete-document/' + id,  // The URL for the delete action
            type: 'DELETE',  // Use DELETE method
            data: {
                _token: csrf_token,  // Attach CSRF token
            },
            success: function (response) {
                $('#document-row-' + id).remove();
            },
            error: function (xhr, status, error) {
                // Handle any error during the request
                alert('Error deleting document: ' + error);
            }
        });
    }
</script>



<script>
    function downloadFile(fileUrl, fileName) {
        // Create an anchor element to trigger the download
        const a = document.createElement('a');
        a.href = fileUrl;
        a.download = fileName; // Use the original file name
        document.body.appendChild(a);
        a.click();
        document.body.removeChild(a);
    }
</script>

<script>
    function toggleFilesTable(button, tableId) {
        let table = document.getElementById(tableId);
        if (table) {
            table.classList.toggle('d-none');
        }
    }


    function deleteFile(formDataId, fileIndex, filePath) {
        if (!confirm("Are you sure you want to delete this file?")) return;

        let route = '{{ route('delete.doc.child') }}';

        $.ajax({
            url: route,
            type: "POST",
            data: {
                form_data_id: formDataId,
                file_index: fileIndex,
                file_path: filePath,
                _token: "{{ csrf_token() }}"
            },
            success: function (response) {
                if (response.success) {
                    $("#file-row-" + formDataId + "-" + fileIndex).remove(); // Remove row from table
                    alert("File deleted successfully.");
                } else {
                    alert("Failed to delete file.");
                }
            },
            error: function () {
                alert("Error occurred while deleting file.");
            }
        });
    }


</script>

@endsection