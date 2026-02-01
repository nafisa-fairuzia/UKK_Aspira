@extends('layout.main')

@section('title', 'Kelola Kategori')

@section('content')

<div class="index-kategori-admin">

    <main id="main-content" class="py-4 bg-light min-vh-100">
        <div class="overflow-hidden">
            <div class="row mb-4 align-items-center">
                <div class="col">
                    <div>
                        <h3 class="fw-bold text-dark">Manajemen Kategori</h3>
                    </div>
                </div>
                <div class="col-auto">
                    <button class="btn btn-primary rounded-2 shadow-sm px-3 fw-bold" data-bs-toggle="modal" data-bs-target="#addKategoriModal">
                        <i class="ti ti-plus me-1"></i> Tambah Kategori
                    </button>
                </div>
            </div>

            @if(session('success'))
            <div class="alert alert-success border-0 shadow-sm rounded-3 mb-4 py-2 small" role="alert">
                <i class="ti ti-check me-2"></i> {{ session('success') }}
            </div>
            @endif

            @if(session('error'))
            <div class="alert alert-danger border-0 shadow-sm rounded-3 mb-4 py-2 small" role="alert">
                <i class="ti ti-alert-circle me-2"></i> {{ session('error') }}
            </div>
            @endif

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
                                    <th class="text-center" style="width: 5%">No</th>
                                    <th style="width: 40%">Nama Kategori</th>
                                    <th style="width: 20%">Tanggal Dibuat</th>
                                    <th class="text-center" style="width: 15%">Volume</th>
                                    <th class="text-end pe-4" style="width: 20%">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($kategori as $item)
                                <tr>
                                    <td class="text-center text-muted small">{{ $kategori->firstItem() + $loop->index }}</td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="avatar-sm me-3 bg-primary-subtle rounded-circle d-flex align-items-center justify-content-center" style="width: 35px; height: 35px; flex-shrink: 0;">
                                                <i class="ti ti-tag text-primary small"></i>
                                            </div>
                                            <div class="text-dark fw-medium">{{ $item->ket_kategori }}</div>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="text-muted small">{{ $item->created_at ? $item->created_at->format('d M Y') : '-' }}</span>
                                    </td>
                                    <td class="text-center">
                                        <span class="badge bg-primary-subtle text-primary rounded-pill px-3 d-inline-flex align-items-center gap-1">
                                            <span>{{ $item->laporan_count ?? 0 }}</span>
                                            <span>Laporan</span>
                                        </span>
                                    </td>
                                    <td class="text-end pe-3">
                                        <div class="d-flex gap-1 justify-content-end">
                                            <button onclick="editKategori('{{ $item->id_kategori }}', '{{ addslashes($item->ket_kategori) }}')"
                                                class="btn btn-sm btn-white border shadow-sm px-2" title="Edit">
                                                <i class="ti ti-edit text-primary"></i>
                                            </button>

                                            <form method="POST" action="{{ route('admin.kategori.destroy', $item->id_kategori) }}" class="d-inline" onsubmit="return confirm('Hapus kategori ini?');">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-white border shadow-sm px-2" title="Hapus">
                                                    <i class="ti ti-trash text-danger"></i>
                                                </button>
                                            </form>
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
                {{ $kategori->links() }}
            </div>
        </div>
    </main>

    <div class="modal fade" id="addKategoriModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" style="max-width: 400px;">
            <div class="modal-content border-0 shadow rounded-3">
                <div class="modal-header border-bottom px-4">
                    <h5 class="fw-bold text-dark mb-0">Tambah Kategori</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form action="{{ route('admin.kategori.store') }}" method="POST">
                    @csrf
                    <div class="modal-body p-4">
                        <div class="mb-3">
                            <label class="form-label small fw-bold text-muted">NAMA KATEGORI</label>
                            <input type="text" name="ket_kategori" class="form-control border shadow-none" placeholder="Masukkan nama kategori" required>
                        </div>
                    </div>
                    <div class="modal-footer border-0 p-4 pt-0">
                        <button type="button" class="btn btn-light fw-bold" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary fw-bold">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="editKategoriModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" style="max-width: 400px;">
            <div class="modal-content border-0 shadow rounded-3">
                <div class="modal-header border-bottom px-4">
                    <h5 class="fw-bold text-dark mb-0">Edit Kategori</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form id="editForm" method="POST">
                    @csrf @method('PUT')
                    <div class="modal-body p-4">
                        <div class="mb-3">
                            <label class="form-label small fw-bold text-muted">NAMA KATEGORI</label>
                            <input type="text" name="ket_kategori" id="edit_ket_kategori" class="form-control border shadow-none" required>
                        </div>
                    </div>
                    <div class="modal-footer border-0 p-4 pt-0">
                        <button type="button" class="btn btn-light fw-bold" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary fw-bold">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</div>

@push('scripts')
<script>
    function editKategori(id, ket) {
        const modal = new bootstrap.Modal(document.getElementById('editKategoriModal'));
        const form = document.getElementById('editForm');

        form.action = `/admin/kategori/${id}`;
        document.getElementById('edit_ket_kategori').value = ket;

        modal.show();
    }
</script>
@endpush

@endsection