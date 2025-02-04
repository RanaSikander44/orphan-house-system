@extends('admin.default')


@section('Page-title', 'Adoption List')

@section('content')
<div class="container-fluid px-4">
    <div class="card mt-4 shadow-sm border-0">
        <div class="card-body px-4">
            <div class="row">
                <!-- Nanny Filter -->
                <div class="col-md-4 mb-3">
                    <label for="search" class="fw-bold mb-2">Search Enquiries</label>
                    <input type="search" class="form-control" placeholder="Search Here ..." id="SearchForEnquiries">
                </div>
            </div>
        </div>
    </div>


    <div class="card bg-white px-4 py-3 mt-4 border-0 shadow-sm rounded">
        <h5 class="text-muted mb-3">Enquiry List</h5>
        <table class="table table-striped">
            <thead class="bg-light">
                <tr>
                    <th scope="col">Enquiry No</th>
                    <th scope="col">Name</th>
                    <th scope="col">Enquiry Date</th>
                    <th scope="col">Status</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody id="filtered-results">
                @forelse ($childrens as $list)
                    <tr>
                        <td>{{$list->enquiry_no}}</td>
                        <td>{{$list->first_name}} {{$list->last_name}}</td>
                        <td>{{ \Carbon\Carbon::parse($list->adoption_date)->format('d  M Y') }}</td>
                        <td>
                            <span class="badge {{ $list->is_approved == 2 ? 'text-danger' : 'text-warning'}}">
                                @if($list->is_approved == 0)
                                    Pending
                                @elseif($list->is_approved == 2)
                                    Disapproved
                                @else
                                    Unknown
                                @endif
                            </span>
                        </td>
                        <td>
                            <div class="dropdown">
                                <button class="btn btn-primary btn-sm dropdown-toggle" type="button"
                                    id="dropdownMenuButton{{ $list->id }}" data-bs-toggle="dropdown" aria-expanded="false">
                                    Action
                                </button>
                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton{{ $list->id }}">
                                    <li>
                                        <a class="dropdown-item" href="{{ route('enquiry.approve.child', $list->id) }}"
                                            title="Approve Enquiry">
                                            <i class="fa fa-check" style="color: green;"></i> Approve
                                        </a>
                                    </li>
                                    @if($list->is_approved == 0)
                                        <li>
                                            <a class="dropdown-item" href="{{ route('enquiry.disapprove', $list->id) }}"
                                                title="Disapprove Enquiry">
                                                <i class="fa fa-ban" style="color: red;"></i> Disapprove
                                            </a>
                                        </li>
                                    @endif
                                    <li>
                                        <a class="dropdown-item" href="{{ route('enquiry.view', $list->id) }}"
                                            title="View Enquiry">
                                            <i class="fa fa-eye"></i> View
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="{{ route('enquiry.edit', $list->id)  }}"
                                            title="Edit Enquiry">
                                            <i class="fa fa-edit"></i> Edit
                                        </a>
                                    </li>

                                    <li>
                                        <a class="dropdown-item" href="javascript:void(0);" title="Delete Enquiry"
                                            onclick="deleteChl({{ $list->id }})">
                                            <i class="fa fa-trash"></i> Delete
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td class="text-center" colspan="12">No childrens Found!</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        <div class="d-flex justify-content-between mt-3 align-items-center">
            <!-- Left side: Showing results -->
            <div class="small text-muted">
                Showing {{ $childrens->firstItem() }} to {{ $childrens->lastItem() }} of {{ $childrens->total() }}
                results
            </div>

            <!-- Right side: Pagination links -->
            <div>
                {{ $childrens->links('pagination::bootstrap-4') }}
            </div>
        </div>
    </div>

</div>

@endsection

<script>
    function deleteChl(id) {
        Swal.fire({
            text: "You won't be able to revert this!",
            showCancelButton: true,
            confirmButtonText: 'Delete',
            cancelButtonText: 'Cancel',
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
        }).then((result) => {
            if (result.isConfirmed) {
                // Redirect to delete route with the dynamic ID
                let deleteUrl = "{{ route('enquiry.delete', ':id') }}".replace(':id', id);
                window.location.href = deleteUrl;
            }
        });
    }
</script>




<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>


<script>

    let csrf = '{{ csrf_token() }}';
</script>

<script>
    $(document).ready(function () {
        $('#SearchForEnquiries').on('input', function () {
            let input = $(this).val();

            $.post({
                url: '{{ route('filter.childs') }}',
                data: {
                    _token: '{{ csrf_token() }}',
                    input: input
                },
                success: function (response) {
                    let tableBody = $('#filtered-results'); // Target table body
                    tableBody.empty(); // Clear previous results

                    if (response.message) {
                        // If there's a message, display it in the table
                        tableBody.append(`<tr><td colspan="6" class="text-center">${response.message}</td></tr>`);
                    } else {
                        // Otherwise, display the results
                        response.forEach(item => {
                            let formattedDate = new Date(item.created_at).toLocaleDateString();

                            // Determine approval status
                            let approvalText, badgeClass;
                            if (item.is_approved === 0) {
                                approvalText = "Pending";
                                badgeClass = "badge text-warning";
                            } else if (item.is_approved === 2) {
                                approvalText = "Disapproved";
                                badgeClass = "badge text-danger";
                            } else {
                                approvalText = "Unknown";
                                badgeClass = "badge badge-secondary";
                            }

                            // Conditionally add Disapprove button
                            let disapproveButton = "";
                            if (item.is_approved === 0) {
                                disapproveButton = `
                                    <li>
                                        <a class="dropdown-item" href="/enquiry/disapprove/${item.id}"
                                            title="Disapprove Enquiry">
                                            <i class="fa fa-ban" style="color: red;"></i> Disapprove
                                        </a>
                                    </li>`;
                            }

                            let row = `
                                <tr>
                                    <td>${item.enquiry_no}</td>
                                    <td>${item.first_name ?? ''} ${item.last_name ?? ''}</td>
                                    <td>${formattedDate}</td>
                                    <td>
                                        <span class="${badgeClass}">${approvalText}</span>
                                    </td>
                                    <td>
                                        <div class="dropdown">
                                            <button class="btn btn-primary btn-sm dropdown-toggle" type="button"
                                                data-bs-toggle="dropdown" aria-expanded="false">
                                                Action
                                            </button>
                                            <ul class="dropdown-menu">
                                                <li>
                                                    <a class="dropdown-item" href="/enquiry/child/approve/${item.id}"
                                                        title="Approve Child">
                                                        <i class="fa fa-check" style="color: green;"></i> Approve
                                                    </a>
                                                </li>
                                                ${disapproveButton}
                                                <li>
                                                    <a class="dropdown-item" href="/enquiry/child-view/${item.id}" title="View Enquiry">
                                                        <i class="fa fa-eye"></i> View
                                                    </a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item" href="/enquiry/child-edit/${item.id}" title="Edit Enquiry">
                                                        <i class="fa fa-edit"></i> Edit
                                                    </a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item" href="javascript:void(0);" title="Delete Enquiry" 
                                                        onclick="deleteChl(${item.id})">
                                                        <i class="fa fa-trash"></i> Delete
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>`;

                            tableBody.append(row); // Append row to the table
                        });
                    }
                }
            });
        });
    });
</script>


<script>
    // $('#select-child-nanny, #select-child-school').on('change', function () {
    // let nannyId = $('#select-child-nanny').val();
    // let schoolId = $('#select-child-school').val();

    // let data = {
    // _token: window.routes.csrfToken,
    // nanny_id: nannyId ? nannyId : 'null',
    // school_id: schoolId ? schoolId : 'null'
    // };

    // $.post({
    // url: window.routes.filterActivity,
    // data: data,
    // success: function (response) {
    // // Clear the existing table rows
    // $('#filtered-results').empty();

    // // Check if any data is returned
    // if (response.length > 0) {
    // // Iterate over each item in the response
    // response.forEach(function (item) {
    // let formattedDate = new Date(item.adoption_date).toLocaleDateString('en-GB', {
    // day: '2-digit',
    // month: 'short',
    // year: 'numeric'
    // });


    // let row = `
    // <tr>
    // <td>${item.enquiry_no}</td>
    // <td>${item.first_name} ${item.last_name}</td>
    // <td>${formattedDate}</td>
    // <td>
    // <div class="dropdown">
    // <button class="btn btn-primary btn-sm dropdown-toggle" type="button" // id="dropdownMenuButton${item.id}"
    data - bs - toggle="dropdown" aria - expanded="false" >
        // Action
        // </button>
        // <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton${item.id}">
        // <li>
        // <a class="dropdown-item" href="/enquiry/child-view/${item.id}" title="View Enquiry">
        // <i class="fa fa-eye"></i> View
        // </a>
        // </li>
        // <li>
        // <a class="dropdown-item" href="/enquiry/child-edit/${item.id}" title="Edit Enquiry">
        // <i class="fa fa-edit"></i> Edit
        // </a>
        // </li>
        // <li>
        // <a class="dropdown-item" href="javascript:void(0);" title="Delete Enquiry" //
        onclick="deleteChl(${item.id})" >
                        // <i class="fa fa-trash"></i> Delete
                        // </a>
                    // </li>
                // </ul>
            // </div>
        // </td>
    // </tr>

// `;
// // Append the new row to the table
// $('#filtered-results').append(row);
// });
// } else {
// // Display a message if no data is found
// $('#filtered-results').append(`
// <tr>
    // <td class="text-center" colspan="12">No children found!</td>
    // </tr>
// `);
// }
// },
// error: function (xhr, status, error) {
// console.error('Error:', error);
// alert('An error occurred while filtering data.');
// }
// });


// $('#clear-filters').click(function () {
// $('#select-child-nanny').val('').trigger('change');
// $('#select-child-school').val('').trigger('change');
// });

// });
});
</script>