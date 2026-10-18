@extends('layouts.admin')

@section('title', 'Tambah Album Galeri — SIMNU Admin')

@section('content')
<div class="space-y-6 max-w-4xl">

    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <a href="{{ route('admin.galeri.index') }}" class="text-xs text-[#0c5a37] hover:underline flex items-center gap-1 mb-1 font-bold">
                <span class="material-symbols-outlined text-[16px]">arrow_back</span>
                <span>Kembali ke Daftar Galeri</span>
            </a>
            <h1 class="text-2xl font-black text-[#004125]">Tambah Album Galeri Baru</h1>
            <p class="text-xs text-[#526350]">Unggah foto-foto dokumentasi kegiatan dan kelompokkan dalam album.</p>
        </div>

        <a href="{{ route('admin.galeri.index') }}" class="w-full sm:w-auto min-h-[44px] px-4 py-2 rounded-xl border border-gray-300 hover:bg-gray-100 text-gray-700 text-xs font-bold transition flex items-center justify-center gap-1.5 shadow-sm">
            <span class="material-symbols-outlined text-[16px]">arrow_back</span>
            <span>Kembali</span>
        </a>
    </div>

    <!-- Form Card -->
    <div class="bg-white rounded-3xl p-6 sm:p-8 border border-[#e6eeff] shadow-sm">
        <form action="{{ route('admin.galeri.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf

            <!-- Judul Album -->
            <div>
                <label for="judul" class="block text-xs font-bold text-gray-800 mb-1.5">
                    Judul Album Kegiatan <span class="text-red-500">*</span>
                </label>
                <input type="text" name="judul" id="judul" value="{{ old('judul') }}" required placeholder="Contoh: Istighotsah Kubro & Dzikir Bersama Malam Jumat Legi" class="w-full px-4 py-2.5 rounded-xl text-xs sm:text-sm border border-gray-200 focus:border-[#0c5a37] focus:outline-none @error('judul') border-red-400 @enderror">
                @error('judul')
                    <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Tanggal & Kategori Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div>
                    <label for="tanggal" class="block text-xs font-bold text-gray-800 mb-1.5">
                        Tanggal Kegiatan <span class="text-red-500">*</span>
                    </label>
                    <input type="date" name="tanggal" id="tanggal" value="{{ old('tanggal', date('Y-m-d')) }}" required class="w-full px-4 py-2.5 rounded-xl text-xs sm:text-sm border border-gray-200 focus:border-[#0c5a37] focus:outline-none">
                </div>

                <div>
                    <label for="kategori" class="block text-xs font-bold text-gray-800 mb-1.5">
                        Kategori Kegiatan <span class="text-red-500">*</span>
                    </label>
                    <select name="kategori" id="kategori" class="w-full px-4 py-2.5 rounded-xl text-xs sm:text-sm border border-gray-200 focus:border-[#0c5a37] focus:outline-none">
                        <option value="Keagamaan">Keagamaan / Istighotsah</option>
                        <option value="Sosial Ummat">Sosial Ummat & LAZISNU</option>
                        <option value="Kaderisasi">Kaderisasi & Pelatihan</option>
                        <option value="Banser & Ansor">Banser & GP Ansor</option>
                        <option value="Muslimat & Fatayat">Muslimat & Fatayat</option>
                        <option value="IPNU & IPPNU">IPNU & IPPNU</option>
                        <option value="Umum">Umum / Lainnya</option>
                    </select>
                </div>

                <div>
                    <label for="status" class="block text-xs font-bold text-gray-800 mb-1.5">
                        Status Publikasi <span class="text-red-500">*</span>
                    </label>
                    <select name="status" id="status" class="w-full px-4 py-2.5 rounded-xl text-xs sm:text-sm border border-gray-200 focus:border-[#0c5a37] focus:outline-none">
                        <option value="Publik">Publik (Tampil di Website)</option>
                        <option value="Draf">Draf (Disimpan Sementara)</option>
                    </select>
                </div>
            </div>

            <!-- Lokasi -->
            <div>
                <label for="lokasi" class="block text-xs font-bold text-gray-800 mb-1.5">
                    Lokasi Kegiatan <span class="text-gray-400 font-normal">(Opsional)</span>
                </label>
                <input type="text" name="lokasi" id="lokasi" value="{{ old('lokasi') }}" placeholder="Contoh: Gedung Bersama PRNU Banjaranyar" class="w-full px-4 py-2.5 rounded-xl text-xs sm:text-sm border border-gray-200 focus:border-[#0c5a37] focus:outline-none">
            </div>

            <!-- Deskripsi -->
            <div>
                <label for="deskripsi" class="block text-xs font-bold text-gray-800 mb-1.5">
                    Keterangan / Deskripsi Singkat <span class="text-gray-400 font-normal">(Opsional)</span>
                </label>
                <textarea name="deskripsi" id="deskripsi" rows="3" placeholder="Tuliskan gambaran ringkas kegiatan ini..." class="w-full px-4 py-2.5 rounded-xl text-xs sm:text-sm border border-gray-200 focus:border-[#0c5a37] focus:outline-none">{{ old('deskripsi') }}</textarea>
            </div>

            <!-- Upload Cover & Upload Foto Banyak Sekaligus -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5 pt-2">
                <!-- Cover Image -->
                <div class="border-2 border-dashed border-gray-200 p-5 rounded-2xl text-center space-y-2 hover:border-[#0c5a37] transition">
                    <span class="material-symbols-outlined text-gray-400 text-3xl">image</span>
                    <label class="block text-xs font-bold text-gray-800">
                        Foto Sampul / Cover Album
                    </label>
                    <p class="text-[11px] text-gray-500">Opsional. Jika kosong, foto pertama akan menjadi cover otomatis.</p>
                    <input type="file" name="cover" accept="image/*" class="text-xs text-gray-600 file:mr-3 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-bold file:bg-[#eff4ff] file:text-[#004125]">
                </div>

                <!-- Batch Photos Upload -->
                <div class="border-2 border-dashed border-[#0c5a37]/30 bg-[#f8f9ff] p-5 rounded-2xl text-center space-y-2 hover:border-[#0c5a37] transition">
                    <span class="material-symbols-outlined text-[#0c5a37] text-3xl">add_photo_alternate</span>
                    <label class="block text-xs font-bold text-[#004125]">
                        Unggah Banyak Foto Sekaligus (Batch) <span class="text-red-500">*</span>
                    </label>
                    <p class="text-[11px] text-gray-500">Pilih beberapa file gambar (JPG, PNG, WEBP) maksimal 5MB/file.</p>
                    <input type="file" name="photos[]" multiple accept="image/*" class="text-xs text-gray-600 file:mr-3 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-bold file:bg-[#004125] file:text-white">
                </div>
            </div>

            <!-- Submit Button -->
            <div class="pt-4 border-t border-gray-100 flex flex-col-reverse sm:flex-row items-stretch sm:items-center justify-end gap-3">
                <a href="{{ route('admin.galeri.index') }}" class="min-h-[44px] px-5 py-2.5 rounded-xl border border-gray-300 text-gray-700 text-xs font-bold hover:bg-gray-100 transition flex items-center justify-center">
                    Batal
                </a>
                <button type="submit" class="min-h-[44px] px-6 py-2.5 rounded-xl bg-[#004125] hover:bg-[#0c5a37] text-white text-xs font-bold transition shadow-md flex items-center justify-center gap-2">
                    <span class="material-symbols-outlined text-[18px]">save</span>
                    <span>Simpan Album Kegiatan</span>
                </button>
            </div>
        </form>
    </div>

</div>
@endsection
