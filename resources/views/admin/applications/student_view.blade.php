@extends('admin.default')

@section('content')
<div class="container-fluid px-4">
    <h3 class="mt-4">Student View</h3>

    <div class="row mt-4">
        <!-- Student Details Section -->
        <div class="col-md-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">
                    <!-- Title -->
                    <h5 class="text-muted fw-bold text-center mb-4">Student Details</h5>

                    <!-- Student Image Section -->
                    <div class="position-relative text-center"
                        style="min-height: 150px; background-color: #7c32ff; border-radius: 8px;">
                        <div class="d-flex justify-content-center align-items-center h-100">
                            <img class="student-meta-img img-fluid rounded-2 shadow"
                                style="width: 100px; height: 100px; object-fit: cover; border: 2px solid #fff; position: absolute; top : 65px;"
                                src="{{ asset('backend/images/students/' . $student->student_image)}}"
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

        <!-- Main Content Section -->
        <div class="col-md-9">
            <div class="card border-0 shadow-none rounded-3">
                <div class="card-body p-3">
                    <ul class="nav nav-pills mb-4" id="infoTabs" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active square-btn" id="academic-tab" data-bs-toggle="pill"
                                data-bs-target="#academic" type="button" role="tab" aria-controls="academic"
                                aria-selected="true">
                                <i class="bi bi-award me-2 ml-3"></i>Profile
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link square-btn" id="attendance-tab" data-bs-toggle="pill"
                                data-bs-target="#attendance" type="button" role="tab" aria-controls="attendance"
                                aria-selected="false">
                                <i class="bi bi-calendar-check me-2"></i>Attendance Records
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link square-btn" id="other-tab" data-bs-toggle="pill"
                                data-bs-target="#other" type="button" role="tab" aria-controls="other"
                                aria-selected="false">
                                <i class="bi bi-file-earmark-text me-2"></i>Other Details
                            </button>
                        </li>
                    </ul>


                    <!-- Pills Content with Box Shadows -->
                    <div class="tab-content" id="infoTabsContent">
                        <!-- Academic Performance Tab -->
                        <div class="tab-pane fade show active" id="academic" role="tabpanel"
                            aria-labelledby="academic-tab">
                            <div class="p-4 rounded-3 shadow-sm bg-light">
                                <p class="text-muted">
                                    This section contains detailed information about the student's academic performance,
                                    grades, and achievements.
                                </p>
                            </div>
                        </div>

                        <!-- Attendance Records Tab -->
                        <div class="tab-pane fade" id="attendance" role="tabpanel" aria-labelledby="attendance-tab">
                            <div class="p-4 rounded-3 shadow-sm bg-light">
                                <p class="text-muted">
                                    This section contains attendance records, including total classes attended and
                                    absences.
                                </p>
                            </div>
                        </div>

                        <!-- Other Details Tab -->
                        <div class="tab-pane fade" id="other" role="tabpanel" aria-labelledby="other-tab">
                            <div class="p-4 rounded-3 shadow-sm bg-light">
                                <p class="text-muted">
                                    This section contains other relevant details, such as extracurricular activities and
                                    disciplinary records.
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Example Buttons with Hover Effects -->
                    <div class="d-flex gap-3 mt-4">
                        <button class="btn btn-primary square-btn shadow-sm">View Profile</button>
                        <button class="btn btn-outline-secondary square-btn shadow-sm">Send Message</button>
                    </div>
                </div>
            </div>
        </div>


        <style>
            /* Default Button Style */
            .square-btn {
                border: 2px solid #7c32ff;
                /* Border color */
                background-color: #f3f4f6;
                /* Light background color */
                color: #7c32ff;
                /* Text color */
                padding: 10px 30px;
                /* Padding */
                margin-right: 15px;
                /* Space between buttons */
                border-radius: 5px;
                /* Rounded corners for buttons */
                transition: all 0.3s ease;
                /* Smooth transition */
            }

            /* Hover Effect */
            .square-btn:hover {
                background-color: #7c32ff;
                /* Background color on hover */
                color: #fff;
                /* Text color on hover */
            }

            /* Active Button (Clicked) Style */
            .square-btn.active {
                background-color: none;
                /* No background color when clicked */
                color: #7c32ff;
                /* Keep the text color */
                border-color: #7c32ff;
                /* Keep the border */
            }

            /* Optional: Add an icon color change when active */
            .square-btn.active i {
                color: #7c32ff;
                /* Icon color when active */
            }

            /* Active tab styling */
            .nav-pills .nav-link.active {
                background-color: #7c32ff;
                color: white;
                border-radius: 0px;
                box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            }

            /* Tab content area with padding and box-shadow */
            .tab-content>.tab-pane {
                padding: 15px;
            }
        </style>





    </div>

    @endsection