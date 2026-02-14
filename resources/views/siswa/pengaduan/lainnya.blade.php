@extends('layout.main')

@section('title', 'Pengaduan Siswa Lain')

@section('content')
<div class="pengaduan-admin">
    <main id="main-content" class="py-4 bg-light min-vh-100">
        <div class="container-l" style="overflow: visible;">

            <div class="d-flex align-items-center justify-content-between mb-4 mt-4">
                <h4 class="fw-bold text-dark mb-0">Daftar Pengaduan Siswa Lain</h4>
                <a href="{{ route('siswa.pengaduan.create') }}" class="btn btn-primary rounded-pill px-4">Buat Pengaduan</a>
            </div>
            <div class="card border-0 shadow-sm rounded-3 overflow-hidden">
                <div class="card-header bg-white py-3 border-bottom">
                    <div class="d-flex align-items-center justify-content-between">
                        <div class="d-flex align-items-center">
                            <i class="ti ti-message-report me-2 text-primary fs-4"></i>
                            <h6 class="mb-0 fw-bold text-dark">Pengaduan Masuk</h6>
                        </div>
                    </div>
                </div>

                <div class="card-body p-0">
                    <div class="table-responsive p-3">
                        <table id="pengaduanTableSiswa" class="table table-hover align-middle mb-0 w-100">
                            <thead class="bg-light">
                                <tr>
                                    <th class="text-center text-dark" style="width: 5%;">No</th>
                                    <th class="text-dark" style="width: 30%;">Informasi Pelapor</th>
                                    <th class="text-dark" style="width: 12%;">Kategori</th>
                                    <th class="text-dark" style="width: 25%;">Keterangan</th>
                                    <th class="text-center text-dark" style="width: 10%;">Status</th>
                                    <th class="text-dark" style="width: 13%;">Tanggal</th>
                                    <th class="text-end pe-4 text-dark" style="width: 5%;">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($pengaduan as $p)
                                <tr>
                                    <td class="text-center text-muted small fw-bold">{{ $pengaduan->firstItem() + $loop->index }}</td>
                                    <td>
                                        <div class="d-flex align-items-center gap-2">
                                            <x-avatar :user="$p->siswa" size="35" class="me-0" />
                                            <div>
                                                <div class="fw-bold text-dark mb-0">{{ $p->siswa->nama ?? 'N/A' }}</div>
                                                <small class="text-muted">Kelas: {{ $p->siswa->kelas->nama_kelas ?? 'N/A' }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="text-dark fw-medium small">{{ $p->kategori->ket_kategori ?? 'Umum' }}</span>
                                    </td>
                                    <td class="text-truncate" style="max-width: 360px;">{{ Str::limit($p->ket ?? '-', 120) }}</td>
                                    <td class="text-center">
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
                                        <div class="small fw-medium">{{ $p->formatted_created_date }}</div>
                                        <div class="text-muted x-small">{{ $p->formatted_created_time }} WIB</div>
                                    </td>

                                    <td class="text-end pe-3">
                                        <a href="{{ route('siswa.pengaduan.showPublic', $p->id_pelaporan) }}" class="btn btn-sm btn-white border shadow-sm px-2" title="Detail">
                                            <i class="ti ti-eye text-primary" style="font-size: 16px;"></i>
                                        </a>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="7">
                                        <p class="text-center text-muted mb-0">Tidak ada pengaduan ditemukan.</p>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="d-flex justify-content-center mt-4">
                {{ $pengaduan->appends(request()->query())->links() }}
            </div>
        </div>
    </main>
</div>
@endsection