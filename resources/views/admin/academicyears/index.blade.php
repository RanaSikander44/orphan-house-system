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
            <div class="card bg-white p-3 mt-5 border-0 shadow-sm">
                <table class="table card-body table-striped">
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
                                <td>{{ $list->starting_date }}</td>
                                <td>{{ $list->ending_date }}</td>
                                <td>{{ $list->ending_date }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center">No academic years available.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                <div class="mt-3">
                    {{ $year->links() }}
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script>
    $(".dateselector").flatpickr({
        dateFormat: "Y-m-d", // Define the desired date format
    });
</script>
@endsection