@extends('admin.default')

@section('content')
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
    window.addEventListener('load', () => {
        $('.select2').select2();
    });
</script>

@endsection