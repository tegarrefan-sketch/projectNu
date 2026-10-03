<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
    </style>
    @stack('styles')
</head>
<body class="min-h-screen bg-[#f8f9ff] text-[#121c2a] flex antialiased">

    <!-- Desktop Sidebar (w-72 fixed) -->
    <aside class="w-72 bg-white border-r border-[#e6eeff] fixed top-0 bottom-0 left-0 z-50 flex flex-col justify-between shadow-sm overflow-y-auto">
        <div>
            <!-- Sidebar Header / Logo -->
            <div class="h-20 px-6 flex items-center gap-3 border-b border-[#e6eeff] bg-[#eff4ff]/50">
                <div class="w-10 h-10 rounded-xl bg-[#004125] flex items-center justify-center text-white shadow-sm shrink-0">
                    <span class="material-symbols-outlined text-[24px]">verified_user</span>
                </div>
                <div class="flex flex-col min-w-0">
                    <span class="text-base font-extrabold text-[#004125] tracking-tight truncate leading-tight">SIMNU Portal</span>
                    <span class="text-xs text-[#404942] font-semibold truncate">PRNU Banjaranyar</span>
                </div>
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

                <a href="{{ route('admin.banom.index') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-sm font-semibold transition-all {{ request()->routeIs('admin.banom.*') ? 'bg-[#0c5a37] text-white shadow-sm' : 'text-[#404942] hover:bg-[#eff4ff] hover:text-[#004125]' }}">
                    <span class="material-symbols-outlined text-[20px]">account_tree</span>
                    <span>5 Badan Otonom</span>
                </a>

                <a href="{{ route('admin.struktur.index') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-sm font-semibold transition-all {{ request()->routeIs('admin.struktur.*') ? 'bg-[#0c5a37] text-white shadow-sm' : 'text-[#404942] hover:bg-[#eff4ff] hover:text-[#004125]' }}">
                    <span class="material-symbols-outlined text-[20px]">badge</span>
                    <span>Struktur Pengurus</span>
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

                <a href="{{ route('admin.aspirasi.index') }}" class="flex items-center justify-between px-3.5 py-2.5 rounded-xl text-sm font-semibold transition-all {{ request()->routeIs('admin.aspirasi.*') ? 'bg-[#0c5a37] text-white shadow-sm' : 'text-[#404942] hover:bg-[#eff4ff] hover:text-[#004125]' }}">
                    <div class="flex items-center gap-3">
                        <span class="material-symbols-outlined text-[20px]">inbox</span>
                        <span>Kotak Aspirasi</span>
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
                    <span class="text-[10px] text-[#404942]">SIMNU v2.4 • Online</span>
                </div>
                <span class="w-2.5 h-2.5 rounded-full bg-emerald-500 animate-pulse"></span>
            </div>

            <form action="{{ route('admin.logout') }}" method="POST" class="w-full">
                @csrf
                <button type="submit" class="w-full flex items-center justify-center gap-2 px-3 py-2 rounded-xl text-xs font-bold text-[#ba1a1a] hover:bg-[#ffdad6] transition-colors">
                    <span class="material-symbols-outlined text-[18px]">logout</span>
                    <span>Keluar Sistem</span>
                </button>
            </form>
        </div>
    </aside>

    <!-- Main Admin Content Area (pl-72) -->
    <div class="flex-1 lg:pl-72 flex flex-col min-w-0">

        <!-- Top Header Bar -->
        <header class="h-20 bg-white/90 backdrop-blur-md border-b border-[#e6eeff] sticky top-0 z-40 px-6 sm:px-8 flex items-center justify-between gap-4">
            <div class="flex items-center gap-3">
                <span class="text-sm font-semibold text-[#404942] hidden sm:inline">Konsol Administrasi PRNU Banjaranyar</span>
            </div>

            <div class="flex items-center gap-4">
                <a href="{{ route('home') }}" target="_blank" class="hidden sm:inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-[#eff4ff] hover:bg-[#dee9fc] text-[#004125] text-xs font-semibold transition-colors">
                    <span class="material-symbols-outlined text-[16px]">open_in_new</span>
                    <span>Lihat Portal Publik</span>
                </a>

                <div class="flex items-center gap-2 px-3 py-1.5 rounded-lg bg-[#e6eeff] text-xs font-bold text-[#004125]">
                    <span class="material-symbols-outlined text-[16px] text-[#904d00]">calendar_month</span>
                    <span>1446 H / 2025 M</span>
                </div>

                <div class="flex items-center gap-3 border-l border-[#e6eeff] pl-4">
                    <div class="text-right hidden md:block">
                        <span class="block text-xs font-bold text-[#121c2a]">{{ Auth::user()->name ?? 'Admin PRNU' }}</span>
                        <span class="block text-[10px] text-[#404942]">Sekretariat Ranting</span>
                    </div>
                    <div class="w-9 h-9 rounded-full bg-[#004125] flex items-center justify-center text-white font-bold text-sm shadow-sm">
                        <span class="material-symbols-outlined text-[20px]">person</span>
                    </div>
                </div>
            </div>
        </header>

        <!-- Page Body Content -->
        <main class="p-6 sm:p-8 flex-1">
            @if (session('success'))
                <div class="mb-6 bg-emerald-50 border border-emerald-200 text-emerald-800 px-4 py-3 rounded-xl flex items-center gap-3 shadow-sm">
                    <span class="material-symbols-outlined text-emerald-600 text-[22px]">check_circle</span>
                    <span class="text-sm font-semibold">{{ session('success') }}</span>
                </div>
            @endif

            @if (session('info'))
                <div class="mb-6 bg-blue-50 border border-blue-200 text-blue-800 px-4 py-3 rounded-xl flex items-center gap-3 shadow-sm">
                    <span class="material-symbols-outlined text-blue-600 text-[22px]">info</span>
                    <span class="text-sm font-semibold">{{ session('info') }}</span>
                </div>
            @endif

            @if (session('error'))
                <div class="mb-6 bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-xl flex items-center gap-3 shadow-sm">
                    <span class="material-symbols-outlined text-red-600 text-[22px]">error</span>
                    <span class="text-sm font-semibold">{{ session('error') }}</span>
                </div>
            @endif

            @yield('content')
        </main>
    </div>

    @stack('scripts')
</body>
</html>
