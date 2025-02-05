@extends('admin.default')
@section('Page-title', 'Edit Dormitory Room')
@section('content')
<div class="container-fluid px-4">
    <form action="{{ route('room.update', $dormitory->id) }}" method="POST">
        @csrf
        <div class="card bg-white px-4 py-3 mt-4 border-0 shadow-sm rounded">
            <div class="card-body bg-white">
                <div class="row">
                    <div class="col-md-6">
                        <label for="" class="fw-bold mb-3">Title</label>
                        <input type="text" class="form-control" name="title" value="{{ $dormitory->title }}">
                    </div>
                    <div class="col-md-6">
                        <label for="" class="fw-bold mb-3">Max Number Of Bed</label>
                        <input type="number" class="form-control" name="max_number_bed"
                            value="{{ $dormitory->max_number_bed }}" required>
                    </div>
                    <div class="col-md-6 mt-3">
                        <label for="" class="fw-bold mb-3">Select Mother <span class="text-danger">*</span></label>
                        <select name="nanny_id" id="MotherSelection" class="form-control" required>
                            @foreach ($nanny as $list)
                                <option value="{{ $list->id }}" class="form-control" {{ $list->id == $dormitory->nanny_id ? 'selected' : '' }}>
                                    {{ $list->first_name }} {{ $list->last_name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            <div class="card-footer border-0 bg-white text-end">
                <button class="btn btn-sm btn-primary">Update</button>
            </div>
        </div>
    </form>
</div>
@endsection

<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

<script>
    $(document).ready(function () {
        $('#MotherSelection').select2();
    });
</script>