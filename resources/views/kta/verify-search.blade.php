@extends('layouts.app')

@section('title', 'Cek & Verifikasi Kartu Tanda Anggota (KTA) — SIMNU Banjaranyar')

@section('content')
<!-- Header Banner with Trust Badges -->
<section class="bg-gradient-to-r from-[#004125] to-[#0c5a37] text-white py-12 sm:py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-4">
        <nav class="flex items-center gap-2 text-xs text-emerald-200">
            <a href="{{ route('home') }}" class="hover:underline flex items-center gap-1">
                <span class="material-symbols-outlined text-[14px]">home</span>
                <span>Beranda</span>
            </a>
            <span>/</span>
            <span class="text-white font-semibold">Cek & Cetak KTA</span>
        </nav>

        <div class="space-y-3 max-w-3xl">
            <div class="flex flex-wrap items-center gap-2">
                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-white/10 text-xs font-semibold text-[#aaf2c4] border border-white/10">
                    <span class="material-symbols-outlined text-[14px]">badge</span>
                    <span>Layanan Resmi Verifikasi & Cetak Mandiri</span>
                </span>
                <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full bg-white/10 text-xs text-emerald-100">
                    <span class="material-symbols-outlined text-[14px]">shield</span>
                    <span>Verifikasi Keamanan Ganda (2-Faktor)</span>
                </span>
            </div>
            <h1 class="text-3xl sm:text-4xl font-extrabold tracking-tight">Cek & Cetak Kartu Tanda Anggota (KTA)</h1>
            <p class="text-xs sm:text-base text-emerald-100 leading-relaxed">
                Warga dan kader Nahdlatul Ulama Ranting Banjaranyar dapat memeriksa status keabsahan KTA serta mencetak kartu fisik atau mengunduh PDF dengan memasukkan Nomor KTA dan Tanggal Lahir resmi yang terdaftar.
            </p>
        </div>
    </div>
</section>

<div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-10 sm:py-14 space-y-12">
    
    <!-- ================= FORM PENCARIAN 2-FAKTOR (NOMOR KTA + TANGGAL LAHIR) ================= -->
    <div class="bg-white rounded-3xl p-6 sm:p-10 border-2 border-[#e6eeff] shadow-md space-y-8">
        <div class="max-w-2xl">
            <span class="text-xs font-bold text-[#fe932c] uppercase tracking-wider block">Verifikasi Keaslian KTA</span>
            <h2 class="text-2xl sm:text-3xl font-extrabold text-[#004125] tracking-tight">Masukkan Data KTA Anda</h2>
            <p class="text-xs sm:text-sm text-[#404942] mt-1">
                Demi perlindungan data pribadi anggota, masukkan <strong>Nomor KTA</strong> dan <strong>Tanggal Lahir</strong> pemilik kartu untuk memvalidasi identitas.
            </p>
        </div>

        <form action="{{ route('kta.verify.search') }}" method="GET" class="space-y-6">
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                <!-- Input 1: Nomor KTA -->
                <div>
                    <label for="nomorKtaInput" class="block text-xs font-bold text-[#121c2a] mb-2">
                        Nomor KTA Resmi <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <span class="material-symbols-outlined absolute left-3.5 top-1/2 -translate-y-1/2 text-gray-400 text-[20px]">badge</span>
                        <input type="text" id="nomorKtaInput" name="nomor_kta" value="{{ $nomorKta ?? '' }}" placeholder="Contoh: IPNU-2026-00001" required class="w-full bg-white pl-11 pr-4 py-3.5 rounded-xl text-xs sm:text-sm font-mono font-bold text-[#121c2a] border border-[#dee9fc] focus:outline-none focus:border-[#004125] shadow-sm uppercase">
                    </div>
                    <p class="text-[11px] text-[#707971] mt-1.5">Ketikkan nomor seri KTA persis seperti yang tertera pada kartu.</p>
                </div>

                <!-- Input 2: Tanggal Lahir (Verifikasi Kedua) -->
                <div>
                    <label for="tglLahirInput" class="block text-xs font-bold text-[#121c2a] mb-2">
                        Tanggal Lahir Anggota <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <span class="material-symbols-outlined absolute left-3.5 top-1/2 -translate-y-1/2 text-gray-400 text-[20px]">calendar_today</span>
                        <input type="date" id="tglLahirInput" name="tanggal_lahir" value="{{ $tanggalLahir ?? '' }}" required class="w-full bg-white pl-11 pr-4 py-3.5 rounded-xl text-xs sm:text-sm font-bold text-[#121c2a] border border-[#dee9fc] focus:outline-none focus:border-[#004125] shadow-sm">
                    </div>
                    <p class="text-[11px] text-[#707971] mt-1.5">Sesuai tanggal lahir yang tercatat di buku induk.</p>
                </div>
            </div>

            <div class="flex flex-col sm:flex-row items-center gap-3 pt-2">
                <button type="submit" class="w-full sm:w-auto inline-flex items-center justify-center gap-2 py-3.5 px-8 rounded-xl bg-[#004125] hover:bg-[#0c5a37] text-white font-extrabold text-xs sm:text-sm shadow-md transition-all">
                    <span class="material-symbols-outlined text-[20px] text-[#fe932c]">search</span>
                    <span>Periksa & Cari KTA</span>
                </button>
                @if(!empty($searched))
                    <a href="{{ route('kta.verify.search') }}" class="w-full sm:w-auto inline-flex items-center justify-center gap-1.5 py-3.5 px-5 rounded-xl border border-gray-300 text-gray-700 hover:bg-gray-50 font-bold text-xs transition">
                        <span class="material-symbols-outlined text-[16px]">refresh</span>
                        <span>Reset Pencarian</span>
                    </a>
                @endif
            </div>
        </form>

        <!-- ================= HASIL VERIFIKASI ================= -->
        @if(!empty($searched))
            @if($foundKta)
                <div class="p-6 sm:p-8 bg-emerald-50 border-2 border-emerald-500 rounded-2xl space-y-6">
                    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 border-b border-emerald-200 pb-4">
                        <div class="flex items-center gap-3">
                            <span class="w-12 h-12 rounded-2xl bg-emerald-600 text-white flex items-center justify-center shrink-0 shadow-md">
                                <span class="material-symbols-outlined text-[28px]">verified</span>
                            </span>
                            <div>
                                <span class="text-xs font-bold uppercase tracking-wider text-emerald-800">Data Anggota Ditemukan & Valid</span>
                                <h3 class="text-xl sm:text-2xl font-black text-emerald-950">{{ $foundKta->member?->nama_lengkap ?? 'Kader NU' }}</h3>
                                <p class="text-xs text-emerald-800 font-mono">
                                    No. KTA: <strong>{{ $foundKta->nomor_kta }}</strong> • Banom: {{ $foundKta->member?->banom?->singkatan ?? 'NU' }} • Jabatan: {{ $foundKta->member?->jabatan_kta ?? 'Anggota' }}
                                </p>
                            </div>
                        </div>

                        <!-- TOMBOL CETAK & PDF -->
                        <div class="flex flex-wrap items-center gap-3">
                            <a href="{{ route('kta.public.print', $foundKta->nomor_kta) }}" target="_blank" class="px-6 py-3.5 rounded-2xl bg-[#004125] hover:bg-[#0c5a37] text-white font-black text-sm flex items-center justify-center gap-2.5 shadow-lg transition hover:scale-105">
                                <span class="material-symbols-outlined text-[22px] text-[#fe932c]">print</span>
                                <span>Cetak KTA Sekarang</span>
                            </a>
                            <a href="{{ route('kta.public.download', $foundKta->nomor_kta) }}" target="_blank" class="px-5 py-3.5 rounded-2xl bg-[#fe932c] hover:bg-[#ff8000] text-[#2f1500] font-black text-sm flex items-center justify-center gap-2 shadow-lg transition hover:scale-105">
                                <span class="material-symbols-outlined text-[20px]">picture_as_pdf</span>
                                <span>Unduh PDF</span>
                            </a>
                            <a href="{{ route('kta.verify', $foundKta->nomor_kta) }}" class="px-4 py-3.5 rounded-2xl bg-white border border-emerald-300 text-emerald-900 font-bold text-xs flex items-center justify-center gap-1.5 shadow-sm hover:bg-emerald-100 transition">
                                <span class="material-symbols-outlined text-[18px]">visibility</span>
                                <span>Detail Lengkap</span>
                            </a>
                        </div>
                    </div>

                    <!-- Mini Preview Kartu Standar ISO ID-1 -->
                    <div class="flex flex-col sm:flex-row items-center justify-center gap-6 pt-2">
                        <div class="w-full max-w-sm bg-gradient-to-br from-[#003820] via-[#004d2c] to-[#012213] text-white p-4 rounded-2xl border-2 border-[#fe932c]/50 shadow-xl relative overflow-hidden">
                            <div class="flex items-center justify-between border-b border-white/20 pb-2 mb-2">
                                <div class="flex items-center gap-2">
                                    <div class="w-6 h-6 rounded-full bg-[#fe932c] text-[#2f1500] flex items-center justify-center font-black text-[10px]">NU</div>
                                    <span class="text-[10px] font-black tracking-wider text-emerald-200">KARTU TANDA ANGGOTA</span>
                                </div>
                                <span class="text-[9px] font-mono text-emerald-300">{{ $foundKta->nomor_kta }}</span>
                            </div>
                            <div class="flex items-center gap-3 py-1">
                                <div class="w-12 h-14 rounded-lg bg-white/10 border border-white/20 flex items-center justify-center text-white shrink-0 overflow-hidden">
                                    @if($foundKta->member?->foto)
                                        <img src="{{ asset('storage/' . $foundKta->member?->foto) }}" alt="{{ $foundKta->member?->nama_lengkap ?? 'Foto' }}" class="w-full h-full object-cover">
                                    @else
                                        <span class="material-symbols-outlined text-[28px]">person</span>
                                    @endif
                                </div>
                                <div class="space-y-0.5">
                                    <div class="text-xs font-black">{{ $foundKta->member?->nama_lengkap ?? 'Kader NU' }}</div>
                                    <div class="text-[10px] text-emerald-300">{{ $foundKta->member?->banom?->nama ?? 'Nahdlatul Ulama' }}</div>
                                    <div class="text-[9px] text-emerald-200">{{ $foundKta->member?->jabatan_kta ?? 'Anggota' }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <!-- PESAN UMUM SAAT GAGAL: "Data tidak ditemukan" -->
                <div class="p-6 bg-amber-50 border border-amber-300 rounded-2xl text-amber-900 space-y-2">
                    <div class="flex items-center gap-2 font-bold text-sm">
                        <span class="material-symbols-outlined text-amber-600">info</span>
                        <span>Data tidak ditemukan</span>
                    </div>
                    <p class="text-xs text-amber-800">
                        Pastikan Nomor KTA dan Tanggal Lahir yang Anda masukkan sudah sesuai dengan data yang terdaftar. Jika Anda merasa data sudah benar namun belum terdaftar, silakan hubungi pengurus sekretariat ranting.
                    </p>
                </div>
            @endif
        @endif

    </div>

    <!-- ================= OPSI ALTERNATIF: PEMINDAI KAMERA OPTIK (SCANNER QR KTA) ================= -->
    <div class="bg-white rounded-3xl p-6 sm:p-8 border border-[#e6eeff] shadow-sm space-y-6">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <span class="text-xs font-bold text-[#fe932c] uppercase tracking-wider block">Opsi Alternatif</span>
                <h3 class="text-xl font-extrabold text-[#004125]">Pindai Kamera Optik (QR Scanner)</h3>
                <p class="text-xs text-[#526350]">Arahkan kamera smartphone ke QR Code pada kartu fisik KTA untuk verifikasi keabsahan langsung.</p>
            </div>
            <button type="button" onclick="document.getElementById('scannerSection').classList.toggle('hidden')" class="px-4 py-2.5 rounded-xl border border-[#dee9fc] bg-[#f8f9ff] hover:bg-[#eff4ff] text-[#004125] font-bold text-xs flex items-center gap-2 transition w-fit">
                <span class="material-symbols-outlined text-[18px]">photo_camera</span>
                <span>Buka / Tutup Pemindai Kamera</span>
            </button>
        </div>

        <div id="scannerSection" class="hidden pt-4 border-t border-[#eff4ff]">
            <div class="relative w-full max-w-lg mx-auto aspect-video sm:aspect-square max-h-[340px] bg-[#002110] rounded-2xl overflow-hidden flex flex-col items-center justify-center p-6 text-white shadow-inner">
                <div class="relative w-48 h-48 rounded-2xl border-2 border-dashed border-[#aaf2c4]/40 flex flex-col items-center justify-center p-4">
                    <span class="absolute top-0 left-0 w-5 h-5 border-t-4 border-l-4 border-[#aaf2c4] rounded-tl-lg"></span>
                    <span class="absolute top-0 right-0 w-5 h-5 border-t-4 border-r-4 border-[#aaf2c4] rounded-tr-lg"></span>
                    <span class="absolute bottom-0 left-0 w-5 h-5 border-b-4 border-l-4 border-[#aaf2c4] rounded-bl-lg"></span>
                    <span class="absolute bottom-0 right-0 w-5 h-5 border-b-4 border-r-4 border-[#aaf2c4] rounded-br-lg"></span>
                    <div class="w-24 h-24 rounded-xl bg-white/10 backdrop-blur-md p-3 flex flex-col items-center justify-center gap-1 text-center border border-white/20">
                        <span class="material-symbols-outlined text-[32px] text-[#aaf2c4]">qr_code_scanner</span>
                        <span class="text-[9px] text-emerald-200">Arahkan QR KTA ke kotak ini</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection
