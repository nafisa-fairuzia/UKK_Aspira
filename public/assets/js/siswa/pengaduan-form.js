const FORM_VALIDATION_CONFIG = {
  description: { maxLength: 255, fieldId: 'ket', counterId: 'charCount' },
  image: { supportedFormats: ['image/jpeg', 'image/jpg', 'image/png', 'image/gif'], fieldId: 'gambar' }
};

const IMAGE_UPLOAD_CONFIG = {
  dropAreaId: 'drop-area',
  fileInputId: 'gambar',
  uploadUIId: 'upload-ui',
  previewUIId: 'preview-ui',
  previewImgId: 'previewImg',
  clearBtnId: 'clearImage'
};

const CSS_CLASSES = { hidden: 'd-none', dragActive: 'bg-primary-soft', borderActive: '#0ea5e9' };

document.addEventListener('DOMContentLoaded', function() {
  initializeDescriptionCounter();
  initializeImageUpload();
  initializeFormValidation();
});

function initializeDescriptionCounter() {
  const ketInput = document.getElementById(FORM_VALIDATION_CONFIG.description.fieldId);
  const charCountSpan = document.getElementById(FORM_VALIDATION_CONFIG.description.counterId);
  if (!ketInput || !charCountSpan) return;
  ketInput.addEventListener('input', function() {
    if (this.value.length > FORM_VALIDATION_CONFIG.description.maxLength) {
      this.value = this.value.substring(0, FORM_VALIDATION_CONFIG.description.maxLength);
    }
    charCountSpan.textContent = `${this.value.length} / ${FORM_VALIDATION_CONFIG.description.maxLength}`;
  });
  charCountSpan.textContent = `${ketInput.value.length} / ${FORM_VALIDATION_CONFIG.description.maxLength}`;
}

function initializeImageUpload() {
  const gambarInput = document.getElementById(IMAGE_UPLOAD_CONFIG.fileInputId);
  const dropArea = document.getElementById(IMAGE_UPLOAD_CONFIG.dropAreaId);
  if (!gambarInput || !dropArea) return;
  setupDragDropListeners(gambarInput, dropArea);
  gambarInput.addEventListener('change', function() { handleImageSelect(this.files[0]); });
  setupClearImageButton();
  if (hasExistingImage()) showImagePreview(getExistingImageSrc());
}

function setupDragDropListeners(fileInput, dropArea) {
  ['dragover', 'dragleave', 'drop'].forEach(eventName => { dropArea.addEventListener(eventName, (e) => e.preventDefault()); });
  dropArea.addEventListener('dragover', function() { this.classList.add(CSS_CLASSES.dragActive); this.style.borderColor = CSS_CLASSES.borderActive; });
  dropArea.addEventListener('dragleave', function() { this.classList.remove(CSS_CLASSES.dragActive); this.style.borderColor = 'transparent'; });
  dropArea.addEventListener('drop', function(e) {
    this.classList.remove(CSS_CLASSES.dragActive);
    const files = e.dataTransfer.files;
    if (files.length > 0) { fileInput.files = files; handleImageSelect(files[0]); }
  });
}

function handleImageSelect(file) {
  if (!file) return;
  if (!FORM_VALIDATION_CONFIG.image.supportedFormats.includes(file.type)) { alert('Format file tidak didukung. Gunakan JPG, PNG, atau GIF.'); return; }
  const reader = new FileReader();
  reader.onload = (event) => { showImagePreview(event.target.result); };
  reader.readAsDataURL(file);
}

function showImagePreview(imageSrc) {
  const previewImg = document.getElementById(IMAGE_UPLOAD_CONFIG.previewImgId);
  const uploadUI = document.getElementById(IMAGE_UPLOAD_CONFIG.uploadUIId);
  const previewUI = document.getElementById(IMAGE_UPLOAD_CONFIG.previewUIId);
  const clearBtn = document.getElementById(IMAGE_UPLOAD_CONFIG.clearBtnId);
  if (previewImg) previewImg.src = imageSrc;
  if (uploadUI) uploadUI.classList.add(CSS_CLASSES.hidden);
  if (previewUI) previewUI.classList.remove(CSS_CLASSES.hidden);
  if (clearBtn) clearBtn.classList.remove(CSS_CLASSES.hidden);
}

function setupClearImageButton() {
  const clearBtn = document.getElementById(IMAGE_UPLOAD_CONFIG.clearBtnId);
  const fileInput = document.getElementById(IMAGE_UPLOAD_CONFIG.fileInputId);
  const uploadUI = document.getElementById(IMAGE_UPLOAD_CONFIG.uploadUIId);
  const previewUI = document.getElementById(IMAGE_UPLOAD_CONFIG.previewUIId);
  if (!clearBtn) return;
  clearBtn.addEventListener('click', function(e) {
    e.preventDefault();
    fileInput.value = '';
    if (uploadUI) uploadUI.classList.remove(CSS_CLASSES.hidden);
    if (previewUI) previewUI.classList.add(CSS_CLASSES.hidden);
    if (clearBtn) clearBtn.classList.add(CSS_CLASSES.hidden);
  });
}

function hasExistingImage() { return window.appData && window.appData.hasExistingImage; }
function getExistingImageSrc() { return window.appData ? window.appData.existingImageSrc : ''; }

function initializeFormValidation() {
  const form = document.querySelector('form');
  if (!form) return;
  form.addEventListener('submit', function(e) {
    if (!validateDescription()) { e.preventDefault(); alert(`Deskripsi tidak boleh lebih dari ${FORM_VALIDATION_CONFIG.description.maxLength} karakter!`); return false; }
    return true;
  });
}

function validateDescription() {
  const ketInput = document.getElementById(FORM_VALIDATION_CONFIG.description.fieldId);
  if (!ketInput) return true;
  const trimmedValue = ketInput.value.trim();
  return trimmedValue.length <= FORM_VALIDATION_CONFIG.description.maxLength;
}

if (!window.appData) { window.appData = { hasExistingImage: false, existingImageSrc: '' }; }
