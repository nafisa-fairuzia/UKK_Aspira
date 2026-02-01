

<?php $__env->startSection('title', 'Kelola Pengaduan'); ?>

<?php $__env->startPush('styles'); ?>
<link rel="stylesheet" href="<?php echo e(asset('assets/css/admin/index.css')); ?>?v=<?php echo e(time()); ?>">
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>

<div class="pengaduan-admin">

    <main id="main-content" class="py-4 bg-light min-vh-100">
        <div class="container-l" style="overflow: visible;">

            <div class="row mb-4 align-items-center">
                <div class="col">
                    <h4 class="fw-bold text-dark mb-0">Daftar Pengaduan</h4>
                </div>
            </div>

            <?php if(session('success')): ?>
            <div class="alert alert-success border-0 shadow-sm rounded-3 mb-4 py-2 small" role="alert">
                <i class="ti ti-check me-2"></i> <?php echo e(session('success')); ?>

            </div>
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

                            <div class="col-md-3">
                                <label class="form-label small fw-semibold text-dark mb-2">Cari Pelapor</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-white border-2 border-end-0 text-muted px-3">
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

                            <div class="col-md-3">
                                <div class="d-flex gap-2">
                                    <button type="submit" class="btn btn-primary fw-bold flex-grow-1 rounded-2 shadow-sm" style="height: 42px; ">
                                        <i class="ti ti-adjustments-horizontal me-1"></i> Filter
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
                            <h6 class="mb-0 fw-bold">Laporan Masuk</h6>
                        </div>
                    </div>
                </div>

                <div class="card-body p-0">
                    <div class="table-responsive p-3">
                        <table id="pengaduanTable" class="table table-hover align-middle mb-0 w-100">
                            <thead class="bg-light">
                                <tr>
                                    <th class="text-center" style="width: 5%">No</th>
                                    <th style="width: 25%">Informasi Pelapor</th>
                                    <th style="width: 15%">Kategori</th>
                                    <th class="text-center" style="width: 30%">Status</th>
                                    <th style="width: 30%">Tanggal</th>
                                    <th class="text-center" style="width: 20%">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__currentLoopData = $pengaduan; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td class="text-center text-muted small fw-bold"><?php echo e($pengaduan->firstItem() + $loop->index); ?></td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <?php if($p->siswa && $p->siswa->profile_pic): ?>
                                            <img src="<?php echo e(asset('storage/' . $p->siswa->profile_pic)); ?>"
                                                class="rounded-circle me-2 border shadow-sm"
                                                style="width: 35px; height: 35px; object-fit: cover; flex-shrink: 0;"
                                                onerror="this.onerror=null; this.src='https://ui-avatars.com/api/?name=<?php echo e(urlencode($p->siswa->nama)); ?>&color=7F9CF5&background=EBF4FF';">
                                            <?php else: ?>
                                            <div class="avatar-sm me-2 bg-primary-subtle rounded-circle d-flex align-items-center justify-content-center" style="width: 35px; height: 35px; flex-shrink: 0;">
                                                <span class="text-primary fw-bold small"><?php echo e(substr($p->siswa->nama ?? 'S', 0, 1)); ?></span>
                                            </div>
                                            <?php endif; ?>
                                            <div>
                                                <div class="fw-bold text-dark mb-0"><?php echo e($p->siswa->nama ?? 'N/A'); ?></div>
                                                <small class="text-muted">Kelas: <?php echo e($p->siswa->kelas->nama_kelas); ?></small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="text-dark fw-medium small"><?php echo e($p->kategori->ket_kategori ?? 'Umum'); ?></span>
                                    </td>
                                    <td class="text-center ">
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
                                        <div class="small fw-medium"><?php echo e($p->created_at->format('d M Y')); ?></div>
                                        <div class="text-muted x-small"><?php echo e($p->created_at->format('H:i')); ?> WIB</div>
                                    </td>
                                    <td class="text-end pe-3">
                                        <div class="d-flex gap-1 justify-content-end">
                                            <a href="<?php echo e(route('admin.pengaduan.show', $p->id_pelaporan)); ?>" class="btn btn-sm btn-white border shadow-sm px-2" title="Detail">
                                                <i class="ti ti-eye text-primary"></i>
                                            </a>

                                            <div class="dropdown">
                                                <button class="btn btn-sm btn-white border shadow-sm dropdown-toggle fw-bold" type="button" data-bs-toggle="dropdown">
                                                    Update
                                                </button>
                                                <ul class="dropdown-menu dropdown-menu-end shadow-lg border-0 p-2">
                                                    <li><small class="dropdown-header text-uppercase opacity-50">Ganti Status:</small></li>
                                                    <?php $__currentLoopData = ['Menunggu', 'Proses', 'Selesai']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $st): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <?php $pStatus = $p->aspirasi->status ?? 'Menunggu'; ?>
                                                    <?php if($st == 'Menunggu' && $pStatus != 'Menunggu'): ?>
                                                    <?php continue; ?>
                                                    <?php endif; ?>
                                                    <?php if($pStatus == 'Selesai'): ?>
                                                    <?php continue; ?>
                                                    <?php endif; ?>
                                                    <li>
                                                        <form action="<?php echo e(route('admin.pengaduan.update', $p->id_pelaporan)); ?>" method="POST">
                                                            <?php echo csrf_field(); ?> <?php echo method_field('PUT'); ?>
                                                            <input type="hidden" name="status" value="<?php echo e($st); ?>">
                                                            <button type="submit" class="dropdown-item rounded-2 <?php echo e($pStatus == $st ? 'active disabled' : ''); ?>">
                                                                <i class="ti ti-<?php echo e($st == 'Menunggu' ? 'clock' : ($st == 'Proses' ? 'loader' : 'check')); ?> me-1"></i> <?php echo e($st); ?>

                                                            </button>
                                                        </form>
                                                    </li>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </ul>
                                            </div>
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
                <?php echo e($pengaduan->links()); ?>

            </div>
        </div>
    </main>
</div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout.main', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\UKK_Aspira\resources\views/admin/pengaduan/index.blade.php ENDPATH**/ ?>