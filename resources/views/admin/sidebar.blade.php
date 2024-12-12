@php
    use App\Models\Menu;

    $sidebar = Menu::with('children')->whereNull('parent_id')->orderBy('order')->get();
@endphp
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
                    @foreach ($sidebar as $menu)
                        @can($menu->permission)
                            <li class="sidebar-dropdown {{ request()->routeIs($menu->route ?? '') ? 'active' : '' }}">
                                <a href="{{ $menu->route ? route($menu->route) : '#' }}"
                                    class="{{ $menu->is_dropdown && $menu->children->count() ? 'dropdown-toggle' : '' }}">
                                    <i class="{{ $menu->icon }}"></i>
                                    <span>{{ $menu->title }}</span>
                                </a>

                                @if ($menu->is_dropdown && $menu->children->count())
                                    <div class="sidebar-submenu"
                                        style="{{ request()->is($menu->route . '*') ? 'height: auto;' : '' }}">
                                        <ul>
                                            @foreach ($menu->children as $child)
                                                @can($child->permission) <!-- Check permission for submenu -->
                                                    <li>
                                                        <a href="{{ route($child->route) }}"
                                                            class="{{ request()->routeIs($child->route) ? 'active' : '' }}">
                                                            {{ $child->title }}
                                                        </a>
                                                    </li>
                                                @endcan
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif
                            </li>
                        @endcan
                    @endforeach
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


<script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4="
    crossorigin="anonymous"></script>


<script>
    $('.sidebar-submenu a.active').each(function () {
        $(this).closest('.sidebar-dropdown').addClass('active');
        console.log($(this).closest('.sidebar-dropdown'));
    });
</script>


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
