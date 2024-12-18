@extends('admin.default')
@section('Page-title', 'Assign Childs To Nanny')

@section('content')
<div class="container-fluid px-4">
    <div class="card bg-white px-4 py-3 mt-4 border-0 shadow-sm rounded">
        <form method="POST" action="{{ route('assign.childs.submit', $nanny->id) }}">
            <div class="row">
                <div class="col-md-6">
                    <h5 class="text-muted">Assign Childs to {{ $nanny->first_name }} Nanny</h5>

                    <div class="container mt-4">
                        @csrf
                        <div class="custom-multi-select">
                            <div class="select-box d-flex align-items-center justify-content-between">
                                <span>Select Childs</span>
                                <i class="bi bi-chevron-down"></i>
                            </div>
                            <ul class="dropdown-list shadow-lg rounded">
                                @forelse ($childs as $list)
                                    <li data-value="{{ $list->id }}" class="p-2 border-bottom">
                                        {{ $list->first_name }} {{ $list->last_name }}
                                    </li>
                                @empty
                                    <li class="no-childs p-2">No Childs are available to assign</li>
                                @endforelse
                            </ul>
                            <div class="selected-options mt-4 d-flex flex-wrap">
                                @foreach ($assigned as $list)
                                    <span class="bg-success text-white px-2 py-1 rounded mx-1 mb-1"
                                        data-value="{{ $list->child_id }}">
                                        {{ $list->child->first_name }} {{ $list->child->last_name }}
                                    </span>
                                    <script>
                                        selectedValues.push({{ $list->child_id }});  // Adding the assigned child ID to the selectedValues array
                                    </script>
                                @endforeach
                            </div>
                        </div>

                        <input type="hidden" name="selected_childs" id="selected_childs">
                    </div>
                </div>



                <div class="card-footer bg-white mt-5 d-flex justify-content-between align-items-center">
                    <div class="action-buttons">
                        <button type="button" class="btn btn-sm btn-warning" data-toggle="modal"
                            data-target="#exampleModal">
                            <i class="fas fa-user-minus"></i> Unassign Child
                        </button>

                        <a href="{{ route('unassign.all', $nanny->id) }}" class="btn btn-sm btn-danger ms-2">
                            <i class="fas fa-trash-alt"></i> Unassign All
                        </a>
                    </div>

                    <div class="assign-button">
                        <button type="submit" class="btn btn-success btn-sm">
                            <i class="fas fa-user-plus"></i> Assign
                        </button>
                    </div>
                </div>

            </div>
        </form>

    </div>
</div>


<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form action="{{ route('unassign.child') }}">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Unassign a Child</h5>
                </div>
                <div class="modal-body">
                    <select name="unassign_child" id="" class="form-control">
                        @forelse ($assigned as $list)
                            <option value="{{ $list->id }}">{{ $list->child->first_name }}
                                {{ $list->child->last_name }}
                            </option>
                        @empty
                            <option value="">This Nanny has no childs .</option>
                        @endforelse
                        <input type="text" class="form-control d-none" name="nanny_id" value="{{ $nanny->id }}">
                    </select>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-sm btn-primary">Submit</button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- end Modal -->






<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script>
    $(document).ready(function () {
        const selectBox = $('.select-box');
        const dropdownList = $('.dropdown-list');
        const selectedOptionsContainer = $('.selected-options');
        const selectedValues = [];  // Store selected values (child IDs)

        // Add already assigned children to the selectedValues array
        @foreach ($assigned as $list)
            selectedValues.push({{ $list->child_id }}); // Add each assigned child's ID
        @endforeach

        // Toggle dropdown visibility
        selectBox.on('click', function () {
            dropdownList.toggle();
        });

        // Select option
        dropdownList.on('click', 'li', function () {
            const value = $(this).data('value');
            const text = $(this).text();

            // Prevent empty options from being selected (e.g., "No Childs are available to assign")
            if (text.trim() === "" || $(this).hasClass('no-childs')) {
                return; // Prevent selection of empty options or the placeholder
            }

            // Check if the child is already selected
            if (!selectedValues.includes(value)) {
                selectedValues.push(value);

                // Add selected option to the container
                selectedOptionsContainer.append(`
                    <span class="bg-success text-white px-2 py-1 rounded mx-1 mb-1" data-value="${value}">
                        ${text} <span class="remove-option text-white">&times;</span>
                    </span>
                `);

                // Update the hidden input field with the selected values
                $('#selected_childs').val(selectedValues.join(','));
            }

            // Hide the dropdown after selection
            dropdownList.hide();
        });

        // Remove selected option
        selectedOptionsContainer.on('click', '.remove-option', function () {
            const value = $(this).parent().data('value');
            selectedValues.splice(selectedValues.indexOf(value), 1);
            $(this).parent().remove();

            // Update the hidden input field with the selected values
            $('#selected_childs').val(selectedValues.join(','));
        });

        // Hide dropdown when clicking outside
        $(document).on('click', function (event) {
            if (!$(event.target).closest('.custom-multi-select').length) {
                dropdownList.hide();
            }
        });
    });
</script>

@endsection