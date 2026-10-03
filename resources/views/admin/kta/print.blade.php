<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak KTA — {{ $kta->nomor_kta }} — {{ $kta->member->nama_lengkap }}</title>

    <!-- Google Fonts & Material Symbols -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" rel="stylesheet">

    @vite(['resources/css/app.css'])

    <style>
        body {
            font-family: 'Plus Jakarta Sans', ui-sans-serif, system-ui, sans-serif;
            background-color: #f1f5f9;
            margin: 0;
            padding: 0;
            -webkit-print-color-adjust: exact !important;
            print-color-adjust: exact !important;
        }

        /* ISO/IEC 7810 ID-1 standard standard credit card size: 85.6mm x 53.98mm */
        .kta-card {
            width: 85.6mm;
            height: 53.98mm;
            min-width: 85.6mm;
            min-height: 53.98mm;
            max-width: 85.6mm;
            max-height: 53.98mm;
            box-sizing: border-box;
            border-radius: 3.5mm;
            overflow: hidden;
            position: relative;
            page-break-inside: avoid;
            break-inside: avoid;
        }

        @media print {
            body {
                background: transparent !important;
                padding: 0 !important;
            }
            .no-print {
                display: none !important;
            }
            .print-container {
                padding: 0 !important;
                margin: 0 !important;
            }
            @page {
                size: A4 portrait;
                margin: 15mm;
            }
        }
    </style>
</head>
<body class="antialiased min-h-screen">

    <!-- Screen Control Toolbar (Hidden when printing) -->
    <div class="no-print bg-white border-b border-gray-200 px-6 py-4 sticky top-0 z-50 shadow-sm flex flex-wrap items-center justify-between gap-4">
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.kta.show', $kta->id) }}" class="p-2 rounded-xl bg-gray-100 hover:bg-gray-200 text-gray-700 transition" title="Kembali ke Studio">
                <span class="material-symbols-outlined text-[18px]">arrow_back</span>
            </a>
            <div>
                <h1 class="text-sm font-bold text-gray-900">Format Siap Cetak KTA PVC — {{ $kta->nomor_kta }}</h1>
                <p class="text-xs text-gray-500">Standar ISO ID-1 (85.6 × 54 mm). Pastikan skala pencetakan pada dialog browser diatur ke <strong class="text-emerald-700">"100% / Actual Size"</strong>.</p>
            </div>
        </div>

        <div class="flex items-center gap-2.5">
            <button type="button" onclick="window.print()" class="px-5 py-2.5 rounded-xl bg-[#004125] hover:bg-[#0c5a37] text-white text-xs font-extrabold transition flex items-center gap-2 shadow-md">
                <span class="material-symbols-outlined text-[18px]">print</span>
                <span>Cetak Sekarang (Ctrl + P)</span>
            </button>
            <button type="button" onclick="window.close()" class="px-4 py-2.5 rounded-xl border border-gray-300 hover:bg-gray-100 text-gray-700 text-xs font-bold transition">
                Tutup
            </button>
        </div>
    </div>

    <!-- Printable Cards Sheet -->
    <div class="print-container max-w-4xl mx-auto p-8 sm:p-12 flex flex-col items-center gap-8">
        
        <div class="no-print text-center space-y-1">
            <span class="text-xs font-bold text-gray-400 uppercase tracking-widest">Lembar Cetak Dokumen Resmi</span>
            <h2 class="text-xl font-extrabold text-[#004125]">Kartu Tanda Anggota Nahdlatul Ulama</h2>
            <p class="text-xs text-gray-500">Gunting sesuai garis tepi kartu setelah dicetak atau masukkan ke tray printer kartu PVC</p>
        </div>

        <!-- Cards Layout (Sisi Depan + Sisi Belakang) -->
        <div class="flex flex-col sm:flex-row items-center justify-center gap-8">
            
            <!-- ================= SISI DEPAN (FRONT) ================= -->
            <div class="flex flex-col items-center gap-2">
                <span class="no-print text-[11px] font-bold uppercase tracking-wider text-gray-500">Sisi Depan (Front)</span>
                
                <div class="kta-card bg-gradient-to-br from-[#003820] via-[#004d2c] to-[#012616] text-white p-3.5 shadow-lg border border-emerald-600/30 flex flex-col justify-between">
                    <!-- Background Watermark -->
                    <div class="absolute -right-8 -bottom-8 w-32 h-32 rounded-full bg-emerald-500/10 blur-xl pointer-events-none"></div>

                    <!-- Header -->
                    <div class="relative z-10 flex items-center justify-between border-b border-white/20 pb-1.5">
                        <div class="flex items-center gap-1.5">
                            <div class="w-6 h-6 rounded-full bg-white/10 flex items-center justify-center p-0.5 border border-white/20">
                                @if($kta->member->banom && $kta->member->banom->logo)
                                    <img src="{{ asset('storage/' . $kta->member->banom->logo) }}" alt="Logo" class="w-full h-full object-contain">
                                @else
                                    <span class="material-symbols-outlined text-emerald-200 text-xs">mosque</span>
                                @endif
                            </div>
                            <div>
                                <div class="text-[6.5px] uppercase tracking-wider text-emerald-200 font-bold">Nahdlatul Ulama Ranting Banjaranyar</div>
                                <div class="text-[9px] font-black tracking-tight text-[#fe932c]">KARTU TANDA ANGGOTA</div>
                            </div>
                        </div>
                        <span class="text-[7.5px] font-black uppercase px-1.5 py-0.5 rounded bg-white/15 border border-white/20 text-[#aaf2c4]">
                            {{ $kta->member->banom->singkatan ?? 'NU' }}
                        </span>
                    </div>

                    <!-- Body -->
                    <div class="relative z-10 grid grid-cols-12 gap-2 items-center my-auto">
                        <!-- Photo -->
                        <div class="col-span-4 flex justify-center">
                            <div class="w-14 h-18 rounded-lg bg-emerald-950/70 border border-emerald-400/50 overflow-hidden shadow flex items-center justify-center">
                                @if($kta->member->foto)
                                    <img src="{{ asset('storage/' . $kta->member->foto) }}" alt="{{ $kta->member->nama_lengkap }}" class="w-full h-full object-cover">
                                @else
                                    <span class="material-symbols-outlined text-emerald-300/40 text-3xl">person</span>
                                @endif
                            </div>
                        </div>

                        <!-- Data -->
                        <div class="col-span-8 space-y-0.5 pl-0.5">
                            <div class="text-[10px] font-black text-white leading-tight line-clamp-1">
                                {{ $kta->member->nama_lengkap }}
                            </div>
                            <div class="text-[7.5px] font-mono text-[#fe932c] font-bold tracking-wide">
                                {{ $kta->nomor_kta }}
                            </div>
                            <div class="text-[6.5px] text-emerald-100 flex items-center gap-1">
                                <span class="material-symbols-outlined text-[8px] text-emerald-300">work</span>
                                <span class="truncate">{{ $kta->member->jabatan ?? 'Kader / Anggota Aktif' }}</span>
                            </div>
                            <div class="text-[6.5px] text-emerald-200/90">
                                Masa Berlaku: <strong>{{ $kta->tanggal_berlaku ? $kta->tanggal_berlaku->format('Y') : 'Seumur Hidup' }}</strong>
                            </div>
                        </div>
                    </div>

                    <!-- Footer -->
                    <div class="relative z-10 flex items-center justify-between pt-1 border-t border-white/10 text-[6px] text-emerald-200/80">
                        <span>PRNU Desa Banjaranyar, Bojonegoro</span>
                        <span class="font-mono tracking-widest text-[#aaf2c4]">KADER RESMI</span>
                    </div>
                </div>
            </div>

            <!-- ================= SISI BELAKANG (BACK) ================= -->
            <div class="flex flex-col items-center gap-2">
                <span class="no-print text-[11px] font-bold uppercase tracking-wider text-gray-500">Sisi Belakang (Back)</span>

                <div class="kta-card bg-gradient-to-br from-[#0c2415] via-[#05170d] to-[#020b06] text-white p-3.5 shadow-lg border border-emerald-800/30 flex flex-col justify-between">
                    <!-- Header -->
                    <div class="relative z-10 flex items-center justify-between border-b border-white/10 pb-1">
                        <span class="text-[7px] font-bold text-emerald-300">PENGURUS RANTING NAHDLATUL ULAMA</span>
                        <span class="text-[5.5px] uppercase tracking-wider text-gray-400 font-mono">SIMNU-AUTH-V1</span>
                    </div>

                    <!-- Body (Rules + QR) -->
                    <div class="relative z-10 flex items-center justify-between gap-2.5 my-auto">
                        <div class="space-y-0.5 text-[6px] text-emerald-100/90 leading-tight max-w-[65%]">
                            <p class="font-bold text-white uppercase text-[5.5px]">Ketentuan Pemegang KTA:</p>
                            <ul class="list-disc list-inside space-y-0.5 text-[5px] text-gray-300">
                                <li>Kartu legalitas keanggotaan NU Banjaranyar.</li>
                                <li>Wajib menjunjung nilai Ahlussunnah wal Jama'ah.</li>
                                <li>Kehilangan harap lapor sekretariat PRNU.</li>
                                <li>Pindai QR Code untuk verifikasi 24 jam.</li>
                            </ul>
                        </div>

                        <!-- QR Code Box -->
                        <div class="flex flex-col items-center gap-0.5 shrink-0">
                            <div class="w-13 h-13 bg-white p-0.5 rounded shadow flex items-center justify-center">
                                @if($kta->qr_code)
                                    <img src="{{ $kta->qr_code }}" alt="QR" class="w-full h-full object-contain">
                                @else
                                    <span class="material-symbols-outlined text-gray-400 text-xl">qr_code</span>
                                @endif
                            </div>
                            <span class="text-[5px] text-emerald-300 font-mono">VERIFIKASI ONLINE</span>
                        </div>
                    </div>

                    <!-- Footer -->
                    <div class="relative z-10 flex items-center justify-between pt-1 border-t border-white/10 text-[5.5px] text-emerald-200/70 font-mono">
                        <span>nu-banjaranyar.or.id</span>
                        <span class="text-[#fe932c]">ENCRYPTED QR</span>
                    </div>
                </div>
            </div>

        </div>

    </div>

</body>
</html>
