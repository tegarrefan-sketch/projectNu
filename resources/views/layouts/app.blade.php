<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'NU Ranting Banjaranyar — Merawat Tradisi, Meneguhkan Aswaja')</title>
    <meta name="description" content="@yield('meta_description', 'Portal resmi Nahdlatul Ulama Ranting Banjaranyar, Kecamatan Baureno, Kabupaten Bojonegoro. Khidmah jam\'iyyah, warta BANOM, dan layanan jamaah terpadu.')">
    
    <!-- Google Fonts & Material Symbols -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" rel="stylesheet">
    
    <!-- Compiled Assets via Vite -->
    @vite(['resources/css/app.css'])

    <style>
        body {
            font-family: 'Plus Jakarta Sans', ui-sans-serif, system-ui, sans-serif;
            background-color: #f8f9ff;
            color: #121c2a;
        }
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
            display: inline-block;
            vertical-align: middle;
        }
    </style>
    @stack('styles')
</head>
<body class="min-h-screen flex flex-col antialiased bg-[#f8f9ff]">

    <!-- Top Sub-Bar (Amaliyah & Waktu Sholat) -->
    <div class="bg-[#004125] text-white py-1.5 px-4 sm:px-8 text-xs font-semibold">
        <div class="max-w-7xl mx-auto flex flex-wrap items-center justify-between gap-2">
            <div class="flex items-center gap-2">
                <span>بِسْمِ اللَّهِ الرَّحْمَٰنِ الرَّحِيمِ</span>
                <span class="opacity-40">•</span>
                <span class="hidden sm:inline">Pemberdayaan Umat & Khidmah Aswaja Ranting Banjaranyar</span>
            </div>
            <div class="flex items-center gap-4 text-[11px] sm:text-xs">
                <div class="flex items-center gap-1">
                    <span class="material-symbols-outlined text-[14px]">schedule</span>
                    <span>Jadwal Sholat Baureno: Ashar 15:18 WIB</span>
                </div>
                <span class="opacity-40">•</span>
                <div class="flex items-center gap-1">
                    <span class="material-symbols-outlined text-[14px]">calendar_today</span>
                    <span>14 Sya'ban 1446 H / 2025 M</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Navigation Header -->
    <header class="sticky top-0 z-50 bg-white/95 backdrop-blur-md shadow-[0_1px_8px_rgba(0,0,0,0.06)] border-b border-[#e6eeff]">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-20 flex items-center justify-between gap-4">
            
            <!-- Logo & Brand -->
            <a href="{{ route('home') }}" class="flex items-center gap-3 shrink-0">
                <div class="w-11 h-11 rounded-full bg-[#004125] flex items-center justify-center text-white shadow-md">
                    <span class="material-symbols-outlined text-[24px]">mosque</span>
                </div>
                <div class="flex flex-col">
                    <span class="text-base sm:text-lg font-bold text-[#004125] tracking-tight leading-tight">NU Ranting Banjaranyar</span>
                    <span class="text-[11px] sm:text-xs text-[#404942] font-medium">Kec. Baureno, Kab. Bojonegoro</span>
                </div>
            </a>

            <!-- Desktop Nav Menu -->
            <nav class="hidden lg:flex items-center gap-1 xl:gap-2">
                <a href="{{ route('home') }}" class="px-3 py-2 rounded-lg text-sm font-semibold transition-colors {{ request()->routeIs('home') ? 'bg-[#0c5a37] text-white' : 'text-[#404942] hover:text-[#004125] hover:bg-[#eff4ff]' }}">
                    Beranda
                </a>
                <a href="{{ route('profile') }}" class="px-3 py-2 rounded-lg text-sm font-semibold transition-colors {{ request()->routeIs('profile') ? 'bg-[#0c5a37] text-white' : 'text-[#404942] hover:text-[#004125] hover:bg-[#eff4ff]' }}">
                    Profil
                </a>
                
                <!-- Dropdown BANOM -->
                <div class="relative group py-2">
                    <button type="button" class="px-3 py-2 rounded-lg text-sm font-semibold text-[#404942] hover:text-[#004125] hover:bg-[#eff4ff] flex items-center gap-1 transition-colors">
                        <span>Badan Otonom</span>
                        <span class="material-symbols-outlined text-[18px]">expand_more</span>
                    </button>
                    <div class="absolute top-full left-0 hidden group-hover:block bg-white p-2 rounded-xl shadow-xl min-w-[220px] border border-[#e6eeff] z-50">
                        <a href="{{ route('banom.show', 'ipnu') }}" class="block px-3 py-2 rounded-lg text-xs font-semibold text-[#404942] hover:bg-[#eff4ff] hover:text-[#004125] transition-colors">
                            IPNU Pelajar Putra
                        </a>
                        <a href="{{ route('banom.show', 'ippnu') }}" class="block px-3 py-2 rounded-lg text-xs font-semibold text-[#404942] hover:bg-[#eff4ff] hover:text-[#004125] transition-colors">
                            IPPNU Pelajar Putri
                        </a>
                        <a href="{{ route('banom.show', 'fatayat') }}" class="block px-3 py-2 rounded-lg text-xs font-semibold text-[#404942] hover:bg-[#eff4ff] hover:text-[#004125] transition-colors">
                            Fatayat NU
                        </a>
                        <a href="{{ route('banom.show', 'ansor') }}" class="block px-3 py-2 rounded-lg text-xs font-semibold text-[#404942] hover:bg-[#eff4ff] hover:text-[#004125] transition-colors">
                            GP Ansor
                        </a>
                        <a href="{{ route('banom.show', 'banser') }}" class="block px-3 py-2 rounded-lg text-xs font-semibold text-[#404942] hover:bg-[#eff4ff] hover:text-[#004125] transition-colors">
                            Satkorkel Banser
                        </a>
                        <div class="border-t border-[#e6eeff] my-1"></div>
                        <a href="{{ route('banom.index') }}" class="block px-3 py-1.5 rounded-lg text-xs font-bold text-[#0c5a37] hover:bg-[#eff4ff] transition-colors">
                            Lihat Semua BANOM →
                        </a>
                    </div>
                </div>

                <a href="{{ route('structure.index') }}" class="px-3 py-2 rounded-lg text-sm font-semibold transition-colors {{ request()->routeIs('structure.index') ? 'bg-[#0c5a37] text-white' : 'text-[#404942] hover:text-[#004125] hover:bg-[#eff4ff]' }}">
                    Struktur
                </a>
                <a href="{{ route('post.index') }}" class="px-3 py-2 rounded-lg text-sm font-semibold transition-colors {{ request()->routeIs('post.*') ? 'bg-[#0c5a37] text-white' : 'text-[#404942] hover:text-[#004125] hover:bg-[#eff4ff]' }}">
                    Warta
                </a>
                <a href="{{ route('event.index') }}" class="px-3 py-2 rounded-lg text-sm font-semibold transition-colors {{ request()->routeIs('event.*') ? 'bg-[#0c5a37] text-white' : 'text-[#404942] hover:text-[#004125] hover:bg-[#eff4ff]' }}">
                    Agenda
                </a>
                <a href="{{ route('kta.verify.search') }}" class="px-3 py-2 rounded-lg text-sm font-semibold transition-colors {{ request()->routeIs('kta.*') ? 'bg-[#0c5a37] text-white' : 'text-[#404942] hover:text-[#004125] hover:bg-[#eff4ff]' }}">
                    Cek KTA
                </a>
                <a href="{{ route('aspirasi.create') }}" class="px-3 py-2 rounded-lg text-sm font-semibold transition-colors {{ request()->routeIs('aspirasi.*') ? 'bg-[#0c5a37] text-white' : 'text-[#404942] hover:text-[#004125] hover:bg-[#eff4ff]' }}">
                    Kotak Aspirasi
                </a>
            </nav>

            <!-- Actions Right -->
            <div class="flex items-center gap-2 sm:gap-3">
                <a href="{{ route('aspirasi.create') }}" class="hidden sm:inline-flex items-center gap-1.5 bg-[#004125] hover:bg-[#0c5a37] text-white text-xs sm:text-sm font-semibold px-3.5 py-2.5 rounded-lg shadow-sm transition-all">
                    <span class="material-symbols-outlined text-[18px]">chat</span>
                    <span>Kirim Aspirasi</span>
                </a>
                <a href="{{ route('admin.login') }}" class="inline-flex items-center gap-1.5 bg-[#e6eeff] hover:bg-[#dee9fc] text-[#121c2a] text-xs sm:text-sm font-semibold px-3.5 py-2.5 rounded-lg transition-colors">
                    <span class="material-symbols-outlined text-[18px] text-[#904d00]">lock</span>
                    <span class="hidden md:inline">Admin Portal</span>
                </a>
                <!-- Mobile Menu Button -->
                <button type="button" onclick="document.getElementById('mobileMenu').classList.toggle('hidden')" class="lg:hidden p-2 rounded-lg bg-[#eff4ff] text-[#004125] hover:bg-[#dee9fc] transition-colors">
                    <span class="material-symbols-outlined text-[24px]">menu</span>
                </button>
            </div>
        </div>

        <!-- Mobile Drawer Menu -->
        <div id="mobileMenu" class="hidden lg:hidden bg-white border-b border-[#e6eeff] px-4 py-4 space-y-2">
            <a href="{{ route('home') }}" class="block px-3 py-2 rounded-lg text-sm font-semibold text-[#121c2a] hover:bg-[#eff4ff]">Beranda</a>
            <a href="{{ route('profile') }}" class="block px-3 py-2 rounded-lg text-sm font-semibold text-[#121c2a] hover:bg-[#eff4ff]">Profil Organisasi</a>
            <a href="{{ route('banom.index') }}" class="block px-3 py-2 rounded-lg text-sm font-semibold text-[#121c2a] hover:bg-[#eff4ff]">5 Badan Otonom (BANOM)</a>
            <a href="{{ route('structure.index') }}" class="block px-3 py-2 rounded-lg text-sm font-semibold text-[#121c2a] hover:bg-[#eff4ff]">Struktur Organisasi</a>
            <a href="{{ route('post.index') }}" class="block px-3 py-2 rounded-lg text-sm font-semibold text-[#121c2a] hover:bg-[#eff4ff]">Warta & Berita</a>
            <a href="{{ route('event.index') }}" class="block px-3 py-2 rounded-lg text-sm font-semibold text-[#121c2a] hover:bg-[#eff4ff]">Agenda & Kegiatan</a>
            <a href="{{ route('kta.verify.search') }}" class="block px-3 py-2 rounded-lg text-sm font-semibold text-[#121c2a] hover:bg-[#eff4ff]">Verifikasi KTA SIMNU</a>
            <a href="{{ route('aspirasi.create') }}" class="block px-3 py-2 rounded-lg text-sm font-semibold text-[#121c2a] hover:bg-[#eff4ff]">Kotak Aspirasi Warga</a>
            <div class="pt-2 border-t border-[#e6eeff]">
                <a href="{{ route('admin.login') }}" class="block px-3 py-2 rounded-lg text-sm font-bold text-[#0c5a37] bg-[#eff4ff]">Masuk Portal Admin SIMNU</a>
            </div>
        </div>
    </header>

    <!-- Main Content Area -->
    <main class="flex-grow">
        @if (session('success'))
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4">
                <div class="bg-emerald-50 border border-emerald-200 text-emerald-800 px-4 py-3 rounded-xl flex items-center gap-3">
                    <span class="material-symbols-outlined text-emerald-600 text-[22px]">check_circle</span>
                    <span class="text-sm font-medium">{{ session('success') }}</span>
                </div>
            </div>
        @endif

        @if (session('error'))
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4">
                <div class="bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-xl flex items-center gap-3">
                    <span class="material-symbols-outlined text-red-600 text-[22px]">error</span>
                    <span class="text-sm font-medium">{{ session('error') }}</span>
                </div>
            </div>
        @endif

        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-[#002110] text-white pt-16 pb-8 border-t-4 border-[#fe932c]">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-12 gap-10 pb-12 border-b border-white/10">
                
                <!-- Col 1: Identity & Desc (5 cols) -->
                <div class="lg:col-span-5 space-y-4">
                    <div class="flex items-center gap-3">
                        <div class="w-12 h-12 rounded-full bg-[#0c5a37] flex items-center justify-center text-white shadow-lg">
                            <span class="material-symbols-outlined text-[28px]">mosque</span>
                        </div>
                        <div>
                            <h3 class="text-lg font-bold text-white tracking-tight">NU Ranting Banjaranyar</h3>
                            <p class="text-xs text-[#8fd6a9]">Kec. Baureno, Kab. Bojonegoro, Jawa Timur</p>
                        </div>
                    </div>
                    <p class="text-sm text-gray-300 leading-relaxed max-w-md">
                        Pusat khidmah dan informasi resmi Pengurus Ranting Nahdlatul Ulama Desa Banjaranyar. Meneguhkan akidah Ahlussunnah wal Jama'ah An-Nahdliyyah, merawat persaudaraan, dan memberdayakan umat.
                    </p>
                    <div class="pt-2 text-xs text-[#8fd6a9] flex items-center gap-2">
                        <span class="material-symbols-outlined text-[18px]">verified</span>
                        <span>SK Pengesahan PCNU Bojonegoro: 184/A.II/PC/SK/VIII/2023</span>
                    </div>
                </div>

                <!-- Col 2: Badan Otonom (3 cols) -->
                <div class="lg:col-span-3 space-y-3">
                    <h4 class="text-sm font-bold text-[#ffdcc3] uppercase tracking-wider">5 Badan Otonom (BANOM)</h4>
                    <ul class="space-y-2 text-sm text-gray-300">
                        <li><a href="{{ route('banom.show', 'ipnu') }}" class="hover:text-white hover:underline transition-colors flex items-center gap-1.5"><span class="w-1.5 h-1.5 rounded-full bg-[#0284c7]"></span>IPNU (Pelajar Putra)</a></li>
                        <li><a href="{{ route('banom.show', 'ippnu') }}" class="hover:text-white hover:underline transition-colors flex items-center gap-1.5"><span class="w-1.5 h-1.5 rounded-full bg-[#10b981]"></span>IPPNU (Pelajar Putri)</a></li>
                        <li><a href="{{ route('banom.show', 'fatayat') }}" class="hover:text-white hover:underline transition-colors flex items-center gap-1.5"><span class="w-1.5 h-1.5 rounded-full bg-[#059669]"></span>Fatayat NU (Pemudi)</a></li>
                        <li><a href="{{ route('banom.show', 'ansor') }}" class="hover:text-white hover:underline transition-colors flex items-center gap-1.5"><span class="w-1.5 h-1.5 rounded-full bg-[#fe932c]"></span>GP Ansor (Pemuda)</a></li>
                        <li><a href="{{ route('banom.show', 'banser') }}" class="hover:text-white hover:underline transition-colors flex items-center gap-1.5"><span class="w-1.5 h-1.5 rounded-full bg-[#dc2626]"></span>Satkorkel Banser</a></li>
                    </ul>
                </div>

                <!-- Col 3: Layanan & Navigasi (2 cols) -->
                <div class="lg:col-span-2 space-y-3">
                    <h4 class="text-sm font-bold text-[#ffdcc3] uppercase tracking-wider">Layanan Ranting</h4>
                    <ul class="space-y-2 text-sm text-gray-300">
                        <li><a href="{{ route('profile') }}" class="hover:text-white transition-colors">Profil Organisasi</a></li>
                        <li><a href="{{ route('structure.index') }}" class="hover:text-white transition-colors">Struktur Pengurus</a></li>
                        <li><a href="{{ route('post.index') }}" class="hover:text-white transition-colors">Warta & Berita</a></li>
                        <li><a href="{{ route('event.index') }}" class="hover:text-white transition-colors">Agenda Pengajian</a></li>
                        <li><a href="{{ route('kta.verify.search') }}" class="hover:text-white transition-colors">Cek / Verifikasi KTA</a></li>
                        <li><a href="{{ route('aspirasi.create') }}" class="hover:text-white transition-colors">Kotak Aspirasi</a></li>
                    </ul>
                </div>

                <!-- Col 4: Alamat & Kontak (2 cols) -->
                <div class="lg:col-span-2 space-y-3">
                    <h4 class="text-sm font-bold text-[#ffdcc3] uppercase tracking-wider">Kontak Sekretariat</h4>
                    <p class="text-xs text-gray-300 leading-relaxed">
                        Gedung Bersama PRNU Banjaranyar, Kec. Baureno, Kab. Bojonegoro, Jatim 62192
                    </p>
                    <p class="text-xs text-gray-300 flex items-center gap-1.5">
                        <span class="material-symbols-outlined text-[16px] text-[#fe932c]">call</span>
                        <span>+62 812-3456-7890</span>
                    </p>
                    <p class="text-xs text-gray-300 flex items-center gap-1.5">
                        <span class="material-symbols-outlined text-[16px] text-[#fe932c]">mail</span>
                        <span>sekretariat@nu-banjaranyar.or.id</span>
                    </p>
                </div>

            </div>

            <!-- Bottom Copyright -->
            <div class="pt-8 flex flex-col sm:flex-row items-center justify-between text-xs text-gray-400 gap-3">
                <p>&copy; {{ date('Y') }} Pengurus Ranting Nahdlatul Ulama Desa Banjaranyar. Khadim Ummah Design System.</p>
                <div class="flex items-center gap-4">
                    <a href="{{ route('kta.verify.search') }}" class="hover:text-[#8fd6a9] transition-colors">SIMNU Terpadu</a>
                    <span>•</span>
                    <a href="{{ route('admin.login') }}" class="hover:text-[#8fd6a9] transition-colors">Konsol Pengurus</a>
                </div>
            </div>
        </div>
    </footer>

    @stack('scripts')
</body>
</html>
