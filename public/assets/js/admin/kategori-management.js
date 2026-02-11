const KATEGORI_FORM_MODES = {
  add: { title: 'Tambah Kategori', submitText: 'Simpan', action: '/admin/kategori' },
  edit: { title: 'Edit Kategori', submitText: 'Update' }
};

const KATEGORI_ELEMENT_IDS = {
  modal: 'kategoriModal',
  form: 'kategoriModalForm',
  title: 'kategoriModalTitle',
  submit: 'kategoriModalSubmit',
  inputKategori: 'ket_kategori_input'
};

function openKategoriModal(mode, payload = null) {
  const form = document.getElementById(KATEGORI_ELEMENT_IDS.form);
  const title = document.getElementById(KATEGORI_ELEMENT_IDS.title);
  const submitBtn = document.getElementById(KATEGORI_ELEMENT_IDS.submit);

  const prevMethod = form.querySelector('input[name="_method"]');
  if (prevMethod) prevMethod.remove();

  if (mode === 'add') {
    configureKategoriAddMode(form, title, submitBtn);
  } else if (mode === 'edit' && payload) {
    configureKategoriEditMode(form, title, submitBtn, payload);
  }

  const bootstrapModal = new bootstrap.Modal(document.getElementById(KATEGORI_ELEMENT_IDS.modal));
  bootstrapModal.show();
}

function configureKategoriAddMode(form, title, submitBtn) {
  title.textContent = KATEGORI_FORM_MODES.add.title;
  form.action = window.routeAdminKategoriStore || KATEGORI_FORM_MODES.add.action;
  form.method = 'POST';
  form.reset();
  submitBtn.textContent = KATEGORI_FORM_MODES.add.submitText;
}

function configureKategoriEditMode(form, title, submitBtn, payload) {
  title.textContent = KATEGORI_FORM_MODES.edit.title;
  form.action = `/admin/kategori/${payload.id}`;
  const methodInput = document.createElement('input');
  methodInput.type = 'hidden';
  methodInput.name = '_method';
  methodInput.value = 'PUT';
  form.appendChild(methodInput);
  document.getElementById(KATEGORI_ELEMENT_IDS.inputKategori).value = payload.ket || '';
  submitBtn.textContent = KATEGORI_FORM_MODES.edit.submitText;
}

function editKategori(kategoriId, kategoriName) {
  const payload = { id: kategoriId, ket: kategoriName };
  openKategoriModal('edit', payload);
}

window.openKategoriModal = openKategoriModal;
window.editKategori = editKategori;
