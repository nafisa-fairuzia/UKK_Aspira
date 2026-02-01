<nav id="sidebar">
    <!-- Toggle button di mobile (kanan atas sidebar) -->
    <button class="btn sidebar-close-btn d-lg-none p-0 border-0" onclick="toggleMobile()" title="Tutup">
        <i class="bi bi-x fs-2"></i>
    </button>

    <div class="sidebar-header d-flex align-items-center justify-content-center">
        <div class="logo-container d-flex align-items-center justify-content-center">
            <img src="<?php echo e(asset('assets/img/logo_aspira2.png')); ?>" class="img-fluid logo-img" alt="Logo">
        </div>
        <span class="fw-bold logo-text">ASPIRA<span style="color: #0ea5e9;">.</span></span>
    </div>

    <div class="nav flex-column">
        <?php if(!session()->has('nis')): ?>
        <a href="<?php echo e(route('admin.dashboard')); ?>" class="nav-link <?php echo e(request()->routeIs('admin.dashboard') ? 'active' : ''); ?>">
            <i class="ti ti-dashboard"></i>
            <span class="nav-text">Dashboard</span>
        </a>

        <div class="section-header">LAPORAN</div>
        <a href="<?php echo e(route('admin.pengaduan.index')); ?>" class="nav-link <?php echo e(request()->routeIs('admin.pengaduan.*') ? 'active' : ''); ?>">
            <i class="ti ti-file-text"></i>
            <span class="nav-text">Pengaduan</span>
        </a>

        <div class="section-header">DATA MASTER</div>
        <a href="<?php echo e(route('admin.siswa.index')); ?>" class="nav-link <?php echo e(request()->routeIs('admin.siswa.*') ? 'active' : ''); ?>">
            <i class="ti ti-users"></i>
            <span class="nav-text">Data Siswa</span>
        </a>
        <a href="<?php echo e(route('admin.kategori.index')); ?>" class="nav-link <?php echo e(request()->routeIs('admin.kategori.*') ? 'active' : ''); ?>">
            <i class="ti ti-archive"></i>
            <span class="nav-text">Data Kategori</span>
        </a>
        <a href="<?php echo e(route('admin.admins.index')); ?>" class="nav-link <?php echo e(request()->routeIs('admin.admins.*') ? 'active' : ''); ?>">
            <i class="ti ti-shield-check"></i>
            <span class="nav-text">Data Admin</span>
        </a>

        <?php else: ?>
        <a href="<?php echo e(route('siswa.dashboard')); ?>" class="nav-link <?php echo e(request()->routeIs('siswa.dashboard') ? 'active' : ''); ?>">
            <i class="ti ti-dashboard"></i>
            <span class="nav-text">Dashboard</span>
        </a>

        <div class="section-header">MENU SISWA</div>
        <a href="<?php echo e(route('siswa.pengaduan.create')); ?>" class="nav-link <?php echo e(request()->routeIs('siswa.pengaduan.create') ? 'active' : ''); ?>">
            <i class="ti ti-edit"></i>
            <span class="nav-text">Ajukan Pengaduan</span>
        </a>
        <a href="<?php echo e(route('siswa.pengaduan.riwayat')); ?>" class="nav-link <?php echo e(request()->routeIs('siswa.pengaduan.riwayat') ? 'active' : ''); ?>">
            <i class="ti ti-history"></i>
            <span class="nav-text">Riwayat</span>
        </a>
        <?php endif; ?>

        <div class="nav-logout">
            <a href="javascript:void(0)" class="nav-link text-danger" onclick="openLogoutModal()">
                <i class="ti ti-logout"></i>
                <span class="nav-text">Logout</span>
            </a>
            <form id="logout-form" action="<?php echo e(route('logout')); ?>" method="POST" class="d-none">
                <?php echo csrf_field(); ?>
            </form>
        </div>
    </div>
</nav>

<div class="sidebar-overlay"></div><?php /**PATH C:\laragon\www\UKK_Aspira\resources\views/layout/sidebar.blade.php ENDPATH**/ ?>