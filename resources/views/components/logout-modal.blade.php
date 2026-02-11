<div class="modal fade" id="logoutModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 20px;">
            <div class="modal-body p-4 text-center">
                <div class="bg-warning bg-opacity-10 text-warning rounded-circle d-flex align-items-center justify-content-center mx-auto mb-3" style="width: 60px; height: 60px;">
                    <i class="ti ti-alert-triangle fs-1"></i>
                </div>
                <h5 class="fw-bold">Logout?</h5>
                <p class="text-muted small">Anda akan keluar dari sistem. Pastikan semua data telah tersimpan.</p>
                <div class="d-flex gap-2 mt-4">
                    <button type="button" class="btn btn-light w-100 fw-bold rounded-3" data-bs-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-warning w-100 fw-bold rounded-3" onclick="performLogout()">Ya, Logout</button>
                </div>
            </div>
        </div>
    </div>
</div>

<form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
    @csrf
</form>