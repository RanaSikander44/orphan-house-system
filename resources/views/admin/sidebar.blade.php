<div id="layoutSidenav_nav">
    <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
        <div class="sb-sidenav-menu">
            <div class="nav">
                <div class="sb-sidenav-menu-heading">Core</div>
                <a class="nav-link {{ request()->is('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">
                    <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                    Dashboard
                </a>
                <div class="sb-sidenav-menu-heading">Applications</div>
                <a class="nav-link {{ request()->is('academic-year') ? 'active' : '' }}"
                    href="{{ route('academic-year') }}">
                    <div class="sb-nav-link-icon"><i class="fas fa-graduation-cap"></i></div>
                    Academic Years
                </a>

                <a class="nav-link {{ request()->is('applications') || request()->is('applications/add') ? 'active' : '' }}"
                    href="{{ route('applications') }}">
                    <div class="sb-nav-link-icon"><i class="fas fa-envelope"></i></div>
                    Applications
                </a>
                
                <a class="nav-link {{ request()->routeIs('posts.index') || request()->routeIs('posts.*') ? 'active' : '' }}"
                    href="{{ route('roles.index') }}">
                    <div class="sb-nav-link-icon"><i class="fas fa-user-shield"></i></div>
                    Roles
                 </a>
                 
                 
                 
                 

            </div>
        </div>

    </nav>
</div>
