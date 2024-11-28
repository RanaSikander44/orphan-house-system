<div class="page-wrapper chiller-theme toggled">
    <nav id="sidebare" class="sidebar-wrapper bg-white">
        <div class="sidebar-content">
            <div class="sidebar-brand">
                <a href="{{ route('dashboard') }}">
                    <img src="{{ asset('backend/images/wisdom-logo.png.webp') }}" style="width: 60%; height: auto;"
                        alt="Wisdom Logo">
                </a>
                <div id="close-sidebar" class="sidebarToggle">
                    <i class="fa-solid fa-angles-right text-black"></i>
                </div>
            </div>

            <div class="sidebar-menu">
                <ul>
                    <li class="sidebar-dropdown {{ request()->is('dashboard') ? 'active' : '' }}">
                        <a href="{{ route('dashboard') }}">
                            <i class="fa fa-tachometer-alt"></i>
                            <span>Dashboard</span>
                        </a>
                    </li>

                    <div class="sb-sidenav-menu-heading mt-2 mb-2 fw-bold text-muted"
                        style="margin-left: 15px; font-size: 12px;">
                        <span>APPLICATIONS</span>
                    </div>

                    <li class="sidebar-dropdown {{ request()->is('academic-year') ? 'active' : '' }}">
                        <a href="{{ route('academic-year') }}">
                            <i class="fas fa-graduation-cap"></i>
                            <span>Sessions</span>
                        </a>
                    </li>

                    <li class="sidebar-dropdown {{ request()->is('applications*') ? 'active' : '' }}">
                        <a href="#" class="dropdown-toggle">
                            <i class="fas fa-envelope"></i>
                            <span>Applications</span>
                        </a>
                        <div class="sidebar-submenu"
                            style="{{ request()->is('applications*') ? 'height: auto;' : '' }}">
                            <ul>
                                <li>
                                    <a href="{{ route('applications') }}"
                                        class="{{ request()->is('applications') ? 'active' : '' }}">
                                        Applications List
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('application.add') }}"
                                        class="{{ request()->is('applications/add') ? 'active' : '' }}">
                                        Add New
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>

                    <li
                        class="sidebar-dropdown {{ request()->is('users') || request()->is('users/create') ? 'active' : '' }}">
                        <a class="nav-link " href="{{ route('users') }}">
                            <i class="fas fa-users"></i>
                            <span>Users</span>
                        </a>
                    </li>


                    <li class="sidebar-dropdown {{ request()->is('roles') || request()->is('roles') ? 'active' : '' }}">
                        <a class="nav-link " href="{{ route('roles.index') }}">
                            <i class="fas fa-user-shield"></i>
                            <span>Roles</span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</div>



<style>
    /* Drodown Css */

    .sidebar-submenu {
        overflow: hidden;
        height: 0;
        transition: height 0.5s ease;
        /* Smooth animation over 0.5 seconds */
    }

    .sidebar-submenu ul {
        list-style: none;
        padding: 0;
        background-color: white;
    }

    .sidebar-submenu ul li a {
        text-decoration: none;
        color: #333;
        display: block;
    }

    .sidebar-dropdown.active .sidebar-submenu {
        display: block;
    }

    .sidebar-menu .active>a {
        color: #007bff;
        /* Highlighted text color */
        /* font-weight: bold; */
        /* Optional */
    }

    .sidebar-menu .active .sidebar-submenu ul li a.active {
        color: #007bff;
        /* Highlighted submenu link color */
        /* font-weight: bold; */
        /* Optional */
    }

    .sidebar-wrapper.collapsed .dropdown-toggle::after {
        content: none;
    }
</style>


<script>
    const dropdownToggles = document.querySelectorAll('.dropdown-toggle');

    dropdownToggles.forEach((toggle) => {
        toggle.addEventListener('click', (event) => {
            event.preventDefault(); // Prevent default link behavior

            const parentLi = toggle.parentElement;

            // Toggle the clicked menu
            const submenu = parentLi.querySelector('.sidebar-submenu');
            if (parentLi.classList.contains('active')) {
                parentLi.classList.remove('active');
                if (submenu) submenu.style.height = '0'; // Collapse the menu
            } else {
                parentLi.classList.add('active');
                if (submenu) submenu.style.height = submenu.scrollHeight + 'px'; // Expand to full height
            }
        });
    });
</script>