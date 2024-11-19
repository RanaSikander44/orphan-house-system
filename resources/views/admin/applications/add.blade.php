@extends('admin.default')
@section('content')
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>


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
                    <a class="nav-link" id="menu2Tab" data-bs-toggle="pill" href="#menu2">Previous School
                        Information</a>
                </li>
            </ul>
            <hr class="w-100 my-4" style="font-weight : 200px;">
        </div>
        <!-- Tab Content -->
        <div class="tab-content mt-3">
            <div class="tab-pane fade show active" style="width : 100%;" id="home">
                <div class="p-3">
                    <div class="row d-flex">
                        <div class="col-6">
                            <div class="card bg-light border-0 shadow-none">
                                <div class="card-header border-0 bg-light pb-0 pl-3 pr-3 pt-3">
                                    <p class="text-muted">Academic Information</p>
                                    <hr class="w-100" style="font-weight : 200px;">
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-6 mb-2">
                                            <label for="" class="text-muted mb-2 ">Academic Year </label>
                                            <div class="cp_wrapper">
                                                <select class="select2" name="color">
                                                    <option value="black">Black</option>
                                                    <option value="white">White</option>
                                                    <option value="gold">Gold</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <label for="" class="text-muted mb-2 ">Admission Number </label>
                                            <input type="text" class="form-control">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="card bg-light border-0">
                                <div class="card-body">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="tab-pane fade" id="menu1">
                <div class="p-3">
                    <div class="card bg-white">
                        <div class="card-body">
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
    </div>
</div>

<script>
    $(document).ready(function () {
        $('.select2').select2({
            dropdownParent: $('.cp_wrapper') // Replace `.cp_wrapper` with your container
        });
    });
</script>
@endsection




<style>
    .select2-container {
        width: 100% !important;
    }

    .select2-container .select2-selection--single {
        height: 40px !important;
        /* Adjust height */
        line-height: 48px !important;
        /* Center text vertically */
        padding: 5px 5px !important;
        /* Adjust padding */
        border: 1px solid #C0C0C0 !important;
        /* Ensure border styling */
        border-radius: 5px !important;
        /* Rounded corners */
        background-color: #FFFFFF !important;
    }

    .select2-container .select2-selection__rendered {
        color: #000000 !important;
        font-size: 16px !important;
    }

    .select2-container--default .select2-selection--single .select2-selection__arrow {
        height: 40px !important;
        width: 40px !important;
    }

    .select2-container .select2-dropdown {
        border-radius: 5px !important;
        border: 1px solid #C0C0C0 !important;
    }

    .select2-container .select2-search--dropdown .select2-search__field {
        padding: 5px !important;
        font-size: 12px !important;
    }
</style>