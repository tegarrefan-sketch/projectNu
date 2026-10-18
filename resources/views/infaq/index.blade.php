@extends('layouts.app')

@section('title', 'Infaq Online & Sedekah Koin LAZISNU — NU Ranting Banjaranyar')

@section('content')
<!-- Header Banner -->
<section class="bg-gradient-to-r from-[#003820] to-[#0c5a37] text-white py-14">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-4">
        <nav class="flex items-center gap-2 text-xs text-emerald-200">
            <a href="{{ route('home') }}" class="hover:underline flex items-center gap-1">
                <span class="material-symbols-outlined text-[14px]">home</span>
                <span>Beranda</span>
            </a>
            <span>/</span>
            <span class="text-white font-semibold">Infaq Online</span>
        </nav>

        <div class="flex flex-col lg:flex-row lg:items-end justify-between gap-6 pt-2">
            <div class="space-y-2 max-w-2xl">
                <div class="inline-flex items-center gap-2 bg-white/10 px-3.5 py-1.5 rounded-full text-xs font-bold text-[#aaf2c4]">
                    <span class="material-symbols-outlined text-[16px]">volunteer_activism</span>
                    <span>Koin Infaq & Kedermawanan Nahdliyin</span>
                </div>
                <h1 class="text-3xl sm:text-4xl font-extrabold tracking-tight">Infaq Online & Gerakan Koin LAZISNU</h1>
                <p class="text-xs sm:text-sm text-emerald-100 leading-relaxed">
                    Salurkan zakat, infaq, dan sedekah jariyah Anda untuk kemakmuran dakwah, santunan anak yatim piatu, dhuafa, dan kemaslahatan warga Desa Banjaranyar.
                </p>
            </div>

            <!-- Transparency Counter -->
            <div class="bg-white/10 backdrop-blur-md p-4 sm:p-5 rounded-3xl border border-white/15 flex items-center gap-4 shrink-0 shadow-lg">
                <div class="w-12 h-12 rounded-2xl bg-[#fe932c] text-[#2f1500] flex items-center justify-center font-bold shrink-0 shadow-md">
                    <span class="material-symbols-outlined text-[26px]">savings</span>
                </div>
                <div>
                    <span class="text-[11px] text-emerald-200 block font-semibold uppercase tracking-wider">Infaq Terhimpun Sah</span>
                    <span class="text-xl sm:text-2xl font-black text-white">Rp {{ number_format($totalTerkumpul, 0, ',', '.') }}</span>
                    <span class="text-[10px] text-emerald-300 block">Dari {{ $totalDonatur }} donatur terverifikasi</span>
                </div>
            </div>
        </div>
    </div>
</section>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    
    <!-- Success Confirmation Box -->
    @if (session('kode_transaksi'))
        <div class="mb-10 bg-emerald-50 border-2 border-emerald-400 p-6 sm:p-8 rounded-3xl shadow-sm text-[#002110] space-y-4 animate-slide-up">
            <div class="flex items-center gap-3.5">
                <div class="w-14 h-14 rounded-2xl bg-emerald-600 text-white flex items-center justify-center font-bold shadow-md">
                    <span class="material-symbols-outlined text-[32px]">check_circle</span>
                </div>
                <div>
                    <span class="px-2.5 py-0.5 rounded-full text-[11px] font-bold bg-emerald-200 text-emerald-950 uppercase tracking-wider">Konfirmasi Diterima</span>
                    <h3 class="text-xl font-black text-emerald-950 mt-0.5">Jazakumullah Khairan Katsiran</h3>
                    <p class="text-xs sm:text-sm text-emerald-800">
                        Terima kasih atas sedekah jariyah Anda. Data donasi telah masuk ke sistem dan sedang dalam antrean verifikasi pengurus LAZISNU.
                    </p>
                </div>
            </div>

            <div class="bg-white p-5 rounded-2xl border border-emerald-200 grid grid-cols-1 sm:grid-cols-3 gap-4 text-xs shadow-sm">
                <div>
                    <span class="text-[#707971] block">Kode Transaksi:</span>
                    <span class="text-sm font-mono font-bold text-[#004125]">{{ session('kode_transaksi') }}</span>
                </div>
                <div>
                    <span class="text-[#707971] block">Nominal Infaq:</span>
                    <span class="text-sm font-bold text-[#004125]">Rp {{ number_format(session('nominal'), 0, ',', '.') }}</span>
                </div>
                <div>
                    <span class="text-[#707971] block">Atas Nama:</span>
                    <span class="text-sm font-bold text-[#004125]">{{ session('nama_donatur') }}</span>
                </div>
            </div>
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 items-start">
        
        <!-- Left: Donation Form (7 cols) -->
        <div class="lg:col-span-7 bg-white rounded-3xl p-6 sm:p-10 border border-[#e6eeff] shadow-sm space-y-8">
            <div>
                <span class="text-xs font-bold text-[#904d00] uppercase tracking-wider block">Formulir Infaq & Sedekah</span>
                <h2 class="text-2xl font-black text-[#004125] tracking-tight">Salurkan Infaq Jariyah Anda</h2>
                <p class="text-xs sm:text-sm text-[#526350] mt-1">Pilih nominal cepat atau tentukan sendiri jumlah infaq kebaikan Anda.</p>
            </div>

            <form action="{{ route('infaq.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf

                <!-- Nominal Cepat Chips -->
                <div class="space-y-2">
                    <label class="block text-xs font-bold text-[#121c2a]">
                        Pilih Nominal Cepat <span class="text-red-500">*</span>
                    </label>
                    <div class="grid grid-cols-2 sm:grid-cols-4 gap-2.5">
                        @foreach([10000, 25000, 50000, 100000] as $amount)
                            <button type="button" onclick="setNominalQuick({{ $amount }})" class="nominal-chip p-3.5 rounded-2xl text-center text-xs sm:text-sm font-black border-2 border-[#dee9fc] bg-[#f8f9ff] text-[#004125] hover:border-[#004125] transition-all" data-amount="{{ $amount }}">
                                Rp {{ number_format($amount, 0, ',', '.') }}
                            </button>
                        @endforeach
                    </div>
                </div>

                <!-- Input Nominal Manual / Terpilih -->
                <div>
                    <label for="nominal_manual" class="block text-xs font-bold text-[#121c2a] mb-1.5">
                        Atau Masukkan Nominal Bebas (Rp) <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <span class="absolute left-4 top-1/2 -translate-y-1/2 font-black text-sm text-[#004125]">Rp</span>
                        <input type="number" name="nominal_manual" id="nominal_manual" min="5000" step="1000" value="{{ old('nominal_manual', 50000) }}" required placeholder="Contoh: 50000" class="w-full pl-12 pr-4 py-3 rounded-2xl text-base font-extrabold text-[#004125] bg-[#f8f9ff] border-2 border-[#dee9fc] focus:bg-white focus:outline-none focus:border-[#004125] transition-all @error('nominal') border-red-400 @enderror">
                    </div>
                    @error('nominal')
                        <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Pilihan Metode Pembayaran -->
                <div class="space-y-2">
                    <label class="block text-xs font-bold text-[#121c2a]">
                        Metode Pembayaran Infaq <span class="text-red-500">*</span>
                    </label>
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                        <label class="cursor-pointer">
                            <input type="radio" name="metode_pembayaran" value="Transfer Bank BSI" class="peer sr-only" checked>
                            <div class="p-3.5 rounded-2xl border-2 border-[#dee9fc] peer-checked:border-[#004125] peer-checked:bg-[#eff4ff] transition-all space-y-1">
                                <span class="text-xs font-black text-[#004125] block">{{ $setting->bank_utama_nama }}</span>
                                <span class="text-[10px] text-gray-500">Transfer Antar Bank</span>
                            </div>
                        </label>

                        @if ($setting->bank_kedua_nama)
                            <label class="cursor-pointer">
                                <input type="radio" name="metode_pembayaran" value="Transfer Bank Jatim" class="peer sr-only">
                                <div class="p-3.5 rounded-2xl border-2 border-[#dee9fc] peer-checked:border-[#004125] peer-checked:bg-[#eff4ff] transition-all space-y-1">
                                    <span class="text-xs font-black text-[#004125] block">{{ $setting->bank_kedua_nama }}</span>
                                    <span class="text-[10px] text-gray-500">Rekening Lokal</span>
                                </div>
                            </label>
                        @endif

                        <label class="cursor-pointer">
                            <input type="radio" name="metode_pembayaran" value="QRIS" class="peer sr-only">
                            <div class="p-3.5 rounded-2xl border-2 border-[#dee9fc] peer-checked:border-[#004125] peer-checked:bg-[#eff4ff] transition-all space-y-1">
                                <span class="text-xs font-black text-[#004125] block">QRIS Standar</span>
                                <span class="text-[10px] text-gray-500">Gopay / OVO / Shopee / BCA</span>
                            </div>
                        </label>
                    </div>
                </div>

                <!-- Data Donatur: Nama & Checkbox Anonim -->
                <div class="space-y-3 pt-1">
                    <div>
                        <label for="nama_donatur" class="block text-xs font-bold text-[#121c2a] mb-1.5">
                            Nama Donatur
                        </label>
                        <input type="text" name="nama_donatur" id="nama_donatur" value="{{ old('nama_donatur') }}" placeholder="Contoh: H. M. Sholihin atau nama keluarga" class="w-full bg-[#f8f9ff] px-4 py-3 rounded-2xl text-xs sm:text-sm text-[#121c2a] border border-[#dee9fc] focus:bg-white focus:outline-none focus:border-[#004125] transition-all">
                    </div>

                    <label class="flex items-center gap-2 cursor-pointer select-none">
                        <input type="checkbox" name="is_anonim" id="is_anonim" value="1" onchange="toggleAnonim(this)" class="w-4 h-4 rounded text-[#004125] focus:ring-[#004125] border-gray-300">
                        <span class="text-xs font-semibold text-gray-700">Sembunyikan nama saya (Tampilkan sebagai "Hamba Allah")</span>
                    </label>
                </div>

                <!-- Nomor WhatsApp (Opsional) -->
                <div>
                    <label for="nomor_whatsapp" class="block text-xs font-bold text-[#121c2a] mb-1.5">
                        Nomor WhatsApp <span class="text-gray-400 font-normal">(Opsional, untuk konfirmasi bukti sah)</span>
                    </label>
                    <input type="text" name="nomor_whatsapp" id="nomor_whatsapp" value="{{ old('nomor_whatsapp') }}" placeholder="0812-xxxx-xxxx" class="w-full bg-[#f8f9ff] px-4 py-3 rounded-2xl text-xs sm:text-sm text-[#121c2a] border border-[#dee9fc] focus:bg-white focus:outline-none focus:border-[#004125] transition-all">
                </div>

                <!-- Pesan / Doa Kebaikan -->
                <div>
                    <label for="pesan_doa" class="block text-xs font-bold text-[#121c2a] mb-1.5">
                        Doa / Hajat Kebaikan <span class="text-gray-400 font-normal">(Opsional)</span>
                    </label>
                    <textarea name="pesan_doa" id="pesan_doa" rows="3" placeholder="Tuliskan niat doa untuk keluarga, almarhum sesepuh, atau keselamatan umat..." class="w-full bg-[#f8f9ff] px-4 py-3 rounded-2xl text-xs sm:text-sm text-[#121c2a] border border-[#dee9fc] focus:bg-white focus:outline-none focus:border-[#004125] transition-all">{{ old('pesan_doa') }}</textarea>
                </div>

                <!-- Upload Bukti Transfer -->
                <div class="border-2 border-dashed border-[#0c5a37]/30 bg-[#f8f9ff] p-5 rounded-2xl text-center space-y-2">
                    <span class="material-symbols-outlined text-[#0c5a37] text-3xl">upload_file</span>
                    <label class="block text-xs font-bold text-[#004125]">
                        Unggah Bukti Transfer Infaq <span class="text-gray-400 font-normal">(Opsional / Bisa menyusul)</span>
                    </label>
                    <p class="text-[11px] text-gray-500">Format gambar JPG, PNG, atau WEBP maks 5MB.</p>
                    <input type="file" name="bukti_transfer" accept="image/*" class="text-xs text-gray-600 file:mr-3 file:py-1.5 file:px-3 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-[#004125] file:text-white">
                </div>

                <!-- Submit Button -->
                <div class="pt-2">
                    <button type="submit" class="w-full inline-flex items-center justify-center gap-3 py-4 px-6 rounded-2xl bg-[#004125] hover:bg-[#0c5a37] text-white font-black text-sm sm:text-base shadow-xl hover:shadow-2xl transition-all transform hover:-translate-y-0.5">
                        <span class="material-symbols-outlined text-[24px] text-[#fe932c]">favorite</span>
                        <span>Kirim Konfirmasi Infaq</span>
                    </button>
                </div>
            </form>
        </div>

        <!-- Right: Bank Account Details & QRIS (5 cols) -->
        <div class="lg:col-span-5 space-y-6">
            
            <!-- Rekening Transfer Box -->
            <div class="bg-white rounded-3xl p-6 sm:p-8 border border-[#e6eeff] shadow-sm space-y-5">
                <div class="flex items-center gap-2">
                    <span class="material-symbols-outlined text-[#0c5a37] text-[24px]">account_balance</span>
                    <h3 class="text-base font-extrabold text-[#004125]">Rekening Resmi Penerimaan</h3>
                </div>

                <!-- Rekening 1: BSI -->
                <div class="bg-[#f8f9ff] p-5 rounded-2xl border border-[#dee9fc] space-y-3">
                    <div class="flex items-center justify-between">
                        <span class="text-xs font-bold text-[#004125]">{{ $setting->bank_utama_nama }}</span>
                        <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-[#eff4ff] text-[#0c5a37]">Utama</span>
                    </div>
                    <div class="flex items-center justify-between gap-2">
                        <span class="text-xl sm:text-2xl font-mono font-black text-[#121c2a]" id="rekUtama">{{ $setting->bank_utama_rekening }}</span>
                        <button type="button" onclick="copyRekening('{{ $setting->bank_utama_rekening }}', this)" class="px-3.5 py-2 rounded-xl bg-[#0c5a37] hover:bg-[#004125] text-white text-xs font-bold flex items-center gap-1.5 transition shadow-sm shrink-0">
                            <span class="material-symbols-outlined text-[16px]">content_copy</span>
                            <span>Salin</span>
                        </button>
                    </div>
                    <p class="text-[11px] text-[#526350]">a.n. <strong class="text-gray-800">{{ $setting->bank_utama_atas_nama }}</strong></p>
                </div>

                @if ($setting->bank_kedua_nama && $setting->bank_kedua_rekening)
                    <!-- Rekening 2: Bank Jatim -->
                    <div class="bg-[#f8f9ff] p-5 rounded-2xl border border-[#dee9fc] space-y-3">
                        <div class="flex items-center justify-between">
                            <span class="text-xs font-bold text-[#004125]">{{ $setting->bank_kedua_nama }}</span>
                            <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-[#eff4ff] text-[#0c5a37]">Lokal</span>
                        </div>
                        <div class="flex items-center justify-between gap-2">
                            <span class="text-xl sm:text-2xl font-mono font-black text-[#121c2a]" id="rekKedua">{{ $setting->bank_kedua_rekening }}</span>
                            <button type="button" onclick="copyRekening('{{ $setting->bank_kedua_rekening }}', this)" class="px-3.5 py-2 rounded-xl bg-[#0c5a37] hover:bg-[#004125] text-white text-xs font-bold flex items-center gap-1.5 transition shadow-sm shrink-0">
                                <span class="material-symbols-outlined text-[16px]">content_copy</span>
                                <span>Salin</span>
                            </button>
                        </div>
                        <p class="text-[11px] text-[#526350]">a.n. <strong class="text-gray-800">{{ $setting->bank_kedua_atas_nama }}</strong></p>
                    </div>
                @endif
            </div>

            <!-- QRIS Scan Box -->
            <div class="bg-white rounded-3xl p-6 sm:p-8 border border-[#e6eeff] shadow-sm space-y-4 text-center">
                <div class="flex items-center justify-center gap-2">
                    <span class="material-symbols-outlined text-[#0c5a37] text-[24px]">qr_code_2</span>
                    <h3 class="text-base font-extrabold text-[#004125]">Scan QRIS Resmi Infaq</h3>
                </div>

                <div class="w-56 h-56 mx-auto bg-white p-3 rounded-2xl border-2 border-[#dee9fc] shadow-inner flex items-center justify-center">
                    @if ($setting->qris_image)
                        <img src="{{ asset('storage/' . $setting->qris_image) }}" alt="QRIS LAZISNU" class="w-full h-full object-contain">
                    @else
                        <!-- Fallback visual QRIS preview -->
                        <div class="space-y-2 text-gray-400">
                            <span class="material-symbols-outlined text-6xl text-[#0c5a37]">qr_code</span>
                            <p class="text-[10px] text-gray-500 font-semibold">QRIS LAZISNU PRNU Banjaranyar</p>
                        </div>
                    @endif
                </div>

                <p class="text-xs text-[#526350] leading-relaxed">
                    Dapat dipindai dari seluruh aplikasi mobile banking (BSI Mobile, BRImo, Livin', BCA) dan e-wallet (GoPay, OVO, ShopeePay, DANA).
                </p>
            </div>

            <!-- Kalimat Penjelas Amanah & Transparansi Dana -->
            <div class="bg-gradient-to-br from-[#0c5a37] to-[#002110] text-white p-7 rounded-3xl shadow-md space-y-3">
                <div class="flex items-center gap-2 text-[#aaf2c4]">
                    <span class="material-symbols-outlined text-[22px]">verified</span>
                    <span class="text-xs font-bold uppercase tracking-wider">Amanah & Transparansi</span>
                </div>
                <h4 class="text-lg font-bold leading-snug">Komitmen Pengelolaan Dana Ummat</h4>
                <p class="text-xs sm:text-sm text-emerald-100 leading-relaxed">
                    {{ $setting->pesan_amanah ?? 'Setiap rupiah infaq yang Anda salurkan akan dikelola secara transparan dan akuntabel oleh UPZIS LAZISNU PRNU Banjaranyar untuk kemakmuran dakwah, santunan yatim, dan kemaslahatan warga desa. Jazakumullah Khairan Katsiran.' }}
                </p>
            </div>

            <!-- Riwayat Infaq Terbaru (Anonim / Privacy Protected) -->
            @if ($recentDonations->isNotEmpty())
                <div class="bg-white rounded-3xl p-6 border border-[#e6eeff] shadow-sm space-y-3">
                    <h4 class="text-xs font-bold uppercase tracking-wider text-gray-400">Doa & Kebaikan Donatur Terbaru</h4>
                    <div class="divide-y divide-[#eff4ff]">
                        @foreach ($recentDonations as $rd)
                            <div class="py-3 space-y-1">
                                <div class="flex items-center justify-between text-xs">
                                    <span class="font-bold text-[#004125]">{{ $rd->nama_donatur }}</span>
                                    <span class="font-extrabold text-emerald-700">Rp {{ number_format($rd->nominal, 0, ',', '.') }}</span>
                                </div>
                                @if ($rd->pesan_doa)
                                    <p class="text-[11px] text-gray-600 italic">"{{ $rd->pesan_doa }}"</p>
                                @endif
                                <span class="text-[10px] text-gray-400 block">{{ $rd->created_at->diffForHumans() }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

        </div>

    </div>
</div>

@push('scripts')
<script>
    function setNominalQuick(val) {
        document.getElementById('nominal_manual').value = val;
        document.querySelectorAll('.nominal-chip').forEach(c => {
            if (parseInt(c.getAttribute('data-amount')) === val) {
                c.classList.add('bg-[#004125]', 'text-white', 'border-[#004125]');
                c.classList.remove('bg-[#f8f9ff]', 'text-[#004125]', 'border-[#dee9fc]');
            } else {
                c.classList.remove('bg-[#004125]', 'text-white', 'border-[#004125]');
                c.classList.add('bg-[#f8f9ff]', 'text-[#004125]', 'border-[#dee9fc]');
            }
        });
    }

    function toggleAnonim(chk) {
        const nameInput = document.getElementById('nama_donatur');
        if (chk.checked) {
            nameInput.disabled = true;
            nameInput.placeholder = 'Hamba Allah (Nama dirahasiakan)';
        } else {
            nameInput.disabled = false;
            nameInput.placeholder = 'Contoh: H. M. Sholihin atau nama keluarga';
        }
    }

    function copyRekening(rek, btn) {
        navigator.clipboard.writeText(rek).then(() => {
            const originalText = btn.innerHTML;
            btn.innerHTML = '<span class="material-symbols-outlined text-[16px]">check</span><span>Tersalin!</span>';
            btn.classList.add('bg-emerald-600');
            setTimeout(() => {
                btn.innerHTML = originalText;
                btn.classList.remove('bg-emerald-600');
            }, 2000);
        });
    }
</script>
@endpush
@endsection
