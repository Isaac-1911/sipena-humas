<nav id="navbar" class="navbar-custom">
    <div class="container d-flex justify-content-between align-items-center">

        {{-- LOGO --}}
        <div class="logo d-flex align-items-center gap-2">
            <img src="{{ asset('images/logo.png') }}" width="40">
            <div>
                <strong>SIPENA HUMAS</strong><br>
                <small>Polres Jember</small>
            </div>
        </div>

        {{-- MENU --}}
        <div class="menu d-flex gap-4">
            <a href="#">Beranda</a>
            <a href="#">Berita</a>
            <a href="#">Arsip</a>
            <a href="#">Layanan</a>
            <a href="#">Kontak</a>
        </div>

    </div>
</nav>

<script>
window.addEventListener('scroll', function() {
    const navbar = document.getElementById('navbar');

    if (window.scrollY > 50) {
        navbar.classList.add('navbar-scrolled');
    } else {
        navbar.classList.remove('navbar-scrolled');
    }
});
</script>
