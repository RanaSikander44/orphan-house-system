@extends('admin.default')

@section('Page-title', 'Permissions')

@section('content')
<div class="container-fluid px-4">

    <!-- Permissions List -->
    <div class="card bg-white px-4 py-3 mt-4 border-0 shadow-sm rounded">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h5 class="text-muted">Permission List</h5>
            <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#addPermissionModal">
                Add New Permission
            </button>
        </div>

        <table class="table table-striped">
            <thead class="bg-light">
                <tr>
                    <th scope="col">Permission</th>
                    <th scope="col">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($permissions as $permission)
                    <tr>
                        <td>{{ $permission->name }}</td>
                        <td>
                            <!-- Edit Button -->
                            <button class="btn btn-sm btn-primary" data-bs-toggle="modal"
                                data-bs-target="#editPermissionModal"
                                onclick="openEditModal({{ $permission->id }}, '{{ $permission->name }}')">Edit</button>
                            <!-- Delete Button -->
                            <button class="btn btn-sm btn-danger" onclick="openDeleteModal({{ $permission->id }})">
                                Delete
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="2" class="text-center">No Permissions Found</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <!-- Pagination -->
        <div class="d-flex justify-content-between mt-3 align-items-center">
            <div>
                <span>Showing {{ $permissions->firstItem() ?? 0 }} to {{ $permissions->lastItem() ?? 0 }} of
                    {{ $permissions->total() }}
                    entries</span>
            </div>
            <div>
                {{ $permissions->links() }}
            </div>
        </div>
    </div>

    <!-- Add Permission Modal -->
    <div class="modal fade" id="addPermissionModal" tabindex="-1" aria-labelledby="addPermissionModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addPermissionModalLabel">Add New Permission</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="addPermissionForm" action="{{ route('permissions.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="permission" class="form-label">Permission Name</label>
                            <input type="text" id="permission" name="name" class="form-control" required
                                placeholder="Enter Permission name">
                        </div>
                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-primary">Add</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Permission Modal -->
    <div class="modal fade" id="editPermissionModal" tabindex="-1" aria-labelledby="editPermissionModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editPermissionModalLabel">Edit Permission</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editPermissionForm" method="post">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label for="editPermission" class="form-label">Permission Name</label>
                            <input type="text" id="editPermission" name="name" class="form-control" required
                                placeholder="Enter Permission name">
                        </div>
                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-primary">Save Changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div class="modal fade" id="deletePermissionModal" tabindex="-1" aria-labelledby="deletePermissionModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deletePermissionModalLabel">Confirm Deletion</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Are you sure you want to delete this permission?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <form id="deletePermissionForm" method="post" style="display: inline;">
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
        function openEditModal(permissionId, permissionName) {
            document.getElementById('editPermissionForm').action = "{{ url('permissions') }}/" + permissionId;
            document.getElementById('editPermission').value = permissionName;
        }

        function openDeleteModal(permissionId) {
            // Set the form action to the delete URL for the permission
            var formAction = "{{ url('permissions') }}/" + permissionId;
            document.getElementById('deletePermissionForm').action = formAction;

            // Show the modal using Bootstrap's modal method
            $('#deletePermissionModal').modal('show');
        }
    </script>
</div>
@endsection