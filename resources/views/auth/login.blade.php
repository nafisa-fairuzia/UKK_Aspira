<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/dist/tabler-icons.min.css">
    <link rel="icon" type="image/png" href="{{ asset('assets/img/logo_aspira1.png') }}?v={{ time() }}" sizes="32x32">
    <link rel="icon" type="image/png" href="{{ asset('assets/img/logo_aspira1.png') }}?v={{ time() }}" sizes="16x16">
    <link rel="shortcut icon" href="{{ asset('assets/img/logo_aspira1.png') }}?v={{ time() }}">
    <link rel="stylesheet" href="{{ asset('assets/css/global.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/auth/login.css') }}">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

</head>

<body>

    <div class="main-card">
        <div class="row g-0">
            <div class="col-lg-7 d-flex visual-section italic">
                <h1 data-aos="fade-right">Fasilitas Nyaman,<br> Belajar Jadi Tenang</h1>
                <div class="illustration-wrapper text-center" data-aos="fade-up">
                    <img src="{{ asset('assets/img/aspira2.png') }}" alt="Digital Illustration">
                </div>
            </div>

            <div class="col-lg-5 col-md-12 ">
                <div class="form-section mt-5" id="loginContainer">
                    <h2 class="text-center mb-5">Masuk ke ASPIRA</h2>

                    <form method="POST" action="{{ route('login') }}" autocomplete="off">
                        @csrf

                        <div class="form-group-wrapper active">
                            <div class="mb-3">
                                <label class="form-label">Username</label>
                                <div class="input-group-custom">
                                    <i class="ti ti-user icon-left"></i>
                                    <input type="text" name="username" id="loginUsername" class="form-control" placeholder="Masukkan Username" required>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Password</label>
                                <div class="input-group-custom">
                                    <i class="ti ti-lock icon-left"></i>
                                    <input type="password" name="password" id="loginPassword" class="form-control" placeholder="••••••••" required>
                                    <i class="ti ti-eye toggle-password" onclick="togglePass('loginPassword', this)"></i>
                                </div>
                            </div>
                        </div>

                        <div class="d-grid mt-5">
                            <button type="submit" class="btn-primary-custom">
                                <i class="ti ti-login me-1"></i> Masuk Sekarang
                            </button>

                            <div class="text-center mt-3">
                                <a href="{{ url('/') }}" class="text-decoration-none text-muted small hover-sky">
                                    <i class="ti ti-arrow-back-up me-1"></i> Kembali ke Beranda
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="{{ asset('assets/js/login.js') }}"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init({
            duration: 500,
        });
    </script>
</body>

</html>