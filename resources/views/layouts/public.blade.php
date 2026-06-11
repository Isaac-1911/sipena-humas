<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>@yield('title', 'SIPENA HUMAS')</title>

    {{-- Bootstrap --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    {{-- Google Font --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    {{-- Bootstrap Icons --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    {{-- Public CSS --}}
    <link rel="stylesheet" href="{{ asset('css/public.css') }}?v={{ filemtime(public_path('css/public.css')) }}">

    {{-- Favicon --}}
    <link rel="icon" type="image/png" href="{{ asset('images/humas-polri.png') }}">
</head>

<body class="@yield('body-class')">

    {{-- Navbar --}}
    @include('partials.navbar')

    {{-- Main Content --}}
    <main>
        @yield('content')
    </main>

    {{-- Bootstrap JS --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    {{-- Public JS --}}
    <script src="{{ asset('js/public.js') }}"></script>

    {{-- FOOTER --}}
    <footer class="main-footer">

        <div class="container">

            <div class="footer-top">

                <div class="row g-5">

                    {{-- BRAND --}}
                    <div class="col-lg-3">

                        <div class="footer-brand">

                            <div class="footer-logo">

                                <img src="{{ asset('images/humas-polri.png') }}" alt="Logo">

                            </div>

                            <div>

                                <h4>
                                    SIPENA HUMAS
                                </h4>

                                <span>
                                    Polres Jember
                                </span>

                            </div>

                        </div>

                        <p class="footer-desc">
                            Sistem Informasi dan Pelayanan Nasional Hubungan
                            Masyarakat Polres Jember.
                        </p>

                        <div class="footer-socials">

                            <a href="#">
                                <i class="bi bi-facebook"></i>
                            </a>

                            <a href="#">
                                <i class="bi bi-twitter-x"></i>
                            </a>

                            <a href="#">
                                <i class="bi bi-instagram"></i>
                            </a>

                            <a href="#">
                                <i class="bi bi-youtube"></i>
                            </a>

                        </div>

                    </div>

                    {{-- NAVIGATION --}}
                    <div class="col-lg-2">

                        <h5 class="footer-title">
                            Navigasi
                        </h5>

                        <ul class="footer-links">

                            <li>
                                <a href="#">Beranda</a>
                            </li>

                            <li>
                                <a href="#news">Berita</a>
                            </li>

                            <li>
                                <a href="#services">Layanan</a>
                            </li>

                            <li>
                                <a href="#contacts">Kontak</a>
                            </li>

                        </ul>

                    </div>

                    {{-- SERVICES --}}
                    {{-- <div class="col-lg-3">

                        <h5 class="footer-title">
                            Layanan
                        </h5>

                        <ul class="footer-links">

                            <li>
                                <a href="#">SKCK</a>
                            </li>

                            <li>
                                <a href="#">SIM</a>
                            </li>

                            <li>
                                <a href="#">Laporan Kehilangan</a>
                            </li>

                            <li>
                                <a href="#">Pengamanan</a>
                            </li>

                            <li>
                                <a href="#">Konsultasi Hukum</a>
                            </li>

                            <li>
                                <a href="#">Call Center 110</a>
                            </li>

                        </ul>

                    </div> --}}

                    {{-- CONTACT --}}
                    <div class="col-lg-4">

                        <h5 class="footer-title">
                            Kontak
                        </h5>

                        <div class="footer-contact-list">

                            <div class="footer-contact-item">

                                <i class="bi bi-geo-alt"></i>

                                <span>
                                    Jl. Kartini No. 1, Jember, Jawa Timur
                                </span>

                            </div>

                            <div class="footer-contact-item">

                                <i class="bi bi-telephone"></i>

                                <span>
                                    110 | (0331) 411-910
                                </span>

                            </div>

                            <div class="footer-contact-item">

                                <i class="bi bi-envelope"></i>

                                <span>
                                    humas@polresjember.go.id
                                </span>

                            </div>

                            <div class="footer-contact-item">

                                <i class="bi bi-clock"></i>

                                <span>
                                    Senin–Jumat, 07.00–15.30
                                </span>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

            {{-- BOTTOM --}}
            <div class="footer-bottom">

                <p>
                    © 2026 SIPENA HUMAS Polres Jember.
                    Hak Cipta Dilindungi.
                </p>

                <div class="footer-bottom-links">

                    <a href="#">
                        Kebijakan Privasi
                    </a>

                    <a href="#">
                        Syarat & Ketentuan
                    </a>

                </div>

            </div>

        </div>

    </footer>

    {{-- FEEDBACK FLOATING BUTTON --}}
    <button class="feedback-float-btn" data-bs-toggle="modal" data-bs-target="#feedbackModal">

        <i class="bi bi-chat-dots-fill"></i>

    </button>

    {{-- FEEDBACK MODAL --}}
    <div class="modal fade" id="feedbackModal" tabindex="-1" aria-hidden="true">

        <div class="modal-dialog modal-dialog-centered">

            <div class="modal-content feedback-modal">

                {{-- HANDLE --}}
                <div class="feedback-handle"></div>

                <div class="feedback-body">

                    {{-- TITLE --}}
                    <h3>
                        Seberapa puas Anda dengan layanan SIPENA?
                    </h3>

                    <form action="" id="feedback-form">
                        <input type="hidden" name="rating" id="selectedRating" value="baik">
                        <input type="hidden" name="improvements" id="selectedImprovements">

                        {{-- EMOJI OPTIONS --}}
                        <div class="feedback-rating-grid">

                            <button type="button" class="feedback-rating-item active" data-rating="buruk">
                                <span>😞</span>
                                <small>Buruk</small>
                            </button>

                            <button type="button" class="feedback-rating-item" data-rating="cukup">
                                <span>😐</span>
                                <small>Cukup</small>
                            </button>

                            <button type="button" class="feedback-rating-item active" data-rating="baik">
                                <span>🙂</span>
                                <small>Baik</small>
                            </button>

                            <button type="button" class="feedback-rating-item" data-rating="bagus">
                                <span>😁</span>
                                <small>Bagus</small>
                            </button>

                            <button type="button" class="feedback-rating-item" data-rating="luar-biasa">
                                <span>😍</span>
                                <small>Luar Biasa</small>
                            </button>

                        </div>

                        {{-- CATEGORY --}}
                        <div class="feedback-section">

                            <label>
                                Layanan Yang Digunakan
                            </label>

                            <select class="form-select">

                                <option>
                                    Pilih Layanan
                                </option>

                                <option>
                                    SKCK
                                </option>

                                <option>
                                    SIM
                                </option>

                                <option>
                                    Pengaduan
                                </option>

                                <option>
                                    Pengawalan
                                </option>

                            </select>

                        </div>

                        {{-- IMPROVEMENT --}}
                        <div class="feedback-section">

                            <label>
                                Apa yang perlu ditingkatkan?
                            </label>

                            <div class="feedback-tags">

                                <button type="button" class="feedback-tag">
                                    Tampilan
                                </button>
                                <button type="button" class="feedback-tag">Kecepatan</button>
                                <button type="button" class="feedback-tag">Informasi</button>
                                <button type="button" class="feedback-tag">Pelayanan</button>
                                <button type="button" class="feedback-tag">Fitur</button>

                            </div>

                        </div>

                        {{-- TEXTAREA --}}
                        <div class="feedback-section">

                            <label>
                                Saran dan Masukan
                            </label>

                            <textarea class="form-control" rows="4" placeholder="Tulis saran Anda..."></textarea>

                        </div>

                        {{-- SUBMIT --}}
                        <button type="submit" class="feedback-submit-btn">

                            <i class="bi bi-send"></i>

                            Kirim Feedback

                        </button>

                </div>

                </form>

            </div>

        </div>

    </div>
</body>

</html>
