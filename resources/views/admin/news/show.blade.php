@extends('layouts.admin')

@section('content')

<div class="news-detail-container" data-aos="fade-up">

    {{-- BACK BUTTON --}}
    <div class="mb-4">
        <a href="{{ route('admin.news.index') }}" class="back-button">
            <i class="bi bi-arrow-left-circle"></i>
            <span>Kembali ke Daftar Berita</span>
        </a>
    </div>

    {{-- NEWS DETAIL CARD --}}
    <div class="news-detail-card">

        {{-- THUMBNAIL SECTION --}}
        @if($news->thumbnail && file_exists(storage_path('app/public/'.$news->thumbnail)))
            <div class="news-detail-thumbnail">
                <img src="{{ asset('storage/'.$news->thumbnail) }}" alt="{{ $news->title }}">
                <div class="thumbnail-overlay"></div>
            </div>
        @else
            <div class="news-detail-thumbnail placeholder">
                <div class="thumbnail-placeholder-content">
                    <i class="bi bi-image"></i>
                    <p>Tidak ada gambar untuk berita ini</p>
                </div>
            </div>
        @endif

        {{-- CONTENT SECTION --}}
        <div class="news-detail-content">

            {{-- META INFORMATION --}}
            <div class="news-detail-meta">
                <div class="meta-item">
                    <i class="bi bi-calendar3"></i>
                    <span>{{ \Carbon\Carbon::parse($news->created_at)->translatedFormat('l, d F Y') }}</span>
                </div>
                <div class="meta-item">
                    <i class="bi bi-clock"></i>
                    <span>{{ \Carbon\Carbon::parse($news->created_at)->format('H:i') }} WIB</span>
                </div>
                <div class="meta-item">
                    <i class="bi bi-tag"></i>
                    <span>Berita Polres Jember</span>
                </div>
                @if($news->updated_at != $news->created_at)
                    <div class="meta-item">
                        <i class="bi bi-pencil-square"></i>
                        <span>Diperbarui: {{ \Carbon\Carbon::parse($news->updated_at)->translatedFormat('d F Y') }}</span>
                    </div>
                @endif
            </div>

            {{-- TITLE --}}
            <h1 class="news-detail-title">{{ $news->title }}</h1>

            {{-- DIVIDER --}}
            <div class="news-detail-divider"></div>

            {{-- CONTENT --}}
            <div class="news-detail-body">
                {!! $news->content !!}
            </div>

            {{-- ACTION BUTTONS --}}
            <div class="news-detail-actions">
                <a href="{{ route('admin.news.edit', $news->id) }}" class="action-btn edit-btn-large">
                    <i class="bi bi-pencil-square"></i>
                    Edit Berita
                </a>

                <form action="{{ route('admin.news.destroy', $news->id) }}"
                      method="POST"
                      class="d-inline"
                      onsubmit="return confirmDelete(event)">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="action-btn delete-btn-large">
                        <i class="bi bi-trash3"></i>
                        Hapus Berita
                    </button>
                </form>
            </div>

        </div>

    </div>

    {{-- RELATED NEWS SECTION (Opsional) --}}
    @php
        $relatedNews = \App\Models\News::where('id', '!=', $news->id)
                                        ->latest()
                                        ->take(3)
                                        ->get();
    @endphp

    @if($relatedNews->count() > 0)
        <div class="related-news-section" data-aos="fade-up" data-aos-delay="100">
            <h3 class="related-news-title">
                <i class="bi bi-newspaper"></i>
                Berita Lainnya
            </h3>

            <div class="row g-4">
                @foreach($relatedNews as $related)
                    <div class="col-md-4">
                        <div class="related-news-card">
                            @if($related->thumbnail && file_exists(storage_path('app/public/'.$related->thumbnail)))
                                <div class="related-news-image">
                                    <img src="{{ asset('storage/'.$related->thumbnail) }}" alt="{{ $related->title }}">
                                </div>
                            @else
                                <div class="related-news-image placeholder-small">
                                    <i class="bi bi-image"></i>
                                </div>
                            @endif

                            <div class="related-news-content">
                                <h6>{{ Str::limit($related->title, 50) }}</h6>
                                <small class="text-muted">
                                    {{ \Carbon\Carbon::parse($related->created_at)->translatedFormat('d F Y') }}
                                </small>
                                <a href="{{ route('admin.news.show', $related->id) }}" class="read-more-link">
                                    Baca Selengkapnya
                                    <i class="bi bi-arrow-right"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif

</div>

@endsection

@section('scripts')
<script>
    // Confirm delete function
    function confirmDelete(event) {
        const result = confirm('Apakah Anda yakin ingin menghapus berita ini? Tindakan ini tidak dapat dibatalkan.');
        if (!result) {
            event.preventDefault();
            return false;
        }
        return true;
    }

    // Add animation to content images
    document.addEventListener('DOMContentLoaded', function() {
        const contentImages = document.querySelectorAll('.news-detail-body img');
        contentImages.forEach(img => {
            img.classList.add('content-image');
            img.setAttribute('loading', 'lazy');
        });

        // Make all links in content open in new tab
        const contentLinks = document.querySelectorAll('.news-detail-body a');
        contentLinks.forEach(link => {
            if (link.href && !link.href.startsWith(window.location.origin)) {
                link.setAttribute('target', '_blank');
                link.setAttribute('rel', 'noopener noreferrer');
            }
        });
    });
</script>
@endsection
