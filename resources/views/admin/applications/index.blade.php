@extends('admin.default')

@section('content')
<div class="container-fluid px-4">
    <h3 class="mt-4">Applications</h3>

    <div class="card bg-white p-3 mt-5 border-0 shadow-sm rounded">
        <table class="table table-striped">
            <thead class="bg-light">
                <tr>
                    <th scope="col">Admission No</th>
                    <th scope="col">Name</th>
                    <th scope="col">Father Name</th>
                    <th scope="col">Date Of Birth</th>
                    <th scope="col">Gender</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Hello</td>
                    <td>
                        <div class="dropdown show">
                            <a class="btn btn-primary btn-sm dropdown-toggle" href="#" role="button"
                                id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Action
                            </a>

                            <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                <a class="dropdown-item" href="{{ route('academic-year') }}">Edit</a>
                                <a class="dropdown-item" href="{{ route('academic-year') }}">Delete</a>
                            </div>
                        </div>

                    </td>
                </tr>

            </tbody>
        </table>

        <div class="d-flex justify-content-between mt-3 align-items-center">
            <!-- Left side: Showing results -->
            <div class="small text-muted">
                Showing to of results
            </div>

            <!-- Right side: Pagination links -->
            <div>

            </div>
        </div>
    </div>


</div>

@endsection