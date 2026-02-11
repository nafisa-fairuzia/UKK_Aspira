@extends('layout.main')

@section('title', 'Data Admin')

@push('styles')
<link rel="stylesheet" href="{{ asset('assets/css/admin/index.css') }}?v={{ time() }}">
@endpush

@section('content')
<div class="admin-list">
    <main id="main-content" class="py-4 bg-light min-vh-100">
        <div class="overflow-hidden">

            <div class="row mb-4 mt-4 align-items-center">
                <div class="col">
                    <h4 class="fw-bold text-dark mb-0">Manajemen Admin</h4>
                </div>
                <div class="col-auto">
                    <button type="button" class="btn btn-primary rounded-2 shadow-sm px-3 fw-bold" onclick="openAdminModal('add')">
                        <i class="ti ti-plus me-1"></i> Tambah Admin
                    </button>
                </div>
            </div>

            <x-alert type="success" />
            <x-alert type="error" />

            <div class="card border-0 shadow-sm rounded-3 overflow-hidden">
                <div class="card-header bg-white py-3 border-bottom">
                    <div class="d-flex align-items-center justify-content-between">
                        <div class="d-flex align-items-center">
                            <i class="ti ti-users me-2 text-primary fs-4"></i>
                            <h6 class="mb-0 fw-bold">Daftar Admin</h6>
                        </div>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive p-3">
                        <table id="adminsTable" class="table table-hover align-middle mb-0 w-100">
                            <thead class="bg-light">
                                <tr>
                                    <th class="text-center text-dark" style="width: 5%">No</th>
                                    <th class="text-dark" style="width: 30%">Nama</th>
                                    <th class="text-dark" style="width: 20%">Username</th>
                                    <th class="text-dark" style="width: 15%">Tanggal Dibuat</th>
                                    <th class="text-end pe-4 text-dark" style="width: 15%">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($admins as $admin)
                                <tr>
                                    <td class="text-center text-muted small">{{ $admins->firstItem() + $loop->index }}</td>
                                    <td>
                                        <div class="d-flex align-items-center gap-2">
                                            <x-avatar :user="$admin" size="35" class="me-0" />
                                            <div>
                                                <div class="text-dark mb-0">{{ $admin->nama ?? '-' }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="text-muted small">{{ $admin->username }}</div>
                                    </td>
                                    <td>
                                        <div class="small fw-medium">{{ $admin->created_at?->format('d M Y') ?? '-' }}</div>
                                    </td>
                                    <td class="text-end pe-3">
                                        <x-action-buttons
                                            :edit-action="true"
                                            :delete-route="route('admin.admins.destroy', $admin->id)"
                                            delete-message="Hapus admin ini?"
                                            onclick="openEditModal('{{ $admin->id }}')" />
                                    </td>
                                </tr>
                                @empty
                                <x-empty-state colspan="5" icon="ti-inbox" message="Tidak ada data admin" />
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="d-flex justify-content-center mt-4">
                {{ $admins->links() }}
            </div>
        </div>
    </main>
</div>

<div class="modal fade" id="adminModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" style="max-width: 480px;">
        <div class="modal-content border-0 shadow rounded-3">
            <div class="modal-header border-bottom px-4">
                <h5 id="adminModalTitle" class="fw-bold text-dark mb-0">Form Admin</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="adminModalForm" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-muted">Nama</label>
                        <input type="text" name="nama" id="admin_nama" class="form-control @error('nama') border-warning @enderror" placeholder="Nama lengkap" required>
                        @error('nama')
                        <small class="text-warning d-block mt-2">
                            <i class="ti ti-alert-circle me-1"></i>{{ $message }}
                        </small>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-muted">Username</label>
                        <input type="text" name="username" id="admin_username" class="form-control @error('username') border-warning @enderror" placeholder="Username" required>
                        @error('username')
                        <small class="text-warning d-block mt-2">
                            <i class="ti ti-alert-circle me-1"></i>
                            @if(str_contains($message, 'unique'))
                            Username sudah ada
                            @else
                            {{ $message }}
                            @endif
                        </small>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-muted">Password</label>
                        <input type="password" name="password" id="admin_password" class="form-control @error('password') border-warning @enderror" placeholder="Masukkan password">
                        @error('password')
                        <small class="text-warning d-block mt-2">
                            <i class="ti ti-alert-circle me-1"></i>{{ $message }}
                        </small>
                        @enderror
                    </div>
                </div>
                <div class="modal-footer border-0 p-4 pt-0">
                    <button type="button" class="btn btn-light fw-bold" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" id="adminModalSubmit" class="btn btn-primary fw-bold">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    window.routeAdminAdminsStore = "{{ route('admin.admins.store') }}";
</script>
<script src="{{ asset('assets/js/admin/admins-management.js') }}?v={{ time() }}"></script>
<script src="{{ asset('assets/js/validation.js') }}?v={{ time() }}"></script>
@endpush