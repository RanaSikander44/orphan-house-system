@extends('admin.default')

@section('Page-title', 'Settings')

@section('content')

<div class="container-fluid px-4 mt-4">
    <form method="post" action="{{ route('settings.store') }}">
        @csrf
        <div class="card border-0 shadow-sm">
            <div class="card-body p-5">
                <div class="row">
                    <div class="col-3 p-0">
                        <div class="p-3" style="background-color: #f8f9fa;">
                            <button type="button" class="btn btn-sm btn-block mb-2 active" id="tab1">Child
                                Settings</button>
                            <button type="button" class="btn btn-sm btn-block mb-2" id="docs">Child
                                Documents</button>
                            <button type="button" class="btn btn-sm btn-block mb-2" id="enquiryForms">Induction
                                Workflow</button>
                            <button type="button" class="btn btn-sm btn-block mb-2" id="staff_docs">Staff
                                Documents</button>
                            <button type="button" class="btn btn-sm btn-block mb-2" id="donor_setting">Donor
                                Settings</button>
                        </div>
                    </div>
                    <div class="col-8 ms-5">
                        <!-- Child Age Tab Content -->
                        <div class="tab1">
                            <div>
                                <label for="charges_of_a_child" class="mb-2">Child Sponsor Cost</label>
                                <input type="number" min="0" class="form-control" name="charges_of_a_child"
                                    value="{{ $settings->charges_of_a_child }}">
                            </div>
                            <div class="d-flex mb-4 mt-4">
                                <div class="flex-fill pe-2">
                                    <label for="min_age_of_student" class="mb-2">Min Age Of Child</label>
                                    <input type="text" class="form-control" name="min_age_of_child"
                                        value="{{ $settings->min_age_of_child ?? '' }}">
                                </div>
                                <div class="flex-fill ps-2">
                                    <label for="max_age_of_student" class="mb-2">Max Age Of Child</label>
                                    <input type="text" class="form-control" name="max_age_of_child"
                                        value="{{ $settings->max_age_of_child ?? '' }}">
                                </div>
                            </div>
                        </div>

                        <!-- Documents For Child -->
                        <div class="tab-documents" style="display:none;">
                            <div class="d-flex align-items-center justify-content-between mb-3">
                                <h6 class="mb-0 text-muted">Required Documents Title</h6>
                                <button type="button" class="btn btn-sm btn-success add-document" title="Add Document">
                                    <i class="fas fa-plus"></i>
                                </button>
                            </div>
                            <div class="documents">
                                @if ($child_documents->isNotEmpty())
                                    @foreach ($child_documents as $key => $document)
                                        <div class="document-group mb-3 d-flex">
                                            <div class="input-group">
                                                <input type="text" class="form-control" id="{{ $document->id }}"
                                                    name="child_documents_title[{{ $document->id }}]"
                                                    value="{{ $document->title }}" placeholder="Enter document title">
                                                @if ($key > 0)
                                                    <button type="button" class="btn btn-danger btn-sm" title="Remove"
                                                        onclick="deletedoc({{ $document->id }})">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                @endif
                                            </div>
                                            <div class="form-check ms-2">
                                                    <input type="checkbox" class="form-check-input" id="required_{{ $document->id }}"
                                                        name="child_documents_required[{{ $document->id }}]"
                                                        {{ $document->required === 1 ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="required_{{ $document->id }}">Required</label>
                                            </div>
                                        </div>
                                    @endforeach
                                @else
                                    <div class="document-group mb-3">
                                        <div class="input-group">
                                            <input type="text" class="form-control" name="child_documents_title[]"
                                                placeholder="Enter document title">
                                            <div class="form-check ms-2">
                                                <input type="checkbox" class="form-check-input"
                                                    name="child_documents_required[]">
                                                <label class="form-check-label">Required</label>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>


                        <!-- Documents For Child End -->

                        <!-- Staff Documents Start -->

                        <div class="staff-tab-documents" style="display:none;">
                            <div class="d-flex align-items-center justify-content-between mb-3">
                                <h6 class="mb-0 text-muted">Staff Documents Title</h6>
                                <button type="button" class="btn btn-sm btn-success staff-add-document"
                                    title="Add Document">
                                    <i class="fas fa-plus"></i>
                                </button>
                            </div>
                            <div class="staff-documents">
                                @if ($staff_documents->isNotEmpty())
                                    @foreach ($staff_documents as $key => $document)
                                        <div class="document-group mb-3">
                                            <div class="input-group">
                                                <input type="text" class="form-control" id="{{ $document->id }}"
                                                    name="staff_document_title[{{ $document->id }}]"
                                                    value="{{ $document->title }}" placeholder="Enter document title">
                                                @if ($key > 0)
                                                    <button type="button" class="btn btn-danger btn-sm staff-remove-document"
                                                        title="Remove" onclick="deletestaffdoc({{ $document->id }})">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                @endif
                                            </div>
                                        </div>
                                    @endforeach
                                @else
                                    <div class="document-group mb-3">
                                        <div class="input-group">
                                            <input type="text" class="form-control" name="staff_document_title[]"
                                                placeholder="Enter document title">
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>


                        <div class="donor-tab-settings" style="display:none;">
                            <h6 class="mb-0 text-muted">Reminder Days for Payment Completion</h6>
                            <div class="donor-settings">
                                <input type="number" class="form-control mt-2" name="min_dayes_for_req_donors"
                                    value="{{ $donorSetting->min_dayes_for_req_donors ?? '' }}">
                                <p class="text-muted mt-3">
                                    This field allows to set the number of days after which a reminder notification
                                    will be sent to donors who have requested for donate but have not completed their
                                    payments. </p>
                                </p>
                            </div>
                        </div>


                        <div class="enquiryForms-tab-settings" style="display:none;">

                            <div class="donor-settings">

                                <a href="{{ route('enquiry.forms.create') }}"
                                    class="btn btn-sm btn-success float-end"><i class="fa-solid fa-plus"></i></a>

                                <table class="table table-striped">

                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        @foreach ($forms as $list)
                                            <tr class="FormData_{{ $list->id }}">
                                                <td>{{ $list->name }}</td>
                                                <td>
                                                    <!-- Active Button -->
                                                    <button
                                                        class="btn btn-sm text-white {{ $list->status === 1 ? '' : 'd-none' }} {{ $list->status === 1 ? 'bg-success ' : '' }}"
                                                        id="FormActive{{ $list->id }}" type="button"
                                                        onclick="FormStatusActive({{ $list->id }})">
                                                        <i class="fa fa-check"></i>
                                                    </button>

                                                    <!-- Inactive Button -->
                                                    <button
                                                        class="btn btn-sm text-white  {{ $list->status === 0 ? '' : 'd-none' }} {{ $list->status === 0 ? 'bg-danger' : '' }}"
                                                        id="FormInactive{{ $list->id }}" type="button"
                                                        onclick="FormStatusInactive({{ $list->id }})">

                                                        <i class="fas fa-times-circle"></i>
                                                    </button>

                                                </td>
                                                <td>
                                                    <a href="{{ route('enquiry.forms.edit', $list->id) }}"
                                                        class="btn btn-sm">
                                                        <i class="fa-solid fa-pencil"></i>
                                                    </a>

                                                    <button type="button" onclick="DelForms({{ $list->id }})"
                                                        class="btn btn-sm">
                                                        <i class="fa-solid fa-trash"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                        @endforeach

                                    </tbody>

                                </table>

                                <div class="d-flex justify-content-between mt-3 align-items-center">
                                    <!-- Left side: Showing results -->
                                    <div class="small text-muted">
                                        Showing {{ $forms->firstItem() }} to {{ $forms->lastItem() }} of
                                        {{ $forms->total() }}
                                        results
                                    </div>

                                    <!-- Right side: Pagination links -->
                                    <div id="pagination-links">
                                        {{ $forms->links('pagination::bootstrap-4') }}
                                    </div>
                                </div>

                            </div>
                        </div>

                        <!-- Staff Document end -->
                    </div>
                </div>
            </div>
            <div class="card-footer border-0 bg-white">
                <button type="submit" class="btn btn-sm btn-info float-end text-white">Save</button>
            </div>
        </div>
    </form>
</div>



@endsection





<style>
    .tab-documents {
        padding: 20px;
    }

    .tab-documents h4 {
        font-size: 1.25rem;
        font-weight: bold;
        color: #333;
    }

    .input-group {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .input-group .form-control {
        border-radius: 6px;
        box-shadow: none;
        border: 1px solid #ccc;
    }

    .input-group button {
        padding: 6px 12px;
        border-radius: 50%;
        border: none;
        background-color: #dc3545;
        color: #fff;
        cursor: pointer;
        font-size: 1rem;
    }

    .input-group button:hover {
        background-color: #c82333;
        color: #fff;
    }

    .btn-success {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 6px 12px;
        border-radius: 6px;
        font-size: 0.9rem;
        box-shadow: none;
    }

    .btn-success i {
        font-size: 1.25rem;
        vertical-align: middle;
    }

    .btn-success:hover {
        background-color: #28a745;
        color: #fff;
    }
</style>

<script>
    let csrf = "{{ csrf_token() }}"; 
</script>

<script src="https://code.jquery.com/jquery-3.7.1.slim.js"
    integrity="sha256-UgvvN8vBkgO0luPSUl2s8TIlOSYRoGFAX4jlCIm9Adc=" crossorigin="anonymous"></script>

<script>
    const FormStatusActive = (id) => {
        let formID = id;
        let task = 'Inactive';
        let csrfToken = '{{ csrf_token() }}'; // Get CSRF token from Blade template

        $.ajax({
            url: `{{ route('enquiry.forms.status', ':id') }}`.replace(':id', formID),
            type: 'POST',
            data: {
                _token: csrfToken, // Pass CSRF token
                task: task
            },
            success: function (response) {
                if (response.success) {
                    $('#FormActive' + id).addClass('d-none');
                    $('#FormInactive' + id).removeClass('d-none').addClass('bg-danger');
                    toastr.success(response.success); // Show the success message from the response
                }
            },
            error: function (error) {
                // Handle error here
                toastr.error(response.error);
                console.error('Error:', error);
            }
        });
    };


    const FormStatusInactive = (id) => {
        let formID = id;
        let task = 'Active';

        $.ajax({
            url: `{{ route('enquiry.forms.status', ':id') }}`.replace(':id', formID),
            type: 'POST',
            data: {
                _token: csrf,
                task: task
            },
            success: function (response) {
                $('#FormActive' + id).removeClass('d-none').addClass('bg-success');
                $('#FormInactive' + id).addClass('d-none');
                toastr.success(response.success);
                console.log(response);
            },
            error: function (error) {
                // Handle error here
                console.error('Error:', error);
            }
        });
    };
</script>



<script>


    const DelForms = (id) => {
        if (!id) return;

        // Show SweetAlert confirmation
        Swal.fire({
            text: "You won't be able to revert this!",
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: `{{ route('enquiry.forms.delete', ':id') }}`.replace(':id', id),
                    type: 'get',
                    data: {
                        _token: csrf,
                    },
                    success: (response) => {
                        const status = response[0];
                        const message = response[1];
                        if (status === "success") {
                            $('.FormData_' + id).remove();
                            toastr.success(message);
                        } else {
                            toastr.error(message || 'An error occurred while deleting the form.');
                        }
                    },
                    error: (xhr, status, error) => {
                        console.error(error);
                        toastr.error('An unexpected error occurred.');
                    },
                });
            }
        });
    };


    const deletedoc = (id) => {
        $.ajax({
            url: `{{ route('settings.child.delete', ':id') }}`.replace(':id', id),
            type: 'DELETE',
            data: {
                _token: csrf, // Include CSRF token
            },
            success: (response) => {
                // Check if the 'success' key exists in the response object
                if (response.success) {
                    document.getElementById(id).closest('.document-group').remove();
                }
            },
        });
    };


    const deletestaffdoc = (id) => {
        $.ajax({
            url: `{{ route('settings.staff.delete', ':id') }}`.replace(':id', id),
            type: 'DELETE',
            data: {
                _token: csrf, // Include CSRF token
            },
            success: (response) => {
                // Check if the 'success' key exists in the response object
                if (response.success) {
                    document.getElementById(id).closest('.staff-document-group').remove();
                }
            },
        });
    };


    $(document).ready(function () {
        $('.tab-documents').hide();

        $('#tab1').click(function () {
            $('.tab1').show();
            $('.tab-documents').hide();
            $('.staff-tab-documents').hide();
            $('.donor-tab-settings').hide();
            $('.enquiryForms-tab-settings').hide();
            $(this).addClass('active').siblings().removeClass('active');
        });

        $('#docs').click(function () {
            $('.tab-documents').show();
            $('.tab1').hide();
            $('.staff-tab-documents').hide();
            $('.donor-tab-settings').hide();
            $('.enquiryForms-tab-settings').hide();
            $(this).addClass('active').siblings().removeClass('active');
        });

        $('#staff_docs').click(function () {
            $('.tab-documents').hide();
            $('.tab1').hide();
            $('.donor-tab-settings').hide();
            $('.enquiryForms-tab-settings').hide();
            $('.staff-tab-documents').show();
            $(this).addClass('active').siblings().removeClass('active');
        });


        $('#donor_setting').click(function () {
            $('.tab-documents').hide();
            $('.tab1').hide();
            $('.staff-tab-documents').hide();
            $('.enquiryForms-tab-settings').hide();
            $('.donor-tab-settings').show();
            $(this).addClass('active').siblings().removeClass('active');
        });

        $('#enquiryForms').click(function () {
            $('.tab-documents').hide();
            $('.tab1').hide();
            $('.staff-tab-documents').hide();
            $('.enquiryForms-tab-settings').show();
            $('.donor-tab-settings').hide();
            $(this).addClass('active').siblings().removeClass('active');

        });

        $('.add-document').click(function () {
            var uniqueId = new Date().getTime(); // Generate a unique ID for each input

            var newDocument = `
                <div class="document-group mb-3 d-flex">
                    <div class="input-group">
                        <input type="text" class="form-control" name="child_documents_title[new_${uniqueId}]" placeholder="Enter document title">
                        <button type="button" class="btn btn-sm btn-danger remove-document">×</button>
                    </div>
                    <div class="form-check ms-2">
                        <input type="checkbox" class="form-check-input" name="child_documents_required[new_${uniqueId}]">
                        <label class="form-check-label">Required</label>
                    </div>
                </div>
            `;

            $('.documents').append(newDocument);
        });


        $('.documents').on('click', '.remove-document', function () {
            if ($('.document-group').length > 1) {
                $(this).closest('.document-group').remove();
            }
        });

        // Add new document group
        $('.staff-add-document').click(function () {
            var newDocument = `
        <div class="document-group mb-3">
            <div class="input-group">
                <input type="text" class="form-control" name="staff_document_title[]" placeholder="Enter document title">
                <button type="button" class="btn btn-sm btn-danger staff-remove-document">×</button>
            </div>
        </div>`;

            $('.staff-documents').append(newDocument);
        });

        // Remove document group
        $('.staff-documents').on('click', '.staff-remove-document', function () {
            $(this).closest('.document-group').remove();
        });
    });

</script>