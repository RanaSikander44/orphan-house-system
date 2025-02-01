@extends('admin.default')


@section('Page-title', 'Adoption List')

@section('content')
<div class="container-fluid px-4">
    <div class="card mt-4 shadow-sm border-0">
        <div class="card-body px-4">
            <div class="row">
                <!-- Nanny Filter -->
                <div class="col-md-4 mb-3">
                    <label for="select-nanny" class="fw-bold mb-3">Filter by Nanny</label>
                    <select name="nanny" id="select-child-nanny" class="form-control select2">
                        <option value=""> -- Select Nanny -- </option>
                        @foreach ($nannies as $list)
                            <option value="{{ $list->id }}">{{ $list->first_name }} {{ $list->last_name }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- School Filter -->
                <div class="col-md-4 mb-3">
                    <label for="select-child-school" class="fw-bold mb-3">Filter by School</label>
                    <select name="school" id="select-child-school" class="form-control select2">
                        <option value="">-- Select School --</option>
                        @foreach ($schools as $list)
                            <option value="{{ $list->id }}">{{ $list->name }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Clear Filters -->
                <div class="col-md-4 mb-3 d-flex align-items-end">
                    <button id="clear-filters" class="btn btn-sm btn-primary">
                        Clear All
                    </button>
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
                    <th scope="col">Status Of Adoption</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody id="filtered-results">
                @forelse ($childrens as $list)
                    <tr>
                        <td>{{$list->enquiry_no}}</td>
                        <td>{{$list->first_name}} {{$list->last_name}}</td>
                        <td>{{ \Carbon\Carbon::parse($list->adoption_date)->format('d  M Y') }}</td>
                        <td>{{ $list->status_of_adoption}}</td>
                        <td>
                            <div class="dropdown">
                                <button class="btn btn-primary btn-sm dropdown-toggle" type="button"
                                    id="dropdownMenuButton{{ $list->id }}" data-bs-toggle="dropdown" aria-expanded="false">
                                    Action
                                </button>
                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton{{ $list->id }}">
                                    <li>
                                        <a class="dropdown-item" href="{{ route('enquiry.approve.child', $list->id) }}"
                                            title="Approve Child">
                                            <i class="fa fa-check" style="color: green;"></i> Approve
                                        </a>
                                    </li>
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
    window.routes = {
        filterActivity: '{{ route('filter.childs') }}',
        csrfToken: '{{ csrf_token() }}'
    };
</script>



<script>
    $(document).ready(function () {
        $('#select-child-nanny, #select-child-school').on('change', function () {
            let nannyId = $('#select-child-nanny').val();
            let schoolId = $('#select-child-school').val();

            let data = {
                _token: window.routes.csrfToken,
                nanny_id: nannyId ? nannyId : 'null',
                school_id: schoolId ? schoolId : 'null'
            };

            $.post({
                url: window.routes.filterActivity,
                data: data,
                success: function (response) {
                    // Clear the existing table rows
                    $('#filtered-results').empty();

                    // Check if any data is returned
                    if (response.length > 0) {
                        // Iterate over each item in the response
                        response.forEach(function (item) {
                            let formattedDate = new Date(item.adoption_date).toLocaleDateString('en-GB', {
                                day: '2-digit',
                                month: 'short',
                                year: 'numeric'
                            });


                            let row = `
                                <tr>
                                    <td>${item.enquiry_no}</td>
                                    <td>${item.first_name} ${item.last_name}</td>
                                    <td>${formattedDate}</td>
                                    <td>${item.status_of_adoption}</td>
                                    <td>
                                        <div class="dropdown">
                                            <button class="btn btn-primary btn-sm dropdown-toggle" type="button"
                                                id="dropdownMenuButton${item.id}" data-bs-toggle="dropdown" aria-expanded="false">
                                                Action
                                            </button>
                                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton${item.id}">
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
                                </tr>

                            `;
                            // Append the new row to the table
                            $('#filtered-results').append(row);
                        });
                    } else {
                        // Display a message if no data is found
                        $('#filtered-results').append(`
                            <tr>
                                <td class="text-center" colspan="12">No children found!</td>
                            </tr>
                        `);
                    }
                },
                error: function (xhr, status, error) {
                    console.error('Error:', error);
                    alert('An error occurred while filtering data.');
                }
            });


            $('#clear-filters').click(function () {
                $('#select-child-nanny').val('').trigger('change');
                $('#select-child-school').val('').trigger('change');
            });

        });
    });
</script>