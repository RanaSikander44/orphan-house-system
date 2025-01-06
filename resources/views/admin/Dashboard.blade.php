@extends('admin.default')

@section('Page-title', 'Dashboard')

@section('content')
<div class="container-fluid px-4">
    <div class="row">
        <div class="col-12">
            <div class="card bg-white text-dark mb-4 rounded-2 mt-4">
                <div class="card-body">
                    <h5 class="ms-1">Welcome - {{ Auth::user()->first_name }} |
                        {{   ucfirst(Auth::user()->role->name) }} Dashboard
                    </h5>
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


        @can('Activity_list')
            @if(!empty($latestActivity))
                <div class="container mt-3 mb-3">
                    <div class="card shadow-sm border-0">
                        <!-- Header -->
                        <div class="card-body">
                            <div class="d-flex align-items-center mb-3">
                                <!-- Profile Image -->
                                <img src="{{ asset('backend/images/childs/' . ($latestActivity->child->child_image ?? 'default.jpg')) }}"
                                    class="rounded-circle me-3" alt="Profile Image" width="50" height="50">

                                <div>
                                    <h6 class="mb-0">{{ $latestActivity->child->first_name ?? 'No Name Found' }}</h6>
                                    <small
                                        class="text-muted">{{ \Carbon\Carbon::parse($latestActivity->created_at)->format('l \a\t g:i A') }}</small>
                                </div>
                            </div>
                            <!-- Post Content -->
                            <h5 class="mb-2">{{ $latestActivity->name }}</h5>
                            <p class="mb-3 text-muted">{{ $latestActivity->desc }}</p>
                            <!-- Post Images Slider -->
                            <div id="imageSlider" class="carousel slide" data-bs-ride="carousel"
                                style="max-width: 500px; margin: 0 auto;">
                                <div class="carousel-inner">
                                    @foreach ($imagesOfCActivity as $index => $list)
                                        <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                                            <div class="text-center mb-3"
                                                style="background-color: #f8f9fa; width: 500px; height: 300px; display: flex; align-items: center; justify-content: center;">
                                                <img src="{{ asset($list->image) }}" class="img-fluid rounded" alt="Post Image"
                                                    style="max-width: 100%; max-height: 100%; object-fit: contain;">
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                                <!-- Controls -->
                                <button class="carousel-control-prev" type="button" data-bs-target="#imageSlider"
                                    data-bs-slide="prev">
                                    <span class="carousel-control-prev-icon" aria-hidden="true"
                                        style="background-color: black;"></span>
                                    <span class="visually-hidden">Previous</span>
                                </button>
                                <button class="carousel-control-next" type="button" data-bs-target="#imageSlider"
                                    data-bs-slide="next">
                                    <span class="carousel-control-next-icon" aria-hidden="true"
                                        style="background-color: black;"></span>
                                    <span class="visually-hidden">Next</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        @endcan
    </div>
    @endsection