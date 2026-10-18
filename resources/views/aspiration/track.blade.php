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
            <a href="{{ route('aspirasi.create') }}" class="hover:underline">Kirim Aspirasi</a>
            <span>/</span>
            <span class="text-white font-semibold">Lacak Tiket</span>
        </nav>

        <h1 class="text-3xl sm:text-4xl font-extrabold tracking-tight">Pelacakan Status Aspirasi Warga</h1>
        <p class="text-xs sm:text-sm text-emerald-100 leading-relaxed">
            Pantau perkembangan dan tindak lanjut aduan atau masukan yang Anda kirimkan kepada pengurus ranting dengan memasukkan kode tiket resmi.
        </p>
    </div>
</section>

<div class="max-w-4xl mx-auto px-4 sm:px-6 py-10 space-y-8">

    @if ($errors->any())
        <div class="bg-rose-50 border-2 border-rose-300 p-4 rounded-2xl text-rose-900 text-xs sm:text-sm">
            <div class="flex items-center gap-2 font-bold mb-1">
                <span class="material-symbols-outlined text-rose-600 text-lg">error</span>
                <span>Mohon perhatikan:</span>
            </div>
            <ul class="list-disc list-inside space-y-0.5">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    
    <!-- Primary Search / Track Form -->
    <div class="bg-white rounded-3xl p-6 sm:p-8 border border-[#e6eeff] shadow-sm space-y-4">
        <div class="flex items-center justify-between gap-4 flex-wrap">
            <div>
                <h2 class="text-base font-bold text-[#121c2a]">Masukkan Kode Tiket Aspirasi</h2>
                <p class="text-xs text-[#526350] mt-0.5">Ketik kode lengkap yang Anda peroleh saat mengirim aspirasi.</p>
            </div>
            <a href="#lupaTiketSection" class="text-xs font-bold text-emerald-800 hover:text-emerald-950 underline flex items-center gap-1">
                <span class="material-symbols-outlined text-[16px]">help_outline</span>
                <span>Lupa nomor tiket?</span>
            </a>
        </div>

        <form action="{{ route('aspirasi.track') }}" method="GET" class="flex flex-col sm:flex-row gap-3">
            <input type="text" name="kode_tiket" value="{{ $kodeTiket }}" placeholder="Contoh: ASP-20261017-XXXXXX" required class="flex-1 bg-[#f8f9ff] px-4 py-3 rounded-xl text-sm font-mono text-[#121c2a] border border-[#dee9fc] focus:outline-none focus:border-[#004125] uppercase tracking-wider">
            <button type="submit" class="px-6 py-3 rounded-xl bg-[#004125] hover:bg-[#0c5a37] text-white font-bold text-xs sm:text-sm shadow-sm transition-colors flex items-center justify-center gap-2">
                <span class="material-symbols-outlined text-[18px]">search</span>
                <span>Periksa Status</span>
            </button>
        </form>
    </div>

    <!-- Tracking Result -->
    @if ($kodeTiket)
        @if ($aspiration)
            <div class="bg-white rounded-3xl p-6 sm:p-8 border border-[#e6eeff] shadow-sm space-y-6">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-4 border-b border-[#eff4ff]">
                    <div>
                        <span class="text-xs text-[#707971] block">Kode Resi Tiket</span>
                        <span class="text-xl sm:text-2xl font-mono font-black text-[#004125]">{{ $aspiration->kode_tiket }}</span>
                    </div>

                    <div>
                        @if ($aspiration->status === 'Baru')
                            <span class="px-3.5 py-1.5 rounded-full text-xs font-bold bg-[#eff4ff] text-[#004125] border border-[#dee9fc] inline-flex items-center gap-1.5">
                                <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                                Status: Baru Diterima
                            </span>
                        @elseif ($aspiration->status === 'Dibaca')
                            <span class="px-3.5 py-1.5 rounded-full text-xs font-bold bg-blue-50 text-blue-700 border border-blue-200 inline-flex items-center gap-1.5">
                                <span class="w-2 h-2 rounded-full bg-blue-500"></span>
                                Status: Ditinjau Pengurus
                            </span>
                        @elseif ($aspiration->status === 'Diproses')
                            <span class="px-3.5 py-1.5 rounded-full text-xs font-bold bg-[#ffdcc3] text-[#6e3900] border border-[#ffb77d] inline-flex items-center gap-1.5">
                                <span class="w-2 h-2 rounded-full bg-amber-500"></span>
                                Status: Sedang Diproses
                            </span>
                        @elseif ($aspiration->status === 'Selesai')
                            <span class="px-3.5 py-1.5 rounded-full text-xs font-bold bg-emerald-50 text-emerald-700 border border-emerald-200 inline-flex items-center gap-1.5">
                                <span class="material-symbols-outlined text-sm">check_circle</span>
                                Status: Selesai Ditindaklanjuti
                            </span>
                        @endif
                    </div>
                </div>

                <div class="space-y-2">
                    <span class="text-[11px] text-[#707971] block">
                        Kategori: <strong class="text-slate-800">{{ $aspiration->kategori }}</strong> • Dikirim pada {{ $aspiration->created_at->format('d M Y, H:i') }} WIB
                    </span>
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
                <p class="text-xs text-red-600">Pastikan nomor tiket yang Anda masukkan sesuai dengan yang tertera saat pengiriman.</p>
            </div>
        @endif
    @endif

    <!-- ================= 4. FITUR LUPA NOMOR TIKET ================= -->
    <div id="lupaTiketSection" class="bg-white rounded-3xl p-6 sm:p-8 border border-[#e6eeff] shadow-sm space-y-5">
        <div class="border-b border-gray-100 pb-3">
            <div class="flex items-center gap-2 text-emerald-800 font-bold text-xs uppercase tracking-wider">
                <span class="material-symbols-outlined text-sm">lock_reset</span>
                <span>Bantuan Pengirim</span>
            </div>
            <h3 class="text-lg font-black text-[#004125] mt-1">Lupa nomor tiket?</h3>
            <p class="text-xs text-[#526350] mt-0.5 leading-relaxed">
                Bagi pengirim yang <strong>tidak memilih opsi anonim</strong> dan mencantumkan nomor WhatsApp saat mengirim, masukkan nomor WhatsApp Anda di bawah ini untuk melihat daftar kode tiket Anda yang disamarkan.
            </p>
        </div>

        <form action="{{ route('aspirasi.forgot-ticket') }}" method="POST" class="space-y-3">
            @csrf
            <div>
                <label for="whatsapp" class="block text-xs font-bold text-[#121c2a] mb-1">
                    Nomor WhatsApp Pengirim:
                </label>
                <div class="flex flex-col sm:flex-row gap-3">
                    <input type="text" name="whatsapp" id="whatsapp" value="{{ $searchedWhatsapp ?? old('whatsapp') }}" required placeholder="Contoh: 081234567890" class="flex-1 bg-[#f8f9ff] px-4 py-3 rounded-xl text-xs sm:text-sm text-[#121c2a] border border-[#dee9fc] focus:outline-none focus:border-[#004125]">
                    <button type="submit" class="px-6 py-3 rounded-xl bg-emerald-800 hover:bg-emerald-900 text-white font-bold text-xs sm:text-sm shadow-sm transition flex items-center justify-center gap-2">
                        <span class="material-symbols-outlined text-[18px]">find_in_page</span>
                        <span>Cari Tiket Saya</span>
                    </button>
                </div>
                <p class="text-[11px] text-gray-500 mt-1">
                    Hanya menampilkan tanggal, status, dan kode tiket tersamar untuk menjaga privasi.
                </p>
            </div>
        </form>

        <!-- Hasil Pencarian Lupa Nomor Tiket -->
        @if ($searched ?? false)
            <div class="pt-2">
                @if ($foundTickets && $foundTickets->isNotEmpty())
                    <div class="space-y-3">
                        <div class="flex items-center justify-between text-xs font-bold text-emerald-900">
                            <span>Daftar Tiket Terkait (Maksimal 10 Terbaru):</span>
                            <span class="text-gray-500 font-normal text-[11px]">{{ $foundTickets->count() }} tiket ditemukan</span>
                        </div>

                        <div class="overflow-hidden rounded-2xl border border-gray-200">
                            <table class="w-full text-left text-xs">
                                <thead class="bg-gray-50 text-gray-600 font-bold border-b border-gray-200">
                                    <tr>
                                        <th class="p-3">Tanggal</th>
                                        <th class="p-3">Status</th>
                                        <th class="p-3">Kode Tiket (Disamarkan)</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-100 bg-white">
                                    @foreach ($foundTickets as $ticket)
                                        <tr class="hover:bg-emerald-50/50 transition">
                                            <td class="p-3 text-gray-700 whitespace-nowrap">
                                                {{ $ticket->created_at->format('d/m/Y H:i') }} WIB
                                            </td>
                                            <td class="p-3 whitespace-nowrap">
                                                @if ($ticket->status === 'Baru')
                                                    <span class="px-2.5 py-0.5 rounded-full text-[11px] font-bold bg-slate-100 text-slate-800">
                                                        Baru
                                                    </span>
                                                @elseif ($ticket->status === 'Dibaca')
                                                    <span class="px-2.5 py-0.5 rounded-full text-[11px] font-bold bg-blue-50 text-blue-700">
                                                        Dibaca
                                                    </span>
                                                @elseif ($ticket->status === 'Diproses')
                                                    <span class="px-2.5 py-0.5 rounded-full text-[11px] font-bold bg-amber-50 text-amber-800">
                                                        Diproses
                                                    </span>
                                                @elseif ($ticket->status === 'Selesai')
                                                    <span class="px-2.5 py-0.5 rounded-full text-[11px] font-bold bg-emerald-50 text-emerald-700">
                                                        Selesai
                                                    </span>
                                                @endif
                                            </td>
                                            <td class="p-3 font-mono font-bold text-emerald-950 tracking-wider">
                                                {{ $ticket->masked_kode }}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="p-3.5 rounded-xl bg-amber-50 border border-amber-200 text-amber-900 text-xs flex items-start gap-2">
                            <span class="material-symbols-outlined text-amber-600 text-base shrink-0 mt-0.5">info</span>
                            <span>
                                <strong>Catatan:</strong> Tabel ini hanya membantu Anda mengenali tiket yang pernah dikirim. Untuk melihat isi lengkap dan perkembangan tindak lanjut, silakan masukkan kode tiket lengkap di kotak pelacakan di atas.
                            </span>
                        </div>
                    </div>
                @else
                    <div class="p-6 text-center bg-gray-50 rounded-2xl border border-gray-200 text-gray-600">
                        <span class="material-symbols-outlined text-gray-400 text-3xl block mb-1">search_off</span>
                        <p class="text-sm font-bold text-gray-800">Tidak ditemukan</p>
                        <p class="text-xs text-gray-500 mt-0.5">Tidak ada tiket aspirasi aktif yang tercatat dengan nomor kontak tersebut.</p>
                    </div>
                @endif
            </div>
        @endif
    </div>

</div>
@endsection
