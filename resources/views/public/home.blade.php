@php
    use Illuminate\Support\Str;
@endphp

@extends('layouts.public')

@section('title', 'SIPENA HUMAS')

@section('body-class', 'homepage')

@section('content')

    <section class="hero-section" id="#hero-section">

        {{-- Background Overlay --}}
        <div class="hero-overlay"></div>

        <div class="container">

            <div class="hero-content">

                {{-- Badge --}}
                <div class="hero-badge">
                    <i class="bi bi-shield-check"></i>
                    Sistem Informasi Pelayanan & Pengaduan
                </div>

                {{-- Heading --}}
                <h1>
                    SIPENA HUMAS <br>
                    Polres Jember
                </h1>

                {{-- Description --}}
                <p>
                    Portal resmi pelayanan informasi, berita, arsip dokumentasi,
                    dan komunikasi publik Polres Jember yang modern, transparan,
                    dan terintegrasi.
                </p>

                {{-- Buttons --}}
                <div class="hero-buttons">

                    <a href="/news" class="btn btn-hero-primary">
                        Lihat Berita
                    </a>

                </div>

            </div>

        </div>

    </section>

    {{-- NEWS SECTION --}}
    <section class="news-section" id="news">

        <div class="container">

            {{-- Section Header --}}
            <div class="section-header">

                <div>
                    <span class="section-badge">
                        Informasi Terkini
                    </span>

                    <h2>
                        Berita Terbaru
                    </h2>

                    <p>
                        Informasi terkini seputar kegiatan Polres Jember
                    </p>
                </div>

                <a href="/news" class="section-link">
                    Lihat Semua
                    <i class="bi bi-arrow-right-short"></i>
                </a>

            </div>

            {{-- News Grid --}}
            <div class="row g-4">

                {{-- Featured News --}}
                <div class="col-lg-8">

                    @if ($featuredNews)
                        <div class="featured-news-card">

                            {{-- Thumbnail --}}
                            <div class="featured-news-image">

                                <img src="{{ asset('storage/' . $featuredNews->thumbnail) }}"
                                    alt="{{ $featuredNews->title }}">

                                <span class="news-category">
                                    Berita
                                </span>

                            </div>

                            {{-- Content --}}
                            <div class="featured-news-content">

                                <div class="news-date">
                                    <i class="bi bi-calendar-event"></i>

                                    {{ $featuredNews->created_at->format('Y-m-d') }}
                                </div>

                                <h3>
                                    {{ $featuredNews->title }}
                                </h3>

                                <p>
                                    {{ Str::limit(strip_tags($featuredNews->content), 140) }}
                                </p>

                                <a href="{{ route('news.show', $featuredNews->slug) }}" class="read-more">

                                    Baca Selengkapnya

                                    <i class="bi bi-arrow-right-short"></i>

                                </a>

                            </div>

                        </div>
                    @endif

                </div>

                {{-- Side News --}}
                <div class="col-lg-4">

                    <div class="side-news-wrapper">

                        @foreach ($sideNews as $news)
                            <a href="{{ route('news.show', $news->slug) }}" class="side-news-card text-decoration-none">

                                <img src="{{ asset('storage/' . $news->thumbnail) }}" alt="{{ $news->title }}">

                                <div class="side-news-content">

                                    <span class="side-news-category">
                                        Berita
                                    </span>

                                    <h4>
                                        {{ Str::limit($news->title, 55) }}
                                    </h4>

                                    <div class="side-news-date">
                                        <i class="bi bi-calendar-event"></i>

                                        {{ $news->created_at?->format('Y-m-d') ?? '-' }}
                                    </div>

                                </div>

                            </a>
                        @endforeach

                        {{-- Button --}}
                        <a href="{{ route('news.index') }}" class="all-news-button">

                            Lihat Semua Berita

                            <i class="bi bi-arrow-right-short"></i>

                        </a>

                    </div>

                </div>

            </div>

        </div>

    </section>

    {{-- @include('public.services') --}}

    {{-- CONTACT SECTION --}}
    <section class="contact-section" id="contacts">

        <div class="container">

            <div class="row g-4 align-items-start">

                {{-- LEFT --}}
                <div class="col-lg-6">

                    <div class="contact-info">

                        <span class="section-badge">
                            Hubungi Kami
                        </span>

                        <h2>
                            Kontak Polres Jember
                        </h2>

                        <p>
                            Sampaikan pertanyaan, laporan, atau aspirasi Anda
                            kepada kami. Tim Humas Polres Jember siap membantu.
                        </p>

                        {{-- Item --}}
                        <div class="contact-list">

                            <div class="contact-item">

                                <div class="contact-icon">
                                    <i class="bi bi-geo-alt"></i>
                                </div>

                                <div>
                                    <span>Alamat</span>

                                    <strong>
                                        Jl. Kartini No. 1, Jember, Jawa Timur
                                    </strong>
                                </div>

                            </div>

                            <div class="contact-item">

                                <div class="contact-icon">
                                    <i class="bi bi-telephone"></i>
                                </div>

                                <div>
                                    <span>Call Center</span>

                                    <strong>
                                        110 (Darurat)
                                    </strong>
                                </div>

                            </div>

                            <div class="contact-item">

                                <div class="contact-icon">
                                    <i class="bi bi-envelope"></i>
                                </div>

                                <div>
                                    <span>Email</span>

                                    <strong>
                                        operatorhumasjember@gmail.com
                                    </strong>
                                </div>

                            </div>

                        </div>

                    </div>

                </div>

                {{-- RIGHT --}}
                <div class="col-lg-6">

                    <div class="contact-form-card">

                        <h3>
                            Kirim Pesan
                        </h3>

                        @if (session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif

                        <form action="{{ route('contact.store') }}" method="POST">

                            @csrf

                            <div class="row g-3">

                                <div class="col-md-6">

                                    <label class="form-label">
                                        Nama Lengkap
                                    </label>

                                    <input type="text" name="name" class="form-control" placeholder="Nama Anda"
                                        required>

                                </div>

                                <div class="col-md-6">

                                    <label class="form-label">
                                        Email
                                    </label>

                                    <input type="email" name="email" class="form-control" placeholder="email@contoh.com"
                                        required>

                                </div>

                                <div class="col-12">

                                    <label class="form-label">
                                        Subjek
                                    </label>

                                    <input type="text" name="subject" class="form-control" placeholder="Subjek pesan"
                                        required>

                                </div>

                                <div class="col-12">

                                    <label class="form-label">
                                        Pesan
                                    </label>

                                    <textarea name="message" rows="5" class="form-control" placeholder="Tulis pesan Anda di sini..." required></textarea>

                                </div>

                                <div class="col-12">

                                    <button type="submit" class="contact-submit-btn">

                                        <i class="bi bi-send"></i>

                                        Kirim Pesan

                                    </button>

                                </div>

                            </div>

                        </form>

                    </div>

                </div>

            </div>

        </div>

    </section>

@endsection
