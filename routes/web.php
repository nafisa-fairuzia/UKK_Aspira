<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\PengaduanController;
use App\Http\Controllers\Admin\SiswaController;
use App\Http\Controllers\Admin\KategoriController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Siswa\DashboardSiswaController;
use App\Http\Controllers\Siswa\PengaduanController as SiswaPengaduanController;
use Illuminate\Support\Facades\Route;


Route::get('/', [AuthController::class, 'showLogin'])->name('login');
Route::post('/', [AuthController::class, 'loginProcess']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// API Routes for Select2
Route::get('/api/kelas-search', [AuthController::class, 'searchKelas'])->name('api.kelas.search');


Route::prefix('admin')->middleware('checklogin')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('admin.dashboard');

    Route::post('/logout', [AuthController::class, 'logout'])->name('admin.logout');

    Route::get('/pengaduan', [PengaduanController::class, 'index'])
        ->name('admin.pengaduan.index');

    Route::get('/pengaduan/{pengaduan}', [PengaduanController::class, 'show'])
        ->name('admin.pengaduan.show');

    Route::put('/pengaduan/{pengaduan}', [PengaduanController::class, 'update'])
        ->name('admin.pengaduan.update');

    Route::get('/notifications', [DashboardController::class, 'getNotifications'])
        ->name('admin.notifications.index');

    Route::post('/notifications/mark-read', [DashboardController::class, 'markNotificationsRead'])
        ->name('admin.notifications.mark-read');

    Route::post('/notifications/{id}/mark-read', [DashboardController::class, 'markSingleNotificationRead'])
        ->name('admin.notifications.mark-single-read');

    Route::post('/profile/upload-picture', [DashboardController::class, 'uploadProfilePicture'])
        ->name('admin.profile.upload-picture');
    Route::post('/profile/delete-picture', [DashboardController::class, 'deleteProfilePicture'])
        ->name('admin.profile.delete-picture');

    Route::get('/siswa', [SiswaController::class, 'index'])->name('admin.siswa.index');
    Route::get('/siswa/create', [SiswaController::class, 'create'])->name('admin.siswa.create');
    Route::post('/siswa', [SiswaController::class, 'store'])->name('admin.siswa.store');
    Route::get('/siswa/{nis}/edit', [SiswaController::class, 'edit'])->name('admin.siswa.edit');
    Route::put('/siswa/{nis}', [SiswaController::class, 'update'])->name('admin.siswa.update');
    Route::delete('/siswa/{nis}', [SiswaController::class, 'destroy'])->name('admin.siswa.destroy');

    Route::get('/kategori', [KategoriController::class, 'index'])->name('admin.kategori.index');
    Route::get('/kategori/create', [KategoriController::class, 'create'])->name('admin.kategori.create');
    Route::post('/kategori', [KategoriController::class, 'store'])->name('admin.kategori.store');
    Route::get('/kategori/{id}/edit', [KategoriController::class, 'edit'])->name('admin.kategori.edit');
    Route::put('/kategori/{id}', [KategoriController::class, 'update'])->name('admin.kategori.update');
    Route::delete('/kategori/{id}', [KategoriController::class, 'destroy'])->name('admin.kategori.destroy');

    // Admin accounts management
    Route::get('/admins', [AdminController::class, 'index'])->name('admin.admins.index');
    Route::post('/admins', [AdminController::class, 'store'])->name('admin.admins.store');
    Route::get('/admins/{id}/edit', [AdminController::class, 'edit'])->name('admin.admins.edit');
    Route::put('/admins/{id}', [AdminController::class, 'update'])->name('admin.admins.update');
    Route::delete('/admins/{id}', [AdminController::class, 'destroy'])->name('admin.admins.destroy');
});


Route::prefix('siswa')->middleware('checklogin')->group(function () {
    Route::get('/dashboard', [DashboardSiswaController::class, 'index'])
        ->name('siswa.dashboard');

    Route::post('/logout', [AuthController::class, 'logout'])->name('siswa.logout');

    Route::get('/pengaduan/create', [SiswaPengaduanController::class, 'create'])
        ->name('siswa.pengaduan.create');

    Route::post('/pengaduan', [SiswaPengaduanController::class, 'store'])
        ->name('siswa.pengaduan.store');

    Route::get('/pengaduan/riwayat', [SiswaPengaduanController::class, 'riwayat'])
        ->name('siswa.pengaduan.riwayat');

    Route::get('/pengaduan/{aspirasi}', [SiswaPengaduanController::class, 'show'])
        ->name('siswa.pengaduan.show');

    Route::get('/pengaduan/{aspirasi}/edit', [SiswaPengaduanController::class, 'editForm'])
        ->name('siswa.pengaduan.editForm');

    Route::put('/pengaduan/{aspirasi}', [SiswaPengaduanController::class, 'update'])
        ->name('siswa.pengaduan.update');

    Route::patch('/pengaduan/{aspirasi}/cancel', [SiswaPengaduanController::class, 'cancel'])
        ->name('siswa.pengaduan.cancel');

    Route::get('/notifications', [DashboardSiswaController::class, 'getNotifications'])
        ->name('siswa.notifications.index');

    Route::post('/notifications/mark-read', [DashboardSiswaController::class, 'markNotificationsRead'])
        ->name('siswa.notifications.mark-read');

    Route::post('/notifications/{id}/mark-read', [DashboardSiswaController::class, 'markSingleNotificationRead'])
        ->name('siswa.notifications.mark-single-read');

    Route::post('/profile/upload-picture', [DashboardSiswaController::class, 'uploadProfilePicture'])
        ->name('siswa.profile.upload-picture');
    Route::post('/profile/delete-picture', [DashboardSiswaController::class, 'deleteProfilePicture'])
        ->name('siswa.profile.delete-picture');
});
