@extends('admin.default')

@section('Page-title', 'Dashboard')

@section('content')
<div class="container-fluid px-4">

    <div class="card bg-white px-4 py-3 mt-4 border-0 shadow-sm rounded">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <!-- Left side: Childs List heading -->
            <h5 class="text-muted mb-0">Childs List</h5>

            <!-- Right side: Request button -->
            <button class="btn btn-sm btn-primary d-flex align-items-center" id="adoptionReqBtn">
                <i class="fas fa-handshake me-2"></i> Request for Adoption
            </button>
        </div>

        <table class="table table-striped">
            <thead class="bg-light">
                <tr>
                    <th></th>
                    <th scope="col">Enquiry No</th>
                    <th scope="col">Name</th>
                    <th scope="col">Age</th>
                    <th scope="col">Date Of Birth</th>
                    <th scope="col">Adoption Date</th>
                    <th scope="col">Status Of Adoption</th>
                    <th scope="col">School Fees</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($childrens as $list)
                    <tr>
                        <td><input type="checkbox" value="{{ $list->id }}" class="checkbox" id="checkbox_{{ $list->id }}">
                        </td>
                        <td>{{$list->enquiry_no}}</td>
                        <td>{{$list->first_name}} {{$list->last_name }}</td>
                        <td>{{ \Carbon\Carbon::parse($list->dob)->age . ' years' }}</td>
                        <td>{{$list->dob}}</td>
                        <td>{{ $list->adoption_date }}</td>
                        <td>{{$list->status_of_adoption}}</td>
                        <td>{{$list->school->fees}}</td>
                        <td>
                            <a class="btn btn-sm btn-primary" href="{{ route('donor.enquiry.view', $list->id) }}"
                                title="View Enquiry">Details
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td class="text-center" colspan="12">No children Found!</td>
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



<script>
    $(document).ready(function () {
        $('#adoptionReqBtn').click(function () {
            var selectedValues = [];
            $('.checkbox:checked').each(function () {
                selectedValues.push($(this).val());
            });

            var selectedCount = selectedValues.length;
            if (selectedCount > 0) {
                $.post({
                    url: '{{ route('donor.adopt.request') }}',
                    data: {
                        '_token': '{{ csrf_token() }}',
                        selectedValues: selectedValues
                    },
                    success: function (response) {
                        // Assuming the response contains a message property with the success message
                        Swal.fire({
                            icon: 'success', // Type of alert: success, error, warning, info, question
                            title: 'Success!',
                            text: response.message, // Display the message from the response
                            confirmButtonText: 'OK'
                        });
                    }

                });
            } else {
                alert('Please select at least one checkbox');
            }
        });
    });
</script>



<!-- <script>
    $(document).ready(function () {
        $('#adoptionReqBtn').click(function () {
            var selectedValues = [];
            $('.checkbox:checked').each(function () {
                selectedValues.push($(this).val());
            });

            var selectedCount = selectedValues.length;
            if (selectedCount > 0) {
                $.post({
                    url: '{{ route('donor.adopt.request') }}',
                    data: {
                        '_token': '{{ csrf_token() }}',
                        selectedValues: selectedValues
                    },
                    success: function (response) {
                        const totalPayment = response.total_fees;
                        Swal.fire({
                            title: 'Total Payment',
                            text: `The total payment amount is: ${totalPayment} AED. Enter your credit card details to proceed.`,
                            icon: 'info',
                            input: 'text',
                            inputAttributes: {
                                placeholder: 'Enter Credit Card Number',
                                maxlength: 16
                            },
                            showCancelButton: true,
                            confirmButtonColor: '#3085d6',
                            cancelButtonColor: '#d33',
                            confirmButtonText: 'Pay Now',
                            cancelButtonText: 'Cancel',
                            reverseButtons: true,
                            preConfirm: (creditCardNumber) => {
                                if (!creditCardNumber || creditCardNumber.length !== 16) {
                                    Swal.showValidationMessage('Please enter a valid credit card number');
                                }
                                return creditCardNumber;
                            }
                        }).then((result) => {
                            if (result.isConfirmed) {
                                $.post({
                                    url: '{{ route('donor.payment.process') }}',
                                    data: {
                                        '_token': '{{ csrf_token() }}',
                                        selectedValues: selectedValues,
                                        totalPayment: totalPayment,
                                        creditCardNumber: result.value
                                    },
                                    success: function () {
                                        Swal.fire({
                                            icon: 'success',
                                            title: 'Payment Successful',
                                            text: 'Your adoption request has been submitted.',
                                            showConfirmButton: false,
                                            timer: 1500
                                        });
                                    }
                                });
                            }
                        });
                    }
                });
            } else {
                alert('Please select at least one checkbox');
            }
        });
    });
</script> -->
@endsection