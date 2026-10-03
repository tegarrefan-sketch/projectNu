@extends('layouts.admin')

@section('title', 'Tambah Anggota / Kader Baru — SIMNU Admin')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">

    <!-- Top Navigation -->
    <div class="flex items-center justify-between">
        <div>
            <nav class="flex items-center gap-2 text-xs text-gray-500 mb-1">
                <a href="{{ route('admin.dashboard') }}" class="hover:text-emerald-800">Admin</a>
                <span>/</span>
                <a href="{{ route('admin.anggota.index') }}" class="hover:text-emerald-800">Kader</a>
                <span>/</span>
                <span class="text-gray-900 font-bold">Pendaftaran Baru</span>
            </nav>
            <h1 class="text-2xl font-black text-[#004125]">Formulir Pendaftaran Kader Baru</h1>
            <p class="text-xs text-[#526350]">Masukkan identitas lengkap anggota untuk didaftarkan ke dalam database resmi PRNU Banjaranyar.</p>
        </div>

        <a href="{{ route('admin.anggota.index') }}" class="px-3.5 py-2 rounded-xl border border-gray-300 hover:bg-gray-100 text-gray-700 text-xs font-bold transition flex items-center gap-1.5">
            <span class="material-symbols-outlined text-[16px]">arrow_back</span>
            <span>Kembali</span>
        </a>
    </div>

    <!-- Form Card -->
    <div class="bg-white rounded-3xl p-6 sm:p-8 border border-[#e6eeff] shadow-sm">
        <form action="{{ route('admin.anggota.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf

            <!-- Section 1: Badan Otonom & Legalitas -->
            <div class="space-y-4">
                <h3 class="text-sm font-bold text-[#004125] flex items-center gap-2 border-b border-gray-100 pb-2">
                    <span class="material-symbols-outlined text-emerald-600 text-base">account_tree</span>
                    <span>1. Afiliasi Badan Otonom & Organisasi</span>
                </h3>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div class="space-y-1">
                        <label for="banom_id" class="block text-xs font-bold uppercase text-[#004125]">
                            Badan Otonom (BANOM) <span class="text-red-500">*</span>
                        </label>
                        <select name="banom_id" id="banom_id" required class="w-full py-2.5 px-3 text-xs rounded-xl border border-gray-200 focus:border-[#0c5a37] focus:ring-1 focus:ring-[#0c5a37]">
                            <option value="">-- Pilih Badan Otonom --</option>
                            @foreach($banoms as $b)
                                <option value="{{ $b->id }}" {{ old('banom_id') == $b->id ? 'selected' : '' }}>
                                    {{ $b->singkatan }} - {{ $b->nama }}
                                </option>
                            @endforeach
                        </select>
                        @error('banom_id')
                            <p class="text-[11px] text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="space-y-1">
                        <label for="nomor_anggota" class="block text-xs font-bold uppercase text-[#004125]">
                            Nomor Induk Anggota (NIA)
                        </label>
                        <input type="text" name="nomor_anggota" id="nomor_anggota" value="{{ old('nomor_anggota') }}" placeholder="Kosongkan untuk generate otomatis oleh sistem"
                            class="w-full py-2.5 px-3 text-xs rounded-xl border border-gray-200 focus:border-[#0c5a37] text-gray-800">
                        <p class="text-[10px] text-gray-400">Contoh format: NIA-IPNU-2026-0001</p>
                    </div>
                </div>
            </div>

            <!-- Section 2: Identitas Diri -->
            <div class="space-y-4 pt-2">
                <h3 class="text-sm font-bold text-[#004125] flex items-center gap-2 border-b border-gray-100 pb-2">
                    <span class="material-symbols-outlined text-emerald-600 text-base">person</span>
                    <span>2. Identitas Kader Pribadi</span>
                </h3>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div class="space-y-1 sm:col-span-2">
                        <label for="nama_lengkap" class="block text-xs font-bold uppercase text-[#004125]">
                            Nama Lengkap (Sesuai KTP/Akte) <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="nama_lengkap" id="nama_lengkap" value="{{ old('nama_lengkap') }}" required placeholder="Contoh: Ahmad Fauzi Rohman"
                            class="w-full py-2.5 px-3 text-xs rounded-xl border border-gray-200 focus:border-[#0c5a37] font-semibold text-gray-900">
                        @error('nama_lengkap')
                            <p class="text-[11px] text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="space-y-1">
                        <label for="jenis_kelamin" class="block text-xs font-bold uppercase text-[#004125]">
                            Jenis Kelamin <span class="text-red-500">*</span>
                        </label>
                        <select name="jenis_kelamin" id="jenis_kelamin" required class="w-full py-2.5 px-3 text-xs rounded-xl border border-gray-200 focus:border-[#0c5a37]">
                            <option value="Laki-laki" {{ old('jenis_kelamin') == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                            <option value="Perempuan" {{ old('jenis_kelamin') == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                        </select>
                    </div>

                    <div class="space-y-1">
                        <label for="tempat_lahir" class="block text-xs font-bold uppercase text-[#004125]">
                            Tempat Lahir
                        </label>
                        <input type="text" name="tempat_lahir" id="tempat_lahir" value="{{ old('tempat_lahir') }}" placeholder="Contoh: Bojonegoro"
                            class="w-full py-2.5 px-3 text-xs rounded-xl border border-gray-200 focus:border-[#0c5a37]">
                    </div>

                    <div class="space-y-1">
                        <label for="tanggal_lahir" class="block text-xs font-bold uppercase text-[#004125]">
                            Tanggal Lahir
                        </label>
                        <input type="date" name="tanggal_lahir" id="tanggal_lahir" value="{{ old('tanggal_lahir') }}"
                            class="w-full py-2.5 px-3 text-xs rounded-xl border border-gray-200 focus:border-[#0c5a37]">
                    </div>

                    <div class="space-y-1">
                        <label for="nomor_telepon" class="block text-xs font-bold uppercase text-[#004125]">
                            Nomor WhatsApp / Telepon
                        </label>
                        <input type="text" name="nomor_telepon" id="nomor_telepon" value="{{ old('nomor_telepon') }}" placeholder="Contoh: 081234567890"
                            class="w-full py-2.5 px-3 text-xs rounded-xl border border-gray-200 focus:border-[#0c5a37]">
                    </div>

                    <div class="space-y-1 sm:col-span-2">
                        <label for="alamat" class="block text-xs font-bold uppercase text-[#004125]">
                            Alamat Domisili Lengkap (RT/RW/Dusun)
                        </label>
                        <textarea name="alamat" id="alamat" rows="2" placeholder="Contoh: RT 03 RW 01 Dusun Krajan, Desa Banjaranyar"
                            class="w-full py-2 px-3 text-xs rounded-xl border border-gray-200 focus:border-[#0c5a37]">{{ old('alamat') }}</textarea>
                    </div>
                </div>
            </div>

            <!-- Section 3: Posisi Organisasi & Status -->
            <div class="space-y-4 pt-2">
                <h3 class="text-sm font-bold text-[#004125] flex items-center gap-2 border-b border-gray-100 pb-2">
                    <span class="material-symbols-outlined text-emerald-600 text-base">work</span>
                    <span>3. Amanah & Status Keaktifan</span>
                </h3>

                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <div class="space-y-1">
                        <label for="jabatan" class="block text-xs font-bold uppercase text-[#004125]">
                            Jabatan / Amanah <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="jabatan" id="jabatan" value="{{ old('jabatan', 'Kader / Anggota') }}" required placeholder="Contoh: Ketua, Sekretaris, Anggota"
                            class="w-full py-2.5 px-3 text-xs rounded-xl border border-gray-200 focus:border-[#0c5a37]">
                    </div>

                    <div class="space-y-1">
                        <label for="tahun_masuk" class="block text-xs font-bold uppercase text-[#004125]">
                            Tahun Masuk / Bai'at
                        </label>
                        <input type="number" name="tahun_masuk" id="tahun_masuk" value="{{ old('tahun_masuk', date('Y')) }}" min="1950" max="2050"
                            class="w-full py-2.5 px-3 text-xs rounded-xl border border-gray-200 focus:border-[#0c5a37]">
                    </div>

                    <div class="space-y-1">
                        <label for="status" class="block text-xs font-bold uppercase text-[#004125]">
                            Status Keanggotaan <span class="text-red-500">*</span>
                        </label>
                        <select name="status" id="status" required class="w-full py-2.5 px-3 text-xs rounded-xl border border-gray-200 focus:border-[#0c5a37]">
                            <option value="Aktif" {{ old('status', 'Aktif') == 'Aktif' ? 'selected' : '' }}>Aktif</option>
                            <option value="Tidak Aktif" {{ old('status') == 'Tidak Aktif' ? 'selected' : '' }}>Tidak Aktif</option>
                            <option value="Alumni" {{ old('status') == 'Alumni' ? 'selected' : '' }}>Alumni</option>
                        </select>
                    </div>
                </div>
            </div>

            <!-- Section 4: Foto Profil & Auto Generate KTA -->
            <div class="space-y-4 pt-2">
                <h3 class="text-sm font-bold text-[#004125] flex items-center gap-2 border-b border-gray-100 pb-2">
                    <span class="material-symbols-outlined text-emerald-600 text-base">id_card</span>
                    <span>4. Pas Foto & Penerbitan KTA</span>
                </h3>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 items-center">
                    <div class="space-y-2">
                        <label for="foto" class="block text-xs font-bold uppercase text-[#004125]">
                            Pas Foto Kader (Untuk KTA Digital)
                        </label>
                        <input type="file" name="foto" id="foto" accept="image/*"
                            class="w-full text-xs text-gray-500 file:mr-3 file:py-2 file:px-3 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-emerald-50 file:text-[#004125] hover:file:bg-emerald-100">
                        <p class="text-[10px] text-gray-400">Disarankan foto formal berseragam/berpeci, resolusi proporsi 3x4 (maks. 2MB)</p>
                    </div>

                    <!-- Auto KTA Generation Switch -->
                    <div class="p-4 rounded-2xl bg-emerald-50/80 border border-emerald-200">
                        <label class="flex items-start gap-3 cursor-pointer">
                            <input type="checkbox" name="generate_kta" value="1" checked class="mt-0.5 w-4 h-4 rounded text-[#0c5a37] focus:ring-[#0c5a37] border-gray-300">
                            <div class="space-y-0.5">
                                <span class="text-xs font-bold text-[#004125] block">Otomatis Terbitkan KTA & QR Code</span>
                                <span class="text-[11px] text-emerald-800 block">Sistem akan langsung membuat nomor seri KTA unik dan QR Code verifikasi publik saat formulir disimpan.</span>
                            </div>
                        </label>
                    </div>
                </div>
            </div>

            <!-- Submit Buttons -->
            <div class="pt-4 border-t border-gray-100 flex items-center justify-end gap-3">
                <a href="{{ route('admin.anggota.index') }}" class="px-5 py-2.5 rounded-xl border border-gray-300 hover:bg-gray-100 text-gray-700 text-xs font-bold transition">
                    Batal
                </a>
                <button type="submit" class="px-6 py-2.5 rounded-xl bg-[#004125] hover:bg-[#0c5a37] text-white text-xs font-extrabold transition flex items-center gap-1.5 shadow-md">
                    <span class="material-symbols-outlined text-[16px]">save</span>
                    <span>Simpan & Daftarkan Kader</span>
                </button>
            </div>

        </form>
    </div>

</div>
@endsection
