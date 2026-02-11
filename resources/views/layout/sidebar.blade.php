<nav id="sidebar">
    <button class="btn sidebar-close-btn d-lg-none p-0 border-0" onclick="toggleMobile()" title="Tutup">
        <i class="bi bi-x fs-2"></i>
    </button>

    <div class="sidebar-header d-flex align-items-center justify-content-center">
        <div class="logo-container d-flex align-items-center justify-content-center">
            <img src="{{ asset('assets/img/logo_aspira1.png') }}" class="img-fluid logo-img" alt="Logo">
        </div>
        <span class="fw-bold logo-text italic" style="font-size: 18px;">ASPIRA</span>
    </div>

    <div class="nav flex-column">
        @php
        $isAdmin = !session()->has('nis');
        @endphp

        @if($isAdmin)
        <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
            <i class="ti ti-dashboard"></i>
            <span class="nav-text">Dashboard</span>
        </a>

        <div class="section-header">LAPORAN</div>
        <a href="{{ route('admin.pengaduan.index') }}" class="nav-link {{ request()->routeIs('admin.pengaduan.*') ? 'active' : '' }}">
            <i class="ti ti-file-text"></i>
            <span class="nav-text">Pengaduan</span>
        </a>

        <div class="section-header">DATA MASTER</div>
        <a href="{{ route('admin.siswa.index') }}" class="nav-link {{ request()->routeIs('admin.siswa.*') ? 'active' : '' }}">
            <i class="ti ti-users"></i>
            <span class="nav-text">Data Siswa</span>
        </a>
        <a href="{{ route('admin.kategori.index') }}" class="nav-link {{ request()->routeIs('admin.kategori.*') ? 'active' : '' }}">
            <i class="ti ti-archive"></i>
            <span class="nav-text">Data Kategori</span>
        </a>
        <a href="{{ route('admin.admins.index') }}" class="nav-link {{ request()->routeIs('admin.admins.*') ? 'active' : '' }}">
            <i class="ti ti-shield-check"></i>
            <span class="nav-text">Data Admin</span>
        </a>
        @else
        <a href="{{ route('siswa.dashboard') }}" class="nav-link {{ request()->routeIs('siswa.dashboard') ? 'active' : '' }}">
            <i class="ti ti-dashboard"></i>
            <span class="nav-text">Dashboard</span>
        </a>

        <div class="section-header">MENU SISWA</div>
        <a href="{{ route('siswa.pengaduan.create') }}" class="nav-link {{ request()->routeIs('siswa.pengaduan.create') ? 'active' : '' }}">
            <i class="ti ti-edit"></i>
            <span class="nav-text">Ajukan Pengaduan</span>
        </a>
        <a href="{{ route('siswa.pengaduan.riwayat') }}" class="nav-link {{ request()->routeIs('siswa.pengaduan.riwayat') ? 'active' : '' }}">
            <i class="ti ti-history"></i>
            <span class="nav-text">Riwayat</span>
        </a>
        @endif

        <div class="nav-logout">
            <a href="javascript:void(0)" class="nav-link text-danger" onclick="openLogoutModal()">
                <i class="ti ti-logout"></i>
                <span class="nav-text">Logout</span>
            </a>
        </div>
    </div>
</nav>

<div class="sidebar-overlay"></div>