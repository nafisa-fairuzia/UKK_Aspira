

<?php $__env->startSection('title', 'Detail Pengaduan'); ?>

<?php $__env->startPush('styles'); ?>
<link rel="stylesheet" href="<?php echo e(asset('assets/css/siswa/show.css')); ?>?v=<?php echo e(time()); ?>">
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>

<div class="siswa-show">
    <main id="main-content" class="py-4" style="background: #f4f7f9; min-height: 100vh;">
        <div class="container-fluid">
            <div class="row align-items-center mb-4 mt-4">
                <div class="col-md-8">
                    <h3 class="fw-bold text-dark mb-0">Detail Pengaduan</h3>
                </div>
                <div class="col-md-4 text-md-end mt-3 mt-md-0">
                </div>
            </div>

            <div class="row g-4">
                <div class="col-lg-8">
                    <div class="card border-0 shadow-sm mb-4 overflow-hidden">
                        <div class="card-body p-4">
                            <div class="row position-relative">
                                <?php

                                $timeline = [
                                'Menunggu' => ['icon' => 'ti-clock', 'title' => 'Menunggu'],
                                'Proses' => ['icon' => 'ti-settings', 'title' => 'Diproses'],
                                'Selesai' => ['icon' => 'ti-circle-check', 'title' => 'Selesai'],
                                ];
                                $reached = true;
                                $currentStatus = $aspirasiData->status ?? $aspirasi->status ?? 'Menunggu';
                                ?>

                                <?php $__currentLoopData = $timeline; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $step): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="col text-center">
                                    <div class="d-flex align-items-center justify-content-center mb-2">
                                        <div class="step-dot <?php echo e($reached ? 'step-dot-active' : ''); ?>">
                                            <i class="ti <?php echo e($step['icon']); ?>"></i>
                                        </div>
                                    </div>
                                    <span class="small fw-bold <?php echo e($reached ? 'text-dark' : 'text-muted'); ?>"><?php echo e($step['title']); ?></span>
                                </div>
                                <?php if($currentStatus == $key): ?> <?php $reached = false; ?> <?php endif; ?>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                        </div>
                    </div>

                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-header bg-white py-3 border-bottom border-light">
                            <div class="d-flex align-items-center">
                                <i class="ti ti-notes text-primary me-2 fs-4"></i>
                                <h6 class="m-0 fw-bold text-dark">Isi Pengaduan</h6>
                            </div>
                        </div>
                        <div class="card-body p-4">
                            <div class="mb-4">
                                <label class="text-muted small text-uppercase fw-bold mb-2 d-block">Lokasi Kejadian</label>
                                <p class="fw-bold text-dark"><i class="ti ti-map-pin me-1 text-primary"></i> <?php echo e($aspirasi->lokasi); ?></p>
                            </div>

                            <div class="mb-4">
                                <label class="small fw-bold text-uppercase text-muted d-block mb-2">Deskripsi</label>
                                <div class="bg-light p-4 rounded-3" style="border-left: 4px solid #0d6efd;">
                                    <p class="mb-0 text-dark">
                                        <?php echo e($aspirasi->ket); ?>

                                    </p>
                                </div>
                            </div>

                            <?php if($aspirasi->gambar): ?>
                            <div class="attachment-box mt-4">
                                <label class="small fw-bold text-muted text-uppercase d-block mb-3">Dokumentasi Terlampir</label>
                                <div class="position-relative d-inline-block w-100">
                                    <img src="<?php echo e(asset('storage/' . $aspirasi->gambar)); ?>" class="img-fluid rounded border shadow-sm"
                                        style="max-height: 500px; width: 100%; object-fit: contain; background: #eee;">
                                </div>
                            </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="sticky-wrapper">
                        <div class="card border-0 shadow-sm mb-4 overflow-hidden">
                            <div class="card-header bg-primary text-white py-3 border-0">
                                <div class="d-flex align-items-center">
                                    <i class="ti ti-message-dots me-2"></i>
                                    <h6 class="m-0 fw-bold">Respon Admin</h6>
                                </div>
                            </div>
                            <div class="card-body p-4">
                                <?php if($aspirasiData && $aspirasiData->feedback): ?>
                                <div class="p-3 bg-light rounded-3 border-start border-3 border-primary">
                                    <p class="mb-3 text-dark small lh-base"><?php echo e($aspirasiData->feedback); ?></p>
                                    <div class="d-flex align-items-center mt-2">
                                        <div class="bg-primary rounded-circle me-2" style="width: 8px; height: 8px;"></div>
                                        <span class="small fw-bold text-primary">Admin</span>
                                    </div>
                                </div>
                                <?php else: ?>
                                <div class="text-center py-4">
                                    <div class="spinner-grow spinner-grow-sm text-muted opacity-25 mb-3" role="status"></div>
                                    <p class="small text-muted mb-0 italic">Belum ada tanggapan resmi.</p>
                                </div>
                                <?php endif; ?>
                            </div>
                        </div>

                        <div class="card border-0 shadow-sm">
                            <div class="card-body p-4">
                                <label class="text-muted small text-uppercase fw-bold mb-3 d-block">Informasi Pengaduan</label>

                                <div class="d-flex justify-content-between mb-3">
                                    <span class="text-muted small">Kategori</span>
                                    <span class="badge bg-primary bg-opacity-10 text-primary border border-primary border-opacity-10">
                                        <?php echo e($aspirasi->kategori->ket_kategori ?? 'Umum'); ?>

                                    </span>
                                </div>

                                <div class="d-flex justify-content-between mb-3">
                                    <span class="text-muted small">Tgl Kirim</span>
                                    <span class="small fw-bold text-dark"><?php echo e($aspirasi->formatted_created_at); ?></span>
                                </div>

                                <div class="d-flex justify-content-between mb-3">
                                    <span class="text-muted small">Nomor Pengaduan</span>
                                    <span class="small fw-bold text-primary">ASP-<?php echo e(sprintf('%05d', $aspirasi->id_pelaporan)); ?></span>
                                </div>
                            </div>
                        </div>

                        <a href="<?php echo e(route('siswa.pengaduan.lainnya')); ?>" class="btn btn-outline-primary mt-4 w-100 fw-bold rounded-3">
                            <i class="ti ti-arrow-left me-1"></i> Kembali
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </main>
</div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout.main', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\UKK_Aspira\resources\views/siswa/pengaduan/show_public.blade.php ENDPATH**/ ?>