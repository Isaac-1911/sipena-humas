@extends('layouts.admin')

@section('content')

<div class="archive-container" data-aos="fade-up">

    {{-- HEADER --}}
    <div class="archive-header">
        <div>
            <h4 class="archive-title">
                <i class="bi bi-archive me-2"></i>
                Manajemen Arsip
            </h4>
            <p class="archive-subtitle">
                <i class="bi bi-database"></i> {{ $archives->total() }} file tersimpan
            </p>
        </div>
        <button type="button" id="openArchiveModalBtn" class="btn-upload">
            <i class="bi bi-cloud-upload me-2"></i>
            Unggah Arsip
        </button>
    </div>

    {{-- ALERTS --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert" style="border-radius: 16px; background: linear-gradient(135deg, #D1FAE5 0%, #A7F3D0 100%); border: none; color: #065F46;">
            <div class="d-flex align-items-center gap-2">
                <i class="bi bi-check-circle-fill" style="font-size: 20px;"></i>
                <div class="flex-grow-1">{{ session('success') }}</div>
                <button type="button" class="btn-close" onclick="this.closest('.alert').remove()" style="filter: brightness(0) invert(0); opacity: 0.6;"></button>
            </div>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert" style="border-radius: 16px; background: linear-gradient(135deg, #FEE2E2 0%, #FECACA 100%); border: none; color: #991B1B;">
            <div class="d-flex align-items-center gap-2">
                <i class="bi bi-exclamation-triangle-fill" style="font-size: 20px;"></i>
                <div class="flex-grow-1">{{ session('error') }}</div>
                <button type="button" class="btn-close" onclick="this.closest('.alert').remove()" style="filter: brightness(0) invert(0); opacity: 0.6;"></button>
            </div>
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert" style="border-radius: 16px; background: linear-gradient(135deg, #FEE2E2 0%, #FECACA 100%); border: none; color: #991B1B;">
            <div class="d-flex align-items-start gap-2">
                <i class="bi bi-exclamation-triangle-fill" style="font-size: 20px;"></i>
                <div class="flex-grow-1">
                    <strong>Terjadi kesalahan:</strong>
                    <ul class="mb-0 mt-2">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                <button type="button" class="btn-close" onclick="this.closest('.alert').remove()" style="filter: brightness(0) invert(0); opacity: 0.6;"></button>
            </div>
        </div>
    @endif

    {{-- ARCHIVE GRID --}}
    <div class="row g-4">
        @forelse($archives as $archive)
            <div class="col-12 col-sm-6 col-lg-4" data-aos="fade-up" data-aos-delay="{{ $loop->iteration * 50 }}">
                <div class="archive-card">

                    {{-- THUMBNAIL --}}
                    <div class="archive-thumbnail">
                        @if($archive->category === 'image')
                            <img src="{{ asset('storage/' . $archive->file_path) }}" alt="{{ $archive->title }}">
                        @elseif($archive->category === 'video')
                            <div class="thumbnail-icon video">
                                <i class="bi bi-play-circle"></i>
                                <span>Video</span>
                            </div>
                        @elseif($archive->category === 'document')
                            <div class="thumbnail-icon document">
                                <i class="bi bi-file-earmark-text"></i>
                                <span>Document</span>
                            </div>
                        @else
                            <div class="thumbnail-icon default">
                                <i class="bi bi-file-earmark"></i>
                                <span>File</span>
                            </div>
                        @endif

                        {{-- BADGE --}}
                        <span class="archive-badge {{ $archive->category }}">
                            <i class="bi {{ $archive->category === 'image' ? 'bi-image' : ($archive->category === 'video' ? 'bi-camera-reels' : 'bi-file-earmark-text') }}"></i>
                            {{ ucfirst($archive->category) }}
                        </span>
                    </div>

                    {{-- CONTENT --}}
                    <div class="archive-content">
                        <div class="archive-meta">
                            <span class="archive-date">
                                <i class="bi bi-calendar3"></i>
                                {{ \Carbon\Carbon::parse($archive->created_at)->translatedFormat('d F Y') }}
                            </span>
                            <span class="archive-size">
                                <i class="bi bi-hdd-stack"></i>
                                {{ $archive->file_size ?? 'N/A' }}
                            </span>
                        </div>

                        <h6 class="archive-title-text">
                            {{ Str::limit($archive->title, 50) }}
                        </h6>

                        @if($archive->description)
                            <p class="archive-description">
                                {{ Str::limit($archive->description, 80) }}
                            </p>
                        @endif

                        <div class="archive-actions">
                            <a href="{{ asset('storage/' . $archive->file_path) }}"
                               target="_blank"
                               class="action-btn view-btn"
                               title="Lihat File">
                                <i class="bi bi-eye"></i>
                                <span>Lihat</span>
                            </a>

                            <a href="{{ route('admin.archive.edit', $archive->id) }}"
                               class="action-btn edit-btn"
                               title="Edit Arsip">
                                <i class="bi bi-pencil-square"></i>
                                <span>Edit</span>
                            </a>

                            <form action="{{ route('admin.archive.destroy', $archive->id) }}"
                                  method="POST"
                                  class="d-inline"
                                  onsubmit="return confirmDelete(event)">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="action-btn delete-btn" title="Hapus Arsip">
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
                        <i class="bi bi-archive"></i>
                    </div>
                    <h5>Belum Ada Arsip</h5>
                    <p>Mulai unggah arsip pertama Anda untuk menyimpan file penting</p>
                    <button type="button" id="openArchiveModalBtnEmpty" class="btn btn-primary mt-3">
                        <i class="bi bi-cloud-upload me-2"></i>
                        Unggah Arsip Pertama
                    </button>
                </div>
            </div>
        @endforelse
    </div>

    {{-- PAGINATION --}}
    @if($archives->hasPages())
        <div class="mt-5" data-aos="fade-up">
            <div class="custom-pagination">
                {{ $archives->links() }}
            </div>
        </div>
    @endif

</div>

{{-- MODAL UPLOAD ARSIP --}}
<div id="archiveModal" class="modal-overlay" style="display: none;">
    <div class="modal-container">
        <div class="modal-header">
            <h5 class="modal-title">
                <i class="bi bi-cloud-upload me-2"></i>
                Unggah Arsip Baru
            </h5>
            <button type="button" class="modal-close" id="closeModalBtn">
                <i class="bi bi-x-lg"></i>
            </button>
        </div>

        <form action="{{ route('admin.archive.store') }}" method="POST" enctype="multipart/form-data" id="archiveForm">
            @csrf

            <div class="modal-body">
                {{-- FILE UPLOAD --}}
                <div class="form-group">
                    <label for="file" class="form-label">
                        <i class="bi bi-file-earmark me-1"></i>
                        File Arsip <span class="text-danger">*</span>
                    </label>
                    <div class="file-upload-box" id="fileUploadBox">
                        <input type="file"
                               name="file"
                               id="fileInput"
                               class="d-none"
                               accept="image/*,video/*,.pdf,.doc,.docx,.xls,.xlsx,.txt"
                               required>
                        <div class="upload-placeholder-new" id="filePlaceholder">
                            <i class="bi bi-cloud-arrow-up"></i>
                            <p>Klik untuk pilih file</p>
                            <small>Maksimal 10MB | Format: JPG, PNG, PDF, DOC, XLS, MP4</small>
                        </div>
                        <div class="file-preview d-none" id="filePreview">
                            <i class="bi bi-file-earmark-check"></i>
                            <span id="fileName"></span>
                            {{-- <button type="button" class="remove-file" onclick="removeFile()">
                                <i class="bi bi-x-circle"></i>
                            </button> --}}
                        </div>
                    </div>
                    @error('file')
                        <div class="error-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- TITLE --}}
                <div class="form-group">
                    <label for="title" class="form-label">
                        <i class="bi bi-fonts me-1"></i>
                        Judul Arsip <span class="text-danger">*</span>
                    </label>
                    <input type="text"
                           name="title"
                           id="title"
                           class="modern-input"
                           placeholder="Masukkan judul arsip"
                           value="{{ old('title') }}"
                           required>
                    <small class="form-text text-muted">Maksimal 100 karakter</small>
                </div>

                {{-- CATEGORY --}}
                <div class="form-group">
                    <label for="category" class="form-label">
                        <i class="bi bi-tag me-1"></i>
                        Kategori <span class="text-danger">*</span>
                    </label>
                    <select name="category" id="category" class="modern-select" required>
                        <option value="">Pilih kategori</option>
                        <option value="image" {{ old('category') == 'image' ? 'selected' : '' }}>
                            <i class="bi bi-image"></i> Gambar
                        </option>
                        <option value="video" {{ old('category') == 'video' ? 'selected' : '' }}>
                            <i class="bi bi-camera-reels"></i> Video
                        </option>
                        <option value="document" {{ old('category') == 'document' ? 'selected' : '' }}>
                            <i class="bi bi-file-text"></i> Dokumen
                        </option>
                    </select>
                </div>

                {{-- DESCRIPTION --}}
                <div class="form-group">
                    <label for="description" class="form-label">
                        <i class="bi bi-chat-text me-1"></i>
                        Deskripsi (Opsional)
                    </label>
                    <textarea name="description"
                              id="description"
                              class="modern-textarea"
                              rows="4"
                              placeholder="Tulis deskripsi arsip di sini...">{{ old('description') }}</textarea>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-light" id="cancelModalBtn">
                    <i class="bi bi-x-circle me-1"></i>
                    Batal
                </button>
                <button type="submit" class="btn btn-primary" style="background: var(--primary);">
                    <i class="bi bi-cloud-upload me-1"></i>
                    Unggah Arsip
                </button>
            </div>
        </form>
    </div>
</div>

@endsection

@section('scripts')
<script>
    // DOM Elements
    const modal = document.getElementById('archiveModal');
    const openModalBtn = document.getElementById('openArchiveModalBtn');
    const openModalBtnEmpty = document.getElementById('openArchiveModalBtnEmpty');
    const closeModalBtn = document.getElementById('closeModalBtn');
    const cancelModalBtn = document.getElementById('cancelModalBtn');
    const fileInput = document.getElementById('fileInput');
    const fileUploadBox = document.getElementById('fileUploadBox');

    // Open Modal Function
    function openModal() {
        if (modal) {
            modal.style.display = 'flex';
            document.body.style.overflow = 'hidden';
        }
    }

    // Close Modal Function
    function closeModal() {
        if (modal) {
            modal.style.display = 'none';
            document.body.style.overflow = '';
            resetForm();
        }
    }

    // Reset Form
    function resetForm() {
        const form = document.getElementById('archiveForm');
        if (form) {
            form.reset();
        }
        removeFile();

        // Remove error messages
        document.querySelectorAll('.error-feedback').forEach(el => el.remove());

        // Reset input borders
        document.querySelectorAll('.modern-input, .modern-select, .modern-textarea').forEach(input => {
            input.style.borderColor = '#E5E7EB';
        });
    }

    // File Preview
    function previewFile(file) {
        const fileName = document.getElementById('fileName');
        const placeholder = document.getElementById('filePlaceholder');
        const previewDiv = document.getElementById('filePreview');

        if (file) {
            // Show file name
            if (fileName) {
                fileName.textContent = file.name;
            }

            // Hide placeholder, show preview
            if (placeholder) placeholder.classList.add('d-none');
            if (previewDiv) previewDiv.classList.remove('d-none');
        }
    }

    // Remove File
    function removeFile() {
        if (fileInput) {
            fileInput.value = '';
        }

        const placeholder = document.getElementById('filePlaceholder');
        const previewDiv = document.getElementById('filePreview');

        if (placeholder) placeholder.classList.remove('d-none');
        if (previewDiv) previewDiv.classList.add('d-none');
    }

    // Confirm Delete
    function confirmDelete(event) {
        const result = confirm('Apakah Anda yakin ingin menghapus arsip ini? Tindakan ini tidak dapat dibatalkan.');
        if (!result) {
            event.preventDefault();
            return false;
        }
        return true;
    }

    // Event Listeners
    document.addEventListener('DOMContentLoaded', function() {
        // Open modal buttons
        if (openModalBtn) {
            openModalBtn.addEventListener('click', openModal);
        }

        if (openModalBtnEmpty) {
            openModalBtnEmpty.addEventListener('click', openModal);
        }

        // Close modal buttons
        if (closeModalBtn) {
            closeModalBtn.addEventListener('click', closeModal);
        }

        if (cancelModalBtn) {
            cancelModalBtn.addEventListener('click', closeModal);
        }

        // Close modal when clicking outside
        if (modal) {
            modal.addEventListener('click', function(e) {
                if (e.target === modal) {
                    closeModal();
                }
            });
        }

        // File upload handler
        if (fileUploadBox) {
            fileUploadBox.addEventListener('click', function() {
                if (fileInput) {
                    fileInput.click();
                }
            });
        }

        if (fileInput) {
            fileInput.addEventListener('change', function(e) {
                if (e.target.files && e.target.files[0]) {
                    const file = e.target.files[0];

                    // Validate file size (max 10MB)
                    if (file.size > 10 * 1024 * 1024) {
                        alert('Ukuran file terlalu besar. Maksimal 10MB.');
                        fileInput.value = '';
                        return;
                    }

                    previewFile(file);
                }
            });
        }

        // Form validation
        const archiveForm = document.getElementById('archiveForm');
        if (archiveForm) {
            archiveForm.addEventListener('submit', function(e) {
                const file = document.getElementById('fileInput');
                const title = document.getElementById('title');
                const category = document.getElementById('category');
                let hasError = false;

                // Remove existing error messages
                document.querySelectorAll('.error-feedback').forEach(el => el.remove());

                // Validate file
                if (!file.files || !file.files[0]) {
                    showError(file, 'File arsip wajib dipilih');
                    hasError = true;
                }

                // Validate title
                if (!title.value.trim()) {
                    showError(title, 'Judul arsip wajib diisi');
                    hasError = true;
                } else if (title.value.length > 100) {
                    showError(title, 'Judul arsip maksimal 100 karakter');
                    hasError = true;
                }

                // Validate category
                if (!category.value) {
                    showError(category, 'Kategori wajib dipilih');
                    hasError = true;
                }

                if (hasError) {
                    e.preventDefault();
                    return false;
                }
            });
        }

        // Auto-hide alerts after 5 seconds
        setTimeout(function() {
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(function(alert) {
                setTimeout(function() {
                    if (alert && alert.parentNode) {
                        alert.style.transition = 'opacity 0.3s ease';
                        alert.style.opacity = '0';
                        setTimeout(function() {
                            if (alert && alert.parentNode) {
                                alert.remove();
                            }
                        }, 300);
                    }
                }, 5000);
            });
        }, 1000);
    });

    // Show Error Function
    function showError(input, message) {
        const errorDiv = document.createElement('div');
        errorDiv.className = 'error-feedback';
        errorDiv.innerHTML = '<i class="bi bi-exclamation-circle"></i> ' + message;

        if (input.type === 'file') {
            input.parentNode.parentNode.appendChild(errorDiv);
        } else {
            input.parentNode.appendChild(errorDiv);
        }

        input.style.borderColor = '#EF4444';

        input.addEventListener('focus', function() {
            errorDiv.remove();
            input.style.borderColor = '#E5E7EB';
        }, { once: true });
    }
</script>
@endsection
