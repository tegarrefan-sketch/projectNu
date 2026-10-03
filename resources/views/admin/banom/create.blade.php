@extends('layouts.admin')

@section('title', 'Tambah Badan Otonom Baru — SIMNU Admin')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">

    <div class="flex items-center justify-between">
        <div>
            <nav class="flex items-center gap-2 text-xs text-gray-500 mb-1">
                <a href="{{ route('admin.dashboard') }}" class="hover:text-emerald-800">Admin</a>
                <span>/</span>
                <a href="{{ route('admin.banom.index') }}" class="hover:text-emerald-800">BANOM</a>
                <span>/</span>
                <span class="text-gray-900 font-bold">Tambah Baru</span>
            </nav>
            <h1 class="text-2xl font-black text-[#004125]">Tambah Badan Otonom (BANOM)</h1>
            <p class="text-xs text-[#526350]">Daftarkan sayap organisasi atau lembaga di bawah naungan Nahdlatul Ulama.</p>
        </div>

        <a href="{{ route('admin.banom.index') }}" class="px-3.5 py-2 rounded-xl border border-gray-300 hover:bg-gray-100 text-gray-700 text-xs font-bold transition flex items-center gap-1.5">
            <span class="material-symbols-outlined text-[16px]">arrow_back</span>
            <span>Kembali</span>
        </a>
    </div>

    <div class="bg-white rounded-3xl p-6 sm:p-8 border border-[#e6eeff] shadow-sm">
        <form action="{{ route('admin.banom.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div class="space-y-1">
                    <label for="nama" class="block text-xs font-bold uppercase text-[#004125]">
                        Nama Lengkap Organisasi <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="nama" id="nama" value="{{ old('nama') }}" required placeholder="Contoh: Ikatan Pelajar Nahdlatul Ulama"
                        class="w-full py-2.5 px-3 text-xs rounded-xl border border-gray-200 focus:border-[#0c5a37] text-gray-800">
                    @error('nama') <p class="text-[11px] text-red-600">{{ $message }}</p> @enderror
                </div>

                <div class="space-y-1">
                    <label for="singkatan" class="block text-xs font-bold uppercase text-[#004125]">
                        Singkatan / Akronim <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="singkatan" id="singkatan" value="{{ old('singkatan') }}" required placeholder="Contoh: IPNU"
                        class="w-full py-2.5 px-3 text-xs rounded-xl border border-gray-200 focus:border-[#0c5a37] uppercase font-bold text-gray-800">
                    @error('singkatan') <p class="text-[11px] text-red-600">{{ $message }}</p> @enderror
                </div>

                <div class="space-y-1 sm:col-span-2">
                    <label for="deskripsi" class="block text-xs font-bold uppercase text-[#004125]">
                        Deskripsi Singkat Profil
                    </label>
                    <textarea name="deskripsi" id="deskripsi" rows="3" placeholder="Jelaskan peran dan fokus kegiatan badan otonom ini..."
                        class="w-full py-2 px-3 text-xs rounded-xl border border-gray-200 focus:border-[#0c5a37]">{{ old('deskripsi') }}</textarea>
                </div>

                <div class="space-y-1">
                    <label for="visi" class="block text-xs font-bold uppercase text-[#004125]">Visi</label>
                    <textarea name="visi" id="visi" rows="2" placeholder="Visi organisasi..."
                        class="w-full py-2 px-3 text-xs rounded-xl border border-gray-200 focus:border-[#0c5a37]">{{ old('visi') }}</textarea>
                </div>

                <div class="space-y-1">
                    <label for="misi" class="block text-xs font-bold uppercase text-[#004125]">Misi</label>
                    <textarea name="misi" id="misi" rows="2" placeholder="Misi organisasi (bisa menggunakan nomor atau poin)..."
                        class="w-full py-2 px-3 text-xs rounded-xl border border-gray-200 focus:border-[#0c5a37]">{{ old('misi') }}</textarea>
                </div>

                <div class="space-y-1 sm:col-span-2">
                    <label for="sejarah" class="block text-xs font-bold uppercase text-[#004125]">Sejarah Singkat Pembentukan</label>
                    <textarea name="sejarah" id="sejarah" rows="3" placeholder="Sejarah berdirinya banom di ranting Banjaranyar..."
                        class="w-full py-2 px-3 text-xs rounded-xl border border-gray-200 focus:border-[#0c5a37]">{{ old('sejarah') }}</textarea>
                </div>

                <div class="space-y-1">
                    <label for="kontak" class="block text-xs font-bold uppercase text-[#004125]">Nomor Kontak / WhatsApp</label>
                    <input type="text" name="kontak" id="kontak" value="{{ old('kontak') }}" placeholder="Contoh: 08123456789"
                        class="w-full py-2.5 px-3 text-xs rounded-xl border border-gray-200 focus:border-[#0c5a37]">
                </div>

                <div class="space-y-1">
                    <label for="alamat" class="block text-xs font-bold uppercase text-[#004125]">Alamat Sekretariat</label>
                    <input type="text" name="alamat" id="alamat" value="{{ old('alamat', 'Kompleks Masjid Jami\' Desa Banjaranyar') }}"
                        class="w-full py-2.5 px-3 text-xs rounded-xl border border-gray-200 focus:border-[#0c5a37]">
                </div>

                <div class="space-y-1">
                    <label for="status" class="block text-xs font-bold uppercase text-[#004125]">Status <span class="text-red-500">*</span></label>
                    <select name="status" id="status" required class="w-full py-2.5 px-3 text-xs rounded-xl border border-gray-200 focus:border-[#0c5a37]">
                        <option value="Aktif" {{ old('status') == 'Aktif' ? 'selected' : '' }}>Aktif</option>
                        <option value="Tidak Aktif" {{ old('status') == 'Tidak Aktif' ? 'selected' : '' }}>Tidak Aktif</option>
                    </select>
                </div>

                <div class="space-y-1">
                    <label for="urutan" class="block text-xs font-bold uppercase text-[#004125]">Urutan Tampilan</label>
                    <input type="number" name="urutan" id="urutan" value="{{ old('urutan', 1) }}"
                        class="w-full py-2.5 px-3 text-xs rounded-xl border border-gray-200 focus:border-[#0c5a37]">
                </div>

                <div class="space-y-1 sm:col-span-2">
                    <label for="logo" class="block text-xs font-bold uppercase text-[#004125]">Logo Resmi BANOM</label>
                    <input type="file" name="logo" id="logo" accept="image/*"
                        class="w-full text-xs text-gray-500 file:mr-3 file:py-2 file:px-3 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-emerald-50 file:text-[#004125] hover:file:bg-emerald-100">
                    <p class="text-[10px] text-gray-400">Format gambar PNG transparan atau SVG diutamakan.</p>
                </div>
            </div>

            <div class="pt-4 border-t border-gray-100 flex items-center justify-end gap-3">
                <a href="{{ route('admin.banom.index') }}" class="px-5 py-2.5 rounded-xl border border-gray-300 hover:bg-gray-100 text-gray-700 text-xs font-bold transition">
                    Batal
                </a>
                <button type="submit" class="px-6 py-2.5 rounded-xl bg-[#004125] hover:bg-[#0c5a37] text-white text-xs font-extrabold transition flex items-center gap-1.5 shadow-md">
                    <span class="material-symbols-outlined text-[16px]">save</span>
                    <span>Simpan Badan Otonom</span>
                </button>
            </div>
        </form>
    </div>

</div>
@endsection
