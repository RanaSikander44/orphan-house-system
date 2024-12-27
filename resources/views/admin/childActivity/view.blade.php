@extends('admin.default')

@section('Page-title', 'Child Activity Management')

@section('content')
<div class="container-fluid px-4">

    <div class="container mt-4">
        <div class="card shadow-sm border-0">
            <!-- Header -->
            <div class="card-body">
                <div class="d-flex align-items-center mb-3">
                    <!-- Profile Image -->
                    <img src="{{ asset('backend/images/childs/' . ($latestActivity->child->child_image ?? 'default-avatar.jpg')) }}"
                        class="rounded-circle me-3" alt="Profile Image" width="50" height="50">

                    <div>
                        <h6 class="mb-0">{{ $latestActivity->child->first_name ?? 'No Name Found' }}</h6>
                        <small
                            class="text-muted">{{ \Carbon\Carbon::parse($latestActivity->created_at)->format('l \a\t g:i A') }}</small>
                    </div>
                </div>
                <!-- Post Content -->
                <h5 class="mb-2">{{ $latestActivity->name }}</h5>
                <p class="mb-3 text-muted">{{ $latestActivity->desc }}</p>
                <!-- Post Images Slider -->
                <div id="imageSlider" class="carousel slide" data-bs-ride="carousel"
                    style="max-width: 500px; margin: 0 auto;">
                    <div class="carousel-inner">
                        @foreach ($imagesOfCActivity as $index => $list)
                            <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                                <div class="text-center mb-3"
                                    style="background-color: #f8f9fa; width: 500px; height: 300px; display: flex; align-items: center; justify-content: center;">
                                    <img src="{{ asset($list->image) }}" class="img-fluid rounded" alt="Post Image"
                                        style="max-width: 100%; max-height: 100%; object-fit: contain;">
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <!-- Controls -->
                    <button class="carousel-control-prev" type="button" data-bs-target="#imageSlider"
                        data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"
                            style="background-color: black;"></span>
                        <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#imageSlider"
                        data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"
                            style="background-color: black;"></span>
                        <span class="visually-hidden">Next</span>
                    </button>
                </div>
                <!-- Reactions
                                        <div class="d-flex justify-content-between align-items-center border-top pt-2">
                                            <div class="text-muted">
                                                <i class="fas fa-heart text-danger me-1"></i>
                                                <i class="fas fa-thumbs-up text-primary me-1"></i>
                                                Lorem ipsum and 291 others
                                            </div>
                                            <div class="text-muted">55 comments</div>
                                        </div>
                                        <div class="d-flex justify-content-between border-top pt-3">
                                            <button class="btn btn-light flex-grow-1 text-muted" aria-label="Like">
                                                <i class="far fa-thumbs-up"></i> Like
                                            </button>
                                            <button class="btn btn-light flex-grow-1 text-muted" aria-label="Comment">
                                                <i class="far fa-comment"></i> Comment
                                            </button>
                                            <button class="btn btn-light flex-grow-1 text-muted" aria-label="Share">
                                                <i class="fas fa-share"></i> Share
                                            </button>
                                        </div> -->
            </div>
        </div>
    </div>



</div>

@endsection