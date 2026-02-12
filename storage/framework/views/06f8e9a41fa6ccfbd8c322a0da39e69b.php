

<?php $__env->startSection('title', 'Kelola Pengaduan'); ?>

<?php $__env->startPush('styles'); ?>
<link rel="stylesheet" href="<?php echo e(asset('assets/css/admin/index.css')); ?>?v=<?php echo e(time()); ?>">
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>

<div class="pengaduan-admin">

    <main id="main-content" class="py-4 bg-light min-vh-100">
        <div class="container-l" style="overflow: visible;">

            <div class="row mb-4 align-items-center mt-4">
                <div class="col">
                    <h4 class="fw-bold text-dark mb-0">Daftar Pengaduan</h4>
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

            <div class="card border-0 shadow-sm mb-4 rounded-3">
                <div class="card-body p-4">
                    <form action="<?php echo e(route('admin.pengaduan.index')); ?>" method="GET">
                        <div class="row g-3 align-items-end">

                            <div class="col-md-2">
                                <label class="form-label small fw-semibold text-dark mb-2">Tanggal</label>
                                <input type="date" name="tanggal" class="form-control border-2 shadow-none rounded-2 px-3"
                                    style="height: 42px; font-size: 13px;" value="<?php echo e(request('tanggal')); ?>">
                            </div>

                            <div class="col-md-2">
                                <label class="form-label small fw-semibold text-dark mb-2">Bulan</label>
                                <select name="bulan" class="form-select border-2 shadow-none rounded-2 px-3" style="height: 42px; font-size: 13px;">
                                    <option value="">Semua Bulan</option>
                                    <?php $__currentLoopData = range(1, 12); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $m): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($m); ?>" <?php echo e(request('bulan') == $m ? 'selected' : ''); ?>>
                                        <?php echo e(\Carbon\Carbon::create()->month($m)->translatedFormat('F')); ?>

                                    </option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>

                            <div class="col-md-2">
                                <label class="form-label small fw-semibold text-dark mb-2">Cari Pelapor</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-white border-2 border-end-0 text-muted px-2">
                                        <i class="ti ti-search"></i>
                                    </span>
                                    <input type="text" name="siswa" class="form-control border-2 border-start-0 shadow-none rounded-end-2"
                                        style="height: 42px; font-size: 13px;" placeholder="Nama atau NIS..." value="<?php echo e(request('siswa')); ?>">
                                </div>
                            </div>

                            <div class="col-md-2">
                                <label class="form-label small fw-semibold text-dark mb-2">Kategori</label>
                                <select name="kategori" class="form-select border-2 shadow-none rounded-2 px-3" style="height: 42px; font-size: 13px;">
                                    <option value="">Semua Kategori</option>
                                    <?php $__currentLoopData = $kategori; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $kat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($kat->id_kategori); ?>" <?php echo e(request('kategori') == $kat->id_kategori ? 'selected' : ''); ?>>
                                        <?php echo e($kat->ket_kategori); ?>

                                    </option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>

                            <div class="col-md-2">
                                <label class="form-label small fw-semibold text-dark mb-2">Status</label>
                                <select name="status" class="form-select border-2 shadow-none rounded-2 px-3" style="height: 42px; font-size: 13px;">
                                    <option value="">Semua Status</option>
                                    <option value="Menunggu" <?php echo e(request('status') == 'Menunggu' ? 'selected' : ''); ?>>Menunggu</option>
                                    <option value="Proses" <?php echo e(request('status') == 'Proses' ? 'selected' : ''); ?>>Proses</option>
                                    <option value="Selesai" <?php echo e(request('status') == 'Selesai' ? 'selected' : ''); ?>>Selesai</option>
                                </select>
                            </div>

                            <div class="col-md-2">
                                <div class="d-flex gap-2">
                                    <button type="submit" class="btn btn-primary fw-bold flex-grow-1 rounded-2 shadow-sm" style="height: 42px; ">
                                        <i class="ti ti-search me-1"></i> Cari
                                    </button>
                                    <a href="<?php echo e(route('admin.pengaduan.index')); ?>" class="btn btn-outline-secondary border-2 fw-bold rounded-2 px-3 d-flex align-items-center justify-content-center"
                                        style="height: 42px;" title="Reset Filter">
                                        <i class="ti ti-refresh"></i>
                                    </a>
                                </div>
                            </div>

                        </div>
                    </form>
                </div>
            </div>

            <div class="card border-0 shadow-sm rounded-3 overflow-hidden">
                <div class="card-header bg-white py-3 border-bottom">
                    <div class="d-flex align-items-center justify-content-between">
                        <div class="d-flex align-items-center">
                            <i class="ti ti-message-report me-2 text-primary fs-4"></i>
                            <h6 class="mb-0 fw-bold text-dark">Pengaduan Masuk</h6>
                        </div>
                        <div class="d-flex gap-2 align-items-center">
                            <form method="GET" action="<?php echo e(route('admin.pengaduan.export.excel')); ?>" class="d-inline">
                                <?php $__currentLoopData = request()->query(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php if($key !== 'page'): ?>
                                <input type="hidden" name="<?php echo e($key); ?>" value="<?php echo e($value); ?>">
                                <?php endif; ?>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <button type="submit" class="btn btn-sm btn-success shadow-sm rounded-2 px-3 excel" style="font-weight: 600;">
                                    Cetak Excel
                                </button>
                            </form>

                            <form method="GET" action="<?php echo e(route('admin.pengaduan.export.pdf')); ?>" class="d-inline">
                                <?php $__currentLoopData = request()->query(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php if($key !== 'page'): ?>
                                <input type="hidden" name="<?php echo e($key); ?>" value="<?php echo e($value); ?>">
                                <?php endif; ?>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <button type="submit" class="btn btn-sm btn-primary shadow-sm rounded-2 px-3" style="font-weight: 600;">
                                    Cetak PDF
                                </button>
                            </form>
                        </div>

                    </div>
                </div>

                <div class="card-body p-0">
                    <div class="table-responsive p-3">
                        <table id="pengaduanTable" class="table table-hover align-middle mb-0 w-100">
                            <thead class="bg-light">
                                <tr>
                                    <th class="text-center text-dark" style="width: 5%;">No</th>
                                    <th class="text-dark" style="width: 25%;">Informasi Pelapor</th>
                                    <th class="text-dark" style="width: 15%;">Kategori</th>
                                    <th class="text-center text-dark" style="width: 15%;">Status</th>
                                    <th class="text-dark" style="width: 25%;">Tanggal</th>
                                    <th class="text-end pe-4 text-dark" style="width: 15%;">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__empty_1 = true; $__currentLoopData = $pengaduan; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <tr>
                                    <td class="text-center text-muted small fw-bold"><?php echo e($pengaduan->firstItem() + $loop->index); ?></td>
                                    <td>
                                        <div class="d-flex align-items-center gap-2">
                                            <?php if (isset($component)) { $__componentOriginal8ca5b43b8fff8bb34ab2ba4eb4bdd67b = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal8ca5b43b8fff8bb34ab2ba4eb4bdd67b = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.avatar','data' => ['user' => $p->siswa,'size' => '35','class' => 'me-0']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('avatar'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['user' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($p->siswa),'size' => '35','class' => 'me-0']); ?>
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
                                            <div>
                                                <div class="fw-bold text-dark mb-0"><?php echo e($p->siswa->nama ?? 'N/A'); ?></div>
                                                <small class="text-muted">Kelas: <?php echo e($p->siswa->kelas->nama_kelas ?? 'N/A'); ?></small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="text-dark fw-medium small"><?php echo e($p->kategori->ket_kategori ?? 'Umum'); ?></span>
                                    </td>
                                    <td class="text-center">
                                        <?php
                                        $currentStatus = $p->aspirasi->status ?? 'Menunggu';
                                        $badgeClass = match($currentStatus) {
                                        'Menunggu' => 'bg-warning-subtle text-warning border-warning-subtle',
                                        'Proses' => 'bg-primary-subtle text-primary border-primary-subtle',
                                        'Selesai' => 'bg-success-subtle text-success border-success-subtle',
                                        default => 'bg-light text-secondary border'
                                        };
                                        ?>
                                        <span class="badge rounded-pill border <?php echo e($badgeClass); ?> px-3 py-1" style="min-width: 90px; font-size: 11px;">
                                            <?php echo e($currentStatus); ?>

                                        </span>
                                    </td>
                                    <td>
                                        <div class="small fw-medium"><?php echo e($p->formatted_created_date); ?></div>
                                        <div class="text-muted x-small"><?php echo e($p->formatted_created_time); ?> WIB</div>
                                    </td>

                                    <td class="text-end pe-3">
                                        <div class="d-flex gap-1 justify-content-end">
                                            <a href="<?php echo e(route('admin.pengaduan.show', $p->id_pelaporan)); ?>" class="btn btn-sm btn-white border shadow-sm px-2" title="Detail">
                                                <i class="ti ti-eye text-primary" style="font-size: 16px;"></i>
                                            </a>

                                            <?php
                                            $pStatus = $p->aspirasi->status ?? 'Menunggu';
                                            $canEdit = $pStatus !== 'Selesai';
                                            ?>

                                            <?php if($canEdit): ?>
                                            <div class="dropdown">
                                                <button class="btn btn-sm btn-white border shadow-sm dropdown-toggle fw-bold" type="button" data-bs-toggle="dropdown" title="Edit Status">
                                                    <i class="ti ti-settings text-secondary" style="font-size: 16px;"></i>
                                                </button>
                                                <ul class="dropdown-menu dropdown-menu-end shadow-lg border-0 p-2">
                                                    <li><small class="dropdown-header text-uppercase opacity-50 ">Ganti Status:</small></li>
                                                    <?php
                                                    $availableStatuses = ['Menunggu' => 'clock', 'Proses' => 'loader', 'Selesai' => 'check'];
                                                    ?>
                                                    <?php $__currentLoopData = $availableStatuses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $status => $icon): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <?php if(($status === 'Menunggu' && $pStatus !== 'Menunggu') || $pStatus === 'Selesai'): ?>
                                                    <?php continue; ?>
                                                    <?php endif; ?>
                                                    <li>
                                                        <form action="<?php echo e(route('admin.pengaduan.update', $p->id_pelaporan)); ?>" method="POST" class="d-inline">
                                                            <?php echo csrf_field(); ?>
                                                            <?php echo method_field('PUT'); ?>
                                                            <input type="hidden" name="status" value="<?php echo e($status); ?>">
                                                            <button type="submit" class="dropdown-item rounded-2 <?php echo e($pStatus === $status ? 'active disabled' : ''); ?>">
                                                                <i class="ti ti-<?php echo e($icon); ?> me-1"></i> <?php echo e($status); ?>

                                                            </button>
                                                        </form>
                                                    </li>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </ul>
                                            </div>
                                            <?php else: ?>
                                            <button class="btn btn-sm btn-white border shadow-sm px-2" type="button" disabled title="Pengaduan sudah selesai">
                                                <i class="ti ti-settings-check text-success" style="font-size: 16px;"></i>
                                            </button>
                                            <?php endif; ?>
                                        </div>
                                    </td>
                                </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <?php if (isset($component)) { $__componentOriginal074a021b9d42f490272b5eefda63257c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal074a021b9d42f490272b5eefda63257c = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.empty-state','data' => ['colspan' => '6','icon' => 'ti-inbox','message' => 'Tidak ada pengaduan yang ditemukan']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('empty-state'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['colspan' => '6','icon' => 'ti-inbox','message' => 'Tidak ada pengaduan yang ditemukan']); ?>
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
                <?php echo e($pengaduan->links()); ?>

            </div>
        </div>
    </main>
</div>

<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script src="<?php echo e(asset('assets/js/admin/pengaduan-index.js')); ?>?v=<?php echo e(time()); ?>"></script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layout.main', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\UKK_Aspira\resources\views/admin/pengaduan/index.blade.php ENDPATH**/ ?>