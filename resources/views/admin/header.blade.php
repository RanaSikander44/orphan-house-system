<nav id="layoutHeader" class="sb-topnav navbar navbar-expand navbar-dark bg-white">
    <!-- Navbar Brand -->
    <p class="navbar-brand mt-2 ps-3 text-black" href="#">@yield('Page-title')</p>
    <!-- Greeting and user button container -->
    <div class="d-flex align-items-center ms-auto">
        <!-- Greeting Text -->
        <p class="mb-0 me-3" style="font-size: 1.1rem; color: #B5B5C3; font-weight: 500;">
            {{ getGreeting() . ',' }}
            <span class="text-dark">{{ Auth::user()->role->name }}</span>
        </p>

        <!-- Notifications Icon with Dropdown -->
        <div class="dropdown" style="margin-right : 30px;">
            <button class="btn position-relative p-0 border-0 bg-transparent" type="button" id="notificationDropdown"
                data-bs-toggle="dropdown" aria-expanded="false">
                <i class="fas fa-bell fa-lg text-dark"></i>
                @if($notifications->count() > 0)
                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                        {{ $notifications->count() }}
                        <span class="visually-hidden">unread notifications</span>
                    </span>
                @endif
            </button>

            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="notificationDropdown" style="width: 300px;">
                @if($notifications->count() > 0)
                    @foreach ($notifications as $list)
                        <li class="dropdown-item">
                            <a href="javascript:void(0);" class="notification-link text-dark" data-id="{{ $list->id }}"
                                data-url="{{ url('chid/activities/view/' . $list->id) }}">
                                <p class="mb-0 text-muted" style="font-size: 0.9rem;">{{ $list->message }}</p>
                                <small class="text-muted">{{ $list->created_at }}</small>
                            </a>
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                    @endforeach
                @else
                    <li class="dropdown-item text-center text-muted">
                        No new notifications
                    </li>
                @endif
            </ul>
        </div>


        <!-- User Button -->
        <button class="btn me-3" style="background-color: #C9F7F5; color: #B5B5C3;" id="sidebarTogglee">
            <i class="fas fa-user fa-fw"></i>
        </button>
    </div>

</nav>


<!-- Sidebar -->
<div id="sidebar">
    <div class="bg-white border-end sidebar-content">
        <ul class="list-group list-group-flush my-ul pt-4">
            <li class="list-group-item first-li">
                <h5 class="text-capitalize">{{ Auth::user()->role->name }} profile</h5>
                <span id="cross" class="" style="cursor : pointer;"><i class="fa-solid fa-xmark"></i></span>
            </li>
            <li class="avatar">
                <div class="image"><img src="{{ asset('backend/images/default.jpg') }}" alt="avatar" class="rounded" />
                </div>
                <div class="name-login">
                    <h5>{{ auth()->user()->first_name }} {{ auth()->user()->first_name }}</h5>
                    <a href="#" class="d-flex align-items-center text-decoration-none">
                        <!-- Envelope Icon -->
                        <i class="fa-solid fa-envelope me-2" style="font-size: 1rem; color: #6c757d;"></i>

                        <!-- Email Address -->
                        <p class="text-muted mb-0" style="font-size: 1rem; color: #6c757d;">
                            {{ Auth()->user()->email }}
                        </p>
                    </a>

                    <a href="{{ route('logout') }}" class="text-capitalize d-block mt-2 my-btn text-dark"
                        style="width  : 40%;">sign out</a>
                </div>
            </li>
            <li class="third-li">
                <i class="fa-solid fa-lock my-lock"></i>
                <ul class="px-2">
                    <li class="fw-bold text-capitalize">security</li>
                    <li>change your password <span class="my-cng text-dark">change</span></li>
                </ul>
            </li>
        </ul>
    </div>
</div>
</nav>



<script>
    document.addEventListener('DOMContentLoaded', function () {
        const csrfToken = "{{ csrf_token() }}";

        // Mark all notifications as read when bell icon is clicked
        document.getElementById('notificationDropdown').addEventListener('click', function () {
            // Collect all notification IDs
            const notificationIds = Array.from(document.querySelectorAll('.notification-link')).map(link => link.getAttribute('data-id'));

            if (notificationIds.length > 0) {
                // Send AJAX request to update all notifications
                $.ajax({
                    url: `/notifications/mark-all-as-read`,
                    type: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken
                    },
                    data: { ids: notificationIds },
                    success: function (response) {
                        if (response.success) {

                            

                        } else {
                            alert('Failed to mark notifications as read.');
                        }
                    },
                    error: function (xhr, status, error) {
                        console.error('AJAX Error:', error);
                    }
                });
            }

        });

    });


</script>



<script>

    const sidebarTogglee = document.getElementById("sidebarTogglee");
    const sidebar = document.getElementById("sidebar");
    const cross = document.getElementById("cross");

    sidebarTogglee.addEventListener("click", () => {
        sidebar.classList.toggle("show");
    });

    cross.addEventListener("click", () => {
        sidebar.classList.remove("show");
    });



</script>