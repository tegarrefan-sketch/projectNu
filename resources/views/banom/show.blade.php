@extends('layouts.app')

@section('title', 'Profil ' . $banom->nama . ' (' . $banom->singkatan . ') — NU Banjaranyar')

@section('content')
<!-- Header Banner with BANOM Primary Color -->
<section class="text-white py-14" style="background: linear-gradient(135deg, {{ $banom->warna_primer ?? '#004125' }} 0%, #002110 100%);">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-4">
        <nav class="flex items-center gap-2 text-xs text-emerald-200">
            <a href="{{ route('home') }}" class="hover:underline flex items-center gap-1">
                <span class="material-symbols-outlined text-[14px]">home</span>
                <span>Beranda</span>
            </a>
            <span>/</span>
            <a href="{{ route('structure.index', ['tab' => 'banom']) }}" class="hover:underline">Badan Otonom</a>
            <span>/</span>
            <span class="text-white font-semibold">{{ $banom->singkatan }}</span>
        </nav>

        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-6 pt-2">
            <div class="space-y-2">
                <span class="inline-block px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wider bg-white/20 backdrop-blur-sm border border-white/20">
                    Pimpinan Ranting {{ $banom->singkatan }}
                </span>
                <h1 class="text-3xl sm:text-4xl font-extrabold tracking-tight">{{ $banom->nama }}</h1>
                <p class="text-xs sm:text-sm text-emerald-100 max-w-2xl leading-relaxed">{{ $banom->deskripsi }}</p>
            </div>
            
            <div class="bg-white/10 backdrop-blur-md p-4 rounded-2xl border border-white/10 shrink-0 text-right space-y-1">
                <span class="text-[11px] text-emerald-200 block">Kader Terdata</span>
                <span class="text-2xl font-extrabold text-white block">{{ $banom->members_count }} Jiwa</span>
                <span class="text-[10px] text-emerald-300">Status: {{ $banom->status }}</span>
            </div>
        </div>
    </div>
</section>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 space-y-12">
    
    <!-- 1. Visi, Misi & Sejarah -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
        <div class="lg:col-span-7 bg-white rounded-2xl p-6 sm:p-8 border border-[#e6eeff] shadow-sm space-y-4">
            <h2 class="text-lg font-bold text-[#004125] flex items-center gap-2">
                <span class="material-symbols-outlined">history_edu</span>
                <span>Sejarah & Peran {{ $banom->singkatan }} di Desa Banjaranyar</span>
            </h2>
            <div class="text-xs sm:text-sm text-[#404942] leading-relaxed space-y-3">
                {!! nl2br(e($banom->sejarah ?? $banom->deskripsi)) !!}
            </div>
        </div>

        <div class="lg:col-span-5 space-y-6">
            <div class="bg-white rounded-2xl p-6 border border-[#e6eeff] shadow-sm space-y-3">
                <h3 class="text-base font-bold text-[#004125] flex items-center gap-2">
                    <span class="material-symbols-outlined">visibility</span>
                    <span>Visi</span>
                </h3>
                <p class="text-xs sm:text-sm text-[#404942] leading-relaxed bg-[#f8f9ff] p-4 rounded-xl border-l-4" style="border-left-color: {{ $banom->warna_primer ?? '#004125' }};">
                    "{{ $banom->visi }}"
                </p>
            </div>

            <div class="bg-white rounded-2xl p-6 border border-[#e6eeff] shadow-sm space-y-3">
                <h3 class="text-base font-bold text-[#004125] flex items-center gap-2">
                    <span class="material-symbols-outlined">checklist</span>
                    <span>Misi</span>
                </h3>
                <div class="text-xs text-[#404942] leading-relaxed space-y-2">
                    {!! nl2br(e($banom->misi)) !!}
                </div>
            </div>
        </div>
    </div>

    <!-- 2. Jajaran Pengurus BANOM -->
    <div class="space-y-6">
        <div>
            <span class="text-xs font-bold text-[#904d00] uppercase tracking-wider block">Struktur Kepemimpinan</span>
            <h2 class="text-2xl font-extrabold text-[#004125] tracking-tight">Pengurus Pimpinan Ranting {{ $banom->singkatan }}</h2>
        </div>

        @include('partials.banom_pyramid', ['officers' => $officers, 'structures' => $structures, 'banom' => $banom])
    </div>

    <!-- 3. Berita & Warta BANOM -->
    @if ($posts->isNotEmpty())
        <div class="space-y-6">
            <div>
                <span class="text-xs font-bold text-[#904d00] uppercase tracking-wider block">Dokumentasi & Kabar</span>
                <h2 class="text-2xl font-extrabold text-[#004125] tracking-tight">Warta Kegiatan {{ $banom->singkatan }}</h2>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                @foreach ($posts as $post)
                    <article class="bg-white rounded-2xl overflow-hidden border border-[#e6eeff] shadow-sm flex flex-col justify-between">
                        <div class="p-5 space-y-2">
                            <span class="text-[11px] text-[#707971] font-medium">{{ $post->published_at ? $post->published_at->format('d M Y') : $post->created_at->format('d M Y') }}</span>
                            <h3 class="text-sm font-bold text-[#121c2a] line-clamp-2">
                                <a href="{{ route('post.show', $post->slug) }}" class="hover:text-[#004125] transition-colors">{{ $post->title }}</a>
                            </h3>
                            <p class="text-xs text-[#404942] line-clamp-2">{{ $post->excerpt }}</p>
                        </div>
                        <div class="p-5 pt-0">
                            <a href="{{ route('post.show', $post->slug) }}" class="text-xs font-bold text-[#0c5a37] hover:underline flex items-center gap-1">
                                <span>Baca Selengkapnya</span>
                                <span class="material-symbols-outlined text-[14px]">arrow_forward</span>
                            </a>
                        </div>
                    </article>
                @endforeach
            </div>
        </div>
    @endif

    <!-- 4. Agenda Mendatang BANOM -->
    @if ($events->isNotEmpty())
        <div class="space-y-6">
            <div>
                <span class="text-xs font-bold text-[#904d00] uppercase tracking-wider block">Jadwal Agenda</span>
                <h2 class="text-2xl font-extrabold text-[#004125] tracking-tight">Agenda Terdekat {{ $banom->singkatan }}</h2>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                @foreach ($events as $event)
                    <div class="bg-white rounded-2xl p-5 border border-[#e6eeff] shadow-sm flex items-center justify-between gap-4">
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 rounded-xl bg-[#eff4ff] text-[#004125] flex flex-col items-center justify-center shrink-0">
                                <span class="text-[10px] font-bold uppercase">{{ $event->tanggal->format('M') }}</span>
                                <span class="text-base font-extrabold leading-none">{{ $event->tanggal->format('d') }}</span>
                            </div>
                            <div>
                                <h3 class="text-sm font-bold text-[#121c2a]">{{ $event->title }}</h3>
                                <p class="text-xs text-[#404942] flex items-center gap-1 mt-0.5">
                                    <span class="material-symbols-outlined text-[14px] text-[#904d00]">location_on</span>
                                    <span>{{ $event->lokasi }}</span>
                                </p>
                            </div>
                        </div>
                        <a href="{{ route('event.show', $event->slug) }}" class="shrink-0 px-3 py-1.5 rounded-lg bg-[#eff4ff] text-[#004125] font-bold text-xs hover:bg-[#0c5a37] hover:text-white transition-colors">
                            Detail
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    @endif

</div>
@endsection
