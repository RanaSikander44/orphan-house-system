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
                            <button class="nav-link custom-btn active" id="profile-tab" data-bs-toggle="pill"
                                data-bs-target="#profile" type="button" role="tab" aria-controls="profile"
                                aria-selected="true">
                                <i class="bi bi-award me-2"></i>Profile
                            </button>
                        </li>

                        @if($staff->role->name === 'Nanny')
                            <li class="nav-item" role="presentation">
                                <button class="nav-link custom-btn" id="childs-tab" data-bs-toggle="pill"
                                    data-bs-target="#childs" type="button" role="tab" aria-controls="childs"
                                    aria-selected="false">
                                    <i class="bi bi-award me-2"></i>Childs
                                </button>
                            </li>
                        @endif

                        <li class="nav-item" role="presentation">
                            <button class="nav-link custom-btn" id="documents-tab" data-bs-toggle="pill"
                                data-bs-target="#documents" type="button" role="tab" aria-controls="documents"
                                aria-selected="false">
                                <i class="bi bi-calendar-check me-2"></i>Documents
                            </button>
                        </li>
                    </ul>

                    <hr>

                    <!-- Pills Content -->
                    <div class="tab-content" id="infoTabsContent">
                        <!-- Profile Tab Pane -->
                        <div class="tab-pane fade show active" id="profile" role="tabpanel"
                            aria-labelledby="profile-tab">
                            <div class="pt-0 p-4 rounded-3">
                                <div class="row g-0">
                                    <!-- Profile Rows Here -->
                                    <div class="d-flex align-items-center py-3 border-bottom">
                                        <div class="col-6">
                                            <h6 class="mb-0 text-muted">First Name</h6>
                                        </div>
                                        <div class="col-6 text-muted text-end">
                                            <p class="mb-0">{{ $staff->user_id }}</p>
                                        </div>
                                    </div>
                                    <div class="d-flex align-items-center py-3 border-bottom">
                                        <div class="col-6">
                                            <h6 class="mb-0 text-muted">Last Name</h6>
                                        </div>
                                        <div class="col-6 text-muted text-end">
                                            <p class="mb-0">{{ $staff->user_id }}</p>
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
                                            <p class="mb-0">{{ $staff->age . ' Years' }}</p>
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
                                            <h6 class="mb-0 text-muted">Present Address</h6>
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
                                </div>
                            </div>
                        </div>

                        <!-- Childs Tab Pane (Visible only if the role is 'Nanny') -->
                        @if($staff->role->name === 'Nanny')
                            <div class="tab-pane fade" id="childs" role="tabpanel" aria-labelledby="childs-tab">
                                <h4 class="p-4 text-muted">Assigned Childs</h4>
                                <div class="pt-0 p-4 rounded-3">
                                    <div class="row g-0">
                                        @foreach ($childs as $list)                                        
                                            <div class="d-flex align-items-center py-3 border-bottom">
                                                <div class="col-6">
                                                    <h6 class="mb-0 text-muted">{{ $list->child->first_name }}
                                                        {{ $list->child->last_name }}
                                                    </h6>
                                                </div>
                                                <div class="col-6 text-muted text-end">
                                                    <a href="{{ route('enquiry.view', $list->child_id) }}" target="__blank"
                                                        class="btn btn-sm btn-warning text-white"><i
                                                            class="fa-solid fa-eye"></i></a>
                                                </div>
                                            </div>
                                        @endforeach
                                        <!-- Add more rows for Childs tab as needed -->
                                    </div>
                                </div>
                            </div>
                        @endif

                        <!-- Documents Tab Pane -->
                        <div class="tab-pane fade" id="documents" role="tabpanel" aria-labelledby="documents-tab">
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
                                                                                                            <td>{{ $list->staffDocs->title ?? 'Unknown Document' }}</td>
                                                                                                            <td>{{ $list->name }}</td>
                                                                                                            <td>
                                                                                                                @php
                                                                                                                    $fileExtension = pathinfo($list->name, PATHINFO_EXTENSION);
                                                                                                                    $downloadFilename = $list->title . '.' . $fileExtension;
                                                                                                                @endphp
                                                                                                                <a href="{{ asset('backend/documents/' . $list->name) }}"
                                                                                                                    class="btn btn-sm btn-primary rounded-pill"
                                                                                                                    download="{{ $downloadFilename }}">
                                                                                                                    <i class="fa-solid fa-download"></i> Download
                                                                                                                </a>
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