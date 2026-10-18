@extends('layouts.app')

@section('title', 'Arsip Agenda & Kegiatan Lampau — NU Ranting Banjaranyar')

@section('content')
<!-- Header Banner -->
<section class="bg-gradient-to-r from-[#003820] to-[#004125] text-white py-14">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-4">
        <nav class="flex items-center gap-2 text-xs text-emerald-200">
            <a href="{{ route('home') }}" class="hover:underline flex items-center gap-1">
                <span class="material-symbols-outlined text-[14px]">home</span>
                <span>Beranda</span>
            </a>
            <span>/</span>
            <a href="{{ route('event.index') }}" class="hover:underline">Agenda</a>
            <span>/</span>
            <span class="text-white font-semibold">Arsip Agenda Lampau</span>
        </nav>

        <div class="flex flex-col lg:flex-row lg:items-end justify-between gap-6 pt-2">
            <div class="space-y-2 max-w-2xl">
                <div class="inline-flex items-center gap-2 bg-white/10 px-3 py-1 rounded-full text-xs font-semibold text-[#aaf2c4]">
                    <span class="material-symbols-outlined text-[15px]">history_edu</span>
                    <span>Dokumentasi Jejak Khidmah Jam'iyyah</span>
                </div>
                <h1 class="text-3xl sm:text-4xl font-extrabold tracking-tight">Arsip Kegiatan yang Telah Terlaksana</h1>
                <p class="text-xs sm:text-sm text-emerald-100 leading-relaxed">
                    Kumpulan agenda, musyawarah, dan majelis pengajian ranting yang telah selesai diselenggarakan di Desa Banjaranyar.
                </p>
            </div>

            <!-- Back to Active Events Button -->
            <a href="{{ route('event.index') }}" class="inline-flex items-center gap-2 px-5 py-3 rounded-2xl bg-white text-[#004125] font-black text-xs sm:text-sm shadow-md hover:bg-emerald-50 transition-all shrink-0">
                <span class="material-symbols-outlined text-[18px]">event_available</span>
                <span>Kembali ke Agenda Aktif</span>
            </a>
        </div>
    </div>
</section>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10 space-y-8">
    
    <!-- Filter and Search Bar Card -->
    <div class="bg-white p-5 sm:p-6 rounded-3xl border border-[#e6eeff] shadow-sm space-y-4">
        <form method="GET" action="{{ route('event.archive') }}" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-12 gap-3.5 items-end">
            <!-- Search Text (4 cols) -->
            <div class="lg:col-span-4">
                <label for="search_q" class="block text-xs font-bold text-[#121c2a] mb-1">Cari Kegiatan / Lokasi</label>
                <div class="relative">
                    <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-[18px]">search</span>
                    <input type="text" id="search_q" name="q" value="{{ $search }}" placeholder="Ketik kata kunci..." class="w-full bg-[#f8f9ff] pl-9 pr-3 py-2.5 rounded-xl text-xs sm:text-sm border border-[#dee9fc] focus:bg-white focus:outline-none focus:border-[#004125] transition-all">
                </div>
            </div>

            <!-- Filter Bulan (3 cols) -->
            <div class="lg:col-span-3">
                <label for="filter_bulan" class="block text-xs font-bold text-[#121c2a] mb-1">Pilih Bulan</label>
                <select id="filter_bulan" name="bulan" class="w-full bg-[#f8f9ff] px-3 py-2.5 rounded-xl text-xs sm:text-sm border border-[#dee9fc] focus:bg-white focus:outline-none focus:border-[#004125] transition-all">
                    <option value="">Semua Bulan</option>
                    @for ($m = 1; $m <= 12; $m++)
                        @php
                            $monthName = \Carbon\Carbon::create(2026, $m, 1)->translatedFormat('F');
                        @endphp
                        <option value="{{ $m }}" {{ (string)$bulan === (string)$m ? 'selected' : '' }}>
                            {{ $monthName }}
                        </option>
                    @endfor
                </select>
            </div>

            <!-- Filter Tahun (2 cols) -->
            <div class="lg:col-span-2">
                <label for="filter_tahun" class="block text-xs font-bold text-[#121c2a] mb-1">Pilih Tahun</label>
                <select id="filter_tahun" name="tahun" class="w-full bg-[#f8f9ff] px-3 py-2.5 rounded-xl text-xs sm:text-sm border border-[#dee9fc] focus:bg-white focus:outline-none focus:border-[#004125] transition-all">
                    <option value="">Semua Tahun</option>
                    @foreach ($availableYears as $yr)
                        <option value="{{ $yr }}" {{ (string)$tahun === (string)$yr ? 'selected' : '' }}>
                            {{ $yr }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Actions (3 cols) -->
            <div class="lg:col-span-3 flex items-center gap-2">
                <button type="submit" class="flex-1 px-4 py-2.5 rounded-xl bg-[#004125] hover:bg-[#0c5a37] text-white font-bold text-xs sm:text-sm transition-colors shadow-sm flex items-center justify-center gap-1.5">
                    <span class="material-symbols-outlined text-[18px]">filter_alt</span>
                    <span>Terapkan Filter</span>
                </button>
                @if ($search || $bulan || $tahun || $banomSlug)
                    <a href="{{ route('event.archive') }}" class="px-3 py-2.5 rounded-xl border border-gray-300 hover:bg-gray-100 text-gray-700 text-xs font-bold transition" title="Reset Filter">
                        <span class="material-symbols-outlined text-[18px]">refresh</span>
                    </a>
                @endif
            </div>
        </form>

        <!-- Banom Chips inside Archive -->
        <div class="flex items-center gap-2 overflow-x-auto pt-2 border-t border-[#eff4ff]">
            <a href="{{ route('event.archive', ['q' => $search, 'bulan' => $bulan, 'tahun' => $tahun]) }}" class="px-3 py-1.5 rounded-lg text-xs font-bold whitespace-nowrap {{ empty($banomSlug) ? 'bg-[#004125] text-white' : 'bg-[#eff4ff] text-[#404942] hover:bg-[#dee9fc]' }}">
                Semua BANOM
            </a>
            @foreach ($banoms as $b)
                <a href="{{ route('event.archive', ['banom' => $b->slug, 'q' => $search, 'bulan' => $bulan, 'tahun' => $tahun]) }}" class="px-3 py-1.5 rounded-lg text-xs font-bold whitespace-nowrap {{ $banomSlug === $b->slug ? 'bg-[#004125] text-white' : 'bg-[#eff4ff] text-[#404942] hover:bg-[#dee9fc]' }}">
                    {{ $b->singkatan }}
                </a>
            @endforeach
        </div>
    </div>

    <!-- Past Events Cards -->
    <div class="space-y-6">
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-2">
                <span class="w-3 h-7 rounded-full bg-gray-400"></span>
                <h2 class="text-xl sm:text-2xl font-black text-[#121c2a]">Riwayat Kegiatan Lampau</h2>
            </div>
            <span class="text-xs font-semibold text-[#526350]">Ditemukan {{ $events->total() }} catatan</span>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            @forelse ($events as $event)
                <div class="bg-white rounded-3xl p-5 border border-[#e6eeff] hover:border-gray-400 transition-all shadow-sm flex flex-col justify-between card-hover">
                    <div class="space-y-3">
                        <div class="flex items-center justify-between">
                            <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-gray-100 text-gray-700">
                                {{ $event->banom ? $event->banom->singkatan : 'PRNU Induk' }}
                            </span>
                            <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-amber-50 text-amber-800 border border-amber-200">
                                Terlaksana
                            </span>
                        </div>

                        <div>
                            <span class="text-xs font-bold text-[#004125] block">
                                {{ $event->tanggal->translatedFormat('l, d F Y') }}
                            </span>
                            <h3 class="text-base font-bold text-[#121c2a] mt-1 line-clamp-2 leading-snug">
                                <a href="{{ route('event.show', $event->slug) }}" class="hover:text-[#004125] transition-colors">
                                    {{ $event->title }}
                                </a>
                            </h3>
                            <p class="text-xs text-[#526350] flex items-center gap-1 mt-2">
                                <span class="material-symbols-outlined text-[14px] text-gray-400">location_on</span>
                                <span class="truncate">{{ $event->lokasi ?? 'Banjaranyar' }}</span>
                            </p>
                        </div>
                    </div>

                    <div class="pt-4 mt-3 border-t border-[#eff4ff] flex items-center justify-between">
                        <span class="text-[11px] text-gray-400">Arsip Dokumentasi</span>
                        <a href="{{ route('event.show', $event->slug) }}" class="text-xs font-bold text-[#0c5a37] hover:underline flex items-center gap-1">
                            <span>Rincian</span>
                            <span class="material-symbols-outlined text-[14px]">arrow_forward</span>
                        </a>
                    </div>
                </div>
            @empty
                <div class="col-span-4 p-12 text-center bg-white rounded-3xl border border-[#e6eeff] space-y-2">
                    <span class="material-symbols-outlined text-gray-400 text-5xl">folder_off</span>
                    <h3 class="text-base font-bold text-[#121c2a]">Tidak Ada Arsip yang Sesuai</h3>
                    <p class="text-xs text-[#526350]">Coba atur ulang kata kunci pencarian, bulan, atau tahun yang Anda pilih.</p>
                </div>
            @endforelse
        </div>

        <div class="pt-4">
            {{ $events->links() }}
        </div>
    </div>

</div>
@endsection
