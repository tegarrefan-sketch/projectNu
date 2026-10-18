@extends('layouts.app')

@section('title', 'Hasil Verifikasi KTA: ' . $nomor_kta . ' — SIMNU Banjaranyar')

@section('content')
<!-- Header Banner -->
<section class="bg-gradient-to-r from-[#004125] to-[#0c5a37] text-white py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-4">
        <nav class="flex items-center gap-2 text-xs text-emerald-200">
            <a href="{{ route('home') }}" class="hover:underline flex items-center gap-1">
                <span class="material-symbols-outlined text-[14px]">home</span>
                <span>Beranda</span>
            </a>
            <span>/</span>
            <a href="{{ route('kta.verify.search') }}" class="hover:underline">Verifikasi KTA</a>
            <span>/</span>
            <span class="text-white font-semibold">{{ $nomor_kta }}</span>
        </nav>

        <div class="space-y-2">
            <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full bg-white/10 text-xs font-semibold text-[#aaf2c4] border border-white/10">
                <span class="material-symbols-outlined text-[14px]">shield_check</span>
                <span>Audit & Otentikasi Terpusat Keanggotaan</span>
            </span>
            <h1 class="text-3xl font-extrabold tracking-tight">Hasil Verifikasi Keaslian KTA</h1>
            <p class="text-xs sm:text-sm text-emerald-100 max-w-2xl">
                Sistem Basis Data Digital Pengurus Ranting Nahdlatul Ulama Desa Banjaranyar secara langsung memvalidasi keabsahan nomor seri dan QR Code fisik KTA.
            </p>
        </div>
    </div>
</section>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    @if($kta)
        @php
            $isAktif = strtolower($kta->status) === 'aktif' && (!$kta->tanggal_berlaku || $kta->tanggal_berlaku->isFuture());
            $isKadaluarsa = strtolower($kta->status) === 'kadaluarsa' || ($kta->tanggal_berlaku && $kta->tanggal_berlaku->isPast());
        @endphp

        @if($isAktif)
            <!-- VALID STATE -->
            <div class="space-y-10">
                <!-- Status Banner: VALID -->
                <div class="bg-emerald-50 border-2 border-emerald-500 rounded-3xl p-6 sm:p-8 shadow-sm flex flex-col md:flex-row items-start md:items-center justify-between gap-6">
                    <div class="flex items-start gap-4">
                        <div class="w-14 h-14 rounded-2xl bg-emerald-600 text-white flex items-center justify-center shrink-0 shadow-lg shadow-emerald-600/20">
                            <span class="material-symbols-outlined text-3xl">verified</span>
                        </div>
                        <div class="space-y-1">
                            <div class="flex items-center gap-2">
                                <span class="px-2.5 py-0.5 rounded-full text-xs font-bold uppercase tracking-wider bg-emerald-600 text-white">Resmi & Terdaftar</span>
                                <span class="text-xs text-emerald-800 font-medium">Validitas Terkonfirmasi</span>
                            </div>
                            <h2 class="text-2xl font-black text-emerald-950">✓ KTA TERDAFTAR</h2>
                            <p class="text-sm text-emerald-800">
                                Kartu Tanda Anggota ini sah dan terdaftar resmi pada basis data Pengurus Ranting Nahdlatul Ulama Banjaranyar.
                            </p>
                        </div>
                    </div>

                    <div class="flex flex-wrap items-center gap-3 w-full md:w-auto">
                        <a href="{{ route('kta.public.print', $kta->nomor_kta) }}" target="_blank" class="w-full sm:w-auto text-center px-5 py-3 rounded-2xl bg-[#004125] hover:bg-[#0c5a37] text-white text-xs sm:text-sm font-black transition flex items-center justify-center gap-2 shadow-md">
                            <span class="material-symbols-outlined text-[20px] text-[#fe932c]">print</span>
                            <span>Cetak Kartu Tanda Anggota</span>
                        </a>
                        <a href="{{ route('kta.public.download', $kta->nomor_kta) }}" target="_blank" class="w-full sm:w-auto text-center px-4 py-3 rounded-2xl bg-[#fe932c] hover:bg-[#ff8000] text-[#2f1500] text-xs sm:text-sm font-black transition flex items-center justify-center gap-2 shadow-md">
                            <span class="material-symbols-outlined text-[20px]">picture_as_pdf</span>
                            <span>Unduh PDF</span>
                        </a>
                        <a href="{{ route('kta.verify.search') }}" class="w-full sm:w-auto text-center px-4 py-3 rounded-2xl border border-emerald-300 text-emerald-900 bg-white hover:bg-emerald-100 text-xs font-bold transition flex items-center justify-center gap-1.5 shadow-sm">
                            <span class="material-symbols-outlined text-[18px]">qr_code_scanner</span>
                            <span>Pindai Lainnya</span>
                        </a>
                    </div>
                </div>

                <!-- Two Column Details + Virtual Card -->
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
                    
                    <!-- Left: Verified Data Specs (7 cols) -->
                    <div class="lg:col-span-7 bg-white rounded-3xl p-6 sm:p-8 border border-[#e6eeff] shadow-sm space-y-6">
                        <div class="border-b border-[#e6eeff] pb-4 flex items-center justify-between">
                            <div>
                                <h3 class="text-lg font-bold text-[#004125]">Informasi Resmi Anggota / Kader</h3>
                                <p class="text-xs text-[#526350]">Diverifikasi oleh Sistem Informasi Keanggotaan Terpadu Ranting Banjaranyar</p>
                            </div>
                            <span class="material-symbols-outlined text-emerald-600">badge</span>
                        </div>

                        <dl class="divide-y divide-[#f2f4f8] text-sm">
                            <div class="py-3.5 sm:grid sm:grid-cols-3 sm:gap-4 items-center">
                                <dt class="text-xs font-bold uppercase text-[#526350] tracking-wider">Nama Lengkap</dt>
                                <dd class="mt-1 font-bold text-gray-900 sm:col-span-2 sm:mt-0 text-base flex items-center gap-2">
                                    <span>{{ $kta->member?->nama_lengkap ?? 'Anggota' }}</span>
                                    <span class="material-symbols-outlined text-emerald-600 text-[18px]">verified_user</span>
                                </dd>
                            </div>

                            <div class="py-3.5 sm:grid sm:grid-cols-3 sm:gap-4 items-center">
                                <dt class="text-xs font-bold uppercase text-[#526350] tracking-wider">Badan Otonom (BANOM)</dt>
                                <dd class="mt-1 text-gray-900 sm:col-span-2 sm:mt-0 flex items-center gap-2">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-emerald-100 text-[#004125]">
                                        {{ $kta->member?->banom?->singkatan ?? 'NU' }}
                                    </span>
                                    <span class="text-xs text-[#526350]">({{ $kta->member?->banom?->nama ?? 'Nahdlatul Ulama' }})</span>
                                </dd>
                            </div>

                            <div class="py-3.5 sm:grid sm:grid-cols-3 sm:gap-4 items-center">
                                <dt class="text-xs font-bold uppercase text-[#526350] tracking-wider">Nomor KTA</dt>
                                <dd class="mt-1 font-mono font-bold text-[#004125] text-sm sm:col-span-2 sm:mt-0 bg-emerald-50 px-2.5 py-1 rounded-md inline-block w-fit">
                                    {{ $kta->nomor_kta }}
                                </dd>
                            </div>

                            <div class="py-3.5 sm:grid sm:grid-cols-3 sm:gap-4 items-center">
                                <dt class="text-xs font-bold uppercase text-[#526350] tracking-wider">Amanah / Jabatan KTA</dt>
                                <dd class="mt-1 text-gray-900 font-bold sm:col-span-2 sm:mt-0 text-[#004125]">
                                    {{ $kta->member?->jabatan_kta ?? 'Anggota' }}
                                </dd>
                            </div>

                            <div class="py-3.5 sm:grid sm:grid-cols-3 sm:gap-4 items-center">
                                <dt class="text-xs font-bold uppercase text-[#526350] tracking-wider">Status Keanggotaan</dt>
                                <dd class="mt-1 sm:col-span-2 sm:mt-0">
                                    <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-bold bg-amber-100 text-amber-900 border border-amber-300">
                                        {{ $kta->member?->status_keanggotaan ?? 'Anggota' }}
                                    </span>
                                </dd>
                            </div>

                            <div class="py-3.5 sm:grid sm:grid-cols-3 sm:gap-4 items-center">
                                <dt class="text-xs font-bold uppercase text-[#526350] tracking-wider">Status Keaktifan KTA</dt>
                                <dd class="mt-1 sm:col-span-2 sm:mt-0">
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-extrabold bg-emerald-500 text-white shadow-sm shadow-emerald-500/20">
                                        <span class="w-1.5 h-1.5 rounded-full bg-white animate-pulse"></span>
                                        <span>{{ $kta->status ?? 'Aktif' }}</span>
                                    </span>
                                </dd>
                            </div>

                            <div class="py-3.5 sm:grid sm:grid-cols-3 sm:gap-4 items-center">
                                <dt class="text-xs font-bold uppercase text-[#526350] tracking-wider">Masa Berlaku</dt>
                                <dd class="mt-1 text-gray-900 sm:col-span-2 sm:mt-0 flex items-center gap-2">
                                    <span class="font-semibold">
                                        {{ $kta->tanggal_terbit ? $kta->tanggal_terbit->translatedFormat('d M Y') : '-' }}
                                    </span>
                                    <span class="text-xs text-gray-400">s/d</span>
                                    <span class="font-semibold text-emerald-800">
                                        {{ $kta->tanggal_berlaku ? $kta->tanggal_berlaku->translatedFormat('d M Y') : 'Seumur Hidup' }}
                                    </span>
                                </dd>
                            </div>

                            <div class="py-3.5 sm:grid sm:grid-cols-3 sm:gap-4 items-center">
                                <dt class="text-xs font-bold uppercase text-[#526350] tracking-wider">Basis Wilayah</dt>
                                <dd class="mt-1 text-gray-900 font-medium sm:col-span-2 sm:mt-0">
                                    Ranting Desa Banjaranyar, Kec. Baureno, Kab. Bojonegoro
                                </dd>
                            </div>
                        </dl>

                        <!-- Privacy Notice -->
                        <div class="p-4 rounded-2xl bg-[#f8fafc] border border-gray-200 text-xs text-[#526350] flex items-start gap-3">
                            <span class="material-symbols-outlined text-[#004125] text-lg shrink-0">policy</span>
                            <p class="leading-relaxed">
                                <strong>Perlindungan Data Pribadi:</strong> Demi privasi dan kepatuhan hukum, data sensitif (NIK, alamat detil, dan kontak telepon) tidak ditampilkan di halaman verifikasi publik.
                            </p>
                        </div>
                    </div>

                    <!-- Right: Digital PVC Replica Card (5 cols) -->
                    <div class="lg:col-span-5 space-y-6">
                        <div class="bg-white rounded-3xl p-6 border border-[#e6eeff] shadow-sm space-y-4">
                            <div class="flex items-center justify-between">
                                <h3 class="text-sm font-bold text-[#004125] flex items-center gap-1.5">
                                    <span class="material-symbols-outlined text-emerald-600 text-[18px]">credit_card</span>
                                    <span>Tampilan Kartu Digital (e-KTA)</span>
                                </h3>
                                <span class="text-[10px] font-bold uppercase tracking-wider text-emerald-700 bg-emerald-100 px-2 py-0.5 rounded-full">Depan</span>
                            </div>

                            <!-- CARD FRONT PREVIEW -->
                            <div class="w-full aspect-[85.6/54] rounded-2xl bg-gradient-to-br from-[#003820] via-[#004d2c] to-[#012616] text-white p-5 shadow-xl relative overflow-hidden flex flex-col justify-between border border-emerald-600/40 select-none">
                                <!-- Background Watermark Ornaments -->
                                <div class="absolute -right-12 -bottom-12 w-48 h-48 rounded-full bg-emerald-500/10 blur-2xl pointer-events-none"></div>
                                <div class="absolute inset-0 bg-[radial-gradient(#ffffff_0.5px,transparent_0.5px)] [background-size:12px_12px] opacity-10 pointer-events-none"></div>

                                <!-- Card Header -->
                                <div class="relative z-10 flex items-center justify-between border-b border-white/15 pb-2">
                                    <div class="flex items-center gap-2">
                                        <div class="w-8 h-8 rounded-full bg-white/10 flex items-center justify-center p-1 border border-white/20">
                                            @if($kta->member?->banom && $kta->member?->banom?->logo)
                                                <img src="{{ asset('storage/' . $kta->member?->banom?->logo) }}" alt="Logo" class="w-full h-full object-contain">
                                            @else
                                                <span class="material-symbols-outlined text-emerald-200 text-lg">mosque</span>
                                            @endif
                                        </div>
                                        <div>
                                            <div class="text-[8px] uppercase tracking-wider text-emerald-200 font-bold">Nahdlatul Ulama Ranting Banjaranyar</div>
                                            <div class="text-[11px] font-black tracking-tight text-[#fe932c]">KARTU TANDA ANGGOTA</div>
                                        </div>
                                    </div>
                                    <span class="text-[9px] font-black uppercase px-2 py-0.5 rounded bg-white/15 border border-white/20 text-[#aaf2c4]">
                                        {{ $kta->member?->banom?->singkatan ?? 'NU' }}
                                    </span>
                                </div>

                                <!-- Card Body -->
                                <div class="relative z-10 grid grid-cols-12 gap-3 items-center my-auto">
                                    <!-- Photo -->
                                    <div class="col-span-4 flex justify-center">
                                        <div class="w-16 h-20 sm:w-18 sm:h-22 rounded-xl bg-emerald-950/60 border-2 border-emerald-400/50 overflow-hidden shadow-md flex items-center justify-center">
                                            @if($kta->member?->foto)
                                                <img src="{{ asset('storage/' . $kta->member?->foto) }}" alt="{{ $kta->member?->nama_lengkap ?? 'Foto' }}" class="w-full h-full object-cover">
                                            @else
                                                <span class="material-symbols-outlined text-emerald-300/40 text-4xl">person</span>
                                            @endif
                                        </div>
                                    </div>

                                    <!-- Personal Data -->
                                    <div class="col-span-8 space-y-1">
                                        <div class="text-[12px] sm:text-[13px] font-black text-white leading-tight line-clamp-1">
                                            {{ $kta->member?->nama_lengkap ?? 'Anggota' }}
                                        </div>
                                        <div class="text-[9px] font-mono text-[#fe932c] font-bold">
                                            {{ $kta->nomor_kta }}
                                        </div>
                                        <div class="text-[8px] text-emerald-100 flex items-center gap-1">
                                            <span class="material-symbols-outlined text-[10px] text-emerald-300">work</span>
                                            <span class="truncate">{{ $kta->member?->jabatan_kta ?? 'Anggota' }}</span>
                                        </div>
                                        <div class="text-[8px] text-emerald-200/80">
                                            Berlaku: {{ $kta->tanggal_berlaku ? $kta->tanggal_berlaku->format('Y') : 'Seumur Hidup' }}
                                        </div>
                                    </div>
                                </div>

                                <!-- Card Footer -->
                                <div class="relative z-10 flex items-center justify-between pt-1 border-t border-white/10 text-[7px] text-emerald-200/70">
                                    <span>PRNU Banjaranyar, Bojonegoro</span>
                                    <span class="font-mono">VALID KADER</span>
                                </div>
                            </div>

                            <!-- CARD BACK PREVIEW -->
                            <div class="w-full aspect-[85.6/54] rounded-2xl bg-gradient-to-br from-[#0c2415] to-[#04120a] text-white p-5 shadow-xl relative overflow-hidden flex flex-col justify-between border border-emerald-800/40 select-none">
                                <div class="relative z-10 flex items-center justify-between border-b border-white/10 pb-1.5">
                                    <span class="text-[8px] font-bold text-emerald-300">PENGURUS RANTING NAHDLATUL ULAMA</span>
                                    <span class="text-[7px] uppercase tracking-wider text-gray-400">Kartu Legalitas</span>
                                </div>

                                <div class="relative z-10 flex items-center justify-between gap-3 my-auto">
                                    <div class="space-y-1 text-[8px] text-emerald-100/90 leading-relaxed max-w-[65%]">
                                        <p class="font-semibold text-white">Ketentuan Pemegang Kartu:</p>
                                        <ul class="list-disc list-inside space-y-0.5 text-[7px] text-gray-300">
                                            <li>Kartu ini adalah bukti sah keanggotaan NU / BANOM.</li>
                                            <li>Wajib menjaga marwah Ahlussunnah wal Jama'ah An-Nahdliyyah.</li>
                                            <li>Pindai QR Code untuk verifikasi keabsahan online.</li>
                                        </ul>
                                    </div>

                                    <!-- QR Code Image -->
                                    <div class="w-16 h-16 bg-white p-1 rounded-lg shrink-0 flex items-center justify-center shadow">
                                        @if($kta->qr_code_svg)
                                            <img src="{{ $kta->qr_code_svg }}" alt="QR" class="w-full h-full object-contain">
                                        @elseif($kta->qr_code)
                                            <img src="{{ $kta->qr_code }}" alt="QR" class="w-full h-full object-contain">
                                        @else
                                            <span class="material-symbols-outlined text-gray-400 text-3xl">qr_code</span>
                                        @endif
                                    </div>
                                </div>

                                <div class="relative z-10 flex items-center justify-between pt-1 border-t border-white/10 text-[7px] text-emerald-200/60 font-mono">
                                    <span>https://nu-banjaranyar.or.id</span>
                                    <span>SIMNU VERIFIED</span>
                                </div>
                            </div>

                            <!-- Buttons below virtual card -->
                            <div class="pt-3 grid grid-cols-2 gap-3">
                                <a href="{{ route('kta.public.print', $kta->nomor_kta) }}" target="_blank" class="px-4 py-3 rounded-2xl bg-[#004125] hover:bg-[#0c5a37] text-white font-extrabold text-xs text-center flex items-center justify-center gap-2 shadow-md transition-all">
                                    <span class="material-symbols-outlined text-[18px] text-[#fe932c]">print</span>
                                    <span>Cetak KTA</span>
                                </a>
                                <a href="{{ route('kta.public.download', $kta->nomor_kta) }}" target="_blank" class="px-4 py-3 rounded-2xl bg-[#fe932c] hover:bg-[#ff8000] text-[#2f1500] font-black text-xs text-center flex items-center justify-center gap-2 shadow-md transition-all">
                                    <span class="material-symbols-outlined text-[18px]">picture_as_pdf</span>
                                    <span>Unduh PDF</span>
                                </a>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

        @else
            <!-- INACTIVE / EXPIRED STATE -->
            <div class="max-w-2xl mx-auto space-y-8">
                <div class="bg-amber-50 border-2 border-amber-500 rounded-3xl p-8 text-center space-y-5 shadow-sm">
                    <div class="w-16 h-16 rounded-full bg-amber-500 text-white flex items-center justify-center mx-auto shadow-lg shadow-amber-500/20">
                        <span class="material-symbols-outlined text-4xl">warning</span>
                    </div>

                    <div class="space-y-2">
                        <span class="px-3 py-1 rounded-full text-xs font-black uppercase tracking-wider bg-amber-500 text-white">Status Tidak Aktif</span>
                        <h2 class="text-3xl font-black text-amber-950">
                            {{ $isKadaluarsa ? 'KTA KADALUARSA' : 'KTA TIDAK AKTIF' }}
                        </h2>
                        <p class="text-sm text-amber-800 leading-relaxed max-w-lg mx-auto">
                            Nomor KTA <span class="font-mono font-bold">{{ $nomor_kta }}</span> atas nama <strong>{{ $kta->member?->nama_lengkap ?? 'Anggota' }}</strong> tercatat pada sistem kami, namun status kartu saat ini adalah <strong>{{ strtoupper($kta->status) }}</strong>.
                        </p>
                    </div>

                    <div class="bg-white/80 rounded-2xl p-4 text-xs text-amber-900 border border-amber-200 text-left space-y-2">
                        <div class="font-bold flex items-center gap-1.5 text-amber-950">
                            <span class="material-symbols-outlined text-sm">info</span>
                            <span>Rincian Catatan:</span>
                        </div>
                        <p>Keterangan: {{ $kta->keterangan ?? 'Kartu telah dinonaktifkan atau masa kepengurusan telah berakhir.' }}</p>
                        <p>Masa Berlaku: {{ $kta->tanggal_berlaku ? $kta->tanggal_berlaku->translatedFormat('d F Y') : '-' }}</p>
                    </div>

                    <div class="pt-2 flex flex-col sm:flex-row items-center justify-center gap-3">
                        <a href="{{ route('kta.verify.search') }}" class="w-full sm:w-auto px-6 py-3 rounded-xl bg-amber-600 hover:bg-amber-700 text-white text-xs font-bold transition flex items-center justify-center gap-2 shadow-md shadow-amber-600/20">
                            <span class="material-symbols-outlined text-[16px]">qr_code_scanner</span>
                            <span>Pindai Ulang KTA Lain</span>
                        </a>
                        <a href="{{ route('aspiration.create') }}" class="w-full sm:w-auto px-6 py-3 rounded-xl bg-white hover:bg-gray-50 border border-amber-300 text-amber-950 text-xs font-bold transition flex items-center justify-center gap-2">
                            <span class="material-symbols-outlined text-[16px]">mail</span>
                            <span>Hubungi Sekretariat</span>
                        </a>
                    </div>
                </div>
            </div>
        @endif

    @else
        <!-- NOT FOUND STATE -->
        <div class="max-w-2xl mx-auto space-y-8">
            <div class="bg-rose-50 border-2 border-rose-500 rounded-3xl p-8 text-center space-y-5 shadow-sm">
                <div class="w-16 h-16 rounded-full bg-rose-600 text-white flex items-center justify-center mx-auto shadow-lg shadow-rose-600/20">
                    <span class="material-symbols-outlined text-4xl">cancel</span>
                </div>

                <div class="space-y-2">
                    <span class="px-3 py-1 rounded-full text-xs font-black uppercase tracking-wider bg-rose-600 text-white">Tidak Valid</span>
                    <h2 class="text-3xl font-black text-rose-950">KTA TIDAK DITEMUKAN</h2>
                    <p class="text-sm text-rose-800 leading-relaxed max-w-lg mx-auto">
                        Nomor KTA <span class="font-mono font-bold bg-rose-100 px-2 py-0.5 rounded text-rose-950">{{ $nomor_kta }}</span> tidak terdaftar dalam basis data Pengurus Ranting Nahdlatul Ulama Banjaranyar.
                    </p>
                </div>

                <div class="bg-white/80 rounded-2xl p-5 text-xs text-rose-900 border border-rose-200 text-left space-y-3">
                    <div class="font-bold flex items-center gap-1.5 text-rose-950 text-sm">
                        <span class="material-symbols-outlined text-base">help</span>
                        <span>Kemungkinan Penyebab:</span>
                    </div>
                    <ul class="list-disc list-inside space-y-1.5 text-gray-700">
                        <li>Kesalahan pengetikan nomor KTA (pastikan format benar, contoh: <code class="font-mono text-emerald-800">IPNU-2026-00001</code>).</li>
                        <li>Kartu yang dipindai bukan merupakan KTA resmi yang diterbitkan PRNU Banjaranyar.</li>
                        <li>Anggota baru yang KTA resminya masih dalam proses penerbitan oleh administrator.</li>
                    </ul>
                </div>

                <div class="pt-2 flex flex-col sm:flex-row items-center justify-center gap-3">
                    <a href="{{ route('kta.verify.search') }}" class="w-full sm:w-auto px-6 py-3 rounded-xl bg-rose-600 hover:bg-rose-700 text-white text-xs font-bold transition flex items-center justify-center gap-2 shadow-md shadow-rose-600/20">
                        <span class="material-symbols-outlined text-[16px]">search</span>
                        <span>Cari Ulang / Pindai Kembali</span>
                    </a>
                    <a href="{{ route('home') }}" class="w-full sm:w-auto px-6 py-3 rounded-xl bg-white hover:bg-gray-50 border border-gray-300 text-gray-800 text-xs font-bold transition flex items-center justify-center gap-2">
                        <span class="material-symbols-outlined text-[16px]">home</span>
                        <span>Kembali ke Beranda</span>
                    </a>
                </div>
            </div>
        </div>
    @endif
</div>
@endsection
