@extends('layouts.admin')

@section('title', 'Edit Album Galeri — SIMNU Admin')

@section('content')
<div class="space-y-6 max-w-4xl">

    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <a href="{{ route('admin.galeri.index') }}" class="text-xs text-[#0c5a37] hover:underline flex items-center gap-1 mb-1 font-bold">
                <span class="material-symbols-outlined text-[16px]">arrow_back</span>
                <span>Kembali ke Daftar Galeri</span>
            </a>
            <h1 class="text-2xl font-black text-[#004125]">Edit Album: {{ $gallery->judul }}</h1>
            <p class="text-xs text-[#526350]">Perbarui detail album atau kelola foto-foto di dalamnya.</p>
        </div>

        <a href="{{ route('admin.galeri.index') }}" class="w-full sm:w-auto min-h-[44px] px-4 py-2 rounded-xl border border-gray-300 hover:bg-gray-100 text-gray-700 text-xs font-bold transition flex items-center justify-center gap-1.5 shadow-sm">
            <span class="material-symbols-outlined text-[16px]">arrow_back</span>
            <span>Kembali</span>
        </a>
    </div>

    <!-- Edit Form Card -->
    <div class="bg-white rounded-3xl p-6 sm:p-8 border border-[#e6eeff] shadow-sm">
        <form action="{{ route('admin.galeri.update', $gallery->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PUT')

            <!-- Judul Album -->
            <div>
                <label for="judul" class="block text-xs font-bold text-gray-800 mb-1.5">
                    Judul Album Kegiatan <span class="text-red-500">*</span>
                </label>
                <input type="text" name="judul" id="judul" value="{{ old('judul', $gallery->judul) }}" required class="w-full px-4 py-2.5 rounded-xl text-xs sm:text-sm border border-gray-200 focus:border-[#0c5a37] focus:outline-none">
            </div>

            <!-- Tanggal, Kategori & Status Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div>
                    <label for="tanggal" class="block text-xs font-bold text-gray-800 mb-1.5">
                        Tanggal Kegiatan <span class="text-red-500">*</span>
                    </label>
                    <input type="date" name="tanggal" id="tanggal" value="{{ old('tanggal', $gallery->tanggal->format('Y-m-d')) }}" required class="w-full px-4 py-2.5 rounded-xl text-xs sm:text-sm border border-gray-200 focus:border-[#0c5a37] focus:outline-none">
                </div>

                <div>
                    <label for="kategori" class="block text-xs font-bold text-gray-800 mb-1.5">
                        Kategori Kegiatan <span class="text-red-500">*</span>
                    </label>
                    <select name="kategori" id="kategori" class="w-full px-4 py-2.5 rounded-xl text-xs sm:text-sm border border-gray-200 focus:border-[#0c5a37] focus:outline-none">
                        @foreach(['Keagamaan', 'Sosial Ummat', 'Kaderisasi', 'Banser & Ansor', 'Muslimat & Fatayat', 'IPNU & IPPNU', 'Umum'] as $cat)
                            <option value="{{ $cat }}" {{ old('kategori', $gallery->kategori) === $cat ? 'selected' : '' }}>{{ $cat }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label for="status" class="block text-xs font-bold text-gray-800 mb-1.5">
                        Status Publikasi <span class="text-red-500">*</span>
                    </label>
                    <select name="status" id="status" class="w-full px-4 py-2.5 rounded-xl text-xs sm:text-sm border border-gray-200 focus:border-[#0c5a37] focus:outline-none">
                        <option value="Publik" {{ old('status', $gallery->status) === 'Publik' ? 'selected' : '' }}>Publik (Tampil di Website)</option>
                        <option value="Draf" {{ old('status', $gallery->status) === 'Draf' ? 'selected' : '' }}>Draf (Disimpan Sementara)</option>
                    </select>
                </div>
            </div>

            <!-- Lokasi -->
            <div>
                <label for="lokasi" class="block text-xs font-bold text-gray-800 mb-1.5">
                    Lokasi Kegiatan <span class="text-gray-400 font-normal">(Opsional)</span>
                </label>
                <input type="text" name="lokasi" id="lokasi" value="{{ old('lokasi', $gallery->lokasi) }}" class="w-full px-4 py-2.5 rounded-xl text-xs sm:text-sm border border-gray-200 focus:border-[#0c5a37] focus:outline-none">
            </div>

            <!-- Deskripsi -->
            <div>
                <label for="deskripsi" class="block text-xs font-bold text-gray-800 mb-1.5">
                    Keterangan / Deskripsi <span class="text-gray-400 font-normal">(Opsional)</span>
                </label>
                <textarea name="deskripsi" id="deskripsi" rows="3" class="w-full px-4 py-2.5 rounded-xl text-xs sm:text-sm border border-gray-200 focus:border-[#0c5a37] focus:outline-none">{{ old('deskripsi', $gallery->deskripsi) }}</textarea>
            </div>

            <!-- Ganti Cover & Tambah Foto Baru -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5 pt-2">
                <div class="border border-gray-200 p-4 rounded-2xl space-y-2">
                    <label class="block text-xs font-bold text-gray-800">
                        Ganti Foto Sampul / Cover
                    </label>
                    @if($gallery->cover)
                        <div class="w-20 h-16 rounded-lg overflow-hidden border border-gray-300">
                            <img src="{{ asset('storage/' . $gallery->cover) }}" alt="Cover" class="w-full h-full object-cover">
                        </div>
                    @endif
                    <input type="file" name="cover" accept="image/*" class="text-xs text-gray-600 file:mr-3 file:py-1 file:px-2.5 file:rounded-lg file:border-0 file:text-xs file:font-bold file:bg-[#eff4ff] file:text-[#004125]">
                </div>

                <div class="border-2 border-dashed border-[#0c5a37]/30 bg-[#f8f9ff] p-4 rounded-2xl space-y-2">
                    <label class="block text-xs font-bold text-[#004125]">
                        Tambah Foto Baru ke Album (Batch)
                    </label>
                    <p class="text-[11px] text-gray-500">Pilih beberapa foto tambahan (JPG, PNG, WEBP) maks 5MB/file.</p>
                    <input type="file" name="photos[]" multiple accept="image/*" class="text-xs text-gray-600 file:mr-3 file:py-1 file:px-2.5 file:rounded-lg file:border-0 file:text-xs file:font-bold file:bg-[#004125] file:text-white">
                </div>
            </div>

            <!-- Submit Button -->
            <div class="pt-4 border-t border-gray-100 flex flex-col-reverse sm:flex-row items-stretch sm:items-center justify-end gap-3">
                <a href="{{ route('admin.galeri.index') }}" class="min-h-[44px] px-5 py-2.5 rounded-xl border border-gray-300 text-gray-700 text-xs font-bold hover:bg-gray-100 transition flex items-center justify-center">
                    Batal
                </a>
                <button type="submit" class="min-h-[44px] px-6 py-2.5 rounded-xl bg-[#004125] hover:bg-[#0c5a37] text-white text-xs font-bold transition shadow-md flex items-center justify-center gap-2">
                    <span class="material-symbols-outlined text-[18px]">save</span>
                    <span>Perbarui Album</span>
                </button>
            </div>
        </form>
    </div>

    <!-- Existing Photos Grid & Deletion -->
    <div class="bg-white rounded-3xl p-6 sm:p-8 border border-[#e6eeff] shadow-sm space-y-4">
        <div class="flex items-center justify-between">
            <h2 class="text-base font-bold text-[#004125] flex items-center gap-2">
                <span class="material-symbols-outlined text-[20px]">photo_library</span>
                <span>Foto yang Sudah Diunggah ({{ $gallery->photos->count() }})</span>
            </h2>
            <span class="text-xs text-gray-500">Klik ikon tempat sampah untuk menghapus foto tertentu</span>
        </div>

        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-4">
            @forelse ($gallery->photos as $p)
                <div class="group relative rounded-2xl overflow-hidden aspect-square bg-slate-100 border border-gray-200">
                    <img src="{{ asset('storage/' . $p->foto) }}" alt="Foto" class="w-full h-full object-cover">
                    
                    <div class="absolute inset-0 bg-black/40 sm:bg-black/50 sm:opacity-0 group-hover:opacity-100 transition-opacity flex items-end sm:items-center justify-end sm:justify-center p-2 sm:p-0">
                        <form action="{{ route('admin.galeri.photo.destroy', $p->id) }}" method="POST" onsubmit="return confirm('Hapus foto ini dari album?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="p-2 sm:p-2.5 min-h-[40px] min-w-[40px] rounded-xl bg-red-600 hover:bg-red-700 text-white shadow-lg transition flex items-center justify-center" title="Hapus Foto Ini">
                                <span class="material-symbols-outlined text-lg">delete</span>
                            </button>
                        </form>
                    </div>
                </div>
            @empty
                <div class="col-span-4 p-8 text-center text-xs text-gray-400">
                    Belum ada foto dalam album ini.
                </div>
            @endforelse
        </div>
    </div>

</div>
@endsection
