@extends('layouts.app')

@section('title', 'Kirim Aspirasi & Masukan Jamaah — NU Ranting Banjaranyar')

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
            <span class="text-white font-semibold">Kirim Aspirasi</span>
        </nav>

        <div class="space-y-2 max-w-3xl">
            <div class="inline-flex items-center gap-2 bg-white/10 px-3.5 py-1.5 rounded-full text-xs font-bold text-[#aaf2c4]">
                <span class="material-symbols-outlined text-[16px]">campaign</span>
                <span>Keterbukaan & Tabayyun Jamaah Desa</span>
            </div>
            <h1 class="text-3xl sm:text-4xl font-black tracking-tight">Kirim Aspirasi & Masukan Jamaah</h1>
            <p class="text-xs sm:text-sm text-emerald-100 leading-relaxed">
                Wadah resmi khidmah warga Nahdliyin Banjaranyar untuk menyampaikan saran keagamaan, kemakmuran masjid/musholla, usulan program, atau pengaduan sosial secara santun dan amanah.
            </p>
        </div>
    </div>
</section>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    
    @if ($errors->any())
        <div class="mb-8 bg-rose-50 border-2 border-rose-300 p-5 rounded-3xl shadow-sm text-rose-900 space-y-2 animate-slide-up">
            <div class="flex items-center gap-2.5 font-bold text-sm text-rose-800">
                <span class="material-symbols-outlined text-rose-600 text-xl">error</span>
                <span>Mohon periksa kembali formulir yang Anda kirim:</span>
            </div>
            <ul class="list-disc list-inside text-xs space-y-1 pl-2 text-rose-700 font-medium">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if (session('error'))
        <div class="mb-8 bg-rose-50 border-2 border-rose-300 p-5 rounded-3xl shadow-sm text-rose-900 flex items-center gap-3 animate-slide-up">
            <span class="material-symbols-outlined text-rose-600 text-2xl shrink-0">error</span>
            <span class="text-xs sm:text-sm font-semibold">{{ session('error') }}</span>
        </div>
    @endif

    <!-- Success Ticket Box (Besar, Lengkap dengan Salin, Unduh Gambar/PDF, dan WA) -->
    @if (session('kode_tiket'))
        @php
            $waMessage = "Assalamu'alaikum. Berikut kode tiket pelacakan aspirasi saya di SIMNU PRNU Banjaranyar:\n*Kode Tiket:* " . session('kode_tiket') . "\n*Lacak Status:* " . route('aspirasi.track', ['kode_tiket' => session('kode_tiket')]) . "\n\nSimpan kode ini untuk melacak aspirasi Anda.";
            $waUrl = 'https://wa.me/?text=' . rawurlencode($waMessage);
        @endphp
        <div class="mb-10 bg-emerald-50 border-2 border-emerald-400 p-6 sm:p-8 rounded-3xl shadow-sm text-[#002110] space-y-5 animate-slide-up">
            <div class="flex items-start sm:items-center gap-3.5">
                <div class="w-14 h-14 rounded-2xl bg-emerald-600 text-white flex items-center justify-center font-bold shadow-md shrink-0">
                    <span class="material-symbols-outlined text-[32px]">mark_email_read</span>
                </div>
                <div>
                    <span class="px-2.5 py-0.5 rounded-full text-[11px] font-bold bg-emerald-200 text-emerald-950 uppercase tracking-wider">Berhasil Terkirim</span>
                    <h3 class="text-xl sm:text-2xl font-black text-emerald-950 mt-0.5">Alhamdulillah, Aspirasi Anda Telah Diterima</h3>
                    <p class="text-xs sm:text-sm text-emerald-800">
                        Pengurus PRNU Banjaranyar akan membaca dan menindaklanjuti masukan Anda dengan penuh amanah.
                    </p>
                </div>
            </div>

            <!-- Kartu Tiket Utama -->
            <div class="bg-white p-6 rounded-2xl border-2 border-emerald-200 shadow-sm space-y-4">
                <div class="text-center sm:text-left flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 border-b border-emerald-100 pb-4">
                    <div>
                        <span class="text-xs font-bold uppercase tracking-wider text-emerald-700 block mb-1">Nomor Resi / Kode Tiket Resmi</span>
                        <div class="text-3xl sm:text-4xl font-mono font-black text-[#004125] tracking-wider select-all" id="ticketCodeDisplay">
                            {{ session('kode_tiket') }}
                        </div>
                    </div>
                    <div class="flex items-center gap-2 justify-center sm:justify-end">
                        <button type="button" onclick="copyTicketCode('{{ session('kode_tiket') }}')" id="btnCopyTicket" class="px-4 py-2.5 rounded-xl bg-emerald-100 hover:bg-emerald-200 text-emerald-900 font-bold text-xs sm:text-sm transition flex items-center gap-1.5 shadow-xs">
                            <span class="material-symbols-outlined text-[18px]" id="copyIcon">content_copy</span>
                            <span id="copyText">Salin Kode</span>
                        </button>
                    </div>
                </div>

                <!-- Catatan Jelas Penting -->
                <div class="flex items-start gap-2.5 p-3 rounded-xl bg-amber-50 border border-amber-200 text-amber-900 text-xs sm:text-sm font-semibold">
                    <span class="material-symbols-outlined text-amber-600 text-lg shrink-0 mt-0.5">info</span>
                    <span><strong>PENTING:</strong> Simpan kode ini untuk melacak aspirasi Anda.</span>
                </div>

                <!-- Tombol Aksi Tambahan: Unduh Gambar, Unduh PDF, Kirim ke WA Saya, Lacak -->
                <div class="pt-2 flex flex-wrap items-center gap-2.5">
                    <a href="{{ route('aspirasi.download-card', session('kode_tiket')) }}" class="px-4 py-2.5 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-800 font-bold text-xs sm:text-sm transition flex items-center gap-1.5 border border-slate-200 shadow-xs">
                        <span class="material-symbols-outlined text-[18px] text-emerald-700">image</span>
                        <span>Unduh sebagai Gambar</span>
                    </a>

                    <a href="{{ route('aspirasi.download-pdf', session('kode_tiket')) }}" target="_blank" class="px-4 py-2.5 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-800 font-bold text-xs sm:text-sm transition flex items-center gap-1.5 border border-slate-200 shadow-xs">
                        <span class="material-symbols-outlined text-[18px] text-rose-600">picture_as_pdf</span>
                        <span>Unduh sebagai PDF</span>
                    </a>

                    <a href="{{ $waUrl }}" target="_blank" rel="noopener noreferrer" class="px-4 py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs sm:text-sm transition flex items-center gap-1.5 shadow-xs">
                        <span class="material-symbols-outlined text-[18px]">chat</span>
                        <span>Kirim ke WhatsApp saya</span>
                    </a>

                    <a href="{{ route('aspirasi.track', ['kode_tiket' => session('kode_tiket')]) }}" class="ml-auto px-5 py-2.5 rounded-xl bg-[#004125] hover:bg-[#0c5a37] text-white font-black text-xs sm:text-sm transition flex items-center gap-2 shadow-sm">
                        <span class="material-symbols-outlined text-[18px]">manage_search</span>
                        <span>Lacak Aspirasi Ini →</span>
                    </a>
                </div>
            </div>
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 items-start">
        
        <!-- Left: Form Container (7 cols) -->
        <div class="lg:col-span-7 bg-white rounded-3xl p-6 sm:p-10 border border-[#e6eeff] shadow-sm space-y-6">
            <div>
                <span class="text-xs font-bold text-[#904d00] uppercase tracking-wider block">Formulir Suara Jamaah</span>
                <h2 class="text-2xl font-black text-[#004125] tracking-tight">Tuliskan Masukan & Gagasan</h2>
                <p class="text-xs text-[#526350] mt-1">Isi formulir berikut dengan jelas. Pengurus menjamin keterbukaan dan kerahasiaan identitas Anda.</p>
            </div>

            <form action="{{ route('aspirasi.store') }}" method="POST" class="space-y-6" id="aspirationForm">
                @csrf

                <!-- ================= 1. NAMA RESMI ANGGOTA / SEARCHABLE SELECT ================= -->
                <div class="space-y-2">
                    <label class="block text-xs font-bold text-[#121c2a]">
                        Identitas / Nama Pengirim <span class="text-red-500">*</span>
                    </label>

                    <!-- Identity Mode Radio Pills -->
                    <input type="hidden" name="member_select" id="memberSelectHidden" value="{{ old('member_select', $selectedMember ? $selectedMember->id : 'bukan_anggota') }}">

                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-2">
                        <label class="cursor-pointer">
                            <input type="radio" name="identity_type" value="bukan_anggota" onchange="setIdentityType('bukan_anggota')" class="peer sr-only" {{ old('member_select', $selectedMember ? 'anggota' : 'bukan_anggota') === 'bukan_anggota' ? 'checked' : '' }}>
                            <div class="p-3 rounded-2xl text-center text-xs font-bold bg-[#f8f9ff] border border-[#dee9fc] peer-checked:bg-[#004125] peer-checked:text-white peer-checked:border-[#004125] transition-all flex items-center justify-center gap-1.5 shadow-xs">
                                <span class="material-symbols-outlined text-[16px]">person</span>
                                <span>Warga Umum</span>
                            </div>
                        </label>
                        <label class="cursor-pointer">
                            <input type="radio" name="identity_type" value="anggota" onchange="setIdentityType('anggota')" class="peer sr-only" {{ ($selectedMember || is_numeric(old('member_select'))) ? 'checked' : '' }}>
                            <div class="p-3 rounded-2xl text-center text-xs font-bold bg-[#f8f9ff] border border-[#dee9fc] peer-checked:bg-[#004125] peer-checked:text-white peer-checked:border-[#004125] transition-all flex items-center justify-center gap-1.5 shadow-xs">
                                <span class="material-symbols-outlined text-[16px]">badge</span>
                                <span>Anggota / Kader</span>
                            </div>
                        </label>
                        <label class="cursor-pointer">
                            <input type="radio" name="identity_type" value="anonim" onchange="setIdentityType('anonim')" class="peer sr-only" {{ old('member_select') === 'anonim' ? 'checked' : '' }}>
                            <div class="p-3 rounded-2xl text-center text-xs font-bold bg-[#f8f9ff] border border-[#dee9fc] peer-checked:bg-[#004125] peer-checked:text-white peer-checked:border-[#004125] transition-all flex items-center justify-center gap-1.5 shadow-xs">
                                <span class="material-symbols-outlined text-[16px]">visibility_off</span>
                                <span>Anonim</span>
                            </div>
                        </label>
                    </div>

                    <!-- Panel: Anggota / Kader NU (Search Autocomplete) -->
                    <div id="sectionMemberSearch" class="{{ ($selectedMember || is_numeric(old('member_select'))) ? '' : 'hidden' }} space-y-2 pt-1">
                        <!-- Card data anggota terpilih -->
                        <div id="selectedMemberCard" class="{{ $selectedMember ? '' : 'hidden' }} p-3.5 bg-emerald-50/80 border border-emerald-200 rounded-2xl flex items-center justify-between gap-3 shadow-xs">
                            <div class="flex items-center gap-3 min-w-0">
                                <div class="w-10 h-10 rounded-xl bg-white border border-emerald-200 flex items-center justify-center shrink-0 overflow-hidden shadow-xs">
                                    <img id="selectedMemberImg" src="{{ $selectedMember?->foto ? asset('storage/' . $selectedMember->foto) : '' }}" alt="Foto" class="w-full h-full object-cover {{ $selectedMember?->foto ? '' : 'hidden' }}">
                                    <span id="selectedMemberIcon" class="material-symbols-outlined text-emerald-700 text-xl {{ $selectedMember?->foto ? 'hidden' : '' }}">person</span>
                                </div>
                                <div class="min-w-0">
                                    <div class="flex items-center gap-2 flex-wrap">
                                        <span id="selectedMemberName" class="font-black text-[#004125] text-xs sm:text-sm truncate block">{{ $selectedMember?->nama_lengkap ?? '' }}</span>
                                        <span id="selectedMemberNia" class="px-2 py-0.5 rounded-md bg-white border border-emerald-300 font-mono text-[10px] font-bold text-emerald-800">
                                            {{ $selectedMember?->nomor_anggota ? 'NIA: ' . $selectedMember->nomor_anggota : '' }}
                                        </span>
                                    </div>
                                    <div class="text-[10px] text-[#526350] truncate mt-0.5" id="selectedMemberSub">
                                        {{ $selectedMember ? ($selectedMember->banom?->singkatan ?? 'PRNU') . ($selectedMember->jabatan ? ' • ' . $selectedMember->jabatan : '') : '' }}
                                    </div>
                                </div>
                            </div>
                            <button type="button" onclick="clearSelectedMember()" class="shrink-0 px-3 py-1.5 rounded-xl bg-white hover:bg-rose-50 border border-gray-200 hover:border-rose-300 text-rose-600 text-xs font-bold transition flex items-center gap-1 shadow-xs" title="Ganti Anggota">
                                <span class="material-symbols-outlined text-[16px]">swap_horiz</span>
                                <span>Ganti</span>
                            </button>
                        </div>

                        <!-- Input Pencarian (autocomplete) -->
                        <div id="memberSearchContainer" class="{{ $selectedMember ? 'hidden' : '' }} relative">
                            <div class="relative">
                                <span class="material-symbols-outlined absolute left-3.5 top-1/2 -translate-y-1/2 text-gray-400 text-lg">search</span>
                                <input type="text" id="memberSearchInput" autocomplete="off" placeholder="Ketik nomor anggota (NIA) atau nama anggota..." class="w-full pl-10 pr-10 py-3 rounded-2xl text-xs sm:text-sm bg-[#f8f9ff] border border-[#dee9fc] focus:bg-white focus:outline-none focus:border-[#004125] shadow-xs">
                                <span id="memberSearchSpinner" class="hidden material-symbols-outlined absolute right-3.5 top-1/2 -translate-y-1/2 text-emerald-700 text-lg animate-spin">progress_activity</span>
                            </div>

                            <!-- Dropdown Hasil Pencarian -->
                            <div id="memberSearchResults" class="hidden absolute left-0 right-0 top-full mt-1.5 bg-white rounded-2xl shadow-xl border border-gray-200 max-h-72 overflow-y-auto divide-y divide-gray-100 z-50 p-1">
                            </div>
                        </div>
                    </div>

                    <!-- Warning Peringatan Aspirasi Anonim (Sesuai Ketentuan) -->
                    <div id="anonimWarning" class="{{ old('member_select') === 'anonim' ? '' : 'hidden' }} p-4 rounded-2xl bg-amber-50 border-2 border-amber-300 text-amber-900 text-xs sm:text-sm font-semibold flex items-center gap-2.5 animate-slide-up">
                        <span class="material-symbols-outlined text-amber-600 text-xl shrink-0">warning</span>
                        <span>Kode tiket tidak dapat dipulihkan jika hilang, simpan dengan baik.</span>
                    </div>

                    <!-- Custom Name Field (Muncul saat memilih opsi Warga Umum) -->
                    <div id="customNameField" class="{{ (old('member_select', $selectedMember ? 'anggota' : 'bukan_anggota') === 'bukan_anggota' && !$selectedMember) ? '' : 'hidden' }} pt-1">
                        <label for="nama_custom" class="block text-xs font-semibold text-[#526350] mb-1">
                            Nama Anda <span class="text-gray-400 font-normal">(Boleh Nama Lengkap atau Inisial)</span>:
                        </label>
                        <input type="text" name="nama_custom" id="nama_custom" value="{{ old('nama_custom') }}" placeholder="Contoh: Pak Sholihin atau Warga RT 02" class="w-full bg-[#f8f9ff] px-4 py-3 rounded-2xl text-xs sm:text-sm text-[#121c2a] border border-[#dee9fc] focus:bg-white focus:outline-none focus:border-[#004125] transition-all">
                    </div>
                </div>

                <!-- Kontak WhatsApp (Opsional, disembunyikan untuk anonim) -->
                <div id="kontakFieldContainer" class="{{ old('member_select') === 'anonim' ? 'hidden' : '' }}">
                    <label for="kontak" class="block text-xs font-bold text-[#121c2a] mb-1.5">
                        Nomor WhatsApp atau Kontak <span class="text-gray-400 font-normal">(Opsional, untuk balasan tindak lanjut)</span>
                    </label>
                    <input type="text" name="kontak" id="kontak" value="{{ old('kontak') }}" placeholder="Contoh: 0812-3456-7890" class="w-full bg-[#f8f9ff] px-4 py-3 rounded-2xl text-xs sm:text-sm text-[#121c2a] border border-[#dee9fc] focus:bg-white focus:outline-none focus:border-[#004125] transition-all">
                </div>

                <!-- Kategori Aspirasi (Radio Chips) -->
                <div>
                    <label class="block text-xs font-bold text-[#121c2a] mb-2">
                        Kategori Pesan / Aspirasi <span class="text-red-500">*</span>
                    </label>
                    <div class="grid grid-cols-2 sm:grid-cols-3 gap-2.5">
                        @foreach (['Saran', 'Kritik', 'Aspirasi', 'Pengaduan', 'Pertanyaan'] as $kat)
                            <label class="cursor-pointer">
                                <input type="radio" name="kategori" value="{{ $kat }}" class="peer sr-only" {{ old('kategori', request('kategori', 'Aspirasi')) === $kat ? 'checked' : '' }}>
                                <div class="p-3.5 rounded-2xl text-center text-xs sm:text-sm font-bold bg-[#f8f9ff] border border-[#dee9fc] peer-checked:bg-[#004125] peer-checked:text-white peer-checked:border-[#004125] transition-all shadow-sm">
                                    {{ $kat }}
                                </div>
                            </label>
                        @endforeach
                    </div>
                </div>

                <!-- Subjek -->
                <div>
                    <label for="subjek" class="block text-xs font-bold text-[#121c2a] mb-1.5">
                        Judul / Inti Masukan <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="subjek" id="subjek" value="{{ old('subjek') }}" required placeholder="Contoh: Usulan Perbaikan Sound System Musholla Dusun" class="w-full bg-[#f8f9ff] px-4 py-3 rounded-2xl text-xs sm:text-sm text-[#121c2a] border border-[#dee9fc] focus:bg-white focus:outline-none focus:border-[#004125] transition-all @error('subjek') border-red-400 @enderror">
                    @error('subjek')
                        <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Pesan -->
                <div>
                    <label for="pesan" class="block text-xs font-bold text-[#121c2a] mb-1.5">
                        Uraian Lengkap Aspirasi / Saran <span class="text-red-500">*</span>
                    </label>
                    <textarea name="pesan" id="pesan" rows="5" required placeholder="Tuliskan aspirasi, kritik, pertanyaan, atau masukan Anda secara jelas dan santun..." class="w-full bg-[#f8f9ff] px-4 py-3 rounded-2xl text-xs sm:text-sm text-[#121c2a] border border-[#dee9fc] focus:bg-white focus:outline-none focus:border-[#004125] transition-all @error('pesan') border-red-400 @enderror">{{ old('pesan') }}</textarea>
                    @error('pesan')
                        <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Submit Button -->
                <div class="pt-2">
                    <button type="submit" class="w-full inline-flex items-center justify-center gap-3 py-4 px-6 rounded-2xl bg-[#004125] hover:bg-[#0c5a37] text-white font-black text-sm sm:text-base shadow-lg hover:shadow-xl transition-all transform hover:-translate-y-0.5">
                        <span class="material-symbols-outlined text-[24px] text-[#fe932c]">send</span>
                        <span>Kirim Aspirasi ke Pengurus Ranting</span>
                    </button>
                </div>
            </form>
        </div>

        <!-- Right: Privacy Guarantee & Tracking (5 cols) -->
        <div class="lg:col-span-5 space-y-6">
            
            <!-- Tracking Box -->
            <div class="bg-gradient-to-br from-[#0c5a37] to-[#002110] text-white p-7 rounded-3xl shadow-md space-y-4">
                <div class="flex items-center gap-2 text-[#aaf2c4]">
                    <span class="material-symbols-outlined text-[22px]">manage_search</span>
                    <span class="text-xs font-bold uppercase tracking-wider">Cek Status Aspirasi</span>
                </div>
                <h3 class="text-xl font-bold">Pernah Mengirim Aspirasi?</h3>
                <p class="text-xs sm:text-sm text-emerald-100 leading-relaxed">
                    Masukkan nomor resi / tiket yang Anda peroleh untuk memantau apakah pesan Anda sudah dibaca atau ditindaklanjuti oleh pengurus.
                </p>
                <form action="{{ route('aspirasi.track') }}" method="GET" class="pt-2 flex gap-2">
                    <input type="text" name="kode_tiket" placeholder="Contoh: ASP-20261010-001" required class="flex-1 bg-white/10 px-3.5 py-2.5 rounded-xl text-xs sm:text-sm border border-white/20 text-white placeholder-emerald-200/60 focus:outline-none focus:bg-white/20">
                    <button type="submit" class="px-4 py-2.5 rounded-xl bg-[#fe932c] hover:bg-[#ff8000] text-[#2f1500] font-black text-xs transition">
                        Lacak
                    </button>
                </form>
            </div>

            <!-- Jaminan Etika & Kerahasiaan -->
            <div class="bg-white rounded-3xl p-7 border border-[#e6eeff] shadow-sm space-y-4">
                <h3 class="text-base font-bold text-[#004125] flex items-center gap-2">
                    <span class="material-symbols-outlined text-[#0c5a37]">shield</span>
                    <span>Etika & Prinsip Tabayyun</span>
                </h3>

                <ul class="space-y-3 text-xs sm:text-sm text-[#404942]">
                    <li class="flex items-start gap-2.5">
                        <span class="material-symbols-outlined text-emerald-600 text-[18px] shrink-0 mt-0.5">check_circle</span>
                        <span><strong>Santun & Membangun:</strong> Disampaikan demi kebaikan bersama dan kemakmuran warga Banjaranyar.</span>
                    </li>
                    <li class="flex items-start gap-2.5">
                        <span class="material-symbols-outlined text-emerald-600 text-[18px] shrink-0 mt-0.5">check_circle</span>
                        <span><strong>Privasi Terjamin:</strong> Pilihan anonim dilindungi sepenuhnya tanpa pencatatan identitas publik.</span>
                    </li>
                    <li class="flex items-start gap-2.5">
                        <span class="material-symbols-outlined text-emerald-600 text-[18px] shrink-0 mt-0.5">check_circle</span>
                        <span><strong>Amanah Tindak Lanjut:</strong> Setiap pesan dibahas dalam musyawarah pengurus harian Syuriyah & Tanfidziyah.</span>
                    </li>
                </ul>
            </div>

        </div>

    </div>
</div>

@push('scripts')
<script>
    const selectHidden = document.getElementById('memberSelectHidden');
    const customNameField = document.getElementById('customNameField');
    const sectionMemberSearch = document.getElementById('sectionMemberSearch');

    const anonimWarning = document.getElementById('anonimWarning');
    const kontakFieldContainer = document.getElementById('kontakFieldContainer');
    const kontakInput = document.getElementById('kontak');

    function setIdentityType(type) {
        if (type === 'bukan_anggota') {
            selectHidden.value = 'bukan_anggota';
            customNameField.classList.remove('hidden');
            sectionMemberSearch.classList.add('hidden');
            if (anonimWarning) anonimWarning.classList.add('hidden');
            if (kontakFieldContainer) kontakFieldContainer.classList.remove('hidden');
            clearSelectedMember();
        } else if (type === 'anggota') {
            customNameField.classList.add('hidden');
            sectionMemberSearch.classList.remove('hidden');
            if (anonimWarning) anonimWarning.classList.add('hidden');
            if (kontakFieldContainer) kontakFieldContainer.classList.remove('hidden');
            if (!selectHidden.value || selectHidden.value === 'bukan_anggota' || selectHidden.value === 'anonim') {
                clearSelectedMember();
            }
        } else if (type === 'anonim') {
            selectHidden.value = 'anonim';
            customNameField.classList.add('hidden');
            sectionMemberSearch.classList.add('hidden');
            if (anonimWarning) anonimWarning.classList.remove('hidden');
            if (kontakFieldContainer) kontakFieldContainer.classList.add('hidden');
            if (kontakInput) kontakInput.value = '';
            clearSelectedMember();
        }
    }

    function copyTicketCode(code) {
        if (!code) return;
        if (navigator.clipboard && window.isSecureContext) {
            navigator.clipboard.writeText(code).then(() => {
                showCopiedState();
            }).catch(() => {
                fallbackCopy(code);
            });
        } else {
            fallbackCopy(code);
        }
    }

    function fallbackCopy(code) {
        const temp = document.createElement('input');
        temp.value = code;
        document.body.appendChild(temp);
        temp.select();
        try {
            document.execCommand('copy');
            showCopiedState();
        } catch (e) {
            alert('Kode tiket: ' + code);
        }
        document.body.removeChild(temp);
    }

    function showCopiedState() {
        const copyText = document.getElementById('copyText');
        const copyIcon = document.getElementById('copyIcon');
        const btn = document.getElementById('btnCopyTicket');
        if (copyText) copyText.innerText = 'Tersalin!';
        if (copyIcon) copyIcon.innerText = 'check';
        if (btn) btn.classList.add('bg-emerald-600', 'text-white');
        setTimeout(() => {
            if (copyText) copyText.innerText = 'Salin Kode';
            if (copyIcon) copyIcon.innerText = 'content_copy';
            if (btn) btn.classList.remove('bg-emerald-600', 'text-white');
        }, 2500);
    }

    let memberDebounceTimer;
    const memberSearchInput = document.getElementById('memberSearchInput');
    const memberSearchResults = document.getElementById('memberSearchResults');
    const memberSearchSpinner = document.getElementById('memberSearchSpinner');

    if (memberSearchInput) {
        memberSearchInput.addEventListener('input', function() {
            clearTimeout(memberDebounceTimer);
            const q = this.value.trim();
            if (q.length === 0) {
                memberSearchResults.innerHTML = '';
                memberSearchResults.classList.add('hidden');
                return;
            }
            memberSearchSpinner.classList.remove('hidden');
            memberDebounceTimer = setTimeout(() => {
                fetch(`{{ route('anggota.search') }}?q=` + encodeURIComponent(q))
                    .then(res => res.json())
                    .then(data => {
                        memberSearchSpinner.classList.add('hidden');
                        memberSearchResults.innerHTML = '';
                        if (!data || data.length === 0) {
                            memberSearchResults.innerHTML = `
                                <div class="p-4 text-center text-xs text-gray-500 font-medium">
                                    <span class="material-symbols-outlined text-gray-400 text-2xl block mb-1">person_search</span>
                                    Anggota tidak ditemukan
                                </div>
                            `;
                            memberSearchResults.classList.remove('hidden');
                            return;
                        }

                        data.forEach(m => {
                            const item = document.createElement('div');
                            item.className = 'p-2.5 rounded-xl hover:bg-emerald-50/80 cursor-pointer transition flex items-center justify-between gap-3 text-xs';
                            item.innerHTML = `
                                <div class="flex items-center gap-2.5 min-w-0">
                                    <div class="w-8 h-8 rounded-lg bg-gray-100 border border-gray-200 flex items-center justify-center shrink-0 overflow-hidden">
                                        ${m.foto ? `<img src="${m.foto}" class="w-full h-full object-cover">` : `<span class="material-symbols-outlined text-gray-400 text-[18px]">person</span>`}
                                    </div>
                                    <div class="min-w-0">
                                        <div class="font-bold text-[#121c2a] truncate">${m.nama_lengkap}</div>
                                        <div class="text-[10px] text-gray-500 truncate">${m.banom || 'PRNU'} ${m.jabatan ? '• ' + m.jabatan : ''}</div>
                                    </div>
                                </div>
                                <span class="px-2 py-0.5 rounded bg-gray-100 font-mono text-[10px] font-bold text-gray-700 shrink-0">
                                    ${m.nomor_anggota ? 'NIA: ' + m.nomor_anggota : '-'}
                                </span>
                            `;
                            item.addEventListener('click', () => selectMember(m));
                            memberSearchResults.appendChild(item);
                        });
                        memberSearchResults.classList.remove('hidden');
                    })
                    .catch(() => {
                        memberSearchSpinner.classList.add('hidden');
                    });
            }, 300);
        });
    }

    function selectMember(m) {
        selectHidden.value = m.id;
        document.getElementById('selectedMemberName').innerText = m.nama_lengkap;
        document.getElementById('selectedMemberNia').innerText = m.nomor_anggota ? 'NIA: ' + m.nomor_anggota : '';
        document.getElementById('selectedMemberSub').innerText = (m.banom || 'PRNU') + (m.jabatan ? ' • ' + m.jabatan : '');
        
        const img = document.getElementById('selectedMemberImg');
        const icon = document.getElementById('selectedMemberIcon');
        if (m.foto) {
            img.src = m.foto;
            img.classList.remove('hidden');
            if (icon) icon.classList.add('hidden');
        } else {
            img.src = '';
            img.classList.add('hidden');
            if (icon) icon.classList.remove('hidden');
        }

        document.getElementById('selectedMemberCard').classList.remove('hidden');
        document.getElementById('memberSearchContainer').classList.add('hidden');
        memberSearchResults.classList.add('hidden');
        memberSearchResults.innerHTML = '';
        if (memberSearchInput) memberSearchInput.value = '';
    }

    function clearSelectedMember() {
        if (document.querySelector('input[name="identity_type"]:checked')?.value === 'anggota') {
            selectHidden.value = '';
        }
        document.getElementById('selectedMemberCard').classList.add('hidden');
        document.getElementById('memberSearchContainer').classList.remove('hidden');
        if (memberSearchInput) {
            memberSearchInput.value = '';
            memberSearchInput.focus();
        }
    }

    document.addEventListener('click', function(e) {
        if (!document.getElementById('memberSearchContainer')?.contains(e.target)) {
            memberSearchResults?.classList.add('hidden');
        }
    });
</script>
@endpush
@endsection
