@extends('admin.default')

@section('content')
<div class="container-fluid px-4">
    <h3 class="mt-4">Applications</h3>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item active">Applications</li>
    </ol>


    <div class="card bg-white p-3">
        <div class="mb-4">
            <a href="{{ route('application.add') }}" class="btn btn-sm btn-success float-end">Add New Student</a>
        </div>
        <table class="table card-body table-striped">
            <thead>
                <tr>
                    <th scope="col">Admission Number</th>
                    <th scope="col">Name</th>
                    <th scope="col">Father Name</th>
                    <th scope="col">Date Of Birth</th>
                    <th scope="col">Gender</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <th scope="row">1</th>
                    <td>Mark</td>
                    <td>Otto</td>
                    <td>@mdo</td>
                    <td>@mdo</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

@endsection