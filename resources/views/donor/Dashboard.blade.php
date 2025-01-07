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
                                    href="#">{{ $child }}</a>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

    @endsection