$(document).ready(function() {
    const buttons = document.querySelectorAll('.btn-open-modal');
    buttons.forEach(btn => btn.addEventListener('click', function() {
        const id = this.dataset.id;
        const form = document.getElementById('feedbackForm');
        if (form) form.action = `/admin/pengaduan/${id}`;
        const modalEl = document.getElementById('feedbackModal');
        if (modalEl) {
            const myModal = new bootstrap.Modal(modalEl);
            myModal.show();
        }
    }));
});
