<div class="page-wrapper chiller-theme toggled">
    <nav id="sidebare" class="sidebar-wrapper bg-white">
        <div class="sidebar-content">
            <div class="sidebar-brand">
                <a href="{{ route('dashboard') }}">
                    <img src="{{ asset('backend/images/wisdom-logo.png.webp') }}" style="width: 60%; height: auto;"
                        alt="Wisdom Logo">
                </a>
                <!-- <img src="" alt=""> -->
                <div id="close-sidebar" class="sidebarToggle">
                    <i class="fa-solid fa-angles-right text-black"></i>
                </div>
            </div>

            <div class="sidebar-menu">
                <ul>
                    <li class="sidebar-dropdown">
                        <a href="{{ route('dashboard') }}">
                            <i class="fa fa-tachometer-alt"></i>
                            <span>Dashboard</span>
                        </a>

                    </li>
                    
                    <li class="sidebar-dropdown">
                        <a href="#">
                            <i class="fa fa-shopping-cart"></i>
                            <span>E-commerce</span>
                        </a>
                        <div class="sidebar-submenu">
                            <ul>
                                <li>
                                    <a href="#">Products</a>
                                </li>
                                <li>
                                    <a href="#">Orders</a>
                                </li>
                                <li>
                                    <a href="#">Credit cart</a>
                                </li>
                            </ul>
                        </div>
                    </li>
                    <li class="sidebar-dropdown">
                        <a href="#">
                            <i class="far fa-gem"></i>
                            <span>Components</span>
                        </a>
                        <div class="sidebar-submenu">
                            <ul>
                                <li>
                                    <a href="#">General</a>
                                </li>
                                <li>
                                    <a href="#">Panels</a>
                                </li>
                                <li>
                                    <a href="#">Tables</a>
                                </li>
                                <li>
                                    <a href="#">Icons</a>
                                </li>
                                <li>
                                    <a href="#">Forms</a>
                                </li>
                            </ul>
                        </div>
                    </li>
                    <li class="sidebar-dropdown">
                        <a href="#" class="dropdown-toggle">
                            <i class="fa fa-chart-line"></i>
                            <span>Charts</span>
                        </a>
                        <div class="sidebar-submenu">
                            <ul>
                                <li>
                                    <a href="#">Pie chart</a>
                                </li>
                                <li>
                                    <a href="#">Line chart</a>
                                </li>
                                <li>
                                    <a href="#">Bar chart</a>
                                </li>
                                <li>
                                    <a href="#">Histogram</a>
                                </li>
                            </ul>
                        </div>
                    </li>
                    <li class="sidebar-dropdown">
                        <a href="#" class="dropdown-toggle">
                            <i class="fa fa-globe"></i>
                            <span>Maps</span>
                        </a>
                        <div class="sidebar-submenu">
                            <ul>
                                <li>
                                    <a href="#">Google maps</a>
                                </li>
                                <li>
                                    <a href="#">Open street map</a>
                                </li>
                            </ul>
                        </div>
                                 
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