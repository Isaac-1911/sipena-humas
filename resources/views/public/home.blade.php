@php
  use Illuminate\Support\Str;
@endphp

@extends('layouts.public')

@section('title', 'SIPENA HUMAS')

@section('body-class', 'homepage')

@section('content')

    <section class="hero-section">

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

                    <a href="/archives" class="btn btn-hero-secondary">
                        Arsip Dokumentasi
                    </a>

                </div>

            </div>

        </div>

    </section>

    {{-- NEWS SECTION --}}
    <section class="news-section">

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

    <section style="height: 100vh; background: white;">
    </section>

@endsection
