@extends('layouts.app')

@section('title', 'Badan Otonom (BANOM) — NU Ranting Banjaranyar')

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
            <span class="text-white font-semibold">Badan Otonom</span>
        </nav>
        <h1 class="text-3xl sm:text-4xl font-extrabold tracking-tight">5 Badan Otonom (BANOM) NU</h1>
        <p class="text-sm text-emerald-100 max-w-2xl leading-relaxed">
            Sayap organisasi Nahdlatul Ulama yang bergerak di berbagai basis komunitas: pelajar putra, santriwati, pemudi, pemuda patriot, dan korps pengamanan desa.
        </p>
    </div>
</section>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        @foreach ($banoms as $banom)
            <div class="bg-white rounded-2xl overflow-hidden border border-[#e6eeff] shadow-sm hover:shadow-lg transition-all flex flex-col justify-between hover:-translate-y-1">
                <div class="p-6 sm:p-8 space-y-4">
                    <div class="flex items-center justify-between">
                        <span class="px-3 py-1 rounded-full text-xs font-bold text-white shadow-sm" style="background-color: {{ $banom->warna_primer ?? '#0c5a37' }};">
                            {{ $banom->singkatan }}
                        </span>
                        <div class="w-10 h-10 rounded-xl bg-[#eff4ff] flex items-center justify-center text-[#004125]">
                            <span class="material-symbols-outlined text-[24px]">corporate_fare</span>
                        </div>
                    </div>

                    <div>
                        <h2 class="text-xl font-bold text-[#121c2a]">{{ $banom->nama }}</h2>
                        <p class="text-xs text-[#404942] mt-2 leading-relaxed line-clamp-3">{{ $banom->deskripsi }}</p>
                    </div>

                    <div class="grid grid-cols-2 gap-3 pt-3 border-t border-[#eff4ff] text-xs">
                        <div class="bg-[#f8f9ff] p-2.5 rounded-xl">
                            <span class="text-[10px] text-[#707971] block">Total Anggota</span>
                            <span class="text-sm font-bold text-[#004125]">{{ $banom->members_count }} Kader</span>
                        </div>
                        <div class="bg-[#f8f9ff] p-2.5 rounded-xl">
                            <span class="text-[10px] text-[#707971] block">Pengurus</span>
                            <span class="text-sm font-bold text-[#004125]">{{ $banom->organization_structures_count }} Personil</span>
                        </div>
                    </div>
                </div>

                <div class="p-6 bg-[#f8f9ff] border-t border-[#e6eeff]">
                    <a href="{{ route('banom.show', $banom->slug) }}" class="inline-flex items-center justify-center w-full gap-2 px-4 py-3 rounded-xl bg-[#0c5a37] hover:bg-[#004125] text-white font-bold text-xs shadow-sm transition-colors">
                        <span>Lihat Profil & Pengurus Lengkap</span>
                        <span class="material-symbols-outlined text-[16px]">arrow_forward</span>
                    </a>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection
