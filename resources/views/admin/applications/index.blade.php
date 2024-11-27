@extends('admin.default')

@section('content')
<div class="container-fluid px-4">
    <h3 class="mt-4">Applications</h3>

    <a href="{{ route('application.add') }}" class="btn btn-sm btn-primary float-end">Add New Student</a>

    <div class="card bg-white p-3 mt-5 border-0 shadow-sm rounded">
        <h5 class="text-muted mb-3">Applications List</h5>
        <table class="table table-striped">
            <thead class="bg-light">
                <tr>
                    <th scope="col">Admission No</th>
                    <th scope="col">Name</th>
                    <th scope="col">Father Name</th>
                    <th scope="col">Date Of Birth</th>
                    <th scope="col">Gender</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($students as $list)
                    <tr>
                        <td>{{$list->admission_no}}</td>
                        <td>{{$list->first_name}}</td>
                        <td>{{$list->last_name}}</td>
                        <td>{{ \Carbon\Carbon::parse($list->dob)->format('d  M Y') }}</td>
                        <td>
                            <div class="dropdown">
                                <button class="btn btn-primary btn-sm dropdown-toggle" type="button"
                                    id="dropdownMenuButton{{ $list->id }}" data-bs-toggle="dropdown" aria-expanded="false">
                                    Action
                                </button>
                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton{{ $list->id }}">
                                    <li>
                                        <a class="dropdown-item" href="{{ route('student.view', $list->id) }}"
                                            title="View Student">
                                            <i class="fa fa-eye"></i> View
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="{{ route('student.edit', $list->id)  }}"
                                            title="Edit Student">
                                            <i class="fa fa-edit"></i> Edit
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="javascript:void(0);" title="Delete Student" onclick="deleteStu()">
                                            <i class="fa fa-trash"></i> Delete
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td class="text-center" colspan="5">No Applications Found!</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        <div class="d-flex justify-content-between mt-3 align-items-center">
            <!-- Left side: Showing results -->
            <div class="small text-muted">
                Showing {{ $students->firstItem() }} to {{ $students->lastItem() }} of {{ $students->total() }} results
            </div>

            <!-- Right side: Pagination links -->
            <div>
                {{ $students->links('pagination::bootstrap-4') }}
            </div>
        </div>
    </div>


</div>

@endsection




<script>
    function deleteStu() {
        Swal.fire({
            text: "You won't be able to revert this!",
            showCancelButton: true,
            confirmButtonText: 'Delete',
            cancelButtonText: 'Cancel',
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
        }).then((result) => {
            if (result.isConfirmed) {
                // Make the AJAX request
                window.location.href = "{{ route('student.delete', $list->id ?? '') }}";

            }
        });
    }
</script>