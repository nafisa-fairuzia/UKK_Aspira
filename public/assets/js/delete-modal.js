
(function() {
    'use strict';

    const DeleteModal = {
        init: function() {
            const deleteModalEl = document.getElementById('confirmDeleteModal');
            if (!deleteModalEl) return;

            this.modal = new bootstrap.Modal(deleteModalEl);
            this.deleteForm = null;
            this.deleteBtn = document.getElementById('confirmDeleteBtn');
            this.deleteMessage = document.getElementById('confirmDeleteMessage');

            this.setupDeleteButtonListener();
            this.setupConfirmDeleteListener();
            this.setupModalCloseListener();
        },
        setupDeleteButtonListener: function() {
            document.addEventListener('submit', (e) => {
                if (e.target.classList.contains('confirm-delete')) {
                    e.preventDefault();

                    this.deleteForm = e.target;

                    const customMessage = e.target.dataset.confirmMessage || 
                        'Apakah Anda yakin ingin menghapus data ini?';

                    if (this.deleteMessage) {
                        this.deleteMessage.textContent = customMessage;
                    }

                    this.resetDeleteButton();

                    this.modal.show();
                }
            });
        },

        setupConfirmDeleteListener: function() {
            if (!this.deleteBtn) return;

            this.deleteBtn.addEventListener('click', () => {
                if (this.deleteForm) {
                    this.showDeleteLoading();

                    setTimeout(() => {
                        this.deleteForm.submit();
                    }, 300);
                }
            });
        },

       
        setupModalCloseListener: function() {
            const deleteModalEl = document.getElementById('confirmDeleteModal');
            if (deleteModalEl) {
                deleteModalEl.addEventListener('hidden.bs.modal', () => {
                    this.resetDeleteButton();
                    this.deleteForm = null;
                });
            }
        },

        showDeleteLoading: function() {
            if (!this.deleteBtn) return;

            this.deleteBtn.disabled = true;

            this.deleteBtn.dataset.originalHTML = this.deleteBtn.innerHTML;

            this.deleteBtn.innerHTML = `
                <span class="spinner-border spinner-border-sm me-2"></span>
                Menghapus...
            `;

            const otherButtons = this.deleteBtn.parentElement.querySelectorAll('button:not(#confirmDeleteBtn)');
            otherButtons.forEach(btn => btn.disabled = true);
        },

        resetDeleteButton: function() {
            if (!this.deleteBtn) return;

            this.deleteBtn.disabled = false;
            this.deleteBtn.innerHTML = '<i class="ti ti-trash me-1"></i> Hapus';

            const otherButtons = this.deleteBtn.parentElement?.querySelectorAll('button');
            if (otherButtons) {
                otherButtons.forEach(btn => btn.disabled = false);
            }
        }
    };

    document.addEventListener('DOMContentLoaded', function() {
        DeleteModal.init();
    });

    window.DeleteModal = DeleteModal;
})();


window.showDeleteConfirmation = function(message = 'Apakah Anda yakin ingin menghapus data ini?') {
    const msgEl = document.getElementById('confirmDeleteMessage');
    if (msgEl) {
        msgEl.textContent = message;
    }
    const deleteModalEl = document.getElementById('confirmDeleteModal');
    if (deleteModalEl) {
        const modal = bootstrap.Modal.getInstance(deleteModalEl) || 
                      new bootstrap.Modal(deleteModalEl);
        modal.show();
    }
};
