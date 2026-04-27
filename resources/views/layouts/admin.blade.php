<!DOCTYPE html>
<html>

<head>
    <title>SIPENA HUMAS</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
</head>

<body class="bg-gray-100">

    <div class="flex h-screen">

        {{-- SIDEBAR --}}
        <div class="sidebar d-flex flex-column justify-content-between">

            <div>
                <div class="logo d-flex align-items-center gap-2 mb-4">
                    <div class="logo-icon">
                        <i class="bi bi-shield-check"></i>
                    </div>
                    <div>
                        <strong>SIPENA HUMAS</strong><br>
                        <small>Polres Jember</small>
                    </div>
                </div>

                <p class="menu-label">MENU UTAMA</p>

                <a href="{{ route('admin.index') }}" class="menu-item active">
                    <i class="bi bi-grid"></i>
                    Dashboard
                </a>

                <a href="{{ route('admin.news.index') }}" class="menu-item">
                    <i class="bi bi-newspaper"></i>
                    Berita
                </a>

                <a href="{{ route('admin.archive.index') }}" class="menu-item">
                    <i class="bi bi-archive"></i>
                    Arsip
                </a>

                <a href="#" class="menu-item">
                    <i class="bi bi-chat"></i>
                    Pesan
                </a>

                <a href="#" class="menu-item">
                    <i class="bi bi-gear"></i>
                    Layanan
                </a>

            </div>

            <div class="sidebar-footer">
                <div class="d-flex align-items-center gap-2 mb-2">
                    <div class="avatar">A</div>
                    <div>
                        <strong>Admin Humas</strong><br>
                        <small>Polres Jember</small>
                    </div>
                </div>

                <a href="#" class="logout">
                    <i class="bi bi-box-arrow-right"></i>
                    Logout
                </a>
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
                        <div class="notification">
                            <i class="bi bi-bell"></i>
                            <span class="badge">3</span>
                        </div>

                        {{-- PROFILE --}}
                        <div class="profile d-flex align-items-center gap-2">
                            <div class="avatar">A</div>
                            <div>
                                <strong>Admin</strong><br>
                                <small>Super Admin</small>
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

</body>

</html>
