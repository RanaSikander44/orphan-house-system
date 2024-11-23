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
        <div class="col-md-8">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">
                    <!-- Title -->
                    <h5 class="fw-bold mb-3">Additional Information</h5>

                    <!-- Placeholder Content -->
                    <p class="text-muted">
                        This section is reserved for additional information such as academic performance, attendance
                        records, and other relevant details.
                    </p>

                    <!-- Example Buttons -->
                    <div class="d-flex gap-2">
                        <button class="btn btn-primary">View Profile</button>
                        <button class="btn btn-secondary">Send Message</button>
                    </div>
                </div>
            </div>
        </div>
    </div>




</div>

@endsection