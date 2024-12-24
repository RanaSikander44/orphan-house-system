@extends('admin.default')

@section('Page-title', 'Enquiry Types')


@section('content')
{{-- Include external CSS for Flatpickr --}}
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

@section('Page-title', 'Academic Years')

<div class="container-fluid px-4 mt-4">
    <div class="row">
        <!-- Form Column -->
        <div class="col-md-4">
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-body">
                    <form action="{{ route('enquiry-types.store') }}" method="post">
                        @csrf
                        <!-- Year Input -->
                        <div class="mb-3">
                            <label for="year" class="form-label">Title <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="title" placeholder="Enter Title" required>
                        </div>

                        <!-- Year Title Input -->
                        <div class="mb-3">
                            <label for="title" class="form-label">Status<span class="text-danger">*</span></label>
                            <select name="status" id="" class="form-control">
                                <option value="1">Active</option>
                                <option value="0">Inactive</option>
                            </select>
                        </div>
                        <!-- Submit Button -->
                        <button class="btn btn-primary btn-sm w-100 mt-3">
                            <i class="fas fa-save"></i> Save
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Table Column -->
        <div class="col-md-8">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <table class="table table-striped table-hover">
                        <thead class="bg-light">
                            <tr>
                                <th scope="col">Title</th>
                                <th scope="col">Status</th>
                                <th scope="col">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($enquiry as $list)
                                <tr>
                                    <td>{{ $list->title }}</td>
                                    <td>{{ $list->status === 1 ? 'Active' : 'Inactive'}}</td>
                                    <td>
                                        <div class="dropdown">
                                            <button class="btn btn-sm btn-primary dropdown-toggle" type="button"
                                                id="actionMenu" data-bs-toggle="dropdown" aria-expanded="false">
                                                Actions
                                            </button>
                                            <ul class="dropdown-menu" aria-labelledby="actionMenu">
                                                <li>
                                                    <a class="dropdown-item"
                                                        href="{{ route('enquiry-types.show', $list->id) }}">
                                                        <i class="fas fa-edit"></i> Edit
                                                    </a>
                                                </li>
                                                <li>
                                                    <form action="{{ route('enquiry-types.destroy', $list->id) }}"
                                                        method="POST" class="d-inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="dropdown-item text-danger">
                                                            <i class="fas fa-trash"></i> Delete
                                                        </button>
                                                    </form>
                                                </li>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center text-muted">No Enquiry Types are available.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>

                    <!-- Pagination -->
                    <div class="d-flex justify-content-between align-items-center mt-3">
                        <div class="text-muted">
                            Showing {{ $enquiry->firstItem() }} to {{ $enquiry->lastItem() }} of {{ $enquiry->total() }}
                            results
                        </div>
                        <div>
                            {{ $enquiry->links('pagination::bootstrap-4') }}
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