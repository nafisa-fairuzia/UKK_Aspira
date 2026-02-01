<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Log In - Aspira Digital</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/dist/tabler-icons.min.css">

    <link rel="stylesheet" href="{{ asset('assets/css/auth/login.css') }}">


</head>

<body>

    <div class="main-card">
        <div class="row g-0">
            <div class="col-lg-7 d-flex visual-section">
                <h1>Fasilitas Nyaman,<br> Belajar Jadi Tenang</h1>
                <div class="illustration-wrapper text-center">
                    <img src="{{ asset('assets/img/aspira2.png') }}" alt="Digital Illustration">
                </div>
            </div>

            <div class="col-lg-5 col-md-12">
                <div class="form-section" id="loginContainer">
                    <h2 class="text-center mb-5">Log In</h2>

                    <div class="login-tabs">
                        <button type="button" class="tab-btn active" onclick="switchLogin('admin')">Admin</button>
                        <button type="button" class="tab-btn" onclick="switchLogin('siswa')">Siswa</button>
                    </div>

                    <form method="POST" action="{{ route('login') }}" autocomplete="off">
                        @csrf
                        <input type="hidden" name="role" id="roleInput" value="admin">

                        <div id="form-admin" class="form-group-wrapper active">
                            <div class="mb-3">
                                <label class="form-label">Username Admin</label>
                                <div class="input-group-custom">
                                    <i class="ti ti-user icon-left"></i>
                                    <input type="text" name="username" class="form-control" placeholder="Masukkan Username" required>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Password</label>
                                <div class="input-group-custom">
                                    <i class="ti ti-lock icon-left"></i>
                                    <input type="password" name="password" id="passAdmin" class="form-control" placeholder="••••••••" required>
                                    <i class="ti ti-eye toggle-password" onclick="togglePass('passAdmin', this)"></i>
                                </div>
                            </div>
                        </div>

                        <div id="form-siswa" class="form-group-wrapper">
                            <div class="mb-3">
                                <label class="form-label">NIS (Nomor Induk Siswa)</label>
                                <div class="input-group-custom">
                                    <i class="ti ti-id-badge icon-left"></i>
                                    <input type="text" name="nis" class="form-control" placeholder="Masukkan NIS Anda" required maxlength="10" inputmode="numeric" oninput="this.value=this.value.replace(/\D/g,'').slice(0,10)">
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Kelas</label>
                                <div class="input-group-custom">
                                    <i class="ti ti-school icon-left"></i>
                                    <input type="text" id="kelasInput" class="form-control" placeholder="Cari Kelas (Contoh: RPL)" required list="kelasOptions" onchange="syncLoginKelasId()">
                                    <input type="hidden" id="kelasIdInput" name="kelas_id">
                                    <datalist id="kelasOptions"></datalist>
                                </div>
                            </div>
                        </div>

                        <div class="d-grid mt-4">
                            <button type="submit" class="btn-primary-custom">
                                <i class="ti ti-login me-1"></i> Masuk Sekarang
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="{{ asset('assets/js/login.js') }}"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const kelasInput = document.getElementById('kelasInput');
            const datalist = document.getElementById('kelasOptions');
            let allKelas = [];

            // Load all kelas on page load
            fetch('{{ route("api.kelas.search") }}')
                .then(r => r.json())
                .then(data => {
                    allKelas = data.results || [];
                    populateDatalist('');
                })
                .catch(err => console.error('Failed to load kelas:', err));

            // Filter datalist as user types
            kelasInput.addEventListener('input', function() {
                populateDatalist(this.value);
            });

            function populateDatalist(filter) {
                datalist.innerHTML = '';
                const filtered = allKelas.filter(k => k.text.toLowerCase().includes(filter.toLowerCase()));
                filtered.forEach(k => {
                    const option = document.createElement('option');
                    option.value = k.text;
                    option.dataset.id = k.id;
                    datalist.appendChild(option);
                });
            }

            // Sync selected kelas text with hidden kelas_id field
            window.syncLoginKelasId = function() {
                const input = document.getElementById('kelasInput');
                const hidden = document.getElementById('kelasIdInput');
                const selected = Array.from(datalist.options).find(opt => opt.value === input.value);

                if (selected && selected.dataset.id) {
                    hidden.value = selected.dataset.id;
                } else {
                    hidden.value = '';
                }
            };
        });
    </script>

</body>

</html>