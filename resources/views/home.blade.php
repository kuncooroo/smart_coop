<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SMARTGATE - Solusi Manajemen Kandang Modern</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;600;800&display=swap"
        rel="stylesheet">

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: #fdfdf5;
        }

        .hero-section {
            background-color: #2d4739;
            position: relative;
            overflow: hidden;
        }

        .curve-divider {
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            line-height: 0;
            transform: rotate(180deg);
        }

        .curve-divider svg {
            position: relative;
            display: block;
            width: calc(100% + 1.3px);
            height: 100px;
        }

        .curve-divider .shape-fill {
            fill: #fdfdf5;
        }

        .nav-transparent {
            background: transparent;
            transition: all 0.3s ease;
        }

        .nav-scrolled {
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(12px);
            transition: all 0.4s ease;
        }

        .nav-link {
            position: relative;
            transition: all 0.3s ease;
        }

        .nav-link::after {
            content: "";
            position: absolute;
            left: 0;
            bottom: -5px;
            width: 0%;
            height: 2px;
            background-color: #8dbb61;
            transition: width 0.3s ease;
        }

        .nav-link:hover::after {
            width: 100%;
        }

        .nav-link:hover {
            transform: translateY(-2px);
        }

        .btn-organic {
            background-color: #8dbb61;
            transition: all 0.3s ease;
        }

        .btn-organic:hover {
            background-color: #7aa552;
            transform: translateY(-2px);
        }

        .text-light-green {
            color: #8dbb61;
        }

        @keyframes float {

            0%,
            100% {
                transform: translateY(0px);
            }

            50% {
                transform: translateY(-15px);
            }
        }

        .animate-float {
            animation: float 4s ease-in-out infinite;
        }

        .scroll-animate {
            opacity: 0;
            transform: translateY(40px);
            transition: all 0.8s ease;
        }

        .scroll-animate.show {
            opacity: 1;
            transform: translateY(0);
        }
    </style>
</head>

<body x-data="{ scrolled: false, loginModal: false, showPassword: false }"@scroll.window="scrolled = window.scrollY > 50">

    <nav :class="scrolled
        ?
        'nav-scrolled py-4 shadow-lg text-[#2d4739]' :
        'py-6 text-white'"
        class="fixed top-0 w-full z-50 transition-all duration-300">

        <div class="max-w-7xl mx-auto px-8 flex items-center justify-between">
            <div class="flex items-center space-x-2">
                <div class="bg-white/10 p-2 rounded-full">
                    <i class="fas fa-bolt text-lg" :class="scrolled ? 'text-[#2d4739]' : 'text-white'"></i>
                </div>

                <span class="font-extrabold text-xl tracking-tight uppercase"
                    :class="scrolled ? 'text-[#2d4739]' : 'text-white'">
                    SMARTGATE
                </span>
            </div>

            <div class="hidden md:flex items-center space-x-10 text-sm font-medium"
                :class="scrolled ? 'text-[#2d4739]' : 'text-white/90'">

                <a href="#home" class="nav-link">Home</a>
                <a href="#about" class="nav-link">Tentang</a>
                <a href="#features" class="nav-link">Fitur</a>
            </div>

            <div>
                @auth
                    <a href="{{ route('dashboard') }}"
                        class="text-white font-bold text-sm border-2 border-white/20 px-6 py-2 rounded-full hover:bg-white hover:text-[#2d4739] transition duration-300">
                        Dashboard
                    </a>
                @else
                    <button @click="loginModal = true"
                        class="font-bold text-sm border-2 px-6 py-2 rounded-full transition duration-300"
                        :class="scrolled
                            ?
                            'text-[#2d4739] border-[#2d4739]/20 hover:bg-[#2d4739] hover:text-white' :
                            'text-white border-white/20 hover:bg-white hover:text-[#2d4739]'">
                        Masuk
                    </button>
                @endauth
            </div>
        </div>
    </nav>

    <section id="home" class="hero-section min-h-[90vh] flex items-center pt-20">
        <div class="max-w-7xl mx-auto px-8 w-full grid md:grid-cols-2 gap-12 items-center relative z-10 pb-32">

            <div class="text-left">
                <h1 class="text-5xl md:text-7xl font-extrabold text-white leading-[1.1] mb-6">
                    Kandang yang Lebih <br>
                    <span class="text-light-green">Pintar dan Aman</span> <br>
                    untuk Ternak!
                </h1>
                <p class="text-white/70 text-lg mb-10 max-w-lg leading-relaxed font-light">
                    SMARTGATE hadir untuk membantu kamu dalam mengelola asupan pakan,
                    monitoring suhu otomatis, dan kontrol gerbang pintar yang dikemas dalam
                    sistem manajemen premium yang kaya akan data real-time!
                </p>
                <button @click="loginModal = true"
                    class="btn-organic text-white px-10 py-4 rounded-xl font-bold shadow-lg">
                    Pelajari lebih lanjut
                </button>
            </div>

            <div class="relative flex justify-center items-center">
                <div class="absolute inset-0 scale-125 opacity-20 pointer-events-none">
                    <svg viewBox="0 0 200 200" xmlns="http://www.w3.org/2000/svg">
                        <path fill="#FFFFFF"
                            d="M44.7,-76.4C58.1,-69.2,69.2,-57,77.4,-43.1C85.5,-29.2,90.8,-13.6,89.3,1.5C87.8,16.7,79.6,31.4,69.5,43.7C59.3,56.1,47.2,66.1,33.5,72.4C19.8,78.7,4.5,81.4,-11.1,78.7C-26.7,76.1,-42.6,68.2,-54.9,56.9C-67.2,45.7,-75.9,31.1,-79.9,15.2C-83.9,-0.6,-83.1,-17.7,-76.3,-32.2C-69.5,-46.8,-56.7,-58.9,-42.5,-65.8C-28.3,-72.7,-14.2,-74.5,0.7,-75.8C15.6,-77.1,31.3,-83.7,44.7,-76.4Z"
                            transform="translate(100 100)" />
                    </svg>
                </div>

                <img src="{{ asset('storage/images/ayam2.jpg') }}"
class="relative z-10 w-full max-w-lg h-[450px] object-cover rounded-[3rem] 
shadow-2xl border-8 border-white/10 
transition duration-500 hover:scale-105 animate-float"> 
            </div>
        </div>

        <div class="curve-divider">
            <svg data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1200 120"
                preserveAspectRatio="none">
                <path
                    d="M0,0V46.29c47.79,22.2,103.59,32.17,158,28,70.36-5.37,136.33-33.31,206.8-37.5,73.84-4.36,147.54,16.88,218.44,35.26,69.27,18,138.3,24.88,209.4,13.08,36.15-6,69.85-17.84,104.45-29.34C989.49,25,1113-14.29,1200,52.47V0Z"
                    opacity=".25" class="shape-fill"></path>
                <path
                    d="M0,0V15.81C13,36.92,27.64,56.86,47.69,72.05,99.41,111.27,165,111,224.58,91.58c31.15-10.15,60.09-26.07,89.67-39.8,40.92-19,84.73-46,130.83-49.67,36.26-2.85,70.9,9.42,98.6,31.56,31.77,25.39,62.32,62,103.63,73,40.44,10.79,81.35-6.69,119.13-24.28s75.16-39,116.92-43.05c59.73-5.85,113.28,22.88,168.9,38.84,30.2,8.66,59,6.17,87.09-7.5,22.43-10.89,48-26.93,60.65-49.24V0Z"
                    opacity=".5" class="shape-fill"></path>
                <path
                    d="M0,0V5.63C149.93,59,314.09,71.32,475.83,42.57c43-7.64,84.23-20.12,127.61-26.46,59-8.63,112.48,12.24,165.56,35.4C827.93,77.22,886,95.24,951.2,90c86.53-7,172.46-45.71,248.8-84.81V0Z"
                    class="shape-fill"></path>
            </svg>
        </div>
    </section>

    <section id="about" class="py-24 bg-[#fdfdf5] overflow-hidden relative">
        <div class="max-w-7xl mx-auto px-8 relative min-h-[500px] flex items-center scroll-animate">
            <div class="grid md:grid-cols-5 gap-12 items-center w-full">

                <div class="flex flex-col items-start md:col-span-3 z-10 relative">
                    <div
                        class="inline-block px-4 py-1.5 rounded-full border border-[#8dbb61] text-[#8dbb61] text-[12px] font-bold tracking-wider mb-6 uppercase">
                        Precision Farming
                    </div>

                    <h2 class="text-4xl md:text-5xl font-extrabold text-[#2d4739] leading-tight mb-8">
                        Teknologi Teruji, Bebas Kendala & Otomatis, dengan Inovasi Lokal Indonesia!
                    </h2>

                    <p class="text-slate-600 text-lg leading-relaxed mb-6 font-medium text-left">
                        SMARTGATE dikembangkan dari riset mendalam teknologi IoT lokal, dengan sensor akurasi tinggi &
                        algoritma cerdas buatan anak bangsa. Jadi solusi manajemen kandang yang lebih efisien dari
                        peternak pemula hingga skala industri!
                    </p>

                    <p class="text-slate-600 text-lg leading-relaxed text-left">
                        Kami percaya bahwa digitalisasi agrikultur adalah kunci masa depan pangan. Dengan fitur pantau
                        jarak jauh, Anda tidak perlu lagi khawatir dengan fluktuasi suhu atau keamanan kandang di malam
                        hari.
                    </p>
                </div>

                <div class="md:col-span-2 relative md:absolute md:right-0 md:bottom-0 z-0">
                    <img src="{{ asset('storage/images/ayam1.png') }}" alt="Ilustrasi Ayam SMARTGATE"
                        class="w-full max-w-[400px] md:max-w-[500px] lg:max-w-[600px] h-auto object-contain 
                            translate-y-6 md:translate-y-10 translate-x-4 md:translate-x-12
                            drop-shadow-2xl transition duration-700 hover:scale-105">
                </div>

            </div>
        </div>
    </section>
    <section id="features" class="relative py-24 bg-[#fdfdf5] overflow-hidden">
        <div class="max-w-7xl mx-auto px-8 text-center relative z-10 scroll-animate">

            <h2 class="text-4xl md:text-5xl font-extrabold text-[#2d4739] mb-20 leading-tight">
                Tetap <span class="text-[#8dbb61]">#SmartAndEfficient</span> dengan SMARTGATE!
            </h2>

            <div class="grid md:grid-cols-3 gap-12 text-center mb-16 scroll-animate">
                <div class="flex flex-col items-center">
                    <div class="w-24 h-24 mb-6 text-[#2d4739] flex items-center justify-center">
                        <i class="fas fa-seedling text-7xl opacity-80"></i>
                    </div>
                    <h4 class="font-bold text-[#2d4739] text-xl mb-3">Efisiensi Pakan Otomatis</h4>
                    <p class="text-slate-600 text-sm leading-relaxed max-w-sm">
                        Dengan penjadwalan pakan presisi berbasis timbangan IoT, kurangi limbah pakan hingga 30% &
                        pastikan ternak tumbuh optimal!
                    </p>
                </div>

                <div class="flex flex-col items-center">
                    <div class="w-24 h-24 mb-6 text-[#2d4739] flex items-center justify-center">
                        <i class="fas fa-thermometer-half text-7xl opacity-80"></i>
                    </div>
                    <h4 class="font-bold text-[#2d4739] text-xl mb-3">Monitoring Lingkungan 24/7</h4>
                    <p class="text-slate-600 text-sm leading-relaxed max-w-sm">
                        Sensor suhu & kelembaban akurasi tinggi, kirim data real-time ke HP Anda untuk cegah stres pada
                        ternak.
                    </p>
                </div>

                <div class="flex flex-col items-center">
                    <div class="w-24 h-24 mb-6 text-[#2d4739] flex items-center justify-center">
                        <i class="fas fa-door-open text-7xl opacity-80"></i>
                    </div>
                    <h4 class="font-bold text-[#2d4739] text-xl mb-3">Kontrol Gerbang Jarak Jauh</h4>
                    <p class="text-slate-600 text-sm leading-relaxed max-w-sm">
                        Buka/tutup gerbang kandang otomatis sesuai jadwal atau secara manual via aplikasi, tingkatkan
                        keamanan & manajemen akses.
                    </p>
                </div>
            </div>

            <div class="mt-20 pb-20">
                <a href="https://wa.me/6287785711752?text=Halo%20saya%20tertarik%20dengan%20website%20ini%20https://smartgate.id"
                    class="inline-flex items-center space-x-3 bg-[#8dbb61] text-white px-10 py-4 rounded-full font-extrabold text-lg shadow-[0_10px_30px_-5px_rgba(141,187,97,0.6)] hover:scale-105 transition-transform duration-300">
                    <i class="fas fa-headset"></i>
                    <span>Hubungi Smartgate</span>
                </a>
            </div>

        </div>
    </section>
    <section class="bg-[#2d4739] text-white py-24 px-6 md:px-12">
        <div class="max-w-7xl mx-auto text-center">

            <h2 class="text-3xl md:text-5xl font-extrabold mb-20 leading-tight tracking-tight">
                Dipercaya oleh ratusan peternak sebagai solusi <br class="hidden md:block"> kandang pintar modern!
            </h2>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-12 md:gap-8 items-start">

                <div class="flex flex-col items-center">
                    <span class="text-7xl md:text-8xl font-extrabold mb-4 tracking-tighter">
                        2000+
                    </span>
                    <p class="script-font text-xl md:text-2xl opacity-90">
                        Satisfied customer
                    </p>
                </div>

                <div
                    class="flex flex-col items-center border-t md:border-t-0 md:border-l border-white/20 pt-12 md:pt-0 md:pl-8">
                    <span class="text-7xl md:text-8xl font-extrabold mb-4 tracking-tighter">
                        100%
                    </span>
                    <p class="script-font text-xl md:text-2xl opacity-90">
                        Excellent customer service
                    </p>
                </div>

                <div
                    class="flex flex-col items-center border-t md:border-t-0 md:border-l border-white/20 pt-12 md:pt-0 md:pl-8">
                    <span class="text-7xl md:text-8xl font-extrabold mb-4 tracking-tighter">
                        100%
                    </span>
                    <p class="script-font text-xl md:text-2xl opacity-90">
                        Natural & Premium quality
                    </p>
                </div>

            </div>
        </div>
    </section>


    <section id="contact" class="relative bg-white pt-24 pb-16">
        <div class="max-w-7xl mx-auto px-8 relative z-10">

            <div class="grid md:grid-cols-4 gap-12 text-left text-slate-500 text-sm border-b border-slate-100 pb-16">

                <div class="col-span-1 flex flex-col items-start space-y-6">
                    <div class="flex items-center space-x-2">
                        <div class="bg-[#2d4739] p-2 rounded-lg">
                            <i class="fas fa-bolt text-white"></i>
                        </div>
                        <span class="font-extrabold text-xl tracking-tight text-[#2d4739] uppercase">SMARTGATE</span>
                    </div>
                    <p class="leading-relaxed">
                        Solusi teknologi IoT terdepan untuk efisiensi pakan dan keamanan kandang peternakan modern di
                        Indonesia.
                    </p>
                </div>

                <div class="col-span-1 space-y-4 font-medium">
                    <h5 class="font-bold text-[#2d4739] text-base">Navigasi</h5>
                    <ul class="space-y-2">
                        <li><a href="#home" class="hover:text-[#8dbb61] transition">Home</a></li>
                        <li><a href="#about" class="hover:text-[#8dbb61] transition">Tentang Kami</a></li>
                        <li><a href="#features" class="hover:text-[#8dbb61] transition">Fitur Unggulan</a></li>
                        <li><a href="#contact" class="hover:text-[#8dbb61] transition">Hubungi Kami</a></li>
                    </ul>
                </div>

                <div class="col-span-1 space-y-4 font-medium">
                    <h5 class="font-bold text-[#2d4739] text-base">Kontak Person</h5>
                    <div class="space-y-3">
                        <p class="flex items-start space-x-3">
                            <i class="fas fa-map-marker-alt text-[#8dbb61] mt-1"></i>
                            <span>
                                Jl. Veteran No.10-11, Ketawanggede, Kec. Lowokwaru, Kota Malang, Jawa Timur
                            </span>
                        </p>
                        <p class="flex items-center space-x-3">
                            <i class="fas fa-envelope text-[#8dbb61]"></i>
                            <span>support@smartgate.id</span>
                        </p>
                        <p class="flex items-center space-x-3">
                            <i class="fas fa-phone text-[#8dbb61]"></i>
                            <span>+62 877 8571 1752</span>
                        </p>
                    </div>
                </div>

                <div class="col-span-1 space-y-4">
                    <h5 class="font-bold text-[#2d4739] text-base">Media Sosial</h5>
                    <div class="flex space-x-4">
                        <a href="#"
                            class="w-10 h-10 rounded-full bg-slate-100 flex items-center justify-center text-xl text-[#2d4739] hover:bg-[#8dbb61] hover:text-white transition">
                            <i class="fab fa-instagram"></i>
                        </a>
                        <a href="#"
                            class="w-10 h-10 rounded-full bg-slate-100 flex items-center justify-center text-xl text-[#2d4739] hover:bg-[#8dbb61] hover:text-white transition">
                            <i class="fab fa-tiktok"></i>
                        </a>
                        <a href="#"
                            class="w-10 h-10 rounded-full bg-slate-100 flex items-center justify-center text-xl text-[#2d4739] hover:bg-[#8dbb61] hover:text-white transition">
                            <i class="fab fa-facebook"></i>
                        </a>
                    </div>
                </div>
            </div>

            <div class="pt-8 text-center text-slate-400 text-xs">
                <p>&copy; 2026 SmartGate Technology. All rights reserved.</p>
            </div>

        </div>
    </section>

    <div x-show="loginModal"
        class="fixed inset-0 z-[100] flex items-center justify-center bg-black/60 backdrop-blur-sm"
        style="display: none;" @keydown.escape.window="loginModal = false">

        <div class="bg-white p-10 rounded-3xl w-full max-w-md shadow-2xl relative" @click.away="loginModal = false">
            <button @click="loginModal = false" class="absolute top-6 right-6 text-slate-400 hover:text-black">
                <i class="fas fa-times text-xl"></i>
            </button>

            <h2 class="text-2xl font-bold text-[#2d4739] mb-2 text-center">Selamat Datang</h2>
            <p class="text-center text-slate-500 text-sm mb-6">Masuk untuk mengelola kandang Anda</p>

            @if ($errors->any())
                <div class="mb-4 p-3 rounded-xl bg-red-50 text-red-600 text-sm">
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('login') }}" method="POST">
                @csrf

                <div>
                    <label class="block text-xs font-bold text-[#2d4739] uppercase mb-1 ml-1">Username / Email</label>
                    <input type="text" name="login" value="{{ old('login') }}" required
                        placeholder="Masukkan username atau email"
                        class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-[#8dbb61] transition">
                </div>

                <div>
                    <label class="block text-xs font-bold text-[#2d4739] uppercase mb-1 ml-1">Password</label>

                    <div class="relative">
                        <input :type="showPassword ? 'text' : 'password'" name="password" required
                            placeholder="••••••••"
                            class="w-full px-4 py-3 pr-12 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-[#8dbb61] transition">

                        <button type="button" @click="showPassword = !showPassword"
                            class="absolute right-4 top-1/2 -translate-y-1/2 text-slate-400 hover:text-[#2d4739]">

                            <i :class="showPassword ? 'fas fa-eye-slash' : 'fas fa-eye'"></i>
                        </button>
                    </div>
                </div>

                <div class="flex items-center justify-between px-1">
                    <label class="flex items-center text-sm text-slate-600 cursor-pointer">
                        <input type="checkbox" name="remember" value="1"{{ old('remember') ? 'checked' : '' }}
                            class="rounded border-gray-300 text-[#8dbb61] focus:ring-[#8dbb61] mr-2">
                    </label>
                    <a href="#" class="text-sm text-[#8dbb61] hover:underline font-medium">Lupa Password?</a>
                </div>

                <button type="submit" class="w-full btn-organic text-white py-4 rounded-xl font-bold shadow-lg mt-2">
                    Masuk Sekarang
                </button>
            </form>
        </div>
    </div>
    @if ($errors->any())
        <script>
            document.addEventListener('DOMContentLoaded', () => {
                const root = document.querySelector('[x-data]');
                if (root) {
                    const alpineData = window.Alpine.$data(root);
                    alpineData.loginModal = true;
                }
            });
        </script>
    @endif
    <script>
        const elements = document.querySelectorAll('.scroll-animate');

        const observer = new IntersectionObserver(entries => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('show');
                }
            });
        }, {
            threshold: 0.2
        });

        elements.forEach(el => observer.observe(el));
    </script>
</body>

</html>
