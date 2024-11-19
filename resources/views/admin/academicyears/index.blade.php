@extends('admin.default')

@section('content')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">


<div class="container-fluid px-4 ">
    <h3 class="mt-4">Academic years</h3>
    <div class="row">
        <div class="col-3">
            <div class="card bg-white border-0 shadow-sm p-1 mt-5 mb-5">
                <div class="card-body">
                    <h5 class="">Add Academic Year</h5>
                    <form action="{{route('academic-year.save')}}" method="post">
                        @csrf
                        <label for="year" class="text-muted mt-2 mb-2">Year <span class="text-danger">*</span></label>
                        <input type="number" class="form-control" name="year" placeholder="Enter Year" required>

                        <label for="Year Title" class="text-muted mt-3 mb-2">Year Title <span
                                class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="title" placeholder="Enter Year Title" required>

                        <label for="Starting Date" class="text-muted mt-3 mb-2">Starting Date <span
                                class="text-danger">*</span></label>
                        <input type="text" class="form-control dateselector" name="starting_date"
                            placeholder="Select Starting Date" required>

                        <label for="Ending Date" class="text-muted mt-3 mb-2">Ending Date <span
                                class="text-danger">*</span></label>
                        <input type="text" class="form-control dateselector" name="ending_date"
                            placeholder="Select Ending Date" required>

                        <button class="p-2 btn btn-primary btn-sm mt-4 ms-5">
                            <i class="fas fa-check"></i> Save
                        </button>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-9">
            <div class="card bg-white p-3 mt-5 border-0 shadow-sm rounded">
                <table class="table table-striped">
                    <thead class="bg-light">
                        <tr>
                            <th scope="col">Year</th>
                            <th scope="col">Year Title</th>
                            <th scope="col">Starting Date</th>
                            <th scope="col">Ending Date</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($year as $list)
                            <tr>
                                <td>{{ $list->year }}</td>
                                <td>{{ $list->title }}</td>
                                <td>{{ \Carbon\Carbon::parse($list->starting_date)->format('d M Y') }}</td>
                                <td>{{ \Carbon\Carbon::parse($list->ending_date)->format('d M Y') }}</td>
                                <td>
                                    <div class="dropdown show">
                                        <a class="btn btn-primary btn-sm dropdown-toggle" href="#" role="button"
                                            id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true"
                                            aria-expanded="false">
                                            Action
                                        </a>

                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                            <a class="dropdown-item"
                                                href="{{ route('academic-year.edit', $list->id) }}">Edit</a>
                                            <a class="dropdown-item"
                                                href="{{ route('academic-year.delete', $list->id) }}">Delete</a>
                                        </div>
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

                <div class="d-flex justify-content-between mt-3 align-items-center">
                    <!-- Left side: Showing results -->
                    <div class="small text-muted">
                        Showing {{ $year->firstItem() }} to {{ $year->lastItem() }} of {{ $year->total() }} results
                    </div>

                    <!-- Right side: Pagination links -->
                    <div>
                        {{ $year->links('pagination::bootstrap-4') }}
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

    </div>
</div>

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