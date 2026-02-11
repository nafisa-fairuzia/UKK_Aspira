

<?php $__env->startSection('title', 'Riwayat Pengaduan'); ?>

<?php $__env->startPush('styles'); ?>
<link rel="stylesheet" href="<?php echo e(asset('assets/css/siswa/riwayat.css')); ?>?v=<?php echo e(time()); ?>">
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>

<main id="main-content" class="py-4 bg-light min-vh-100">
    <div class="siswa-riwayat">
        <div class="d-flex justify-content-between align-items-center mb-4 mt-4">
            <div>
                <h3 class="fw-bold mb-1 text-dark">Riwayat Pengaduan</h3>
            </div>
            <a href="<?php echo e(route('siswa.pengaduan.create')); ?>" class="btn btn-primary rounded-pill px-4 shadow-sm fw-bold">
                <i class="ti ti-plus me-1"></i> Buat Laporan
            </a>
        </div>

        <?php
        $statusFilters = [
        ['label' => 'Semua', 'status' => null, 'icon' => 'ti-list-check'],
        ['label' => 'Menunggu', 'status' => 'Menunggu', 'icon' => 'ti-clock'],
        ['label' => 'Diproses', 'status' => 'Proses', 'icon' => 'ti-loader-3'],
        ['label' => 'Selesai', 'status' => 'Selesai', 'icon' => 'ti-circle-check'],
        ];
        ?>

        <div class="mb-4">
            <div class="filter-pills">
                <?php $__currentLoopData = $statusFilters; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $filter): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <a href="<?php echo e(route('siswa.pengaduan.riwayat', $filter['status'] ? ['status' => $filter['status']] : [])); ?>"
                    class="pill-btn <?php echo e((request('status') === $filter['status']) ? 'active' : ''); ?>">
                    <i class="ti <?php echo e($filter['icon']); ?>"></i>
                    <span><?php echo e($filter['label']); ?></span>
                </a>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>

        <div class="row g-3">
            <?php $__empty_1 = true; $__currentLoopData = $pengaduan; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <?php

            $statusMap = [
            'Menunggu' => ['icon' => 'ti-clock', 'badge' => 'status-menunggu'],
            'Proses' => ['icon' => 'ti-loader', 'badge' => 'status-proses'],
            'Selesai' => ['icon' => 'ti-check', 'badge' => 'status-selesai'],
            ];
            $itemStatus = $item->aspirasi->status ?? 'Menunggu';
            $status = $statusMap[$itemStatus] ?? $statusMap['Menunggu'];
            ?>

            <div class="col-xl-4 col-md-6">
                <div class="card border-0 shadow-sm rounded-4 h-100 card-hover position-relative">
                    <div class="position-absolute top-0 end-0 m-3">
                        <span class="badge bg-white text-muted border shadow-sm">
                            #<?php echo e($totalPengaduan - ($pengaduan->firstItem() ? $pengaduan->firstItem() + $loop->index : $loop->iteration) + 1); ?>

                        </span>
                    </div>

                    <div class="card-body p-4">
                        <div class="d-flex align-items-center mb-4">
                            <div class="status-indicator me-3">
                                <div class="status-badge <?php echo e($status['badge']); ?>">
                                    <i class="ti <?php echo e($status['icon']); ?>"></i>
                                </div>
                            </div>
                            <div class="flex-grow-1">
                                <h6 class="mb-0 fw-bold card-title-clamp" title="<?php echo e($item->ket); ?>">
                                    <?php echo e(Str::words($item->ket, 7, '...')); ?>

                                </h6>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="text-muted x-small text-uppercase fw-bold mb-2 d-block" style="font-size: 0.7rem; letter-spacing: 0.5px;">Informasi Pengaduan</label>
                            <div class="bg-light p-2 rounded-3">
                                <p class="mb-1 fw-medium text-dark small">
                                    <i class="ti ti-tag me-1 text-primary"></i> <?php echo e($item->kategori->ket_kategori ?? 'Umum'); ?>

                                </p>
                                <p class="mb-0 text-muted small">
                                    <i class="ti ti-calendar-event me-1"></i> <?php echo e($item->formatted_created_at); ?>

                                </p>
                            </div>
                        </div>

                        <a href="<?php echo e(route('siswa.pengaduan.show', $item->id_pelaporan)); ?>" class="btn btn-outline-primary btn-sm w-100 rounded-3 py-2 fw-bold">
                            Lihat Progres <i class="ti ti-arrow-right ms-1"></i>
                        </a>
                    </div>
                </div>
            </div>

            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <div class="col-12 text-center py-5">
                <i class="ti ti-notes-off text-muted mb-2" style="font-size: 3rem;"></i>
                <p class="text-muted">Belum ada riwayat pengaduan.</p>
            </div>
            <?php endif; ?>
        </div>

        <div class="mt-5 d-flex justify-content-center">
            <?php echo e($pengaduan->appends(request()->query())->links()); ?>

        </div>
    </div>
</main>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout.main', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\UKK_Aspira\resources\views/siswa/pengaduan/riwayat.blade.php ENDPATH**/ ?>