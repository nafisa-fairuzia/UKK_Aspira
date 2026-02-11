@extends('layout.main')

@section('title', 'Riwayat Pengaduan')

@push('styles')
<link rel="stylesheet" href="{{ asset('assets/css/siswa/riwayat.css') }}?v={{ time() }}">
@endpush

@section('content')

<main id="main-content" class="py-4 bg-light min-vh-100">
    <div class="siswa-riwayat">
        <div class="d-flex justify-content-between align-items-center mb-4 mt-4">
            <div>
                <h3 class="fw-bold mb-1 text-dark">Riwayat Pengaduan</h3>
            </div>
            <a href="{{ route('siswa.pengaduan.create') }}" class="btn btn-primary rounded-pill px-4 shadow-sm fw-bold">
                <i class="ti ti-plus me-1"></i> Buat Laporan
            </a>
        </div>

        @php
        $statusFilters = [
        ['label' => 'Semua', 'status' => null, 'icon' => 'ti-list-check'],
        ['label' => 'Menunggu', 'status' => 'Menunggu', 'icon' => 'ti-clock'],
        ['label' => 'Diproses', 'status' => 'Proses', 'icon' => 'ti-loader-3'],
        ['label' => 'Selesai', 'status' => 'Selesai', 'icon' => 'ti-circle-check'],
        ];
        @endphp

        <div class="mb-4">
            <div class="filter-pills">
                @foreach($statusFilters as $filter)
                <a href="{{ route('siswa.pengaduan.riwayat', $filter['status'] ? ['status' => $filter['status']] : []) }}"
                    class="pill-btn {{ (request('status') === $filter['status']) ? 'active' : '' }}">
                    <i class="ti {{ $filter['icon'] }}"></i>
                    <span>{{ $filter['label'] }}</span>
                </a>
                @endforeach
            </div>
        </div>

        <div class="row g-3">
            @forelse($pengaduan as $item)
            @php

            $statusMap = [
            'Menunggu' => ['icon' => 'ti-clock', 'badge' => 'status-menunggu'],
            'Proses' => ['icon' => 'ti-loader', 'badge' => 'status-proses'],
            'Selesai' => ['icon' => 'ti-check', 'badge' => 'status-selesai'],
            ];
            $itemStatus = $item->aspirasi->status ?? 'Menunggu';
            $status = $statusMap[$itemStatus] ?? $statusMap['Menunggu'];
            @endphp

            <div class="col-xl-4 col-md-6">
                <div class="card border-0 shadow-sm rounded-4 h-100 card-hover position-relative">
                    <div class="position-absolute top-0 end-0 m-3">
                        <span class="badge bg-white text-muted border shadow-sm">
                            #{{ $totalPengaduan - ($pengaduan->firstItem() ? $pengaduan->firstItem() + $loop->index : $loop->iteration) + 1 }}
                        </span>
                    </div>

                    <div class="card-body p-4">
                        <div class="d-flex align-items-center mb-4">
                            <div class="status-indicator me-3">
                                <div class="status-badge {{ $status['badge'] }}">
                                    <i class="ti {{ $status['icon'] }}"></i>
                                </div>
                            </div>
                            <div class="flex-grow-1">
                                <h6 class="mb-0 fw-bold card-title-clamp" title="{{ $item->ket }}">
                                    {{ Str::words($item->ket, 7, '...') }}
                                </h6>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="text-muted x-small text-uppercase fw-bold mb-2 d-block" style="font-size: 0.7rem; letter-spacing: 0.5px;">Informasi Pengaduan</label>
                            <div class="bg-light p-2 rounded-3">
                                <p class="mb-1 fw-medium text-dark small">
                                    <i class="ti ti-tag me-1 text-primary"></i> {{ $item->kategori->ket_kategori ?? 'Umum' }}
                                </p>
                                <p class="mb-0 text-muted small">
                                    <i class="ti ti-calendar-event me-1"></i> {{ $item->formatted_created_at }}
                                </p>
                            </div>
                        </div>

                        <a href="{{ route('siswa.pengaduan.show', $item->id_pelaporan) }}" class="btn btn-outline-primary btn-sm w-100 rounded-3 py-2 fw-bold">
                            Lihat Progres <i class="ti ti-arrow-right ms-1"></i>
                        </a>
                    </div>
                </div>
            </div>

            @empty
            <div class="col-12 text-center py-5">
                <i class="ti ti-notes-off text-muted mb-2" style="font-size: 3rem;"></i>
                <p class="text-muted">Belum ada riwayat pengaduan.</p>
            </div>
            @endforelse
        </div>

        <div class="mt-5 d-flex justify-content-center">
            {{ $pengaduan->appends(request()->query())->links() }}
        </div>
    </div>
</main>

@endsection