<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bukti Resi Tiket Aspirasi — {{ $aspiration->kode_tiket }}</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&family=JetBrains+Mono:wght@600;700;800&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" rel="stylesheet">

    @vite(['resources/css/app.css'])

    <style>
        body {
            font-family: 'Plus Jakarta Sans', ui-sans-serif, system-ui, sans-serif;
            background-color: #f8fafc;
            margin: 0;
            padding: 0;
            -webkit-print-color-adjust: exact !important;
            print-color-adjust: exact !important;
        }

        .font-mono-code {
            font-family: 'JetBrains Mono', monospace;
        }

        @media print {
            body {
                background: #ffffff !important;
                padding: 0 !important;
            }
            .no-print {
                display: none !important;
            }
            .print-card {
                box-shadow: none !important;
                border: 2px solid #004125 !important;
                max-width: 100% !important;
                margin: 0 !important;
            }
            @page {
                size: A5 portrait;
                margin: 10mm;
            }
        }
    </style>
</head>
<body class="min-h-screen text-slate-800 antialiased p-4 sm:p-8 flex flex-col items-center justify-center">

    <!-- Top Action Bar (Screen Only) -->
    <div class="no-print w-full max-w-xl mb-4 flex items-center justify-between gap-3">
        <a href="{{ route('aspirasi.create') }}" class="inline-flex items-center gap-1.5 text-xs font-bold text-slate-600 hover:text-emerald-700 bg-white px-3 py-2 rounded-xl border border-slate-200 shadow-sm transition">
            <span class="material-symbols-Outlined text-base">arrow_back</span>
            Kembali
        </a>
        <div class="flex items-center gap-2">
            <a href="{{ route('aspirasi.download-card', $aspiration->kode_tiket) }}" class="inline-flex items-center gap-1.5 text-xs font-bold text-emerald-800 bg-emerald-50 hover:bg-emerald-100 px-3 py-2 rounded-xl border border-emerald-200 transition">
                <span class="material-symbols-Outlined text-base">image</span>
                Unduh Gambar
            </a>
            <button onclick="window.print()" class="inline-flex items-center gap-1.5 text-xs font-bold text-white bg-emerald-700 hover:bg-emerald-800 px-4 py-2 rounded-xl shadow transition">
                <span class="material-symbols-Outlined text-base">print</span>
                Cetak / Simpan PDF
            </button>
        </div>
    </div>

    <!-- Printable Receipt Card -->
    <div class="print-card w-full max-w-xl bg-white rounded-3xl border border-slate-200 shadow-xl overflow-hidden">
        <!-- Header -->
        <div class="bg-gradient-to-r from-emerald-900 via-emerald-800 to-teal-900 p-6 text-white text-center relative overflow-hidden">
            <div class="absolute -right-10 -bottom-10 w-36 h-36 bg-amber-400/10 rounded-full blur-2xl"></div>
            <div class="inline-flex items-center justify-center w-12 h-12 bg-white/10 rounded-2xl mb-3 backdrop-blur-sm border border-white/20">
                <span class="material-symbols-Outlined text-2xl text-amber-300">task_alt</span>
            </div>
            <h1 class="text-lg font-black tracking-tight text-white uppercase">Pengurus Ranting NU Banjaranyar</h1>
            <p class="text-xs text-emerald-200 mt-0.5 font-medium">Bukti Resi Pelacakan Aspirasi & Masukan Jamaah</p>
        </div>

        <div class="p-6 sm:p-8 space-y-6">
            <!-- Large Ticket Box -->
            <div class="bg-gradient-to-br from-emerald-50 via-teal-50 to-amber-50/30 rounded-2xl p-5 border-2 border-dashed border-emerald-300 text-center relative">
                <span class="text-[11px] font-bold uppercase tracking-wider text-emerald-800 bg-emerald-100/80 px-3 py-0.5 rounded-full inline-block mb-2">
                    Kode Tiket Resmi
                </span>
                <div class="font-mono-code text-2xl sm:text-3xl font-extrabold text-emerald-950 tracking-wider select-all my-1">
                    {{ $aspiration->kode_tiket }}
                </div>
                <p class="text-xs font-semibold text-emerald-700 mt-1 flex items-center justify-center gap-1">
                    <span class="material-symbols-Outlined text-sm">lock</span>
                    Simpan kode ini untuk melacak status aspirasi Anda.
                </p>
            </div>

            <!-- Details Table -->
            <div class="bg-slate-50 rounded-2xl p-4 border border-slate-200/80 space-y-3 text-xs sm:text-sm">
                <div class="flex justify-between items-center py-1 border-b border-slate-200/60">
                    <span class="text-slate-500 font-medium">Kategori:</span>
                    <span class="font-bold text-slate-800 px-2 py-0.5 bg-slate-200/70 rounded-md">{{ $aspiration->kategori }}</span>
                </div>
                <div class="flex justify-between items-center py-1 border-b border-slate-200/60">
                    <span class="text-slate-500 font-medium">Waktu Kirim:</span>
                    <span class="font-bold text-slate-800">{{ $aspiration->created_at->format('d F Y, H:i') }} WIB</span>
                </div>
                <div class="flex justify-between items-center py-1 border-b border-slate-200/60">
                    <span class="text-slate-500 font-medium">Status Awal:</span>
                    <span class="font-bold text-emerald-700">{{ $aspiration->status }}</span>
                </div>
                <div class="flex justify-between items-center py-1 border-b border-slate-200/60">
                    <span class="text-slate-500 font-medium">Pengirim:</span>
                    <span class="font-bold text-slate-800">{{ $aspiration->is_anonim ? 'Anonim (Dirahasiakan)' : $aspiration->nama }}</span>
                </div>
                <div class="py-1">
                    <span class="text-slate-500 font-medium block mb-1">Subjek Aspirasi:</span>
                    <p class="font-semibold text-slate-800 bg-white p-2.5 rounded-xl border border-slate-200/70">{{ $aspiration->subjek }}</p>
                </div>
            </div>

            <!-- Tracking Link & QR Info -->
            <div class="bg-amber-50/80 rounded-2xl p-4 border border-amber-200/80 flex items-start gap-3 text-xs text-amber-900">
                <span class="material-symbols-Outlined text-amber-600 text-lg flex-shrink-0 mt-0.5">info</span>
                <div>
                    <div class="font-bold">Cara Melacak Progres:</div>
                    <div class="mt-0.5 leading-relaxed text-amber-800">
                        Kunjungi portal pelacakan di <strong class="font-mono text-emerald-900">{{ route('aspirasi.track') }}</strong> lalu ketikkan kode tiket di atas.
                    </div>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <div class="bg-slate-100 p-4 border-t border-slate-200 text-center text-[11px] text-slate-500">
            Sistem Informasi Manajemen NU (SIMNU) — Pengurus Ranting Banjaranyar
        </div>
    </div>

</body>
</html>
