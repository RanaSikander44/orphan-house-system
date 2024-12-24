@extends('admin.default')

@section('Page-title', 'Add School')

@section('content')
<div class="container-fluid px-4">

    <div class="card bg-white px-4 py-3 mt-4 border-0 shadow-sm rounded">
        <div class="card-body">
            <form method="POST" action="{{ route('schools.store') }}">
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <label for="name" class="form-label">School Name</label>
                        <input type="text" name="name" id="name" class="form-control" placeholder="Enter school name"
                            required>
                    </div>

                    <div class="col-md-6">
                        <label for="fees" class="form-label">School Fees</label>
                        <input type="number" name="fees" id="fees" class="form-control" placeholder="Enter fees amount"
                            required>
                    </div>

                    <div class="col-md-6 mt-3">
                        <label for="grade" class="form-label">Select Grade</label>
                        <select name="grade" id="" class="form-control">
                            @foreach ($grade as $list)
                                <option value="{{ $list->id }}">{{ $list->grade }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-6 mt-3">
                        <label for="address" class="form-label">Address</label>
                        <textarea name="address" class="form-control" id="" rows="4" cols="50"></textarea>
                    </div>

                </div>

                <div class="d-flex justify-content-end mt-4">
                    <button type="submit" class="btn btn-primary">Add School</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection