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
                        <!-- Academic Informations -->
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
                                        </div>
                                        <div class="col-6">
                                            <label for="" class="text-muted mb-2 ">Admission Number</label>
                                            <input type="text" class="form-control" name="admission_no"
                                                value="{{$newAdmissionNumber}}">
                                        </div>

                                        <div class="col-6 mt-3">
                                            <label for="" class="text-muted mb-2 ">Admission Date</label>
                                            <input type="text" class="form-control dateselector" name="admission_date"
                                                placeholder="Select Admission Date" required>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <!-- Personal Informations -->
                        <div class="col-6">
                            <div class="card bg-light border-0 shadow-none">
                                <div class="card-header border-0 bg-light pb-0 pl-3 pr-3 pt-3">
                                    <p class="text-muted">Personal Information</p>
                                    <hr class="w-100" style="font-weight : 200px;">
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-6 mb-2">
                                            <label for="" class="text-muted mb-2 ">First Name </label>
                                            <input type="text" class="form-control" placeholder="Enter First Name" name="first_name">
                                        </div>

                                        <div class="col-6 mb-2">
                                            <label for="" class="text-muted mb-2 ">Last Name </label>
                                            <input type="text" class="form-control" placeholder="Enter Last Name" name="last_name">
                                        </div>
                                        <div class="col-6">
                                            <label for="" class="text-muted mb-2 ">Admission Number</label>
                                            <input type="text" class="form-control" name="admission_no"
                                                value="{{$newAdmissionNumber}}">
                                        </div>

                                        <div class="col-6 mt-3">
                                            <label for="" class="text-muted mb-2 ">Admission Date</label>
                                            <input type="text" class="form-control dateselector" name="admission_date"
                                                placeholder="Select Admission Date" required>
                                        </div>
                                    </div>
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
            dropdownParent: $('.cp_wrapper')
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