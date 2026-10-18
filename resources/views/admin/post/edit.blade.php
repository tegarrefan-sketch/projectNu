@extends('layouts.admin')

@section('title', 'Edit Warta: ' . $post->title . ' — SIMNU Admin')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">

    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <nav class="flex items-center gap-2 text-xs text-gray-500 mb-1">
                <a href="{{ route('admin.dashboard') }}" class="hover:text-emerald-800">Admin</a>
                <span>/</span>
                <a href="{{ route('admin.berita.index') }}" class="hover:text-emerald-800">Warta</a>
                <span>/</span>
                <span class="text-gray-900 font-bold truncate max-w-xs">{{ $post->title }}</span>
            </nav>
            <h1 class="text-2xl font-black text-[#004125]">Edit Warta & Publikasi</h1>
            <p class="text-xs text-[#526350]">Perbarui materi berita, kutipan ringkas, atau foto dokumentasi.</p>
        </div>

        <a href="{{ route('admin.berita.index') }}" class="w-full sm:w-auto px-4 py-2.5 rounded-xl border border-gray-300 hover:bg-gray-100 text-gray-700 text-xs font-bold transition flex items-center justify-center gap-1.5 min-h-[44px]">
            <span class="material-symbols-outlined text-[16px]">arrow_back</span>
            <span>Kembali</span>
        </a>
    </div>

    <div class="bg-white rounded-3xl p-6 sm:p-8 border border-[#e6eeff] shadow-sm">
        <form action="{{ route('admin.berita.update', $post->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div class="space-y-1 sm:col-span-2">
                    <label for="title" class="block text-xs font-bold uppercase text-[#004125]">
                        Judul Berita / Warta <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="title" id="title" value="{{ old('title', $post->title) }}" required
                        class="w-full py-2.5 px-3 text-xs rounded-xl border border-gray-200 focus:border-[#0c5a37] font-bold text-gray-900 text-sm">
                </div>

                <div class="space-y-1">
                    <label for="kategori" class="block text-xs font-bold uppercase text-[#004125]">
                        Kategori Publikasi <span class="text-red-500">*</span>
                    </label>
                    <select name="kategori" id="kategori" required class="w-full py-2.5 px-3 text-xs rounded-xl border border-gray-200 focus:border-[#0c5a37]">
                        <option value="Kegiatan" {{ old('kategori', $post->kategori) == 'Kegiatan' ? 'selected' : '' }}>Kegiatan Ranting</option>
                        <option value="Pengumuman" {{ old('kategori', $post->kategori) == 'Pengumuman' ? 'selected' : '' }}>Pengumuman Resmi</option>
                        <option value="Kajian" {{ old('kategori', $post->kategori) == 'Kajian' ? 'selected' : '' }}>Kajian / Risalah Islam</option>
                        <option value="Opini" {{ old('kategori', $post->kategori) == 'Opini' ? 'selected' : '' }}>Opini & Artikel Kader</option>
                        <option value="Umum" {{ old('kategori', $post->kategori) == 'Umum' ? 'selected' : '' }}>Warta Umum</option>
                    </select>
                </div>

                <div class="space-y-1">
                    <label for="banom_id" class="block text-xs font-bold uppercase text-[#004125]">
                        Terkait Badan Otonom (Opsional)
                    </label>
                    <select name="banom_id" id="banom_id" class="w-full py-2.5 px-3 text-xs rounded-xl border border-gray-200 focus:border-[#0c5a37]">
                        <option value="">-- Warta Umum PRNU Banjaranyar --</option>
                        @foreach($banoms as $b)
                            <option value="{{ $b->id }}" {{ old('banom_id', $post->banom_id) == $b->id ? 'selected' : '' }}>
                                {{ $b->singkatan }} - {{ $b->nama }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="space-y-1 sm:col-span-2">
                    <label for="excerpt" class="block text-xs font-bold uppercase text-[#004125]">
                        Kutipan Singkat (Lead / Ringkasan)
                    </label>
                    <textarea name="excerpt" id="excerpt" rows="2"
                        class="w-full py-2 px-3 text-xs rounded-xl border border-gray-200 focus:border-[#0c5a37]">{{ old('excerpt', $post->excerpt) }}</textarea>
                </div>

                <div class="space-y-1 sm:col-span-2">
                    <label for="content" class="block text-xs font-bold uppercase text-[#004125]">
                        Isi Warta / Artikel Lengkap <span class="text-red-500">*</span>
                    </label>
                    <textarea name="content" id="content" rows="10" required
                        class="w-full py-2.5 px-3 text-xs rounded-xl border border-gray-200 focus:border-[#0c5a37] leading-relaxed">{{ old('content', $post->content) }}</textarea>
                </div>

                <div class="space-y-1">
                    <label for="author" class="block text-xs font-bold uppercase text-[#004125]">
                        Penulis / Tim Redaksi <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="author" id="author" value="{{ old('author', $post->author) }}" required
                        class="w-full py-2.5 px-3 text-xs rounded-xl border border-gray-200 focus:border-[#0c5a37]">
                </div>

                <div class="space-y-1">
                    <label for="status" class="block text-xs font-bold uppercase text-[#004125]">
                        Status Publikasi <span class="text-red-500">*</span>
                    </label>
                    <select name="status" id="status" required class="w-full py-2.5 px-3 text-xs rounded-xl border border-gray-200 focus:border-[#0c5a37]">
                        <option value="published" {{ old('status', $post->status) === 'published' ? 'selected' : '' }}>Tayang (Published)</option>
                        <option value="draft" {{ old('status', $post->status) === 'draft' ? 'selected' : '' }}>Draf (Draft)</option>
                    </select>
                </div>

                <div class="space-y-2 sm:col-span-2">
                    <label class="block text-xs font-bold uppercase text-[#004125]">Foto Thumbnail Warta</label>
                    <div class="flex items-center gap-4">
                        <div class="w-20 h-14 rounded-xl bg-gray-100 border border-gray-200 overflow-hidden flex items-center justify-center shrink-0">
                            @if($post->thumbnail)
                                <img src="{{ asset('storage/' . $post->thumbnail) }}" alt="{{ $post->title }}" class="w-full h-full object-cover">
                            @else
                                <span class="material-symbols-outlined text-gray-400 text-xl">image</span>
                            @endif
                        </div>
                        <div class="flex-1">
                            <input type="file" name="thumbnail" id="thumbnail" accept="image/*"
                                class="w-full text-xs text-gray-500 file:mr-3 file:py-2 file:px-3 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-emerald-50 file:text-[#004125] hover:file:bg-emerald-100">
                            <p class="text-[10px] text-gray-400 mt-1">Kosongkan jika tidak ingin mengubah thumbnail.</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="pt-4 border-t border-gray-100 flex flex-col sm:flex-row items-stretch sm:items-center justify-end gap-3">
                <a href="{{ route('admin.berita.index') }}" class="px-5 py-2.5 rounded-xl border border-gray-300 hover:bg-gray-100 text-gray-700 text-xs font-bold transition text-center min-h-[44px] flex items-center justify-center">
                    Batal
                </a>
                <button type="submit" class="px-6 py-2.5 rounded-xl bg-[#004125] hover:bg-[#0c5a37] text-white text-xs font-extrabold transition flex items-center justify-center gap-1.5 shadow-md min-h-[44px]">
                    <span class="material-symbols-outlined text-[16px]">save</span>
                    <span>Simpan Perubahan</span>
                </button>
            </div>
        </form>
    </div>

</div>
@endsection
