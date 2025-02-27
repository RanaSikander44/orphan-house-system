@extends('admin.default')

@section('Page-title', 'Child Activity Management')

@section('content')

<div class="container-fluid px-4">
    @if ($activity->isEmpty())
        <div class="alert alert-info mt-4 text-center">
            No activities found for the children.
        </div>
    @else
            @foreach ($activity as $list)
                <div class="card bg-white px-4 py-3 mt-4 border-0 shadow-sm rounded">
                    <div class="card-body position-relative">
                        <div class="dropdown position-absolute activity-dropdown" style="top: 10px; right: 10px;">
                            <button class="btn btn-link text-dark p-0 toggle-menu" type="button"
                                id="dropdownMenuButton{{ $list->id }}">
                                <i class="fa-solid fa-ellipsis-vertical"></i>
                            </button>
                            <ul class="dropdown-menu menu-content" aria-labelledby="dropdownMenuButton{{ $list->id }}">
                                <li><a class="dropdown-item" href="{{ route('activity.edit', $list->id) }}">Edit</a></li>
                                <li>
                                    <button type="button" class="dropdown-item text-danger" onclick="delAct(123)">Delete</button>
                                </li>

                                <!-- Example form -->
                                <form id="delete-form-act" method="get" action="{{ route('activity.delete', $list->id) }}"
                                    style="display: none;">
                                    @csrf
                                </form>
                            </ul>
                        </div>


                        <!-- Remaining Content -->
                        <div class="d-flex align-items-center mb-3">
                            <!-- Profile Image -->
                            <img src="{{ asset('backend/images/childs/' . ($list->child->child_image ?? 'default.jpg')) }}"
                                class="rounded-circle me-3" alt="Profile Image" width="50" height="50">
                            <div>
                                <h6 class="mb-0">{{ $list->child->first_name ?? 'No Name Found' }}</h6>
                                <small
                                    class="text-muted">{{ \Carbon\Carbon::parse($list->created_at)->format('l \a\t g:i A') }}</small>
                            </div>
                        </div>
                        <!-- Post Content -->
                        <h5 class="mb-2">{{ $list->name }}</h5>
                        <p class="mb-3 text-muted">{{ $list->desc }}</p>
                        <!-- Post Images Slider -->
                        <div id="imageSlider{{ $list->id }}" class="carousel slide" data-bs-ride="carousel"
                            style="max-width: 500px; margin: 0 auto;">
                            <div class="carousel-inner">
                                @foreach ($list->images as $index => $image)
                                    <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                                        <div class="text-center mb-3"
                                            style="background-color: #f8f9fa; width: 500px; height: 300px; display: flex; align-items: center; justify-content: center;">
                                            <img src="{{ asset($image->image) }}" class="img-fluid rounded" alt="Post Image"
                                                style="max-width: 100%; max-height: 100%; object-fit: contain;">
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <!-- Controls -->
                            <button class="carousel-control-prev" type="button" data-bs-target="#imageSlider{{ $list->id }}"
                                data-bs-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true" style="background-color: black;"></span>
                                <span class="visually-hidden">Previous</span>
                            </button>
                            <button class="carousel-control-next" type="button" data-bs-target="#imageSlider{{ $list->id }}"
                                data-bs-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true" style="background-color: black;"></span>
                                <span class="visually-hidden">Next</span>
                            </button>
                        </div>
                    </div>
                </div>
            @endforeach

            <div class="d-flex justify-content-between mt-3 align-items-center mb-4">
                <div>
                    <span>Showing {{ $activity->firstItem() ?? 0 }} to {{ $activity->lastItem() ?? 0 }} of
                        {{ $activity->total() }}
                        entries</span>
                </div>
                <div>
                    {{ $activity->links() }}
                </div>
            </div>
        </div>

    @endif

<style>
    .dropdown .menu-content {
        right: auto !important;
        left: 0 !important;
        transform: translateX(-100%);
    }
</style>

<script>
    $(document).ready(function () {

        $(".toggle-menu").on("click", function (e) {
            e.preventDefault();
            const menu = $(this).siblings(".menu-content");
            $(".menu-content").not(menu).hide(); // Hide other menus
            menu.toggle(); // Toggle the current menu
        });

        // Hide menu when clicking outside
        $(document).on("click", function (e) {
            if (!$(e.target).closest(".dropdown").length) {
                $(".menu-content").hide();
            }
        });
    });

</script>

<script>
    function delAct(id) {
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Delete',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                const form = document.getElementById(`delete-form-act`);
                if (form) {
                    form.submit();
                }
            }
        });
    }
</script>

@endsection