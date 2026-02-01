function switchLogin(role) {
    const btns = document.querySelectorAll('.tab-btn');
    const fAdmin = document.getElementById('form-admin');
    const fSiswa = document.getElementById('form-siswa');
    const roleInput = document.getElementById('roleInput');

    const adminInputs = fAdmin.querySelectorAll('input');
    const siswaInputs = fSiswa.querySelectorAll('input, select');

    btns.forEach(b => b.classList.remove('active'));

    if (role === 'admin') {
        btns[0].classList.add('active');
        fAdmin.classList.add('active');
        fSiswa.classList.remove('active');
        roleInput.value = 'admin';

        adminInputs.forEach(i => i.disabled = false);
        siswaInputs.forEach(i => i.disabled = true);
        
    } else {
        btns[1].classList.add('active');
        fSiswa.classList.add('active');
        fAdmin.classList.remove('active');
        roleInput.value = 'siswa';

        adminInputs.forEach(i => i.disabled = true);
        siswaInputs.forEach(i => i.disabled = false);

     
    }
}

function togglePass(fieldId, icon) {
    const field = document.getElementById(fieldId);
    if (field.type === 'password') {
        field.type = 'text';
        icon.classList.remove('ti-eye');
        icon.classList.add('ti-eye-off');
    } else {
        field.type = 'password';
        icon.classList.remove('ti-eye-off');
        icon.classList.add('ti-eye');
    }
}

document.addEventListener('DOMContentLoaded', function() {
    const roleInput = document.getElementById('roleInput');
    const initialRole = roleInput ? roleInput.value : 'admin';
    try {
        switchLogin(initialRole);
    } catch (err) {
        console.warn('switchLogin not available on load:', err);
    }

    const form = document.querySelector('form');
    const submitBtn = document.querySelector('.btn-primary-custom');
    
    if (form && submitBtn) {
        submitBtn.addEventListener('click', function(e) {
            if (!form.checkValidity()) {
                e.preventDefault();
                e.stopPropagation();
            }
        });
    }
});