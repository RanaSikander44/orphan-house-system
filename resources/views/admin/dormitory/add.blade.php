@extends('admin.default')

@section('Page-title', 'Add Dormitory Room')

@section('content')
<div class="container-fluid px-4">
    <form action="{{ route('room-store') }}" method="POST">
        @csrf
        <div class="card bg-white px-4 py-3 mt-4 border-0 shadow-sm rounded">
            <div class="card-body bg-white">
                <div class="row">
                    <div class="col-md-6">
                        <label for="" class="fw-bold mb-3">Title</label>
                        <input type="text" class="form-control" name="title">
                    </div>
                    <div class="col-md-6">
                        <label for="" class="fw-bold mb-3">Max Number Of Bed</label>
                        <input type="number" class="form-control" name="max_number_bed" required>
                    </div>
                </div>
            </div>
            <div class="card-footer border-0 bg-white text-end">
                <button class="btn btn-sm btn-primary">Save</button>
            </div>
        </div>

    </form>
</div>



@endsection