@extends('admin.default')

@section('Page-title', 'Donation Request Detail')

@section('content')
<div class="container-fluid px-4 mt-4">
    <div class="card bg-white px-4 py-3 mt-4 border-0 shadow-sm rounded">
        <div class="card-body">
            <table class="table table-striped table-bordered">
                <tbody>
                    <tr>
                        <th>Child First Name</th>
                        <td>{{ $details->child->first_name }}</td>
                    </tr>
                    <tr>
                        <th>Child Last Name</th>
                        <td>{{ $details->child->last_name }}</td>
                    </tr>
                    <tr>
                        <th>Donor First Name</th>
                        <td>{{ $details->donor->first_name }}</td>
                    </tr>
                    <tr>
                        <th>Donor Last Name</th>
                        <td>{{ $details->donor->last_name }}</td>
                    </tr>
                    <tr>
                        <th>Status</th>
                        <td>
                            <span class="badge {{ $details->req_status == 1 ? 'bg-success' : 'bg-warning text-dark' }}">
                                {{ $details->req_status == 1 ? 'Accepted' : 'Pending' }}
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <th>Request Date</th>
                        <td>{{ $details->created_at->format('d-F-Y') }}</td>
                    </tr>
                    <tr>
                        <th>Accept</th>
                        <th>
                            <a href="{{ $details->req_status == 1 ? '#' : route('admin.adopt.req.accept', $details->id) }}"
                                class="btn btn-sm btn-success" {{ $details->req_status == 1 ? 'disabled' : '' }}
                                style="{{ $details->req_status == 1 ? 'pointer-events: none; opacity: 0.65;' : '' }}">
                                {{ $details->req_status == 1 ? 'Accepted' : 'Accept' }}
                            </a>

                            @if($details->req_status != 1)
                                <a href="{{ route('admin.adopt.req.reject', $details->id)}}"
                                    class="btn btn-sm btn-danger">Reject</a>
                            @endif
                        </th>

                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection