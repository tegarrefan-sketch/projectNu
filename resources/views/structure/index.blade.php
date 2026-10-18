@extends('layouts.app')

@section('title', 'Struktur Organisasi & Badan Otonom — NU Ranting Banjaranyar')

@section('content')
<!-- Header Banner -->
<section class="bg-gradient-to-r from-[#004125] to-[#0c5a37] text-white py-14">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-4">
        <nav class="flex items-center gap-2 text-xs text-emerald-200">
            <a href="{{ route('home') }}" class="hover:underline flex items-center gap-1">
                <span class="material-symbols-outlined text-[14px]">home</span>
                <span>Beranda</span>
            </a>
            <span>/</span>
            <span class="text-white font-semibold">Struktur Organisasi</span>
        </nav>

        <div class="flex flex-col lg:flex-row lg:items-end justify-between gap-6 pt-2">
            <div class="space-y-2 max-w-2xl">
                <div class="inline-flex items-center gap-2 bg-white/10 px-3 py-1 rounded-full text-xs font-semibold text-[#aaf2c4]">
                    <span class="material-symbols-outlined text-[15px]">account_tree</span>
                    <span>Tata Kelola Aswaja & Badan Otonom</span>
                </div>
                <h1 class="text-3xl sm:text-4xl font-extrabold tracking-tight">Struktur Kepengurusan NU Banjaranyar</h1>
                <p class="text-xs sm:text-sm text-emerald-100 leading-relaxed">
                    Dwitunggal kepemimpinan Syuriyah (pengarah spiritual) dan Tanfidziyah (pelaksana program), serta jajaran pimpinan 6 Badan Otonom tingkat ranting.
                </p>
            </div>

            <!-- SK PCNU Box -->
            <div class="bg-white/10 backdrop-blur-md p-4 rounded-2xl border border-white/15 flex items-center justify-between gap-4 shrink-0">
                <div class="flex items-center gap-3">
                    <div class="w-11 h-11 rounded-xl bg-[#fe932c] text-[#2f1500] flex items-center justify-center font-bold shadow-md">
                        <span class="material-symbols-outlined text-[24px]">verified</span>
                    </div>
                    <div>
                        <span class="text-[11px] text-emerald-200 block font-medium">SK PCNU Bojonegoro</span>
                        <span class="text-xs sm:text-sm font-extrabold text-white">{{ $profile->sk_nomor ?? '184/A.II/PC/SK/VIII/2023' }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10 space-y-10">
    
    <!-- Unified 3 Main Tabs: 1) Pengurus Ranting, 2) Badan Otonom (BANOM), 3) Pengurus Pleno -->
    <div class="bg-white p-3 sm:p-4 rounded-3xl border border-[#e6eeff] shadow-sm flex flex-col md:flex-row md:items-center justify-between gap-4">
        
        <!-- Tab Buttons -->
        <div class="flex items-center gap-2 sm:gap-3 overflow-x-auto pb-1 md:pb-0">
            <!-- Tab 1: Pengurus Ranting -->
            <a href="{{ route('structure.index', ['tab' => 'ranting', 'q' => $search]) }}" class="px-5 py-3 rounded-2xl text-xs sm:text-sm font-black whitespace-nowrap transition-all flex items-center gap-2 {{ in_array($tab, ['ranting', 'syuriyah', 'tanfidziyah']) ? 'bg-[#004125] text-white shadow-md' : 'bg-[#eff4ff] text-[#404942] hover:bg-[#dee9fc]' }}">
                <span class="material-symbols-outlined text-[20px]">badge</span>
                <span>1. Pengurus Ranting</span>
            </a>

            <!-- Tab 2: Badan Otonom -->
            <a href="{{ route('structure.index', ['tab' => 'banom', 'q' => $search]) }}" class="px-5 py-3 rounded-2xl text-xs sm:text-sm font-black whitespace-nowrap transition-all flex items-center gap-2 {{ $tab === 'banom' ? 'bg-[#004125] text-white shadow-md' : 'bg-[#eff4ff] text-[#404942] hover:bg-[#dee9fc]' }}">
                <span class="material-symbols-outlined text-[20px]">diversity_3</span>
                <span>2. Badan Otonom (BANOM)</span>
            </a>

            <!-- Tab 3: Pengurus Pleno -->
            <a href="{{ route('structure.index', ['tab' => 'pleno', 'q' => $search]) }}" class="px-5 py-3 rounded-2xl text-xs sm:text-sm font-black whitespace-nowrap transition-all flex items-center gap-2 {{ $tab === 'pleno' ? 'bg-[#004125] text-white shadow-md' : 'bg-[#eff4ff] text-[#404942] hover:bg-[#dee9fc]' }}">
                <span class="material-symbols-outlined text-[20px]">groups_3</span>
                <span>3. Pengurus Pleno</span>
            </a>
        </div>

        @if ($tab !== 'banom')
            <!-- Search Form -->
            <form method="GET" action="{{ route('structure.index') }}" class="relative w-full md:w-72">
                <input type="hidden" name="tab" value="{{ $tab }}">
                <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-[18px]">search</span>
                <input type="text" name="q" value="{{ $search }}" placeholder="Cari nama pengurus..." class="w-full bg-[#f8f9ff] pl-9 pr-3 py-2.5 rounded-xl text-xs sm:text-sm text-[#121c2a] border border-[#e6eeff] focus:outline-none focus:border-[#004125] transition-colors">
            </form>
        @endif

    </div>

    @if ($tab === 'banom')
        <!-- ================= TAB 2: BADAN OTONOM (6 CARD, JARAK LEGA 32PX) ================= -->
        <div class="space-y-6">
            <div class="max-w-2xl space-y-1">
                <span class="text-xs font-bold text-[#904d00] uppercase tracking-wider block">Sayap Pergerakan & Kaderisasi</span>
                <h2 class="text-2xl sm:text-3xl font-extrabold text-[#004125] tracking-tight">Enam Badan Otonom (BANOM) Tingkat Ranting</h2>
                <p class="text-xs sm:text-sm text-[#526350] leading-relaxed">
                    Sayap pergerakan Nahdlatul Ulama Banjaranyar di berbagai kalangan usia dan pemuda-pemudi desa.
                </p>
            </div>

            <!-- Responsive Grid: 3 kolom desktop, 2 kolom tablet, 1 kolom mobile, gap besar 32px (gap-8) -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach ($banoms as $banom)
                    @php
                        $groupedOfficers = $banom->officers->groupBy(function($o) {
                            return $o->position->nama ?? 'Pengurus';
                        });
                        $modalId = 'officerModal_' . $banom->id;
                    @endphp
                    <div class="bg-white rounded-3xl overflow-hidden border-2 border-[#e6eeff] hover:border-[#0c5a37] shadow-sm hover:shadow-xl transition-all duration-300 flex flex-col justify-between card-hover">
                        <!-- Top Content -->
                        <div class="p-7 sm:p-8 space-y-5">
                            <div class="flex items-start justify-between gap-3">
                                <div class="w-16 h-16 rounded-2xl bg-[#eff4ff] border border-[#dee9fc] flex items-center justify-center p-2.5 shrink-0 shadow-inner">
                                    @if ($banom->logo)
                                        <img src="{{ asset('storage/' . $banom->logo) }}" alt="{{ $banom->singkatan }}" loading="lazy" class="w-full h-full object-contain">
                                    @else
                                        <span class="text-base font-black text-[#004125]">{{ $banom->singkatan }}</span>
                                    @endif
                                </div>

                                <div class="flex flex-col items-end gap-1">
                                    <span class="px-2.5 py-1 rounded-full text-[10px] font-extrabold bg-[#e6eeff] text-[#004125]">
                                        Banom #{{ $banom->urutan }}
                                    </span>
                                    @if($banom->rentang_usia)
                                        <span class="px-2 py-0.5 rounded-md text-[10px] font-bold bg-amber-50 text-amber-900 border border-amber-200">
                                            {{ $banom->rentang_usia }}
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="space-y-1.5">
                                <h3 class="text-xl font-black text-[#121c2a] leading-tight">{{ $banom->nama }}</h3>
                                <span class="text-xs font-extrabold text-[#0c5a37] block">Akronim: {{ $banom->singkatan }}</span>
                            </div>

                            <p class="text-xs text-[#526350] line-clamp-3 leading-relaxed">
                                {{ $banom->deskripsi ?: 'Organisasi sayap Nahdlatul Ulama yang berkhidmat di ranting Banjaranyar.' }}
                            </p>

                            <!-- Statistik Pengurus & Anggota -->
                            <div class="grid grid-cols-2 gap-3 py-3 px-4 rounded-2xl bg-[#f8f9ff] border border-[#e6eeff] text-center">
                                <div>
                                    <span class="text-[10px] font-bold text-[#707971] uppercase tracking-wider block">Pengurus</span>
                                    <span class="text-sm font-black text-[#004125]">{{ $banom->officers_count }} Personil</span>
                                </div>
                                <div>
                                    <span class="text-[10px] font-bold text-[#707971] uppercase tracking-wider block">Kader Terdata</span>
                                    <span class="text-sm font-black text-gray-800">{{ $banom->members_count }} Orang</span>
                                </div>
                            </div>

                            <!-- Preview Pimpinan Inti (Jika Ada) -->
                            @php
                                $ketuaOfficer = $banom->officers->first(function($o) {
                                    $namaPos = strtolower($o->position->nama ?? '');
                                    return str_contains($namaPos, 'ketua') || str_contains($namaPos, 'kasatkorkel') || str_contains($namaPos, 'kepala');
                                });
                            @endphp
                            @if($ketuaOfficer)
                                <div class="p-3 bg-emerald-50/70 border border-emerald-200 rounded-xl flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-lg bg-emerald-100 overflow-hidden shrink-0 flex items-center justify-center">
                                        @if($ketuaOfficer->display_foto)
                                            <img src="{{ $ketuaOfficer->display_foto }}" alt="{{ $ketuaOfficer->display_nama }}" loading="lazy" class="w-full h-full object-cover">
                                        @else
                                            <span class="material-symbols-outlined text-emerald-700 text-[20px]">person</span>
                                        @endif
                                    </div>
                                    <div class="min-w-0 flex-1">
                                        <span class="text-[10px] font-bold text-emerald-800 uppercase block leading-tight">{{ $ketuaOfficer->position->nama ?? 'Pimpinan' }}</span>
                                        <span class="text-xs font-black text-[#004125] truncate block leading-tight">{{ $ketuaOfficer->display_nama }}</span>
                                    </div>
                                </div>
                            @endif
                        </div>

                        <!-- Card Action Footer -->
                        <div class="p-6 bg-gradient-to-b from-transparent to-[#f8f9ff] border-t border-[#f2f4f8] flex items-center gap-2">
                            <button type="button" onclick="openOfficerModal('{{ $modalId }}')" class="flex-1 py-3 px-4 rounded-xl bg-[#0c5a37] hover:bg-[#004125] text-white text-xs font-extrabold flex items-center justify-center gap-1.5 shadow-sm transition">
                                <span class="material-symbols-outlined text-[18px]">groups</span>
                                <span>Lihat Profil & Pengurus Lengkap</span>
                            </button>
                        </div>
                    </div>

                    <!-- MODAL SUSUNAN PENGURUS LENGKAP -->
                    <div id="{{ $modalId }}" class="fixed inset-0 z-50 hidden bg-black/60 backdrop-blur-sm flex items-center justify-center p-4 overflow-y-auto">
                        <div class="bg-white w-full max-w-3xl max-h-[90vh] rounded-3xl shadow-2xl flex flex-col overflow-hidden animate-in fade-in zoom-in-95 duration-200">
                            <!-- Modal Header -->
                            <div class="px-6 sm:px-8 py-5 bg-gradient-to-r from-[#004125] to-[#0c5a37] text-white flex items-center justify-between">
                                <div class="flex items-center gap-3">
                                    <div class="w-12 h-12 rounded-2xl bg-white/10 border border-white/20 flex items-center justify-center p-2 shrink-0">
                                        @if($banom->logo)
                                            <img src="{{ asset('storage/' . $banom->logo) }}" alt="{{ $banom->singkatan }}" loading="lazy" class="w-full h-full object-contain">
                                        @else
                                            <span class="material-symbols-outlined text-2xl text-[#aaf2c4]">account_tree</span>
                                        @endif
                                    </div>
                                    <div>
                                        <h3 class="text-lg sm:text-xl font-black">Susunan Pengurus {{ $banom->singkatan }}</h3>
                                        <p class="text-xs text-emerald-200">{{ $banom->nama }}</p>
                                    </div>
                                </div>
                                <button type="button" onclick="closeOfficerModal('{{ $modalId }}')" class="w-10 h-10 rounded-xl bg-white/10 hover:bg-white/20 text-white flex items-center justify-center transition" aria-label="Tutup Modal">
                                    <span class="material-symbols-outlined text-2xl">close</span>
                                </button>
                            </div>

                            <!-- Modal Body -->
                            <div class="p-6 sm:p-8 overflow-y-auto space-y-6 max-h-[calc(90vh-140px)]">
                                @include('partials.banom_pyramid', ['officers' => $banom->officers, 'structures' => $banom->organizationStructures, 'banom' => $banom])
                            </div>

                            <!-- Modal Footer -->
                            <div class="p-4 bg-gray-50 border-t border-gray-100 flex items-center justify-between">
                                <a href="{{ route('banom.show', $banom->slug) }}" class="text-xs font-extrabold text-[#0c5a37] hover:underline flex items-center gap-1">
                                    <span>Buka Halaman Detail Profil</span>
                                    <span class="material-symbols-outlined text-[16px]">arrow_forward</span>
                                </a>

                                <button type="button" onclick="closeOfficerModal('{{ $modalId }}')" class="px-5 py-2.5 rounded-xl bg-[#0c5a37] text-white text-xs font-bold hover:bg-[#004125] transition">
                                    Tutup
                                </button>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

    @elseif ($tab === 'pleno')
        <!-- ================= TAB 3: PENGURUS PLENO RANTING ================= -->
        <div class="space-y-8">
            <div class="max-w-2xl space-y-1">
                <span class="text-xs font-bold text-[#904d00] uppercase tracking-wider block">Forum Keputusan Tertinggi Ranting</span>
                <h2 class="text-2xl sm:text-3xl font-extrabold text-[#004125] tracking-tight">Pengurus Pleno Ranting Banjaranyar</h2>
                <p class="text-xs sm:text-sm text-[#526350] leading-relaxed">
                    Pengurus Pleno menggabungkan Pengurus Lengkap Syuriyah, Pengurus Harian Tanfidziyah, dan seluruh Ketua Badan Otonom tingkat desa secara otomatis tanpa penginputan ganda.
                </p>
            </div>

            <!-- Bagian 1: Pengurus Lengkap Syuriyah -->
            <div class="bg-white rounded-3xl p-6 sm:p-8 border border-[#e6eeff] shadow-sm space-y-5">
                <div class="flex items-center gap-3 pb-4 border-b border-gray-100">
                    <span class="material-symbols-outlined text-[#004125] text-[24px]">verified_user</span>
                    <div>
                        <h3 class="text-lg font-black text-[#004125]">1. Pengurus Lengkap Syuriyah</h3>
                        <p class="text-xs text-[#707971]">Pengarah spiritual dan hukum Islam tertinggi di tingkat ranting (Rais, Katib, Wakil, dan A'wan).</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                    @forelse($plenoSyuriyah as $off)
                        <div class="p-4 rounded-2xl bg-[#f8f9ff] border border-[#dee9fc] flex items-center gap-3.5">
                            <div class="w-14 h-14 rounded-xl bg-gray-100 overflow-hidden flex items-center justify-center shrink-0 border border-gray-200">
                                @if($off->display_foto)
                                    <img src="{{ $off->display_foto }}" alt="{{ $off->display_nama }}" loading="lazy" class="w-full h-full object-cover">
                                @else
                                    <span class="material-symbols-outlined text-gray-400 text-[24px]">person</span>
                                @endif
                            </div>
                            <div class="min-w-0 flex-1">
                                <span class="text-[10px] font-extrabold text-emerald-800 bg-emerald-100 px-2 py-0.5 rounded uppercase block w-fit mb-1">
                                    {{ $off->position->nama ?? 'Syuriyah' }}
                                </span>
                                <h4 class="text-xs font-black text-[#121c2a] truncate">{{ $off->display_nama }}</h4>
                                <span class="text-[10px] text-gray-500">Unsur Syuriyah</span>
                            </div>
                        </div>
                    @empty
                        <div class="col-span-3 py-6 text-center text-gray-400 text-xs">
                            Belum ada pengurus Syuriyah terdata.
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- Bagian 2: Pengurus Harian Tanfidziyah -->
            <div class="bg-white rounded-3xl p-6 sm:p-8 border border-[#e6eeff] shadow-sm space-y-5">
                <div class="flex items-center gap-3 pb-4 border-b border-gray-100">
                    <span class="material-symbols-outlined text-[#004125] text-[24px]">engineering</span>
                    <div>
                        <h3 class="text-lg font-black text-[#004125]">2. Pengurus Harian Tanfidziyah</h3>
                        <p class="text-xs text-[#707971]">Pelaksana program kerja keummatan dan tata kelola organisasi (Ketua, Sekretaris, Bendahara, dan para Wakil).</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                    @forelse($plenoTanfidziyah as $off)
                        <div class="p-4 rounded-2xl bg-[#f8f9ff] border border-[#dee9fc] flex items-center gap-3.5">
                            <div class="w-14 h-14 rounded-xl bg-gray-100 overflow-hidden flex items-center justify-center shrink-0 border border-gray-200">
                                @if($off->display_foto)
                                    <img src="{{ $off->display_foto }}" alt="{{ $off->display_nama }}" loading="lazy" class="w-full h-full object-cover">
                                @else
                                    <span class="material-symbols-outlined text-gray-400 text-[24px]">person</span>
                                @endif
                            </div>
                            <div class="min-w-0 flex-1">
                                <span class="text-[10px] font-extrabold text-green-900 bg-green-100 px-2 py-0.5 rounded uppercase block w-fit mb-1">
                                    {{ $off->position->nama ?? 'Tanfidziyah' }}
                                </span>
                                <h4 class="text-xs font-black text-[#121c2a] truncate">{{ $off->display_nama }}</h4>
                                <span class="text-[10px] text-gray-500">Unsur Tanfidziyah</span>
                            </div>
                        </div>
                    @empty
                        <div class="col-span-3 py-6 text-center text-gray-400 text-xs">
                            Belum ada pengurus Tanfidziyah terdata.
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- Bagian 3: Seluruh Pimpinan / Ketua Badan Otonom -->
            <div class="bg-white rounded-3xl p-6 sm:p-8 border border-[#e6eeff] shadow-sm space-y-5">
                <div class="flex items-center gap-3 pb-4 border-b border-gray-100">
                    <span class="material-symbols-outlined text-[#004125] text-[24px]">military_tech</span>
                    <div>
                        <h3 class="text-lg font-black text-[#004125]">3. Seluruh Pimpinan / Ketua Badan Otonom</h3>
                        <p class="text-xs text-[#707971]">Perwakilan resmi dari seluruh 6 Badan Otonom NU di tingkat desa.</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                    @forelse($plenoKetuaBanom as $item)
                        @php
                            $b = $item['banom'];
                            $off = $item['officer'];
                        @endphp
                        <div class="p-4 rounded-2xl bg-[#f8f9ff] border border-[#dee9fc] flex items-center gap-3.5">
                            <div class="w-14 h-14 rounded-xl bg-gray-100 overflow-hidden flex items-center justify-center shrink-0 border border-gray-200">
                                @if($off->display_foto)
                                    <img src="{{ $off->display_foto }}" alt="{{ $off->display_nama }}" loading="lazy" class="w-full h-full object-cover">
                                @else
                                    <span class="material-symbols-outlined text-gray-400 text-[24px]">person</span>
                                @endif
                            </div>
                            <div class="min-w-0 flex-1">
                                <span class="text-[10px] font-black text-[#004125] bg-emerald-100 px-2 py-0.5 rounded uppercase block w-fit mb-1">
                                    {{ $b->singkatan }}
                                </span>
                                <h4 class="text-xs font-black text-[#121c2a] truncate">{{ $off->display_nama }}</h4>
                                <span class="text-[10px] text-gray-500 font-semibold">{{ $off->position->nama ?? 'Ketua' }} {{ $b->singkatan }}</span>
                            </div>
                        </div>
                    @empty
                        <div class="col-span-3 py-6 text-center text-gray-400 text-xs">
                            Belum ada ketua Badan Otonom yang terdaftar.
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

    @else
        <!-- ================= TAB 1: PENGURUS RANTING (MUSTASYAR, SYURIYAH, TANFIDZIYAH) ================= -->
        <div class="space-y-10">
            
            @if($prnuOfficers->isNotEmpty())
                <!-- A. MUSTASYAR (Dewan Penasihat) -->
                @if($mustasyarOfficers->isNotEmpty())
                    <div class="space-y-4">
                        <div class="flex items-center gap-2 pb-2 border-b border-gray-200">
                            <span class="material-symbols-outlined text-[#004125] text-[22px]">psychology</span>
                            <div>
                                <h2 class="text-xl font-black text-[#004125]">Mustasyar (Dewan Penasihat)</h2>
                                <p class="text-xs text-[#707971]">Para sesepuh dan alim ulama penasihat perkumpulan Nahdlatul Ulama Ranting Banjaranyar.</p>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            @foreach($mustasyarOfficers as $off)
                                <div class="bg-white rounded-3xl p-6 border border-[#e6eeff] shadow-sm hover:shadow-md transition-all flex items-start gap-4">
                                    <div class="w-16 h-16 rounded-2xl bg-amber-50 text-amber-900 flex items-center justify-center shrink-0 border border-amber-200 overflow-hidden">
                                        @if($off->display_foto)
                                            <img src="{{ $off->display_foto }}" alt="{{ $off->display_nama }}" loading="lazy" class="w-full h-full object-cover">
                                        @else
                                            <span class="material-symbols-outlined text-[32px]">person</span>
                                        @endif
                                    </div>
                                    <div class="space-y-1 min-w-0 flex-1">
                                        <span class="px-2 py-0.5 rounded text-[10px] font-extrabold bg-amber-100 text-amber-900 uppercase">
                                            {{ $off->position->nama ?? 'Mustasyar' }}
                                        </span>
                                        <h3 class="text-base font-black text-[#121c2a] leading-tight">{{ $off->display_nama }}</h3>
                                        <p class="text-xs text-[#707971]">Dewan Penasihat Ranting</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                <!-- B. SYURIYAH (Dewan Pengarah / Pemimpin Tertinggi) -->
                @if($syuriyahHarianOfficers->isNotEmpty() || $awanOfficers->isNotEmpty())
                    <div class="space-y-6">
                        <div class="flex items-center gap-2 pb-2 border-b border-gray-200">
                            <span class="material-symbols-outlined text-[#004125] text-[22px]">verified_user</span>
                            <div>
                                <h2 class="text-xl font-black text-[#004125]">Syuriyah (Dewan Pengarah / Pemimpin Tertinggi)</h2>
                                <p class="text-xs text-[#707971]">Pemimpin tertinggi spiritual, penentu kebijakan keagamaan, dan penjaga akidah Ahlussunnah wal Jama'ah.</p>
                            </div>
                        </div>

                        <!-- 1. Pengurus Harian Syuriyah: Rais, Wakil Rais, Katib, Wakil Katib -->
                        @if($syuriyahHarianOfficers->isNotEmpty())
                            <div class="space-y-3">
                                <span class="text-xs font-black text-[#004125] uppercase tracking-wider block bg-emerald-50 px-3 py-1.5 rounded-lg border border-emerald-200 w-fit">
                                    Pengurus Harian Syuriyah
                                </span>
                                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                                    @foreach($syuriyahHarianOfficers as $off)
                                        <div class="bg-white rounded-3xl p-6 border-2 border-emerald-100 shadow-sm hover:shadow-md transition-all flex items-start gap-4">
                                            <div class="w-16 h-16 rounded-2xl bg-emerald-50 text-[#004125] flex items-center justify-center shrink-0 border border-emerald-200 overflow-hidden">
                                                @if($off->display_foto)
                                                    <img src="{{ $off->display_foto }}" alt="{{ $off->display_nama }}" loading="lazy" class="w-full h-full object-cover">
                                                @else
                                                    <span class="material-symbols-outlined text-[32px]">person</span>
                                                @endif
                                            </div>
                                            <div class="space-y-1 min-w-0 flex-1">
                                                <span class="px-2 py-0.5 rounded text-[10px] font-extrabold bg-[#aaf2c4] text-[#002110] uppercase">
                                                    {{ $off->position->nama ?? 'Syuriyah' }}
                                                </span>
                                                <h3 class="text-base font-black text-[#121c2a] leading-tight">{{ $off->display_nama }}</h3>
                                                <p class="text-xs text-[#0c5a37] font-bold">{{ $off->position->keterangan ?? 'Pengurus Harian Syuriyah' }}</p>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        <!-- 2. Pengurus Lengkap Syuriyah: A'wan -->
                        @if($awanOfficers->isNotEmpty())
                            <div class="space-y-3 pt-2">
                                <span class="text-xs font-black text-gray-700 uppercase tracking-wider block bg-gray-100 px-3 py-1.5 rounded-lg border border-gray-200 w-fit">
                                    Pengurus Lengkap Syuriyah (A'wan)
                                </span>
                                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                                    @foreach($awanOfficers as $off)
                                        <div class="bg-white rounded-2xl p-4 border border-[#e6eeff] flex items-center gap-3 shadow-xs">
                                            <div class="w-12 h-12 rounded-xl bg-gray-100 overflow-hidden flex items-center justify-center shrink-0">
                                                @if($off->display_foto)
                                                    <img src="{{ $off->display_foto }}" alt="{{ $off->display_nama }}" loading="lazy" class="w-full h-full object-cover">
                                                @else
                                                    <span class="material-symbols-outlined text-gray-400">person</span>
                                                @endif
                                            </div>
                                            <div class="min-w-0 flex-1">
                                                <h4 class="text-xs font-black text-[#121c2a] truncate">{{ $off->display_nama }}</h4>
                                                <span class="text-[10px] text-gray-500 font-semibold">A'wan Syuriyah</span>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    </div>
                @endif

                <!-- C. TANFIDZIYAH (Pengurus Harian / Pelaksana) -->
                @if($tanfidziyahOfficers->isNotEmpty())
                    <div class="space-y-4">
                        <div class="flex items-center gap-2 pb-2 border-b border-gray-200">
                            <span class="material-symbols-outlined text-[#004125] text-[22px]">engineering</span>
                            <div>
                                <h2 class="text-xl font-black text-[#004125]">Tanfidziyah (Pengurus Harian / Pelaksana)</h2>
                                <p class="text-xs text-[#707971]">Pelaksana program kerja harian, tata kelola keorganisasian, dan pelayanan keummatan desa.</p>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            @foreach($tanfidziyahOfficers as $off)
                                <div class="bg-white rounded-3xl p-6 border-2 border-[#dee9fc] shadow-sm hover:shadow-md transition-all flex items-start gap-4">
                                    <div class="w-16 h-16 rounded-2xl bg-[#eff4ff] text-[#004125] flex items-center justify-center shrink-0 border border-[#dee9fc] overflow-hidden">
                                        @if($off->display_foto)
                                            <img src="{{ $off->display_foto }}" alt="{{ $off->display_nama }}" loading="lazy" class="w-full h-full object-cover">
                                        @else
                                            <span class="material-symbols-outlined text-[32px]">person</span>
                                        @endif
                                    </div>
                                    <div class="space-y-1 min-w-0 flex-1">
                                        <span class="px-2 py-0.5 rounded text-[10px] font-extrabold bg-[#ffdcc3] text-[#2f1500] uppercase">
                                            {{ $off->position->nama ?? 'Tanfidziyah' }}
                                            @if($off->urutan_wakil)
                                                Ke-{{ $off->urutan_wakil }}
                                            @endif
                                        </span>
                                        <h3 class="text-base font-black text-[#121c2a] leading-tight">{{ $off->display_nama }}</h3>
                                        <p class="text-xs text-[#526350]">{{ $off->position->keterangan ?? 'Pengurus Harian Tanfidziyah' }}</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

            @else
                <!-- Fallback to Legacy Structures if Any -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @forelse ($legacyStructures as $item)
                        <div class="bg-white rounded-3xl p-6 border border-[#e6eeff] shadow-sm hover:shadow-lg transition-all flex items-start gap-5">
                            <div class="w-16 h-16 rounded-2xl bg-[#eff4ff] text-[#004125] flex items-center justify-center shrink-0 border-2 border-[#dee9fc] overflow-hidden">
                                @if ($item->foto)
                                    <img src="{{ asset('storage/' . $item->foto) }}" alt="{{ $item->nama }}" loading="lazy" class="w-full h-full object-cover">
                                @else
                                    <span class="material-symbols-outlined text-[36px]">person</span>
                                @endif
                            </div>
                            <div class="space-y-1 min-w-0 flex-1">
                                <span class="px-2.5 py-0.5 rounded-full text-[10px] font-extrabold bg-[#aaf2c4] text-[#002110]">
                                    {{ ucfirst($item->kategori_hierarki) }}
                                </span>
                                <h3 class="text-base font-black text-[#121c2a] leading-tight truncate">{{ $item->nama }}</h3>
                                <p class="text-xs font-extrabold text-[#0c5a37]">{{ $item->jabatan }}</p>
                            </div>
                        </div>
                    @empty
                        <div class="col-span-3 p-12 text-center bg-white rounded-3xl border border-[#e6eeff] text-sm text-[#404942]">
                            Belum ada data struktur pengurus yang terdata.
                        </div>
                    @endforelse
                </div>
            @endif

        </div>
    @endif

</div>

@push('scripts')
<script>
    function openOfficerModal(id) {
        const modal = document.getElementById(id);
        if (modal) {
            modal.classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }
    }

    function closeOfficerModal(id) {
        const modal = document.getElementById(id);
        if (modal) {
            modal.classList.add('hidden');
            document.body.style.overflow = '';
        }
    }
</script>
@endpush
@endsection
