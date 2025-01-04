@extends('admin.default')

@section('Page-title', 'Donations Request')

@section('content')


<div class="container-fluid px-4">

    <div class="card bg-white px-4 py-3 mt-4 border-0 shadow-sm rounded">
        <div class="card-body position-relative">

            <!-- Tabs Navigation -->
            <ul class="nav nav-tabs justify-content-around" id="requestTabs" role="tablist"
                style="border-bottom: 2px solid #dee2e6;">
                <li class="nav-item flex-grow-1 text-center" role="presentation">
                    <button class="nav-link active w-100" id="pending-tab" data-bs-toggle="tab"
                        data-bs-target="#pending" type="button" role="tab" aria-controls="pending" aria-selected="true">
                        Pending Requests
                    </button>
                </li>
                <li class="nav-item flex-grow-1 text-center" role="presentation">
                    <button class="nav-link w-100" id="accepted-tab" data-bs-toggle="tab" data-bs-target="#accepted"
                        type="button" role="tab" aria-controls="accepted" aria-selected="false">
                        Accepted Requests
                    </button>
                </li>
            </ul>

            <!-- Tabs Content -->
            <div class="tab-content mt-4" id="requestTabsContent">
                <!-- Pending Requests Tab -->
                <div class="tab-pane fade show active" id="pending" role="tabpanel" aria-labelledby="pending-tab">
                    <table class="table table-striped mt-3">
                        <thead>
                            <tr>
                                <th>Donor</th>
                                <th>Child</th>
                                <th>Request Date</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($pendingrequests as $list)
                                <tr>
                                    <td>{{ $list->donor->first_name }} {{ $list->donor->last_name }}</td>
                                    <td>{{ $list->child->first_name }} {{ $list->child->last_name }}</td>
                                    <td>{{ $list->created_at->format('d-F-Y') }}</td>
                                    <td>
                                        <span class="badge {{ $list->req_status == 1 ? 'bg-success' : 'bg-warning' }}">
                                            {{ $list->req_status == 1 ? 'Accepted' : 'Pending' }}
                                        </span>
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.donations.req.view', $list->id) }}"
                                            class="btn btn-sm btn-success">View Details</a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td class="text-center" colspan="6">No requests Found!</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Accepted Requests Tab -->
                <div class="tab-pane fade" id="accepted" role="tabpanel" aria-labelledby="accepted-tab">
                    <table class="table table-striped mt-3">
                        <thead>
                            <tr>
                                <th>Donor</th>
                                <th>Child</th>
                                <th>Request Date</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($acceptedrequests as $list)
                                <tr>
                                    <td>{{ $list->donor->first_name }} {{ $list->donor->last_name }}</td>
                                    <td>{{ $list->child->first_name }} {{ $list->child->last_name }}</td>
                                    <td>{{ $list->created_at->format('d-F-Y') }}</td>
                                    <td>
                                        <span class="badge {{ $list->req_status == 1 ? 'bg-success' : 'bg-warning' }}">
                                            {{ $list->req_status == 1 ? 'Accepted' : 'Pending' }}
                                        </span>
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.donations.req.view', $list->id) }}"
                                            class="btn btn-sm btn-success">View Details</a>
                                    </td>
                                </tr>
                            @empty
                                <td class="text-center" colspan="6">No requests Found!</td>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>

</div>





@endsection