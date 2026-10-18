@extends('layouts.app')

@section('title', 'Agenda Kegiatan — NU Ranting Banjaranyar')

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
            <span class="text-white font-semibold">Agenda Kegiatan</span>
        </nav>

        <div class="flex flex-col lg:flex-row lg:items-end justify-between gap-6 pt-2">
            <div class="space-y-2 max-w-2xl">
                <div class="inline-flex items-center gap-2 bg-white/10 px-3 py-1 rounded-full text-xs font-semibold text-[#aaf2c4]">
                    <span class="material-symbols-outlined text-[15px]">event</span>
                    <span>Kalender Amaliyah & Pengajian</span>
                </div>
                <h1 class="text-3xl sm:text-4xl font-extrabold tracking-tight">Jadwal Agenda Aktif & Mendatang</h1>
                <p class="text-xs sm:text-sm text-emerald-100 leading-relaxed">
                    Informasi jadwal pengajian rutin selapanan, istighotsah, rapat pleno, dan agenda badan otonom yang akan segera berlangsung.
                </p>
            </div>

            <!-- Search Form in Header -->
            <form method="GET" action="{{ route('event.index') }}" class="w-full lg:w-80">
                <div class="relative">
                    <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-[18px]">search</span>
                    <input type="text" name="q" value="{{ $search }}" placeholder="Cari nama agenda atau lokasi..." class="w-full bg-white/10 text-white placeholder-emerald-200/60 pl-9 pr-4 py-2.5 rounded-xl text-xs sm:text-sm border border-white/20 focus:outline-none focus:bg-white/20 transition-all">
                </div>
            </form>
        </div>
    </div>
</section>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10 space-y-8">
    
    <!-- Filter Chips & Archive Shortcut Banner -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <!-- Filter Chips -->
        <div class="flex items-center gap-2 overflow-x-auto pb-1 bg-white p-3 rounded-2xl border border-[#e6eeff] shadow-sm">
            <a href="{{ route('event.index', ['q' => $search]) }}" class="px-4 py-2 rounded-xl text-xs font-bold whitespace-nowrap transition-all {{ empty($banomSlug) ? 'bg-[#004125] text-white shadow-sm' : 'bg-[#eff4ff] text-[#404942] hover:bg-[#dee9fc]' }}">
                Semua Agenda
            </a>
            @foreach ($banoms as $b)
                <a href="{{ route('event.index', ['banom' => $b->slug, 'q' => $search]) }}" class="px-4 py-2 rounded-xl text-xs font-bold whitespace-nowrap transition-all {{ $banomSlug === $b->slug ? 'bg-[#004125] text-white shadow-sm' : 'bg-[#eff4ff] text-[#404942] hover:bg-[#dee9fc]' }}">
                    {{ $b->singkatan }}
                </a>
            @endforeach
        </div>

        <!-- Shortcut to Archive -->
        <a href="{{ route('event.archive') }}" class="inline-flex items-center gap-2 bg-[#eff4ff] hover:bg-[#dee9fc] text-[#004125] font-bold text-xs sm:text-sm px-4 py-2.5 rounded-2xl border border-[#d0dbed] transition-colors shrink-0">
            <span class="material-symbols-outlined text-[18px]">history_edu</span>
            <span>Buka Arsip Agenda Lampau ({{ $pastCount }})</span>
            <span class="material-symbols-outlined text-[16px]">arrow_forward</span>
        </a>
    </div>

    <!-- Active Upcoming Events List -->
    <div class="space-y-6">
        <div class="flex items-center gap-2.5">
            <span class="w-3 h-7 rounded-full bg-[#0c5a37]"></span>
            <h2 class="text-xl sm:text-2xl font-black text-[#121c2a]">Daftar Agenda Mendatang</h2>
            <span class="text-xs font-bold text-emerald-800 bg-emerald-100 px-2.5 py-0.5 rounded-full">Diurutkan Paling Dekat</span>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse ($events as $event)
                <div class="bg-white rounded-3xl p-6 border-2 border-[#e6eeff] hover:border-[#0c5a37] card-hover flex flex-col justify-between shadow-sm space-y-4">
                    <div class="space-y-4">
                        <div class="flex items-start justify-between gap-4">
                            <div class="w-16 h-16 rounded-2xl bg-[#eff4ff] text-[#004125] flex flex-col items-center justify-center shrink-0 border border-[#dee9fc]">
                                <span class="text-[11px] font-bold uppercase tracking-wider">{{ $event->tanggal->translatedFormat('M') }}</span>
                                <span class="text-2xl font-black leading-none">{{ $event->tanggal->format('d') }}</span>
                                <span class="text-[10px] text-[#707971]">{{ $event->tanggal->format('Y') }}</span>
                            </div>

                            <span class="px-3 py-1 rounded-full text-xs font-extrabold bg-[#eff4ff] text-[#004125] border border-[#dee9fc]">
                                {{ $event->banom ? $event->banom->singkatan : 'PRNU Induk' }}
                            </span>
                        </div>

                        <div>
                            <h3 class="text-base sm:text-lg font-bold text-[#121c2a] leading-snug">
                                <a href="{{ route('event.show', $event->slug) }}" class="hover:text-[#004125] transition-colors">{{ $event->title }}</a>
                            </h3>
                            <div class="mt-3 space-y-2 text-xs sm:text-sm text-[#526350]">
                                <p class="flex items-center gap-2">
                                    <span class="material-symbols-outlined text-[16px] text-[#fe932c]">schedule</span>
                                    <span>{{ $event->waktu_mulai ? date('H:i', strtotime($event->waktu_mulai)) . ' WIB' : 'Waktu menyusul' }}</span>
                                </p>
                                <p class="flex items-center gap-2">
                                    <span class="material-symbols-outlined text-[16px] text-[#fe932c]">location_on</span>
                                    <span class="truncate">{{ $event->lokasi ?? 'Desa Banjaranyar' }}</span>
                                </p>
                            </div>
                            <p class="text-xs text-[#707971] mt-3 line-clamp-2 leading-relaxed">
                                {{ $event->description }}
                            </p>
                        </div>
                    </div>

                    <div class="pt-4 border-t border-[#eff4ff] flex items-center justify-between">
                        <span class="text-xs text-[#0c5a37] font-bold flex items-center gap-1.5">
                            <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                            <span>{{ $event->status }}</span>
                        </span>
                        <a href="{{ route('event.show', $event->slug) }}" class="text-xs font-bold text-[#0c5a37] hover:underline flex items-center gap-1">
                            <span>Detail Agenda</span>
                            <span class="material-symbols-outlined text-[14px]">arrow_forward</span>
                        </a>
                    </div>
                </div>
            @empty
                <div class="col-span-3 p-12 text-center bg-white rounded-3xl border border-[#e6eeff] space-y-3">
                    <span class="material-symbols-outlined text-gray-400 text-5xl">event_busy</span>
                    <h3 class="text-base font-bold text-[#121c2a]">Tidak Ada Agenda Aktif</h3>
                    <p class="text-xs sm:text-sm text-[#526350]">
                        Seluruh agenda lampau telah dipindahkan secara otomatis ke halaman Arsip Agenda.
                    </p>
                    <div class="pt-2">
                        <a href="{{ route('event.archive') }}" class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl bg-[#0c5a37] text-white text-xs font-bold">
                            <span>Buka Arsip Agenda Lampau</span>
                            <span class="material-symbols-outlined text-[16px]">arrow_forward</span>
                        </a>
                    </div>
                </div>
            @endforelse
        </div>

        <div class="pt-4">
            {{ $events->links() }}
        </div>
    </div>

</div>
@endsection
