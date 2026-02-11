const MESSAGES = { cancel: { title: 'Batalkan?', description: 'Pengaduan ini akan dihentikan dan tidak akan diproses lebih lanjut.' } };
const ELEMENT_IDS = { cancelModal: 'cancelModal' };

function confirmCancel() {
  const cancelModal = document.getElementById(ELEMENT_IDS.cancelModal);
  if (!cancelModal) { console.error('Cancel modal element not found'); return; }
  const modal = new bootstrap.Modal(cancelModal);
  modal.show();
}

window.confirmCancel = confirmCancel;
