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
            <h5 class="mb-3">
                <i class="bi bi-activity me-2"></i>
                Aktivitas Terbaru
            </h5>

            @php
                $latestNews = \App\Models\News::latest()->take(3)->get();
                $latestArchives = \App\Models\Archive::latest()->take(3)->get();
                $activities = $latestNews->concat($latestArchives)->sortByDesc('created_at')->take(5);
            @endphp

            @forelse($activities as $activity)
                <div class="activity-item">
                    <div class="icon-box {{ get_class($activity) === \App\Models\News::class ? 'icon-blue' : 'icon-yellow' }}">
                        <i class="bi {{ get_class($activity) === \App\Models\News::class ? 'bi-newspaper' : 'bi-archive' }}"></i>
                    </div>
                    <div>
                        <strong>{{ $activity->title }}</strong><br>
                        <small class="text-muted">
                            {{ get_class($activity) === \App\Models\News::class ? 'Berita baru ditambahkan' : 'Arsip baru ditambahkan' }}
                            {{-- • {{ $activity->created_at->diffForHumans() }} --}}
                        </small>
                    </div>
                </div>
            @empty
                <p class="text-muted text-center py-3">Belum ada aktivitas</p>
            @endforelse
        </div>
    </div>

    {{-- PESAN TERBARU --}}
    <div class="col-12 col-md-6" data-aos="fade-left" data-aos-delay="350">
        <div class="bg-white p-4 rounded-xl shadow">
            <h5 class="mb-3">
                <i class="bi bi-envelope me-2"></i>
                Pesan Terbaru
                <a href="#" class="btn btn-sm btn-link float-end">Lihat semua</a>
            </h5>

            @php
                $messages = \App\Models\Message::latest()->take(5)->get();
            @endphp

            @forelse($messages as $msg)
                <div class="message-item">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <strong>{{ $msg->name }}</strong>
                            @if($msg->email)
                                <small class="text-muted d-block">📧 {{ $msg->email }}</small>
                            @endif
                            <p class="mb-0 mt-1">
                                {{ \Illuminate\Support\Str::limit($msg->message, 60) }}
                            </p>
                        </div>
                        <small class="text-muted">{{ $msg->created_at->diffForHumans() }}</small>
                    </div>
                </div>
            @empty
                <p class="text-muted text-center py-3">
                    <i class="bi bi-inbox" style="font-size: 40px;"></i><br>
                    Belum ada pesan
                </p>
            @endforelse
        </div>
    </div>
</div>

{{-- QUICK ACTIONS --}}
<div class="row mt-4" data-aos="fade-up" data-aos-delay="400">
    <div class="col-12">
        <div class="bg-white p-4 rounded-xl shadow">
            <h5 class="mb-3">
                <i class="bi bi-lightning-charge me-2"></i>
                Aksi Cepat
            </h5>
            <div class="row g-3">
                <div class="col-6 col-sm-4 col-md-2">
                    <a href="{{ route('admin.news.create') }}" class="btn btn-outline-primary w-100 py-3">
                        <i class="bi bi-plus-circle d-block mb-2" style="font-size: 24px;"></i>
                        <small>Tambah Berita</small>
                    </a>
                </div>
                <div class="col-6 col-sm-4 col-md-2">
                    <a href="{{ route('admin.archive.create') }}" class="btn btn-outline-warning w-100 py-3">
                        <i class="bi bi-archive d-block mb-2" style="font-size: 24px;"></i>
                        <small>Tambah Arsip</small>
                    </a>
                </div>
                <div class="col-6 col-sm-4 col-md-2">
                    <a href="{{ route('admin.news.index') }}" class="btn btn-outline-info w-100 py-3">
                        <i class="bi bi-eye d-block mb-2" style="font-size: 24px;"></i>
                        <small>Lihat Semua</small>
                    </a>
                </div>
                <div class="col-6 col-sm-4 col-md-2">
                    <a href="#" class="btn btn-outline-success w-100 py-3">
                        <i class="bi bi-download d-block mb-2" style="font-size: 24px;"></i>
                        <small>Export Data</small>
                    </a>
                </div>
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
</script>
@endpush
