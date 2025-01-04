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
                            <button type="button" class="btn btn-sm btn-block mb-2 active" id="tab1">Child Age</button>
                            <button type="button" class="btn btn-sm btn-block mb-2" id="docs">Child
                                Documents</button>
                            <button type="button" class="btn btn-sm btn-block mb-2" id="staff_docs">Staff
                                Documents</button>
                            <button type="button" class="btn btn-sm btn-block mb-2" id="donor_setting">Donor
                                Settings</button>
                        </div>
                    </div>
                    <div class="col-8 ms-5">
                        <!-- Child Age Tab Content -->
                        <div class="tab1">
                            <div class="d-flex mb-4">
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

                        <!-- Required Documents Tab Content For Child -->
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
                                        <div class="document-group mb-3">
                                            <div class="input-group">
                                                <input type="text" class="form-control" id="{{ $document->id }}"
                                                    name="student_document_title[{{ $document->id }}]"
                                                    value="{{ $document->title }}" placeholder="Enter document title">
                                                @if ($key > 0)
                                                    <button type="button" class="btn btn-danger btn-sm" title="Remove"
                                                        onclick="deletedoc({{ $document->id }})">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                @endif
                                            </div>
                                        </div>
                                    @endforeach
                                @else
                                    <div class="document-group mb-3">
                                        <div class="input-group">
                                            <input type="text" class="form-control" name="student_document_title[]"
                                                placeholder="Enter document title">
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <!-- Staff Documents -->


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
                            <div class="d-flex align-items-center justify-content-between mb-3">
                                <h6 class="mb-0 text-muted">Reminder Days for Payment Completion</h6>
                                <!-- <p class="text-dark fw-bold">
                                    The number of days entered in this field will determine when a reminder notification
                                    or email is sent to donors if their payment remains pending.
                                </p> -->

                            </div>
                            <div class="donor-settings">
                                <input type="number" class="form-control" name="min_dayes_for_req_donors" value="{{ $donorSetting->min_dayes_for_req_donors }}">
                                <p class="text-muted mt-3">
                                    This field allows to set the number of days after which a reminder notification
                                    will be sent to donors who have requested for donate but have not completed their
                                    payments. </p>
                                </p>
                            </div>
                        </div>


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
    let csrf = "{{ csrf_token() }}"; // This will output the CSRF token correctly
</script>

<script src="https://code.jquery.com/jquery-3.7.1.slim.js"
    integrity="sha256-UgvvN8vBkgO0luPSUl2s8TIlOSYRoGFAX4jlCIm9Adc=" crossorigin="anonymous"></script>

<script>
    const deletedoc = (id) => {
        $.ajax({
            url: `{{ route('settings.delete', ':id') }}`.replace(':id', id),
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
            url: `{{ route('settings.delete', ':id') }}`.replace(':id', id),
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
            $(this).addClass('active').siblings().removeClass('active');
        });

        $('#docs').click(function () {
            $('.tab-documents').show();
            $('.tab1').hide();
            $('.staff-tab-documents').hide();
            $('.donor-tab-settings').hide();
            $(this).addClass('active').siblings().removeClass('active');
        });

        $('#staff_docs').click(function () {
            $('.tab-documents').hide();
            $('.tab1').hide();
            $('.donor-tab-settings').hide();
            $('.staff-tab-documents').show();
            $(this).addClass('active').siblings().removeClass('active');
        });


        $('#donor_setting').click(function () {
            $('.tab-documents').hide();
            $('.tab1').hide();
            $('.staff-tab-documents').hide();
            $('.donor-tab-settings').show();
            $(this).addClass('active').siblings().removeClass('active');
        });


        $('.add-document').click(function () {
            var newIndex = $('.document-group').length + 1;

            var newDocument = `
                <div class="document-group mb-3">
                    <div class="input-group">
                        <input type="text" class="form-control" name="student_document_title[]" placeholder="Enter document title">
                        <button type="button" class="btn btn-sm btn-danger remove-document">×</button>
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