@extends('layout.main')

@section('title', 'Edit Pengaduan')

@push('styles')
<link rel="stylesheet" href="{{ asset('assets/css/siswa/create.css') }}?v={{ time() }}">
@endpush

@section('content')

<main id="main-content" class="py-4 bg-light min-vh-100">
    <div class="siswa-create">
        <div class="row mb-4 mt-4">
            <div class="col-12">
                <div class="p-4 rounded-4 shadow-sm border-0 position-relative overflow-hidden"
                    style="background: linear-gradient(135deg, #0ea5e9 0%, #2563eb 100%);">
                    <div class="position-absolute text-white top-0 end-0 mt-n4 me-n4">
                        <i class="ti ti-message-report" style="font-size: 150px; opacity: 20%;"></i>
                    </div>
                    <div class="position-relative z-1 text-white">
                        <h3 class="fw-bold mb-1">Edit Pengaduan</h3>
                        <p class="mb-0 opacity-75">Perbarui detail pengaduan Anda.</p>
                    </div>
                </div>
            </div>
        </div>

        <form method="POST" action="{{ route('siswa.pengaduan.update', $aspirasi->id_pelaporan) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="row g-4">
                <div class="col-lg-8 col-xl-9">
                    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                        <div class="card-header bg-white border-0 pt-4 px-4 pb-0">
                            <div class="d-flex align-items-center">
                                <div class="p-2 bg-primary-soft rounded-3 me-3 text-primary">
                                    <i class="ti ti-edit fs-4"></i>
                                </div>
                                <h5 class="fw-bold mb-0">Detail Pengaduan</h5>
                            </div>
                        </div>
                        <div class="card-body p-4">
                            <div class="row g-4">
                                <div class="col-md-6">
                                    <label for="id_kategori" class="form-label small fw-bold text-muted">KATEGORI <span class="text-danger">*</span></label>
                                    <div class="input-modern-group">
                                        <select name="id_kategori" id="id_kategori" class="form-select border-0 shadow-none px-0" required>
                                            <option value="" disabled>Pilih Kategori...</option>
                                            @foreach($kategori as $kat)
                                            <option value="{{ $kat->id_kategori }}" {{ $aspirasi->id_kategori == $kat->id_kategori ? 'selected' : '' }}>
                                                {{ $kat->ket_kategori }}
                                            </option>
                                            @endforeach
                                        </select>
                                        <div class="input-line"></div>
                                    </div>
                                    @error('id_kategori') <div class="text-danger x-small mt-1">{{ $message }}</div> @enderror
                                </div>

                                <div class="col-md-6">
                                    <label for="lokasi" class="form-label small fw-bold text-muted">LOKASI <span class="text-danger">*</span></label>
                                    <div class="input-modern-group">
                                        <input type="text" name="lokasi" id="lokasi" class="form-control border-0 shadow-none px-0"
                                            placeholder="Contoh: Depan Kantin" value="{{ $aspirasi->lokasi }}" required>
                                        <div class="input-line"></div>
                                    </div>
                                    @error('lokasi') <div class="text-danger x-small mt-1">{{ $message }}</div> @enderror
                                </div>

                                <div class="col-12">
                                    <label for="ket" class="form-label small fw-bold text-muted">DESKRIPSI <span class="text-danger">*</span></label>
                                    <div class="p-3 bg-light rounded-4">
                                        <textarea name="ket" id="ket" class="form-control border-0 bg-transparent shadow-none"
                                            rows="10" placeholder="Ceritakan detail masalah..."
                                            maxlength="255" required style="resize: none;">{{ $aspirasi->ket }}</textarea>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center mt-2 px-1">
                                        <span class="x-small text-muted"><i class="ti ti-info-circle-filled me-1 text-primary"></i>Maksimal 255 karakter.</span>
                                        <span id="charCount" class="badge rounded-pill bg-primary px-3 fw-normal">{{ strlen($aspirasi->ket) }} / 255</span>
                                    </div>
                                    @error('ket') <div class="text-danger x-small mt-1">{{ $message }}</div> @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-xl-3">
                    <div class="d-flex flex-column gap-4">
                        <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                            <div class="card-body p-4 text-center">
                                <h6 class="fw-bold text-start mb-3">Lampiran Bukti</h6>
                                <div class="upload-interactive" id="drop-area">
                                    <input type="file" name="gambar" id="gambar" class="d-none" accept="image/*">
                                    <label for="gambar" class="m-0 cursor-pointer w-100">
                                        <div id="upload-ui" class="py-3">
                                            <div class="icon-pulse mx-auto mb-2 text-primary">
                                                <i class="ti ti-cloud-upload fs-1"></i>
                                            </div>
                                            <p class="small fw-bold mb-0">Klik Untuk Cari</p>
                                            <span class="x-small text-muted opacity-75">Sertakan foto bukti</span>
                                        </div>
                                        <div id="preview-ui" class="d-none">
                                            <img id="previewImg" src="" class="img-fluid rounded-3 shadow-sm border">
                                            <div class="mt-2 x-small text-primary fw-bold"><i class="ti ti-refresh me-1"></i>Ganti Foto</div>
                                        </div>
                                    </label>
                                </div>
                                <button type="button" id="clearImage" class="btn btn-sm btn-outline-danger border-0 w-100 mt-2 {{ $aspirasi->gambar ? '' : 'd-none' }}">
                                    <i class="ti ti-trash me-1"></i> Batalkan Foto
                                </button>
                            </div>
                        </div>

                        <div class="card border-0 bg-white shadow-sm rounded-4 overflow-hidden">
                            <div class="p-4 bg-light text-center border-bottom border-white">
                                <div class="text-primary mb-2"><i class="ti ti-shield-check fs-2"></i></div>
                                <p class="small text-muted mb-0 px-2">Perubahan akan disimpan secara aman.</p>
                            </div>
                            <div class="p-4">
                                <button type="submit" class="btn btn-primary w-100 py-2 rounded-3 fw-bold shadow-sm mb-3">
                                    Update <i class="ti ti-arrow-right ms-2"></i>
                                </button>
                                <a href="{{ route('siswa.pengaduan.show', $aspirasi->id_pelaporan) }}" class="btn btn-light w-100 py-2 btn-sm text-muted">Batal</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</main>

@push('scripts')
<script>
    window.appData = {
        hasExistingImage: Boolean("{{ $aspirasi->gambar }}"),
        existingImageSrc: "{{ $aspirasi->gambar ? asset('storage/' . $aspirasi->gambar) : '' }}"
    };
</script>
<script src="{{ asset('assets/js/siswa/pengaduan-form.js') }}?v={{ time() }}"></script>
@endpush

@endsection