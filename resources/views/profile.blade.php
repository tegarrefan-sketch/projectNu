@extends('layouts.app')

@section('title', 'Profil Organisasi — NU Ranting Banjaranyar')

@section('content')
<!-- Header Banner -->
<section class="bg-gradient-to-r from-[#004125] to-[#0c5a37] text-white py-14">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-3">
        <nav class="flex items-center gap-2 text-xs text-emerald-200">
            <a href="{{ route('home') }}" class="hover:underline flex items-center gap-1">
                <span class="material-symbols-outlined text-[14px]">home</span>
                <span>Beranda</span>
            </a>
            <span>/</span>
            <span class="text-white font-semibold">Profil Organisasi</span>
        </nav>
        <h1 class="text-3xl sm:text-4xl font-extrabold tracking-tight">Profil Pengurus Ranting Nahdlatul Ulama</h1>
        <p class="text-sm text-emerald-100 max-w-2xl leading-relaxed">
            Mengenal lebih dekat sejarah perjuangan, visi, misi, dan susunan kepengurusan dwitunggal PRNU Desa Banjaranyar, Kec. Baureno, Kab. Bojonegoro.
        </p>
    </div>
</section>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 space-y-12">
    
    <!-- 1. SK & Identitas Singkat -->
    <div class="bg-white rounded-2xl p-6 sm:p-8 border border-[#e6eeff] shadow-sm flex flex-col md:flex-row md:items-center justify-between gap-6">
        <div class="flex items-start sm:items-center gap-4">
            <div class="w-14 h-14 rounded-2xl bg-[#eff4ff] text-[#004125] flex items-center justify-center shrink-0">
                <span class="material-symbols-outlined text-[32px]">verified</span>
            </div>
            <div>
                <span class="text-xs font-bold text-[#904d00] uppercase tracking-wider block">Surat Keputusan Sah</span>
                <h3 class="text-lg font-bold text-[#121c2a]">{{ $profile->sk_nomor }}</h3>
                <p class="text-xs text-[#404942]">Pengurus Cabang Nahdlatul Ulama (PCNU) Bojonegoro • Masa Khidmat {{ $profile->masa_khidmat }}</p>
            </div>
        </div>
        <div class="flex items-center gap-3">
            <span class="px-3.5 py-1.5 rounded-full text-xs font-bold bg-[#eff4ff] text-[#004125] border border-[#dee9fc]">
                Status: Aktif Berjalan
            </span>
        </div>
    </div>

    <!-- 2. Sejarah, Visi, Misi Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-10">
        
        <!-- Sejarah (7 cols) -->
        <div class="lg:col-span-7 bg-white rounded-2xl p-6 sm:p-8 border border-[#e6eeff] shadow-sm space-y-4">
            <div class="flex items-center gap-2 text-[#004125]">
                <span class="material-symbols-outlined text-[24px]">history_edu</span>
                <h2 class="text-xl font-bold">Sejarah Perjalanan Ranting</h2>
            </div>
            <div class="text-sm text-[#404942] leading-relaxed space-y-3 prose max-w-none">
                {!! nl2br(e($profile->sejarah)) !!}
            </div>
        </div>

        <!-- Visi & Misi (5 cols) -->
        <div class="lg:col-span-5 space-y-6">
            <div class="bg-white rounded-2xl p-6 border border-[#e6eeff] shadow-sm space-y-3">
                <div class="flex items-center gap-2 text-[#004125]">
                    <span class="material-symbols-outlined text-[22px]">visibility</span>
                    <h2 class="text-lg font-bold">Visi Organisasi</h2>
                </div>
                <p class="text-sm text-[#404942] leading-relaxed italic bg-[#f8f9ff] p-4 rounded-xl border-l-4 border-[#0c5a37]">
                    "{{ $profile->visi }}"
                </p>
            </div>

            <div class="bg-white rounded-2xl p-6 border border-[#e6eeff] shadow-sm space-y-3">
                <div class="flex items-center gap-2 text-[#004125]">
                    <span class="material-symbols-outlined text-[22px]">task_alt</span>
                    <h2 class="text-lg font-bold">Misi Utama</h2>
                </div>
                <div class="text-xs text-[#404942] leading-relaxed space-y-2">
                    {!! nl2br(e($profile->misi)) !!}
                </div>
            </div>

            <div class="bg-white rounded-2xl p-6 border border-[#e6eeff] shadow-sm space-y-3">
                <div class="flex items-center gap-2 text-[#004125]">
                    <span class="material-symbols-outlined text-[22px]">balance</span>
                    <h2 class="text-lg font-bold">Nilai Dasar Aswaja</h2>
                </div>
                <p class="text-xs text-[#404942] leading-relaxed">
                    {{ $profile->nilai_organisasi }}
                </p>
            </div>
        </div>

    </div>

    <!-- 3. Dwitunggal Kepengurusan (Syuriyah & Tanfidziyah) -->
    <div class="space-y-6">
        <div>
            <span class="text-xs font-bold text-[#904d00] uppercase tracking-wider block">Hierarki Kepemimpinan</span>
            <h2 class="text-2xl font-extrabold text-[#004125] tracking-tight">Dwitunggal Syuriyah & Tanfidziyah</h2>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach ($syuriyah as $item)
                <div class="bg-white rounded-2xl p-5 border border-[#e6eeff] shadow-sm flex items-start gap-4">
                    <div class="w-14 h-14 rounded-2xl bg-[#eff4ff] text-[#004125] flex items-center justify-center shrink-0">
                        <span class="material-symbols-outlined text-[28px]">person</span>
                    </div>
                    <div>
                        <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-[#aaf2c4] text-[#002110]">Syuriyah</span>
                        <h3 class="text-base font-bold text-[#121c2a] mt-1">{{ $item->nama }}</h3>
                        <p class="text-xs font-semibold text-[#0c5a37]">{{ $item->jabatan }}</p>
                        <p class="text-xs text-[#707971] mt-1">{{ $item->deskripsi }}</p>
                    </div>
                </div>
            @endforeach

            @foreach ($tanfidziyah as $item)
                <div class="bg-white rounded-2xl p-5 border border-[#e6eeff] shadow-sm flex items-start gap-4">
                    <div class="w-14 h-14 rounded-2xl bg-[#eff4ff] text-[#004125] flex items-center justify-center shrink-0">
                        <span class="material-symbols-outlined text-[28px]">person</span>
                    </div>
                    <div>
                        <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-[#ffdcc3] text-[#2f1500]">Tanfidziyah</span>
                        <h3 class="text-base font-bold text-[#121c2a] mt-1">{{ $item->nama }}</h3>
                        <p class="text-xs font-semibold text-[#904d00]">{{ $item->jabatan }}</p>
                        <p class="text-xs text-[#707971] mt-1">{{ $item->deskripsi }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

</div>
@endsection
