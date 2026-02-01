@extends('layout.main')

@section('title', 'Kelola Pengaduan')

@push('styles')
<link rel="stylesheet" href="{{ asset('assets/css/admin/index.css') }}?v={{ time() }}">
@endpush

@section('content')

<div class="pengaduan-admin">

    <main id="main-content" class="py-4 bg-light min-vh-100">
        <div class="container-l" style="overflow: visible;">

            <div class="row mb-4 align-items-center">
                <div class="col">
                    <h4 class="fw-bold text-dark mb-0">Daftar Pengaduan</h4>
                </div>
            </div>

            @if(session('success'))
            <div class="alert alert-success border-0 shadow-sm rounded-3 mb-4 py-2 small" role="alert">
                <i class="ti ti-check me-2"></i> {{ session('success') }}
            </div>
            @endif

            <div class="card border-0 shadow-sm mb-4 rounded-3">
                <div class="card-body p-4">
                    <form action="{{ route('admin.pengaduan.index') }}" method="GET">
                        <div class="row g-3 align-items-end">

                            <div class="col-md-2">
                                <label class="form-label small fw-semibold text-dark mb-2">Tanggal</label>
                                <input type="date" name="tanggal" class="form-control border-2 shadow-none rounded-2 px-3"
                                    style="height: 42px; font-size: 13px;" value="{{ request('tanggal') }}">
                            </div>

                            <div class="col-md-2">
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
                                <label class="form-label small fw-semibold text-dark mb-2">Cari Pelapor</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-white border-2 border-end-0 text-muted px-3">
                                        <i class="ti ti-search"></i>
                                    </span>
                                    <input type="text" name="siswa" class="form-control border-2 border-start-0 shadow-none rounded-end-2"
                                        style="height: 42px; font-size: 13px;" placeholder="Nama atau NIS..." value="{{ request('siswa') }}">
                                </div>
                            </div>

                            <div class="col-md-2">
                                <label class="form-label small fw-semibold text-dark mb-2">Kategori</label>
                                <select name="kategori" class="form-select border-2 shadow-none rounded-2 px-3" style="height: 42px; font-size: 13px;">
                                    <option value="">Semua Kategori</option>
                                    @foreach($kategori as $kat)
                                    <option value="{{ $kat->id_kategori }}" {{ request('kategori') == $kat->id_kategori ? 'selected' : '' }}>
                                        {{ $kat->ket_kategori }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-3">
                                <div class="d-flex gap-2">
                                    <button type="submit" class="btn btn-primary fw-bold flex-grow-1 rounded-2 shadow-sm" style="height: 42px; ">
                                        <i class="ti ti-adjustments-horizontal me-1"></i> Filter
                                    </button>
                                    <a href="{{ route('admin.pengaduan.index') }}" class="btn btn-outline-secondary border-2 fw-bold rounded-2 px-3 d-flex align-items-center justify-content-center"
                                        style="height: 42px;" title="Reset Filter">
                                        <i class="ti ti-refresh"></i>
                                    </a>
                                </div>
                            </div>

                        </div>
                    </form>
                </div>
            </div>

            <div class="card border-0 shadow-sm rounded-3 overflow-hidden">
                <div class="card-header bg-white py-3 border-bottom">
                    <div class="d-flex align-items-center justify-content-between">
                        <div class="d-flex align-items-center">
                            <i class="ti ti-message-report me-2 text-primary fs-4"></i>
                            <h6 class="mb-0 fw-bold">Laporan Masuk</h6>
                        </div>
                    </div>
                </div>

                <div class="card-body p-0">
                    <div class="table-responsive p-3">
                        <table id="pengaduanTable" class="table table-hover align-middle mb-0 w-100">
                            <thead class="bg-light">
                                <tr>
                                    <th class="text-center" style="width: 5%">No</th>
                                    <th style="width: 25%">Informasi Pelapor</th>
                                    <th style="width: 15%">Kategori</th>
                                    <th class="text-center" style="width: 30%">Status</th>
                                    <th style="width: 30%">Tanggal</th>
                                    <th class="text-center" style="width: 20%">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($pengaduan as $p)
                                <tr>
                                    <td class="text-center text-muted small fw-bold">{{ $pengaduan->firstItem() + $loop->index }}</td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            @if($p->siswa && $p->siswa->profile_pic)
                                            <img src="{{ asset('storage/' . $p->siswa->profile_pic) }}"
                                                class="rounded-circle me-2 border shadow-sm"
                                                style="width: 35px; height: 35px; object-fit: cover; flex-shrink: 0;"
                                                onerror="this.onerror=null; this.src='https://ui-avatars.com/api/?name={{ urlencode($p->siswa->nama) }}&color=7F9CF5&background=EBF4FF';">
                                            @else
                                            <div class="avatar-sm me-2 bg-primary-subtle rounded-circle d-flex align-items-center justify-content-center" style="width: 35px; height: 35px; flex-shrink: 0;">
                                                <span class="text-primary fw-bold small">{{ substr($p->siswa->nama ?? 'S', 0, 1) }}</span>
                                            </div>
                                            @endif
                                            <div>
                                                <div class="fw-bold text-dark mb-0">{{ $p->siswa->nama ?? 'N/A' }}</div>
                                                <small class="text-muted">Kelas: {{ $p->siswa->kelas->nama_kelas }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="text-dark fw-medium small">{{ $p->kategori->ket_kategori ?? 'Umum' }}</span>
                                    </td>
                                    <td class="text-center ">
                                        @php
                                        $currentStatus = $p->aspirasi->status ?? 'Menunggu';
                                        $badgeClass = match($currentStatus) {
                                        'Menunggu' => 'bg-warning-subtle text-warning border-warning-subtle',
                                        'Proses' => 'bg-primary-subtle text-primary border-primary-subtle',
                                        'Selesai' => 'bg-success-subtle text-success border-success-subtle',
                                        default => 'bg-light text-secondary border'
                                        };
                                        @endphp
                                        <span class="badge rounded-pill border {{ $badgeClass }} px-3 py-1" style="min-width: 90px; font-size: 11px;">
                                            {{ $currentStatus }}
                                        </span>
                                    </td>
                                    <td>
                                        <div class="small fw-medium">{{ $p->created_at->format('d M Y') }}</div>
                                        <div class="text-muted x-small">{{ $p->created_at->format('H:i') }} WIB</div>
                                    </td>
                                    <td class="text-end pe-3">
                                        <div class="d-flex gap-1 justify-content-end">
                                            <a href="{{ route('admin.pengaduan.show', $p->id_pelaporan) }}" class="btn btn-sm btn-white border shadow-sm px-2" title="Detail">
                                                <i class="ti ti-eye text-primary"></i>
                                            </a>

                                            <div class="dropdown">
                                                <button class="btn btn-sm btn-white border shadow-sm dropdown-toggle fw-bold" type="button" data-bs-toggle="dropdown">
                                                    Update
                                                </button>
                                                <ul class="dropdown-menu dropdown-menu-end shadow-lg border-0 p-2">
                                                    <li><small class="dropdown-header text-uppercase opacity-50">Ganti Status:</small></li>
                                                    @foreach(['Menunggu', 'Proses', 'Selesai'] as $st)
                                                    @php $pStatus = $p->aspirasi->status ?? 'Menunggu'; @endphp
                                                    @if($st == 'Menunggu' && $pStatus != 'Menunggu')
                                                    @continue
                                                    @endif
                                                    @if($pStatus == 'Selesai')
                                                    @continue
                                                    @endif
                                                    <li>
                                                        <form action="{{ route('admin.pengaduan.update', $p->id_pelaporan) }}" method="POST">
                                                            @csrf @method('PUT')
                                                            <input type="hidden" name="status" value="{{ $st }}">
                                                            <button type="submit" class="dropdown-item rounded-2 {{ $pStatus == $st ? 'active disabled' : '' }}">
                                                                <i class="ti ti-{{ $st == 'Menunggu' ? 'clock' : ($st == 'Proses' ? 'loader' : 'check') }} me-1"></i> {{ $st }}
                                                            </button>
                                                        </form>
                                                    </li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="d-flex justify-content-center mt-4">
                {{ $pengaduan->links() }}
            </div>
        </div>
    </main>
</div>

@endsection
