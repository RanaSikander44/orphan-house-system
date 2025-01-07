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
                    <button class="nav-link active w-100" id="accepted-tab" data-bs-toggle="tab"
                        data-bs-target="#accepted" type="button" role="tab" aria-controls="accepted"
                        aria-selected="false">
                        Accepted Requests
                    </button>
                </li>
                <li class="nav-item flex-grow-1 text-center" role="presentation">
                    <button class="nav-link w-100" id="pending-tab" data-bs-toggle="tab" data-bs-target="#pending"
                        type="button" role="tab" aria-controls="pending" aria-selected="true">
                        Pending Requests
                    </button>
                </li>
            </ul>

            <div class="tab-content mt-4" id="requestTabsContent">
                <!-- Pending -->
                <div class="tab-pane fade" id="pending" role="tabpanel" aria-labelledby="pending-tab">
                    <table class="table table-striped mt-3">
                        <thead>
                            <tr>
                                <th>Child</th>
                                <th>Requested Date</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($pendingReq as $list)
                                <tr>
                                    <td>
                                        {{ $list->child->first_name }}
                                        {{ $list->child->last_name }}
                                    </td>
                                    <td>
                                        {{ $list->created_at->format('d-F-Y') }}
                                    </td>
                                    <td>
                                        <span class="badge {{ $list->req_status == 1 ? 'bg-success' : 'bg-warning' }}">
                                            {{ $list->req_status == 1 ? 'Accepted' : 'Pending' }}
                                        </span>
                                    </td>
                                    <td>
                                        <p class="text-muted">
                                            Once your donation request is accepted, you will be able to proceed with the
                                            payment.
                                        </p>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center">No pending requests found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>

                    <!-- Pagination for Pending Requests -->
                    <div class="d-flex justify-content-center">
                        {{ $pendingReq->links() }}
                    </div>
                </div>

                <!-- Accepted -->
                <div class="tab-pane fade show active" id="accepted" role="tabpanel" aria-labelledby="accepted-tab">
                    <table class="table table-striped mt-3">
                        <thead>
                            <tr>
                                <th>Child</th>
                                <th>Requested Date</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($child as $list)
                                <tr>
                                    <td>
                                        {{ $list->first_name }}
                                    </td>
                                    <td>
                                        {{ $list->created_at->format('d-F-Y') }}
                                    </td>
                                    <td>
                                        <span class="badge bg-success">
                                            Accepted
                                        </span>
                                    </td>
                                    <td>
                                        @if($list->donorReq->payment_id != null)
                                            <button class="btn btn-sm bg-info" disabled>Paid</button>
                                        @else
                                            <a href="{{ route('donor.payment.req', $list->id) }}"
                                                class="btn btn-sm btn-info text-white">Make Payment</a>
                                        @endif

                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center">No accepted requests found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>

                    <!-- Pagination for Accepted Requests -->
                    <div class="d-flex justify-content-center">
                        {{ $child->links() }}
                    </div>
                </div>
            </div>

        </div>
    </div>

</div>

@endsection