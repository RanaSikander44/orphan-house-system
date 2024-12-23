@extends('admin.default')

@section('Page-title', 'Dashboard')

@section('content')
<div class="container-fluid px-4">
    <div class="row">
        <div class="col-12">
            <div class="card bg-white text-dark mb-4 rounded-2 mt-4">
                <div class="card-body">
                    <h5 class="ms-1">Welcome - {{ Auth::user()->first_name }} | {{   ucfirst(Auth::user()->role->name) }} Dashboard</h5>
                    <div class="row mt-4">
                        <div class="col-md-3">
                            <div class="card bg-info text-white rounded-2 bg-gradient" style="border: none;">
                                <h5 class="ms-3 mt-3">Childs</h5>
                                <p class="ms-3 mt-2">Total Childs</p>
                                <a class="h5 text-white fw-bold stretched-link ms-3 mb-3 text-decoration-none"
                                    href="{{ route('adoptions') }}">{{ $students }}</a>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card text-white rounded-2 bg-gradient"
                                style="border: none; background-color: #DC4BF1;">
                                <h5 class="ms-3 mt-3">Users</h5>
                                <p class="ms-3 mt-2">Total Users</p>
                                <a class="h5 text-white fw-bold stretched-link ms-3 mb-3 text-decoration-none"
                                    href="{{ route('users') }}">{{ $users_count }}</a>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card text-white rounded-2 bg-gradient"
                                style="border: none; background-color: #8D5FF6;">
                                <h5 class="ms-3 mt-3">Teachers</h5>
                                <p class="ms-3 mt-2">Total Teachers</p>
                                <a class="h5 text-white fw-bold stretched-link ms-3 mb-3 text-decoration-none"
                                    href="#">0</a>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card bg-primary text-white rounded-2 bg-gradient" style="border: none;">
                                <h5 class="ms-3 mt-3">Parents</h5>
                                <p class="ms-3 mt-2">Total Parents</p>
                                <a class="h5 text-white fw-bold stretched-link ms-3 mb-3 text-decoration-none"
                                    href="#">0</a>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>



    <!-- <div class="row">
        <div class="col-xl-6">
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-chart-area me-1"></i>
                    Area Chart Example
                </div>
                <div class="card-body"><canvas id="myAreaChart" width="100%" height="40"></canvas></div>
            </div>
        </div>
        <div class="col-xl-6">
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-chart-bar me-1"></i>
                    Bar Chart Example
                </div>
                <div class="card-body"><canvas id="myBarChart" width="100%" height="40"></canvas></div>
            </div>
        </div>
    </div> -->
</div>
@endsection