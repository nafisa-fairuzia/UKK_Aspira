

<?php $__env->startSection('title', 'Kelola Siswa'); ?>

<?php $__env->startSection('content'); ?>

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

            <?php if(session('success')): ?>
            <?php if (isset($component)) { $__componentOriginal5194778a3a7b899dcee5619d0610f5cf = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5194778a3a7b899dcee5619d0610f5cf = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.alert','data' => ['type' => 'success']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('alert'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => 'success']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal5194778a3a7b899dcee5619d0610f5cf)): ?>
<?php $attributes = $__attributesOriginal5194778a3a7b899dcee5619d0610f5cf; ?>
<?php unset($__attributesOriginal5194778a3a7b899dcee5619d0610f5cf); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal5194778a3a7b899dcee5619d0610f5cf)): ?>
<?php $component = $__componentOriginal5194778a3a7b899dcee5619d0610f5cf; ?>
<?php unset($__componentOriginal5194778a3a7b899dcee5619d0610f5cf); ?>
<?php endif; ?>
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
                                    <th class="text-center text-dark" style="width: 4%">No</th>
                                    <th class="text-dark" style="width: 16%">NIS</th>
                                    <th class="text-dark" style="width: 25%">Nama Lengkap</th>
                                    <th class="text-dark" style="width: 18%">Kelas</th>
                                    <th class="text-dark" style="width: 13%">Username</th>
                                    <th class="text-dark" style="width: 15%">Tanggal Terdaftar</th>
                                    <th class="text-end pe-4 text-dark" style="width: 12%">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__empty_1 = true; $__currentLoopData = $siswa; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <tr>
                                    <td class="text-center text-muted small"><?php echo e($siswa->firstItem() + $loop->index); ?></td>
                                    <td>
                                        <span class="text-dark"><?php echo e($item->nis); ?></span>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center gap-2">
                                            <?php if (isset($component)) { $__componentOriginal8ca5b43b8fff8bb34ab2ba4eb4bdd67b = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal8ca5b43b8fff8bb34ab2ba4eb4bdd67b = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.avatar','data' => ['user' => $item,'size' => '35','class' => 'me-0']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('avatar'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['user' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($item),'size' => '35','class' => 'me-0']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal8ca5b43b8fff8bb34ab2ba4eb4bdd67b)): ?>
<?php $attributes = $__attributesOriginal8ca5b43b8fff8bb34ab2ba4eb4bdd67b; ?>
<?php unset($__attributesOriginal8ca5b43b8fff8bb34ab2ba4eb4bdd67b); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal8ca5b43b8fff8bb34ab2ba4eb4bdd67b)): ?>
<?php $component = $__componentOriginal8ca5b43b8fff8bb34ab2ba4eb4bdd67b; ?>
<?php unset($__componentOriginal8ca5b43b8fff8bb34ab2ba4eb4bdd67b); ?>
<?php endif; ?>
                                            <div class="text-dark"><?php echo e($item->nama); ?></div>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="text-muted fw-medium"><?php echo e($item->kelas->nama_kelas ?? 'N/A'); ?></span>
                                    </td>
                                    <td>
                                        <span class="text-dark small"><?php echo e($item->username ?? '-'); ?></span>
                                    </td>
                                    <td>
                                        <small class="text-muted">
                                            <?php echo e($item->created_at ? $item->created_at->format('d/m/Y') : '-'); ?>

                                        </small>
                                    </td>
                                    <td class="text-end pe-3">
                                        <div class="d-flex gap-1 justify-content-end">
                                            <button type="button"
                                                class="btn btn-sm btn-white border shadow-sm px-2 btn-edit-siswa"
                                                title="Edit"
                                                data-nis="<?php echo e($item->nis); ?>"
                                                data-nama="<?php echo e($item->nama); ?>"
                                                data-kelas-id="<?php echo e($item->kelas_id); ?>"
                                                data-nama-kelas="<?php echo e($item->kelas->nama_kelas ?? ''); ?>"
                                                data-username="<?php echo e($item->username ?? ''); ?>">
                                                <i class="ti ti-edit text-primary"></i>
                                            </button>
                                            <form method="POST" action="<?php echo e(route('admin.siswa.destroy', $item->nis)); ?>" class="d-inline" onsubmit="return confirm('Hapus data siswa ini?');">
                                                <?php echo csrf_field(); ?>
                                                <?php echo method_field('DELETE'); ?>
                                                <button type="submit" class="btn btn-sm btn-white border shadow-sm px-2" title="Hapus">
                                                    <i class="ti ti-trash text-danger"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <?php if (isset($component)) { $__componentOriginal074a021b9d42f490272b5eefda63257c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal074a021b9d42f490272b5eefda63257c = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.empty-state','data' => ['colspan' => '6','icon' => 'ti-users','message' => 'Tidak ada data siswa']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('empty-state'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['colspan' => '6','icon' => 'ti-users','message' => 'Tidak ada data siswa']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal074a021b9d42f490272b5eefda63257c)): ?>
<?php $attributes = $__attributesOriginal074a021b9d42f490272b5eefda63257c; ?>
<?php unset($__attributesOriginal074a021b9d42f490272b5eefda63257c); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal074a021b9d42f490272b5eefda63257c)): ?>
<?php $component = $__componentOriginal074a021b9d42f490272b5eefda63257c; ?>
<?php unset($__componentOriginal074a021b9d42f490272b5eefda63257c); ?>
<?php endif; ?>
                                <?php endif; ?>
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

    <div class="modal fade" id="siswaModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow" style="border-radius: 20px;">
                <div class="modal-header border-0 pt-4 px-4">
                    <h5 id="siswaModalTitle" class="modal-title fw-bold">Formulir Identitas</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="siswaModalForm" method="POST" autocomplete="off">
                    <?php echo csrf_field(); ?>
                    <input type="hidden" id="siswaKelasId" name="id_kelas">
                    <div class="modal-body p-4">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label small fw-semibold text-dark">NIS</label>
                                <input type="text" id="siswaNis" name="nis" class="form-control form-control-sm rounded-2 bg-light px-3 py-2 <?php $__errorArgs = ['nis'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-warning <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" placeholder="Contoh: 202401234" required maxlength="10" inputmode="numeric" oninput="this.value=this.value.replace(/\D/g,'').slice(0,10)">
                                <?php $__errorArgs = ['nis'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <small class="text-warning d-block mt-2">
                                    <i class="ti ti-alert-circle me-1"></i>
                                    <?php if(str_contains($message, 'unique')): ?>
                                    NIS sudah ada
                                    <?php else: ?>
                                    <?php echo e($message); ?>

                                    <?php endif; ?>
                                </small>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small fw-semibold text-dark">Kelas</label>
                                <input type="text" id="siswaKelasInput" class="form-control form-control-sm rounded-2 bg-light px-3 py-2 <?php $__errorArgs = ['id_kelas'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-warning <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" placeholder="Cari Kelas (Contoh: RPL)" required list="siswaKelasOptions" onchange="syncKelasId('siswaKelasInput', 'siswaKelasId')">
                                <datalist id="siswaKelasOptions"></datalist>
                                <?php $__errorArgs = ['id_kelas'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <small class="text-warning d-block mt-2">
                                    <i class="ti ti-alert-circle me-1"></i><?php echo e($message); ?>

                                </small>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                            <div class="col-12">
                                <label class="form-label small fw-semibold text-dark">Nama Lengkap</label>
                                <input type="text" id="siswaNama" name="nama" class="form-control form-control-sm rounded-2 bg-light px-3 py-2 <?php $__errorArgs = ['nama'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-warning <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" placeholder="Ketik nama lengkap..." required>
                                <?php $__errorArgs = ['nama'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <small class="text-warning d-block mt-2">
                                    <i class="ti ti-alert-circle me-1"></i><?php echo e($message); ?>

                                </small>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small fw-semibold text-dark">Username</label>
                                <input type="text" id="siswaUsername" name="username" class="form-control form-control-sm rounded-2 bg-light px-3 py-2 <?php $__errorArgs = ['username'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-warning <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" placeholder="Masukkan username" required>
                                <?php $__errorArgs = ['username'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <small class="text-warning d-block mt-2">
                                    <i class="ti ti-alert-circle me-1"></i>
                                    <?php if(str_contains($message, 'unique')): ?>
                                    Username sudah ada
                                    <?php else: ?>
                                    <?php echo e($message); ?>

                                    <?php endif; ?>
                                </small>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small fw-semibold text-dark">Password</label>
                                <input type="password" id="siswaPassword" name="password" class="form-control form-control-sm rounded-2 bg-light px-3 py-2 <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-warning <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" placeholder="Masukkan password">
                                <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <small class="text-warning d-block mt-2">
                                    <i class="ti ti-alert-circle me-1"></i><?php echo e($message); ?>

                                </small>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
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

    <?php $__env->startPush('scripts'); ?>
    <script>
        window.routeAdminSiswaStore = "<?php echo e(route('admin.siswa.store')); ?>";
        window.apiKelasSearch = "<?php echo e(route('api.kelas.search')); ?>";
    </script>
    <script src="<?php echo e(asset('assets/js/admin/siswa-management.js')); ?>?v=<?php echo e(time()); ?>"></script>
    <script src="<?php echo e(asset('assets/js/validation.js')); ?>?v=<?php echo e(time()); ?>"></script>
    <?php $__env->stopPush(); ?>


</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout.main', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\UKK_Aspira\resources\views/admin/siswa/index.blade.php ENDPATH**/ ?>