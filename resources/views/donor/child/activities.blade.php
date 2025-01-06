@extends('admin.default')

@section('Page-title', 'Dashboard')

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
    @endif
</div>
@endsection