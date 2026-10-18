@extends('layouts.admin')

@section('title', 'Detail Badan Otonom — ' . $banom->singkatan . ' — SIMNU Admin')

@section('content')
<div class="space-y-6">

    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 bg-white p-6 rounded-2xl border border-[#e6eeff] shadow-sm">
        <div>
            <nav class="flex items-center gap-2 text-xs text-[#707971] mb-1">
                <a href="{{ route('admin.banoms.index') }}" class="hover:underline">Badan Otonom</a>
                <span>/</span>
                <span class="text-[#004125] font-semibold">{{ $banom->singkatan }}</span>
            </nav>
            <h1 class="text-2xl font-black text-[#004125] tracking-tight">Detail Banom: {{ $banom->nama }}</h1>
            <p class="text-xs text-[#526350] mt-0.5">Struktur kepengurusan resmi dan profil badan otonom.</p>
        </div>

        <div class="flex flex-wrap items-center gap-2">
            <a href="{{ route('admin.banoms.officers.index', $banom->id) }}" class="px-4 py-2.5 rounded-xl bg-[#0c5a37] hover:bg-[#004125] text-white text-xs font-black shadow-sm transition flex items-center gap-1.5">
                <span class="material-symbols-outlined text-[18px] text-[#fe932c]">groups</span>
                <span>Kelola Pengurus ({{ $banom->banomOfficers->count() }})</span>
            </a>

            <a href="{{ route('admin.banoms.edit', $banom->id) }}" class="px-4 py-2.5 rounded-xl border border-gray-300 text-gray-700 hover:bg-gray-50 text-xs font-bold transition flex items-center gap-1">
                <span class="material-symbols-outlined text-[16px]">edit</span>
                <span>Edit Profil</span>
            </a>

            <a href="{{ route('admin.banoms.index') }}" class="px-3.5 py-2.5 rounded-xl bg-gray-100 hover:bg-gray-200 text-gray-700 text-xs font-bold transition">
                Kembali
            </a>
        </div>
    </div>

    <!-- 2 Column Layout: Profile Card Left & Officers Grouped Right -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">
        
        <!-- Left: Profil Banom (4 cols) -->
        <div class="lg:col-span-4 bg-white rounded-3xl p-6 border border-[#e6eeff] shadow-sm space-y-5">
            <div class="text-center space-y-3 pb-4 border-b border-gray-100">
                <div class="w-20 h-20 mx-auto rounded-3xl bg-[#f8f9ff] border border-[#dee9fc] flex items-center justify-center p-3 shadow-sm overflow-hidden">
                    @if($banom->logo)
                        <img src="{{ asset('storage/' . $banom->logo) }}" alt="{{ $banom->singkatan }}" class="w-full h-full object-contain">
                    @else
                        <span class="text-xl font-black text-[#004125]">{{ $banom->singkatan }}</span>
                    @endif
                </div>

                <div>
                    <h2 class="text-xl font-black text-[#004125]">{{ $banom->singkatan }}</h2>
                    <p class="text-xs text-gray-600 font-semibold">{{ $banom->nama }}</p>
                </div>

                <div class="flex items-center justify-center gap-2">
                    <span class="px-2.5 py-0.5 rounded-full text-[10px] font-extrabold uppercase border {{ $banom->is_active ? 'bg-emerald-50 text-emerald-800 border-emerald-200' : 'bg-gray-100 text-gray-600 border-gray-200' }}">
                        {{ $banom->is_active ? 'Status: Aktif' : 'Status: Nonaktif' }}
                    </span>
                    <span class="px-2.5 py-0.5 rounded-full text-[10px] font-mono font-bold bg-gray-100 text-gray-700">
                        Urutan #{{ $banom->urutan }}
                    </span>
                </div>
            </div>

            <div class="space-y-3 text-xs text-[#404942]">
                <div>
                    <span class="font-bold text-[#121c2a] block mb-1">Deskripsi:</span>
                    <p class="leading-relaxed bg-[#f8f9ff] p-3 rounded-xl border border-gray-100">
                        {{ $banom->deskripsi ?: 'Belum ada deskripsi profil.' }}
                    </p>
                </div>

                <div class="pt-2 flex items-center justify-between text-xs border-t border-gray-100">
                    <span class="text-gray-500">Total Pengurus:</span>
                    <strong class="text-[#004125] font-black">{{ $banom->banomOfficers->count() }} Orang</strong>
                </div>
            </div>
        </div>

        <!-- Right: Daftar Pengurus Dikelompokkan per Jabatan Sesuai Hierarki (8 cols) -->
        <div class="lg:col-span-8 bg-white rounded-3xl p-6 sm:p-8 border border-[#e6eeff] shadow-sm space-y-6">
            <div class="flex items-center justify-between border-b border-gray-100 pb-4">
                <div>
                    <span class="text-xs font-bold text-[#fe932c] uppercase tracking-wider block">Hierarki Kepengurusan</span>
                    <h3 class="text-xl font-black text-[#004125]">Jajaran Pengurus {{ $banom->singkatan }}</h3>
                </div>

                <a href="{{ route('admin.banoms.officers.create', $banom->id) }}" class="px-3.5 py-2 rounded-xl bg-emerald-50 hover:bg-emerald-100 text-[#004125] text-xs font-black flex items-center gap-1.5 transition">
                    <span class="material-symbols-outlined text-[16px]">person_add</span>
                    <span>Tambah Pengurus</span>
                </a>
            </div>

            @if($groupedOfficers->isEmpty())
                <div class="py-12 text-center text-gray-400 space-y-2">
                    <span class="material-symbols-outlined text-4xl text-gray-300">badge</span>
                    <p class="text-xs">Belum ada pengurus yang didaftarkan untuk badan otonom ini.</p>
                    <a href="{{ route('admin.banoms.officers.create', $banom->id) }}" class="inline-block mt-2 text-xs font-bold text-[#0c5a37] hover:underline">
                        + Tambah Pengurus Pertama
                    </a>
                </div>
            @else
                <div class="space-y-6">
                    @foreach($groupedOfficers as $positionName => $officerList)
                        <div class="space-y-3">
                            <!-- Group Position Heading -->
                            <div class="flex items-center gap-2 bg-[#f8f9ff] px-4 py-2.5 rounded-xl border border-[#dee9fc]">
                                <span class="material-symbols-outlined text-[18px] text-[#0c5a37]">military_tech</span>
                                <h4 class="text-xs font-black text-[#004125] uppercase tracking-wider">{{ $positionName }}</h4>
                                <span class="text-[10px] font-bold text-gray-400">({{ $officerList->count() }} orang)</span>
                            </div>

                            <!-- Officers Cards Grid in this Position -->
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 pl-2">
                                @foreach($officerList as $officer)
                                    <div class="p-3.5 rounded-2xl bg-white border border-[#e6eeff] hover:border-emerald-300 shadow-sm flex items-center justify-between gap-3 transition">
                                        <div class="flex items-center gap-3">
                                            <div class="w-11 h-11 rounded-xl bg-gray-100 border border-gray-200 overflow-hidden flex items-center justify-center text-gray-400 shrink-0">
                                                @if($officer->display_foto)
                                                    <img src="{{ $officer->display_foto }}" alt="{{ $officer->display_nama }}" class="w-full h-full object-cover">
                                                @else
                                                    <span class="material-symbols-outlined text-[24px]">person</span>
                                                @endif
                                            </div>

                                            <div>
                                                <h5 class="text-xs font-extrabold text-[#121c2a]">{{ $officer->display_nama }}</h5>
                                                @if($officer->bidang)
                                                    <span class="text-[10px] font-bold text-[#fe932c] block">Bidang: {{ $officer->bidang }}</span>
                                                @endif
                                                <div class="flex items-center gap-2 mt-0.5">
                                                    @if($officer->member)
                                                        <span class="text-[9px] font-mono text-emerald-800 bg-emerald-50 px-1.5 py-0.5 rounded">Kader Terdata</span>
                                                    @endif
                                                    <span class="text-[9px] text-gray-400">Urutan #{{ $officer->urutan }}</span>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="flex items-center gap-1 shrink-0">
                                            <a href="{{ route('admin.banoms.officers.edit', [$banom->id, $officer->id]) }}" class="p-1 rounded-lg text-emerald-700 hover:bg-emerald-50 transition" title="Edit Pengurus">
                                                <span class="material-symbols-outlined text-[16px]">edit</span>
                                            </a>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

    </div>

</div>
@endsection
