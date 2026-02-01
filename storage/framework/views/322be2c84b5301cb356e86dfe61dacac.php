

<?php $__env->startSection('title', 'Kelola Siswa'); ?>

<?php $__env->startSection('content'); ?>

<div class="index-siswa-admin">

    <main id="main-content" class="py-4 bg-light min-vh-100">
        <div class="overflow-hidden">

            <div class="row mb-4 align-items-center">
                <div class="col">
                    <h4 class="fw-bold text-dark mb-0">Manajemen Siswa</h4>
                </div>
                <div class="col-auto">
                    <button type="button" class="btn btn-primary rounded-2 shadow-sm px-3 fw-bold" data-bs-toggle="modal" data-bs-target="#modalTambahSiswa">
                        <i class="ti ti-plus me-1"></i> Tambah Siswa
                    </button>
                </div>
            </div>

            <?php if(session('success')): ?>
            <div class="alert alert-success border-0 shadow-sm rounded-3 mb-4 py-2 small" role="alert">
                <i class="ti ti-check me-2"></i> <?php echo e(session('success')); ?>

            </div>
            <?php endif; ?>

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
                                    <th class="text-center" style="width: 5%">No</th>
                                    <th style="width: 20%">NIS</th>
                                    <th style="width: 35%">Nama Lengkap</th>
                                    <th style="width: 20%">Kelas</th>
                                    <th class="text-end pe-4" style="width: 20%">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__currentLoopData = $siswa; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td class="text-center text-muted small"><?php echo e($siswa->firstItem() + $loop->index); ?></td>
                                    <td>
                                        <span class="text-dark"><?php echo e($item->nis); ?></span>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <?php if($item->profile_pic): ?>
                                            <img src="<?php echo e(asset('storage/' . $item->profile_pic)); ?>"
                                                class="rounded-circle me-3 border shadow-sm"
                                                style="width: 35px; height: 35px; object-fit: cover; flex-shrink: 0;"
                                                onerror="this.onerror=null; this.src='https://ui-avatars.com/api/?name=<?php echo e(urlencode($item->nama)); ?>&color=7F9CF5&background=EBF4FF';">
                                            <?php else: ?>
                                            <div class="avatar-sm me-3 bg-primary-subtle rounded-circle d-flex align-items-center justify-content-center" style="width: 35px; height: 35px; flex-shrink: 0;">
                                                <span class="text-primary fw-bold small"><?php echo e(substr($item->nama, 0, 1)); ?></span>
                                            </div>
                                            <?php endif; ?>
                                            <div>
                                                <div class="text-dark mb-0"><?php echo e($item->nama); ?></div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="text-muted fw-medium"><?php echo e($item->kelas->nama_kelas); ?></span>
                                    </td>
                                    <td class="text-end pe-3">
                                        <div class="d-flex gap-1 justify-content-end">
                                            <button type="button"
                                                class="btn btn-sm btn-white border shadow-sm px-2 btn-edit-siswa"
                                                title="Edit"
                                                data-bs-toggle="modal"
                                                data-bs-target="#modalEditSiswa"
                                                data-nis="<?php echo e($item->nis); ?>"
                                                data-nama="<?php echo e($item->nama); ?>"
                                                data-kelas-id="<?php echo e($item->kelas_id); ?>"
                                                data-nama-kelas="<?php echo e($item->kelas->nama_kelas ?? ''); ?>">
                                                <i class="ti ti-edit text-primary"></i>
                                            </button>

                                            <form method="POST" action="<?php echo e(route('admin.siswa.destroy', $item->nis)); ?>" class="d-inline" onsubmit="return confirm('Hapus data siswa ini?');">
                                                <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                                                <button type="submit" class="btn btn-sm btn-white border shadow-sm px-2" title="Hapus">
                                                    <i class="ti ti-trash text-danger"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="d-flex justify-content-center mt-4">
                <?php echo e($siswa->links()); ?>

            </div>
        </div>
    </main>

    <div class="modal fade" id="modalTambahSiswa" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow" style="border-radius: 20px;">
                <div class="modal-header border-0 pt-4 px-4">
                    <h5 class="modal-title fw-bold">Formulir Identitas</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="<?php echo e(route('admin.siswa.store')); ?>" method="POST" autocomplete="off">
                    <?php echo csrf_field(); ?>
                    <input type="hidden" id="kelasTambahId" name="kelas_id">
                    <div class="modal-body p-4">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label small fw-bold text-muted">NOMOR INDUK SISWA</label>
                                <input type="text" name="nis" class="form-control border-0" placeholder="Contoh: 202401234" required maxlength="10" inputmode="numeric" oninput="this.value=this.value.replace(/\D/g,'').slice(0,10)" style="background-color: #f3f6f9; border-radius: 10px; padding: 12px;">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small fw-bold text-muted">TINGKAT KELAS</label>
                                <input type="text" id="kelasTambahInput" class="form-control border-0" placeholder="Cari Kelas (Contoh: RPL)" required list="kelasTambahOptions" onchange="syncKelasId('kelasTambahInput', 'kelasTambahId')" style="background-color: #f3f6f9; border-radius: 10px; padding: 12px;">
                                <datalist id="kelasTambahOptions"></datalist>
                            </div>
                            <div class="col-12">
                                <label class="form-label small fw-bold text-muted">NAMA LENGKAP SISWA</label>
                                <input type="text" name="nama" class="form-control border-0" placeholder="Ketik nama lengkap sesuai akta..." required style="background-color: #f3f6f9; border-radius: 10px; padding: 12px;">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer border-0 pb-4 px-4 gap-2">
                        <button type="reset" class="btn btn-light flex-fill fw-bold py-2 shadow-sm" style="border-radius: 12px;">Reset</button>
                        <button type="submit" class="btn btn-primary flex-fill fw-bold py-2 shadow-sm" style="border-radius: 12px;">
                            <i class="ti ti-cloud-upload me-1"></i> Simpan Data Siswa
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalEditSiswa" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow" style="border-radius: 20px;">
                <div class="modal-header border-0 pt-4 px-4">
                    <h5 class="modal-title fw-bold">Edit Data Siswa</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="formEditSiswa" method="POST" autocomplete="off">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('PUT'); ?>
                    <input type="hidden" id="kelasEditId" name="kelas_id">
                    <div class="modal-body p-4">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label small fw-bold text-muted">NOMOR INDUK SISWA</label>
                                <input type="text" id="editNis" name="nis" class="form-control border-0" placeholder="Contoh: 202401234" maxlength="10" inputmode="numeric" oninput="this.value=this.value.replace(/\D/g,'').slice(0,10)" style="background-color: #f3f6f9; border-radius: 10px; padding: 12px;">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small fw-bold text-muted">TINGKAT KELAS</label>
                                <input type="text" id="kelasEditInput" class="form-control border-0" placeholder="Cari Kelas (Contoh: RPL)" required list="kelasEditOptions" onchange="syncKelasId('kelasEditInput', 'kelasEditId')" style="background-color: #f3f6f9; border-radius: 10px; padding: 12px;">
                                <datalist id="kelasEditOptions"></datalist>
                            </div>
                            <div class="col-12">
                                <label class="form-label small fw-bold text-muted">NAMA LENGKAP SISWA</label>
                                <input type="text" id="editNama" name="nama" class="form-control border-0" required style="background-color: #f3f6f9; border-radius: 10px; padding: 12px;">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer border-0 pb-4 px-4 gap-2">
                        <button type="button" class="btn btn-light flex-fill fw-bold py-2 shadow-sm" style="border-radius: 12px;" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary flex-fill fw-bold py-2 shadow-sm" style="border-radius: 12px;">
                            <i class="ti ti-device-floppy me-1"></i> Update Data Siswa
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let allKelas = [];

            // Load kelas data
            function loadKelas() {
                fetch('<?php echo e(route("api.kelas.search")); ?>')
                    .then(r => r.json())
                    .then(data => {
                        allKelas = data.results || [];
                        populateDatalist('kelasTambahOptions', '');
                        populateDatalist('kelasEditOptions', '');
                    })
                    .catch(err => console.error('Failed to load kelas:', err));
            }

            function populateDatalist(datalistId, filter) {
                const datalist = document.getElementById(datalistId);
                if (!datalist) return;
                datalist.innerHTML = '';
                const filtered = allKelas.filter(k => k.text.toLowerCase().includes(filter.toLowerCase()));
                filtered.forEach(k => {
                    const option = document.createElement('option');
                    option.value = k.text;
                    option.dataset.id = k.id;
                    datalist.appendChild(option);
                });
            }

            // Sync input text with hidden ID field
            window.syncKelasId = function(inputId, hiddenId) {
                const input = document.getElementById(inputId);
                const hidden = document.getElementById(hiddenId);
                if (!input || !hidden) return;

                const datalistId = inputId.includes('Tambah') ? 'kelasTambahOptions' : 'kelasEditOptions';
                const datalist = document.getElementById(datalistId);
                const selected = Array.from(datalist.options).find(opt => opt.value === input.value);

                if (selected && selected.dataset.id) {
                    hidden.value = selected.dataset.id;
                } else {
                    hidden.value = '';
                }
            };

            // Filter on input
            document.getElementById('kelasTambahInput')?.addEventListener('input', function() {
                populateDatalist('kelasTambahOptions', this.value);
            });
            document.getElementById('kelasEditInput')?.addEventListener('input', function() {
                populateDatalist('kelasEditOptions', this.value);
            });

            // Handle edit button clicks
            document.addEventListener('click', function(e) {
                const btn = e.target.closest('.btn-edit-siswa');
                if (btn) {
                    const nis = btn.dataset.nis;
                    const nama = btn.dataset.nama;
                    const kelasId = btn.dataset.kelasId;
                    const namaKelas = btn.dataset.namaKelas || '';
                    editSiswa(nis, nama, kelasId, namaKelas);
                }
            });

            function editSiswa(nis, nama, kelas_id, kelas_name) {
                document.getElementById('editNis').value = nis;
                document.getElementById('editNama').value = nama;
                document.getElementById('kelasEditInput').value = kelas_name || '';
                document.getElementById('kelasEditId').value = kelas_id || '';
                document.getElementById('formEditSiswa').action = '/admin/siswa/' + nis;
            }

            // Load kelas on page load
            loadKelas();
        });
    </script>


</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout.main', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\UKK_Aspira\resources\views/admin/siswa/index.blade.php ENDPATH**/ ?>