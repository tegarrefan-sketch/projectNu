<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'SIMNU Portal — Admin PRNU Banjaranyar')</title>

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
        /* Mobile touch target minimum 44px & prevent auto-zoom on iOS */
        @media (max-width: 768px) {
            input, select, textarea {
                font-size: 16px !important;
            }
            button, a.btn, input[type="submit"] {
                min-height: 44px;
            }
        }
    </style>
    @stack('styles')
</head>
<body class="min-h-screen bg-[#f8f9ff] text-[#121c2a] flex antialiased overflow-x-hidden">

    <!-- Dark Backdrop Overlay for Mobile / Tablet Sidebar -->
    <div id="adminSidebarOverlay" onclick="closeAdminSidebar()" class="fixed inset-0 bg-black/60 backdrop-blur-xs z-40 hidden lg:hidden transition-opacity duration-300"></div>

    <!-- Sidebar: Fixed on lg+, Off-canvas sliding on mobile/tablet -->
    <aside id="adminSidebar" class="w-72 bg-white border-r border-[#e6eeff] fixed top-0 bottom-0 left-0 z-50 flex flex-col justify-between shadow-xl lg:shadow-sm overflow-y-auto transition-transform duration-300 -translate-x-full lg:translate-x-0">
        <div>
            <!-- Sidebar Header / Logo -->
            <div class="h-20 px-5 sm:px-6 flex items-center justify-between border-b border-[#e6eeff] bg-[#eff4ff]/50">
                <div class="flex items-center gap-3 min-w-0">
                    <div class="w-10 h-10 rounded-xl bg-[#004125] flex items-center justify-center text-white shadow-sm shrink-0">
                        <span class="material-symbols-outlined text-[24px]">verified_user</span>
                    </div>
                    <div class="flex flex-col min-w-0">
                        <span class="text-base font-extrabold text-[#004125] tracking-tight truncate leading-tight">SIMNU Portal</span>
                        <span class="text-xs text-[#404942] font-semibold truncate">PRNU Banjaranyar</span>
                    </div>
                </div>

                <!-- Close Sidebar Button (Mobile/Tablet Only) -->
                <button type="button" onclick="closeAdminSidebar()" class="lg:hidden p-2 rounded-xl text-gray-500 hover:text-gray-800 hover:bg-gray-100 transition shrink-0" aria-label="Tutup Menu">
                    <span class="material-symbols-outlined text-[22px]">close</span>
                </button>
            </div>

            <!-- Navigation Links -->
            <nav class="p-4 space-y-1">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-sm font-semibold transition-all {{ request()->routeIs('admin.dashboard') ? 'bg-[#0c5a37] text-white shadow-sm' : 'text-[#404942] hover:bg-[#eff4ff] hover:text-[#004125]' }}">
                    <span class="material-symbols-outlined text-[20px]">space_dashboard</span>
                    <span>Dashboard Utama</span>
                </a>

                <a href="{{ route('admin.profil.edit') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-sm font-semibold transition-all {{ request()->routeIs('admin.profil.*') ? 'bg-[#0c5a37] text-white shadow-sm' : 'text-[#404942] hover:bg-[#eff4ff] hover:text-[#004125]' }}">
                    <span class="material-symbols-outlined text-[20px]">corporate_fare</span>
                    <span>Profil Organisasi</span>
                </a>

                <div class="pt-2 pb-1">
                    <span class="px-3.5 text-[10px] font-bold text-[#707971] uppercase tracking-wider">Struktur Organisasi</span>
                </div>

                <a href="{{ route('admin.banoms.index') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-sm font-semibold transition-all {{ (request()->routeIs('admin.banoms.index') || request()->routeIs('admin.banoms.create') || request()->routeIs('admin.banoms.edit')) ? 'bg-[#0c5a37] text-white shadow-sm' : 'text-[#404942] hover:bg-[#eff4ff] hover:text-[#004125]' }}">
                    <span class="material-symbols-outlined text-[20px]">account_tree</span>
                    <span>Organisasi dan Banom</span>
                </a>

                <a href="{{ route('admin.positions.index') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-sm font-semibold transition-all {{ request()->routeIs('admin.positions.*') ? 'bg-[#0c5a37] text-white shadow-sm' : 'text-[#404942] hover:bg-[#eff4ff] hover:text-[#004125]' }}">
                    <span class="material-symbols-outlined text-[20px]">workspace_premium</span>
                    <span>Kelola Jabatan</span>
                </a>

                <a href="{{ route('admin.divisions.index') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-sm font-semibold transition-all {{ request()->routeIs('admin.divisions.*') ? 'bg-[#0c5a37] text-white shadow-sm' : 'text-[#404942] hover:bg-[#eff4ff] hover:text-[#004125]' }}">
                    <span class="material-symbols-outlined text-[20px]">category</span>
                    <span>Bagian (Bidang/Seksi)</span>
                </a>

                <a href="{{ route('admin.pengurus.index') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-sm font-semibold transition-all {{ (request()->routeIs('admin.pengurus.*') || request()->routeIs('admin.banoms.officers.*') || request()->routeIs('admin.struktur.*')) ? 'bg-[#0c5a37] text-white shadow-sm' : 'text-[#404942] hover:bg-[#eff4ff] hover:text-[#004125]' }}">
                    <span class="material-symbols-outlined text-[20px]">badge</span>
                    <span>Pengurus</span>
                </a>

                <a href="{{ route('admin.anggota.index') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-sm font-semibold transition-all {{ request()->routeIs('admin.anggota.*') ? 'bg-[#0c5a37] text-white shadow-sm' : 'text-[#404942] hover:bg-[#eff4ff] hover:text-[#004125]' }}">
                    <span class="material-symbols-outlined text-[20px]">groups</span>
                    <span>Anggota / Kader</span>
                </a>

                <a href="{{ route('admin.kta.index') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-sm font-semibold transition-all {{ request()->routeIs('admin.kta.*') ? 'bg-[#0c5a37] text-white shadow-sm' : 'text-[#404942] hover:bg-[#eff4ff] hover:text-[#004125]' }}">
                    <span class="material-symbols-outlined text-[20px]">id_card</span>
                    <span>KTA Digital & Cetak</span>
                </a>

                <div class="pt-2 pb-1">
                    <span class="px-3.5 text-[10px] font-bold text-[#707971] uppercase tracking-wider">Publikasi & Humas</span>
                </div>

                <a href="{{ route('admin.berita.index') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-sm font-semibold transition-all {{ request()->routeIs('admin.berita.*') ? 'bg-[#0c5a37] text-white shadow-sm' : 'text-[#404942] hover:bg-[#eff4ff] hover:text-[#004125]' }}">
                    <span class="material-symbols-outlined text-[20px]">newspaper</span>
                    <span>Warta & Berita</span>
                </a>

                <a href="{{ route('admin.agenda.index') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-sm font-semibold transition-all {{ request()->routeIs('admin.agenda.*') ? 'bg-[#0c5a37] text-white shadow-sm' : 'text-[#404942] hover:bg-[#eff4ff] hover:text-[#004125]' }}">
                    <span class="material-symbols-outlined text-[20px]">event_available</span>
                    <span>Agenda & Istighotsah</span>
                </a>

                <a href="{{ route('admin.galeri.index') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-sm font-semibold transition-all {{ request()->routeIs('admin.galeri.*') ? 'bg-[#0c5a37] text-white shadow-sm' : 'text-[#404942] hover:bg-[#eff4ff] hover:text-[#004125]' }}">
                    <span class="material-symbols-outlined text-[20px]">photo_library</span>
                    <span>Galeri Foto</span>
                </a>

                <a href="{{ route('admin.infaq.index') }}" class="flex items-center justify-between px-3.5 py-2.5 rounded-xl text-sm font-semibold transition-all {{ request()->routeIs('admin.infaq.*') ? 'bg-[#0c5a37] text-white shadow-sm' : 'text-[#404942] hover:bg-[#eff4ff] hover:text-[#004125]' }}">
                    <div class="flex items-center gap-3">
                        <span class="material-symbols-outlined text-[20px]">volunteer_activism</span>
                        <span>Infaq & ZISWAF</span>
                    </div>
                    @php
                        $pendingInfaq = \App\Models\Donation::where('status', 'Menunggu Verifikasi')->count();
                    @endphp
                    @if ($pendingInfaq > 0)
                        <span class="px-2 py-0.5 rounded-full text-xs font-bold bg-[#fe932c] text-[#663500]">{{ $pendingInfaq }}</span>
                    @endif
                </a>

                <a href="{{ route('admin.aspirasi.index') }}" class="flex items-center justify-between px-3.5 py-2.5 rounded-xl text-sm font-semibold transition-all {{ request()->routeIs('admin.aspirasi.*') ? 'bg-[#0c5a37] text-white shadow-sm' : 'text-[#404942] hover:bg-[#eff4ff] hover:text-[#004125]' }}">
                    <div class="flex items-center gap-3">
                        <span class="material-symbols-outlined text-[20px]">inbox</span>
                        <span>Kirim Aspirasi</span>
                    </div>
                    @php
                        $unreadCount = \App\Models\Aspiration::where('status', 'Baru')->count();
                    @endphp
                    @if ($unreadCount > 0)
                        <span class="px-2 py-0.5 rounded-full text-xs font-bold bg-[#fe932c] text-[#663500]">{{ $unreadCount }}</span>
                    @endif
                </a>

                <div class="pt-2 pb-1">
                    <span class="px-3.5 text-[10px] font-bold text-[#707971] uppercase tracking-wider">Sistem</span>
                </div>

                <a href="{{ route('admin.pengaturan.index') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-sm font-semibold transition-all {{ request()->routeIs('admin.pengaturan.*') ? 'bg-[#0c5a37] text-white shadow-sm' : 'text-[#404942] hover:bg-[#eff4ff] hover:text-[#004125]' }}">
                    <span class="material-symbols-outlined text-[20px]">settings</span>
                    <span>Pengaturan Akun</span>
                </a>
            </nav>
        </div>

        <!-- Sidebar Footer Status & Logout -->
        <div class="p-4 border-t border-[#e6eeff] space-y-2">
            <div class="bg-[#eff4ff] p-3 rounded-xl flex items-center justify-between">
                <div>
                    <span class="text-[11px] font-bold text-[#004125] block">Server Ranting</span>
                    <span class="text-[10px] text-[#404942]">SIMNU • Terhubung</span>
                </div>
                <span class="w-2.5 h-2.5 rounded-full bg-emerald-500 animate-pulse"></span>
            </div>

            <form action="{{ route('admin.logout') }}" method="POST" class="w-full">
                @csrf
                <button type="submit" class="w-full flex items-center justify-center gap-2 px-3 py-2 rounded-xl text-xs font-bold text-[#ba1a1a] hover:bg-[#ffdad6] transition-colors min-h-[44px]">
                    <span class="material-symbols-outlined text-[18px]">logout</span>
                    <span>Keluar Sistem</span>
                </button>
            </form>
        </div>
    </aside>

    <!-- Main Admin Content Area (pl-0 on mobile, pl-72 on lg+) -->
    <div class="flex-1 lg:pl-72 flex flex-col min-w-0 w-full overflow-x-hidden">

        <!-- Top Header Bar -->
        <header class="h-16 sm:h-20 bg-white/95 backdrop-blur-md border-b border-[#e6eeff] sticky top-0 z-30 px-4 sm:px-8 flex items-center justify-between gap-3 shadow-xs">
            <div class="flex items-center gap-3 min-w-0">
                <!-- Hamburger Button (Mobile & Tablet) -->
                <button type="button" id="adminHamburgerBtn" onclick="openAdminSidebar()" class="lg:hidden p-2 rounded-xl bg-gray-100 hover:bg-emerald-50 text-[#004125] transition flex items-center justify-center shrink-0 min-h-[44px] min-w-[44px]" aria-label="Buka Menu Navigasi">
                    <span class="material-symbols-outlined text-[24px]">menu</span>
                </button>

                <div class="min-w-0">
                    <span class="text-xs sm:text-sm font-bold text-[#004125] block truncate">PRNU Banjaranyar</span>
                    <span class="text-[10px] text-gray-500 hidden sm:block truncate">Konsol Administrasi Jam'iyyah</span>
                </div>
            </div>

            <div class="flex items-center gap-2 sm:gap-4 shrink-0">
                <!-- Notification Badges on Mobile & Desktop -->
                @php
                    $pendingTotal = ($pendingInfaq ?? 0) + ($unreadCount ?? 0);
                @endphp
                @if ($pendingTotal > 0)
                    <div class="flex items-center gap-1.5">
                        @if (($pendingInfaq ?? 0) > 0)
                            <a href="{{ route('admin.infaq.index') }}" class="p-1.5 sm:px-2.5 sm:py-1 rounded-xl bg-amber-50 border border-amber-200 text-amber-900 text-xs font-bold flex items-center gap-1" title="{{ $pendingInfaq }} Infaq perlu verifikasi">
                                <span class="material-symbols-outlined text-[18px] text-amber-700">volunteer_activism</span>
                                <span class="text-xs font-black">{{ $pendingInfaq }}</span>
                            </a>
                        @endif
                        @if (($unreadCount ?? 0) > 0)
                            <a href="{{ route('admin.aspirasi.index') }}" class="p-1.5 sm:px-2.5 sm:py-1 rounded-xl bg-rose-50 border border-rose-200 text-rose-900 text-xs font-bold flex items-center gap-1" title="{{ $unreadCount }} Aspirasi baru">
                                <span class="material-symbols-outlined text-[18px] text-rose-700">inbox</span>
                                <span class="text-xs font-black">{{ $unreadCount }}</span>
                            </a>
                        @endif
                    </div>
                @endif

                <a href="{{ route('home') }}" target="_blank" class="hidden md:inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-[#eff4ff] hover:bg-[#dee9fc] text-[#004125] text-xs font-semibold transition-colors">
                    <span class="material-symbols-outlined text-[16px]">open_in_new</span>
                    <span>Portal Publik</span>
                </a>

                <div class="hidden sm:flex items-center gap-1.5 px-2.5 py-1.5 rounded-lg bg-[#e6eeff] text-xs font-bold text-[#004125]">
                    <span class="material-symbols-outlined text-[16px] text-[#904d00]">calendar_month</span>
                    <span>1446 H</span>
                </div>

                <!-- User Profile & Quick Logout on Mobile -->
                <div class="flex items-center gap-2 sm:gap-3 border-l border-[#e6eeff] pl-2.5 sm:pl-4">
                    <div class="text-right hidden sm:block">
                        <span class="block text-xs font-bold text-[#121c2a] truncate max-w-[120px]">{{ Auth::user()->name ?? 'Admin PRNU' }}</span>
                        <span class="block text-[10px] text-[#404942]">Administrator</span>
                    </div>
                    <a href="{{ route('admin.pengaturan.index') }}" class="w-9 h-9 sm:w-10 sm:h-10 rounded-full bg-[#004125] hover:bg-[#0c5a37] flex items-center justify-center text-white font-bold text-sm shadow-sm transition shrink-0" title="Profil Akun: {{ Auth::user()->name ?? 'Admin' }}">
                        <span class="material-symbols-outlined text-[20px]">person</span>
                    </a>
                </div>
            </div>
        </header>

        <!-- Page Body Content: Responsive padding and flexible width -->
        <main class="p-3.5 sm:p-6 lg:p-8 flex-1 min-w-0 w-full overflow-x-hidden">
            @if (session('success'))
                <div class="mb-5 bg-emerald-50 border border-emerald-200 text-emerald-800 px-4 py-3 rounded-2xl flex items-center gap-3 shadow-xs">
                    <span class="material-symbols-outlined text-emerald-600 text-[22px] shrink-0">check_circle</span>
                    <span class="text-xs sm:text-sm font-semibold break-words flex-1">{{ session('success') }}</span>
                </div>
            @endif

            @if (session('info'))
                <div class="mb-5 bg-blue-50 border border-blue-200 text-blue-800 px-4 py-3 rounded-2xl flex items-center gap-3 shadow-xs">
                    <span class="material-symbols-outlined text-blue-600 text-[22px] shrink-0">info</span>
                    <span class="text-xs sm:text-sm font-semibold break-words flex-1">{{ session('info') }}</span>
                </div>
            @endif

            @if (session('error'))
                <div class="mb-5 bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-2xl flex items-center gap-3 shadow-xs">
                    <span class="material-symbols-outlined text-red-600 text-[22px] shrink-0">error</span>
                    <span class="text-xs sm:text-sm font-semibold break-words flex-1">{{ session('error') }}</span>
                </div>
            @endif

            @yield('content')
        </main>
    </div>

    <!-- Responsive Sidebar Scripts -->
    <script>
        function openAdminSidebar() {
            const sidebar = document.getElementById('adminSidebar');
            const overlay = document.getElementById('adminSidebarOverlay');
            if (sidebar) {
                sidebar.classList.remove('-translate-x-full');
                sidebar.classList.add('translate-x-0');
            }
            if (overlay) {
                overlay.classList.remove('hidden');
            }
            document.body.classList.add('overflow-hidden', 'lg:overflow-auto');
        }

        function closeAdminSidebar() {
            const sidebar = document.getElementById('adminSidebar');
            const overlay = document.getElementById('adminSidebarOverlay');
            if (sidebar) {
                sidebar.classList.add('-translate-x-full');
                sidebar.classList.remove('translate-x-0');
            }
            if (overlay) {
                overlay.classList.add('hidden');
            }
            document.body.classList.remove('overflow-hidden', 'lg:overflow-auto');
        }

        // Auto-close sidebar on link navigation on mobile devices
        document.addEventListener('DOMContentLoaded', function() {
            const links = document.querySelectorAll('#adminSidebar nav a');
            links.forEach(l => {
                l.addEventListener('click', function() {
                    if (window.innerWidth < 1024) {
                        closeAdminSidebar();
                    }
                });
            });
        });
    </script>
    @stack('scripts')
</body>
</html>
