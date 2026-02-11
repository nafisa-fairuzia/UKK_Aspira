@extends('layout.main')

@section('title', 'Detail Pengaduan')

@push('styles')
<link rel="stylesheet" href="{{ asset('assets/css/admin/show.css') }}?v={{ time() }}">
<style>
    /* Tambahan CSS sederhana untuk memastikan stepper terlihat oke */
    .step-dot {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background: #e9ecef;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto;
        color: #adb5bd;
    }

    .step-dot-active {
        background: #0d6efd;
        color: #fff;
    }
</style>
@endpush

@section('content')
<div class="show-admin">
    <main id="main-content" class="py-4" style="background: #f4f7f9; min-height: 100vh;">
        <div class="container mt-4">

            {{-- Header --}}
            <div class="row align-items-center mb-4">
                <div class="col-md-8">
                    <h4 class="fw-bold text-dark mb-0">Detail Pengaduan</h4>
                </div>
                <div class="col-md-4 text-md-end">
                    <div class="d-inline-flex align-items-center p-2 px-3 bg-white border rounded shadow-sm">
                        <div class="me-3 text-start">
                            <small class="text-muted d-block text-uppercase fw-bold" style="font-size: 9px; letter-spacing: 0.5px;">NOMOR</small>
                            <span class="fw-bold text-primary">ASP-{{ sprintf('%05d', $pengaduan->id_pelaporan) }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row g-4">
                {{-- Kolom Kiri: Informasi Utama --}}
                <div class="col-lg-8">

                    {{-- Status Stepper --}}
                    <div class="card border-0 shadow-sm mb-4 overflow-hidden">
                        <div class="card-body p-4">
                            <div class="row position-relative">
                                @php
                                $statusList = [
                                'Menunggu' => ['icon' => 'ti-clock', 'title' => 'Menunggu'],
                                'Proses' => ['icon' => 'ti-settings', 'title' => 'Diproses'],
                                'Selesai' => ['icon' => 'ti-circle-check', 'title' => 'Selesai']
                                ];
                                $currentStatus = $pengaduan->aspirasi->status ?? 'Menunggu';

                                $statusKeys = array_keys($statusList);
                                $currentIndex = array_search($currentStatus, $statusKeys);
                                @endphp

                                @foreach($statusList as $key => $val)
                                @php $loopIndex = array_search($key, $statusKeys); @endphp
                                <div class="col text-center">
                                    <div class="d-flex align-items-center justify-content-center mb-2">
                                        <div class="step-dot {{ $loopIndex <= $currentIndex ? 'step-dot-active' : '' }}">
                                            <i class="ti {{ $val['icon'] }}"></i>
                                        </div>
                                    </div>
                                    <span class="small fw-bold {{ $loopIndex <= $currentIndex ? 'text-dark' : 'text-muted' }}">
                                        {{ $val['title'] }}
                                    </span>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    {{-- Identitas Pelapor --}}
                    <div class="card border-0 shadow-sm mb-4 overflow-hidden">
                        <div class="row g-0">
                            <div class="col-md-7 border-end">
                                <div class="card-body p-4">
                                    <label class="text-muted small text-uppercase fw-bold mb-3 d-block">Identitas Pelapor</label>
                                    <div class="d-flex align-items-center">
                                        <div class="flex-shrink-0">
                                            @if($pengaduan->siswa && $pengaduan->siswa->profile_pic)
                                            <img src="{{ asset('storage/' . $pengaduan->siswa->profile_pic) }}"
                                                class="rounded-3 border shadow-sm"
                                                style="width: 56px; height: 56px; object-fit: cover;"
                                                onerror="this.onerror=null; this.src='https://ui-avatars.com/api/?name={{ urlencode($pengaduan->siswa->nama) }}&color=7F9CF5&background=EBF4FF';">
                                            @else
                                            <div class="rounded-3 bg-primary bg-opacity-10 text-primary d-flex align-items-center justify-content-center" style="width: 56px; height: 56px;">
                                                <i class="ti ti-user fs-2"></i>
                                            </div>
                                            @endif
                                        </div>
                                        <div class="flex-grow-1 ms-3">
                                            <h5 class="fw-bold mb-0 text-dark">{{ $pengaduan->siswa->nama ?? 'N/A' }}</h5>
                                            <p class="text-secondary mb-0 small">NIS: {{ $pengaduan->nis }} • Kelas {{ $pengaduan->siswa->kelas->nama_kelas ?? '-' }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-5 bg-light bg-opacity-50">
                                <div class="card-body p-4">
                                    <div class="mb-3">
                                        <small class="text-muted d-block fw-bold text-uppercase" style="font-size: 10px;">Kategori Pengaduan</small>
                                        <span class="badge bg-white text-primary border border-primary border-opacity-25 mt-1 px-2 py-1">{{ $pengaduan->kategori->ket_kategori ?? 'Umum' }}</span>
                                    </div>
                                    <div>
                                        <small class="text-muted d-block fw-bold text-uppercase" style="font-size: 10px;">Dikirim Pada</small>
                                        <span class="text-dark fw-medium small">{{ $pengaduan->formatted_created_date }}</span>
                                        <span class="text-muted small mx-1">•</span>
                                        <span class="text-dark fw-medium small">{{ $pengaduan->formatted_created_time }} WIB</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Deskripsi & Gambar --}}
                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-header bg-white py-3 border-bottom border-light">
                            <div class="d-flex align-items-center">
                                <i class="ti ti-notes text-primary me-2 fs-4"></i>
                                <h6 class="m-0 fw-bold text-dark">Detail Deskripsi</h6>
                            </div>
                        </div>
                        <div class="card-body p-4">
                            <div class="mb-4">
                                <label class="small fw-bold text-uppercase text-muted d-block mb-2">Deskripsi</label>
                                <div class="bg-light p-4 rounded-3" style="border-left: 4px solid #0d6efd;">
                                    <p class="mb-0 text-dark" >
                                        {{ $pengaduan->ket ?? $pengaduan->deskripsi }}
                                    </p>
                                </div>
                            </div>

                            @if($pengaduan->gambar)
                            <div class="attachment-box mt-4">
                                <label class="small fw-bold text-muted text-uppercase d-block mb-3">Dokumentasi Terlampir</label>
                                <div class="position-relative d-inline-block w-100">
                                    <img src="{{ asset('storage/' . $pengaduan->gambar) }}" class="img-fluid rounded border shadow-sm" style="max-height: 600px; width: 100%; object-fit: cover;">
                                    <div class="position-absolute bottom-0 start-0 m-3">
                                        <a href="{{ asset('storage/' . $pengaduan->gambar) }}" target="_blank" class="btn btn-dark btn-sm rounded-pill px-3 shadow">
                                            <i class="ti ti-maximize me-1"></i> Perbesar Gambar
                                        </a>
                                    </div>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>

                {{-- Kolom Kanan: Umpan Balik Admin --}}
                <div class="col-lg-4">
                    <div class="sticky-top" style="top: 80px;">
                        <div class="card border-0 shadow-sm overflow-hidden">
                            <div class="card-header bg-primary text-white py-3 border-0">
                                <div class="d-flex align-items-center">
                                    <i class="ti ti-message-2 me-2"></i>
                                    <h6 class="m-0 fw-bold">Umpan Balik</h6>
                                </div>
                            </div>
                            <div class="card-body p-4">
                                @if(session('success'))
                                <div class="mb-3 alert alert-success d-flex align-items-center border-0 small py-2">
                                    <i class="ti ti-circle-check me-2"></i> Berhasil diperbarui
                                </div>
                                @endif

                                @if(session('error'))
                                <div class="mb-3 alert alert-danger d-flex align-items-center border-0 small py-2">
                                    <i class="ti ti-alert-circle me-2"></i> {{ session('error') }}
                                </div>
                                @endif

                                <form method="POST" action="{{ route('admin.pengaduan.update', $pengaduan->id_pelaporan) }}" id="formUpdate">
                                    @csrf
                                    @method('PUT')

                                    <div class="mb-4">
                                        <label class="form-label small fw-bold text-muted text-uppercase">Tentukan Status</label>
                                        <select name="status" class="form-select border-2 shadow-none py-2 fw-medium" id="statusSelect" {{ $currentStatus == 'Selesai' ? 'disabled' : '' }}>
                                            @foreach(['Menunggu', 'Proses', 'Selesai'] as $st)
                                            <option value="{{ $st }}" {{ $currentStatus == $st ? 'selected' : '' }}
                                                {{ ($st == 'Menunggu' && $currentStatus != 'Menunggu') ? 'disabled' : '' }}>
                                                {{ $st }}
                                            </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="mb-4">
                                        <label class="form-label small fw-bold text-muted text-uppercase">Respon Resmi</label>
                                        <textarea name="tanggapan_admin" id="tanggapan_admin" class="form-control border-2 bg-light shadow-none p-3 @error('tanggapan_admin') is-invalid @enderror" rows="5" placeholder="Berikan arahan atau solusi..." style="font-size: 0.9rem;" {{ $currentStatus == 'Selesai' ? 'disabled' : '' }}>{{ $pengaduan->aspirasi?->feedback ?? '' }}</textarea>
                                        @error('tanggapan_admin')
                                        <div class="invalid-feedback d-block mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <button type="submit" class="btn btn-primary w-100 fw-bold py-2 shadow-sm" id="submitBtn" {{ $currentStatus == 'Selesai' ? 'disabled' : '' }}>
                                        <i class="ti ti-device-floppy me-1"></i> Perbarui
                                    </button>
                                </form>

                                @if($currentStatus == 'Selesai')
                                <div class="mt-3 alert alert-info d-flex align-items-center border-0 small py-2">
                                    <i class="ti ti-info-circle me-2"></i> Pengaduan sudah selesai, tidak dapat diubah
                                </div>
                                @endif
                            </div>
                        </div>

                        <a href="{{ route('admin.pengaduan.index') }}" class="btn btn-outline-primary mt-4 w-100 fw-bold rounded-3">
                            <i class="ti ti-arrow-narrow-left me-1"></i> Kembali
                        </a>
                    </div>
                </div>
            </div>
        </div> 
    </main>
</div>
@endsection