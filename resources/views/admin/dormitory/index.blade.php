@extends('admin.default')
@section('Page-title', 'Dormitory Rooms')
@section('content')
<div class="container-fluid px-4">
    <div class="card bg-white px-4 py-3 mt-4 border-0 shadow-sm rounded">
        <table class="table table-striped ">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Title</th>
                    <th>Max Number of bed</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @php 
                     $index = 1;
                @endphp
                @foreach ($dormitory as $list)                
                    <tr>
                        <td>{{ $index++ }}</td>
                        <td>{{ $list->title }}</td>
                        <td>{{ $list->max_number_bed }}</td>
                        <td>
                            <div class="dropdown">
                                <button class="btn btn-primary btn-sm dropdown-toggle" type="button"
                                    id="dropdownMenuButton{{ $list->id }}" data-bs-toggle="dropdown" aria-expanded="false">
                                    Action
                                </button>
                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton{{ $list->id }}">
                                    <li>
                                        <a class="dropdown-item" href="{{ route('room.edit', $list->id)  }}"
                                            title="Edit Room">
                                            <i class="fa fa-edit"></i> Edit
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="javascript:void(0);" title="Delete Room"
                                            onclick="deleteRoom({{ $list->id }})">
                                            <i class="fa fa-trash"></i> Delete
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
<script>
    let deleteRoom = (id) => {
        Swal.fire({
            text: "You won't be able to revert this!",
            showCancelButton: true,
            confirmButtonText: 'Delete',
            cancelButtonText: 'Cancel',
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = "{{ route('room.delete', ':id') }}".replace(':id', id);
            }
        });
    }
</script>
@endsection