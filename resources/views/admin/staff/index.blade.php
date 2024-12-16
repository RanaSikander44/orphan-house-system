@extends('admin.default')
@section('Page-title', 'Staff List')

@section('content')
<div class="container-fluid px-4">

    <div class="card bg-white px-4 py-3 mt-4 border-0 shadow-sm rounded">
        <table class="table table-striped">
            <thead class="bg-light">
                <tr>
                    <th scope="col">Name</th>
                    <th scope="col">Email</th>
                    <th scope="col">Gender</th>
                    <th scope="col">Role</th>
                    <th scope="col">Actions</th>
                </tr>
            </thead>
            <tbody>

                @forelse($staff as $list)
                    <tr>
                        <td>{{ $list->first_name }} {{ $list->last_name }}</td>
                        <td>{{ $list->email }}</td>
                        <td>{{ $list->gender }}</td>
                        <td>{{ $list->role->name }}</td>
                        <td>
                            <div class="dropdown">
                                <button class="btn btn-primary btn-sm dropdown-toggle" type="button"
                                    id="dropdownMenuButton{{ $list->id }}" data-bs-toggle="dropdown" aria-expanded="false">
                                    Action
                                </button>
                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton{{ $list->id }}">
                                    <li>
                                        <a class="dropdown-item" href="{{ route('staff.show', $list->id) }}"
                                            title="View Student">
                                            <i class="fa fa-eye"></i> View
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="{{ route('staff.edit', $list->id)  }}"
                                            title="Edit Student">
                                            <i class="fa fa-edit"></i> Edit
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="javascript:void(0);" title="Delete Student"
                                            onclick="deleteStaff({{ $list->id }})">
                                            <i class="fa fa-trash"></i> Delete
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="12" class="text-center">No Data Found!</td>
                    </tr>
                @endforelse


            </tbody>
        </table>

        <!-- Pagination -->
        <div class="d-flex justify-content-between mt-3 align-items-center">
            <div>
                <span>Showing {{ $staff->firstItem() ?? 0 }} to {{ $staff->lastItem() ?? 0 }} of {{ $staff->total() }}
                    entries</span>
            </div>
            <div>
                {{ $staff->links() }}
            </div>
        </div>

    </div>

</div>
@endsection



<script>
    let deleteStaff = (id) => {
        Swal.fire({
            text: "You won't be able to revert this!",
            showCancelButton: true,
            confirmButtonText: 'Delete',
            cancelButtonText: 'Cancel',
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = "{{ route('staff.delete', ':id') }}".replace(':id', id);

            }
        });
    }
</script>