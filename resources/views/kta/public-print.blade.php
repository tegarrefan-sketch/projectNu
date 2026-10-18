<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak KTA — {{ $kta->nomor_kta }} — {{ $kta->member?->nama_lengkap ?? 'Anggota' }}</title>

    <!-- Google Fonts & Material Symbols -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
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

        /* ISO/IEC 7810 ID-1 standard credit card size: 85.6mm x 53.98mm */
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
                margin: 0 auto !important;
            }
            @page {
                size: A4 portrait;
                margin: 15mm;
            }
        }
    </style>
</head>
<body class="antialiased min-h-screen">

    <!-- Screen Control Toolbar (Otomatis disembunyikan saat dicetak) -->
    <div class="no-print bg-[#003820] text-white px-6 py-4 sticky top-0 z-50 shadow-md flex flex-wrap items-center justify-between gap-4">
        <div class="flex items-center gap-3">
            <a href="{{ route('kta.verify', $kta->nomor_kta) }}" class="p-2.5 rounded-xl bg-white/10 hover:bg-white/20 text-white transition" title="Kembali ke Halaman Verifikasi">
                <span class="material-symbols-outlined text-[20px]">arrow_back</span>
            </a>
            <div>
                <h1 class="text-sm sm:text-base font-black">Cetak Kartu Tanda Anggota (KTA) NU</h1>
                <p class="text-xs text-emerald-200">
                    Standar ISO ID-1 (85.6 × 54 mm) • Nomor: <strong class="text-[#fe932c]">{{ $kta->nomor_kta }}</strong>
                </p>
            </div>
        </div>

        <div class="flex items-center gap-3">
            <button type="button" onclick="window.print()" class="px-5 py-2.5 rounded-xl bg-[#fe932c] hover:bg-[#ff8000] text-[#2f1500] text-xs sm:text-sm font-black transition flex items-center gap-2 shadow-lg hover:scale-[1.02]">
                <span class="material-symbols-outlined text-[20px]">print</span>
                <span>Cetak Sekarang (Ctrl + P)</span>
            </button>
            <button type="button" onclick="window.print()" class="px-4 py-2.5 rounded-xl bg-white/10 hover:bg-white/20 text-white text-xs sm:text-sm font-bold transition flex items-center gap-2">
                <span class="material-symbols-outlined text-[18px]">picture_as_pdf</span>
                <span>Simpan PDF</span>
            </button>
            <a href="{{ route('kta.verify', $kta->nomor_kta) }}" class="px-4 py-2.5 rounded-xl border border-white/20 hover:bg-white/10 text-white text-xs font-bold transition">
                Tutup
            </a>
        </div>
    </div>

    <!-- Printable Cards Sheet (Front & Back) -->
    <div class="print-container max-w-4xl mx-auto p-6 sm:p-12 flex flex-col items-center gap-8">
        
        <div class="no-print text-center space-y-1.5">
            <span class="text-xs font-bold text-gray-400 uppercase tracking-widest">Lembar Dokumen Resmi KTA</span>
            <h2 class="text-2xl font-black text-[#004125]">Kartu Tanda Anggota Nahdlatul Ulama</h2>
            <p class="text-xs text-gray-600 max-w-lg mx-auto">
                Ukuran cetak otomatis disesuaikan dengan kartu standar (85.6 × 54 mm). Pada dialog cetak browser, pilih orientasi <strong class="text-emerald-800">Portrait</strong> dan skala <strong class="text-emerald-800">100% / Actual Size</strong>.
            </p>
        </div>

        <!-- Cards Layout (Side by Side on Screen, Stacked for Print) -->
        <div class="flex flex-col md:flex-row items-center justify-center gap-8">
            
            <!-- ================= SISI DEPAN (FRONT) ================= -->
            <div class="flex flex-col items-center gap-2">
                <span class="no-print text-xs font-bold uppercase tracking-wider text-gray-500">Sisi Depan (Front)</span>
                
                <div class="kta-card bg-gradient-to-br from-[#003820] via-[#004d2c] to-[#012616] text-white p-3.5 shadow-xl relative border border-emerald-500/50 flex flex-col justify-between select-none">
                    <!-- Background Watermark Pattern -->
                    <div class="absolute -right-10 -bottom-10 w-40 h-40 rounded-full bg-emerald-400/10 blur-xl pointer-events-none"></div>
                    <div class="absolute inset-0 bg-[radial-gradient(#ffffff_0.6px,transparent_0.6px)] [background-size:10px_10px] opacity-10 pointer-events-none"></div>

                    <!-- Header -->
                    <div class="relative z-10 flex items-center justify-between border-b border-white/20 pb-1.5">
                        <div class="flex items-center gap-2">
                            <div class="w-7 h-7 rounded-full bg-[#002110] border border-[#fe932c] flex items-center justify-center text-white shrink-0 p-0.5">
                                @if($kta->member?->banom && $kta->member?->banom?->logo)
                                    <img src="{{ asset('storage/' . $kta->member?->banom?->logo) }}" alt="Logo" class="w-full h-full object-contain">
                                @else
                                    <span class="material-symbols-outlined text-[#fe932c] text-[16px]">mosque</span>
                                @endif
                            </div>
                            <div>
                                <div class="text-[7.5px] uppercase tracking-wider text-emerald-200 font-bold leading-tight">Pengurus Ranting Nahdlatul Ulama</div>
                                <div class="text-[10px] font-black tracking-tight text-[#fe932c] leading-tight">KARTU TANDA ANGGOTA</div>
                            </div>
                        </div>
                        <span class="text-[8px] font-black uppercase px-2 py-0.5 rounded bg-white/15 border border-white/20 text-[#aaf2c4]">
                            {{ $kta->member?->banom?->singkatan ?? 'NU' }}
                        </span>
                    </div>

                    <!-- Body -->
                    <div class="relative z-10 grid grid-cols-12 gap-2.5 items-center my-auto">
                        <!-- Foto -->
                        <div class="col-span-4 flex justify-center">
                            <div class="w-14 h-18 rounded-lg bg-emerald-950/80 border border-emerald-400/60 overflow-hidden shadow-md flex items-center justify-center">
                                @if($kta->member?->foto)
                                    <img src="{{ asset('storage/' . $kta->member?->foto) }}" alt="{{ $kta->member?->nama_lengkap ?? 'Foto' }}" class="w-full h-full object-cover">
                                @else
                                    <span class="material-symbols-outlined text-emerald-300/40 text-3xl">person</span>
                                @endif
                            </div>
                        </div>

                        <!-- Data Diri -->
                        <div class="col-span-8 space-y-0.5">
                            <div class="text-[11px] font-black text-white leading-tight line-clamp-1">
                                {{ $kta->member?->nama_lengkap ?? 'Anggota' }}
                            </div>
                            <div class="text-[8.5px] font-mono text-[#fe932c] font-bold">
                                {{ $kta->nomor_kta }}
                            </div>
                            <div class="text-[7.5px] text-emerald-100 flex items-center gap-1">
                                <span class="material-symbols-outlined text-[9px] text-emerald-300">work</span>
                                <span class="truncate">{{ $kta->member?->jabatan_kta ?? 'Anggota' }}</span>
                            </div>
                            <div class="text-[7.5px] text-emerald-200/90 flex items-center gap-1">
                                <span class="material-symbols-outlined text-[9px] text-emerald-300">location_on</span>
                                <span>Banjaranyar, Baureno</span>
                            </div>
                            <div class="text-[7px] text-emerald-300/80 pt-0.5">
                                Berlaku: {{ $kta->tanggal_berlaku ? $kta->tanggal_berlaku->translatedFormat('d M Y') : 'Seumur Hidup' }}
                            </div>
                        </div>
                    </div>

                    <!-- Footer -->
                    <div class="relative z-10 flex items-center justify-between pt-1 border-t border-white/15 text-[6.5px] text-emerald-200/80">
                        <span>PRNU DESA BANJARANYAR, BOJONEGORO</span>
                        <span class="font-mono font-bold text-[#aaf2c4]">KADER RESMI</span>
                    </div>
                </div>
            </div>

            <!-- ================= SISI BELAKANG (BACK) ================= -->
            <div class="flex flex-col items-center gap-2">
                <span class="no-print text-xs font-bold uppercase tracking-wider text-gray-500">Sisi Belakang (Back)</span>
                
                <div class="kta-card bg-gradient-to-br from-[#0c2415] to-[#04120a] text-white p-3.5 shadow-xl relative border border-emerald-700/50 flex flex-col justify-between select-none">
                    <!-- Header -->
                    <div class="relative z-10 flex items-center justify-between border-b border-white/15 pb-1">
                        <span class="text-[7.5px] font-bold text-emerald-300 uppercase tracking-wide">Legalitas Keanggotaan Aswaja</span>
                        <span class="text-[7px] uppercase tracking-wider text-gray-400">SIMNU Terpadu</span>
                    </div>

                    <!-- Body -->
                    <div class="relative z-10 flex items-center justify-between gap-3 my-auto">
                        <div class="space-y-1 text-[7px] text-emerald-100/90 leading-tight max-w-[66%]">
                            <p class="font-bold text-white text-[7.5px]">Ketentuan Pemegang KTA:</p>
                            <ul class="list-disc list-inside space-y-0.5 text-gray-300">
                                <li>Kartu ini adalah bukti sah keanggotaan PRNU Banjaranyar.</li>
                                <li>Wajib menjunjung tinggi nilai Ahlussunnah wal Jama'ah An-Nahdliyyah.</li>
                                <li>Pindai QR Code di samping untuk verifikasi data online.</li>
                            </ul>
                            <p class="text-[6.5px] text-emerald-300/80 pt-0.5">Dikeluarkan oleh Pengurus Ranting NU Banjaranyar.</p>
                        </div>

                        <!-- QR Code Verification Image -->
                        <div class="w-16 h-16 bg-white p-1 rounded-lg shrink-0 flex items-center justify-center shadow-md">
                            @if($kta->qr_code_svg)
                                <img src="{{ $kta->qr_code_svg }}" alt="QR Verifikasi" class="w-full h-full object-contain">
                            @else
                                <span class="material-symbols-outlined text-gray-400 text-3xl">qr_code</span>
                            @endif
                        </div>
                    </div>

                    <!-- Footer -->
                    <div class="relative z-10 flex items-center justify-between pt-1 border-t border-white/15 text-[6.5px] text-emerald-200/70 font-mono">
                        <span>nu-banjaranyar.or.id/kta/verify/{{ $kta->nomor_kta }}</span>
                        <span>SIMNU VERIFIED</span>
                    </div>
                </div>
            </div>

        </div>

        <div class="no-print pt-4 text-center">
            <button type="button" onclick="window.print()" class="inline-flex items-center gap-2 px-6 py-3 rounded-2xl bg-[#004125] hover:bg-[#0c5a37] text-white font-bold text-sm shadow-md transition-all">
                <span class="material-symbols-outlined text-[20px]">print</span>
                <span>Klik di Sini untuk Mencetak Kartu (Atau Simpan PDF)</span>
            </button>
        </div>

    </div>

    @if(!empty($autoPrint))
        <script>
            window.addEventListener('load', () => {
                setTimeout(() => { window.print(); }, 400);
            });
        </script>
    @endif
</body>
</html>
