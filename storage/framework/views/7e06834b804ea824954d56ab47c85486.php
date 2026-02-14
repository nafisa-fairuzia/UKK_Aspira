

<?php $__env->startSection('title', 'Pengaduan Siswa Lain'); ?>

<?php $__env->startSection('content'); ?>
<div class="pengaduan-admin">
    <main id="main-content" class="py-4 bg-light min-vh-100">
        <div class="container-l" style="overflow: visible;">

            <div class="d-flex align-items-center justify-content-between mb-4 mt-4">
                <h4 class="fw-bold text-dark mb-0">Daftar Pengaduan Siswa Lain</h4>
                <a href="<?php echo e(route('siswa.pengaduan.create')); ?>" class="btn btn-primary rounded-pill px-4">Buat Pengaduan</a>
            </div>
            <div class="card border-0 shadow-sm rounded-3 overflow-hidden">
                <div class="card-header bg-white py-3 border-bottom">
                    <div class="d-flex align-items-center justify-content-between">
                        <div class="d-flex align-items-center">
                            <i class="ti ti-message-report me-2 text-primary fs-4"></i>
                            <h6 class="mb-0 fw-bold text-dark">Pengaduan Masuk</h6>
                        </div>
                    </div>
                </div>

                <div class="card-body p-0">
                    <div class="table-responsive p-3">
                        <table id="pengaduanTableSiswa" class="table table-hover align-middle mb-0 w-100">
                            <thead class="bg-light">
                                <tr>
                                    <th class="text-center text-dark" style="width: 5%;">No</th>
                                    <th class="text-dark" style="width: 30%;">Informasi Pelapor</th>
                                    <th class="text-dark" style="width: 12%;">Kategori</th>
                                    <th class="text-dark" style="width: 25%;">Keterangan</th>
                                    <th class="text-center text-dark" style="width: 10%;">Status</th>
                                    <th class="text-dark" style="width: 13%;">Tanggal</th>
                                    <th class="text-end pe-4 text-dark" style="width: 5%;">Aksi</th>
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
                                    <td class="text-truncate" style="max-width: 360px;"><?php echo e(Str::limit($p->ket ?? '-', 120)); ?></td>
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
                                        <a href="<?php echo e(route('siswa.pengaduan.showPublic', $p->id_pelaporan)); ?>" class="btn btn-sm btn-white border shadow-sm px-2" title="Detail">
                                            <i class="ti ti-eye text-primary" style="font-size: 16px;"></i>
                                        </a>
                                    </td>
                                </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <tr>
                                    <td colspan="7">
                                        <p class="text-center text-muted mb-0">Tidak ada pengaduan ditemukan.</p>
                                    </td>
                                </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="d-flex justify-content-center mt-4">
                <?php echo e($pengaduan->appends(request()->query())->links()); ?>

            </div>
        </div>
    </main>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout.main', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\UKK_Aspira\resources\views/siswa/pengaduan/lainnya.blade.php ENDPATH**/ ?>