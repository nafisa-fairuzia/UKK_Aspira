@extends('layout.main')

@section('title', 'Kelola Siswa')

@section('content')

<div class="index-siswa-admin">

    <main id="main-content" class="py-4 bg-light min-vh-100">
        <div class="overflow-hidden">

            <div class="row mb-4 mt-4 align-items-center">
                <div class="col">
                    <h4 class="fw-bold text-dark mb-0">Manajemen Siswa</h4>
                </div>
                <div class="col-auto">
                    <button type="button" class="btn btn-primary rounded-2 shadow-sm px-3 fw-bold" onclick="openSiswaModal('add')">
                        <i class="ti ti-plus me-1"></i> Tambah Siswa
                    </button>
                </div>
            </div>

            @if(session('success'))
            <x-alert type="success" />
            @endif

            <div class="card border-0 shadow-sm rounded-3 overflow-hidden">
                <div class="card-header bg-white py-3 border-bottom">
                    <div class="d-flex align-items-center">
                        <i class="ti ti-users me-2 text-primary fs-4"></i>
                        <h6 class="mb-0 fw-bold">Data Siswa</h6>
                    </div>
                </div>

                <div class="card-body p-0">
                    <div class="table-responsive p-3">
                        <table id="siswaTable" class="table table-hover align-middle mb-0 w-100">
                            <thead class="bg-light">
                                <tr>
                                    <th class="text-center text-dark" style="width: 4%">No</th>
                                    <th class="text-dark" style="width: 16%">NIS</th>
                                    <th class="text-dark" style="width: 30%">Nama Lengkap</th>
                                    <th class="text-dark" style="width: 20%">Kelas</th>
                                    <th class="text-dark" style="width: 15%">Username</th>
                                    <th class="text-end pe-4 text-dark" style="width: 15%">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($siswa as $item)
                                <tr>
                                    <td class="text-center text-muted small">{{ $siswa->firstItem() + $loop->index }}</td>
                                    <td>
                                        <span class="text-dark">{{ $item->nis }}</span>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center gap-2">
                                            <x-avatar :user="$item" size="35" class="me-0" />
                                            <div class="text-dark">{{ $item->nama }}</div>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="text-muted fw-medium">{{ $item->kelas->nama_kelas ?? 'N/A' }}</span>
                                    </td>
                                    <td>
                                        <span class="text-dark small">{{ $item->username ?? '-' }}</span>
                                    </td>
                                    <td class="text-end pe-3">
                                        <div class="d-flex gap-1 justify-content-end">
                                            <button type="button"
                                                class="btn btn-sm btn-white border shadow-sm px-2 btn-edit-siswa"
                                                title="Edit"
                                                data-nis="{{ $item->nis }}"
                                                data-nama="{{ $item->nama }}"
                                                data-kelas-id="{{ $item->kelas_id }}"
                                                data-nama-kelas="{{ $item->kelas->nama_kelas ?? '' }}"
                                                data-username="{{ $item->username ?? '' }}">
                                                <i class="ti ti-edit text-primary"></i>
                                            </button>
                                            <form method="POST" action="{{ route('admin.siswa.destroy', $item->nis) }}" class="d-inline" onsubmit="return confirm('Hapus data siswa ini?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-white border shadow-sm px-2" title="Hapus">
                                                    <i class="ti ti-trash text-danger"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <x-empty-state colspan="5" icon="ti-users" message="Tidak ada data siswa" />
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="d-flex justify-content-center mt-4">
                {{ $siswa->links() }}
            </div>
        </div>
    </main>

    <div class="modal fade" id="siswaModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow" style="border-radius: 20px;">
                <div class="modal-header border-0 pt-4 px-4">
                    <h5 id="siswaModalTitle" class="modal-title fw-bold">Formulir Identitas</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="siswaModalForm" method="POST" autocomplete="off">
                    @csrf
                    <input type="hidden" id="siswaKelasId" name="id_kelas">
                    <div class="modal-body p-4">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label small fw-semibold text-dark">NIS</label>
                                <input type="text" id="siswaNis" name="nis" class="form-control form-control-sm rounded-2 bg-light px-3 py-2 @error('nis') border-warning @enderror" placeholder="Contoh: 202401234" required maxlength="10" inputmode="numeric" oninput="this.value=this.value.replace(/\D/g,'').slice(0,10)">
                                @error('nis')
                                <small class="text-warning d-block mt-2">
                                    <i class="ti ti-alert-circle me-1"></i>
                                    @if(str_contains($message, 'unique'))
                                    NIS sudah ada
                                    @else
                                    {{ $message }}
                                    @endif
                                </small>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small fw-semibold text-dark">Kelas</label>
                                <input type="text" id="siswaKelasInput" class="form-control form-control-sm rounded-2 bg-light px-3 py-2 @error('id_kelas') border-warning @enderror" placeholder="Cari Kelas (Contoh: RPL)" required list="siswaKelasOptions" onchange="syncKelasId('siswaKelasInput', 'siswaKelasId')">
                                <datalist id="siswaKelasOptions"></datalist>
                                @error('id_kelas')
                                <small class="text-warning d-block mt-2">
                                    <i class="ti ti-alert-circle me-1"></i>{{ $message }}
                                </small>
                                @enderror
                            </div>
                            <div class="col-12">
                                <label class="form-label small fw-semibold text-dark">Nama Lengkap</label>
                                <input type="text" id="siswaNama" name="nama" class="form-control form-control-sm rounded-2 bg-light px-3 py-2 @error('nama') border-warning @enderror" placeholder="Ketik nama lengkap..." required>
                                @error('nama')
                                <small class="text-warning d-block mt-2">
                                    <i class="ti ti-alert-circle me-1"></i>{{ $message }}
                                </small>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small fw-semibold text-dark">Username</label>
                                <input type="text" id="siswaUsername" name="username" class="form-control form-control-sm rounded-2 bg-light px-3 py-2 @error('username') border-warning @enderror" placeholder="Masukkan username" required>
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
                            <div class="col-md-6">
                                <label class="form-label small fw-semibold text-dark">Password</label>
                                <input type="password" id="siswaPassword" name="password" class="form-control form-control-sm rounded-2 bg-light px-3 py-2 @error('password') border-warning @enderror" placeholder="Masukkan password">
                                @error('password')
                                <small class="text-warning d-block mt-2">
                                    <i class="ti ti-alert-circle me-1"></i>{{ $message }}
                                </small>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer border-0 pb-4 px-4 gap-2">
                        <button type="button" class="btn btn-light flex-fill fw-bold py-2 shadow-sm rounded-2" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" id="siswaModalSubmit" class="btn btn-primary flex-fill fw-bold py-2 shadow-sm rounded-2">
                            <i class="ti ti-cloud-upload me-1"></i> Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        window.routeAdminSiswaStore = "{{ route('admin.siswa.store') }}";
        window.apiKelasSearch = "{{ route('api.kelas.search') }}";
    </script>
    <script src="{{ asset('assets/js/admin/siswa-management.js') }}?v={{ time() }}"></script>
    <script src="{{ asset('assets/js/validation.js') }}?v={{ time() }}"></script>
    @endpush


</div>
@endsection