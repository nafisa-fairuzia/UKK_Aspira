<!DOCTYPE html>
<html lang="id" class="scroll-smooth">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ASPIRA</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link rel="icon" type="image/png" href="{{ asset('assets/img/logo_aspira1.png') }}?v={{ time() }}" sizes="32x32">
    <link rel="icon" type="image/png" href="{{ asset('assets/img/logo_aspira1.png') }}?v={{ time() }}" sizes="16x16">
    <link rel="shortcut icon" href="{{ asset('assets/img/logo_aspira1.png') }}?v={{ time() }}">

    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&display=swap');

        html {
            scroll-padding-top: 80px;
        }

        /* FAQ styles */
        .faq-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 1.25rem;
        }

        .faq-card {
            background: linear-gradient(180deg, rgba(255, 255, 255, 0.9), rgba(250, 250, 255, 0.7));
            border: 1px solid rgba(14, 165, 233, 0.08);
            padding: 1.25rem;
            border-radius: 14px;
            box-shadow: 0 6px 18px rgba(2, 6, 23, 0.04);
            transition: transform .28s ease, box-shadow .28s ease;
            cursor: pointer;
            overflow: hidden;
            position: relative;
        }

        .faq-card:hover {
            transform: translateY(-6px);
            box-shadow: 0 12px 30px rgba(2, 6, 23, 0.08);
        }

        .faq-q {
            font-weight: 700;
            color: #0f172a;
            display: flex;
            justify-content: space-between;
            gap: 1rem;
            align-items: center;
        }

        .faq-a {
            margin-top: 0;
            color: #475569;
            line-height: 1.55;
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.3s ease, margin-top 0.3s ease, opacity 0.3s ease;
            opacity: 0;
            visibility: hidden;
        }

        .faq-open .faq-a {
            max-height: 500px;
            margin-top: 0.75rem;
            opacity: 1;
            visibility: visible;
        }

        .faq-bullet {
            width: 44px;
            height: 44px;
            border-radius: 10px;
            display: inline-grid;
            place-items: center;
            background: linear-gradient(135deg, #e0f2fe, #bae6fd);
            color: #0369a1;
            font-weight: 800;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            overflow-x: hidden;
        }

        .text-primary {
            color: #0ea5e9;
        }

        .bg-primary {
            background-color: #0ea5e9;
        }

        .blob-bg {
            position: absolute;
            z-index: -1;
            filter: blur(70px);
            opacity: 0.4;
            border-radius: 50%;
            animation: pulse 10s infinite alternate;
        }

        @keyframes pulse {
            0% {
                transform: scale(1);
            }

            100% {
                transform: scale(1.2);
            }
        }

        @media (max-width: 768px) {

            .faq-grid {
                grid-template-columns: 1fr !important;
            }

            .faq-card {
                padding: 1rem !important;
            }

            .faq-q {
                flex-wrap: wrap !important;
                gap: 0.5rem !important;
            }

            .faq-bullet {
                width: 32px !important;
                height: 32px !important;
                font-size: 0.75rem !important;
            }

            .px-10 {
                padding-left: 1.5rem !important;
                padding-right: 1.5rem !important;
            }

            h1.text-6xl {
                font-size: 2.75rem !important;
                line-height: 1.1 !important;
                text-align: center !important;
            }

            p.text-xl {
                font-size: 1.1rem !important;
                text-align: center !important;
                margin-left: auto !important;
                margin-right: auto !important;
            }

            #home {
                margin-top: 30px;
            }

            #home img {
                max-width: 90% !important;
                height: auto !important;
                position: relative;
                z-index: 10 !important;
            }

            #alur .text-5xl {
                font-size: 2.25rem !important;
                text-align: center !important;
            }

            #alur .grid {
                gap: 3rem !important;
            }

            #kenapa h2.text-5xl {
                font-size: 2.5rem !important;
                text-align: center !important;
                margin-top: 2rem;
            }

            #kenapa .grid {
                display: flex !important;
                flex-direction: column !important;
                gap: 2rem !important;
            }

            #kenapa .order-1 {
                order: 1 !important;
            }

            #kenapa .order-2 {
                order: 2 !important;
            }

            header nav .flex.items-center.justify-between {
                padding: 0.5rem 0;
            }

            .blob-bg {
                width: 200px !important;
                height: 200px !important;
                top: 0 !important;
                left: 50% !important;
                transform: translateX(-50%);
            }
        }
    </style>
</head>

<body class="bg-white text-gray-800">

    <header class="sticky top-0 z-50 transition-all duration-500">
        <nav id="main-nav" class="px-10 py-4 transition-all duration-500">
            <div class="flex items-center justify-between max-w-7xl mx-auto">
                <div class="flex items-center gap-2">
                    <img src="{{ asset('assets/img/logo_aspira1.png') }}" class="w-10" alt="Logo">
                    <span class="font-extrabold text-2xl tracking-tighter italic">ASPIRA</span>
                </div>

                <ul class="hidden md:flex gap-10 font-bold tracking-tight" id="nav-list">
                    <li><a href="#home" class="nav-link text-gray-500 transition-colors duration-300">Home</a></li>
                    <li><a href="#alur" class="nav-link text-gray-500 transition-colors duration-300">Cara Kerja</a></li>
                    <li><a href="#kenapa" class="nav-link text-gray-500 transition-colors duration-300">Keunggulan</a></li>
                    <li><a href="#faq" class="nav-link text-gray-500 transition-colors duration-300">FAQ</a></li>
                </ul>

                <a href="{{ route('login') }}">
                    <button class="bg-sky-500 text-white px-8 py-2.5 rounded-full font-bold hover:bg-sky-600 transition shadow-lg shadow-sky-100">
                        Masuk
                    </button>
                </a>
            </div>
        </nav>
    </header>

    <header id="home" class="relative max-w-7xl mx-auto px-10 grid md:grid-cols-2 gap-10 items-center -mt-10">
        <div class="blob-bg w-96 h-96 bg-sky-100 -top-20 -left-20"></div>

        <div class="z-10 text-center md:text-left">
            <h1 class="text-6xl md:text-7xl font-extrabold leading-tight mb-8 tracking-tighter " data-aos="fade-right" data-aos-duration="500">
                Aspirasi <span class="text-primary">Nyata,</span><br>Sekolah Nyaman
            </h1>
            <p class="text-gray-500 text-xl mb-10 max-w-md mx-auto md:mx-0 leading-relaxed font-medium" data-aos="fade-right" data-aos-delay="200">
                Laporkan kendala fasilitas dengan cepat agar segera ditangani demi kenyamanan bersama.
            </p>

            <div class="flex flex-col sm:flex-row items-center gap-5 justify-center md:justify-start">
                <button class="bg-primary text-white px-10 py-4 rounded-2xl font-bold shadow-2xl shadow-sky-200 hover:-translate-y-1 transition-all" data-aos="zoom-in" data-aos-delay="300">
                    Mulai Sekarang
                </button>
                <a href="#alur" class="flex items-center gap-3 font-bold text-gray-700 hover:text-primary transition-all group" data-aos="zoom-in" data-aos-delay="400">
                    <span class="w-12 h-12 rounded-full border border-gray-200 flex items-center justify-center group-hover:border-primary transition-all">
                        <i class="fas fa-arrow-down text-xs"></i>
                    </span>
                    Panduan Penggunaan
                </a>
            </div>
        </div>

        <div class="relative">
            <div class="absolute top-40 -left-10 w-12 h-12 border-2 border-sky-300 rounded-xl animate-[spin_8s_linear_infinite] opacity-60"></div>
            <div class="absolute top-96 right-0 w-12 h-12 border-2 border-sky-200 rounded-xl animate-[spin_8s_linear_infinite] opacity-60"></div>
            <div class="absolute top-24 right-0 w-20 h-20 bg-sky-400/10 rounded-full animate-bounce"></div>
            <div class="absolute top-[450px] right-[450px] w-10 h-10 bg-sky-500/10 rounded-full animate-bounce"></div>
            <div class="blob-bg w-96 h-96 bg-sky-200 top-32 right-20"></div>

            <div class="hero-image-blend relative z-10" data-aos="fade-up" data-aos-duration="700">
                <img src="{{ asset('assets/img/aspira6.jpg') }}" class="mx-auto transition-duration-700" style="width: 540px;" alt="Hero Illustration">
            </div>
        </div>
    </header>

    <section id="alur" class="py-10 bg-white mb-10">
        <div class="max-w-7xl mx-auto px-10">
            <div class="text-center mb-24">
                <h2 class="text-xs font-bold tracking-[0.5em] text-sky-600 uppercase mb-4" data-aos="fade-down">Workflow</h2>
                <p class="text-5xl font-extrabold text-slate-900 tracking-tighter italic" data-aos="fade-up">
                    Cara Kerja <span class="text-sky-600">ASPIRA</span>
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-4 gap-8 relative">
                <div class="group text-center" data-aos="fade-up" data-aos-delay="100">
                    <div class="w-20 h-20 bg-sky-50 rounded-3xl flex items-center justify-center mx-auto mb-8 border border-sky-100 group-hover:bg-sky-600 transition-all duration-500 group-hover:rotate-6">
                        <i class="fas fa-edit text-2xl text-sky-600 group-hover:text-white"></i>
                    </div>
                    <h3 class="text-xl font-bold text-slate-900 mb-3">Ajukan</h3>
                    <p class="text-slate-500 text-sm leading-relaxed px-4">Input detail kerusakan fasilitas secara digital.</p>
                </div>
                <div class="group text-center" data-aos="fade-up" data-aos-delay="200">
                    <div class="w-20 h-20 bg-sky-50 rounded-3xl flex items-center justify-center mx-auto mb-8 border border-sky-100 group-hover:bg-sky-600 transition-all duration-500 group-hover:rotate-6">
                        <i class="fas fa-clipboard-check text-2xl text-primary group-hover:text-white"></i>
                    </div>
                    <h3 class="text-xl font-bold text-slate-900 mb-3">Verifikasi</h3>
                    <p class="text-slate-500 text-sm leading-relaxed px-4">Validasi data oleh tim sarana prasarana.</p>
                </div>
                <div class="group text-center" data-aos="fade-up" data-aos-delay="300">
                    <div class="w-20 h-20 bg-sky-50 rounded-3xl flex items-center justify-center mx-auto mb-8 border border-sky-100 group-hover:bg-sky-600 transition-all duration-500 group-hover:rotate-6">
                        <i class="fas fa-tools text-2xl text-sky-600 group-hover:text-white"></i>
                    </div>
                    <h3 class="text-xl font-bold text-slate-900 mb-3">Perbaikan</h3>
                    <p class="text-slate-500 text-sm leading-relaxed px-4">Pengerjaan fisik oleh petugas lapangan.</p>
                </div>
                <div class="group text-center" data-aos="fade-up" data-aos-delay="400">
                    <div class="w-20 h-20 bg-slate-900 rounded-3xl flex items-center justify-center mx-auto mb-8 shadow-xl group-hover:bg-sky-600 transition-all duration-500">
                        <i class="fas fa-check-double text-2xl text-white"></i>
                    </div>
                    <h3 class="text-xl font-bold text-slate-900 mb-3">Selesai</h3>
                    <p class="text-slate-500 text-sm leading-relaxed px-4">Laporan selesai ditangani secara otomatis.</p>
                </div>
            </div>
        </div>
    </section>

    <section id="kenapa" class="pb-10 bg-slate-50/50">
        <div class="max-w-7xl mx-auto px-10 grid md:grid-cols-2 gap-20 items-start pt-5">
            <div class="relative order-2 md:order-1 flex justify-center">
                <div class="absolute top-72 right-0 w-12 h-12 border-2 border-sky-300 rounded-xl animate-[spin_8s_linear_infinite] opacity-60"></div>
                <div class="absolute top-10 right-50 w-10 h-10 bg-sky-400/10 rounded-full animate-bounce"></div>
                <div class="absolute bottom-16 right-32 w-14 h-14 bg-sky-400/10 rounded-full animate-bounce"></div>

                <div data-aos="fade-up" data-aos-duration="700" class="relative z-10">
                    <img src="{{ asset('assets/img/aspira9.png') }}" class="w-full max-w-lg" alt="Illustration">
                </div>
            </div>

            <div class="order-1 md:order-2 mt-3">
                <h2 class="text-5xl font-extrabold mb-6 tracking-tighter leading-tight" data-aos="fade-right">
                    Mengapa Harus <br><span class="text-primary italic">ASPIRA?</span>
                </h2>

                <div class="space-y-5">
                    <div class="flex items-start gap-6" data-aos="fade-left" data-aos-delay="100">
                        <span class="w-12 h-12 shrink-0 rounded-2xl bg-white border border-gray-100 shadow-sm text-sky-500 flex items-center justify-center font-bold text-xl">1</span>
                        <div>
                            <h4 class="font-bold text-xl text-gray-800">Sistem Pelaporan Terpusat</h4>
                            <p class="text-gray-500 mt-2 text-sm leading-relaxed">Setiap keluhan tercatat secara otomatis di database.</p>
                        </div>
                    </div>

                    <div class="flex items-start gap-6" data-aos="fade-left" data-aos-delay="200">
                        <span class="w-12 h-12 shrink-0 rounded-2xl bg-white border border-gray-100 shadow-sm text-sky-500 flex items-center justify-center font-bold text-xl">2</span>
                        <div>
                            <h4 class="font-bold text-xl text-gray-800">Respon Sangat Cepat</h4>
                            <p class="text-gray-500 mt-2 text-sm leading-relaxed">Memangkas proses birokrasi yang lama.</p>
                        </div>
                    </div>

                    <div class="flex items-start gap-6" data-aos="fade-left" data-aos-delay="300">
                        <span class="w-12 h-12 shrink-0 rounded-2xl bg-white border border-gray-100 shadow-sm text-sky-500 flex items-center justify-center font-bold text-xl">3</span>
                        <div>
                            <h4 class="font-bold text-xl text-gray-800">Transparansi Real-Time</h4>
                            <p class="text-gray-500 mt-2 text-sm leading-relaxed">Pantau langsung status pengerjaan kapan saja.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="faq" class="py-16 bg-white">
        <div class="max-w-7xl mx-auto px-10 pb-16">
            <div class="text-center mb-10">
                <h3 class="text-xs font-bold tracking-[0.4em] text-sky-600 uppercase mb-2" data-aos="fade-down">Ingin Tahu Lebih</h3>
                <h2 class="text-3xl md:text-4xl font-extrabold" data-aos="fade-up">Pertanyaan yang Sering Diajukan</h2>
                <p class="text-gray-500 mt-2 max-w-2xl mx-auto" data-aos="fade-up" data-aos-delay="100">FAQ ini disusun singkat dan langsung—jawaban fokus aksi, bukan teori.</p>
            </div>

            <div class="faq-grid" data-aos="fade-up" data-aos-delay="200">
                <div class="faq-card" tabindex="0">
                    <div class="faq-q">
                        <div class="flex items-center gap-4"><span class="faq-bullet bg-sky-100 text-sky-600 w-8 h-8 flex items-center justify-center rounded-full text-sm font-bold">A</span><span>Siapa yang bisa mengajukan laporan?</span></div>
                        <i class="fa-solid fa-chevron-down text-sky-400 transition-transform duration-300"></i>
                    </div>
                    <div class="faq-a">Layanan pengaduan ini dikhususkan bagi seluruh siswa aktif SMKN 8 Jember. Pastikan login menggunakan akun siswa Anda.</div>
                </div>

                <div class="faq-card" tabindex="0">
                    <div class="faq-q">
                        <div class="flex items-center gap-4"><span class="faq-bullet bg-sky-100 text-sky-600 w-8 h-8 flex items-center justify-center rounded-full text-sm font-bold">B</span><span>Kapan laporan saya akan diproses?</span></div>
                        <i class="fa-solid fa-chevron-down text-sky-400 transition-transform duration-300"></i>
                    </div>
                    <div class="faq-a">Laporan akan ditinjau pada jam operasional sekolah (07:00 - 15:00). Kecepatan respon bergantung pada kompleksitas masalah yang dilaporkan.</div>
                </div>

                <div class="faq-card" tabindex="0">
                    <div class="faq-q">
                        <div class="flex items-center gap-4"><span class="faq-bullet bg-sky-100 text-sky-600 w-8 h-8 flex items-center justify-center rounded-full text-sm font-bold">C</span><span>Laporan belum ditindaklanjuti dalam 24 jam?</span></div>
                        <i class="fa-solid fa-chevron-down text-sky-400 transition-transform duration-300"></i>
                    </div>
                    <div class="faq-a">Jika dalam 24 jam belum ada perubahan status atau respon awal, silakan hubungi kontak admin sekolah yang tertera di bagian footer untuk konfirmasi lebih lanjut.</div>
                </div>

                <div class="faq-card" tabindex="0">
                    <div class="faq-q">
                        <div class="flex items-center gap-4"><span class="faq-bullet bg-sky-100 text-sky-600 w-8 h-8 flex items-center justify-center rounded-full text-sm font-bold">D</span><span>Siapa saja yang bisa melihat detail laporan?</span></div>
                        <i class="fa-solid fa-chevron-down text-sky-400 transition-transform duration-300"></i>
                    </div>
                    <div class="faq-a">Keamanan privasi terjaga. Hanya admin sistem dan pihak sekolah terkait yang memiliki wewenang untuk melihat detail lengkap laporan Anda.</div>
                </div>

                <div class="faq-card" tabindex="0">
                    <div class="faq-q">
                        <div class="flex items-center gap-4"><span class="faq-bullet bg-sky-100 text-sky-600 w-8 h-8 flex items-center justify-center rounded-full text-sm font-bold">E</span><span>Apa yang harus disiapkan saat melapor?</span></div>
                        <i class="fa-solid fa-chevron-down text-sky-400 transition-transform duration-300"></i>
                    </div>
                    <div class="faq-a">Cukup siapkan deskripsi masalah yang jelas dan sertakan bukti foto pendukung agar tim sarana prasarana bisa melakukan verifikasi dengan cepat.</div>
                </div>

                <div class="faq-card" tabindex="0">
                    <div class="faq-q">
                        <div class="flex items-center gap-4"><span class="faq-bullet bg-sky-100 text-sky-600 w-8 h-8 flex items-center justify-center rounded-full text-sm font-bold">F</span><span>Bagaimana cara memantau progres perbaikan?</span></div>
                        <i class="fa-solid fa-chevron-down text-sky-400 transition-transform duration-300"></i>
                    </div>
                    <div class="faq-a">Anda dapat masuk ke halaman Riwayat Pengaduan. Di sana status laporan akan terupdate secara otomatis mulai dari tahap verifikasi hingga selesai diperbaiki.</div>
                </div>
            </div>
        </div>
    </section>
    <footer class="bg-gradient-to-b from-slate-900 to-black text-slate-100 relative overflow-hidden">
        <div class="h-1 bg-gradient-to-r from-transparent via-sky-500 to-transparent"></div>

        <div class="max-w-7xl mx-auto px-10 py-20 relative z-10">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-12 mb-12">

                <div class="flex flex-col">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="w-12 h-12 flex items-center justify-center">
                            <img src="{{ asset('assets/img/logo_aspira1.png') }}" class="w-10" alt="Logo">
                        </div>
                        <div>
                            <div class="font-extrabold text-2xl tracking-tight text-white italic">ASPIRA</div>
                        </div>
                    </div>
                    <p class="text-slate-400 text-sm mb-6 leading-relaxed max-w-sm">
                        Platform digital terpadu untuk menyampaikan aspirasi, laporan sarana prasarana, dan pengaduan layanan di lingkungan SMKN 8 Jember secara transparan.
                    </p>
                    <div class="flex gap-4">
                        <a class="w-11 h-11 bg-slate-800/60 hover:bg-sky-600 rounded-xl flex items-center justify-center transition duration-300 border border-slate-700/50" href="https://www.facebook.com/OFFICIALSMKN8JEMBER/" target="_blank" title="Facebook">
                            <i class="fab fa-facebook-f text-lg"></i>
                        </a>
                        <a class="w-11 h-11 bg-slate-800/60 hover:bg-gradient-to-tr from-yellow-500 via-red-500 to-purple-500 rounded-xl flex items-center justify-center transition duration-300 border border-slate-700/50" href="https://www.instagram.com/smkn8_official/" target="_blank" title="Instagram">
                            <i class="fab fa-instagram text-lg"></i>
                        </a>
                        <a class="w-11 h-11 bg-slate-800/60 hover:bg-black rounded-xl flex items-center justify-center transition duration-300 border border-slate-700/50" href="https://www.tiktok.com/@smkn.8.jember.off" target="_blank" title="TikTok">
                            <i class="fab fa-tiktok text-lg"></i>
                        </a>
                    </div>
                </div>

                <div class="md:justify-self-center">
                    <h4 class="font-bold text-white mb-6 text-sm uppercase tracking-[0.2em] border-b border-sky-500/30 pb-2 inline-block">Navigasi</h4>
                    <ul class="space-y-4 text-slate-400 text-sm">
                        <li><a href="#home" class="hover:text-sky-300 transition duration-300 flex items-center gap-3"><i class="fas fa-angle-right text-sky-500"></i>Beranda</a></li>
                        <li><a href="#fitur" class="hover:text-sky-300 transition duration-300 flex items-center gap-3"><i class="fas fa-angle-right text-sky-500"></i>Fitur Unggulan</a></li>
                        <li><a href="#alur" class="hover:text-sky-300 transition duration-300 flex items-center gap-3"><i class="fas fa-angle-right text-sky-500"></i>Alur Pengaduan</a></li>
                        <li><a href="#faq" class="hover:text-sky-300 transition duration-300 flex items-center gap-3"><i class="fas fa-angle-right text-sky-500"></i>Tanya Jawab</a></li>
                    </ul>
                </div>

                <div class="bg-slate-800/20 border border-slate-700/30 rounded-2xl p-6 backdrop-blur-sm">
                    <h4 class="font-bold text-white mb-5 text-sm uppercase tracking-[0.2em] flex items-center gap-2">
                        <span class="w-8 h-8 bg-sky-500/10 rounded-lg flex items-center justify-center">
                            <i class="fas fa-envelope-open-text text-sky-400"></i>
                        </span>
                        Hubungi Kami
                    </h4>
                    <ul class="space-y-4 text-slate-400 text-sm">
                        <li class="flex items-start gap-4">
                            <i class="fas fa-phone-alt text-sky-500 mt-1"></i>
                            <span class="leading-tight">(0331) 881084</span>
                        </li>
                        <li class="flex items-start gap-4">
                            <i class="fas fa-envelope text-sky-500 mt-1"></i>
                            <a href="mailto:smkn8jember@yahoo.com" class="hover:text-sky-300 transition break-all">smkn8jember@yahoo.com</a>
                        </li>
                        <li class="flex items-start gap-4">
                            <i class="fas fa-map-marker-alt text-sky-500 mt-1"></i>
                            <span class="leading-relaxed">Jl. Pelita No.27, Sidomekar, Kec. Semboro, Kab. Jember, Jawa Timur</span>
                        </li>
                    </ul>
                </div>

            </div>

            <div class="pt-8 border-t border-slate-800/60 flex flex-col md:flex-row justify-between items-center gap-4 text-slate-500 text-xs text-center md:text-left">
                <p>© 2026 <span class="text-white font-semibold">ASPIRA SMKN 8 JEMBER</span>. Hak Cipta Dilindungi.</p>

            </div>
        </div>
    </footer>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init({
            once: true,
        });

        const mainNav = document.getElementById('main-nav');

        function updateNavStyle() {
            if (window.scrollY > 40) {
                mainNav.classList.add('bg-white/80', 'backdrop-blur-md', 'border-b', 'border-gray-100', 'shadow-sm');
            } else {
                mainNav.classList.remove('bg-white/80', 'backdrop-blur-md', 'border-b', 'border-gray-100', 'shadow-sm');
            }
        }
        window.addEventListener('scroll', updateNavStyle);
        updateNavStyle();

        const navLinks = document.querySelectorAll('.nav-link');
        const sections = document.querySelectorAll('header[id], section[id]');

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                const id = entry.target.id;
                const link = document.querySelector('.nav-link[href="#' + id + '"]');
                if (entry.isIntersecting) {
                    navLinks.forEach(l => {
                        l.classList.remove('text-sky-500');
                        l.classList.add('text-gray-500');
                    });
                    if (link) {
                        link.classList.add('text-sky-500');
                        link.classList.remove('text-gray-500');
                    }
                }
            });
        }, {
            root: null,
            rootMargin: '-40% 0px -40% 0px',
            threshold: 0
        });

        sections.forEach(s => observer.observe(s));

        navLinks.forEach(link => {
            link.addEventListener('click', function(e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) target.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
                navLinks.forEach(l => {
                    l.classList.remove('text-sky-500');
                    l.classList.add('text-gray-500');
                });
                this.classList.add('text-sky-500');
                this.classList.remove('text-gray-500');
            });
        });

        const faqCards = document.querySelectorAll('.faq-card');
        faqCards.forEach(card => {
            const chevron = card.querySelector('.fa-chevron-down');

            card.addEventListener('click', () => {
                const isCurrentlyOpen = card.classList.contains('faq-open');

                faqCards.forEach(c => {
                    c.classList.remove('faq-open');
                    const c_chevron = c.querySelector('.fa-chevron-down');
                    if (c_chevron) {
                        c_chevron.style.transform = 'rotate(0deg)';
                        c_chevron.style.transition = 'transform 0.3s ease';
                    }
                });

                if (!isCurrentlyOpen) {
                    card.classList.add('faq-open');
                    if (chevron) {
                        chevron.style.transform = 'rotate(180deg)';
                    }
                }
            });

            card.addEventListener('keydown', (e) => {
                if (e.key === 'Enter' || e.key === ' ') {
                    e.preventDefault();
                    card.click();
                }
            });
        });
    </script>
</body>

</html>