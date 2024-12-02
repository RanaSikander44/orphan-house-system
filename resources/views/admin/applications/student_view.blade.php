@extends('admin.default')

@section('Page-title' , 'Applications View')
@section('content')
<div class="container-fluid px-4">

    <div class="row mt-4">
        <!-- Student Details Section -->
        <div class="col-md-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">

                    <h5 class="text-muted fw-bold text-center mb-4">Application Details</h5>

                    <!-- Student Image Section -->
                    <div class="position-relative text-center"
                        style="min-height: 150px; background-color: #7c32ff; border-radius: 8px;">
                        <div class="d-flex justify-content-center align-items-center h-100">
                            <img class="student-meta-img img-fluid rounded-2 shadow"
                                style="width: 100px; height: 100px; object-fit: cover; border: 2px solid #fff; position: absolute; top : 65px;"
                                src="{{ $student->student_image ? asset('backend/images/students/' . $student->student_image) : asset('backend/images/default.jpg') }}"
                                alt="Student Photo">
                        </div>
                    </div>

                    <!-- Student Information -->
                    <!-- Centered Student Information -->
                    <div class="white-box text-muted mt-5 p-3 border rounded shadow-sm text-center">
                        <div class="row py-2 border-bottom align-items-center">
                            <div class="col-6 fw-bold">Student Name:</div>
                            <div class="col-6">{{ $student->first_name }} {{ $student->last_name }}</div>
                        </div>
                        <div class="row py-2 border-bottom align-items-center">
                            <div class="col-6 fw-bold">Roll No:</div>
                            <div class="col-6">{{ $student->admission_no }}</div>
                        </div>

                        <div class="row py-2 border-bottom align-items-center">
                            <div class="col-6 fw-bold">Gender</div>
                            <div class="col-6">{{ $student->gender }}</div>
                        </div>

                    </div>


                </div>
            </div>
        </div>

        <div class="col-md-9">
            <div class="card border-0 shadow-none rounded-3">
                <div class="card-body p-3">
                    <!-- Add flexbox utilities to the nav -->
                    <ul class="nav nav-pills mb-4 justify-content-around" id="infoTabs" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link custom-btn active" id="academic-tab" data-bs-toggle="pill"
                                data-bs-target="#academic" type="button" role="tab" aria-controls="academic"
                                aria-selected="true">
                                <i class="bi bi-award me-2"></i>Profile
                            </button>
                        </li>
                        <!-- Parent Tab Link -->
                        <li class="nav-item" role="presentation">
                            <button class="nav-link custom-btn" id="parents-tab" data-bs-toggle="pill"
                                data-bs-target="#parents-info" type="button" role="tab" aria-controls="parents-info"
                                aria-selected="false">
                                <i class="bi bi-file-earmark-text me-2"></i>Parents Info
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link custom-btn" id="attendance-tab" data-bs-toggle="pill"
                                data-bs-target="#other" type="button" role="tab" aria-controls="other"
                                aria-selected="false">
                                <i class="bi bi-calendar-check me-2"></i>Documents
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link custom-btn" id="attendance-tab" data-bs-toggle="pill"
                                data-bs-target="#attendance" type="button" role="tab" aria-controls="attendance"
                                aria-selected="false">
                                <i class="bi bi-calendar-check me-2"></i>Documents
                            </button>
                        </li>
                    </ul>
                    <hr>
                    <!-- Pills Content -->
                    <div class="tab-content" id="infoTabsContent">
                        <div class="tab-pane fade show active" id="academic" role="tabpanel"
                            aria-labelledby="academic-tab">
                            <div class=" pt-0 p-4 rounded-3">
                                <div class="row g-0">
                                    <!-- Row 1 -->
                                    <div class="d-flex align-items-center py-3 border-bottom">
                                        <div class="col-6">
                                            <h6 class="mb-0 text-muted">Admission Date</h6>
                                        </div>
                                        <div class="col-6 text-muted text-end">
                                            <p class="mb-0">{{ $student->admission_date }}</p>
                                        </div>
                                    </div>

                                    <!-- Row 2 -->
                                    <div class="d-flex align-items-center py-3 border-bottom">
                                        <div class="col-6">
                                            <h6 class="mb-0 text-muted">Date Of Birth</h6>
                                        </div>
                                        <div class="col-6 text-muted text-end">
                                            <p class="mb-0">{{ $student->dob }}</p>
                                        </div>
                                    </div>

                                    <!-- Row 3 -->
                                    <div class="d-flex align-items-center py-3 border-bottom">
                                        <div class="col-6">
                                            <h6 class="mb-0 text-muted">Age</h6>
                                        </div>
                                        <div class="col-6 text-muted text-end">
                                            <p class="mb-0">
                                                @php
                                                    $dob = \Carbon\Carbon::parse($student->dob);
                                                    $age = $dob->age;
                                                @endphp
                                                {{ $age }} years old
                                            </p>
                                        </div>

                                    </div>

                                    <div class="d-flex align-items-center py-3 border-bottom">
                                        <div class="col-6">
                                            <h6 class="mb-0 text-muted">Religion</h6>
                                        </div>
                                        <div class="col-6 text-muted text-end">
                                            <p class="mb-0">{{ $student->religion }}</p>
                                        </div>
                                    </div>

                                    <div class="d-flex align-items-center py-3 border-bottom">
                                        <div class="col-6">
                                            <h6 class="mb-0 text-muted">Phone Number</h6>
                                        </div>
                                        <div class="col-6 text-muted text-end">
                                            <p class="mb-0">{{ $student->phone_number }}</p>
                                        </div>
                                    </div>

                                    <div class="d-flex align-items-center py-3 border-bottom">
                                        <div class="col-6">
                                            <h6 class="mb-0 text-muted">Email Address
                                            </h6>
                                        </div>
                                        <div class="col-6 text-muted text-end">
                                            <p class="mb-0">{{ $student->email }}</p>
                                        </div>
                                    </div>

                                    <div class="d-flex align-items-center py-3 border-bottom">
                                        <div class="col-6">
                                            <h6 class="mb-0 text-muted">Present Address </h6>
                                        </div>
                                        <div class="col-6 text-muted text-end">
                                            <p class="mb-0">{{ $student->current_address }}</p>
                                        </div>
                                    </div>

                                    <div class="d-flex align-items-center py-3 border-bottom">
                                        <div class="col-6">
                                            <h6 class="mb-0 text-muted">Permanent Address</h6>
                                        </div>
                                        <div class="col-6 text-muted text-end">
                                            <p class="mb-0">{{ $student->permanent_address }}</p>
                                        </div>
                                    </div>

                                    <!-- Add more rows as needed -->
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
                                                                                                        <a href="{{ asset('backend/documents/' . $list->name) }}"
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


@endsection