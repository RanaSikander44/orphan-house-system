@extends('admin.default')


@section('Page-title', 'Schools')

@section('content')
<div class="container-fluid px-4">

    <div class="card bg-white px-4 py-3 mt-4 border-0 shadow-sm rounded">
        <table class="table table-striped">
            <thead class="bg-light">
                <tr>
                    <th scope="col">Name</th>   
                    <th scope="col">Grade</th>
                    <th scope="col">Fees</th>
                    <th scope="col">Address</th>
                    <th scope="col">Actions</th>
                </tr>
            </thead>
            <tbody>

                @forelse($schools as $list)
                    <tr>
                        <td>{{ $list->name }} {{ $list->last_name }}</td>
                        <td>{{ $list->grade }}</td>
                        <td>{{ $list->fees }}</td>
                        <td>{{ $list->address }}</td>
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
                <span>Showing {{ $schools->firstItem() ?? 0 }} to {{ $schools->lastItem() ?? 0 }} of {{ $schools->total() }}
                    entries</span>
            </div>
            <div>
                {{ $schools->links() }}
            </div>
        </div>

    </div>

</div>


@endsection