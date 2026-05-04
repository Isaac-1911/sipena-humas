@extends('layouts.admin')

@section('content')
    <div class="news-edit-container" data-aos="fade-up">

        {{-- HEADER --}}
        <div class="edit-header">
            <div>
                <h4 class="edit-title">
                    <i class="bi bi-pencil-square me-2"></i>
                    Edit Berita
                </h4>
                <p class="edit-subtitle">Perbarui informasi berita yang sudah ada</p>
            </div>
            <a href="{{ route('admin.news.index') }}" class="back-button-small">
                <i class="bi bi-arrow-left"></i>
                Kembali
            </a>
        </div>

        {{-- FORM CARD --}}
        <div class="edit-form-card">
            <form action="{{ route('admin.news.update', $news->id) }}" method="POST" enctype="multipart/form-data"
                id="editNewsForm">
                @csrf
                @method('PUT')

                {{-- THUMBNAIL SECTION --}}
                <div class="form-section">
                    <div class="section-title">
                        {{-- <i class="bi bi-image"></i> --}}
                        <h5>Thumbnail Berita</h5>
                    </div>

                    <div class="thumbnail-section">
                        @if ($news->thumbnail && file_exists(storage_path('app/public/' . $news->thumbnail)))
                            <div class="current-thumbnail">
                                <label class="form-label-small">Thumbnail Saat Ini</label>
                                <div class="current-thumbnail-image">
                                    <img src="{{ asset('storage/' . $news->thumbnail) }}" alt="Current Thumbnail">
                                    {{-- <button type="button" class="remove-thumbnail-btn" onclick="confirmRemoveThumbnail()" title="Hapus Thumbnail">
                                    <i class="bi bi-trash"></i>
                                </button> --}}
                                </div>
                            </div>
                        @endif

                        <div class="thumbnail-upload-new">
                            <label class="form-label-small">
                                <i class="bi bi-cloud-upload me-1"></i>
                                Ganti Thumbnail (Opsional)
                            </label>
                            <div class="thumbnail-upload-box" id="thumbnailUploadBox">
                                <input type="file" name="image" id="thumbnailInput" class="d-none" accept="image/*"
                                    onchange="previewNewThumbnail(this)">
                                <div class="upload-placeholder-new" id="uploadPlaceholderNew">
                                    <i class="bi bi-cloud-arrow-up"></i>
                                    <p>Klik untuk upload gambar baru</p>
                                    <small>Format: JPG, PNG, GIF (Max 2MB)</small>
                                </div>
                                <div class="upload-preview-new d-none" id="uploadPreviewNew">
                                    <img id="thumbnailPreviewNew" src="" alt="Preview">
                                    <button type="button" class="remove-new-image" onclick="removeNewThumbnail()">
                                        <i class="bi bi-x-circle"></i>
                                    </button>
                                </div>
                            </div>
                            <small class="form-text text-muted">Biarkan kosong jika tidak ingin mengganti thumbnail</small>
                        </div>
                    </div>
                </div>

                {{-- TITLE SECTION --}}
                <div class="form-section">
                    <div class="section-title">
                        {{-- <i class="bi bi-fonts"></i> --}}
                        <h5>Judul Berita</h5>
                    </div>

                    <div class="form-group-modern">
                        <input type="text" name="title" id="title" class="modern-input-large"
                            placeholder="Masukkan judul berita" value="{{ old('title', $news->title) }}" required>
                        <div class="input-char-counter">
                            <span id="charCount">{{ strlen(old('title', $news->title)) }}</span> / 100 karakter
                        </div>
                        @error('title')
                            <div class="error-feedback">{{ $message }}</div>
                        @enderror
                    </div>


                </div>

                {{-- CONTENT SECTION --}}
                <div class="form-section">
                    <div class="section-title">
                        {{-- <i class="bi bi-file-text"></i> --}}
                        <h5>Konten Berita</h5>
                    </div>

                    <div class="form-group-modern">
                        <textarea name="content" id="content" class="modern-textarea-large" rows="12"
                            placeholder="Tulis konten berita di sini... Gunakan HTML untuk formatting">{{ old('content', $news->content) }}</textarea>
                        @error('content')
                            <div class="error-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                {{-- ACTION BUTTONS --}}
                <div class="form-actions">
                    <a href="{{ route('admin.news.index') }}" class="btn-cancel">
                        <i class="bi bi-x-circle"></i>
                        Batal
                    </a>
                    <button type="submit" class="btn-update">
                        <i class="bi bi-check-circle"></i>
                        Update Berita
                    </button>
                </div>

            </form>
        </div>

        {{-- DANGER ZONE --}}
        <div class="danger-zone" data-aos="fade-up" data-aos-delay="100">
            <div class="danger-zone-header">
                <i class="bi bi-exclamation-triangle"></i>
                <h6>Zona Bahaya</h6>
            </div>
            <p class="danger-zone-text">Setelah menghapus berita, semua data yang terkait akan hilang permanen.</p>
            <button type="button" class="btn-delete" onclick="confirmDelete()">
                <i class="bi bi-trash3"></i>
                Hapus Berita Ini
            </button>
        </div>

    </div>

    {{-- MODAL KONFIRMASI HAPUS THUMBNAIL --}}
    <div id="removeThumbnailModal" class="modal-confirm" style="display: none;">
        <div class="modal-confirm-content">
            <div class="modal-confirm-header">
                <i class="bi bi-exclamation-triangle"></i>
                <h5>Konfirmasi Hapus Thumbnail</h5>
            </div>
            <div class="modal-confirm-body">
                <p>Apakah Anda yakin ingin menghapus thumbnail ini?</p>
                <small>Tindakan ini tidak dapat dibatalkan.</small>
            </div>
            <div class="modal-confirm-footer">
                <button type="button" class="btn-confirm-cancel" onclick="closeRemoveModal()">Batal</button>
                <form action="{{ route('admin.news.remove-thumbnail', $news->id) }}" method="POST"
                    style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn-confirm-danger">Ya, Hapus Thumbnail</button>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        // Character counter for title
        const titleInput = document.getElementById('title');
        const charCountSpan = document.getElementById('charCount');

        if (titleInput && charCountSpan) {
            titleInput.addEventListener('input', function() {
                const length = this.value.length;
                charCountSpan.textContent = length;

                if (length > 100) {
                    charCountSpan.style.color = '#EF4444';
                } else {
                    charCountSpan.style.color = '#6B7280';
                }
            });
        }

        // Preview new thumbnail
        function previewNewThumbnail(input) {
            const preview = document.getElementById('thumbnailPreviewNew');
            const placeholder = document.getElementById('uploadPlaceholderNew');
            const previewDiv = document.getElementById('uploadPreviewNew');

            if (input.files && input.files[0]) {
                const file = input.files[0];
                const reader = new FileReader();

                reader.onload = function(e) {
                    preview.src = e.target.result;
                    placeholder.classList.add('d-none');
                    previewDiv.classList.remove('d-none');
                }

                reader.readAsDataURL(file);
            }
        }

        // Remove new thumbnail
        function removeNewThumbnail() {
            const input = document.getElementById('thumbnailInput');
            const placeholder = document.getElementById('uploadPlaceholderNew');
            const previewDiv = document.getElementById('uploadPreviewNew');

            input.value = '';
            placeholder.classList.remove('d-none');
            previewDiv.classList.add('d-none');
        }

        // Confirm remove current thumbnail
        function confirmRemoveThumbnail() {
            const modal = document.getElementById('removeThumbnailModal');
            if (modal) {
                modal.style.display = 'flex';
                document.body.style.overflow = 'hidden';
            }
        }

        // Close remove modal
        function closeRemoveModal() {
            const modal = document.getElementById('removeThumbnailModal');
            if (modal) {
                modal.style.display = 'none';
                document.body.style.overflow = '';
            }
        }

        // Confirm delete news
        function confirmDelete() {
            const result = confirm('Apakah Anda yakin ingin menghapus berita ini? Tindakan ini tidak dapat dibatalkan.');
            if (result) {
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = '{{ route('admin.news.destroy', $news->id) }}';
                form.innerHTML = '@csrf @method('DELETE')';
                document.body.appendChild(form);
                form.submit();
            }
        }

        // Form validation
        const editForm = document.getElementById('editNewsForm');
        if (editForm) {
            editForm.addEventListener('submit', function(e) {
                const title = document.getElementById('title');
                const content = document.getElementById('content');
                let hasError = false;

                // Remove existing error messages
                document.querySelectorAll('.error-feedback').forEach(el => {
                    if (!el.innerHTML.includes('title') && !el.innerHTML.includes('content')) {
                        el.remove();
                    }
                });

                // Validate title
                if (!title.value.trim()) {
                    showFormError(title, 'Judul berita wajib diisi');
                    hasError = true;
                } else if (title.value.length > 100) {
                    showFormError(title, 'Judul berita maksimal 100 karakter');
                    hasError = true;
                }

                // Validate content
                if (!content.value.trim()) {
                    showFormError(content, 'Konten berita wajib diisi');
                    hasError = true;
                }

                if (hasError) {
                    e.preventDefault();
                    return false;
                }
            });
        }

        function showFormError(input, message) {
            const errorDiv = document.createElement('div');
            errorDiv.className = 'error-feedback';
            errorDiv.innerHTML = '<i class="bi bi-exclamation-circle"></i> ' + message;
            input.parentNode.appendChild(errorDiv);
            input.style.borderColor = '#EF4444';

            input.addEventListener('focus', function() {
                errorDiv.remove();
                input.style.borderColor = '#E5E7EB';
            }, {
                once: true
            });
        }

        // Close modal when clicking outside
        document.addEventListener('click', function(e) {
            const modal = document.getElementById('removeThumbnailModal');
            if (modal && e.target === modal) {
                closeRemoveModal();
            }
        });

        // Auto resize textarea
        const textarea = document.getElementById('content');
        if (textarea) {
            textarea.addEventListener('input', function() {
                this.style.height = 'auto';
                this.style.height = this.scrollHeight + 'px';
            });
        }

        document.getElementById('thumbnailUploadBox').addEventListener('click', function(e) {

            const input = document.getElementById('thumbnailInput');

            // biar tombol remove gak ikut trigger upload
            if (e.target.closest('.remove-new-image')) return;

            input.click();
        });
    </script>
@endsection
