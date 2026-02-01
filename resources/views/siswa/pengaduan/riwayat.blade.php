@extends('layout.main')

@section('title', 'Riwayat Pengaduan')

@push('styles')
<link rel="stylesheet" href="{{ asset('assets/css/siswa/riwayat.css') }}?v={{ time() }}">
<style>
    .siswa-riwayat .card-title-clamp {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
        text-overflow: ellipsis;
        word-break: break-word;
        min-height: 2.8em;
        line-height: 1.4em;
    }
</style>
@endpush

@section('content')

<main id="main-content" class="py-4 bg-light min-vh-100">
    <div class="siswa-riwayat">
        <div class="row align-items-center mb-4 mt-2">

            <div class="col-md-7">
                <h3 class="fw-bold mb-1 text-dark">Riwayat Laporan</h3>
            </div>
            <div class="col-md-5 text-md-end mt-3 mt-md-0">
                <a href="{{ route('siswa.pengaduan.create') }}" class="btn btn-primary rounded-3 px-4 py-2 shadow-sm">
                    <i class="ti ti-plus me-1"></i> Buat Laporan Baru
                </a>
            </div>
        </div>

        <div class="card border-0 shadow-sm mb-4 rounded-3">
            <div class="card-body p-4">
                <form method="GET" action="{{ route('siswa.pengaduan.riwayat') }}">
                    <div class="row g-3 align-items-end">

                        <div class="col-md-3">
                            <label class="form-label small fw-semibold text-dark mb-2">Status Laporan</label>
                            <select name="status" class="form-select border-2 shadow-none rounded-2 px-3" style="height: 42px; font-size: 13px;">
                                <option value="">Semua Status</option>
                                <option value="Menunggu" {{ request('status') == 'Menunggu' ? 'selected' : '' }}>Menunggu</option>
                                <option value="Proses" {{ request('status') == 'Proses' ? 'selected' : '' }}>Diproses</option>
                                <option value="Selesai" {{ request('status') == 'Selesai' ? 'selected' : '' }}>Selesai</option>
                            </select>
                        </div>

                        <div class="col-md-3">
                            <label class="form-label small fw-semibold text-dark mb-2">Bulan</label>
                            <select name="bulan" class="form-select border-2 shadow-none rounded-2 px-3" style="height: 42px; font-size: 13px;">
                                <option value="">Semua Bulan</option>
                                @foreach(range(1, 12) as $m)
                                <option value="{{ $m }}" {{ request('bulan') == $m ? 'selected' : '' }}>
                                    {{ \Carbon\Carbon::create()->month($m)->translatedFormat('F') }}
                                </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-3">
                            <label class="form-label small fw-semibold text-dark mb-2">Tahun</label>
                            <select name="tahun" class="form-select border-2 shadow-none rounded-2 px-3" style="height: 42px; font-size: 13px;">
                                <option value="">Semua Tahun</option>
                                @for($year = date('Y'); $year >= date('Y') - 2; $year--)
                                <option value="{{ $year }}" {{ request('tahun') == $year ? 'selected' : '' }}>{{ $year }}</option>
                                @endfor
                            </select>
                        </div>

                        <div class="col-md-3">
                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-primary fw-bold flex-grow-1 rounded-2 shadow-sm" style="height: 42px;">
                                    <i class="ti ti-adjustments-horizontal me-1"></i> Filter
                                </button>
                                <a href="{{ route('siswa.pengaduan.riwayat') }}" class="btn btn-outline-secondary border-2 fw-bold rounded-2 px-3 d-flex align-items-center justify-content-center"
                                    style="height: 42px;" title="Reset Filter">
                                    <i class="ti ti-refresh"></i>
                                </a>
                            </div>
                        </div>

                    </div>
                </form>
            </div>
        </div>

        <div class="row g-3">
            @forelse($pengaduan as $item)
            <div class="col-xl-4 col-md-6">
                <div class="card border-0 shadow-sm rounded-4 h-100 card-hover position-relative">
                    <div class="position-absolute top-0 end-0 m-3">
                        <span class="badge bg-white text-muted border shadow-sm">#{{ $totalPengaduan - ($pengaduan->firstItem() ? $pengaduan->firstItem() + $loop->index : $loop->iteration) + 1 }}</span>
                    </div>
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center mb-4">
                            <div class="status-indicator me-3">
                                @php $istat = $item->aspirasi->status ?? 'Menunggu'; @endphp
                                @if($istat == 'Menunggu')
                                <div class="status-badge status-menunggu"><i class="ti ti-clock"></i></div>
                                @elseif($istat == 'Proses')
                                <div class="status-badge status-proses"><i class="ti ti-loader"></i></div>
                                @elseif($istat == 'Selesai')
                                <div class="status-badge status-selesai"><i class="ti ti-check"></i></div>
                                @endif
                            </div>
                            <div class="flex-grow-1">
                                <h6 class="mb-0 fw-bold card-title-clamp" title="{{ $item->ket }}">
                                    {{ Str::words($item->ket, 7, '...') }}
                                </h6>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="text-muted x-small text-uppercase fw-bold mb-2 d-block" style="font-size: 0.7rem; letter-spacing: 0.5px;">Informasi Laporan</label>
                            <div class="bg-light p-2 rounded-3">
                                <p class="mb-1 fw-medium text-dark small">
                                    <i class="ti ti-tag me-1 text-primary"></i> {{ $item->kategori->ket_kategori ?? 'Umum' }}
                                </p>
                                <p class="mb-0 text-muted small">
                                    <i class="ti ti-calendar-event me-1"></i> {{ $item->created_at->format('d M Y, H:i') }}
                                </p>
                            </div>
                        </div>

                        <a href="{{ route('siswa.pengaduan.show', $item->id_pelaporan) }}" class="btn btn-outline-primary btn-sm w-100 rounded-3 py-2 fw-bold">
                            Lihat Progres Laporan <i class="ti ti-arrow-right ms-1"></i>
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