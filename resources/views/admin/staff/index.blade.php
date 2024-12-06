@extends('admin.default')
@section('Page-title', 'Staff List')

@section('content')
<div class="container-fluid px-4">

    <div class="card bg-white px-4 py-3 mt-4 border-0 shadow-sm rounded">
        <table class="table table-striped">
            <thead class="bg-light">
                <tr>
                    <th scope="col">Name</th>
                    <th scope="col">Role</th>
                    <th scope="col">Actions</th>
                </tr>
            </thead>
            <tbody>

                @forelse($staff as $list)
                    <tr>
                        <td>{{ $list->first_name }} {{ $list->last_name }}</td>
                        <td>{{ $list->role_id }}</td>
                        <td></td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="text-center">No Staff Data Found!</td>
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