@extends('layouts.app')

@section('title', 'Agenda & Kegiatan — NU Ranting Banjaranyar')

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
                <h1 class="text-3xl sm:text-4xl font-extrabold tracking-tight">Jadwal Agenda & Istighotsah Ranting</h1>
                <p class="text-xs sm:text-sm text-emerald-100 leading-relaxed">
                    Informasi jadwal pengajian selapanan Ahad Kliwon, istighotsah malam Jumat, bahtsul masail, dan kegiatan 5 Badan Otonom.
                </p>
            </div>

            <!-- Search Form in Header -->
            <form method="GET" action="{{ route('event.index') }}" class="w-full lg:w-80">
                <div class="relative">
                    <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-[18px]">search</span>
                    <input type="text" name="q" value="{{ $search }}" placeholder="Cari nama agenda atau lokasi..." class="w-full bg-white/10 text-white placeholder-emerald-200/60 pl-9 pr-4 py-2.5 rounded-xl text-xs border border-white/20 focus:outline-none focus:bg-white/20 transition-all">
                </div>
            </form>
        </div>
    </div>
</section>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10 space-y-10">
    
    <!-- Filter Chips -->
    <div class="flex items-center gap-2 overflow-x-auto pb-1 bg-white p-3 rounded-2xl border border-[#e6eeff] shadow-sm">
        <a href="{{ route('event.index', ['q' => $search]) }}" class="px-3.5 py-2 rounded-xl text-xs font-bold whitespace-nowrap transition-all {{ empty($banomSlug) ? 'bg-[#004125] text-white shadow-sm' : 'bg-[#eff4ff] text-[#404942] hover:bg-[#dee9fc]' }}">
            Semua Agenda
        </a>
        @foreach ($banoms as $b)
            <a href="{{ route('event.index', ['banom' => $b->slug, 'q' => $search]) }}" class="px-3.5 py-2 rounded-xl text-xs font-bold whitespace-nowrap transition-all {{ $banomSlug === $b->slug ? 'bg-[#004125] text-white shadow-sm' : 'bg-[#eff4ff] text-[#404942] hover:bg-[#dee9fc]' }}">
                {{ $b->singkatan }}
            </a>
        @endforeach
    </div>

    <!-- Upcoming Events List -->
    <div class="space-y-4">
        <div class="flex items-center gap-2">
            <span class="w-2.5 h-6 rounded-full bg-[#0c5a37]"></span>
            <h2 class="text-xl font-bold text-[#121c2a]">Agenda Mendatang</h2>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            @forelse ($upcomingEvents as $event)
                <div class="bg-white rounded-2xl p-6 border border-[#e6eeff] shadow-sm hover:shadow-md transition-all flex flex-col justify-between space-y-4">
                    <div class="flex items-start gap-4">
                        <div class="w-16 h-16 rounded-2xl bg-[#eff4ff] text-[#004125] flex flex-col items-center justify-center shrink-0 border border-[#dee9fc]">
                            <span class="text-[11px] font-bold uppercase tracking-wider">{{ $event->tanggal->format('M') }}</span>
                            <span class="text-xl font-extrabold leading-none">{{ $event->tanggal->format('d') }}</span>
                            <span class="text-[10px] text-[#707971]">{{ $event->tanggal->format('Y') }}</span>
                        </div>

                        <div class="space-y-1 min-w-0">
                            <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-[#eff4ff] text-[#004125]">
                                {{ $event->banom ? $event->banom->singkatan : 'PRNU Induk' }}
                            </span>
                            <h3 class="text-base font-bold text-[#121c2a] leading-snug">
                                <a href="{{ route('event.show', $event->slug) }}" class="hover:text-[#004125] transition-colors">{{ $event->title }}</a>
                            </h3>
                            <p class="text-xs text-[#707971] flex items-center gap-1">
                                <span class="material-symbols-outlined text-[14px]">schedule</span>
                                <span>{{ $event->waktu_mulai ? date('H:i', strtotime($event->waktu_mulai)) . ' WIB' : 'Waktu menyusul' }}</span>
                            </p>
                            <p class="text-xs text-[#404942] flex items-center gap-1">
                                <span class="material-symbols-outlined text-[14px] text-[#904d00]">location_on</span>
                                <span>{{ $event->lokasi }}</span>
                            </p>
                        </div>
                    </div>

                    <div class="pt-3 border-t border-[#eff4ff] flex items-center justify-between">
                        <span class="text-[11px] text-[#0c5a37] font-semibold flex items-center gap-1">
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
                <div class="col-span-2 p-10 text-center bg-white rounded-2xl border border-[#e6eeff] text-xs text-[#404942]">
                    Tidak ada agenda mendatang untuk filter ini.
                </div>
            @endforelse
        </div>

        <div class="pt-2">
            {{ $upcomingEvents->links() }}
        </div>
    </div>

    <!-- Past Events List -->
    @if ($pastEvents->isNotEmpty())
        <div class="space-y-4 pt-6">
            <div class="flex items-center gap-2">
                <span class="w-2.5 h-6 rounded-full bg-gray-400"></span>
                <h2 class="text-lg font-bold text-[#404942]">Riwayat Kegiatan yang Telah Terlaksana</h2>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                @foreach ($pastEvents as $past)
                    <div class="bg-white/70 rounded-2xl p-4 border border-[#e6eeff] flex items-center justify-between gap-4">
                        <div class="flex items-center gap-3">
                            <span class="text-xs font-bold text-gray-500 bg-gray-100 px-2.5 py-1 rounded-lg">
                                {{ $past->tanggal->format('d M Y') }}
                            </span>
                            <div>
                                <h4 class="text-xs font-bold text-[#121c2a]">{{ $past->title }}</h4>
                                <p class="text-[11px] text-[#707971]">{{ $past->lokasi }}</p>
                            </div>
                        </div>
                        <span class="px-2 py-0.5 rounded text-[10px] font-semibold bg-gray-100 text-gray-600">Selesai</span>
                    </div>
                @endforeach
            </div>
        </div>
    @endif

</div>
@endsection
