@extends('admin.default')

@section('Page-title', 'Payments')

@section('content')
<div class="container-fluid px-4">
    <div class="card bg-white px-4 py-3 mt-4 border-0 shadow-sm rounded">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>#</th>
                    <th>User</th>
                    <th>Amount</th>
                    <th>Renewal Type</th>
                    <th>Next Payment Date</th>
                    <th>Payment Date</th>

                </tr>
            </thead>
            <tbody>
                @foreach ($payments as $list)
                    <tr>
                        <td>
                            {{ $list->id }}
                        </td>
                        <td>
                            {{ $list->user->first_name }}
                            {{ $list->user->last_name }}
                        </td>
                        <td>
                            {{ $list->amount_paid }}
                        </td>
                        <td>
                            {{ $list->renewalType->renewal_type ?? 'Not Defined' }}
                        </td>
                        <td>
                            {{ \Carbon\Carbon::parse($list->renewalType->end_date)->format('d-F-Y') ?? 'Not Defined'}}
                        </td>
                        <td>
                            {{ $list->created_at->format('d-F-Y') }}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

@endsection