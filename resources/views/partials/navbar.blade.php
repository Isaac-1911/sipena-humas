<nav id="mainNavbar" class="navbar navbar-expand-lg fixed-top">
    <div class="container">

        {{-- Logo --}}
        <a class="navbar-brand d-flex align-items-center gap-2" href="/">

            <div class="logo-box">
                <img src="{{ asset('images/logo-fixxx.png') }}" alt="Humas Polri">
            </div>

            <div class="brand-text">
                <h6>SIPENA HUMAS</h6>
                <span>Polres Jember</span>
            </div>

        </a>

        {{-- Mobile Toggle --}}
        <button class="navbar-toggler border-0 shadow-none"
                type="button"
                data-bs-toggle="collapse"
                data-bs-target="#navbarContent">

            <i class="bi bi-list"></i>

        </button>

        {{-- Menu --}}
        <div class="collapse navbar-collapse" id="navbarContent">

            <ul class="navbar-nav mx-auto">

                <li class="nav-item">
                    <a class="nav-link" href="/">Beranda</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="#news">Berita</a>
                </li>

                {{-- <li class="nav-item">
                    <a class="nav-link" href="#services">Layanan</a>
                </li> --}}

                <li class="nav-item">
                    <a class="nav-link" href="#contacts">Kontak</a>
                </li>

            </ul>

        </div>

    </div>
</nav>
