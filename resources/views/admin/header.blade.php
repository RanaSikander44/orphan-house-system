<nav id="layoutHeader" class="sb-topnav navbar navbar-expand navbar-dark bg-white">
    <!-- Navbar Brand-->
    <a class="navbar-brand ps-3 text-black" href="index.html">Clients</a>

    <!-- Sidebar Toggle-->
    <!-- <button
        class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0 "
        id="sidebarToggle"
        href="#!"
      > -->
    <!-- <i class="fas fa-bars"></i> -->
    </button>
    <!-- Navbar Search-->
    <form class="d-none d-md-inline-block form-inline ms-auto me-0 me-md-3 my-2 my-md-0">
        <div class="input-group">
            <input class="form-control" type="text" placeholder="Search for..." aria-label="Search for..."
                aria-describedby="btnNavbarSearch" />
            <button class="btn btn-primary" id="btnNavbarSearch" type="button">
                <i class="fas fa-search"></i>
            </button>
        </div>
    </form>
    <!-- Navbar-->
    <!-- Navbar-->

</nav>
<!-- Sidebar -->
<div id="sidebar">
    <div class="bg-white border-end sidebar-content">
        <ul class="list-group list-group-flush my-ul pt-2">
            <li class="list-group-item first-li">
                <h4 class="text-capitalize">Admin profile</h4>
                <span id="cross" class="" style="cursor : pointer;"><i class="fa-solid fa-xmark"></i></span>
            </li>
            <li class="avatar">
                <div class="image"><img src="" alt="avatar" /></div>
                <div class="name-login">
                    <h5>{{ auth()->user()->name }}</h5>
                    <a href="#"><i class="fa-solid fa-envelope"></i> {{ Auth()->user()->email }}</a>
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