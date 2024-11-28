@extends('admin.default')

@section('Page-title' , 'Users')


@section('content')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<div class="container-fluid px-4">
    <div class="card bg-white px-4 py-3 mt-4 border-0 shadow-sm rounded">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h5 class="text-muted">Users List</h5>
            <a href="{{ route('users.create') }}" class="btn btn-sm btn-primary">
                Add New
            </a>
        </div>

        @if($users->count())
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Actions</th> <!-- Actions Column -->
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                        <tr>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>
                                <span>{{ $user->role->role ?? 'No Role Assigned' }}</span>
                            </td>
                            <td>
                                <!-- Edit Button -->
                                <a href="{{ route('users.edit', $user->id) }}"
                                    class="btn btn-sm text-white btn-warning">Edit</a>

                                <!-- Delete Button -->
                                <button type="button" class="btn btn-sm btn-danger"
                                    onclick="deleteUser({{ $user->id }})">Delete</button>

                                <!-- Form for Deleting User -->
                                <form id="delete-form-{{ $user->id }}" action="{{ route('users.destroy', $user->id) }}"
                                    method="POST" style="display:none;">
                                    @csrf
                                    @method('DELETE')
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <!-- Pagination Links -->
            <div class="d-flex justify-content-end mt-3">
                {{ $users->links() }} <!-- This generates pagination links -->
            </div>
        @else
            <p>No users found.</p>
        @endif

    </div>
</div>

@endsection

<script>
    function deleteUser(userId) {
        Swal.fire({
            text: "You won't be able to revert this!",
            showCancelButton: true,
            confirmButtonText: 'Delete',
            cancelButtonText: 'Cancel',
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
        }).then((result) => {
            if (result.isConfirmed) {
                // Submit the form if confirmed
                document.getElementById('delete-form-' + userId).submit();
            }
        });
    }
</script>