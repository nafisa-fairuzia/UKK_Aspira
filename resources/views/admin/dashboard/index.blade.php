@extends('layout.main')

@section('title', 'Dashboard Admin')

@push('styles')
<link rel="stylesheet" href="{{ asset('assets/css/admin/dashboard.css') }}?v={{ time() }}">
@endpush

@section('content')

<div class="dashboard-admin">
    <main id="main-content">
        <div class="card welcome-card mb-4 mt-4 border-0 shadow-lg position-relative overflow-hidden rounded-4">
            <div class="card-body p-4 p-md-5">
                <div class="position-relative" style="z-index: 2; max-width: 600px;">
                    <span class="badge bg-white bg-opacity-25 mb-3 px-3 py-2 rounded-pill">
                        Selamat Datang Kembali
                    </span>
                    <h2 class="fw-bold text-white mb-2">Hi, {{ Session::get('nama') ?? 'Admin' }}! ✨</h2>
                    <p class="text-white opacity-75 mb-4">
                        Pantau dan kelola seluruh kondisi sarana prasarana sekolah untuk memastikan kenyamanan belajar tetap terjaga.
                    </p>
                    <a href="{{ route('admin.pengaduan.index') }}" class="btn btn-light rounded-pill px-4 fw-bold shadow-sm">
                        <i class="ti ti-message-circle-search me-1"></i> Cek Pengaduan
                    </a>
                </div>

                <div class="decoration-circle-1"></div>
                <div class="decoration-circle-2"></div>
                <img src="{{ asset('assets/img/aspira4.png') }}" class="welcome-img" alt="Illustration">
            </div>
        </div>

        <div class="row g-4 mb-4">
            @php
            $stats = [
            [
            'label' => 'Total Pengaduan',
            'val' => $total,
            'icon' => 'ti-folder',
            'bg' => 'info',
            'color' => '#0ea5e9'
            ],
            [
            'label' => 'Menunggu',
            'val' => $menunggu,
            'icon' => 'ti-clock-pause',
            'bg' => 'warning',
            'color' => '#f59e0b'
            ],
            [
            'label' => 'Proses',
            'val' => $proses,
            'icon' => 'ti-settings-automation',
            'bg' => 'primary',
            'color' => '#0ea5e9'
            ],
            [
            'label' => 'Selesai',
            'val' => $selesai,
            'icon' => 'ti-circle-check',
            'bg' => 'success',
            'color' => '#10b981'
            ],
            ];
            @endphp

            @foreach($stats as $st)
            @php
            $statusParam = $st['label'] === 'Total Pengaduan' ? null : ($st['label'] === 'Menunggu' ? 'Menunggu' : ($st['label'] === 'Proses' ? 'Proses' : ($st['label'] === 'Selesai' ? 'Selesai' : null)));
            $cardLink = $statusParam ? route('admin.pengaduan.index') . '?status=' . urlencode($statusParam) : route('admin.pengaduan.index');
            @endphp
            <div class="col-6 col-lg-3">
                <a href="{{ $cardLink }}" class="text-decoration-none">
                    <div class="card border-0 p-4 rounded-4 shadow-sm h-100 card-hover">
                        <div class="d-flex align-items-center justify-content-between">
                            <div>
                                <div class="text-muted small fw-bold text-uppercase">{{ $st['label'] }}</div>
                                <h2 class="fw-bold mb-0 mt-1" style="color: <?php echo $st['color']; ?>;">
                                    {{ $st['val'] }}
                                </h2>
                            </div>
                            <div class="flex-shrink-0">
                                <div class="bg-{{ $st['bg'] }} bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center" style="width: 55px; height: 55px;">
                                    <i class="ti {{ $st['icon'] }} fs-3" style="color: <?php echo $st['color']; ?>;"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            @endforeach
        </div>

        <div class="row g-4 mt-2">

            <div class="col-lg-6">
                <div class="card border-0 shadow-sm rounded-4 h-100">
                    <div class="card-header bg-white border-0 pt-4 px-4 pb-0">
                        <div class="d-flex align-items-center justify-content-between">
                            <div class="d-flex align-items-center">
                                <div class="p-2 bg-primary-soft rounded-4 me-3">
                                    <i class="ti ti-chart-line fs-4 text-primary"></i>
                                </div>
                                <h5 class="fw-bold mb-0">Statistik Pengaduan</h5>
                            </div>
                            <small class="text-muted small">7 Hari Terakhir</small>
                        </div>
                    </div>
                    <div class="card-body p-4">
                        {{-- Data chart disediakan oleh controller: $chart_labels (array of labels) dan $chart_data (array of counts) --}}
                        <div style="height: 180px; width: 100%;">
                            <canvas id="trendChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="card border-0 shadow-sm rounded-4 h-100">
                    <div class="card-header bg-white border-0 pt-4 px-4 pb-0">
                        <div class="d-flex align-items-center">
                            <div class="p-2 bg-primary-soft rounded-3 me-3">
                                <i class="ti ti-bolt fs-4 text-primary"></i>
                            </div>
                            <h5 class="fw-bold mb-0">Aksi Cepat</h5>
                        </div>
                    </div>
                    <div class="card-body p-4">
                        <div class="row g-3">
                            <div class="col-6">
                                <a href="{{ route('admin.pengaduan.index') }}" class="text-decoration-none">
                                    <div class="action-card text-center p-3 rounded-3 border">
                                        <div class="mb-2"><i class="ti ti-file-text fs-2 text-primary"></i></div>
                                        <small class="fw-bold text-dark">Kelola Pengaduan</small>
                                    </div>
                                </a>
                            </div>
                            <div class="col-6">
                                <a href="{{ route('admin.siswa.index') }}" class="text-decoration-none">
                                    <div class="action-card text-center p-3 rounded-3 border">
                                        <div class="mb-2"><i class="ti ti-users fs-2 text-success"></i></div>
                                        <small class="fw-bold text-dark">Data Siswa</small>
                                    </div>
                                </a>
                            </div>
                            <div class="col-6">
                                <a href="{{ route('admin.kategori.index') }}" class="text-decoration-none">
                                    <div class="action-card text-center p-3 rounded-3 border">
                                        <div class="mb-2"><i class="ti ti-archive fs-2 text-warning"></i></div>
                                        <small class="fw-bold text-dark">Kategori</small>
                                    </div>
                                </a>
                            </div>
                            <div class="col-6">
                                <a href="{{ route('admin.admins.index') }}" class="text-decoration-none">
                                    <div class="action-card text-center p-3 rounded-3 border">
                                        <div class="mb-2"><i class="ti ti-shield-check fs-2 text-info"></i></div>
                                        <small class="fw-bold text-dark">Data Admin</small>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="mt-4">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h4 class="fw-bold mb-0 text-dark">Daftar Pengaduan Terbaru</h4>
                <a href="{{ route('admin.pengaduan.index') }}" class="btn btn-outline-primary btn-sm">
                    <i class="ti ti-eye me-1"></i> Lihat Semua
                </a>
            </div>

            <div class="row g-3">
                @forelse($pengaduan as $item)
                <div class="col-xl-4 col-md-6">
                    <div class="card border-0 shadow-sm rounded-4 h-100 card-hover">
                        <div class="card-body p-4">
                            <div class="d-flex justify-content-between align-items-start mb-3">
                                @php
                                $currentStatus = $item->aspirasi->status ?? 'Menunggu';
                                $badgeClass = match($currentStatus) {
                                'Menunggu' => 'bg-warning-subtle text-warning',
                                'Proses' => 'bg-primary-subtle text-primary',
                                'Selesai' => 'bg-success-subtle text-success',
                                default => 'bg-light text-secondary'
                                };
                                @endphp
                                <span class="badge {{ $badgeClass }} border-0 px-3 py-2 rounded-pill small fw-bold">
                                    {{ strtoupper($currentStatus) }}
                                </span>
                                <small class="text-muted fw-medium">ASP-{{ sprintf('%05d', $item->id_pelaporan) }}</small>
                            </div>

                            <div class="d-flex align-items-center mb-4">
                                @if($item->siswa && $item->siswa->profile_pic)
                                <img src="{{ asset('storage/' . $item->siswa->profile_pic) }}"
                                    class="rounded-3 me-3 border shadow-sm"
                                    style="width: 45px; height: 45px; object-fit: cover; flex-shrink: 0;"
                                    onerror="this.onerror=null; this.src='https://ui-avatars.com/api/?name={{ urlencode($item->siswa->nama) }}&color=7F9CF5&background=EBF4FF';">
                                @else
                                <div class="avatar-box bg-primary-subtle rounded-3 d-flex align-items-center justify-content-center fw-bold me-3 text-primary" style="width: 45px; height: 45px; font-size: 18px;">
                                    {{ strtoupper(substr($item->siswa->nama ?? 'S', 0, 1)) }}
                                </div>
                                @endif
                                <div>
                                    <h6 class="mb-0 fw-bold">{{ $item->siswa->nama ?? 'N/A' }}</h6>
                                    <small class="text-muted">NIS: {{ $item->nis }}</small>
                                </div>

                            </div>

                            <div class="mb-4">
                                <label class="text-muted x-small text-uppercase fw-bold mb-1 d-block">Kategori & Waktu</label>
                                <p class="mb-0 fw-medium text-dark small">
                                    <i class="ti ti-tag me-1 text-primary"></i> {{ $item->kategori->ket_kategori ?? 'Umum' }}
                                </p>
                                <p class="mb-0 text-muted x-small">
                                    <i class="ti ti-clock me-1"></i> {{ $item->formatted_created_at }}
                                </p>
                            </div>

                            <a href="{{ route('admin.pengaduan.show', $item->id_pelaporan) }}" class="btn btn-outline-primary btn-sm w-100 rounded-3 py-2 fw-bold">
                                Kelola Pengaduan <i class="ti ti-arrow-right ms-1"></i>
                            </a>
                        </div>
                    </div>
                </div>
                @empty
                <div class="col-12 text-center py-5">
                    <div class="py-5">
                        <i class="ti ti-inbox fs-1 text-muted opacity-25"></i>
                        <p class="text-muted mt-2">Tidak ada pengaduan yang ditemukan</p>
                    </div>
                </div>
                @endforelse
            </div>

        </div>

    </main>
</div>

@endsection
@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    window.chartLabels = JSON.parse('{!! json_encode($chart_labels) !!}');
    window.chartData = JSON.parse('{!! json_encode($chart_data) !!}');
</script>
<script src="{{ asset('assets/js/admin/dashboard-chart.js') }}?v={{ time() }}"></script>
@endpush