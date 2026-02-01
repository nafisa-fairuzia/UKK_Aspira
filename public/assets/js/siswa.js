    const fileInput = document.getElementById('gambar');
    const uploadUi = document.getElementById('upload-ui');
    const previewUi = document.getElementById('preview-ui');
    const previewImg = document.getElementById('previewImg');
    const clearBtn = document.getElementById('clearImage');

    fileInput.addEventListener('change', function() {
        const file = this.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                previewImg.src = e.target.result;
                uploadUi.classList.add('d-none');
                previewUi.classList.remove('d-none');
                clearBtn.classList.remove('d-none');
            }
            reader.readAsDataURL(file);
        }
    });

    clearBtn.addEventListener('click', function() {
        fileInput.value = '';
        uploadUi.classList.remove('d-none');
        previewUi.classList.add('d-none');
        this.classList.add('d-none');
    });

    const textarea = document.getElementById('ket');
    const charCount = document.getElementById('charCount');
    textarea.addEventListener('input', function() {
        charCount.textContent = `${this.value.length} / 255`;
        charCount.className = this.value.length > 240 ? 'badge rounded-pill bg-danger px-3 fw-normal' : 'badge rounded-pill bg-primary px-3 fw-normal';
    });
