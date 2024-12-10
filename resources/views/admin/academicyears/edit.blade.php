@extends('admin.default')

@section('Page-title', 'Edit Session')

@section('content')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

<div class="container-fluid px-4 mt-4">
    <div class="row mt-4">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-body">
                        <h3 class=" mb-4">Edit Academic Year</h3>
                        <form action="{{ route('academic-year.update', $rowforedit->id) }}" method="post">

                            @csrf
                            <div class="row">
                                <div class="col-lg-4 col-md-6 mb-3">
                                    <label for="year" class="form-label">Year <span
                                            class="text-danger">*</span></label>
                                            <input type="number" class="form-control" name="year" placeholder="Enter Year" value="{{ $rowforedit->year }}" required>
                                </div>
                                <div class="col-lg-4 col-md-6 mb-3">
                                    <label for="title" class="form-label">Year Title <span
                                            class="text-danger">*</span></label>
                                            <input type="text" class="form-control" name="title" placeholder="Enter Year Title" value="{{ $rowforedit->title }}" required>
                                </div>
                                <div class="col-lg-4 col-md-6 mb-3">
                                    <label for="starting_date" class="form-label">Starting Date <span
                                            class="text-danger">*</span></label>
                                            <input type="text" class="form-control dateselector" name="starting_date" placeholder="Select Starting Date" value="{{ $rowforedit->starting_date }}" required>

                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6 col-md-6 mb-3">
                                    <label for="ending_date" class="form-label">Ending Date <span
                                            class="text-danger">*</span></label>
                                            <input type="text" class="form-control dateselector" name="ending_date" placeholder="Select Ending Date" value="{{ $rowforedit->ending_date }}" required>

                                </div>
                                <div class="col-lg-6 col-md-6 mb-3">
                                    <label for="status" class="form-label">Status <span
                                            class="text-danger">*</span></label>
                                    <input type="number" class="form-control" name="status" placeholder="Enter Status" value="{{ $rowforedit->status }}"
                                        required>
                                </div>
                            </div>
                            <div class="text-end mt-1 ">
                                <button class="btn btn-primary btn-md">
                                    <i class="fas fa-save"></i> Update
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row mt-1">
        <div class="col-md-12">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <h5 class="mb-4">Academic Years</h5>
                    <table class="table table-striped table-hover">
                        <thead class="bg-light">
                            <tr>
                                <th scope="col">Year</th>
                                <th scope="col">Year Title</th>
                                <th scope="col">Starting Date</th>
                                <th scope="col">Ending Date</th>
                                <th scope="col">Status</th>
                                <th scope="col">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($year as $list)
                                <tr>
                                    <td>{{ $list->year }}</td>
                                    <td>{{ $list->title }}</td>
                                    <td>{{ \Carbon\Carbon::parse($list->starting_date)->format('d M Y') }}</td>
                                    <td>{{ \Carbon\Carbon::parse($list->ending_date)->format('d M Y') }}</td>
                                    <td>{{ $list->status ? 'Active' : 'Inactive' }}</td>

                                    <td>
                                        <div class="dropdown">
                                            <button class="btn btn-sm btn-primary dropdown-toggle" type="button"
                                                id="actionMenu" data-bs-toggle="dropdown" aria-expanded="false">
                                                Actions
                                            </button>
                                            <ul class="dropdown-menu" aria-labelledby="actionMenu">
                                                <li>
                                                    <a class="dropdown-item"
                                                        href="{{ route('academic-year.edit', $list->id) }}">
                                                        <i class="fas fa-edit"></i> Edit
                                                    </a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item text-danger"
                                                        href="{{ route('academic-year.delete', $list->id) }}">
                                                        <i class="fas fa-trash"></i> Delete
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center text-muted">No academic years available.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                    <div class="d-flex justify-content-between align-items-center mt-3">
                        <div class="text-muted">
                            Showing {{ $year->firstItem() }} to {{ $year->lastItem() }} of {{ $year->total() }} results
                        </div>
                        <div>
                            {{ $year->links('pagination::bootstrap-4') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<style>
    .card {
        border-radius: 10px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }

    .table {
        font-size: 0.95rem;
    }

    .table th,
    .table td {
        vertical-align: center;
        padding: 1rem;
    }

    .table-striped tbody tr:nth-of-type(odd) {
        background-color: #f9f9f9;
    }

    .table th {
        font-weight: bolder;
        text-align: start;
    }


</style>

<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script>
    $(".dateselector").flatpickr({
        dateFormat: "Y-m-d", // Define the desired date format
    });
</script>


<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
    integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN"
    crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js"
    integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q"
    crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"
    integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl"
    crossorigin="anonymous"></script>
@endsection
