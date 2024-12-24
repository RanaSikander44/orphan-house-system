@extends('admin.default')

@section('Page-title', 'Child Activity Management')

@section('content')
<div class="container-fluid px-4">
    <!-- <div class="card mt-4 border-0 shadow-sm rounded"> -->
    <div class="card bg-white px-4 py-3 mt-4 border-0 shadow-sm rounded">
        <table class="table table-striped ">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Description</th>
                    <th>Activity Date</th>
                    <th>Created By</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($activity as $list)                
                    <tr>
                        <td>{{ $list->id }}</td>
                        <td>{{ $list->name }}</td>
                        <td>{{ $list->desc}}</td>
                        <td>{{ $list->activity_date}}</td>
                        <td>{{ $list->creator->role->name }}</td>
                        <td>
                            <div class="dropdown">
                                <button class="btn btn-primary btn-sm dropdown-toggle" type="button"
                                    id="dropdownMenuButton{{ $list->id }}" data-bs-toggle="dropdown" aria-expanded="false">
                                    Action
                                </button>
                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton{{ $list->id }}">
                                    <li>
                                        <a class="dropdown-item" href="{{ route('activity.view', $list->id)  }}"
                                            title="Edit Enquiry">
                                            <i class="fa fa-eye"></i> View
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="{{ route('activity.edit', $list->id)  }}"
                                            title="Edit Enquiry">
                                            <i class="fa fa-edit"></i> Edit
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="{{ route('activity.delete', $list->id) }}"
                                            title="Delete Activity">
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


@endsection