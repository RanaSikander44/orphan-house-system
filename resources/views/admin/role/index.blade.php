@extends('admin.default')

@section('Page-title', 'Roles')

@section('content')
<div class="container-fluid px-4">
    <div class="card bg-white px-4 py-3 mt-4 border-0 shadow-sm rounded">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h5 class="text-muted">Role List</h5>
            <a href="{{ route('roles.create') }}" class="btn btn-sm btn-primary">
                Add New Role
            </a>
        </div>


        <table class="table table-striped">
            <thead class="bg-light">
                <tr>
                    <th scope="col">Role</th>
                    <th scope="col">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($roles as $role)
                    <tr>
                        <td>{{ $role->name }}</td>
                        <td>
                            <!-- Edit Button -->
                            <a href="{{ route('roles.edit' , $role->id) }}" class="btn btn-sm btn-primary">Edit</a>
                            <!-- Delete Button -->
                            <button class="btn btn-sm btn-danger" onclick="openDeleteModal({{ $role->id }})">
                                Delete
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="2" class="text-center">No Roles Found</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <!-- Pagination -->
        <div class="d-flex justify-content-between mt-3 align-items-center">
            <div>
                <span>Showing {{ $roles->firstItem() ?? 0 }} to {{ $roles->lastItem() ?? 0 }} of {{ $roles->total() }}
                    entries</span>
            </div>
            <div>
                {{ $roles->links() }}
            </div>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div class="modal fade" id="deleteRoleModal" tabindex="-1" aria-labelledby="deleteRoleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteRoleModalLabel">Confirm Deletion</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Are you sure you want to delete this role?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <form id="deleteRoleForm" method="POST" action="" style="display: inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- JavaScript to Handle Modals -->
    <script>
        function openEditModal(roleId, role) {
            document.getElementById('editRoleForm').action = "{{ url('roles') }}/" + roleId;
            document.getElementById('editRole').value = role;
        }

        function openDeleteModal(roleId) {
            // Set the form action to the delete URL for the role
            var formAction = "{{ url('roles') }}/" + roleId;
            document.getElementById('deleteRoleForm').action = formAction;

            // Show the modal using Bootstrap's modal method
            $('#deleteRoleModal').modal('show');
        }
    </script>
</div>
@endsection