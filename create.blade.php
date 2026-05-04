@extends('layouts.app')

@section('content')

    <div class="dashboard-container">

        <!-- Page Header -->
        <div class="page-header mb-4">
            <div class="d-flex align-items-center gap-3">
                <div class="page-icon">
                    <i class="bi bi-calendar-plus"></i>
                </div>
                <div>
                    <h1 class="page-title mb-1">Ajukan Cuti</h1>
                    <p class="page-subtitle">Isi formulir di bawah ini untuk mengajukan cuti</p>
                </div>
            </div>
        </div>

        <!-- Form Card -->
        <div class="card-clean form-card">

            <!-- Alert Messages -->
            @if ($errors->any() || session('success') || $errors->has('business'))
                <div class="alert-container mb-4">

                    <!-- Error Business (Tabrakan cuti dll) -->
                    @if ($errors->has('business'))
                        <div class="alert-clean alert-danger-clean">
                            <div class="d-flex align-items-center gap-2">
                                <i class="bi bi-exclamation-triangle-fill"></i>
                                <strong>{{ $errors->first('business') }}</strong>
                            </div>
                        </div>
                    @endif

                    <!-- Validation Errors -->
                    @if ($errors->any() && !$errors->has('business'))
                        <div class="alert-clean alert-danger-clean">
                            <div class="d-flex align-items-center gap-2 mb-2">
                                <i class="bi bi-exclamation-triangle-fill"></i>
                                <strong>Perhatian! Mohon periksa kembali form Anda</strong>
                            </div>
                            <ul class="mb-0 ps-3">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <!-- Success Message -->
                    @if (session('success'))
                        <div class="alert-clean alert-success-clean">
                            <div class="d-flex align-items-center gap-2">
                                <i class="bi bi-check-circle-fill"></i>
                                <span>{{ session('success') }}</span>
                            </div>
                        </div>
                    @endif

                </div>
            @endif

            <!-- Form -->
            <form action="{{ route('leave.store') }}" method="POST" enctype="multipart/form-data" id="leaveForm">
                @csrf

                <div class="form-section">
                    <div class="section-title">
                        <i class="bi bi-info-circle"></i>
                        <span>Informasi Dasar Cuti</span>
                    </div>

                    <div class="row g-4">
                        <!-- Jenis Cuti -->
                        <div class="col-12">
                            <label class="form-label">
                                <i class="bi bi-tag"></i>
                                Jenis Cuti
                                <span class="required">*</span>
                            </label>
                            <select name="leave_type_id" class="form-control @error('leave_type_id') is-invalid @enderror"
                                required>
                                <option value="">Pilih jenis cuti</option>
                                @foreach ($leaveTypes as $type)
                                    <option value="{{ $type->id }}"
                                        {{ old('leave_type_id') == $type->id ? 'selected' : '' }}>
                                        {{ $type->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('leave_type_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="form-hint">Pilih jenis cuti sesuai dengan kebutuhan Anda</small>
                        </div>
                    </div>
                </div>

                <div class="form-section">
                    <div class="section-title">
                        <i class="bi bi-calendar-range"></i>
                        <span>Periode Cuti</span>
                    </div>

                    <div class="row g-4">
                        <!-- Tanggal Mulai -->
                        <div class="col-md-6">
                            <label class="form-label">
                                <i class="bi bi-calendar-plus"></i>
                                Tanggal Mulai
                                <span class="required">*</span>
                            </label>
                            <input type="date" name="start_date" value="{{ old('start_date') }}"
                                class="form-control @error('start_date') is-invalid @enderror" required>
                            @error('start_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="form-hint">Hari pertama Anda mulai cuti</small>
                        </div>

                        <!-- Tanggal Selesai -->
                        <div class="col-md-6">
                            <label class="form-label">
                                <i class="bi bi-calendar-minus"></i>
                                Tanggal Selesai
                                <span class="required">*</span>
                            </label>
                            <input type="date" name="end_date" value="{{ old('end_date') }}"
                                class="form-control @error('end_date') is-invalid @enderror" required>
                            @error('end_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="form-hint">Hari terakhir Anda cuti</small>
                        </div>
                    </div>

                    <!-- Info Durasi Cuti -->
                    <div class="duration-info mt-3" id="durationInfo" style="display: none;">
                        <div class="d-flex align-items-center gap-2 p-3 bg-blue-light rounded-3">
                            <i class="bi bi-info-circle"></i>
                            <span>Durasi cuti: <strong id="durationDays">0</strong> hari kerja</span>
                        </div>
                    </div>
                </div>

                <div class="form-section">
                    <div class="section-title">
                        <i class="bi bi-geo-alt"></i>
                        <span>Lokasi & Alamat</span>
                    </div>

                    <div class="row g-4">
                        <!-- Lokasi -->
                        <div class="col-md-6">
                            <label class="form-label">
                                <i class="bi bi-globe2"></i>
                                Lokasi Cuti
                                <span class="required">*</span>
                            </label>

                            <div class="d-flex gap-3">
                                <div class="form-check flex-grow-1">
                                    <input class="form-check-input" type="radio" name="location_type"
                                        id="locationDalamNegeri" value="dalam_negeri"
                                        {{ old('location_type') == 'dalam_negeri' ? 'checked' : '' }} required>
                                    <label
                                        class="form-check-label w-100 py-2 px-3 border rounded-3 {{ old('location_type') == 'dalam_negeri' ? 'border-primary bg-primary bg-opacity-10' : 'border-secondary' }}"
                                        for="locationDalamNegeri" style="cursor: pointer;">
                                        <i class="bi bi-house-door me-2"></i>
                                        Dalam Negeri
                                    </label>
                                </div>

                                <div class="form-check flex-grow-1">
                                    <input class="form-check-input" type="radio" name="location_type"
                                        id="locationLuarNegeri" value="luar_negeri"
                                        {{ old('location_type') == 'luar_negeri' ? 'checked' : '' }}>
                                    <label
                                        class="form-check-label w-100 py-2 px-3 border rounded-3 {{ old('location_type') == 'luar_negeri' ? 'border-primary bg-primary bg-opacity-10' : 'border-secondary' }}"
                                        for="locationLuarNegeri" style="cursor: pointer;">
                                        <i class="bi bi-airplane me-2"></i>
                                        Luar Negeri
                                    </label>
                                </div>
                            </div>

                            @error('location_type')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Alamat -->
                        <div class="col-md-6">
                            <label class="form-label">
                                <i class="bi bi-pin-map"></i>
                                Alamat Selama Cuti
                                <span class="required">*</span>
                            </label>
                            <input type="text" name="leave_address" value="{{ old('leave_address') }}"
                                class="form-control @error('leave_address') is-invalid @enderror"
                                placeholder="Contoh: Jl. Merdeka No. 123, Jakarta" required>
                            @error('leave_address')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="form-hint">Alamat lengkap selama menjalani cuti</small>
                        </div>
                    </div>
                </div>

                <div class="form-section">
                    <div class="section-title">
                        <i class="bi bi-chat-text"></i>
                        <span>Alasan & Keterangan</span>
                    </div>

                    <div class="row g-4">
                        <!-- Alasan -->
                        <div class="col-12">
                            <label class="form-label">
                                <i class="bi bi-quote"></i>
                                Alasan Cuti
                                <span class="required">*</span>
                            </label>
                            <textarea name="reason" rows="4" class="form-control @error('reason') is-invalid @enderror"
                                placeholder="Tuliskan alasan cuti dengan jelas dan lengkap..." required>{{ old('reason') }}</textarea>
                            @error('reason')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="form-hint">Jelaskan alasan Anda mengajukan cuti</small>
                        </div>
                    </div>
                </div>

                <div class="form-section">
                    <div class="section-title">
                        <i class="bi bi-paperclip"></i>
                        <span>Lampiran Dokumen</span>
                    </div>

                    <div class="row g-4">
                        <!-- Lampiran -->
                        <div class="col-12">
                            <label class="form-label">
                                <i class="bi bi-file-earmark"></i>
                                Lampiran (Opsional)
                            </label>
                            <div class="file-upload-wrapper">
                                <div class="file-upload-area" id="fileUploadArea">
                                    <i class="bi bi-cloud-upload fs-2"></i>
                                    <p class="mb-1">Klik atau tarik file ke sini</p>
                                    <small class="text-muted">PDF, JPG, PNG (Max. 5MB)</small>
                                    <input type="file" name="attachment" id="fileInput"
                                        class="file-input @error('attachment') is-invalid @enderror">
                                </div>
                            </div>
                            <div id="fileInfo" class="file-info" style="display: none;">
                                <div class="d-flex align-items-center gap-2 p-2 bg-light rounded">
                                    <i class="bi bi-file-earmark-check text-success"></i>
                                    <span id="fileName"></span>
                                    <button type="button" class="btn-clear-file ms-auto" id="clearFile">
                                        <i class="bi bi-x"></i>
                                    </button>
                                </div>
                            </div>
                            @error('attachment')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                            <small class="form-hint">Upload dokumen pendukung jika diperlukan oleh jenis cuti</small>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="form-actions mt-4 pt-3">
                    <div class="d-flex gap-3">
                        <button type="submit" class="btn btn-primary btn-submit">
                            <i class="bi bi-send"></i>
                            Kirim Pengajuan
                        </button>
                        <button type="button" class="btn btn-secondary" id="resetForm">
                            <i class="bi bi-arrow-counterclockwise"></i>
                            Reset
                        </button>
                        <a href="{{ route('leave.index') }}" class="btn btn-outline ms-auto">
                            <i class="bi bi-x-lg"></i>
                            Batal
                        </a>
                    </div>
                </div>

            </form>

            <!-- Leave Balance Info Card -->
            <div class="leave-balance-card mt-4">
                <div class="d-flex align-items-center gap-3">
                    <div class="balance-icon">
                        <i class="bi bi-calendar-check"></i>
                    </div>
                    <div class="balance-info">
                        <div class="balance-label">Sisa Cuti Tahunan Anda</div>
                        <div class="balance-value">12 <span>Hari</span></div>
                    </div>
                    <div class="balance-progress flex-grow-1">
                        <div class="progress-clean">
                            <div class="progress-clean-bar" style="width: {{ 100 - $percentage }}%"></div>
                        </div>
                        <div class="d-flex justify-content-between mt-1">
                            <small class="text-muted">Terpakai: {{ $usedLeave }} hari</small>
                            <small class="text-muted">Sisa: {{ $remainingLeave }} hari</small>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {

            const locationOptions = document.querySelectorAll('.location-option');
            const locationTypeInput = document.getElementById('locationTypeInput');

            function setLocationValue(value) {
                if (!locationTypeInput) return;

                locationTypeInput.value = value;

                locationOptions.forEach(opt => {
                    if (opt.dataset.value === value) {
                        opt.classList.add('active');
                    } else {
                        opt.classList.remove('active');
                    }
                });
            }

            locationOptions.forEach(option => {
                option.addEventListener('click', function() {
                    const value = this.dataset.value;
                    setLocationValue(value);
                });

                option.addEventListener('mouseenter', function() {
                    if (!this.classList.contains('active')) {
                        this.style.borderColor = '#cbd5e1';
                    }
                });

                option.addEventListener('mouseleave', function() {
                    if (!this.classList.contains('active')) {
                        this.style.borderColor = '#e2e8f0';
                    }
                });
            });

            if (locationTypeInput && locationTypeInput.value) {
                setLocationValue(locationTypeInput.value);
            }

            // ===== DURATION CALCULATOR =====
            const startDateInput = document.querySelector('input[name="start_date"]');
            const endDateInput = document.querySelector('input[name="end_date"]');
            const durationInfo = document.getElementById('durationInfo');
            const durationDaysSpan = document.getElementById('durationDays');

            function calculateDuration() {
                if (!startDateInput || !endDateInput) return;

                if (startDateInput.value && endDateInput.value) {
                    const start = new Date(startDateInput.value);
                    const end = new Date(endDateInput.value);

                    if (start <= end) {
                        const diffTime = Math.abs(end - start);
                        const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24)) + 1;

                        durationDaysSpan.textContent = diffDays;
                        durationInfo.style.display = 'block';
                    } else {
                        durationInfo.style.display = 'none';
                    }
                } else {
                    durationInfo.style.display = 'none';
                }
            }

            startDateInput?.addEventListener('change', calculateDuration);
            endDateInput?.addEventListener('change', calculateDuration);

            // ===== FILE UPLOAD =====
            const fileInput = document.getElementById('fileInput');
            const fileUploadArea = document.getElementById('fileUploadArea');
            const fileInfo = document.getElementById('fileInfo');
            const fileName = document.getElementById('fileName');
            const clearFileBtn = document.getElementById('clearFile');

            fileUploadArea?.addEventListener('click', () => fileInput.click());

            fileUploadArea?.addEventListener('dragover', (e) => {
                e.preventDefault();
                fileUploadArea.classList.add('drag-over');
            });

            fileUploadArea?.addEventListener('dragleave', () => {
                fileUploadArea.classList.remove('drag-over');
            });

            fileUploadArea?.addEventListener('drop', (e) => {
                e.preventDefault();
                fileUploadArea.classList.remove('drag-over');

                if (e.dataTransfer.files.length) {
                    fileInput.files = e.dataTransfer.files;

                    if (fileInput.files[0]) {
                        fileName.textContent = fileInput.files[0].name;
                        fileUploadArea.style.display = 'none';
                        fileInfo.style.display = 'block';
                    }
                }
            });

            fileInput?.addEventListener('change', () => {
                if (fileInput.files[0]) {
                    fileName.textContent = fileInput.files[0].name;
                    fileUploadArea.style.display = 'none';
                    fileInfo.style.display = 'block';
                }
            });

            clearFileBtn?.addEventListener('click', () => {
                fileInput.value = '';
                fileUploadArea.style.display = 'flex';
                fileInfo.style.display = 'none';
            });

            // ===== RESET FORM =====
            const resetBtn = document.getElementById('resetForm');

            resetBtn?.addEventListener('click', (e) => {
                e.preventDefault();

                document.getElementById('leaveForm').reset();

                setLocationValue('');

                fileInput.value = '';
                fileUploadArea.style.display = 'flex';
                fileInfo.style.display = 'none';

                durationInfo.style.display = 'none';

                document.querySelectorAll('.is-invalid').forEach(el => {
                    el.classList.remove('is-invalid');
                });
            });

        });
    </script>
@endpush
