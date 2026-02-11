@extends('layout.main')

@section('title', 'Kelola Kategori')

@section('content')

<div class="index-kategori-admin">

    <main id="main-content" class="py-4 bg-light min-vh-100 ">
        <div class="overflow-hidden">
            <div class="row mb-4 align-items-center mt-4">
                <div class="col">
                    <div>
                        <h3 class="fw-bold text-dark">Manajemen Kategori</h3>
                    </div>
                </div>
                <div class="col-auto">
                    <button type="button" class="btn btn-primary rounded-2 shadow-sm px-3 fw-bold" onclick="openKategoriModal('add')">
                        <i class="ti ti-plus me-1"></i> Tambah Kategori
                    </button>
                </div>
            </div>

            <x-alert type="success" />
            <x-alert type="error" />

            <div class="card border-0 shadow-sm rounded-3 overflow-hidden">
                <div class="card-header bg-white py-3 border-bottom">
                    <div class="d-flex align-items-center">
                        <i class="ti ti-category me-2 text-primary fs-4"></i>
                        <h6 class="mb-0 fw-bold">Daftar Kategori</h6>
                    </div>
                </div>

                <div class="card-body p-0">
                    <div class="table-responsive p-3">
                        <table id="kategoriTable" class="table table-hover align-middle mb-0 w-100">
                            <thead class="bg-light">
                                <tr>
                                    <th class="text-center text-dark" style="width: 5%">No</th>
                                    <th class="text-dark" style="width: 40%">Nama Kategori</th>
                                    <th class="text-dark" style="width: 20%">Tanggal Dibuat</th>
                                    <th class="text-center text-dark" style="width: 15%">Jumlah</th>
                                    <th class="text-end pe-4 text-dark" style="width: 20%">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($kategori as $item)
                                <tr>
                                    <td class="text-center text-muted small">{{ $kategori->firstItem() + $loop->index }}</td>
                                    <td>
                                        <div class="d-flex align-items-center gap-3">
                                            <div class="avatar-sm bg-primary-subtle rounded-circle d-flex align-items-center justify-content-center" style="width: 35px; height: 35px; flex-shrink: 0;">
                                                <i class="ti ti-tag text-primary small"></i>
                                            </div>
                                            <div class="text-dark fw-medium">{{ $item->ket_kategori }}</div>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="text-muted small">{{ $item->created_at?->format('d M Y') ?? '-' }}</span>
                                    </td>
                                    <td class="text-center">
                                        <span class="badge bg-primary-subtle text-primary rounded-pill px-3 d-inline-flex align-items-center gap-1">
                                            <span>{{ $item->laporan_count ?? 0 }}</span>
                                            <span>Pengaduan</span>
                                        </span>
                                    </td>
                                    <td class="text-end pe-3">
                                        <div class="d-flex gap-1 justify-content-end">
                                            <button
                                                type="button"
                                                class="btn btn-sm btn-white border shadow-sm px-2"
                                                title="Edit"
                                                onclick="editKategori('{{ $item->id_kategori }}', '{{ addslashes($item->ket_kategori) }}')">
                                                <i class="ti ti-edit text-primary"></i>
                                            </button>
                                            <form
                                                method="POST"
                                                action="{{ route('admin.kategori.destroy', $item->id_kategori) }}"
                                                class="d-inline"
                                                onsubmit="return confirm('Hapus kategori ini?');">
                                                @csrf
                                                @method('DELETE')
                                                <button
                                                    type="submit"
                                                    class="btn btn-sm btn-white border shadow-sm px-2"
                                                    title="Hapus">
                                                    <i class="ti ti-trash text-danger"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <x-empty-state colspan="5" icon="ti-category" message="Tidak ada data kategori" />
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="d-flex justify-content-center mt-4">
                {{ $kategori->links() }}
            </div>
        </div>
    </main>

    <div class="modal fade" id="kategoriModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" style="max-width: 400px;">
            <div class="modal-content border-0 shadow rounded-3">
                <div class="modal-header border-bottom px-4">
                    <h5 id="kategoriModalTitle" class="fw-bold text-dark mb-0">Form Kategori</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form id="kategoriModalForm" method="POST">
                    @csrf
                    <div class="modal-body p-4">
                        <div class="mb-3">
                            <label class="form-label small fw-bold text-muted">NAMA KATEGORI</label>
                            <input type="text" name="ket_kategori" id="ket_kategori_input" class="form-control border shadow-none @error('ket_kategori') border-warning @enderror" required>
                            @error('ket_kategori')
                            <small class="text-warning d-block mt-2">
                                <i class="ti ti-alert-circle me-1"></i>
                                @if(str_contains($message, 'unique'))
                                Data sudah ada
                                @else
                                {{ $message }}
                                @endif
                            </small>
                            @enderror
                        </div>
                    </div>
                    <div class="modal-footer border-0 p-4 pt-0">
                        <button type="button" class="btn btn-light fw-bold" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" id="kategoriModalSubmit" class="btn btn-primary fw-bold">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</div>

@push('scripts')
<script>
    window.routeAdminKategoriStore = "{{ route('admin.kategori.store') }}";
</script>
<script src="{{ asset('assets/js/admin/kategori-management.js') }}?v={{ time() }}"></script>
<script src="{{ asset('assets/js/validation.js') }}?v={{ time() }}"></script>
@endpush

@endsection