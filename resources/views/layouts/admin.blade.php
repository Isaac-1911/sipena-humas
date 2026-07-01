<!DOCTYPE html>
<html>

<head>
    <title>SIPENA HUMAS</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
    @stack('scripts')
</head>

<body class="bg-gray-100">

    <div class="flex h-screen">

        {{-- SIDEBAR --}}
        <div class="sidebar d-flex flex-column justify-content-between">

            <div>
                <div class="logo d-flex align-items-center gap-2 mb-4">
                    <img src="{{ asset('images/logo-fixxx.png') }}" alt="" class="sidebar-logo">
                    <div>
                        <strong>SIPENA HUMAS</strong><br>
                        <small>Polres Jember</small>
                    </div>
                </div>

                <p class="menu-label">MENU UTAMA</p>

                <a href="{{ route('admin.index') }}"
                    class="menu-item {{ request()->routeIs('admin.index') ? 'active' : '' }}">
                    <i class="bi bi-grid"></i>
                    Dashboard
                </a>

                <a href="{{ route('admin.news.index') }}"
                    class="menu-item {{ request()->routeIs('admin.news.*') ? 'active' : '' }}">
                    <i class="bi bi-newspaper"></i>
                    Berita
                </a>

                {{-- <a href="{{ route('admin.archive.index') }}"
                    class="menu-item {{ request()->routeIs('admin.archive.*') ? 'active' : '' }}">
                    <i class="bi bi-archive"></i>
                    Arsip
                </a> --}}

                <a href="{{ route('admin.messages.index') }}"
                    class="menu-item {{ request()->routeIs('admin.messages.*') ? 'active' : '' }}">
                    <i class="bi bi-chat"></i>
                    Pesan
                </a>

                {{-- <a href="#" class="menu-item {{  request()->routeIs('admin.services.*') ? 'active' : '' }}">
                    <i class="bi bi-gear"></i>
                    Layanan
                </a> --}}

            </div>

            <div class="sidebar-footer">
                <div class="d-flex align-items-center gap-2 mb-2">
                    <div class="avatar">A</div>
                    <div>
                        <strong>Admin Humas</strong><br>
                        <small>Polres Jember</small>
                    </div>
                </div>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <button type="submit" onclick="return confirm('Yakin ingin logout?')"
                        class="logout border-0 bg-transparent w-100 text-start">
                        <i class="bi bi-box-arrow-right"></i>
                        Logout
                    </button>
                </form>
            </div>

        </div>

        {{-- MAIN --}}
        <div class="flex-1 flex flex-col">

            {{-- TOPBAR --}}
            <div class="main">

                <div class="topbar d-flex justify-content-between align-items-center">

                    {{-- SEARCH --}}
                    <div class="search-box">
                        <i class="bi bi-search"></i>
                        <input type="text" placeholder="Cari...">
                    </div>

                    {{-- RIGHT SIDE --}}
                    <div class="d-flex align-items-center gap-3">

                        {{-- NOTIFICATION --}}
                        {{-- <div class="notification">
                            <i class="bi bi-bell"></i>
                            <span class="badge">3</span>
                        </div> --}}

                        {{-- PROFILE --}}
                        <div class="profile d-flex align-items-center gap-2">
                            <div class="avatar">A</div>
                            <div>
                                <strong>Admin</strong><br>
                                {{-- <small>Super Admin</small> --}}
                            </div>
                        </div>

                    </div>

                </div>

                <div class="content-wrapper">
                    @yield('content')
                </div>

            </div>

        </div>

    </div>
    @yield('scripts')
    <script>
        // Fungsi untuk menutup alert dengan JavaScript murni
        function closeAlert(button) {
            const alert = button.closest('.alert');
            if (alert) {
                // Tambahkan class fade out
                alert.classList.remove('show');
                alert.classList.add('fade');

                // Hapus alert setelah animasi selesai
                setTimeout(function() {
                    alert.remove();
                }, 150);
            }
        }

        // Auto close alert setelah 5 detik
        document.addEventListener('DOMContentLoaded', function() {
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(function(alert) {
                setTimeout(function() {
                    if (alert && alert.parentNode) {
                        alert.classList.remove('show');
                        alert.classList.add('fade');
                        setTimeout(function() {
                            if (alert && alert.parentNode) {
                                alert.remove();
                            }
                        }, 150);
                    }
                }, 5000);
            });
        });

        // Alternative: Manual close with vanilla JS (if Bootstrap not working)
        document.addEventListener('click', function(e) {
            if (e.target.classList.contains('btn-close') || e.target.parentElement.classList.contains(
                    'btn-close')) {
                let btn = e.target;
                if (btn.parentElement && btn.parentElement.classList.contains('btn-close')) {
                    btn = btn.parentElement;
                }
                const alert = btn.closest('.alert');
                if (alert) {
                    alert.classList.remove('show');
                    alert.classList.add('fade');
                    setTimeout(function() {
                        alert.remove();
                    }, 150);
                }
            }
        });
    </script>
</body>

</html>
