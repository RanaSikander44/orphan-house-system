@extends('admin.default')

@section('Page-title', 'Staff View')
@section('content')
<div class="container-fluid px-4">

    <div class="row mt-4">
        <!-- Student Details Section -->
        <div class="col-md-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">

                    <h5 class="text-muted fw-bold text-center mb-4">Staff Details</h5>

                    <!-- Student Image Section -->
                    <div class="position-relative text-center"
                        style="min-height: 150px; background-color: #7c32ff; border-radius: 8px;">
                        <div class="d-flex justify-content-center align-items-center h-100">
                            <img class="student-meta-img img-fluid rounded-2 shadow"
                                style="width: 100px; height: 100px; object-fit: cover; border: 2px solid #fff; position: absolute; top : 65px;"
                                src="{{ $staff->staff_image ? asset('backend/images/staff/' . $staff->staff_image) : asset('backend/images/default.jpg') }}"
                                alt="Staff Photo">
                        </div>
                    </div>

                    <!-- Centered Student Information -->
                    <div class="white-box text-muted mt-5 p-3 border rounded shadow-sm text-center">
                        <div class="row py-2 border-bottom align-items-center">
                            <div class="col-6 fw-bold">Name:</div>
                            <div class="col-6">{{ $staff->first_name }} {{ $staff->last_name }}</div>
                        </div>

                        <!-- <div class="row py-2 border-bottom align-items-center">
                            <div class="col-6 fw-bold">Gender</div>
                            <div class="col-6">{{ $staff->gender }}</div>
                        </div> -->

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
                        <li class="nav-item" role="presentation">
                            <button class="nav-link custom-btn" id="attendance-tab" data-bs-toggle="pill"
                                data-bs-target="#other" type="button" role="tab" aria-controls="other"
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

                                    <div class="d-flex align-items-center py-3 border-bottom">
                                        <div class="col-6">
                                            <h6 class="mb-0 text-muted">First Name</h6>
                                        </div>
                                        <div class="col-6 text-muted text-end">
                                            <p class="mb-0">{{ $staff->first_name }}</p>
                                        </div>
                                    </div>

                                    <div class="d-flex align-items-center py-3 border-bottom">
                                        <div class="col-6">
                                            <h6 class="mb-0 text-muted">Last Name</h6>
                                        </div>
                                        <div class="col-6 text-muted text-end">
                                            <p class="mb-0">{{ $staff->last_name }}</p>
                                        </div>
                                    </div>


                                    <div class="d-flex align-items-center py-3 border-bottom">
                                        <div class="col-6">
                                            <h6 class="mb-0 text-muted">Role</h6>
                                        </div>
                                        <div class="col-6 text-muted text-end">
                                            <p class="mb-0">{{ $staff->role->name }}</p>
                                        </div>
                                    </div>

                                    <div class="d-flex align-items-center py-3 border-bottom">
                                        <div class="col-6">
                                            <h6 class="mb-0 text-muted">Date Of Birth</h6>
                                        </div>
                                        <div class="col-6 text-muted text-end">
                                            <p class="mb-0">{{ $staff->dob }}</p>
                                        </div>
                                    </div>


                                    <div class="d-flex align-items-center py-3 border-bottom">
                                        <div class="col-6">
                                            <h6 class="mb-0 text-muted">Age</h6>
                                        </div>
                                        <div class="col-6 text-muted text-end">
                                            <p class="mb-0">{{ $staff->age . ' Years'}}</p>
                                        </div>
                                    </div>

                                    <div class="d-flex align-items-center py-3 border-bottom">
                                        <div class="col-6">
                                            <h6 class="mb-0 text-muted">Gender</h6>
                                        </div>
                                        <div class="col-6 text-muted text-end">
                                            <p class="mb-0">{{ $staff->gender }}</p>
                                        </div>
                                    </div>

                                    <!-- Row 1 -->
                                    <div class="d-flex align-items-center py-3 border-bottom">
                                        <div class="col-6">
                                            <h6 class="mb-0 text-muted">Email</h6>
                                        </div>
                                        <div class="col-6 text-muted text-end">
                                            <p class="mb-0">{{ $staff->email }}</p>
                                        </div>
                                    </div>

                                    <div class="d-flex align-items-center py-3 border-bottom">
                                        <div class="col-6">
                                            <h6 class="mb-0 text-muted">Religion</h6>
                                        </div>
                                        <div class="col-6 text-muted text-end">
                                            <p class="mb-0">{{ $staff->religion }}</p>
                                        </div>
                                    </div>

                                    <!-- Row 2 -->
                                    <div class="d-flex align-items-center py-3 border-bottom">
                                        <div class="col-6">
                                            <h6 class="mb-0 text-muted">Phone Number</h6>
                                        </div>
                                        <div class="col-6 text-muted text-end">
                                            <p class="mb-0">{{ $staff->phone_no }}</p>
                                        </div>
                                    </div>

                                    <div class="d-flex align-items-center py-3 border-bottom">
                                        <div class="col-6">
                                            <h6 class="mb-0 text-muted">Emergency Contact Number</h6>
                                        </div>
                                        <div class="col-6 text-muted text-end">
                                            <p class="mb-0">{{ $staff->emergency_contact_number }}</p>
                                        </div>
                                    </div>

                                    <div class="d-flex align-items-center py-3 border-bottom">
                                        <div class="col-6">
                                            <h6 class="mb-0 text-muted">Present Address </h6>
                                        </div>
                                        <div class="col-6 text-muted text-end">
                                            <p class="mb-0">{{ $staff->current_address }}</p>
                                        </div>
                                    </div>

                                    <div class="d-flex align-items-center py-3 border-bottom">
                                        <div class="col-6">
                                            <h6 class="mb-0 text-muted">Permanent Address</h6>
                                        </div>
                                        <div class="col-6 text-muted text-end">
                                            <p class="mb-0">{{ $staff->permanent_address }}</p>
                                        </div>
                                    </div>

                                    <!-- Add more rows as needed -->
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
                                                                                                    <td>{{ $list->staffDocs->title ?? 'Unknown Document' }}</td>

                                                                                                    <!-- Display File Name -->
                                                                                                    <td>{{ $list->name }}</td>

                                                                                                    <td>
                                                                                                        <!-- PHP block to generate the correct file extension and download filename -->
                                                                                                        @php
                                                                                                            $fileExtension = pathinfo($list->name, PATHINFO_EXTENSION); // Get the file extension
                                                                                                            $downloadFilename = $list->title . '.' . $fileExtension; // Set the download filename with title and extension
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
            url: '{{ route('staff.docs.delete', ['id' => ':id']) }}'.replace(':id', id),
            type: 'get',  // Use DELETE method
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