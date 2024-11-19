<nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
    <!-- Navbar Brand-->
    <a class="navbar-brand ps-3 pt-2" href="{{ route('dashboard') }}">
        <img src="{{asset('backend/images/logo.png')}}" style="width : 100px;" alt="">
    </a>
    <!-- Sidebar Toggle-->
    <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"><i
            class="fas fa-bars"></i></button>
    <!-- Navbar Search-->
    <form class="d-none d-md-inline-block form-inline ms-auto me-0 me-md-3 my-2 my-md-0">
        <div class="input-group">
            <input class="form-control" type="text" placeholder="Search for..." aria-label="Search for..."
                aria-describedby="btnNavbarSearch" />
            <button class="btn btn-primary" id="btnNavbarSearch" type="button"><i class="fas fa-search"></i></button>
        </div>
    </form>
    <!-- Navbar-->
    <ul class="navbar-nav ms-auto ms-md-0 me-3 me-lg-4">
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown"
                aria-expanded="false"><i class="fas fa-user fa-fw"></i></a>
            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                <li><a class="dropdown-item" href="#!">Settings</a></li>
                <li><a class="dropdown-item" href="#!">Activity Log</a></li>
                <li>
                    <hr class="dropdown-divider" />
                </li>
                <li><a class="dropdown-item" href="#!">Logout</a></li>
            </ul>
        </li>
    </ul>
</nav>





<style>
    /* select 2  */
    .select2 {
        width: 100%;
    }

    .select2-container .select2-selection--single,
    .select2-container--default .select2-search--dropdown .select2-search__field {
        border-color: var(--color-border, #C0C0C0);
    }

    .select2-container .select2-selection--single,
    .select2-dropdown .select2-search--dropdown .select2-search__field {
        background-color: var(--color-white, #FFFFFF);
        border-radius: var(--br-600, 24px);
        border-radius: 5px;
    }

    .select2-container .select2-selection--single,
    .select2-container .select2-selection--single .select2-selection__rendered {
        height: auto;
        line-height: normal;
    }

    .select2-dropdown .select2-search--dropdown .select2-search__field,
    .select2-container .select2-selection--single .select2-selection__rendered {
        padding: var(--padding-input, 8px 15px);
        color: var(--color-text, #000000);
    }

    .select2-container--default .select2-selection--single .select2-selection__arrow {
        height: 100%;
        width: var(--gap-700, 48px);
    }

    .select2-search--dropdown,
    .select2-results__option[aria-selected],
    .select2-results__option[data-selected],
    .select2-results__option.select2-results__message {
        padding-inline: var(--gap-300, 12px);
    }

    .select2-dropdown {
        border-radius: var(--br-200, 8px);
        border-radius: 10px;
        overflow: hidden;
    }

    .select2-search--dropdown {
        padding-block: var(--gap-300, 12px);
    }

    .select2-dropdown .select2-search--dropdown .select2-search__field {
        padding: 5px;
        font-family: var(--ff-sans);
        font-size: var(--fs-400, 15px);
    }

    .select2-container--default .select2-results__option[aria-selected=true],
    .select2-container--default .select2-results__option[data-selected=true],
    .select2-container--default .select2-results__option--highlighted[aria-selected]:hover,
    .select2-container--default .select2-results__option--highlighted[data-selected]:hover,
    .select2-container--default .select2-results__option--highlighted[aria-selected]:focus,
    .select2-container--default .select2-results__option--highlighted[data-selected]:focus {
        background-color: var(--color-accent, #000000);
        color: var(--color-white, #FFFFFF);
    }

    .select2-container--default .select2-results__option--highlighted[aria-selected],
    .select2-container--default .select2-results__option--highlighted[data-selected] {
        background-color: var(--color-grey-100, #C0C0C0FF);
        color: var(--color-primary, #000000);
    }
</style>