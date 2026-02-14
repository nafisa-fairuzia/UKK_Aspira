(function() {
  const formErrorCounts = new WeakMap(); 

  function getCsrfToken() {
    return document.querySelector('meta[name="csrf-token"]')?.content || '';
  }

  function setFormHasError(form, delta) {
    const prev = formErrorCounts.get(form) || 0;
    const next = Math.max(0, prev + delta);
    formErrorCounts.set(form, next);

    const submitButtons = form.querySelectorAll('button[type="submit"], input[type="submit"]');
    const disabled = next > 0;
    submitButtons.forEach(btn => {
      btn.disabled = disabled;
      if (disabled) {
        btn.classList.add('disabled');
        btn.setAttribute('aria-disabled', 'true');
      } else {
        btn.classList.remove('disabled');
        btn.removeAttribute('aria-disabled');
      }
    });
  }

  function ensureErrorEl(input) {
    let el = input.parentElement.querySelector('.text-warning');
    if (!el) {
      el = document.createElement('small');
      el.className = 'text-warning d-block mt-2';
      input.parentElement.appendChild(el);
    }
    return el;
  }

  function clearFieldError(input) {
    input.classList.remove('border-warning');
    const el = input.parentElement.querySelector('.text-warning');
    if (el) el.style.display = 'none';
  }

  function applyFieldError(input, message) {
    if (!input) return;
    input.classList.add('border-warning');
    const el = ensureErrorEl(input);
    el.innerHTML = '<i class="ti ti-alert-circle me-1"></i>' + message;
    el.style.display = 'block';
  }

 
  function registerUniqueValidator(options) {
    const input = document.getElementById(options.id);
    if (!input) return;

    const form = input.closest('form') || document.body;
    let lastStateIsError = false;
    let lastCheckedValue = null;
    let pendingRequestId = 0;

    function setErrorState(isError, message) {
      if (isError === lastStateIsError) return;
      if (isError) {
        applyFieldError(input, message);
        setFormHasError(form, 1);
      } else {
        clearFieldError(input);
        setFormHasError(form, -1);
      }
      lastStateIsError = isError;
    }

    async function doCheck(value) {
      const v = value.trim();
      lastCheckedValue = v;
      if (v === '') {
        if (lastStateIsError) setErrorState(false);
        return;
      }

      if (input.dataset.initialValue !== undefined && v === input.dataset.initialValue) {
        if (lastStateIsError) setErrorState(false);
        return;
      }

      const requestId = ++pendingRequestId;

      try {
        const body = {};
        body[options.payloadKey] = v;

        const resp = await fetch(options.url, {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': getCsrfToken()
          },
          body: JSON.stringify(body)
        });

        const data = await resp.json();

        if (requestId !== pendingRequestId || input.value.trim() !== v) {
          return;
        }

        if (data && data.exists) {
          setErrorState(true, options.message || 'Data sudah ada');
        } else {
          setErrorState(false);
        }
      } catch (e) {
        console.error('Validation request failed', e);
      }
    }

    let timer = null;
    const debounceMs = options.debounceMs || 400;
    function debouncedCheck() {
      clearTimeout(timer);
      timer = setTimeout(() => doCheck(input.value), debounceMs);
      if (lastStateIsError) {
        clearFieldError(input);
      }
    }

    input.addEventListener('input', debouncedCheck);
    input.addEventListener('blur', () => doCheck(input.value));

    const modal = input.closest('.modal');
    if (modal) {
      modal.addEventListener('shown.bs.modal', () => {
        input.dataset.initialValue = (input.value || '').trim();

        if (lastStateIsError) {
          setFormHasError(form, -1);
          lastStateIsError = false;
        }
        clearFieldError(input);

        if (input.value && input.value.trim() !== '') {
          if (input.dataset.initialValue && input.value.trim() === input.dataset.initialValue) {
            setErrorState(false);
          } else {
            doCheck(input.value);
          }
        }
      });

      modal.addEventListener('hidden.bs.modal', () => {
        if (lastStateIsError) {
          setFormHasError(form, -1);
          lastStateIsError = false;
        }
        clearFieldError(input);
        if (input.dataset.initialValue !== undefined) {
          input.value = input.dataset.initialValue;
          delete input.dataset.initialValue;
        }
      });

      modal.querySelectorAll('[data-bs-dismiss="modal"], .btn-cancel').forEach(btn => {
        btn.addEventListener('click', () => {
          if (lastStateIsError) {
            setFormHasError(form, -1);
            lastStateIsError = false;
          }
          clearFieldError(input);
          if (input.dataset.initialValue !== undefined) {
            input.value = input.dataset.initialValue;
          }
        });
      });
    }

    if (input.value && input.value.trim() !== '') {
      doCheck(input.value);
    }
  }

  document.addEventListener('DOMContentLoaded', function() {
    registerUniqueValidator({
      id: 'ket_kategori_input',
      url: '/admin/kategori/check-duplicate',
      payloadKey: 'ket_kategori',
      message: 'Kategori sudah ada',
      debounceMs: 400
    });

    registerUniqueValidator({
      id: 'admin_username',
      url: '/admin/admins/check-username',
      payloadKey: 'username',
      message: 'Username sudah ada',
      debounceMs: 400
    });

    registerUniqueValidator({
      id: 'siswaNis',
      url: '/admin/siswa/check-nis',
      payloadKey: 'nis',
      message: 'NIS sudah ada',
      debounceMs: 400
    });

    registerUniqueValidator({
      id: 'siswaUsername',
      url: '/admin/siswa/check-username',
      payloadKey: 'username',
      message: 'Username sudah ada',
      debounceMs: 400
    });
  });
})();
