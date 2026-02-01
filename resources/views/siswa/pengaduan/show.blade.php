@extends('layout.main')

@section('title', 'Detail Pengaduan')

@push('styles')
<link rel="stylesheet" href="{{ asset('assets/css/siswa/show.css') }}?v={{ time() }}">
@endpush

@section('content')

<div class="siswa-show">
    <main id="main-content" class="py-4" style="background: #f4f7f9; min-height: 100vh;">
        <div class="container-fluid">
            <div class="row align-items-center mb-4">
                <div class="col-md-8">
                    <h3 class="fw-bold text-dark mb-0">Detail Pengaduan</h3>
                </div>
                <div class="col-md-4 text-md-end mt-3 mt-md-0">
                    <div class="d-inline-flex gap-2">
                        @php
                        $feedback = $aspirasiData?->feedback ?? null;
                        $currentStatus = $aspirasiData->status ?? 'Menunggu';
                        @endphp

                        @if(!$feedback && $currentStatus == 'Menunggu')
                        <a href="{{ route('siswa.pengaduan.editForm', $aspirasi->id_pelaporan) }}" class="btn btn-primary shadow-sm fw-bold px-3">
                            <i class="ti ti-pencil me-1"></i> Edit
                        </a>
                        <button class="btn btn-white border shadow-sm fw-bold px-3 text-danger" onclick="confirmCancel()">
                            <i class="ti ti-trash me-1"></i> Batalkan
                        </button>
                        @else
                        <span class="badge bg-secondary py-2 px-3 mt-4">Tidak dapat dibatalkan</span>
                        {{-- Tanggapan ditampilkan di panel sebelah; link "Lihat Tanggapan" dihapus --}}
                        @endif

                    </div>
                </div>
            </div>

            <div class="row g-4">
                <div class="col-lg-8">

                    <div class="card border-0 shadow-sm mb-4 overflow-hidden">
                        <div class="card-body p-4">
                            <div class="row position-relative">
                                @php
                                $statusList = [
                                'Menunggu' => ['icon' => 'ti-clock', 'title' => 'Menunggu'],
                                'Proses' => ['icon' => 'ti-settings', 'title' => 'Diproses'],
                                'Selesai' => ['icon' => 'ti-circle-check', 'title' => 'Selesai']
                                ];
                                $reached = true;
                                $currentStatus = $aspirasiData->status ?? $aspirasi->status ?? 'Menunggu';
                                @endphp
                                @foreach($statusList as $key => $val)
                                <div class="col text-center">
                                    <div class="d-flex align-items-center justify-content-center mb-2">
                                        <div class="step-dot {{ $reached ? 'step-dot-active' : '' }}">
                                            <i class="ti {{ $val['icon'] }}"></i>
                                        </div>
                                    </div>
                                    <span class="small fw-bold {{ $reached ? 'text-dark' : 'text-muted' }}">{{ $val['title'] }}</span>
                                </div>
                                @if($currentStatus == $key) @php $reached = false; @endphp @endif
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-header bg-white py-3 border-bottom border-light">
                            <div class="d-flex align-items-center">
                                <i class="ti ti-notes text-primary me-2 fs-4"></i>
                                <h6 class="m-0 fw-bold text-dark">Isi Laporan Anda</h6>
                            </div>
                        </div>
                        <div class="card-body p-4">
                            <div class="mb-4">
                                <label class="text-muted small text-uppercase fw-bold mb-2 d-block">Lokasi Kejadian</label>
                                <p class="fw-bold text-dark"><i class="ti ti-map-pin me-1 text-primary"></i> {{ $aspirasi->lokasi }}</p>
                            </div>

                            <div class="mb-4">
                                <label class="small fw-bold text-uppercase text-muted d-block mb-2">Deskripsi</label>
                                <div class="bg-light p-4 rounded-3" style="border-left: 4px solid #0d6efd;">
                                    <p class="mb-0 text-dark" style="white-space: pre-line; font-size: 0.97rem; line-height:1.6;">
                                        {{ $aspirasi->ket }}
                                    </p>
                                </div>
                            </div>

                            @if($aspirasi->gambar)
                            <div class="attachment-box mt-4">
                                <label class="small fw-bold text-muted text-uppercase d-block mb-3">Dokumentasi Terlampir</label>
                                <div class="position-relative d-inline-block w-100">
                                    <img src="{{ asset('storage/' . $aspirasi->gambar) }}" class="img-fluid rounded border shadow-sm" style="max-height: 500px; width: 100%; object-fit: contain; background: #eee;">
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="sticky-wrapper">

                        <div id="respon" class="card border-0 shadow-sm mb-4 overflow-hidden">
                            <div class="card-header bg-primary text-white py-3 border-0">
                                <div class="d-flex align-items-center">
                                    <i class="ti ti-message-dots me-2"></i>
                                    <h6 class="m-0 fw-bold">Respon Admin</h6>
                                </div>
                            </div>
                            <div class="card-body p-4">
                                @php
                                $feedback = $aspirasiData?->feedback ?? null;
                                @endphp
                                @if($feedback)
                                <div class="p-3 bg-light rounded-3 border-start border-3 border-primary">
                                    <p class="mb-3 text-dark small lh-base">{{ $feedback }}</p>
                                    <div class="d-flex align-items-center mt-2">
                                        <div class="bg-primary rounded-circle me-2" style="width: 8px; height: 8px;"></div>
                                        <span class="small fw-bold text-primary">Admin</span>
                                    </div>
                                </div>
                                @else
                                <div class="text-center py-4">
                                    <div class="spinner-grow spinner-grow-sm text-muted opacity-25 mb-3" role="status"></div>
                                    <p class="small text-muted mb-0 italic">Belum ada tanggapan resmi.</p>
                                </div>
                                @endif
                            </div>
                        </div>

                        <div class="card border-0 shadow-sm">
                            <div class="card-body p-4">
                                <label class="text-muted small text-uppercase fw-bold mb-3 d-block">Informasi Laporan</label>

                                <div class="d-flex justify-content-between mb-3">
                                    <span class="text-muted small">Kategori</span>
                                    <span class="badge bg-primary bg-opacity-10 text-primary border border-primary border-opacity-10">{{ $aspirasi->kategori->ket_kategori ?? 'Umum' }}</span>
                                </div>

                                <div class="d-flex justify-content-between mb-3">
                                    <span class="text-muted small">Tgl Kirim</span>
                                    <span class="small fw-bold text-dark">{{ $aspirasi->created_at->format('d M Y, H:i') }}</span>
                                </div>

                                <div class="d-flex justify-content-between mb-3">
                                    <span class="text-muted small">Nomor Pengaduan</span>
                                    <span class="small fw-bold text-primary">ASP-{{ sprintf('%05d', $aspirasi->id_pelaporan) }}</span>
                                </div>
                            </div>
                        </div>
                        <a href="{{ route('siswa.pengaduan.riwayat') }}" class="btn btn-outline-primary mt-4 w-100 fw-bold rounded-3">
                            <i class="ti ti-arrow-left me-1"></i> Kembali
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </main>


    <div class="modal fade" id="cancelModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered modal-sm">
            <div class="modal-content border-0 shadow-lg rounded-4">
                <div class="modal-body p-4 text-center">
                    <div class="bg-danger bg-opacity-10 text-danger rounded-circle d-flex align-items-center justify-content-center mx-auto mb-3" style="width: 60px; height: 60px;">
                        <i class="ti ti-alert-triangle fs-1"></i>
                    </div>
                    <h5 class="fw-bold">Batalkan?</h5>
                    <p class="text-muted small">Laporan ini akan dihentikan dan tidak akan diproses lebih lanjut.</p>
                    <div class="d-flex gap-2 mt-4">
                        <button type="button" class="btn btn-light w-100 fw-bold rounded-3" data-bs-dismiss="modal">Tutup</button>
                        <form method="POST" action="{{ route('siswa.pengaduan.cancel', $aspirasi->id_pelaporan) }}" class="w-100">
                            @csrf @method('PATCH')
                            <button type="submit" class="btn btn-danger w-100 fw-bold rounded-3">Ya, Batal</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function confirmCancel() {
            new bootstrap.Modal(document.getElementById('cancelModal')).show();
        }
    </script>

</div>

@endsection