@extends('layouts.admin')

@section('title', 'Tulis Warta / Berita Baru — SIMNU Admin')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">

    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <nav class="flex items-center gap-2 text-xs text-gray-500 mb-1">
                <a href="{{ route('admin.dashboard') }}" class="hover:text-emerald-800">Admin</a>
                <span>/</span>
                <a href="{{ route('admin.berita.index') }}" class="hover:text-emerald-800">Warta</a>
                <span>/</span>
                <span class="text-gray-900 font-bold">Tulis Baru</span>
            </nav>
            <h1 class="text-2xl font-black text-[#004125]">Tulis Warta & Artikel Baru</h1>
            <p class="text-xs text-[#526350]">Publikasikan warta kegiatan, siaran pers BANOM, atau kajian keagamaan.</p>
        </div>

        <a href="{{ route('admin.berita.index') }}" class="w-full sm:w-auto px-4 py-2.5 rounded-xl border border-gray-300 hover:bg-gray-100 text-gray-700 text-xs font-bold transition flex items-center justify-center gap-1.5 min-h-[44px]">
            <span class="material-symbols-outlined text-[16px]">arrow_back</span>
            <span>Kembali</span>
        </a>
    </div>

    <div class="bg-white rounded-3xl p-6 sm:p-8 border border-[#e6eeff] shadow-sm">
        <form action="{{ route('admin.berita.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div class="space-y-1 sm:col-span-2">
                    <label for="title" class="block text-xs font-bold uppercase text-[#004125]">
                        Judul Berita / Warta <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="title" id="title" value="{{ old('title') }}" required placeholder="Contoh: Ranting NU Banjaranyar Gelar Safari Ramadan dan Santunan Yatim"
                        class="w-full py-2.5 px-3 text-xs rounded-xl border border-gray-200 focus:border-[#0c5a37] font-bold text-gray-900 text-sm">
                    @error('title') <p class="text-[11px] text-red-600">{{ $message }}</p> @enderror
                </div>

                <div class="space-y-1">
                    <label for="kategori" class="block text-xs font-bold uppercase text-[#004125]">
                        Kategori Publikasi <span class="text-red-500">*</span>
                    </label>
                    <select name="kategori" id="kategori" required class="w-full py-2.5 px-3 text-xs rounded-xl border border-gray-200 focus:border-[#0c5a37]">
                        <option value="Kegiatan" {{ old('kategori') == 'Kegiatan' ? 'selected' : '' }}>Kegiatan Ranting</option>
                        <option value="Pengumuman" {{ old('kategori') == 'Pengumuman' ? 'selected' : '' }}>Pengumuman Resmi</option>
                        <option value="Kajian" {{ old('kategori') == 'Kajian' ? 'selected' : '' }}>Kajian / Risalah Islam</option>
                        <option value="Opini" {{ old('kategori') == 'Opini' ? 'selected' : '' }}>Opini & Artikel Kader</option>
                        <option value="Umum" {{ old('kategori') == 'Umum' ? 'selected' : '' }}>Warta Umum</option>
                    </select>
                </div>

                <div class="space-y-1">
                    <label for="banom_id" class="block text-xs font-bold uppercase text-[#004125]">
                        Terkait Badan Otonom (Opsional)
                    </label>
                    <select name="banom_id" id="banom_id" class="w-full py-2.5 px-3 text-xs rounded-xl border border-gray-200 focus:border-[#0c5a37]">
                        <option value="">-- Warta Umum PRNU Banjaranyar --</option>
                        @foreach($banoms as $b)
                            <option value="{{ $b->id }}" {{ old('banom_id') == $b->id ? 'selected' : '' }}>
                                {{ $b->singkatan }} - {{ $b->nama }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="space-y-1 sm:col-span-2">
                    <label for="excerpt" class="block text-xs font-bold uppercase text-[#004125]">
                        Kutipan Singkat (Lead / Ringkasan untuk Beranda)
                    </label>
                    <textarea name="excerpt" id="excerpt" rows="2" placeholder="Tuliskan 1-2 kalimat pengantar menarik tentang warta ini..."
                        class="w-full py-2 px-3 text-xs rounded-xl border border-gray-200 focus:border-[#0c5a37]">{{ old('excerpt') }}</textarea>
                </div>

                <div class="space-y-1 sm:col-span-2">
                    <label for="content" class="block text-xs font-bold uppercase text-[#004125]">
                        Isi Warta / Artikel Lengkap <span class="text-red-500">*</span>
                    </label>
                    <textarea name="content" id="content" rows="10" required placeholder="Tuliskan isi berita secara lengkap di sini..."
                        class="w-full py-2.5 px-3 text-xs rounded-xl border border-gray-200 focus:border-[#0c5a37] leading-relaxed">{{ old('content') }}</textarea>
                    @error('content') <p class="text-[11px] text-red-600">{{ $message }}</p> @enderror
                </div>

                <div class="space-y-1">
                    <label for="author" class="block text-xs font-bold uppercase text-[#004125]">
                        Penulis / Tim Redaksi <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="author" id="author" value="{{ old('author', Auth::user()->name ?? 'Redaksi SIMNU') }}" required
                        class="w-full py-2.5 px-3 text-xs rounded-xl border border-gray-200 focus:border-[#0c5a37]">
                </div>

                <div class="space-y-1">
                    <label for="status" class="block text-xs font-bold uppercase text-[#004125]">
                        Status Publikasi <span class="text-red-500">*</span>
                    </label>
                    <select name="status" id="status" required class="w-full py-2.5 px-3 text-xs rounded-xl border border-gray-200 focus:border-[#0c5a37]">
                        <option value="published" {{ old('status', 'published') === 'published' ? 'selected' : '' }}>Tayang Langsung (Published)</option>
                        <option value="draft" {{ old('status') === 'draft' ? 'selected' : '' }}>Simpan sebagai Draf</option>
                    </select>
                </div>

                <div class="space-y-1 sm:col-span-2">
                    <label for="thumbnail" class="block text-xs font-bold uppercase text-[#004125]">
                        Foto Utama / Thumbnail Warta
                    </label>
                    <input type="file" name="thumbnail" id="thumbnail" accept="image/*"
                        class="w-full text-xs text-gray-500 file:mr-3 file:py-2 file:px-3 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-emerald-50 file:text-[#004125] hover:file:bg-emerald-100">
                    <p class="text-[10px] text-gray-400">Format gambar 16:9 disarankan untuk tampilan optimal di beranda (maks. 3MB)</p>
                </div>
            </div>

            <div class="pt-4 border-t border-gray-100 flex flex-col sm:flex-row items-stretch sm:items-center justify-end gap-3">
                <a href="{{ route('admin.berita.index') }}" class="px-5 py-2.5 rounded-xl border border-gray-300 hover:bg-gray-100 text-gray-700 text-xs font-bold transition text-center min-h-[44px] flex items-center justify-center">
                    Batal
                </a>
                <button type="submit" class="px-6 py-2.5 rounded-xl bg-[#004125] hover:bg-[#0c5a37] text-white text-xs font-extrabold transition flex items-center justify-center gap-1.5 shadow-md min-h-[44px]">
                    <span class="material-symbols-outlined text-[16px]">publish</span>
                    <span>Publikasikan Warta</span>
                </button>
            </div>
        </form>
    </div>

</div>
@endsection
