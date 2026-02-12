<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <title><?php echo $__env->yieldContent('title', 'ASPIRA'); ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap"
        rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
    <link rel="icon" type="image/png" href="<?php echo e(asset('assets/img/logo_aspira1.png')); ?>?v=<?php echo e(time()); ?>" sizes="32x32">
    <link rel="icon" type="image/png" href="<?php echo e(asset('assets/img/logo_aspira1.png')); ?>?v=<?php echo e(time()); ?>" sizes="16x16">
    <link rel="shortcut icon" href="<?php echo e(asset('assets/img/logo_aspira1.png')); ?>?v=<?php echo e(time()); ?>">
    <link rel="apple-touch-icon" href="<?php echo e(asset('assets/img/logo_aspira1.png')); ?>?v=<?php echo e(time()); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('assets/css/global.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('assets/css/modal.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('assets/css/admin/dashboard.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('assets/css/admin/index.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('assets/css/admin/kategori.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('assets/css/admin/show.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('assets/css/siswa/dashboard.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('assets/css/siswa/create.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('assets/css/siswa/riwayat.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('assets/css/siswa/show.css')); ?>">

</head>

<body>

    <?php echo $__env->make('layout.sidebar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <?php echo $__env->make('layout.header', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <?php echo $__env->yieldContent('content'); ?>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

    <script src="<?php echo e(asset('assets/js/layout.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/js/data_tables.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/js/login.js')); ?>"></script>

    <script>
        (function() {
            const isCollapsed = localStorage.getItem('sidebarCollapsed') === 'true';
            if (isCollapsed) {
                document.documentElement.classList.add('sidebar-no-transition');
            }
        })();
    </script>


    <div class="modal fade" id="logoutModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow rounded-3">
                <div class="modal-header border-0 px-4">
                    <h5 class="fw-bold text-dark mb-0">Konfirmasi Logout</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-4">
                    <p class="mb-0">Apakah Anda yakin ingin logout sekarang?</p>
                </div>
                <div class="modal-footer border-0 p-4 pt-0">
                    <button type="button" class="btn btn-light fw-bold" data-bs-dismiss="modal">Batal</button>
                    <button type="button" id="confirmLogoutBtn" class="btn btn-danger fw-bold">Logout</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        let logoutModalInstance = null;
        let logoutFormEl = null;

        window.openLogoutModal = function() {
            if (!logoutModalInstance) {
                const el = document.getElementById('logoutModal');
                if (el) {
                    logoutModalInstance = new bootstrap.Modal(el);
                }
            }
            if (logoutModalInstance) {
                logoutModalInstance.show();
            }
        };

        (function() {
            document.addEventListener('DOMContentLoaded', function() {
                const logoutModalEl = document.getElementById('logoutModal');
                if (logoutModalEl) {
                    logoutModalInstance = new bootstrap.Modal(logoutModalEl);
                }
                logoutFormEl = document.getElementById('logout-form');

                const confirmLogoutBtn = document.getElementById('confirmLogoutBtn');
                if (confirmLogoutBtn && logoutFormEl) {
                    confirmLogoutBtn.addEventListener('click', function() {
                        logoutFormEl.submit();
                    });
                }
            });
        })();
    </script>

    <?php echo $__env->make('components.logout-modal', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

    <?php echo $__env->yieldPushContent('scripts'); ?>
</body>

</html><?php /**PATH C:\laragon\www\UKK_Aspira\resources\views/layout/main.blade.php ENDPATH**/ ?>