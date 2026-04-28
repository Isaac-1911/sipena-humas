@extends('layouts.admin')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4" data-aos="fade-up">
    <div>
        <h4 class="mb-1" style="color: var(--primary);">
            <i class="bi bi-newspaper me-2"></i>
            Manajemen Berita
        </h4>
        <small class="text-muted">
            <i class="bi bi-database"></i> {{ $news->total() }} berita tersedia
        </small>
    </div>

    <button onclick="openModal()"
        class="btn btn-primary"
        style="background: linear-gradient(135deg, var(--primary) 0%, var(--primary-light) 100%); border: none; padding: 10px 24px; border-radius: 12px;">
        <i class="bi bi-plus-circle me-2"></i>
        Tambah Berita
    </button>
</div>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert" data-aos="fade-down">
        <i class="bi bi-check-circle me-2"></i>
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert" data-aos="fade-down">
        <i class="bi bi-exclamation-triangle me-2"></i>
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<div class="row g-4">
    @forelse($news as $item)
        <div class="col-12 col-sm-6 col-lg-4" data-aos="fade-up" data-aos-delay="{{ $loop->iteration * 50 }}">
            <div class="news-card">
                {{-- THUMBNAIL --}}
                <div class="news-thumbnail">
                    @if($item->thumbnail && file_exists(storage_path('app/public/'.$item->thumbnail)))
                        <img src="{{ asset('storage/'.$item->thumbnail) }}" alt="{{ $item->title }}">
                    @else
                        <div class="thumbnail-placeholder">
                            <i class="bi bi-image"></i>
                            <span>Tidak ada gambar</span>
                        </div>
                    @endif

                    @if($item->is_featured ?? false)
                        <span class="featured-badge">
                            <i class="bi bi-star-fill"></i> Featured
                        </span>
                    @endif
                </div>

                {{-- CONTENT --}}
                <div class="news-content">
                    <div class="news-meta">
                        <span class="news-date">
                            <i class="bi bi-calendar3"></i>
                            {{ \Carbon\Carbon::parse($item->created_at)->translatedFormat('d F Y') }}
                        </span>
                        <span class="news-category">
                            <i class="bi bi-tag"></i>
                            Berita
                        </span>
                    </div>

                    <h6 class="news-title">
                        {{ Str::limit($item->title, 60) }}
                    </h6>

                    <p class="news-excerpt">
                        {{ Str::limit(strip_tags($item->content), 100) }}
                    </p>

                    <div class="news-actions">
                        <a href="{{ route('admin.news.show', $item->id) }}"
                           class="action-btn view-btn"
                           title="Lihat Detail">
                            <i class="bi bi-eye"></i>
                            <span>Lihat</span>
                        </a>

                        <a href="{{ route('admin.news.edit', $item->id) }}"
                           class="action-btn edit-btn"
                           title="Edit Berita">
                            <i class="bi bi-pencil-square"></i>
                            <span>Edit</span>
                        </a>

                        <form action="{{ route('admin.news.destroy', $item->id) }}"
                              method="POST"
                              class="d-inline"
                              onsubmit="return confirmDelete()">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="action-btn delete-btn" title="Hapus Berita">
                                <i class="bi bi-trash3"></i>
                                <span>Hapus</span>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @empty
        <div class="col-12" data-aos="fade-up">
            <div class="empty-state-full">
                <div class="empty-state-icon">
                    <i class="bi bi-newspaper"></i>
                </div>
                <h5>Belum Ada Berita</h5>
                <p>Mulai tambahkan berita pertama Anda untuk mengisi konten website</p>
                <button onclick="openModal()" class="btn btn-primary mt-3">
                    <i class="bi bi-plus-circle me-2"></i>
                    Tambah Berita Pertama
                </button>
            </div>
        </div>
    @endforelse
</div>

{{-- PAGINATION --}}
@if($news->hasPages())
    <div class="mt-5" data-aos="fade-up">
        <div class="custom-pagination">
            {{ $news->links() }}
        </div>
    </div>
@endif

{{-- MODAL TAMBAH BERITA --}}
<div id="newsModal" class="modal-overlay d-none">
    <div class="modal-container">
        <div class="modal-header">
            <h5 class="modal-title">
                <i class="bi bi-plus-circle me-2"></i>
                Tambah Berita Baru
            </h5>
            <button type="button" class="modal-close" onclick="closeModal()">
                <i class="bi bi-x-lg"></i>
            </button>
        </div>

        <form action="{{ route('admin.news.store') }}" method="POST" enctype="multipart/form-data" id="newsForm">
            @csrf

            <div class="modal-body">
                <div class="form-group">
                    <label for="thumbnail" class="form-label">
                        <i class="bi bi-image me-1"></i>
                        Thumbnail
                    </label>
                    <div class="thumbnail-upload" onclick="document.getElementById('thumbnailInput').click()">
                        <input type="file"
                               name="image"
                               id="thumbnailInput"
                               class="d-none"
                               accept="image/*"
                               onchange="previewThumbnail(this)">
                        <div class="upload-placeholder" id="uploadPlaceholder">
                            <i class="bi bi-cloud-upload" style="font-size: 40px;"></i>
                            <p>Klik untuk upload gambar</p>
                            <small>Format: JPG, PNG, GIF (Max 2MB)</small>
                        </div>
                        <div class="upload-preview d-none" id="uploadPreview">
                            <img id="thumbnailPreview" src="" alt="Preview">
                            <button type="button" class="remove-image" onclick="removeThumbnail()">
                                <i class="bi bi-x-circle"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="title" class="form-label">
                        <i class="bi bi-fonts me-1"></i>
                        Judul Berita <span class="text-danger">*</span>
                    </label>
                    <input type="text"
                           name="title"
                           id="title"
                           class="form-control modern-input"
                           placeholder="Masukkan judul berita"
                           required>
                    <small class="form-text text-muted">Maksimal 100 karakter</small>
                </div>

                <div class="form-group">
                    <label for="content" class="form-label">
                        <i class="bi bi-file-text me-1"></i>
                        Konten Berita <span class="text-danger">*</span>
                    </label>
                    <textarea name="content"
                              id="content"
                              class="form-control modern-textarea"
                              rows="6"
                              placeholder="Tulis konten berita di sini..."
                              required></textarea>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-light" onclick="closeModal()">
                    <i class="bi bi-x-circle me-1"></i>
                    Batal
                </button>
                <button type="submit" class="btn btn-primary" style="background: var(--primary);">
                    <i class="bi bi-save me-1"></i>
                    Simpan Berita
                </button>
            </div>
        </form>
    </div>
</div>

@endsection

@push('scripts')
<script>
function openModal() {
    document.getElementById('newsModal').classList.remove('d-none');
    document.body.style.overflow = 'hidden';
}

function closeModal() {
    document.getElementById('newsModal').classList.add('d-none');
    document.body.style.overflow = '';
    resetForm();
}

function resetForm() {
    document.getElementById('newsForm').reset();
    removeThumbnail();
}

function previewThumbnail(input) {
    const preview = document.getElementById('thumbnailPreview');
    const placeholder = document.getElementById('uploadPlaceholder');
    const previewDiv = document.getElementById('uploadPreview');

    if (input.files && input.files[0]) {
        const reader = new FileReader();

        reader.onload = function(e) {
            preview.src = e.target.result;
            placeholder.classList.add('d-none');
            previewDiv.classList.remove('d-none');
        }

        reader.readAsDataURL(input.files[0]);
    }
}

function removeThumbnail() {
    const input = document.getElementById('thumbnailInput');
    const placeholder = document.getElementById('uploadPlaceholder');
    const previewDiv = document.getElementById('uploadPreview');

    input.value = '';
    placeholder.classList.remove('d-none');
    previewDiv.classList.add('d-none');
}

function confirmDelete() {
    return confirm('Apakah Anda yakin ingin menghapus berita ini? Tindakan ini tidak dapat dibatalkan.');
}

// Close modal when clicking outside
document.getElementById('newsModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeModal();
    }
});

// Form validation
document.getElementById('newsForm').addEventListener('submit', function(e) {
    const title = document.getElementById('title').value.trim();
    const content = document.getElementById('content').value.trim();

    if (!title) {
        e.preventDefault();
        alert('Judul berita wajib diisi');
        return false;
    }

    if (title.length > 100) {
        e.preventDefault();
        alert('Judul berita maksimal 100 karakter');
        return false;
    }

    if (!content) {
        e.preventDefault();
        alert('Konten berita wajib diisi');
        return false;
    }
});

// Auto-hide alert after 5 seconds
setTimeout(function() {
    const alerts = document.querySelectorAll('.alert');
    alerts.forEach(function(alert) {
        const bsAlert = new bootstrap.Alert(alert);
        setTimeout(function() {
            bsAlert.close();
        }, 5000);
    });
}, 1000);
</script>
@endpush
