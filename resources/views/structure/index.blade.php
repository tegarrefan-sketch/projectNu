@extends('layouts.app')

@section('title', 'Struktur Organisasi & Kepengurusan — NU Ranting Banjaranyar')

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
                    <span>Tata Kelola Aswaja Ranting</span>
                </div>
                <h1 class="text-3xl sm:text-4xl font-extrabold tracking-tight">Struktur Kepengurusan & Hierarki Khidmat</h1>
                <p class="text-xs sm:text-sm text-emerald-100 leading-relaxed">
                    Dwitunggal kepemimpinan Syuriyah (pengarah spiritual & hukum Islam), Tanfidziyah (pelaksana program keummatan), dan 5 Badan Otonom masa khidmat 2023–2028.
                </p>
            </div>

            <!-- SK PCNU Box -->
            <div class="bg-white/10 backdrop-blur-md p-4 rounded-2xl border border-white/10 flex items-center justify-between gap-4 shrink-0">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-[#fe932c] text-[#2f1500] flex items-center justify-center font-bold">
                        <span class="material-symbols-outlined text-[20px]">verified</span>
                    </div>
                    <div>
                        <span class="text-[10px] text-emerald-200 block">SK PCNU Bojonegoro</span>
                        <span class="text-xs font-bold text-white">{{ $profile->sk_nomor }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10 space-y-8">
    
    <!-- Filter Tabs & Search Bar -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 bg-white p-4 rounded-2xl border border-[#e6eeff] shadow-sm">
        
        <!-- Filter Tabs -->
        <div class="flex items-center gap-2 overflow-x-auto pb-1 md:pb-0">
            <a href="{{ route('structure.index', ['tab' => 'all', 'q' => $search]) }}" class="px-3.5 py-2 rounded-xl text-xs font-bold transition-all whitespace-nowrap {{ $tab === 'all' ? 'bg-[#004125] text-white shadow-sm' : 'bg-[#eff4ff] text-[#404942] hover:bg-[#dee9fc]' }}">
                Semua Pengurus
            </a>
            <a href="{{ route('structure.index', ['tab' => 'syuriyah', 'q' => $search]) }}" class="px-3.5 py-2 rounded-xl text-xs font-bold transition-all whitespace-nowrap {{ $tab === 'syuriyah' ? 'bg-[#004125] text-white shadow-sm' : 'bg-[#eff4ff] text-[#404942] hover:bg-[#dee9fc]' }}">
                Mustasyar & Syuriyah
            </a>
            <a href="{{ route('structure.index', ['tab' => 'tanfidziyah', 'q' => $search]) }}" class="px-3.5 py-2 rounded-xl text-xs font-bold transition-all whitespace-nowrap {{ $tab === 'tanfidziyah' ? 'bg-[#004125] text-white shadow-sm' : 'bg-[#eff4ff] text-[#404942] hover:bg-[#dee9fc]' }}">
                Tanfidziyah
            </a>
            <a href="{{ route('structure.index', ['tab' => 'banom', 'q' => $search]) }}" class="px-3.5 py-2 rounded-xl text-xs font-bold transition-all whitespace-nowrap {{ $tab === 'banom' ? 'bg-[#004125] text-white shadow-sm' : 'bg-[#eff4ff] text-[#404942] hover:bg-[#dee9fc]' }}">
                Pimpinan 5 BANOM
            </a>
        </div>

        <!-- Search Form -->
        <form method="GET" action="{{ route('structure.index') }}" class="relative w-full md:w-72">
            <input type="hidden" name="tab" value="{{ $tab }}">
            <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-[18px]">search</span>
            <input type="text" name="q" value="{{ $search }}" placeholder="Cari nama pengurus..." class="w-full bg-[#f8f9ff] pl-9 pr-3 py-2 rounded-xl text-xs text-[#121c2a] border border-[#e6eeff] focus:outline-none focus:border-[#004125] transition-colors">
        </form>

    </div>

    <!-- Structure Cards Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse ($structures as $item)
            <div class="bg-white rounded-2xl p-6 border border-[#e6eeff] shadow-sm hover:shadow-md transition-all flex items-start gap-4">
                <div class="w-16 h-16 rounded-2xl bg-[#eff4ff] text-[#004125] flex items-center justify-center shrink-0 border border-[#dee9fc] overflow-hidden">
                    @if ($item->foto)
                        <img src="{{ asset('storage/' . $item->foto) }}" alt="{{ $item->nama }}" class="w-full h-full object-cover">
                    @else
                        <span class="material-symbols-outlined text-[32px]">person</span>
                    @endif
                </div>

                <div class="space-y-1 min-w-0">
                    <div class="flex items-center gap-1.5 flex-wrap">
                        @if ($item->kategori_hierarki === 'syuriyah')
                            <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-[#aaf2c4] text-[#002110]">Syuriyah</span>
                        @elseif ($item->kategori_hierarki === 'mustasyar')
                            <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-[#dce1ff] text-[#00164e]">Mustasyar</span>
                        @elseif ($item->kategori_hierarki === 'tanfidziyah')
                            <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-[#ffdcc3] text-[#2f1500]">Tanfidziyah</span>
                        @elseif ($item->kategori_hierarki === 'banom')
                            <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-[#eff4ff] text-[#004125]">BANOM {{ $item->banom?->singkatan }}</span>
                        @endif
                    </div>

                    <h3 class="text-base font-bold text-[#121c2a] truncate">{{ $item->nama }}</h3>
                    <p class="text-xs font-semibold text-[#0c5a37]">{{ $item->jabatan }}</p>
                    <p class="text-xs text-[#707971] leading-relaxed pt-1">{{ $item->deskripsi }}</p>
                </div>
            </div>
        @empty
            <div class="col-span-3 p-12 text-center bg-white rounded-2xl border border-[#e6eeff] text-sm text-[#404942]">
                Tidak ada data pengurus yang cocok dengan kriteria pencarian.
            </div>
        @endforelse
    </div>

</div>
@endsection
