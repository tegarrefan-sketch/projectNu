@extends('layouts.admin')

@section('title', 'Edit Badan Otonom — ' . $banom->singkatan . ' — SIMNU Admin')

@section('content')
<div class="max-w-3xl mx-auto space-y-6">

    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 bg-white p-6 rounded-2xl border border-[#e6eeff] shadow-sm">
        <div>
            <nav class="flex items-center gap-2 text-xs text-[#707971] mb-1">
                <a href="{{ route('admin.banoms.index') }}" class="hover:underline">Badan Otonom</a>
                <span>/</span>
                <span class="text-[#004125] font-semibold">Edit</span>
            </nav>
            <h1 class="text-2xl font-black text-[#004125] tracking-tight">Edit BANOM: {{ $banom->singkatan }}</h1>
            <p class="text-xs text-[#526350] mt-0.5">{{ $banom->nama }}</p>
        </div>

        <div class="flex items-center gap-2">
            <!-- Tombol Kelola Pengurus -->
            <a href="{{ route('admin.banoms.officers.index', $banom->id) }}" class="px-4 py-2.5 rounded-xl bg-[#0c5a37] hover:bg-[#004125] text-white text-xs font-black shadow-sm transition flex items-center gap-1.5">
                <span class="material-symbols-outlined text-[18px] text-[#fe932c]">groups</span>
                <span>Kelola Pengurus ({{ $banom->banomOfficers()->count() }})</span>
            </a>

            <a href="{{ route('admin.banoms.index') }}" class="px-3.5 py-2.5 rounded-xl bg-gray-100 hover:bg-gray-200 text-gray-700 text-xs font-bold transition flex items-center gap-1">
                <span class="material-symbols-outlined text-[16px]">arrow_back</span>
                <span>Kembali</span>
            </a>
        </div>
    </div>

    <!-- Form Card -->
    <div class="bg-white p-6 sm:p-8 rounded-2xl border border-[#e6eeff] shadow-sm">
        <form action="{{ route('admin.banoms.update', $banom->id) }}" method="POST" enctype="multipart/form-data" class="space-y-5">
            @csrf
            @method('PUT')

            <!-- Nama Lengkap -->
            <div>
                <label for="nama" class="block text-xs font-bold text-[#121c2a] mb-1.5">
                    Nama Resmi BANOM <span class="text-red-500">*</span>
                </label>
                <input type="text" id="nama" name="nama" value="{{ old('nama', $banom->nama) }}" required class="w-full px-4 py-3 rounded-xl text-xs sm:text-sm bg-[#f8f9ff] border @error('nama') border-red-500 @else border-[#dee9fc] @enderror focus:bg-white focus:outline-none focus:border-[#004125]">
                @error('nama')
                    <p class="text-[11px] text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Grid Kategori & Singkatan -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label for="kategori" class="block text-xs font-bold text-[#121c2a] mb-1.5">
                        Kategori Organisasi <span class="text-red-500">*</span>
                    </label>
                    <select id="kategori" name="kategori" class="w-full px-4 py-3 rounded-xl text-xs sm:text-sm bg-[#f8f9ff] border border-[#dee9fc] focus:bg-white focus:outline-none focus:border-[#004125]">
                        <option value="banom" {{ old('kategori', $banom->kategori) === 'banom' ? 'selected' : '' }}>Badan Otonom (Banom)</option>
                        <option value="ranting" {{ old('kategori', $banom->kategori) === 'ranting' ? 'selected' : '' }}>Pengurus Ranting NU (PRNU)</option>
                    </select>
                </div>

                <div>
                    <label for="singkatan" class="block text-xs font-bold text-[#121c2a] mb-1.5">
                        Singkatan / Akronim <span class="text-red-500">*</span>
                    </label>
                    <input type="text" id="singkatan" name="singkatan" value="{{ old('singkatan', $banom->singkatan) }}" required class="w-full px-4 py-3 rounded-xl text-xs sm:text-sm font-bold uppercase bg-[#f8f9ff] border @error('singkatan') border-red-500 @else border-[#dee9fc] @enderror focus:bg-white focus:outline-none focus:border-[#004125]">
                    @error('singkatan')
                        <p class="text-[11px] text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Grid Rentang Usia & Label Bagian -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label for="rentang_usia" class="block text-xs font-bold text-[#121c2a] mb-1.5">
                        Deskripsi / Rentang Usia
                    </label>
                    <input type="text" id="rentang_usia" name="rentang_usia" value="{{ old('rentang_usia', $banom->rentang_usia) }}" placeholder="Contoh: Pemuda usia 20-40 tahun" class="w-full px-4 py-3 rounded-xl text-xs sm:text-sm bg-[#f8f9ff] border border-[#dee9fc] focus:bg-white focus:outline-none focus:border-[#004125]">
                </div>

                <div>
                    <label for="label_bagian" class="block text-xs font-bold text-[#121c2a] mb-1.5">
                        Label Bagian / Divisi (Dropdown)
                    </label>
                    <select id="label_bagian" name="label_bagian" class="w-full px-4 py-3 rounded-xl text-xs sm:text-sm bg-[#f8f9ff] border border-[#dee9fc] focus:bg-white focus:outline-none focus:border-[#004125]">
                        <option value="Bidang" {{ old('label_bagian', $banom->label_bagian ?? 'Bidang') === 'Bidang' ? 'selected' : '' }}>Bidang (mis. GP Ansor, Fatayat)</option>
                        <option value="Departemen" {{ old('label_bagian', $banom->label_bagian) === 'Departemen' ? 'selected' : '' }}>Departemen (mis. IPNU, IPPNU)</option>
                        <option value="Seksi" {{ old('label_bagian', $banom->label_bagian) === 'Seksi' ? 'selected' : '' }}>Seksi (mis. Muslimat NU)</option>
                        <option value="Unit/Biro" {{ old('label_bagian', $banom->label_bagian) === 'Unit/Biro' ? 'selected' : '' }}>Unit / Biro (mis. BANSER)</option>
                    </select>
                </div>
            </div>

            <!-- Deskripsi Singkat -->
            <div>
                <label for="deskripsi" class="block text-xs font-bold text-[#121c2a] mb-1.5">
                    Deskripsi Profil BANOM
                </label>
                <textarea id="deskripsi" name="deskripsi" rows="3" class="w-full px-4 py-3 rounded-xl text-xs sm:text-sm bg-[#f8f9ff] border border-[#dee9fc] focus:bg-white focus:outline-none focus:border-[#004125]">{{ old('deskripsi', $banom->deskripsi) }}</textarea>
                @error('deskripsi')
                    <p class="text-[11px] text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Logo Upload & Current Logo Preview -->
            <div>
                <label for="logo" class="block text-xs font-bold text-[#121c2a] mb-1.5">
                    Upload Logo Baru (Maks 2MB, JPG/PNG/WEBP)
                </label>

                @if($banom->logo)
                    <div class="flex items-center gap-4 mb-3 p-3 bg-[#f8f9ff] rounded-xl border border-[#dee9fc]">
                        <img src="{{ asset('storage/' . $banom->logo) }}" alt="Logo {{ $banom->singkatan }}" class="w-12 h-12 object-contain rounded-lg bg-white p-1 border border-gray-200">
                        <div>
                            <span class="text-xs font-bold text-gray-800 block">Logo Saat Ini Aktif</span>
                            <span class="text-[11px] text-gray-400">File lama akan otomatis diganti jika Anda mengunggah file baru.</span>
                        </div>
                    </div>
                @endif

                <input type="file" id="logo" name="logo" accept=".jpg,.jpeg,.png,.webp" class="w-full text-xs text-gray-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-[#eff4ff] file:text-[#004125] hover:file:bg-[#dee9fc] border border-[#dee9fc] rounded-xl p-2 bg-[#f8f9ff]">
                @error('logo')
                    <p class="text-[11px] text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5 items-center">
                <!-- Urutan Tampilan -->
                <div>
                    <label for="urutan" class="block text-xs font-bold text-[#121c2a] mb-1.5">
                        Urutan Tampilan
                    </label>
                    <input type="number" id="urutan" name="urutan" value="{{ old('urutan', $banom->urutan) }}" min="0" required class="w-full px-4 py-3 rounded-xl text-xs sm:text-sm bg-[#f8f9ff] border @error('urutan') border-red-500 @else border-[#dee9fc] @enderror focus:bg-white focus:outline-none focus:border-[#004125]">
                    @error('urutan')
                        <p class="text-[11px] text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Status Aktif Checkbox -->
                <div class="pt-4 sm:pt-6">
                    <label class="flex items-center gap-3 cursor-pointer">
                        <input type="checkbox" name="is_active" value="1" {{ old('is_active', $banom->is_active) ? 'checked' : '' }} class="w-5 h-5 rounded text-[#0c5a37] focus:ring-[#004125] border-gray-300">
                        <span class="text-xs font-bold text-[#121c2a]">Status Aktif (Tampilkan di Publik)</span>
                    </label>
                    <p class="text-[11px] text-[#707971] mt-1 pl-8">Nonaktifkan jika Banom sementara tidak ditampilkan.</p>
                </div>
            </div>

            <!-- Submit Button & Action -->
            <div class="pt-5 border-t border-[#f2f4f8] flex flex-wrap items-center justify-between gap-3">
                <a href="{{ route('admin.banoms.officers.index', $banom->id) }}" class="px-4 py-2.5 rounded-xl border border-emerald-300 text-[#004125] bg-emerald-50 hover:bg-emerald-100 text-xs font-extrabold flex items-center gap-1.5 transition">
                    <span class="material-symbols-outlined text-[18px]">group_add</span>
                    <span>Kelola Pengurus Banom</span>
                </a>

                <div class="flex items-center gap-2">
                    <a href="{{ route('admin.banoms.index') }}" class="px-5 py-2.5 rounded-xl border border-gray-300 text-gray-700 text-xs font-bold hover:bg-gray-50 transition">
                        Batal
                    </a>
                    <button type="submit" class="px-6 py-2.5 rounded-xl bg-[#0c5a37] hover:bg-[#004125] text-white text-xs font-black shadow-md transition flex items-center gap-2">
                        <span class="material-symbols-outlined text-[18px]">save</span>
                        <span>Perbarui Banom</span>
                    </button>
                </div>
            </div>
        </form>
    </div>

</div>
@endsection
