

<?php $__env->startSection('title', 'Ajukan Pengaduan'); ?>

<?php $__env->startPush('styles'); ?>
<link rel="stylesheet" href="<?php echo e(asset('assets/css/siswa/create.css')); ?>?v=<?php echo e(time()); ?>">
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>

<main id="main-content" class="py-4 bg-light min-vh-100">
    <div class="siswa-create">
        <div class="row mb-4">
            <div class="col-12">
                <div class="p-4 rounded-4 shadow-sm border-0 position-relative overflow-hidden"
                    style="background: linear-gradient(135deg, #0ea5e9 0%, #2563eb 100%);">
                    <div class="position-absolute text-white top-0 end-0 mt-n4 me-n4">
                        <i class="ti ti-message-report" style="font-size: 150px; opacity: 20%;"></i>
                    </div>

                    <div class="position-relative z-1 text-white">
                        <h3 class="fw-bold mb-1">Sampaikan Aspirasi Anda</h3>
                        <p class="mb-0 opacity-75">Suara Anda membantu kami membangun sekolah yang lebih baik.</p>
                    </div>
                </div>
            </div>
        </div>

        <form method="POST" action="<?php echo e(route('siswa.pengaduan.store')); ?>" enctype="multipart/form-data">
            <?php echo csrf_field(); ?>
            <div class="row g-4">
                <div class="col-lg-8 col-xl-9">
                    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                        <div class="card-header bg-white border-0 pt-4 px-4 pb-0">
                            <div class="d-flex align-items-center">
                                <div class="p-2 bg-primary-soft rounded-3 me-3 text-primary">
                                    <i class="ti ti-edit fs-4"></i>
                                </div>
                                <h5 class="fw-bold mb-0">Detail Laporan</h5>
                            </div>
                        </div>
                        <div class="card-body p-4">
                            <div class="row g-4">
                                <div class="col-md-6">
                                    <label for="id_kategori" class="form-label small fw-bold text-muted">KATEGORI <span class="text-danger">*</span></label>
                                    <div class="input-modern-group">
                                        <select name="id_kategori" id="id_kategori" class="form-select border-0 shadow-none px-0" required>
                                            <option value="" selected disabled>Pilih Kategori...</option>
                                            <?php $__currentLoopData = $kategori; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $kat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($kat->id_kategori); ?>" <?php echo e(old('id_kategori') == $kat->id_kategori ? 'selected' : ''); ?>>
                                                <?php echo e($kat->ket_kategori); ?>

                                            </option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                        <div class="input-line"></div>
                                    </div>
                                    <?php $__errorArgs = ['id_kategori'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="text-danger x-small mt-1"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>

                                <div class="col-md-6">
                                    <label for="lokasi" class="form-label small fw-bold text-muted">LOKASI <span class="text-danger">*</span></label>
                                    <div class="input-modern-group">
                                        <input type="text" name="lokasi" id="lokasi" class="form-control border-0 shadow-none px-0"
                                            placeholder="Contoh: Depan Kantin" value="<?php echo e(old('lokasi')); ?>" required>
                                        <div class="input-line"></div>
                                    </div>
                                    <?php $__errorArgs = ['lokasi'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="text-danger x-small mt-1"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>

                                <div class="col-12">
                                    <label for="ket" class="form-label small fw-bold text-muted">DESKRIPSI <span class="text-danger">*</span></label>
                                    <div class="p-3 bg-light rounded-4">
                                        <textarea name="ket" id="ket" class="form-control border-0 bg-transparent shadow-none"
                                            rows="10" placeholder="Ceritakan detail masalah..."
                                            maxlength="255" required style="resize: none;"><?php echo e(old('ket')); ?></textarea>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center mt-2 px-1">
                                        <span class="x-small text-muted"><i class="ti ti-info-circle-filled me-1 text-primary"></i>Maksimal 255 karakter.</span>
                                        <span id="charCount" class="badge rounded-pill bg-primary px-3 fw-normal">0 / 255</span>
                                    </div>
                                    <?php $__errorArgs = ['ket'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="text-danger x-small mt-1"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-xl-3">
                    <div class="d-flex flex-column gap-4">

                        <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                            <div class="card-body p-4 text-center">
                                <h6 class="fw-bold text-start mb-3">Lampiran Bukti</h6>
                                <div class="upload-interactive" id="drop-area">
                                    <input type="file" name="gambar" id="gambar" class="d-none" accept="image/*">
                                    <label for="gambar" class="m-0 cursor-pointer w-100">
                                        <div id="upload-ui" class="py-3">
                                            <div class="icon-pulse mx-auto mb-2 text-primary">
                                                <i class="ti ti-cloud-upload fs-1"></i>
                                            </div>
                                            <p class="small fw-bold mb-0">Klik Untuk Cari</p>
                                            <span class="x-small text-muted opacity-75">Sertakan foto bukti</span>
                                        </div>
                                        <div id="preview-ui" class="d-none">
                                            <img id="previewImg" src="" class="img-fluid rounded-3 shadow-sm border">
                                            <div class="mt-2 x-small text-primary fw-bold"><i class="ti ti-refresh me-1"></i>Ganti Foto</div>
                                        </div>
                                    </label>
                                </div>
                                <button type="button" id="clearImage" class="btn btn-sm btn-outline-danger border-0 w-100 mt-2 d-none">
                                    <i class="ti ti-trash me-1"></i> Batalkan Foto
                                </button>
                            </div>
                        </div>

                        <div class="card border-0 bg-white shadow-sm rounded-4 overflow-hidden">
                            <div class="p-4 bg-light text-center border-bottom border-white">
                                <div class="text-primary mb-2"><i class="ti ti-shield-check fs-2"></i></div>
                                <p class="small text-muted mb-0 px-2">Laporan akan dikirim secara aman dan terenkripsi.</p>
                            </div>
                            <div class="p-4">
                                <button type="submit" class="btn btn-primary w-100 py-3 rounded-3 fw-bold shadow-sm mb-3">
                                    Kirim Laporan <i class="ti ti-arrow-right ms-2"></i>
                                </button>
                                <a href="<?php echo e(route('siswa.dashboard')); ?>" class="btn btn-light w-100 py-2 btn-sm text-muted">Kembali</a>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </form>

    </div>
</main>

<script>
    const ketInput = document.getElementById('ket');
    const charCountSpan = document.getElementById('charCount');

    // Update character count
    ketInput.addEventListener('input', () => {
        // Enforce 255 character limit
        if (ketInput.value.length > 255) {
            ketInput.value = ketInput.value.substring(0, 255);
        }
        charCountSpan.textContent = ketInput.value.length + ' / 255';
    });

    // Prevent form submission if content exceeds 255 chars
    document.querySelector('form').addEventListener('submit', function(e) {
        const ketValue = ketInput.value.trim();
        if (ketValue.length > 255) {
            e.preventDefault();
            alert('Deskripsi tidak boleh lebih dari 255 karakter!');
            return false;
        }
    });
</script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout.main', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\UKK_Aspira\resources\views/siswa/pengaduan/create.blade.php ENDPATH**/ ?>