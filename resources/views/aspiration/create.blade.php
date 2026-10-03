@extends('layouts.app')

@section('title', 'Kotak Aspirasi & Saran Warga — NU Ranting Banjaranyar')

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
            <span class="text-white font-semibold">Kotak Aspirasi Warga</span>
        </nav>

        <div class="space-y-2 max-w-3xl">
            <div class="inline-flex items-center gap-2 bg-white/10 px-3 py-1 rounded-full text-xs font-semibold text-[#aaf2c4]">
                <span class="material-symbols-outlined text-[15px]">shield</span>
                <span>Keterbukaan & Tabayyun Jamaah Desa</span>
            </div>
            <h1 class="text-3xl sm:text-4xl font-extrabold tracking-tight">Kotak Saran & Aspirasi Masyarakat</h1>
            <p class="text-xs sm:text-sm text-emerald-100 leading-relaxed">
                Wadah resmi khidmah warga Nahdliyin Banjaranyar untuk menyampaikan usulan keagamaan, kemakmuran masjid/musholla, dan kepedulian sosial secara santun dan bermartabat.
            </p>
        </div>
    </div>
</section>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    
    <!-- Success Ticket Modal / Box -->
    @if (session('kode_tiket'))
        <div class="mb-10 bg-emerald-50 border-2 border-emerald-400 p-6 sm:p-8 rounded-3xl shadow-sm text-[#002110] space-y-4">
            <div class="flex items-center gap-3">
                <div class="w-12 h-12 rounded-2xl bg-emerald-600 text-white flex items-center justify-center font-bold">
                    <span class="material-symbols-outlined text-[28px]">mark_email_read</span>
                </div>
                <div>
                    <h3 class="text-lg font-extrabold text-emerald-900">Aspirasi Berhasil Diterima!</h3>
                    <p class="text-xs text-emerald-700">Simpan nomor resi berikut untuk memantau proses tindak lanjut oleh pengurus.</p>
                </div>
            </div>

            <div class="bg-white p-4 rounded-2xl border border-emerald-200 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                <div>
                    <span class="text-xs text-[#707971] block">Nomor Resi / Tiket Aspirasi:</span>
                    <span class="text-xl sm:text-2xl font-mono font-extrabold text-[#004125]">{{ session('kode_tiket') }}</span>
                </div>
                <a href="{{ route('aspirasi.track', ['kode_tiket' => session('kode_tiket')]) }}" class="px-5 py-2.5 rounded-xl bg-[#0c5a37] text-white font-bold text-xs hover:bg-[#004125] transition-colors self-start sm:self-center">
                    Cek Status Tindak Lanjut →
                </a>
            </div>
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 items-start">
        
        <!-- Left: Form Container (7 cols) -->
        <div class="lg:col-span-7 bg-white rounded-3xl p-6 sm:p-10 border border-[#e6eeff] shadow-sm space-y-6">
            <div>
                <span class="text-xs font-bold text-[#904d00] uppercase tracking-wider block">Formulir Suara Jamaah</span>
                <h2 class="text-2xl font-extrabold text-[#004125] tracking-tight">Kirim Gagasan & Masukan</h2>
            </div>

            <form action="{{ route('aspirasi.store') }}" method="POST" class="space-y-5">
                @csrf

                <!-- Nama Lengkap -->
                <div>
                    <label for="nama" class="block text-xs font-bold text-[#121c2a] mb-1.5">
                        Nama Lengkap / Inisial <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="nama" id="nama" value="{{ old('nama') }}" required placeholder="Contoh: H. M. Sholihin atau Inisial (Bila aduan sensitif)" class="w-full bg-[#f8f9ff] px-4 py-3 rounded-xl text-xs sm:text-sm text-[#121c2a] border border-[#dee9fc] focus:bg-white focus:outline-none focus:border-[#004125] transition-all @error('nama') border-red-400 @enderror">
                    @error('nama')
                        <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Kontak WhatsApp (Opsional) -->
                <div>
                    <label for="kontak" class="block text-xs font-bold text-[#121c2a] mb-1.5">
                        Nomor WhatsApp atau Email <span class="text-gray-400 font-normal">(Opsional)</span>
                    </label>
                    <input type="text" name="kontak" id="kontak" value="{{ old('kontak') }}" placeholder="0812-xxxx-xxxx (Digunakan pengurus bila butuh konfirmasi lanjutan)" class="w-full bg-[#f8f9ff] px-4 py-3 rounded-xl text-xs sm:text-sm text-[#121c2a] border border-[#dee9fc] focus:bg-white focus:outline-none focus:border-[#004125] transition-all">
                </div>

                <!-- Kategori Aspirasi (Radio Chips) -->
                <div>
                    <label class="block text-xs font-bold text-[#121c2a] mb-2">
                        Kategori Aspirasi <span class="text-red-500">*</span>
                    </label>
                    <div class="grid grid-cols-2 sm:grid-cols-3 gap-2">
                        @foreach (['Saran', 'Kritik', 'Aspirasi', 'Pengaduan', 'Pertanyaan'] as $kat)
                            <label class="cursor-pointer">
                                <input type="radio" name="kategori" value="{{ $kat }}" class="peer sr-only" {{ old('kategori', 'Aspirasi') === $kat ? 'checked' : '' }}>
                                <div class="p-3 rounded-xl text-center text-xs font-semibold bg-[#f8f9ff] border border-[#dee9fc] peer-checked:bg-[#0c5a37] peer-checked:text-white peer-checked:border-[#0c5a37] transition-all">
                                    {{ $kat }}
                                </div>
                            </label>
                        @endforeach
                    </div>
                </div>

                <!-- Subjek -->
                <div>
                    <label for="subjek" class="block text-xs font-bold text-[#121c2a] mb-1.5">
                        Subjek / Topik Masukan <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="subjek" id="subjek" value="{{ old('subjek') }}" required placeholder="Contoh: Usulan Perbaikan Penerangan Musholla Dusun Krajan" class="w-full bg-[#f8f9ff] px-4 py-3 rounded-xl text-xs sm:text-sm text-[#121c2a] border border-[#dee9fc] focus:bg-white focus:outline-none focus:border-[#004125] transition-all @error('subjek') border-red-400 @enderror">
                    @error('subjek')
                        <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Pesan -->
                <div>
                    <label for="pesan" class="block text-xs font-bold text-[#121c2a] mb-1.5">
                        Uraian Pesan / Masukan Lengkap <span class="text-red-500">*</span>
                    </label>
                    <textarea name="pesan" id="pesan" rows="5" required placeholder="Tuliskan saran, pertanyaan, atau laporan Anda secara jelas dan santun..." class="w-full bg-[#f8f9ff] px-4 py-3 rounded-xl text-xs sm:text-sm text-[#121c2a] border border-[#dee9fc] focus:bg-white focus:outline-none focus:border-[#004125] transition-all @error('pesan') border-red-400 @enderror">{{ old('pesan') }}</textarea>
                    @error('pesan')
                        <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Submit Button -->
                <div class="pt-2">
                    <button type="submit" class="w-full inline-flex items-center justify-center gap-2 py-3.5 px-6 rounded-xl bg-[#004125] hover:bg-[#0c5a37] text-white font-bold text-sm shadow-md transition-all">
                        <span class="material-symbols-outlined text-[20px]">send</span>
                        <span>Kirim Aspirasi ke Pengurus Ranting</span>
                    </button>
                </div>
            </form>
        </div>

        <!-- Right: Privacy Guarantee & Tracking (5 cols) -->
        <div class="lg:col-span-5 space-y-6">
            
            <!-- Privacy Guarantee Card -->
            <div class="bg-gradient-to-br from-[#0c5a37] to-[#002110] text-white rounded-3xl p-6 sm:p-8 space-y-4 shadow-md">
                <div class="flex items-center gap-3 text-[#fe932c]">
                    <span class="material-symbols-outlined text-[28px]">verified_user</span>
                    <h3 class="text-lg font-bold">Jaminan Kerahasiaan Data</h3>
                </div>
                <p class="text-xs text-emerald-100/90 leading-relaxed">
                    Identitas Anda dilindungi secara ketat. Aspirasi Anda ditelaah secara tertutup oleh Tim Khidmah Syuriyah & Tanfidziyah tanpa dipublikasikan secara terbuka ke pihak mana pun tanpa izin Anda.
                </p>
                <div class="pt-2 border-t border-white/10 space-y-2 text-xs text-emerald-200">
                    <div class="flex items-center gap-2">
                        <span class="w-2 h-2 rounded-full bg-[#aaf2c4]"></span>
                        <span>Privasi Warga Terjamin 100%</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="w-2 h-2 rounded-full bg-[#fe932c]"></span>
                        <span>Resi Pelacakan Terenkripsi</span>
                    </div>
                </div>
            </div>

            <!-- Quick Track Box -->
            <div class="bg-white rounded-3xl p-6 border border-[#e6eeff] shadow-sm space-y-4">
                <div class="flex items-center gap-2 text-[#004125]">
                    <span class="material-symbols-outlined text-[22px]">manage_search</span>
                    <h3 class="text-base font-bold">Lacak Status Aspirasi Sebelumnya</h3>
                </div>
                <p class="text-xs text-[#404942]">Sudah pernah mengirim masukan? Masukkan nomor tiket Anda untuk memantau status respon pengurus.</p>
                <form action="{{ route('aspirasi.track') }}" method="GET" class="flex gap-2">
                    <input type="text" name="kode_tiket" placeholder="Contoh: ASP-2026-00001" required class="flex-1 bg-[#f8f9ff] px-3.5 py-2.5 rounded-xl text-xs text-[#121c2a] border border-[#dee9fc] focus:outline-none focus:border-[#004125]">
                    <button type="submit" class="px-4 py-2.5 rounded-xl bg-[#0c5a37] text-white font-bold text-xs hover:bg-[#004125] transition-colors">
                        Lacak
                    </button>
                </form>
            </div>

        </div>

    </div>

</div>
@endsection
