@extends('layouts.app')

@section('title', 'Lacak Status Aspirasi — NU Ranting Banjaranyar')

@section('content')
<!-- Header Banner -->
<section class="bg-gradient-to-r from-[#004125] to-[#0c5a37] text-white py-14">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 space-y-4">
        <nav class="flex items-center gap-2 text-xs text-emerald-200">
            <a href="{{ route('home') }}" class="hover:underline flex items-center gap-1">
                <span class="material-symbols-outlined text-[14px]">home</span>
                <span>Beranda</span>
            </a>
            <span>/</span>
            <a href="{{ route('aspirasi.create') }}" class="hover:underline">Kotak Aspirasi</a>
            <span>/</span>
            <span class="text-white font-semibold">Lacak Tiket</span>
        </nav>

        <h1 class="text-3xl sm:text-4xl font-extrabold tracking-tight">Pelacakan Status Aspirasi Warga</h1>
        <p class="text-xs sm:text-sm text-emerald-100 leading-relaxed">
            Pantau perkembangan dan tindak lanjut aduan atau masukan yang Anda kirimkan kepada pengurus ranting.
        </p>
    </div>
</section>

<div class="max-w-4xl mx-auto px-4 sm:px-6 py-10 space-y-8">
    
    <!-- Search / Track Form -->
    <div class="bg-white rounded-3xl p-6 sm:p-8 border border-[#e6eeff] shadow-sm space-y-4">
        <h2 class="text-base font-bold text-[#121c2a]">Masukkan Kode Tiket Aspirasi</h2>
        <form action="{{ route('aspirasi.track') }}" method="GET" class="flex flex-col sm:flex-row gap-3">
            <input type="text" name="kode_tiket" value="{{ $kodeTiket }}" placeholder="Contoh: ASP-2026-00001" required class="flex-1 bg-[#f8f9ff] px-4 py-3 rounded-xl text-sm font-mono text-[#121c2a] border border-[#dee9fc] focus:outline-none focus:border-[#004125] uppercase">
            <button type="submit" class="px-6 py-3 rounded-xl bg-[#004125] hover:bg-[#0c5a37] text-white font-bold text-xs shadow-sm transition-colors">
                Periksa Status
            </button>
        </form>
    </div>

    <!-- Tracking Result -->
    @if ($kodeTiket)
        @if ($aspiration)
            <div class="bg-white rounded-3xl p-6 sm:p-8 border border-[#e6eeff] shadow-sm space-y-6">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-4 border-b border-[#eff4ff]">
                    <div>
                        <span class="text-xs text-[#707971] block">Kode Resi</span>
                        <span class="text-lg font-mono font-extrabold text-[#004125]">{{ $aspiration->kode_tiket }}</span>
                    </div>

                    <div>
                        @if ($aspiration->status === 'Baru')
                            <span class="px-3 py-1 rounded-full text-xs font-bold bg-[#eff4ff] text-[#004125] border border-[#dee9fc]">
                                Status: Baru Diterima
                            </span>
                        @elseif ($aspiration->status === 'Dibaca')
                            <span class="px-3 py-1 rounded-full text-xs font-bold bg-blue-50 text-blue-700 border border-blue-200">
                                Status: Ditinjau Pengurus
                            </span>
                        @elseif ($aspiration->status === 'Diproses')
                            <span class="px-3 py-1 rounded-full text-xs font-bold bg-[#ffdcc3] text-[#6e3900] border border-[#ffb77d]">
                                Status: Sedang Diproses
                            </span>
                        @elseif ($aspiration->status === 'Selesai')
                            <span class="px-3 py-1 rounded-full text-xs font-bold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                Status: Selesai Ditindaklanjuti
                            </span>
                        @endif
                    </div>
                </div>

                <div class="space-y-2">
                    <span class="text-[11px] text-[#707971] block">Kategori: {{ $aspiration->kategori }} • Dikirim pada {{ $aspiration->created_at->format('d M Y, H:i') }} WIB</span>
                    <h3 class="text-lg font-bold text-[#121c2a]">{{ $aspiration->subjek }}</h3>
                    <p class="text-xs sm:text-sm text-[#404942] bg-[#f8f9ff] p-4 rounded-xl leading-relaxed">
                        "{{ $aspiration->pesan }}"
                    </p>
                </div>

                <!-- Admin Response Note (if available) -->
                @if ($aspiration->catatan_admin)
                    <div class="p-5 rounded-2xl bg-[#eff4ff] border border-[#dee9fc] space-y-2">
                        <div class="flex items-center gap-2 text-[#004125]">
                            <span class="material-symbols-outlined text-[20px]">reply</span>
                            <h4 class="text-xs font-bold uppercase tracking-wider">Catatan Tindak Lanjut Pengurus:</h4>
                        </div>
                        <p class="text-xs sm:text-sm text-[#121c2a] leading-relaxed">
                            {{ $aspiration->catatan_admin }}
                        </p>
                    </div>
                @else
                    <p class="text-xs text-[#707971] italic">
                        Pengurus harian sedang menelaah masukan ini. Silakan periksa kembali berkala.
                    </p>
                @endif
            </div>
        @else
            <div class="p-10 text-center bg-red-50 rounded-3xl border border-red-200 text-red-800 space-y-2">
                <span class="material-symbols-outlined text-[36px] text-red-500">search_off</span>
                <h3 class="text-base font-bold">Kode Tiket Tidak Ditemukan</h3>
                <p class="text-xs text-red-600">Pastikan nomor tiket yang Anda masukkan sesuai dengan yang tertera saat pengiriman (Contoh: ASP-2026-00001).</p>
            </div>
        @endif
    @endif

</div>
@endsection
