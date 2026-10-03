@extends('layouts.app')

@section('title', 'Verifikasi Keaslian KTA Nahdlatul Ulama — SIMNU Banjaranyar')

@section('content')
<!-- Header Banner with Trust Badges -->
<section class="bg-gradient-to-r from-[#004125] to-[#0c5a37] text-white py-14">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-4">
        <nav class="flex items-center gap-2 text-xs text-emerald-200">
            <a href="{{ route('home') }}" class="hover:underline flex items-center gap-1">
                <span class="material-symbols-outlined text-[14px]">home</span>
                <span>Beranda</span>
            </a>
            <span>/</span>
            <span class="text-white font-semibold">Verifikasi KTA SIMNU</span>
        </nav>

        <div class="space-y-3 max-w-3xl">
            <div class="flex flex-wrap items-center gap-2">
                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-white/10 text-xs font-semibold text-[#aaf2c4] border border-white/10">
                    <span class="material-symbols-outlined text-[14px]">verified</span>
                    <span>Sistem Autentikasi Keabsahan Kartu Digital & Fisik PBNU</span>
                </span>
                <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full bg-white/10 text-xs text-emerald-100">
                    <span class="material-symbols-outlined text-[14px]">lock</span>
                    <span>Enkripsi QR Code SHA-256</span>
                </span>
            </div>
            <h1 class="text-3xl sm:text-4xl font-extrabold tracking-tight">Verifikasi Keaslian KTA Nahdlatul Ulama</h1>
            <p class="text-xs sm:text-sm text-emerald-100 leading-relaxed">
                Pindai QR Code pada Kartu Tanda Anggota (KTA) fisik maupun e-KTA digital, atau masukkan Nomor Induk Anggota (NIA) / Nomor KTA untuk memvalidasi legalitas kader, masa amanah khidmat, dan status keabsahan secara instan.
            </p>
        </div>
    </div>
</section>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    
    <!-- 2-Column Console (Scanner Left + Manual Input Right) -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
        
        <!-- Left: Camera Viewfinder Scanner Simulation (6 cols) -->
        <div class="lg:col-span-6 bg-white rounded-3xl p-6 sm:p-8 border border-[#e6eeff] shadow-sm space-y-5">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-2">
                    <span class="w-2.5 h-2.5 rounded-full bg-[#fe932c]"></span>
                    <h2 class="text-base font-bold text-[#004125]">Pemindai Kamera Optik (Live Scanner)</h2>
                </div>
                <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full bg-[#eff4ff] text-xs font-bold text-[#004125]">
                    <span class="material-symbols-outlined text-[14px] text-emerald-600 animate-pulse">sensors</span>
                    <span>Scanner Aktif</span>
                </span>
            </div>

            <!-- Viewfinder Frame -->
            <div class="relative w-full aspect-video sm:aspect-square max-h-[380px] bg-[#002110] rounded-2xl overflow-hidden flex flex-col items-center justify-center p-6 text-white shadow-inner">
                <!-- Grid Overlay Background -->
                <div class="absolute inset-0 opacity-20 bg-[radial-gradient(#aaf2c4_1px,transparent_1px)] [background-size:16px_16px]"></div>

                <!-- Laser Target Box -->
                <div class="relative w-56 h-56 sm:w-64 sm:h-64 rounded-2xl border-2 border-dashed border-[#aaf2c4]/40 flex flex-col items-center justify-center p-4">
                    <!-- Scanner Corner Brackets -->
                    <span class="absolute top-0 left-0 w-6 h-6 border-t-4 border-l-4 border-[#aaf2c4] rounded-tl-lg"></span>
                    <span class="absolute top-0 right-0 w-6 h-6 border-t-4 border-r-4 border-[#aaf2c4] rounded-tr-lg"></span>
                    <span class="absolute bottom-0 left-0 w-6 h-6 border-b-4 border-l-4 border-[#aaf2c4] rounded-bl-lg"></span>
                    <span class="absolute bottom-0 right-0 w-6 h-6 border-b-4 border-r-4 border-[#aaf2c4] rounded-br-lg"></span>

                    <!-- Animated Red/Green Laser Bar -->
                    <div class="absolute inset-x-2 top-1/2 -translate-y-1/2 h-0.5 bg-gradient-to-r from-transparent via-[#aaf2c4] to-transparent shadow-[0_0_12px_#aaf2c4] animate-pulse"></div>

                    <!-- Inner Mockup Target -->
                    <div class="w-28 h-28 rounded-xl bg-white/10 backdrop-blur-md p-3 flex flex-col items-center justify-center gap-2 text-center border border-white/20">
                        <span class="material-symbols-outlined text-[36px] text-[#aaf2c4]">qr_code_scanner</span>
                        <span class="text-[10px] text-emerald-200">Arahkan QR KTA ke kotak ini</span>
                    </div>
                </div>

                <!-- Bottom Status Strip -->
                <div class="absolute bottom-3 inset-x-4 flex items-center justify-between px-3 py-1.5 rounded-xl bg-[#004125]/80 backdrop-blur-sm text-[11px] text-white">
                    <span class="flex items-center gap-1.5">
                        <span class="w-2 h-2 rounded-full bg-emerald-400 animate-ping"></span>
                        <span>Mencari QR Code... Enkripsi Terverifikasi</span>
                    </span>
                    <span class="font-mono text-[#aaf2c4]">60 FPS</span>
                </div>
            </div>

            <p class="text-xs text-[#707971] text-center">
                Arahkan kamera smartphone atau webcam ke QR Code pada kartu fisik / e-KTA digital.
            </p>
        </div>

        <!-- Right: Manual Input Console (6 cols) -->
        <div class="lg:col-span-6 bg-white rounded-3xl p-6 sm:p-8 border border-[#e6eeff] shadow-sm space-y-6">
            <div>
                <span class="text-xs font-bold text-[#904d00] uppercase tracking-wider block">Metode Manual</span>
                <h2 class="text-2xl font-extrabold text-[#004125] tracking-tight">Cek Nomor KTA / NIA</h2>
                <p class="text-xs text-[#404942] mt-1">Masukkan Nomor KTA atau Nomor Induk Anggota untuk memeriksa keabsahan data.</p>
            </div>

            <!-- Manual Form -->
            <form onsubmit="event.preventDefault(); var kta = document.getElementById('nomorKtaInput').value.trim(); if(kta) { window.location.href = '{{ url('/kta/verify') }}/' + encodeURIComponent(kta); }" class="space-y-4">
                <div>
                    <label for="nomorKtaInput" class="block text-xs font-bold text-[#121c2a] mb-1.5">
                        Nomor KTA Resmi <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <span class="material-symbols-outlined absolute left-3.5 top-1/2 -translate-y-1/2 text-gray-400 text-[20px]">badge</span>
                        <input type="text" id="nomorKtaInput" placeholder="Contoh: IPNU-2026-00001 atau ANSOR-2026-00001" required class="w-full bg-[#f8f9ff] pl-11 pr-4 py-3 rounded-xl text-xs sm:text-sm font-mono text-[#121c2a] border border-[#dee9fc] focus:bg-white focus:outline-none focus:border-[#004125] uppercase transition-all">
                    </div>
                    <p class="text-[11px] text-[#707971] mt-1">Format standar: [KODE_BANOM]-[TAHUN]-[5 DIGIT NOMOR]</p>
                </div>

                <button type="submit" class="w-full inline-flex items-center justify-center gap-2 py-3 px-6 rounded-xl bg-[#004125] hover:bg-[#0c5a37] text-white font-bold text-xs sm:text-sm shadow-md transition-all">
                    <span class="material-symbols-outlined text-[18px]">verified</span>
                    <span>Validasi Keabsahan Kartu</span>
                </button>
            </form>

            <!-- Example KTA Numbers from Seeders for Quick Demo Testing -->
            <div class="pt-4 border-t border-[#eff4ff] space-y-2.5">
                <span class="text-xs font-bold text-[#404942] block">Contoh Nomor KTA Terdaftar (Klik untuk Uji):</span>
                <div class="flex flex-wrap gap-2">
                    <a href="{{ route('kta.verify', 'IPNU-2026-00001') }}" class="px-2.5 py-1.5 rounded-lg bg-[#eff4ff] text-[#004125] font-mono text-xs font-bold hover:bg-[#dee9fc] transition-colors">
                        IPNU-2026-00001
                    </a>
                    <a href="{{ route('kta.verify', 'ANSOR-2026-00001') }}" class="px-2.5 py-1.5 rounded-lg bg-[#eff4ff] text-[#004125] font-mono text-xs font-bold hover:bg-[#dee9fc] transition-colors">
                        ANSOR-2026-00001
                    </a>
                    <a href="{{ route('kta.verify', 'BANSER-2026-00001') }}" class="px-2.5 py-1.5 rounded-lg bg-[#eff4ff] text-[#004125] font-mono text-xs font-bold hover:bg-[#dee9fc] transition-colors">
                        BANSER-2026-00001
                    </a>
                    <a href="{{ route('kta.verify', 'FATAYAT-2026-00001') }}" class="px-2.5 py-1.5 rounded-lg bg-[#eff4ff] text-[#004125] font-mono text-xs font-bold hover:bg-[#dee9fc] transition-colors">
                        FATAYAT-2026-00001
                    </a>
                </div>
            </div>

            <!-- Guarantee Box -->
            <div class="p-4 rounded-2xl bg-[#eff4ff] border border-[#dee9fc] space-y-1.5">
                <div class="flex items-center gap-2 text-[#004125]">
                    <span class="material-symbols-outlined text-[18px]">shield</span>
                    <span class="text-xs font-bold">Privasi Data Dilindungi</span>
                </div>
                <p class="text-[11px] text-[#404942] leading-relaxed">
                    Halaman verifikasi hanya menampilkan nama, keanggotaan badan otonom, jabatan, dan masa berlaku guna menghindari kebocoran data pribadi sensitif (seperti NIK atau nomor telepon).
                </p>
            </div>
        </div>

    </div>

</div>
@endsection
