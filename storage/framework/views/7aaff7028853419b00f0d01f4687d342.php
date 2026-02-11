<!DOCTYPE html>
<html lang="id" class="scroll-smooth">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ASPIRA — Sistem Aspirasi Sekolah</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&display=swap');

        html {
            scroll-padding-top: 80px;
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

        /* Responsive Fixes */
        @media (max-width: 768px) {
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
        <nav class="bg-white/80 backdrop-blur-md border-b border-gray-100 px-10 py-4">
            <div class="flex items-center justify-between max-w-7xl mx-auto">
                <div class="flex items-center gap-2">
                    <img src="<?php echo e(asset('assets/img/logo_aspira1.png')); ?>" class="w-10" alt="Logo">
                    <span class="font-extrabold text-2xl tracking-tighter italic">ASPIRA</span>
                </div>

                <ul class="hidden md:flex gap-10 font-bold text-gray-500 tracking-tight" id="nav-list">
                    <li><a href="#home" class="nav-link text-sky-500 transition-colors duration-300">Home</a></li>
                    <li><a href="#alur" class="nav-link hover:text-sky-500 transition-colors duration-300">Cara Kerja</a></li>
                    <li><a href="#kenapa" class="nav-link hover:text-sky-500 transition-colors duration-300">Keunggulan</a></li>
                </ul>

                <a href="<?php echo e(route('login')); ?>">
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
                <img src="<?php echo e(asset('assets/img/aspira6.jpg')); ?>" class="mx-auto transition-duration-700" style="width: 540px;" alt="Hero Illustration">
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
                    <img src="<?php echo e(asset('assets/img/aspira9.png')); ?>" class="w-full max-w-lg" alt="Illustration">
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

    <footer class="bg-white py-10 border-t border-gray-100">
        <div class="max-w-7xl mx-auto px-10 flex flex-col items-center">
            <div class="flex items-center gap-2 mb-8">
                <img src="<?php echo e(asset('assets/img/logo_aspira1.png')); ?>" class="w-10" alt="Logo Footer">
                <span class="font-bold text-xl italic tracking-tighter">ASPIRA</span>
            </div>
            <div class="text-center">
                <p class="text-gray-400 text-[10px] uppercase tracking-[0.4em] font-bold">
                    Sistem Pengaduan Sarana & Prasarana Sekolah
                </p>
                <p class="text-gray-400 text-xs mt-4">
                    © 2026 ASPIRA. All rights reserved.
                </p>
            </div>
        </div>
    </footer>

    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init();

        // Navbar Active State
        const navLinks = document.querySelectorAll('.nav-link');
        navLinks.forEach(link => {
            link.addEventListener('click', function() {
                navLinks.forEach(l => {
                    l.classList.remove('text-sky-500');
                    l.classList.add('text-gray-500');
                });
                this.classList.add('text-sky-500');
                this.classList.remove('text-gray-500');
            });
        });
    </script>
</body>

</html><?php /**PATH C:\laragon\www\UKK_Aspira\resources\views/landing-page/index.blade.php ENDPATH**/ ?>