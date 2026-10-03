@extends('layouts.app')

@section('title', $event->title . ' — Agenda NU Banjaranyar')

@section('content')
<!-- Header & Breadcrumbs -->
<div class="bg-white border-b border-[#e6eeff] py-4">
    <div class="max-w-4xl mx-auto px-4 sm:px-6">
        <nav class="flex items-center gap-2 text-xs text-[#707971]">
            <a href="{{ route('home') }}" class="hover:text-[#004125] flex items-center gap-1">
                <span class="material-symbols-outlined text-[14px]">home</span>
                <span>Beranda</span>
            </a>
            <span>/</span>
            <a href="{{ route('event.index') }}" class="hover:text-[#004125]">Agenda Kegiatan</a>
            <span>/</span>
            <span class="text-[#004125] font-semibold truncate">{{ Str::limit($event->title, 40) }}</span>
        </nav>
    </div>
</div>

<div class="max-w-4xl mx-auto px-4 sm:px-6 py-10 space-y-8">
    
    <div class="bg-white rounded-3xl p-6 sm:p-10 border border-[#e6eeff] shadow-sm space-y-6">
        <div class="flex items-center gap-2">
            <span class="px-3 py-1 rounded-full text-xs font-bold text-white bg-[#004125]">
                {{ $event->banom ? $event->banom->singkatan : 'PRNU Induk' }}
            </span>
            <span class="px-3 py-1 rounded-full text-xs font-bold bg-[#eff4ff] text-[#004125]">
                {{ $event->status }}
            </span>
        </div>

        <h1 class="text-2xl sm:text-3xl font-extrabold text-[#121c2a] leading-tight">
            {{ $event->title }}
        </h1>

        <!-- Date, Time, Location Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 pt-2">
            <div class="bg-[#f8f9ff] p-4 rounded-2xl border border-[#e6eeff] flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-[#eff4ff] text-[#004125] flex items-center justify-center shrink-0">
                    <span class="material-symbols-outlined text-[22px]">calendar_month</span>
                </div>
                <div>
                    <span class="text-[11px] text-[#707971] block">Tanggal Kegiatan</span>
                    <span class="text-xs font-bold text-[#121c2a]">{{ $event->tanggal->format('d F Y') }}</span>
                </div>
            </div>

            <div class="bg-[#f8f9ff] p-4 rounded-2xl border border-[#e6eeff] flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-[#eff4ff] text-[#004125] flex items-center justify-center shrink-0">
                    <span class="material-symbols-outlined text-[22px]">schedule</span>
                </div>
                <div>
                    <span class="text-[11px] text-[#707971] block">Waktu Pelaksanaan</span>
                    <span class="text-xs font-bold text-[#121c2a]">{{ $event->waktu_mulai ? date('H:i', strtotime($event->waktu_mulai)) . ' WIB' : 'Menyusul' }}</span>
                </div>
            </div>

            <div class="bg-[#f8f9ff] p-4 rounded-2xl border border-[#e6eeff] flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-[#eff4ff] text-[#004125] flex items-center justify-center shrink-0">
                    <span class="material-symbols-outlined text-[22px]">location_on</span>
                </div>
                <div class="min-w-0">
                    <span class="text-[11px] text-[#707971] block">Tempat / Lokasi</span>
                    <span class="text-xs font-bold text-[#121c2a] truncate block">{{ $event->lokasi }}</span>
                </div>
            </div>
        </div>

        <!-- Description -->
        <div class="pt-4 border-t border-[#eff4ff] space-y-3">
            <h2 class="text-base font-bold text-[#121c2a]">Uraian & Keterangan Acara</h2>
            <div class="text-sm text-[#404942] leading-relaxed space-y-3">
                {!! nl2br(e($event->description)) !!}
            </div>
        </div>
    </div>

    <!-- Other Upcoming Events -->
    @if ($otherEvents->isNotEmpty())
        <div class="space-y-4">
            <h2 class="text-lg font-bold text-[#004125]">Agenda Lainnya</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                @foreach ($otherEvents as $other)
                    <div class="bg-white rounded-2xl p-4 border border-[#e6eeff] shadow-sm space-y-2">
                        <span class="text-[10px] font-bold text-[#0c5a37]">{{ $other->tanggal->format('d M Y') }}</span>
                        <h3 class="text-xs font-bold text-[#121c2a] line-clamp-2">
                            <a href="{{ route('event.show', $other->slug) }}" class="hover:text-[#004125]">{{ $other->title }}</a>
                        </h3>
                        <p class="text-[11px] text-[#707971] truncate">{{ $other->lokasi }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    @endif

</div>
@endsection
