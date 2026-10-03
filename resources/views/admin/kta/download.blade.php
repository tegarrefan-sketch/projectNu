<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KTA-{{ Str::slug($kta->member->nama_lengkap) }}-{{ $kta->member->banom->singkatan ?? 'NU' }}.pdf</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" rel="stylesheet">

    @vite(['resources/css/app.css'])

    <style>
        body {
            font-family: 'Plus Jakarta Sans', ui-sans-serif, system-ui, sans-serif;
            background-color: #f8fafc;
            -webkit-print-color-adjust: exact !important;
            print-color-adjust: exact !important;
        }
        .kta-card {
            width: 85.6mm;
            height: 53.98mm;
            min-width: 85.6mm;
            min-height: 53.98mm;
            box-sizing: border-box;
            border-radius: 3.5mm;
            overflow: hidden;
            position: relative;
            break-inside: avoid;
        }
        @media print {
            .no-print { display: none !important; }
            body { background: transparent !important; }
            @page {
                size: A4 portrait;
                margin: 15mm;
            }
        }
    </style>
</head>
<body class="min-h-screen antialiased">
    
    <!-- Top Action Bar -->
    <div class="no-print bg-[#004125] text-white px-6 py-4 flex flex-wrap items-center justify-between gap-4 shadow-md sticky top-0 z-50">
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.kta.show', $kta->id) }}" class="p-2 rounded-xl bg-white/10 hover:bg-white/20 transition">
                <span class="material-symbols-outlined text-[18px]">arrow_back</span>
            </a>
            <div>
                <h1 class="text-sm font-bold">Simpan sebagai PDF / Cetak Kartu KTA</h1>
                <p class="text-xs text-emerald-200">KTA-{{ Str::slug($kta->member->nama_lengkap) }}-{{ $kta->member->banom->singkatan ?? 'NU' }}.pdf</p>
            </div>
        </div>

        <div class="flex items-center gap-2">
            <button type="button" onclick="window.print()" class="px-5 py-2.5 rounded-xl bg-[#fe932c] hover:bg-[#e07e1e] text-white text-xs font-black transition flex items-center gap-2 shadow-lg">
                <span class="material-symbols-outlined text-[18px]">picture_as_pdf</span>
                <span>Unduh / Cetak PDF (Ctrl+P)</span>
            </button>
        </div>
    </div>

    <!-- Instructions Notice -->
    <div class="no-print max-w-2xl mx-auto mt-6 p-4 rounded-2xl bg-emerald-50 border border-emerald-200 text-xs text-emerald-900 flex items-start gap-3">
        <span class="material-symbols-outlined text-emerald-700 text-lg shrink-0">tips_and_updates</span>
        <div>
            <span class="font-bold">Panduan Ekspor PDF:</span>
            <p class="mt-0.5 text-emerald-800">
                Pilih tujuan cetak (Destination) ke <strong>"Save as PDF"</strong> / <strong>"Simpan sebagai PDF"</strong> pada dialog browser untuk menyimpan kartu ini sebagai file dokumen PDF digital.
            </p>
        </div>
    </div>

    <!-- Sheet with Front and Back -->
    <div class="max-w-3xl mx-auto py-8 sm:py-12 flex flex-col items-center gap-8">
        
        <div class="flex flex-col sm:flex-row items-center justify-center gap-8">
            <!-- Front Card -->
            <div class="kta-card bg-gradient-to-br from-[#003820] via-[#004d2c] to-[#012616] text-white p-3.5 shadow-xl border border-emerald-600/30 flex flex-col justify-between">
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

                <div class="relative z-10 grid grid-cols-12 gap-2 items-center my-auto">
                    <div class="col-span-4 flex justify-center">
                        <div class="w-14 h-18 rounded-lg bg-emerald-950/70 border border-emerald-400/50 overflow-hidden shadow flex items-center justify-center">
                            @if($kta->member->foto)
                                <img src="{{ asset('storage/' . $kta->member->foto) }}" alt="{{ $kta->member->nama_lengkap }}" class="w-full h-full object-cover">
                            @else
                                <span class="material-symbols-outlined text-emerald-300/40 text-3xl">person</span>
                            @endif
                        </div>
                    </div>

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

                <div class="relative z-10 flex items-center justify-between pt-1 border-t border-white/10 text-[6px] text-emerald-200/80">
                    <span>PRNU Desa Banjaranyar, Bojonegoro</span>
                    <span class="font-mono tracking-widest text-[#aaf2c4]">KADER RESMI</span>
                </div>
            </div>

            <!-- Back Card -->
            <div class="kta-card bg-gradient-to-br from-[#0c2415] via-[#05170d] to-[#020b06] text-white p-3.5 shadow-xl border border-emerald-800/30 flex flex-col justify-between">
                <div class="relative z-10 flex items-center justify-between border-b border-white/10 pb-1">
                    <span class="text-[7px] font-bold text-emerald-300">PENGURUS RANTING NAHDLATUL ULAMA</span>
                    <span class="text-[5.5px] uppercase tracking-wider text-gray-400 font-mono">SIMNU-AUTH-V1</span>
                </div>

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

                <div class="relative z-10 flex items-center justify-between pt-1 border-t border-white/10 text-[5.5px] text-emerald-200/70 font-mono">
                    <span>nu-banjaranyar.or.id</span>
                    <span class="text-[#fe932c]">ENCRYPTED QR</span>
                </div>
            </div>
        </div>

    </div>

</body>
</html>
