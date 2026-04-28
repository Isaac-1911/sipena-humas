@extends('layouts.admin')

@section('content')

{{-- WELCOME CARD --}}
<div class="welcome-card d-flex justify-content-between align-items-center mb-4" data-aos="fade-up">
    <div>
        <p class="text-warning mb-1">
            <i class="bi bi-shield-check"></i> Selamat Datang
        </p>
        <h4 class="mb-1">SIPENA HUMAS Dashboard</h4>
        <small>Kelola berita dan arsip dengan mudah dan profesional</small>
    </div>

    <div class="d-flex gap-3">
        <div class="mini-stat">
            <small><i class="bi bi-newspaper"></i> Berita</small>
            <h5>{{ \App\Models\News::count() }}</h5>
        </div>
        <div class="mini-stat">
            <small><i class="bi bi-archive"></i> Arsip</small>
            <h5>{{ \App\Models\Archive::count() }}</h5>
        </div>
    </div>
</div>

{{-- STATISTICS CARDS --}}
<div class="row g-4 mb-4">
    <div class="col-12 col-sm-6 col-md-3" data-aos="fade-up" data-aos-delay="100">
        <div class="stat-card d-flex justify-content-between align-items-center">
            <div>
                <div class="stat-title">Total Berita</div>
                <div class="stat-value">{{ \App\Models\News::count() }}</div>
                <small class="text-success">
                    <i class="bi bi-arrow-up"></i> +12% bulan ini
                </small>
            </div>
            <div class="icon-box icon-blue">
                <i class="bi bi-newspaper"></i>
            </div>
        </div>
    </div>

    <div class="col-12 col-sm-6 col-md-3" data-aos="fade-up" data-aos-delay="150">
        <div class="stat-card d-flex justify-content-between align-items-center">
            <div>
                <div class="stat-title">Total Arsip</div>
                <div class="stat-value">{{ \App\Models\Archive::count() }}</div>
                <small class="text-success">
                    <i class="bi bi-arrow-up"></i> +8% bulan ini
                </small>
            </div>
            <div class="icon-box icon-yellow">
                <i class="bi bi-archive"></i>
            </div>
        </div>
    </div>

    <div class="col-12 col-sm-6 col-md-3" data-aos="fade-up" data-aos-delay="200">
        <div class="stat-card d-flex justify-content-between align-items-center">
            <div>
                <div class="stat-title">Pesan Masuk</div>
                <div class="stat-value">{{ \App\Models\Message::count() }}</div>
                <small class="text-danger">
                    <i class="bi bi-arrow-down"></i> -2% minggu ini
                </small>
            </div>
            <div class="icon-box icon-green">
                <i class="bi bi-chat"></i>
            </div>
        </div>
    </div>

    <div class="col-12 col-sm-6 col-md-3" data-aos="fade-up" data-aos-delay="250">
        <div class="stat-card d-flex justify-content-between align-items-center">
            <div>
                <div class="stat-title">Pengguna Aktif</div>
                <div class="stat-value">{{ \App\Models\User::count() }}</div>
                <small class="text-success">
                    <i class="bi bi-plus-circle"></i> +5 user baru
                </small>
            </div>
            <div class="icon-box icon-purple">
                <i class="bi bi-people"></i>
            </div>
        </div>
    </div>
</div>

<div class="row g-4">
    {{-- AKTIVITAS TERBARU --}}
    <div class="col-12 col-md-6" data-aos="fade-right" data-aos-delay="300">
        <div class="bg-white p-4 rounded-xl shadow">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <div class="card-title">
                    <i class="bi bi-activity"></i>
                    <span>Aktivitas Terbaru</span>
                </div>
                {{-- <a href="#" class="view-all-btn">
                    Lihat semua <i class="bi bi-arrow-right"></i>
                </a> --}}
            </div>

            @php
                $latestNews = \App\Models\News::latest()->take(3)->get();
                $latestArchives = \App\Models\Archive::latest()->take(3)->get();
                $activities = $latestNews->concat($latestArchives)->sortByDesc('created_at')->take(5);
            @endphp

            @if($activities->count() > 0)
                <div class="activity-list">
                    @foreach($activities as $activity)
                        <div class="activity-item">
                            <div class="activity-icon {{ get_class($activity) === \App\Models\News::class ? 'icon-blue' : 'icon-yellow' }}">
                                <i class="bi {{ get_class($activity) === \App\Models\News::class ? 'bi-newspaper' : 'bi-archive' }}"></i>
                            </div>
                            <div class="activity-content">
                                <strong>{{ Str::limit($activity->title, 40) }}</strong>
                                <small>{{ get_class($activity) === \App\Models\News::class ? 'Berita baru ditambahkan' : 'Arsip baru ditambahkan' }}</small>
                            </div>
                            {{-- <div class="activity-time">
                                {{ $activity->created_at->diffForHumans() }}
                            </div> --}}
                        </div>
                    @endforeach
                </div>
            @else
                <div class="empty-state">
                    <i class="bi bi-inbox"></i>
                    <p>Belum ada aktivitas</p>
                </div>
            @endif
        </div>
    </div>

    {{-- PESAN TERBARU --}}
    <div class="col-12 col-md-6" data-aos="fade-left" data-aos-delay="350">
        <div class="bg-white p-4 rounded-xl shadow">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <div class="card-title">
                    <i class="bi bi-envelope"></i>
                    <span>Pesan Terbaru</span>
                </div>
                {{-- <a href="#" class="view-all-btn">
                    Lihat semua <i class="bi bi-arrow-right"></i>
                </a> --}}
            </div>

            @php
                $messages = \App\Models\Message::latest()->take(5)->get();
            @endphp

            @if($messages->count() > 0)
                <div class="message-list">
                    @foreach($messages as $msg)
                        <div class="message-item">
                            <div class="message-header">
                                <div>
                                    <span class="message-name">{{ $msg->name }}</span>
                                    @if($msg->email)
                                        <span class="message-email">({{ $msg->email }})</span>
                                    @endif
                                </div>
                                <div class="message-date">{{ $msg->created_at->diffForHumans() }}</div>
                            </div>
                            <p class="message-text">
                                {{ \Illuminate\Support\Str::limit($msg->message, 80) }}
                            </p>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="empty-state">
                    <i class="bi bi-inbox"></i>
                    <p>Belum ada pesan masuk</p>
                </div>
            @endif
        </div>
    </div>
</div>

{{-- QUICK ACTIONS --}}
<div class="row mt-4" data-aos="fade-up" data-aos-delay="400">
    <div class="col-12">
        <div class="bg-white p-4 rounded-xl shadow">
            <div class="card-title mb-4">
                <i class="bi bi-lightning-charge"></i>
                <span>Aksi Cepat</span>
            </div>

            <div class="quick-actions-grid">
                <a href="{{ route('admin.news.create') }}" class="action-card">
                    <div class="action-icon">
                        <i class="bi bi-plus-lg"></i>
                    </div>
                    <div class="action-title">Tambah Berita</div>
                    <div class="action-desc">Publikasikan berita terbaru</div>
                </a>

                <a href="{{ route('admin.archive.create') }}" class="action-card">
                    <div class="action-icon">
                        <i class="bi bi-archive"></i>
                    </div>
                    <div class="action-title">Tambah Arsip</div>
                    <div class="action-desc">Simpan arsip penting</div>
                </a>

                <a href="{{ route('admin.news.index') }}" class="action-card">
                    <div class="action-icon">
                        <i class="bi bi-eye"></i>
                    </div>
                    <div class="action-title">Lihat Semua</div>
                    <div class="action-desc">Kelola semua konten</div>
                </a>

                <a href="#" class="action-card" onclick="return confirmExport()">
                    <div class="action-icon">
                        <i class="bi bi-download"></i>
                    </div>
                    <div class="action-title">Export Data</div>
                    <div class="action-desc">Download laporan lengkap</div>
                </a>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    // Add click handlers for stat cards
    document.querySelectorAll('.stat-card').forEach(card => {
        card.addEventListener('click', function() {
            const title = this.querySelector('.stat-title').innerText;
            if (title.includes('Berita')) {
                window.location.href = "{{ route('admin.news.index') }}";
            } else if (title.includes('Arsip')) {
                window.location.href = "{{ route('admin.archive.index') }}";
            }
        });
    });

    // Confirm export function
    function confirmExport() {
        if(confirm('Apakah Anda yakin ingin mengexport semua data?')) {
            alert('Fitur export akan segera tersedia');
            return false;
        }
        return false;
    }
</script>
@endpush
