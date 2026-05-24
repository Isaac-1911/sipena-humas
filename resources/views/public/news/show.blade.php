@extends('layouts.public')

@section('title', $news->title)

@section('content')

<section class="news-detail-section">

    <div class="news-detail-hero">

        @if($news->thumbnail)
            <div class="hero-background">
                <div class="hero-bg-image" style="background-image: url('{{ asset('storage/' . $news->thumbnail) }}');"></div>
            </div>
        @else
            <div class="hero-background">
                <div class="hero-bg-image" style="background-image: url('{{ asset('images/default-news.jpg') }}');"></div>
            </div>
        @endif

        <div class="hero-overlay"></div>

        <div class="container">
            <div class="row">
                <div class="col-lg-10 mx-auto">
                    <div class="news-detail-content">
                        <div class="detail-breadcrumb">
                            <a href="{{ url('/') }}">Beranda</a>
                            <i class="bi bi-chevron-right"></i>
                            <a href="{{ url('/berita') }}">Berita</a>
                            <i class="bi bi-chevron-right"></i>
                            <span>{{ Str::limit($news->slug, 50) }}</span>
                        </div>

                        <h1>{{ $news->title }}</h1>
                        <div class="detail-meta">
                            <div class="meta-item">
                                <i class="bi bi-calendar3"></i>
                                <span>{{ $news->created_at?->isoFormat('dddd, D MMMM YYYY') ?? '-' }}</span>
                            </div>
                            <div class="meta-item">
                                <i class="bi bi-clock"></i>
                                <span>{{ $news->created_at?->format('H:i') }} WIB</span>
                            </div>
                            <div class="meta-item">
                                <i class="bi bi-person-badge"></i>
                                <span>Humas Polres Jember</span>
                            </div>
                            <div class="meta-item">
                                <i class="bi bi-eye"></i>
                                <span>{{ number_format($news->views ?? 0) }} kali dibaca</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <div class="news-detail-body">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="news-content-wrapper">
                        <article class="news-article">
                            {!! $news->content !!}
                        </article>

                        <div class="news-footer">
                            <div class="footer-left">
                                <div class="update-info">
                                    <i class="bi bi-pencil-square"></i>
                                    <span>Diperbarui: {{ $news->updated_at?->isoFormat('D MMMM YYYY, HH:mm') ?? $news->created_at?->isoFormat('D MMMM YYYY, HH:mm') }} WIB</span>
                                </div>
                            </div>
                            <div class="footer-right">
                                <div class="share-buttons">
                                    <span class="share-label">Bagikan:</span>
                                    <a href="#" class="share-btn" onclick="shareFacebook(); return false;">
                                        <i class="bi bi-facebook"></i>
                                    </a>
                                    <a href="#" class="share-btn" onclick="shareTwitter(); return false;">
                                        <i class="bi bi-twitter-x"></i>
                                    </a>
                                    <a href="#" class="share-btn" onclick="shareWhatsApp(); return false;">
                                        <i class="bi bi-whatsapp"></i>
                                    </a>
                                    <a href="#" class="share-btn" onclick="copyLink(); return false;">
                                        <i class="bi bi-link-45deg"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</section>

@endsection

@push('scripts')
<script>
function shareFacebook() {
    window.open('https://www.facebook.com/sharer/sharer.php?u=' + encodeURIComponent(window.location.href), '_blank', 'width=600,height=400');
}
function shareTwitter() {
    window.open('https://twitter.com/intent/tweet?text={{ $news->title }}&url=' + encodeURIComponent(window.location.href), '_blank', 'width=600,height=400');
}
function shareWhatsApp() {
    window.open('https://wa.me/?text=' + encodeURIComponent('{{ $news->title }} ' + window.location.href), '_blank');
}
function copyLink() {
    navigator.clipboard.writeText(window.location.href).then(() => {
        alert('Link berita berhasil disalin!');
    });
}
</script>
@endpush
