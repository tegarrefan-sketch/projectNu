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
            font-size: 16px;
        }
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 500, 'GRAD' 0, 'opsz' 24;
            display: inline-block;
            vertical-align: middle;
        }
    </style>
    @stack('styles')
</head>
<body class="min-h-screen flex flex-col antialiased bg-[#f8f9ff] text-[#121c2a]">

    @auth
    <!-- Admin Preview Banner & Quick Return Toolbar -->
    <div class="bg-[#002d1a] border-b border-emerald-800 text-white px-4 py-2 text-xs sticky top-0 z-50 shadow-md">
        <div class="max-w-7xl mx-auto flex flex-wrap items-center justify-between gap-2">
            <div class="flex items-center gap-2">
                <span class="material-symbols-outlined text-emerald-400 text-base">admin_panel_settings</span>
                <span>Mode Pratinjau Admin: <strong class="text-white">{{ auth()->user()->name }}</strong></span>
            </div>
            <div class="flex items-center gap-2">
                @if(request()->routeIs('event.*'))
                    <a href="{{ route('admin.agenda.index') }}" class="inline-flex items-center gap-1 px-3 py-1 rounded-lg bg-emerald-600 hover:bg-emerald-500 text-white font-bold transition shadow-sm">
                        <span class="material-symbols-outlined text-[14px]">arrow_back</span>
                        <span>Kembali ke Manajemen Agenda</span>
                    </a>
                @elseif(request()->routeIs('post.*') || request()->routeIs('berita.*'))
                    <a href="{{ route('admin.berita.index') }}" class="inline-flex items-center gap-1 px-3 py-1 rounded-lg bg-emerald-600 hover:bg-emerald-500 text-white font-bold transition shadow-sm">
                        <span class="material-symbols-outlined text-[14px]">arrow_back</span>
                        <span>Kembali ke Manajemen Warta</span>
                    </a>
                @else
                    <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center gap-1 px-3 py-1 rounded-lg bg-emerald-600 hover:bg-emerald-500 text-white font-bold transition shadow-sm">
                        <span class="material-symbols-outlined text-[14px]">dashboard</span>
                        <span>Kembali ke Panel Admin</span>
                    </a>
                @endif
            </div>
        </div>
    </div>
    @endauth

    <!-- Top Sub-Bar (Amaliyah & Waktu Sholat) -->
    <div class="bg-[#00331d] text-white py-2 px-4 sm:px-8 text-xs font-semibold border-b border-white/10">
        <div class="max-w-7xl mx-auto flex flex-wrap items-center justify-between gap-2">
            <div class="flex items-center gap-2">
                <span class="text-[#aaf2c4] font-bold">بِسْمِ اللَّهِ الرَّحْمَٰنِ الرَّحِيمِ</span>
                <span class="opacity-40">•</span>
                <span class="hidden sm:inline text-emerald-100">Pemberdayaan Umat & Khidmah Aswaja Ranting Banjaranyar</span>
            </div>
            <div class="flex items-center gap-4 text-xs">
                <div class="flex items-center gap-1.5 text-emerald-200">
                    <span class="material-symbols-outlined text-[16px] text-[#fe932c]">schedule</span>
                    <span>Jadwal Sholat Baureno: Ashar 15:18 WIB</span>
                </div>
                <span class="opacity-40">•</span>
                <div class="flex items-center gap-1.5 text-emerald-200">
                    <span class="material-symbols-outlined text-[16px] text-[#fe932c]">calendar_today</span>
                    <span>14 Sya'ban 1446 H / 2025 M</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Navigation Header (Clean, Spacious, Dropdown-enabled) -->
    <header class="sticky top-0 z-50 bg-white/95 backdrop-blur-md shadow-[0_2px_12px_rgba(0,0,0,0.06)] border-b border-[#e6eeff]">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-20 sm:h-22 flex items-center justify-between gap-4">
            
            <!-- Logo & Brand (Jelas, besar, ramah lansia) -->
            <a href="{{ route('home') }}" class="flex items-center gap-3.5 shrink-0 group py-1">
                <div class="w-12 h-12 rounded-2xl bg-[#004125] group-hover:bg-[#0c5a37] flex items-center justify-center text-white shadow-md transition-colors">
                    <span class="material-symbols-outlined text-[28px] text-[#fe932c]">mosque</span>
                </div>
                <div class="flex flex-col">
                    <span class="text-lg sm:text-xl font-extrabold text-[#004125] tracking-tight leading-snug">NU Ranting Banjaranyar</span>
                    <span class="text-xs text-[#526350] font-medium">Kec. Baureno, Kab. Bojonegoro</span>
                </div>
            </a>

            <!-- Desktop Nav Menu (Lega, teratur dalam 4 kelompok menu) -->
            <nav class="hidden lg:flex items-center gap-1.5 xl:gap-2">
                <!-- 1. Beranda -->
                <a href="{{ route('home') }}" class="px-4 py-2.5 rounded-xl text-[15px] font-bold transition-all {{ request()->routeIs('home') ? 'bg-[#004125] text-white shadow-sm' : 'text-[#2a382e] hover:text-[#004125] hover:bg-[#eff4ff]' }}">
                    Beranda
                </a>

                <!-- 2. Profil & Struktur ▾ -->
                <div class="relative nav-item group">
                    <button type="button" class="px-4 py-2.5 rounded-xl text-[15px] font-bold flex items-center gap-1.5 transition-all {{ request()->routeIs('profile') || request()->routeIs('structure.*') || request()->routeIs('banom.*') ? 'bg-[#004125] text-white shadow-sm' : 'text-[#2a382e] hover:text-[#004125] hover:bg-[#eff4ff]' }}" aria-haspopup="true">
                        <span>Profil & Struktur</span>
                        <span class="material-symbols-outlined text-[20px] transition-transform duration-200 group-hover:rotate-180">expand_more</span>
                    </button>
                    <div class="nav-dropdown absolute top-full left-0 pt-2 w-64 z-50">
                        <div class="bg-white rounded-2xl p-2.5 shadow-xl border border-[#e6eeff] space-y-1">
                            <a href="{{ route('profile') }}" class="flex items-center gap-3 px-3.5 py-3 rounded-xl hover:bg-[#eff4ff] text-[#2a382e] hover:text-[#004125] transition-colors {{ request()->routeIs('profile') ? 'bg-[#eff4ff] text-[#004125] font-bold' : '' }}">
                                <span class="material-symbols-outlined text-[#0c5a37] text-[22px]">account_balance</span>
                                <div>
                                    <div class="text-sm font-bold">Profil Organisasi</div>
                                    <div class="text-[11px] text-[#707971]">Sejarah, visi & misi ranting</div>
                                </div>
                            </a>
                            <a href="{{ route('structure.index') }}" class="flex items-center gap-3 px-3.5 py-3 rounded-xl hover:bg-[#eff4ff] text-[#2a382e] hover:text-[#004125] transition-colors {{ request()->routeIs('structure.index') && request('tab') !== 'banom' ? 'bg-[#eff4ff] text-[#004125] font-bold' : '' }}">
                                <span class="material-symbols-outlined text-[#0c5a37] text-[22px]">badge</span>
                                <div>
                                    <div class="text-sm font-bold">Struktur Pengurus</div>
                                    <div class="text-[11px] text-[#707971]">Syuriyah & Tanfidziyah</div>
                                </div>
                            </a>
                            <a href="{{ route('structure.index', ['tab' => 'banom']) }}" class="flex items-center gap-3 px-3.5 py-3 rounded-xl hover:bg-[#eff4ff] text-[#2a382e] hover:text-[#004125] transition-colors {{ request('tab') === 'banom' ? 'bg-[#eff4ff] text-[#004125] font-bold' : '' }}">
                                <span class="material-symbols-outlined text-[#0c5a37] text-[22px]">diversity_3</span>
                                <div>
                                    <div class="text-sm font-bold">Badan Otonom (Banom)</div>
                                    <div class="text-[11px] text-[#707971]">Muslimat, Ansor, Fatayat, dll</div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- 3. Informasi ▾ -->
                <div class="relative nav-item group">
                    <button type="button" class="px-4 py-2.5 rounded-xl text-[15px] font-bold flex items-center gap-1.5 transition-all {{ request()->routeIs('post.*') || request()->routeIs('event.*') || request()->routeIs('galeri.*') ? 'bg-[#004125] text-white shadow-sm' : 'text-[#2a382e] hover:text-[#004125] hover:bg-[#eff4ff]' }}" aria-haspopup="true">
                        <span>Informasi</span>
                        <span class="material-symbols-outlined text-[20px] transition-transform duration-200 group-hover:rotate-180">expand_more</span>
                    </button>
                    <div class="nav-dropdown absolute top-full left-0 pt-2 w-64 z-50">
                        <div class="bg-white rounded-2xl p-2.5 shadow-xl border border-[#e6eeff] space-y-1">
                            <a href="{{ route('post.index') }}" class="flex items-center gap-3 px-3.5 py-3 rounded-xl hover:bg-[#eff4ff] text-[#2a382e] hover:text-[#004125] transition-colors {{ request()->routeIs('post.*') ? 'bg-[#eff4ff] text-[#004125] font-bold' : '' }}">
                                <span class="material-symbols-outlined text-[#0c5a37] text-[22px]">feed</span>
                                <div>
                                    <div class="text-sm font-bold">Warta / Berita</div>
                                    <div class="text-[11px] text-[#707971]">Kabar kegiatan terkini</div>
                                </div>
                            </a>
                            <a href="{{ route('event.index') }}" class="flex items-center gap-3 px-3.5 py-3 rounded-xl hover:bg-[#eff4ff] text-[#2a382e] hover:text-[#004125] transition-colors {{ request()->routeIs('event.index') ? 'bg-[#eff4ff] text-[#004125] font-bold' : '' }}">
                                <span class="material-symbols-outlined text-[#0c5a37] text-[22px]">event_available</span>
                                <div>
                                    <div class="text-sm font-bold">Agenda Mendatang</div>
                                    <div class="text-[11px] text-[#707971]">Jadwal pengajian & musyawarah</div>
                                </div>
                            </a>
                            <a href="{{ route('event.archive') }}" class="flex items-center gap-3 px-3.5 py-3 rounded-xl hover:bg-[#eff4ff] text-[#2a382e] hover:text-[#004125] transition-colors {{ request()->routeIs('event.archive') ? 'bg-[#eff4ff] text-[#004125] font-bold' : '' }}">
                                <span class="material-symbols-outlined text-[#0c5a37] text-[22px]">history_edu</span>
                                <div>
                                    <div class="text-sm font-bold">Arsip Agenda</div>
                                    <div class="text-[11px] text-[#707971]">Kegiatan yang telah terlaksana</div>
                                </div>
                            </a>
                            <a href="{{ route('galeri.index') }}" class="flex items-center gap-3 px-3.5 py-3 rounded-xl hover:bg-[#eff4ff] text-[#2a382e] hover:text-[#004125] transition-colors {{ request()->routeIs('galeri.*') ? 'bg-[#eff4ff] text-[#004125] font-bold' : '' }}">
                                <span class="material-symbols-outlined text-[#0c5a37] text-[22px]">photo_library</span>
                                <div>
                                    <div class="text-sm font-bold">Galeri Kegiatan</div>
                                    <div class="text-[11px] text-[#707971]">Dokumentasi foto kegiatan</div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- 4. Layanan ▾ -->
                <div class="relative nav-item group">
                    <button type="button" class="px-4 py-2.5 rounded-xl text-[15px] font-bold flex items-center gap-1.5 transition-all {{ request()->routeIs('kta.*') || request()->routeIs('aspirasi.*') || request()->routeIs('infaq.*') ? 'bg-[#004125] text-white shadow-sm' : 'text-[#2a382e] hover:text-[#004125] hover:bg-[#eff4ff]' }}" aria-haspopup="true">
                        <span>Layanan Warga</span>
                        <span class="material-symbols-outlined text-[20px] transition-transform duration-200 group-hover:rotate-180">expand_more</span>
                    </button>
                    <div class="nav-dropdown absolute top-full left-0 pt-2 w-64 z-50">
                        <div class="bg-white rounded-2xl p-2.5 shadow-xl border border-[#e6eeff] space-y-1">
                            <a href="{{ route('kta.verify.search') }}" class="flex items-center gap-3 px-3.5 py-3 rounded-xl hover:bg-[#eff4ff] text-[#2a382e] hover:text-[#004125] transition-colors {{ request()->routeIs('kta.*') ? 'bg-[#eff4ff] text-[#004125] font-bold' : '' }}">
                                <span class="material-symbols-outlined text-[#0c5a37] text-[22px]">badge</span>
                                <div>
                                    <div class="text-sm font-bold">Cek & Cetak KTA</div>
                                    <div class="text-[11px] text-[#707971]">Validasi & unduh kartu kader</div>
                                </div>
                            </a>
                            <a href="{{ route('aspirasi.create') }}" class="flex items-center gap-3 px-3.5 py-3 rounded-xl hover:bg-[#eff4ff] text-[#2a382e] hover:text-[#004125] transition-colors {{ request()->routeIs('aspirasi.*') ? 'bg-[#eff4ff] text-[#004125] font-bold' : '' }}">
                                <span class="material-symbols-outlined text-[#0c5a37] text-[22px]">campaign</span>
                                <div>
                                    <div class="text-sm font-bold">Kirim Aspirasi</div>
                                    <div class="text-[11px] text-[#707971]">Saran & usulan kemakmuran</div>
                                </div>
                            </a>
                            <a href="{{ route('infaq.index') }}" class="flex items-center gap-3 px-3.5 py-3 rounded-xl hover:bg-[#eff4ff] text-[#2a382e] hover:text-[#004125] transition-colors {{ request()->routeIs('infaq.*') ? 'bg-[#eff4ff] text-[#004125] font-bold' : '' }}">
                                <span class="material-symbols-outlined text-[#0c5a37] text-[22px]">volunteer_activism</span>
                                <div>
                                    <div class="text-sm font-bold">Infaq Online</div>
                                    <div class="text-[11px] text-[#707971]">Sedekah koin LAZISNU</div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </nav>

            <!-- Actions Right (Single prominent action, NO ADMIN PORTAL LINK) -->
            <div class="flex items-center gap-3">
                <a href="{{ route('aspirasi.create') }}" class="inline-flex items-center gap-2 bg-[#004125] hover:bg-[#0c5a37] text-white text-sm font-bold px-4 py-2.5 sm:px-5 sm:py-3 rounded-xl shadow-md transition-all hover:scale-[1.02]">
                    <span class="material-symbols-outlined text-[20px] text-[#fe932c]">campaign</span>
                    <span>Kirim Aspirasi</span>
                </a>

                <!-- Mobile Menu Hamburger Button -->
                <button type="button" id="mobileMenuBtn" aria-label="Buka Menu" class="lg:hidden p-2.5 rounded-xl bg-[#eff4ff] text-[#004125] hover:bg-[#dee9fc] transition-colors">
                    <span class="material-symbols-outlined text-[28px]" id="mobileMenuIcon">menu</span>
                </button>
            </div>
        </div>

        <!-- Mobile Drawer Accordion Menu (Lega, font besar, ramah orang tua) -->
        <div id="mobileMenu" class="hidden lg:hidden bg-white border-b border-[#e6eeff] px-4 py-5 space-y-3 max-h-[80vh] overflow-y-auto">
            <!-- Beranda -->
            <a href="{{ route('home') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl text-base font-bold text-[#121c2a] hover:bg-[#eff4ff] {{ request()->routeIs('home') ? 'bg-[#eff4ff] text-[#004125]' : '' }}">
                <span class="material-symbols-outlined text-[#004125]">home</span>
                <span>Beranda</span>
            </a>

            <!-- Accordion 1: Profil & Struktur -->
            <div class="border border-[#e6eeff] rounded-2xl overflow-hidden">
                <button type="button" onclick="toggleAccordion('acc-profil', this)" class="w-full flex items-center justify-between px-4 py-3.5 bg-[#f8f9ff] text-base font-bold text-[#121c2a] text-left">
                    <div class="flex items-center gap-3">
                        <span class="material-symbols-outlined text-[#004125]">account_balance</span>
                        <span>Profil & Struktur</span>
                    </div>
                    <span class="material-symbols-outlined text-[22px] transition-transform duration-200 acc-chevron">expand_more</span>
                </button>
                <div id="acc-profil" class="hidden bg-white px-3 py-2 space-y-1 border-t border-[#e6eeff]">
                    <a href="{{ route('profile') }}" class="block px-3 py-2.5 rounded-xl text-sm font-semibold text-[#404942] hover:bg-[#eff4ff]">Profil Organisasi</a>
                    <a href="{{ route('structure.index') }}" class="block px-3 py-2.5 rounded-xl text-sm font-semibold text-[#404942] hover:bg-[#eff4ff]">Struktur Pengurus Ranting</a>
                    <a href="{{ route('structure.index', ['tab' => 'banom']) }}" class="block px-3 py-2.5 rounded-xl text-sm font-semibold text-[#404942] hover:bg-[#eff4ff]">Badan Otonom (Banom)</a>
                </div>
            </div>

            <!-- Accordion 2: Informasi -->
            <div class="border border-[#e6eeff] rounded-2xl overflow-hidden">
                <button type="button" onclick="toggleAccordion('acc-info', this)" class="w-full flex items-center justify-between px-4 py-3.5 bg-[#f8f9ff] text-base font-bold text-[#121c2a] text-left">
                    <div class="flex items-center gap-3">
                        <span class="material-symbols-outlined text-[#004125]">feed</span>
                        <span>Informasi & Agenda</span>
                    </div>
                    <span class="material-symbols-outlined text-[22px] transition-transform duration-200 acc-chevron">expand_more</span>
                </button>
                <div id="acc-info" class="hidden bg-white px-3 py-2 space-y-1 border-t border-[#e6eeff]">
                    <a href="{{ route('post.index') }}" class="block px-3 py-2.5 rounded-xl text-sm font-semibold text-[#404942] hover:bg-[#eff4ff]">Warta / Berita</a>
                    <a href="{{ route('event.index') }}" class="block px-3 py-2.5 rounded-xl text-sm font-semibold text-[#404942] hover:bg-[#eff4ff]">Agenda Mendatang</a>
                    <a href="{{ route('event.archive') }}" class="block px-3 py-2.5 rounded-xl text-sm font-semibold text-[#404942] hover:bg-[#eff4ff]">Arsip Agenda Lampau</a>
                    <a href="{{ route('galeri.index') }}" class="block px-3 py-2.5 rounded-xl text-sm font-semibold text-[#404942] hover:bg-[#eff4ff]">Galeri Foto Kegiatan</a>
                </div>
            </div>

            <!-- Accordion 3: Layanan Warga -->
            <div class="border border-[#e6eeff] rounded-2xl overflow-hidden">
                <button type="button" onclick="toggleAccordion('acc-layanan', this)" class="w-full flex items-center justify-between px-4 py-3.5 bg-[#f8f9ff] text-base font-bold text-[#121c2a] text-left">
                    <div class="flex items-center gap-3">
                        <span class="material-symbols-outlined text-[#004125]">design_services</span>
                        <span>Layanan Warga</span>
                    </div>
                    <span class="material-symbols-outlined text-[22px] transition-transform duration-200 acc-chevron">expand_more</span>
                </button>
                <div id="acc-layanan" class="hidden bg-white px-3 py-2 space-y-1 border-t border-[#e6eeff]">
                    <a href="{{ route('kta.verify.search') }}" class="block px-3 py-2.5 rounded-xl text-sm font-semibold text-[#404942] hover:bg-[#eff4ff]">Cek & Cetak KTA</a>
                    <a href="{{ route('aspirasi.create') }}" class="block px-3 py-2.5 rounded-xl text-sm font-semibold text-[#404942] hover:bg-[#eff4ff]">Kirim Aspirasi & Masukan</a>
                    <a href="{{ route('infaq.index') }}" class="block px-3 py-2.5 rounded-xl text-sm font-semibold text-[#404942] hover:bg-[#eff4ff]">Infaq Online (LAZISNU)</a>
                </div>
            </div>
        </div>
    </header>

    <!-- Main Content Area -->
    <main class="flex-grow">
        @if (session('success'))
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-6">
                <div class="bg-emerald-50 border-2 border-emerald-300 text-emerald-900 px-5 py-4 rounded-2xl flex items-center gap-3.5 shadow-sm">
                    <span class="material-symbols-outlined text-emerald-600 text-[26px]">check_circle</span>
                    <span class="text-sm sm:text-base font-semibold">{{ session('success') }}</span>
                </div>
            </div>
        @endif

        @if (session('error'))
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-6">
                <div class="bg-red-50 border-2 border-red-300 text-red-900 px-5 py-4 rounded-2xl flex items-center gap-3.5 shadow-sm">
                    <span class="material-symbols-outlined text-red-600 text-[26px]">error</span>
                    <span class="text-sm sm:text-base font-semibold">{{ session('error') }}</span>
                </div>
            </div>
        @endif

        @yield('content')
    </main>

    <!-- Footer (Lega, rapi, ramah dibaca, TANPA link admin portal) -->
    <footer class="bg-[#002110] text-white pt-16 pb-10 border-t-4 border-[#fe932c] mt-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-12 gap-10 pb-12 border-b border-white/10">
                
                <!-- Col 1: Identity & Desc (5 cols) -->
                <div class="lg:col-span-5 space-y-4">
                    <div class="flex items-center gap-3.5">
                        <div class="w-13 h-13 rounded-2xl bg-[#0c5a37] flex items-center justify-center text-white shadow-lg">
                            <span class="material-symbols-outlined text-[30px] text-[#fe932c]">mosque</span>
                        </div>
                        <div>
                            <h3 class="text-xl font-extrabold text-white tracking-tight">NU Ranting Banjaranyar</h3>
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
                    <h4 class="text-sm font-bold text-[#ffdcc3] uppercase tracking-wider">Badan Otonom (BANOM)</h4>
                    <ul class="space-y-2 text-sm text-gray-300">
                        <li><a href="{{ route('structure.index', ['tab' => 'banom']) }}" class="hover:text-white hover:underline transition-colors flex items-center gap-2"><span class="w-2 h-2 rounded-full bg-[#047857]"></span>Muslimat NU</a></li>
                        <li><a href="{{ route('structure.index', ['tab' => 'banom']) }}" class="hover:text-white hover:underline transition-colors flex items-center gap-2"><span class="w-2 h-2 rounded-full bg-[#fe932c]"></span>GP Ansor (Pemuda)</a></li>
                        <li><a href="{{ route('structure.index', ['tab' => 'banom']) }}" class="hover:text-white hover:underline transition-colors flex items-center gap-2"><span class="w-2 h-2 rounded-full bg-[#059669]"></span>Fatayat NU (Pemudi)</a></li>
                        <li><a href="{{ route('structure.index', ['tab' => 'banom']) }}" class="hover:text-white hover:underline transition-colors flex items-center gap-2"><span class="w-2 h-2 rounded-full bg-[#0284c7]"></span>IPNU (Pelajar Putra)</a></li>
                        <li><a href="{{ route('structure.index', ['tab' => 'banom']) }}" class="hover:text-white hover:underline transition-colors flex items-center gap-2"><span class="w-2 h-2 rounded-full bg-[#10b981]"></span>IPPNU (Pelajar Putri)</a></li>
                        <li><a href="{{ route('structure.index', ['tab' => 'banom']) }}" class="hover:text-white hover:underline transition-colors flex items-center gap-2"><span class="w-2 h-2 rounded-full bg-[#dc2626]"></span>Satkorkel Banser</a></li>
                    </ul>
                </div>

                <!-- Col 3: Layanan & Informasi (2 cols) -->
                <div class="lg:col-span-2 space-y-3">
                    <h4 class="text-sm font-bold text-[#ffdcc3] uppercase tracking-wider">Layanan Ranting</h4>
                    <ul class="space-y-2 text-sm text-gray-300">
                        <li><a href="{{ route('profile') }}" class="hover:text-white transition-colors">Profil Organisasi</a></li>
                        <li><a href="{{ route('structure.index') }}" class="hover:text-white transition-colors">Struktur Pengurus</a></li>
                        <li><a href="{{ route('post.index') }}" class="hover:text-white transition-colors">Warta & Berita</a></li>
                        <li><a href="{{ route('event.index') }}" class="hover:text-white transition-colors">Agenda Pengajian</a></li>
                        <li><a href="{{ route('event.archive') }}" class="hover:text-white transition-colors">Arsip Agenda</a></li>
                        <li><a href="{{ route('galeri.index') }}" class="hover:text-white transition-colors">Galeri Kegiatan</a></li>
                        <li><a href="{{ route('kta.verify.search') }}" class="hover:text-white transition-colors">Cek & Cetak KTA</a></li>
                        <li><a href="{{ route('infaq.index') }}" class="hover:text-white transition-colors">Infaq Online</a></li>
                        <li><a href="{{ route('aspirasi.create') }}" class="hover:text-white transition-colors">Kirim Aspirasi</a></li>
                    </ul>
                </div>

                <!-- Col 4: Alamat & Kontak (2 cols) -->
                <div class="lg:col-span-2 space-y-3">
                    <h4 class="text-sm font-bold text-[#ffdcc3] uppercase tracking-wider">Sekretariat</h4>
                    <p class="text-xs text-gray-300 leading-relaxed">
                        Gedung Bersama PRNU Banjaranyar, Kec. Baureno, Kab. Bojonegoro, Jatim 62192
                    </p>
                    <p class="text-xs text-gray-300 flex items-center gap-1.5 pt-1">
                        <span class="material-symbols-outlined text-[16px] text-[#fe932c]">call</span>
                        <span>+62 812-3456-7890</span>
                    </p>
                    <p class="text-xs text-gray-300 flex items-center gap-1.5">
                        <span class="material-symbols-outlined text-[16px] text-[#fe932c]">mail</span>
                        <span>sekretariat@nu-banjaranyar.or.id</span>
                    </p>
                </div>

            </div>

            <!-- Bottom Copyright (NO ADMIN PORTAL LINK) -->
            <div class="pt-8 flex flex-col sm:flex-row items-center justify-between text-xs text-gray-400 gap-3">
                <p>&copy; {{ date('Y') }} Pengurus Ranting Nahdlatul Ulama Desa Banjaranyar. Khadim Ummah Design System.</p>
                <div class="flex items-center gap-4 text-emerald-300">
                    <span>Amanah, Transparan & Berdaya</span>
                </div>
            </div>
        </div>
    </footer>

    <!-- Global Micro-Interactions & Scroll Reveal Scripts -->
    <script>
        // Mobile Hamburger Toggle
        const mobileMenuBtn = document.getElementById('mobileMenuBtn');
        const mobileMenu = document.getElementById('mobileMenu');
        const mobileMenuIcon = document.getElementById('mobileMenuIcon');

        if (mobileMenuBtn && mobileMenu) {
            mobileMenuBtn.addEventListener('click', () => {
                const isHidden = mobileMenu.classList.toggle('hidden');
                mobileMenuIcon.textContent = isHidden ? 'menu' : 'close';
            });
        }

        // Mobile Accordion Toggle
        function toggleAccordion(id, btn) {
            const content = document.getElementById(id);
            const chevron = btn.querySelector('.acc-chevron');
            if (content) {
                const isHidden = content.classList.toggle('hidden');
                if (chevron) {
                    chevron.style.transform = isHidden ? 'rotate(0deg)' : 'rotate(180deg)';
                }
            }
        }

        // IntersectionObserver for Scroll-Reveal Animations
        document.addEventListener('DOMContentLoaded', () => {
            const prefersReducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
            if (prefersReducedMotion) return;

            const revealElements = document.querySelectorAll('.reveal');
            if ('IntersectionObserver' in window) {
                const observer = new IntersectionObserver((entries, obs) => {
                    entries.forEach(entry => {
                        if (entry.isIntersecting) {
                            entry.target.classList.add('is-visible');
                            obs.unobserve(entry.target);
                        }
                    });
                }, { threshold: 0.1, rootMargin: '0px 0px -40px 0px' });

                revealElements.forEach(el => observer.observe(el));
            } else {
                revealElements.forEach(el => el.classList.add('is-visible'));
            }
        });
    </script>

    @stack('scripts')
</body>
</html>
