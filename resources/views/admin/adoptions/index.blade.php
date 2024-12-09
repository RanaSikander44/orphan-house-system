@extends('admin.default')


@section('Page-title' , 'Adoption List')

@section('content')
<div class="container-fluid px-4">


    <div class="card bg-white px-4 py-3 mt-4 border-0 shadow-sm rounded">
        <h5 class="text-muted mb-3">Adoption List</h5>
        <table class="table table-striped">
            <thead class="bg-light">
                <tr>
                    <th scope="col">Enquiry No</th>
                    <th scope="col">Name</th>
                    <th scope="col">Father Name</th>
                    <th scope="col">Date Of Birth</th>
                    <th scope="col">Gender</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($childrens as $list)
                    <tr>
                        <td>{{$list->admission_no}}</td>
                        <td>{{$list->first_name}}</td>
                        <td>{{$list->last_name}}</td>
                        <td>{{ \Carbon\Carbon::parse($list->dob)->format('d  M Y') }}</td>
                        <td>{{ $list->gender}}</td>
                        <td>
                            <div class="dropdown">
                                <button class="btn btn-primary btn-sm dropdown-toggle" type="button"
                                    id="dropdownMenuButton{{ $list->id }}" data-bs-toggle="dropdown" aria-expanded="false">
                                    Action
                                </button>
                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton{{ $list->id }}">
                                    <li>
                                        <a class="dropdown-item" href="{{ route('enquiry.view', $list->id) }}"
                                            title="View Enquiry">
                                            <i class="fa fa-eye"></i> View
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="{{ route('enquiry.edit', $list->id)  }}"
                                            title="Edit Enquiry">
                                            <i class="fa fa-edit"></i> Edit
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="javascript:void(0);" title="Delete Enquiry" onclick="deleteChl()">
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
                Showing {{ $childrens->firstItem() }} to {{ $childrens->lastItem() }} of {{ $childrens->total() }} results
            </div>

            <!-- Right side: Pagination links -->
            <div>
                {{ $childrens->links('pagination::bootstrap-4') }}
            </div>
        </div>
    </div>
    
</div>

@endsection




<script>
    function deleteChl() {
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
                window.location.href = "{{ route('enquiry.delete', $list->id ?? '') }}";

            }
        });
    }
</script>