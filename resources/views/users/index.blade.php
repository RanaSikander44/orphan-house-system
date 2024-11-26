@extends('admin.default')

@section('content')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<div class="container-fluid px-4">
    <h3 class="mt-4">Users</h3>

    <a href="{{ route('users.create') }}" class="btn btn-sm btn-primary float-end">Add New User</a>

    <div class="card bg-white p-3 mt-5 border-0 shadow-sm rounded">
        <h5 class="text-muted mb-3">User List</h5>

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
                            <span>{{ ucfirst($user->role) }}</span>
                        </td>
                        <td>
                            <!-- Edit Button -->
                            <a href="{{ route('users.edit', $user->id) }}" class="btn btn-sm btn-warning">Edit</a>
    
                            <!-- Delete Button -->
                            <button type="button" class="btn btn-sm btn-danger" onclick="deleteUser({{ $user->id }})">Delete</button>

                            <!-- Form for Deleting User -->
                            <form id="delete-form-{{ $user->id }}" action="{{ route('users.destroy', $user->id) }}" method="POST" style="display:none;">
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
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'No, cancel!',
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

