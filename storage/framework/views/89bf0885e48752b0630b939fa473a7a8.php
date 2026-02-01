

<?php $__env->startSection('title', 'Data Admin'); ?>

<?php $__env->startPush('styles'); ?>
<link rel="stylesheet" href="<?php echo e(asset('assets/css/admin/index.css')); ?>?v=<?php echo e(time()); ?>">
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>

<div class="admin-list">
    <main id="main-content" class="py-4 bg-light min-vh-100">
        <div class="container-l overflow-hidden">

            <div class="row mb-4 align-items-center">
                <div class="col">

                    <h4 class="fw-bold text-dark mb-0">Manajemen Admin</h4>
                </div>
                <div class="col-auto">
                    <button class="btn btn-primary rounded-2 shadow-sm px-3 fw-bold" data-bs-toggle="modal" data-bs-target="#addAdminModal">
                        <i class="ti ti-plus me-1"></i> Tambah Admin
                    </button>
                </div>
            </div>

            <?php if(session('success')): ?>
            <div class="alert alert-success border-0 shadow-sm rounded-3 mb-4 py-2 small" role="alert">
                <i class="ti ti-check me-2"></i> <?php echo e(session('success')); ?>

            </div>
            <?php endif; ?>

            <?php if(session('error')): ?>
            <div class="alert alert-danger border-0 shadow-sm rounded-3 mb-4 py-2 small" role="alert">
                <i class="ti ti-alert-circle me-2"></i> <?php echo e(session('error')); ?>

            </div>
            <?php endif; ?>

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
                                    <th class="text-center" style="width: 5%">No</th>
                                    <th style="width: 30%">Nama</th>
                                    <th style="width: 20%">Username</th>
                                    <th style="width: 15%">Tanggal Dibuat</th>
                                    <th class="text-center" style="width: 5%">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__empty_1 = true; $__currentLoopData = $admins; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $admin): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <tr>
                                    <td class="text-center text-muted small"><?php echo e($admins->firstItem() + $loop->index); ?></td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <?php if($admin->profile_pic): ?>
                                            <img src="<?php echo e(asset('storage/' . $admin->profile_pic)); ?>"
                                                class="rounded-circle me-3 border shadow-sm"
                                                style="width: 35px; height: 35px; object-fit: cover; flex-shrink: 0;"
                                                onerror="this.onerror=null; this.src='https://ui-avatars.com/api/?name=<?php echo e(urlencode($admin->nama)); ?>&color=7F9CF5&background=EBF4FF';">
                                            <?php else: ?>
                                            <div class="avatar-sm me-3 bg-primary-subtle rounded-circle d-flex align-items-center justify-content-center" style="width: 35px; height: 35px; flex-shrink: 0;">
                                                <span class="text-primary fw-bold small"><?php echo e(substr($admin->nama, 0, 1)); ?></span>
                                            </div>
                                            <?php endif; ?>
                                            <div>
                                                <div class="text-dark mb-0"><?php echo e($admin->nama ?? '-'); ?></div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="text-muted small"><?php echo e($admin->username); ?></div>
                                    </td>
                                    <td>
                                        <div class="small fw-medium"><?php echo e($admin->created_at ? $admin->created_at->format('d M Y') : '-'); ?></div>
                                    </td>
                                    <td class="text-end pe-3">
                                        <div class="d-flex gap-1 justify-content-end">
                                            <button class="btn btn-sm btn-white border shadow-sm px-2" title="Edit" onclick="openEditModal('<?php echo e($admin->id); ?>')">
                                                <i class="ti ti-edit text-primary"></i>
                                            </button>
                                            <form method="POST" action="<?php echo e(route('admin.admins.destroy', $admin->id)); ?>" class="d-inline" onsubmit="return confirm('Hapus admin ini?');">
                                                <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                                                <button type="submit" class="btn btn-sm btn-white border shadow-sm px-2" title="Hapus">
                                                    <i class="ti ti-trash text-danger"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <tr>
                                    <td colspan="6" class="text-center py-4 text-muted">
                                        <i class="ti ti-inbox me-2"></i> Tidak ada data admin
                                    </td>
                                </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="d-flex justify-content-center mt-4">
                <?php echo e($admins->links()); ?>

            </div>
        </div>
    </main>

    <div class="modal fade" id="addAdminModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" style="max-width: 480px;">
            <div class="modal-content border-0 shadow rounded-3">
                <div class="modal-header border-bottom px-4">
                    <h5 class="fw-bold text-dark mb-0">Tambah Admin</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form action="<?php echo e(route('admin.admins.store')); ?>" method="POST">
                    <?php echo csrf_field(); ?>
                    <div class="modal-body p-4">
                        <div class="mb-3">
                            <label class="form-label small fw-bold text-muted">Nama</label>
                            <input type="text" name="nama" class="form-control border shadow-none" placeholder="Nama lengkap" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label small fw-bold text-muted">Username</label>
                            <input type="text" name="username" class="form-control border shadow-none" placeholder="Username" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label small fw-bold text-muted">Password</label>
                            <input type="password" name="password" class="form-control border shadow-none" placeholder="Password" required>
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

    <div class="modal fade" id="editAdminModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" style="max-width: 480px;">
            <div class="modal-content border-0 shadow rounded-3">
                <div class="modal-header border-bottom px-4">
                    <h5 class="fw-bold text-dark mb-0">Edit Admin</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form id="editAdminForm" method="POST">
                    <?php echo csrf_field(); ?> <?php echo method_field('PUT'); ?>
                    <div class="modal-body p-4">
                        <div class="mb-3">
                            <label class="form-label small fw-bold text-muted">Nama</label>
                            <input type="text" name="nama" id="edit_nama" class="form-control border shadow-none" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label small fw-bold text-muted">Username</label>
                            <input type="text" name="username" id="edit_username" class="form-control border shadow-none" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label small fw-bold text-muted">Password (kosongkan jika tidak diubah)</label>
                            <input type="password" name="password" id="edit_password" class="form-control border shadow-none" placeholder="Password baru">
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

<script>
    function openEditModal(id) {
        fetch(`/admin/admins/${id}/edit`)
            .then(res => res.json())
            .then(data => {
                document.getElementById('edit_nama').value = data.nama || '';
                document.getElementById('edit_username').value = data.username || '';
                const form = document.getElementById('editAdminForm');
                form.action = `/admin/admins/${id}`;
                const modal = new bootstrap.Modal(document.getElementById('editAdminModal'));
                modal.show();
            })
            .catch(err => console.error(err));
    }
</script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout.main', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\UKK_Aspira\resources\views/admin/admins/index.blade.php ENDPATH**/ ?>