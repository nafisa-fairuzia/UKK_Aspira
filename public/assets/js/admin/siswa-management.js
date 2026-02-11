let allKelas = [];

const KELAS_API_URL = '/api/kelas/search';

const FORM_CONFIG = {
  addMode: { title: 'Tambah Siswa', buttonText: 'Simpan Data Siswa', method: 'POST' },
  editMode: { title: 'Edit Data Siswa', buttonText: 'Update Data Siswa', method: 'PUT' }
};

function openSiswaModal(mode, payload = null) {
  const elementIds = { title: 'siswaModalTitle', form: 'siswaModalForm', submit: 'siswaModalSubmit', modal: 'siswaModal' };

  const title = document.getElementById(elementIds.title);
  const form = document.getElementById(elementIds.form);
  const submit = document.getElementById(elementIds.submit);

  const prevMethod = form.querySelector('input[name="_method"]');
  if (prevMethod) prevMethod.remove();

  if (mode === 'add') {
    configureAddMode(form, title, submit);
  } else if (mode === 'edit' && payload) {
    configureEditMode(form, title, submit, payload);
  }

  const modal = new bootstrap.Modal(document.getElementById(elementIds.modal));
  modal.show();
}

function configureAddMode(form, title, submit) {
  title.textContent = FORM_CONFIG.addMode.title;
  form.action = window.routeAdminSiswaStore;
  form.method = 'POST';
  form.reset();
  document.getElementById('siswaUsername').value = '';
  document.getElementById('siswaPassword').value = '';
  submit.textContent = FORM_CONFIG.addMode.buttonText;
}

function configureEditMode(form, title, submit, payload) {
  title.textContent = FORM_CONFIG.editMode.title;
  form.action = `/admin/siswa/${payload.nis}`;
  const methodInput = document.createElement('input');
  methodInput.type = 'hidden';
  methodInput.name = '_method';
  methodInput.value = 'PUT';
  form.appendChild(methodInput);
  document.getElementById('siswaNis').value = payload.nis || '';
  document.getElementById('siswaNama').value = payload.nama || '';
  document.getElementById('siswaKelasInput').value = payload.kelas_name || '';
  document.getElementById('siswaKelasId').value = payload.id_kelas || '';
  document.getElementById('siswaUsername').value = payload.username || '';
  document.getElementById('siswaPassword').value = '';
  submit.textContent = FORM_CONFIG.editMode.buttonText;
}

function loadKelas() {
  fetch(window.apiKelasSearch || KELAS_API_URL)
    .then(response => response.json())
    .then(data => {
      allKelas = data.results || [];
      populateDatalist('siswaKelasOptions', '');
    })
    .catch(error => {
      console.error('Gagal memuat data kelas:', error);
    });
}

function populateDatalist(datalistId, filter) {
  const datalist = document.getElementById(datalistId);
  if (!datalist) return;
  datalist.innerHTML = '';
  const filteredKelas = allKelas.filter(kelas => kelas.text.toLowerCase().includes(filter.toLowerCase()));
  filteredKelas.forEach(kelas => {
    const option = document.createElement('option');
    option.value = kelas.text;
    option.dataset.id = kelas.id;
    datalist.appendChild(option);
  });
}

function syncKelasId(inputId, hiddenId) {
  const inputElement = document.getElementById(inputId);
  const hiddenElement = document.getElementById(hiddenId);
  if (!inputElement || !hiddenElement) return;
  const datalistId = inputId === 'siswaKelasInput' ? 'siswaKelasOptions' : null;
  const datalist = datalistId ? document.getElementById(datalistId) : null;
  if (!datalist) return;
  const selectedOption = Array.from(datalist.options).find(option => option.value === inputElement.value);
  if (selectedOption && selectedOption.dataset.id) {
    hiddenElement.value = selectedOption.dataset.id;
  } else {
    hiddenElement.value = '';
  }
}

document.addEventListener('DOMContentLoaded', function() {
  loadKelas();
  const siswaKelasInput = document.getElementById('siswaKelasInput');
  if (siswaKelasInput) {
    siswaKelasInput.addEventListener('input', function() {
      populateDatalist('siswaKelasOptions', this.value);
      syncKelasId('siswaKelasInput', 'siswaKelasId');
    });
  }
  document.addEventListener('click', function(event) {
    const editButton = event.target.closest('.btn-edit-siswa');
    if (editButton) {
      const siswaData = {
        nis: editButton.dataset.nis,
        nama: editButton.dataset.nama,
        id_kelas: editButton.dataset.kelasId,
        kelas_name: editButton.dataset.namaKelas || '',
        username: editButton.dataset.username || ''
      };
      openSiswaModal('edit', siswaData);
    }
  });
});

window.openSiswaModal = openSiswaModal;
window.syncKelasId = syncKelasId;
