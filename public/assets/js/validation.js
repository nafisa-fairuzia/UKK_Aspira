function validateAdminUsername() {
    const usernameInput = document.getElementById('admin_username');
    if (!usernameInput) return;

    usernameInput.addEventListener('blur', async function() {
        const username = this.value.trim();
        if (username === '') return;

        try {
            const response = await fetch('/admin/admins/check-username', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || ''
                },
                body: JSON.stringify({ username: username })
            });

            const data = await response.json();
            
            if (data.exists) {
                usernameInput.classList.add('border-warning');
                const errorElement = usernameInput.nextElementSibling;
                if (errorElement && errorElement.classList.contains('text-warning')) {
                    errorElement.innerHTML = '<i class="ti ti-alert-circle me-1"></i>Username sudah ada';
                    errorElement.style.display = 'block';
                }
            } else {
                usernameInput.classList.remove('border-warning');
                const errorElement = usernameInput.nextElementSibling;
                if (errorElement && errorElement.classList.contains('text-warning')) {
                    errorElement.style.display = 'none';
                }
            }
        } catch (error) {
            console.error('Validation error:', error);
        }
    });
}

function validateKategori() {
    const ketInput = document.getElementById('ket_kategori_input');
    if (!ketInput) return;

    ketInput.addEventListener('blur', async function() {
        const ket = this.value.trim();
        if (ket === '') return;

        try {
            const response = await fetch('/admin/kategori/check-duplicate', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || ''
                },
                body: JSON.stringify({ ket_kategori: ket })
            });

            const data = await response.json();
            
            if (data.exists) {
                this.classList.add('border-warning');
                const errorElement = this.parentElement.querySelector('.text-warning');
                if (errorElement) {
                    errorElement.innerHTML = '<i class="ti ti-alert-circle me-1"></i>Data sudah ada';
                    errorElement.style.display = 'block';
                }
            } else {
                this.classList.remove('border-warning');
                const errorElement = this.parentElement.querySelector('.text-warning');
                if (errorElement) {
                    errorElement.style.display = 'none';
                }
            }
        } catch (error) {
            console.error('Validation error:', error);
        }
    });
}

function validateSiswa() {
    const nisInput = document.getElementById('siswaNis');
    const usernameInput = document.getElementById('siswaUsername');

    if (nisInput) {
        nisInput.addEventListener('blur', validateSiswaNis);
    }

    if (usernameInput) {
        usernameInput.addEventListener('blur', validateSiswaUsername);
    }
}

async function validateSiswaNis() {
    const nis = this.value.trim();
    if (nis === '') return;

    try {
        const response = await fetch('/admin/siswa/check-nis', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || ''
            },
            body: JSON.stringify({ nis: nis })
        });

        const data = await response.json();
        
        if (data.exists) {
            this.classList.add('border-warning');
            const parentCol = this.closest('.col-md-6, .col-12');
            let errorElement = parentCol.querySelector('.text-warning');
            
            if (!errorElement) {
                errorElement = document.createElement('small');
                errorElement.className = 'text-warning d-block mt-2';
                this.parentElement.appendChild(errorElement);
            }
            
            errorElement.innerHTML = '<i class="ti ti-alert-circle me-1"></i>NIS sudah ada';
            errorElement.style.display = 'block';
        } else {
            this.classList.remove('border-warning');
            const parentCol = this.closest('.col-md-6, .col-12');
            const errorElement = parentCol.querySelector('.text-warning');
            if (errorElement) {
                errorElement.style.display = 'none';
            }
        }
    } catch (error) {
        console.error('Validation error:', error);
    }
}

async function validateSiswaUsername() {
    const username = this.value.trim();
    if (username === '') return;

    try {
        const response = await fetch('/admin/siswa/check-username', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || ''
            },
            body: JSON.stringify({ username: username })
        });

        const data = await response.json();
        
        if (data.exists) {
            this.classList.add('border-warning');
            const parentCol = this.closest('.col-md-6, .col-12');
            let errorElement = parentCol.querySelector('.text-warning');
            
            if (!errorElement) {
                errorElement = document.createElement('small');
                errorElement.className = 'text-warning d-block mt-2';
                this.parentElement.appendChild(errorElement);
            }
            
            errorElement.innerHTML = '<i class="ti ti-alert-circle me-1"></i>Username sudah ada';
            errorElement.style.display = 'block';
        } else {
            this.classList.remove('border-warning');
            const parentCol = this.closest('.col-md-6, .col-12');
            const errorElement = parentCol.querySelector('.text-warning');
            if (errorElement) {
                errorElement.style.display = 'none';
            }
        }
    } catch (error) {
        console.error('Validation error:', error);
    }
}

document.addEventListener('DOMContentLoaded', function() {
    validateAdminUsername();
    validateKategori();
    validateSiswa();
});
