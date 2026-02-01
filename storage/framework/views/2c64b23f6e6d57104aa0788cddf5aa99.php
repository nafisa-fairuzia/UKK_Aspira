<?php
$role = Session::get('role');
$nama = Session::get('nama');

$avatarName = $nama ?? 'Admin';

$profilePic = ($role == 'admin') ? Session::get('profile_pic') : (Session::get('siswa_profile_pic') ?? Session::get('profile_pic'));
$defaultAvatar = "https://ui-avatars.com/api/?name=" . urlencode($avatarName) . "&background=0ea5e9&color=fff";
$displayPic = $profilePic ? asset('storage/' . $profilePic) : $defaultAvatar;
$baseUrl = ($role == 'admin') ? '/admin' : '/siswa';
?>

<style>
    .btn-notification,
    .btn-profile {
        transition: all 0.2s ease;
    }

    .btn-notification {
        background-color: #f1f5f9;
        color: #0ea5e9;
        border-radius: 8px;
        width: 40px;
        height: 40px;
    }

    .btn-notification:hover {
        border: 2px solid #0ea5e9;
        transform: scale(1.05);
        background-color: #f1f5f9 !important;
    }

    .btn-profile:hover {
        background-color: #f8f9fa !important;
    }

    #notification-badge {
        top: 4px !important;
        right: 4px !important;
        transform: translate(50%, -50%);
        border: 2px solid #fff;
        font-weight: 600;
        min-width: 20px;
        height: 20px;
        font-size: 9px;
    }

    /* CSS UNTUK TITIK BIRU NOTIF BARU */
    .unread-dot {
        width: 8px;
        height: 8px;
        background-color: #0ea5e9;
        border-radius: 50%;
        display: inline-block;
        margin-left: auto;
        flex-shrink: 0;
    }

    .dropdown-toggle::after {
        display: none;
    }

    #notification-list {
        max-height: 400px;
        overflow-y: auto;
    }

    #notification-list::-webkit-scrollbar {
        width: 6px;
    }

    #notification-list::-webkit-scrollbar-thumb {
        background: #cbd5e1;
        border-radius: 3px;
    }
</style>

<header id="header" class="d-flex align-items-center px-4" style="height: 70px;">
    <button class="btn d-lg-none p-0 me-3 border-0" onclick="toggleMobile()"><i class="bi bi-list fs-2"></i></button>
    <button class="btn d-none d-lg-block p-0 me-3 border-0 text-muted" onclick="toggleDesktop()"><i class="bi bi-grid-fill fs-4"></i></button>

    <div class="ms-auto d-flex align-items-center gap-3">
        <div class="dropdown">
            <button class="btn btn-notification position-relative d-flex align-items-center justify-content-center" id="notificationDropdown" data-bs-toggle="dropdown">
                <i class="ti ti-bell fs-4"></i>
                <span class="position-absolute badge rounded-pill bg-danger align-items-center justify-content-center" id="notification-badge" style="display: none;">
                    <span id="notification-count">0</span>
                </span>
            </button>
            <ul class="dropdown-menu dropdown-menu-end shadow border-0 mt-2 p-0" style="min-width: 320px; border-radius: 12px;">
                <li class="p-3 d-flex justify-content-between align-items-center">
                    <span class="fw-bold">Notifikasi</span>
                    <button class="btn btn-sm btn-link text-decoration-none p-0 small" id="mark-all-read">Tandai Semua Dibaca</button>
                </li>
                <hr class="dropdown-divider m-0">
                <div id="notification-list">
                    <div class="text-center py-3">
                        <p class="text-muted mb-0 small">Memuat...</p>
                    </div>
                </div>
                <hr class="dropdown-divider m-0">
                <li><a class="dropdown-item text-center fw-bold text-primary small py-2" href="#" id="view-all-link">Lihat Semua</a></li>
            </ul>
        </div>

        <div class="dropdown">
            <button class="btn d-flex align-items-center border-0 p-0" data-bs-toggle="dropdown">
                <img src="<?php echo e($displayPic); ?>" class="profile-img rounded-circle shadow-sm" width="35" height="35" style="object-fit: cover;" data-default="<?php echo e($defaultAvatar); ?>">
                <h6 class="ms-2 mb-0 text-dark fw-semibold d-none d-md-block"><?php echo e($avatarName); ?></h6>
                <i class="ti ti-chevron-down ms-1 text-muted"></i>
            </button>
            <ul class="dropdown-menu dropdown-menu-end shadow border-0 mt-2 p-2" style="min-width: 200px; border-radius: 12px;">
                <li class="px-2 py-1">
                    <div class="d-flex align-items-center">
                        <img src="<?php echo e($displayPic); ?>" class="profile-img rounded-circle me-2" width="40" height="40" style="object-fit: cover;">
                        <div>
                            <div class="fw-bold small"><?php echo e($avatarName); ?></div>
                            <small class="text-muted" style="font-size: 11px;"><?php echo e($role == 'admin' ? 'Administrator' : 'Siswa'); ?></small>
                        </div>
                    </div>
                </li>
                <li>
                    <hr class="dropdown-divider">
                </li>
                <li><a class="dropdown-item d-flex align-items-center" href="javascript:void(0)" onclick="openProfileModal()"><i class="ti ti-camera me-2"></i> Ganti Foto</a></li>
                <li>
                    <a class="dropdown-item d-flex align-items-center text-danger" href="javascript:void(0)" onclick="openLogoutModal()">
                        <i class="ti ti-logout me-2"></i> Logout
                    </a>
                </li>
            </ul>
        </div>
    </div>
</header>

<div class="modal fade" id="profileModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow" style="border-radius: 16px;">
            <div class="modal-header">
                <h5 class="fw-bold m-0">Ganti Foto Profil</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-4 text-center">
                <img id="modalProfilePic" src="<?php echo e($displayPic); ?>" class="rounded-circle shadow-sm mb-3" width="100" height="100" style="object-fit: cover;">
                <form id="profilePicForm" class="text-start">
                    <div class="mb-3">
                        <input type="file" class="form-control" id="profilePicInput" name="profile_pic" accept="image/*" required>
                    </div>
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary flex-fill" aria-label="Upload foto">Upload</button>
                        <button type="button" id="deletePicBtn" class="btn btn-outline-danger flex-fill" aria-label="Hapus foto" <?php if(!$profilePic): ?> disabled <?php endif; ?>>Hapus</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="confirmDeletePicModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm"> <div class="modal-content border-0 shadow-lg" style="border-radius: 20px;">
            <div class="modal-header border-0 pb-0">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            
            <div class="modal-body px-4 pt-0 pb-4 text-center">
                <div class="mx-auto mb-3 d-flex align-items-center justify-content-center bg-danger-subtle rounded-circle" style="width: 70px; height: 70px;">
                    <i class="ti ti-trash-x fs-1 text-danger"></i>
                </div>
                
                <h5 class="fw-bold mb-2">Hapus Foto Profil?</h5>
                <p class="text-muted small mb-0">Apakah Anda yakin? Tindakan ini akan menghapus foto Anda secara permanen.</p>
            </div>

            <div class="modal-footer border-0 p-4 pt-0 d-flex gap-2">
                <button type="button" class="btn btn-light fw-semibold flex-fill py-2" style="border-radius: 12px;" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-danger fw-bold flex-fill py-2" id="confirmDeleteBtn" style="border-radius: 12px;">Hapus</button>
            </div>
        </div>
    </div>
</div>

<form id="logout-form" action="<?php echo e(route('logout')); ?>" method="POST" class="d-none"><?php echo csrf_field(); ?></form>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const baseUrl = "<?php echo e($baseUrl); ?>";
        const csrf = document.querySelector('meta[name="csrf-token"]')?.content;

        const updateImages = (url) => document.querySelectorAll('.profile-img, #modalProfilePic').forEach(img => img.src = url);
        const setBadge = (count) => {
            const b = document.getElementById('notification-badge');
            b.style.display = count > 0 ? 'flex' : 'none';
            document.getElementById('notification-count').textContent = count > 99 ? '99+' : count;
        };

        const fetchNotif = () => {
            fetch(`${baseUrl}/notifications`, {
                    credentials: 'same-origin'
                })
                .then(r => r.json())
                .then(data => {
                    setBadge(data.unread_count);
                    const list = document.getElementById('notification-list');

                    list.innerHTML = data.notifications.length ? data.notifications.map(n => `
            <a class="dropdown-item d-flex align-items-start py-2 px-3 notification-item ${n.dibaca ? '' : 'bg-light'}" href="${n.url}" data-id="${n.id}" data-unread="${!n.dibaca}">
                <div class="d-flex align-items-start w-100">
                    <i class="ti ti-bell text-primary me-3 fs-5 mt-1"></i>
                    <div class="flex-grow-1 overflow-hidden">
                        <div class="d-flex justify-content-between align-items-center mb-1">
                            <div class="fw-semibold small text-truncate pe-2">${n.judul}</div>
                            <small class="text-muted flex-shrink-0" style="font-size: 10px;">${n.created_at}</small>
                        </div>
                        <div class="text-muted text-truncate" style="font-size: 0.75rem;">${n.pesan}</div>
                    </div>
                    ${!n.dibaca ? '<span class="unread-dot ms-2 mt-2"></span>' : ''}
                </div>
            </a>`).join('') : '<div class="text-center py-3 small text-muted">Tidak ada notifikasi</div>';

                    // Attach click handlers to notification items (mark as read + update badge)
                    list.querySelectorAll('.notification-item').forEach(function(item) {
                        item.addEventListener('click', function(ev) {
                            ev.preventDefault();
                            const id = this.dataset.id;
                            const targetUrl = this.getAttribute('href');
                            const isUnread = this.dataset.unread === 'true' || this.dataset.unread === '1' || this.classList.contains('bg-light');

                            if (isUnread) {
                                fetch(`${baseUrl}/notifications/${id}/mark-read`, {
                                    method: 'POST',
                                    headers: {
                                        'X-CSRF-TOKEN': csrf,
                                        'Content-Type': 'application/json'
                                    },
                                    credentials: 'same-origin'
                                }).then(r => r.json()).then(resp => {
                                    // decrement badge
                                    const countEl = document.getElementById('notification-count');
                                    let count = parseInt(countEl.textContent.replace('+', '')) || 0;
                                    count = Math.max(0, count - 1);
                                    setBadge(count);

                                    // remove unread visual indicator
                                    this.classList.remove('bg-light');
                                    const dot = this.querySelector('.unread-dot');
                                    if (dot) dot.remove();

                                    // navigate after marking
                                    if (targetUrl && targetUrl !== '#') window.location.href = targetUrl;
                                }).catch(err => {
                                    console.error('Mark single notification failed', err);
                                    if (targetUrl && targetUrl !== '#') window.location.href = targetUrl;
                                });
                            } else {
                                if (targetUrl && targetUrl !== '#') window.location.href = targetUrl;
                            }
                        });
                    });
                });
        };

        document.getElementById('mark-all-read').onclick = () => {
            fetch(`${baseUrl}/notifications/mark-read`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': csrf
                    },
                    credentials: 'same-origin'
                })
                .then(r => r.json())
                .then(() => {
                    setBadge(0);
                    document.querySelectorAll('#notification-list .bg-light').forEach(el => el.classList.remove('bg-light'));
                    document.querySelectorAll('.unread-dot').forEach(el => el.remove()); // Hapus semua titik biru
                })
                .catch(err => console.error('Mark all read failed', err));
        };

        document.getElementById('profilePicForm').onsubmit = function(e) {
            e.preventDefault();
            const btn = this.querySelector('button[type="submit"]');
            btn.disabled = true;
            btn.innerText = 'Uploading...';

            fetch(`${baseUrl}/profile/upload-picture`, {
                method: 'POST',
                body: new FormData(this),
                headers: {
                    'X-CSRF-TOKEN': csrf
                },
                credentials: 'same-origin'
            }).then(async (r) => {
                if (!r.ok) {
                    const txt = await r.text();
                    throw new Error('Upload failed: ' + r.status + ' ' + txt);
                }
                return r.json();
            }).then(res => {
                if (res.success) {
                    updateImages(`/storage/${res.path}?t=${Date.now()}`);
                    alert('Berhasil!');
                } else {
                    alert(res.message || 'Upload gagal');
                }
            }).catch(err => {
                console.error('Upload error', err);
                alert('Gagal mengunggah foto. Cek console untuk detail.');
            }).finally(() => {
                btn.disabled = false;
                btn.innerText = 'Upload';
            });
        };

        if (document.getElementById('deletePicBtn')) {
            document.getElementById('deletePicBtn').onclick = () => {
                new bootstrap.Modal('#confirmDeletePicModal').show();
            };
        }

        // Handle confirm delete button
        if (document.getElementById('confirmDeleteBtn')) {
            document.getElementById('confirmDeleteBtn').onclick = () => {
                const btn = document.getElementById('confirmDeleteBtn');
                btn.disabled = true;
                btn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Menghapus...';

                fetch(`${baseUrl}/profile/delete-picture`, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': csrf
                        },
                        credentials: 'same-origin'
                    })
                    .then(async (r) => {
                        if (!r.ok) throw new Error('Delete failed ' + r.status);
                        return r.json();
                    }).then(res => {
                        if (res.success) {
                            bootstrap.Modal.getInstance('#confirmDeletePicModal').hide();
                            updateImages(document.querySelector('.profile-img').dataset.default);
                            alert('Foto profil berhasil dihapus!');
                            // Disable delete button after deletion
                            document.getElementById('deletePicBtn').disabled = true;
                        }
                    }).catch(err => {
                        console.error('Delete profile pic error', err);
                        alert('Gagal menghapus foto. Cek console untuk detail.');
                    }).finally(() => {
                        btn.disabled = false;
                        btn.innerHTML = 'Hapus';
                    });
            };
        }

        fetchNotif();
        setInterval(fetchNotif, 60000);
    });

    function openProfileModal() {
        new bootstrap.Modal('#profileModal').show();
    }
</script><?php /**PATH C:\laragon\www\UKK_Aspira\resources\views/layout/header.blade.php ENDPATH**/ ?>