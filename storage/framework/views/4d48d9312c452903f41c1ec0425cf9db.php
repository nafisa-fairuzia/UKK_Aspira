

<?php $__env->startSection('title', 'Dashboard Siswa'); ?>

<?php $__env->startPush('styles'); ?>
<link rel="stylesheet" href="<?php echo e(asset('assets/css/siswa/dashboard.css')); ?>?v=<?php echo e(time()); ?>">
<style>
    :root {
        --stat-color-default: #0ea5e9;
    }

    .stat-color {
        color: var(--stat-color);
    }

    .bg-color {
        background-color: var(--bg-color);
    }

    .timeline-dot {
        background-color: var(--timeline-color);
    }

    .timeline-icon {
        color: var(--timeline-color);
    }
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<div class="siswa-dashboard ">
    <main id="main-content" class="py-4">
        <div class="card welcome-card mb-4 mt-4 border-0 shadow-lg position-relative overflow-hidden rounded-4 ">
            <div class="card-body p-4 p-md-5">
                <div class="row align-items-center position-relative" style="z-index: 2;">
                    <div class="col-md-7 text-white">
                        <span class="badge bg-white bg-opacity-25 mb-3 px-3 py-2 rounded-pill">
                            Selamat Datang Kembali
                        </span>
                        <h2 class="fw-bold mb-1">Hi, <?php echo e(Session::get('nama') ?? 'Siswa'); ?>! ✨</h2>
                        <p class="opacity-75 mb-4">
                            Suaramu sangat berarti untuk kenyamanan belajar kita.
                            Sudahkah kamu mengecek kondisi kelas hari ini?
                        </p>
                        <div class="d-flex gap-2">
                            <a href="<?php echo e(route('siswa.pengaduan.create')); ?>"
                                class="btn btn-light rounded-pill px-4 fw-bold shadow-sm">
                                <i class="ti ti-plus me-1"></i> Buat Pengaduan
                            </a>
                            <button class="btn btn-outline-light rounded-pill px-4" data-bs-toggle="modal" data-bs-target="#modalPanduan">
                                Panduan
                            </button>
                        </div>
                    </div>
                </div>

                <div class="decoration-circle-1"></div>
                <div class="decoration-circle-2"></div>
                <img src="<?php echo e(asset('assets/img/aspira5.png')); ?>"
                    class="welcome-img"
                    alt="Illustration">
            </div>
        </div>

        <div class="row g-4 mb-4">
            <?php
            $stats = [
            [
            'label' => 'Total Pengaduan',
            'val' => $total,
            'icon' => 'ti-folder',
            'bg' => 'info',
            'color' => '#0ea5e9',
            'status' => null
            ],
            [
            'label' => 'Menunggu',
            'val' => $menunggu,
            'icon' => 'ti-clock-pause',
            'bg' => 'warning',
            'color' => '#f59e0b',
            'status' => 'Menunggu'
            ],
            [
            'label' => 'Proses',
            'val' => $proses,
            'icon' => 'ti-settings-automation',
            'bg' => 'primary',
            'color' => '#0ea5e9',
            'status' => 'Proses'
            ],
            [
            'label' => 'Selesai',
            'val' => $selesai,
            'icon' => 'ti-circle-check',
            'bg' => 'success',
            'color' => '#10b981',
            'status' => 'Selesai'
            ],
            ];
            ?>

            <?php $__currentLoopData = $stats; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $st): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php
            $link = $st['status'] ? route('siswa.pengaduan.riwayat', ['status' => $st['status']]) : route('siswa.pengaduan.riwayat');
            ?>
            <div class="col-6 col-lg-3">
                <a href="<?php echo e($link); ?>" class="text-decoration-none text-reset d-block" title="Lihat <?php echo e($st['label']); ?>">
                    <div class="card border-0 p-4 rounded-4 shadow-sm h-100 card-hover" style="cursor: pointer;">
                        <div class="d-flex align-items-center justify-content-between">
                            <div>
                                <div class="text-muted small fw-bold text-uppercase"><?php echo e($st['label']); ?></div>
                                <h2 class="fw-bold mb-0 mt-1" style="color: <?php echo $st['color']; ?>;">
                                    <?php echo e($st['val']); ?>

                                </h2>
                            </div>
                            <div class="flex-shrink-0">
                                <div class="bg-<?php echo e($st['bg']); ?> bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center" style="width: 55px; height: 55px;">
                                    <i class="ti <?php echo e($st['icon']); ?> fs-3" style="color: <?php echo $st['color']; ?>;"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>



        <div class="row g-4 mt-2">

            <div class="col-lg-8">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <h5 class="fw-bold mb-0 text-dark">Aktivitas Terbaru</h5>
                    <a href="<?php echo e(route('siswa.pengaduan.riwayat')); ?>" class="btn btn-sm btn-light rounded-pill px-3 fw-bold text-primary">Lihat Semua</a>
                </div>

                <div class="timeline">
                    <?php $__empty_1 = true; $__currentLoopData = $riwayat->take(3); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <?php

                    $st = strtolower($item->aspirasi->status ?? 'menunggu');

                    if($st == 'selesai') {
                    $color = '#10b981';
                    $bgSubtle = 'bg-success-subtle';
                    $iconStatus = 'ti-circle-check';
                    } elseif($st == 'proses') {
                    $color = '#0ea5e9';
                    $bgSubtle = 'bg-info-subtle';
                    $iconStatus = 'ti-settings-automation';
                    } else {
                    $color = '#f59e0b';
                    $bgSubtle = 'bg-warning-subtle';
                    $iconStatus = 'ti-clock-pause';
                    }
                    ?>

                    <div class="timeline-item d-flex gap-3 mb-3">
                        <div class="timeline-status d-flex flex-column align-items-center">
                            
                            <div class="dot shadow-sm" style="background-color: <?= $color ?>; width: 12px; height: 12px; border-radius: 50%;"></div>
                            <div class="line" style="width: 2px; background-color: #e9ecef; flex-grow: 1; margin: 4px 0;"></div>
                        </div>

                        <div class="card border-0 shadow-sm rounded-4 w-100 stat-hover">
                            <div class="card-body p-3">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="d-flex align-items-center gap-3">
                                        
                                        <div class="p-2 rounded-3 <?php echo e($bgSubtle); ?> d-flex align-items-center justify-content-center" style="width: 45px; height: 45px;">
                                            <i class="ti <?php echo e($iconStatus); ?> fs-4" style="color: <?= $color ?>;"></i>
                                        </div>

                                        <div>
                                            
                                            <h6 class="fw-bold mb-1 small" style="color: <?= $color ?>;">
                                                <?php echo e($item->kategori->ket_kategori ?? 'Umum'); ?>

                                            </h6>
                                            <p class="text-muted small mb-0"><?php echo e(Str::limit($item->lokasi, 30)); ?></p>
                                        </div>
                                    </div>

                                    <div class="text-end">
                                        <span class="badge <?php echo e($bgSubtle); ?> text-dark opacity-75 rounded-pill mb-1" style="font-size: 10px;">
                                            <?php echo e($item->created_at->diffForHumans()); ?>

                                        </span>
                                        
                                        <a href="<?php echo e(route('siswa.pengaduan.show', $item->id_pelaporan)); ?>" class="d-block fw-bold small text-decoration-none" style="color: <?= $color ?>;">
                                            Lihat <i class="ti ti-arrow-right"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <div class="card border-0 shadow-sm rounded-4 w-100 p-5 text-center">
                        <p class="text-muted small mb-0">Belum ada aktivitas pengaduan.</p>
                    </div>
                    <?php endif; ?>
                </div>
            </div>

            <div class="col-lg-4">
                <h5 class="fw-bold mb-3 text-dark">Jam Operasional</h5>

                <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-4">
                    <div class=" p-0">
                        <div class="p-4 text-white" style="background: var(--gradient);">
                            <div class="d-flex align-items-center gap-3">
                                <div class="bg-white bg-opacity-25 rounded-circle d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                                    <i class="ti ti-clock-play fs-3"></i>
                                </div>
                                <div>
                                    <h6 class="fw-bold mb-0">Waktu Pelayanan</h6>
                                    <p class="small mb-0 opacity-75">Senin - Jumat</p>
                                </div>
                            </div>
                        </div>

                        <div class="p-4">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <span class="text-muted small fw-bold">JAM KERJA</span>
                                <span class="badge bg-primary-subtle text-primary rounded-pill">07:00 - 15:00</span>
                            </div>
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <span class="text-muted small fw-bold">ISTIRAHAT</span>
                                <span class="badge bg-light text-muted rounded-pill">12:00 - 13:00</span>
                            </div>
                            <hr class="opacity-50">
                            <div class="d-flex align-items-center gap-2 text-success">
                                <i class="ti ti-circle-check"></i>
                                <span class="small fw-bold">Sistem Menerima Pengaduan 24 Jam</span>
                            </div>
                            <p class="x-small text-muted mt-2 mb-0">
                                *Pengaduan yang masuk di luar jam kerja akan diproses pada hari kerja berikutnya.
                            </p>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <div class="d-flex align-items-center justify-content-between mb-3 mt-4">
            <h5 class="fw-bold mb-0 text-dark">Pengaduan Siswa Lain</h5>
            <a href="<?php echo e(route('siswa.pengaduan.lainnya')); ?>" class="btn btn-sm btn-light rounded-pill px-3 fw-bold text-primary">Lihat Semua</a>
        </div>

        <div class="row g-3 mb-4">
            <?php $__empty_1 = true; $__currentLoopData = $othersLatest; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $other): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <?php
            $st = strtolower($other['status'] ?? 'menunggu');
            if($st == 'selesai') { $color = '#10b981'; $bgSubtle = 'bg-success-subtle'; $iconStatus = 'ti-circle-check'; }
            elseif($st == 'proses') { $color = '#0ea5e9'; $bgSubtle = 'bg-info-subtle'; $iconStatus = 'ti-settings-automation'; }
            else { $color = '#f59e0b'; $bgSubtle = 'bg-warning-subtle'; $iconStatus = 'ti-clock-pause'; }
            ?>
            <div class="col-xl-4 col-md-6">
                <div class="card border-0 shadow-sm rounded-4 h-100 card-hover">
                    <div class="card-body p-4">
                        <?php
                        $s = $other['status'] ?? 'Menunggu';
                        $badgeClass = $s === 'Menunggu' ? 'bg-warning-subtle text-warning' : ($s === 'Proses' ? 'bg-primary-subtle text-primary' : ($s === 'Selesai' ? 'bg-success-subtle text-success' : 'bg-light text-secondary'));
                        ?>

                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <span class="badge <?php echo e($badgeClass); ?> border-0 px-3 py-2 rounded-pill small fw-bold"><?php echo e(strtoupper($s)); ?></span>
                            <small class="text-muted fw-medium">ASP-<?php echo e(sprintf('%05d', $other['id'])); ?></small>
                        </div>

                        <div class="d-flex align-items-center mb-4">
                            <div class="avatar-box bg-primary-subtle rounded-3 d-flex align-items-center justify-content-center fw-bold me-3 text-primary" style="width:45px; height:45px; font-size:18px;">
                                <?php echo e(strtoupper(substr($other['nama'] ?? 'S', 0, 1))); ?>

                            </div>
                            <div>
                                <h6 class="mb-0 fw-bold"><?php echo e($other['nama'] ?? 'N/A'); ?></h6>
                                <small class="text-muted">NIS: <?php echo e($other['nis']); ?></small>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="text-muted x-small text-uppercase fw-bold mb-1 d-block">Kategori & Waktu</label>
                            <p class="mb-0 fw-medium text-dark small"><i class="ti ti-tag me-1 text-primary"></i> <?php echo e($other['kategori'] ?? 'Umum'); ?></p>
                            <p class="mb-0 text-muted x-small"><i class="ti ti-clock me-1"></i> <?php echo e(\Illuminate\Support\Carbon::parse($other['created_at'])->translatedFormat('d M Y H:i')); ?></p>
                        </div>

                        <p class="small text-secondary mb-3"><?php echo e(Str::limit($other['deskripsi'] ?? $other['lokasi'], 120)); ?></p>

                        <a href="<?php echo e(route('siswa.pengaduan.showPublic', $other['id'])); ?>" class="btn btn-outline-primary btn-sm w-100 rounded-3 py-2 fw-bold">Lihat</a>
                    </div>
                </div>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <div class="col-12">
                <div class="card border-0 shadow-sm rounded-4 w-100 p-4 text-center">
                    <p class="text-muted small mb-0">Belum ada pengaduan dari siswa lain.</p>
                </div>
            </div>
            <?php endif; ?>
        </div>
    </main>
</div>
<div class="modal fade" id="modalPanduan" tabindex="-1" aria-labelledby="modalPanduanLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 rounded-4 overflow-hidden">
            <div class="modal-header bg-primary text-white p-4">
                <h5 class="modal-title fw-bold" id="modalPanduanLabel">
                    <i class="ti ti-info-circle me-2"></i> Cara Membuat Pengaduan
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <div class="row g-4 text-center">
                    <div class="col-md-4">
                        <div class="p-3 bg-light rounded-4 h-100">
                            <div class="bg-primary bg-opacity-10 text-primary rounded-circle d-flex align-items-center justify-content-center mx-auto mb-3" style="width: 60px; height: 60px;">
                                <i class="ti ti-edit fs-2"></i>
                            </div>
                            <h6 class="fw-bold">1. Isi Form</h6>
                            <p class="small text-muted mb-0">Klik tombol "Buat Pengaduan " dan jelaskan detail kerusakan fasilitas.</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="p-3 bg-light rounded-4 h-100">
                            <div class="bg-warning bg-opacity-10 text-warning rounded-circle d-flex align-items-center justify-content-center mx-auto mb-3" style="width: 60px; height: 60px;">
                                <i class="ti ti-camera fs-2"></i>
                            </div>
                            <h6 class="fw-bold">2. Upload Bukti</h6>
                            <p class="small text-muted mb-0">Lampirkan foto fasilitas yang rusak agar admin lebih mudah memverifikasi.</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="p-3 bg-light rounded-4 h-100">
                            <div class="bg-success bg-opacity-10 text-success rounded-circle d-flex align-items-center justify-content-center mx-auto mb-3" style="width: 60px; height: 60px;">
                                <i class="ti ti-refresh fs-2"></i>
                            </div>
                            <h6 class="fw-bold">3. Pantau Progres</h6>
                            <p class="small text-muted mb-0">Cek status Pengaduanmu di dashboard secara berkala hingga selesai.</p>
                        </div>
                    </div>
                </div>

                <hr class="my-4">

                <div class="alert alert-info border-0 rounded-3 d-flex align-items-center">
                    <i class="ti ti-alert-circle fs-4 me-3"></i>
                    <div class="small">
                        <strong>Catatan:</strong> Pengaduan yang masuk akan diverifikasi oleh Admin maksimal 1x24 jam pada hari kerja.
                    </div>
                </div>
            </div>
            <div class="modal-footer border-0 p-4 pt-0">
                <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Tutup</button>
                <a href="<?php echo e(route('siswa.pengaduan.create')); ?>" class="btn btn-primary rounded-pill px-4">Mulai Melapor</a>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout.main', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\UKK_Aspira\resources\views/siswa/dashboard/index.blade.php ENDPATH**/ ?>