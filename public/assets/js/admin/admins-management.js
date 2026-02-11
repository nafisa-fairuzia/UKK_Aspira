const ADMIN_FORM_CONFIG = {
  add: {
    title: 'Tambah Admin',
    submitText: 'Simpan',
    action: function() {
      return window.routeAdminAdminsStore || "{{ route('admin.admins.store') }}";
    }
  },
  edit: {
    title: 'Edit Admin',
    submitText: 'Update'
  }
};

function openAdminModal(mode, payload = null) {
  const modal = document.getElementById('adminModal');
  const title = document.getElementById('adminModalTitle');
  const form = document.getElementById('adminModalForm');
  const submitBtn = document.getElementById('adminModalSubmit');

  const prevMethod = form.querySelector('input[name="_method"]');
  if (prevMethod) prevMethod.remove();

  if (mode === 'add') {
    configureAddAdminForm(form, title, submitBtn);
  } else if (mode === 'edit' && payload) {
    configureEditAdminForm(form, title, submitBtn, payload);
  }

  const bootstrapModal = new bootstrap.Modal(modal);
  bootstrapModal.show();
}

function configureAddAdminForm(form, title, submitBtn) {
  title.textContent = ADMIN_FORM_CONFIG.add.title;
  form.action = window.routeAdminAdminsStore || '/admin/admins';
  form.method = 'POST';
  form.reset();
  submitBtn.textContent = ADMIN_FORM_CONFIG.add.submitText;
}

function configureEditAdminForm(form, title, submitBtn, payload) {
  title.textContent = ADMIN_FORM_CONFIG.edit.title;
  form.action = `/admin/admins/${payload.id}`;

  const methodInput = document.createElement('input');
  methodInput.type = 'hidden';
  methodInput.name = '_method';
  methodInput.value = 'PUT';
  form.appendChild(methodInput);

  document.getElementById('admin_nama').value = payload.nama || '';
  document.getElementById('admin_username').value = payload.username || '';
  document.getElementById('admin_password').value = '';

  submitBtn.textContent = ADMIN_FORM_CONFIG.edit.submitText;
}

function openEditModal(adminId) {
  fetch(`/admin/admins/${adminId}/edit`)
    .then(response => response.json())
    .then(data => {
      openAdminModal('edit', data);
    })
    .catch(error => {
      console.error('Error loading admin data:', error);
      alert('Gagal memuat data admin. Silakan coba lagi.');
    });
}

window.openAdminModal = openAdminModal;
window.openEditModal = openEditModal;
