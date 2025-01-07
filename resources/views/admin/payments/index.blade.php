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
                    <th>Date</th>
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
                            {{ $list->amount }}
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