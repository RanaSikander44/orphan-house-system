@extends('admin.default')

@section('Page-title', 'Edit School')

@section('content')
<div class="container-fluid px-4">

    <div class="card bg-white px-4 py-3 mt-4 border-0 shadow-sm rounded">
        <div class="card-body">
            <form method="POST" action="{{ route('schools.update', $school->id) }}">
                @csrf
                @method('put')
                <div class="row">
                    <div class="col-md-6">
                        <label for="name" class="form-label">School Name</label>
                        <input type="text" name="name" id="name" class="form-control" value="{{ $school->name }}"
                            placeholder="Enter school name" required>
                    </div>

                    <div class="col-md-6">
                        <label for="fees" class="form-label">School Fees</label>
                        <input type="number" name="fees" id="fees" class="form-control" value="{{ $school->fees }}"
                            placeholder="Enter fees amount" required>
                    </div>

                    <div class="col-md-6 mt-3">
                        <label for="grade" class="form-label">Select Grade</label>
                        <select name="grade" id="" class="form-control">
                            @foreach ($grade as $list)
                                <option value="{{ $list->id }}" {{ $list->id == $school->grade ? 'selected' : '' }}>
                                    {{ $list->grade }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-6 mt-3">
                        <label for="address" class="form-label">Address</label>
                        <textarea name="address" class="form-control" id="" rows="4" cols="50">
                            {{ $school->address }}
                        </textarea>
                    </div>

                </div>

                <div class="d-flex justify-content-end mt-4">
                    <button type="submit" class="btn btn-primary">Update School</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection