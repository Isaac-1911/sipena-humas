@php
    use Illuminate\Support\Str;
@endphp

@extends('layouts.public')

@section('title', 'Berita')

@section('content')

<section class="news-page">

    <div class="news-hero">
        <div class="container">
            <div class="news-hero-content">
                <span class="hero-badge">Berita</span>
                <h1>Informasi Terkini</h1>
                <p>Berita dan kegiatan resmi Humas Polres Jember</p>
            </div>
        </div>
    </div>

    <div class="news-main">
        <div class="container">

            @if($featuredNews)
            <div class="featured-wrapper">
                <a href="{{ route('news.show', $featuredNews->slug) }}" class="featured-link">
                    <div class="featured-item">
                        <div class="featured-image">
                            <img src="{{ asset('storage/' . $featuredNews->thumbnail) }}" alt="{{ $featuredNews->title }}">
                        </div>
                        <div class="featured-info">
                            <span class="featured-tag">Utama</span>
                            <h2>{{ $featuredNews->title }}</h2>
                            <p>{{ Str::limit(strip_tags($featuredNews->content), 130) }}</p>
                            <div class="featured-date">
                                <i class="bi bi-calendar3"></i>
                                <span>{{ $featuredNews->created_at?->format('d M Y') }}</span>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            @endif

            <div class="news-header">
                <h3>Semua Berita</h3>
                <span class="news-count">{{ $news->total() }} berita</span>
            </div>

            <div class="news-list">
                @foreach($news as $item)
                <div class="news-item">
                    <a href="{{ route('news.show', $item->slug) }}" class="news-link">
                        <div class="news-thumb">
                            @if($item->thumbnail)
                                <img src="{{ asset('storage/' . $item->thumbnail) }}" alt="{{ $item->title }}">
                            @else
                                <div class="thumb-placeholder">
                                    <i class="bi bi-image"></i>
                                </div>
                            @endif
                        </div>
                        <div class="news-detail">
                            <div class="news-date">
                                <i class="bi bi-calendar3"></i>
                                <span>{{ $item->created_at?->format('d M Y') }}</span>
                            </div>
                            <h4>{{ Str::limit($item->title, 70) }}</h4>
                            <p>{{ Str::limit(strip_tags($item->content), 110) }}</p>
                            <div class="news-read">
                                <span>Selengkapnya</span>
                                <i class="bi bi-arrow-right"></i>
                            </div>
                        </div>
                    </a>
                </div>
                @endforeach
            </div>

            <div class="news-pagination">
                {{ $news->links() }}
            </div>

        </div>
    </div>

</section>

@endsection
