@extends('layouts.admin')

@section('title', 'Edit Pengurus: ' . $struktur->nama . ' — SIMNU Admin')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">

    <div class="flex items-center justify-between">
        <div>
            <nav class="flex items-center gap-2 text-xs text-gray-500 mb-1">
                <a href="{{ route('admin.dashboard') }}" class="hover:text-emerald-800">Admin</a>
                <span>/</span>
                <a href="{{ route('admin.struktur.index') }}" class="hover:text-emerald-800">Struktur</a>
                <span>/</span>
                <span class="text-gray-900 font-bold">{{ $struktur->nama }}</span>
            </nav>
            <h1 class="text-2xl font-black text-[#004125]">Edit Jajaran Pengurus</h1>
            <p class="text-xs text-[#526350]">Perbarui data amanah, hierarki bagan, atau pas foto pengurus.</p>
        </div>

        <a href="{{ route('admin.struktur.index') }}" class="px-3.5 py-2 rounded-xl border border-gray-300 hover:bg-gray-100 text-gray-700 text-xs font-bold transition flex items-center gap-1.5">
            <span class="material-symbols-outlined text-[16px]">arrow_back</span>
            <span>Kembali</span>
        </a>
    </div>

    <div class="bg-white rounded-3xl p-6 sm:p-8 border border-[#e6eeff] shadow-sm">
        <form action="{{ route('admin.struktur.update', $struktur->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div class="space-y-1 sm:col-span-2">
                    <label for="nama" class="block text-xs font-bold uppercase text-[#004125]">
                        Nama Lengkap Beserta Gelar <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="nama" id="nama" value="{{ old('nama', $struktur->nama) }}" required
                        class="w-full py-2.5 px-3 text-xs rounded-xl border border-gray-200 focus:border-[#0c5a37] font-semibold text-gray-900">
                </div>

                <div class="space-y-1">
                    <label for="jabatan" class="block text-xs font-bold uppercase text-[#004125]">
                        Jabatan / Amanah Khidmat <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="jabatan" id="jabatan" value="{{ old('jabatan', $struktur->jabatan) }}" required
                        class="w-full py-2.5 px-3 text-xs rounded-xl border border-gray-200 focus:border-[#0c5a37] text-gray-800">
                </div>

                <div class="space-y-1">
                    <label for="kategori_hierarki" class="block text-xs font-bold uppercase text-[#004125]">
                        Tingkat / Hierarki <span class="text-red-500">*</span>
                    </label>
                    <select name="kategori_hierarki" id="kategori_hierarki" required class="w-full py-2.5 px-3 text-xs rounded-xl border border-gray-200 focus:border-[#0c5a37]">
                        <option value="mustasyar" {{ old('kategori_hierarki', $struktur->kategori_hierarki) == 'mustasyar' ? 'selected' : '' }}>Mustasyar (Dewan Penasihat)</option>
                        <option value="syuriyah" {{ old('kategori_hierarki', $struktur->kategori_hierarki) == 'syuriyah' ? 'selected' : '' }}>Syuriyah (Pimpinan Tertinggi)</option>
                        <option value="tanfidziyah" {{ old('kategori_hierarki', $struktur->kategori_hierarki) == 'tanfidziyah' ? 'selected' : '' }}>Tanfidziyah (Pelaksana Harian)</option>
                        <option value="lembaga" {{ old('kategori_hierarki', $struktur->kategori_hierarki) == 'lembaga' ? 'selected' : '' }}>Lembaga / Lajnah</option>
                        <option value="banom" {{ old('kategori_hierarki', $struktur->kategori_hierarki) == 'banom' ? 'selected' : '' }}>Pimpinan Badan Otonom</option>
                    </select>
                </div>

                <div class="space-y-1">
                    <label for="banom_id" class="block text-xs font-bold uppercase text-[#004125]">
                        Badan Otonom (Opsional)
                    </label>
                    <select name="banom_id" id="banom_id" class="w-full py-2.5 px-3 text-xs rounded-xl border border-gray-200 focus:border-[#0c5a37]">
                        <option value="">-- Pengurus Pusat Ranting NU (PRNU) --</option>
                        @foreach($banoms as $b)
                            <option value="{{ $b->id }}" {{ old('banom_id', $struktur->banom_id) == $b->id ? 'selected' : '' }}>
                                {{ $b->singkatan }} - {{ $b->nama }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="space-y-1">
                    <label for="urutan" class="block text-xs font-bold uppercase text-[#004125]">
                        Nomor Urut Tampilan
                    </label>
                    <input type="number" name="urutan" id="urutan" value="{{ old('urutan', $struktur->urutan) }}"
                        class="w-full py-2.5 px-3 text-xs rounded-xl border border-gray-200 focus:border-[#0c5a37]">
                </div>

                <div class="space-y-1 sm:col-span-2">
                    <label for="deskripsi" class="block text-xs font-bold uppercase text-[#004125]">
                        Keterangan Tambahan / Profil Singkat
                    </label>
                    <textarea name="deskripsi" id="deskripsi" rows="2"
                        class="w-full py-2 px-3 text-xs rounded-xl border border-gray-200 focus:border-[#0c5a37]">{{ old('deskripsi', $struktur->deskripsi) }}</textarea>
                </div>

                <div class="space-y-1">
                    <label for="status" class="block text-xs font-bold uppercase text-[#004125]">
                        Status Khidmat <span class="text-red-500">*</span>
                    </label>
                    <select name="status" id="status" required class="w-full py-2.5 px-3 text-xs rounded-xl border border-gray-200 focus:border-[#0c5a37]">
                        <option value="Aktif" {{ old('status', $struktur->status) == 'Aktif' ? 'selected' : '' }}>Aktif</option>
                        <option value="Tidak Aktif" {{ old('status', $struktur->status) == 'Tidak Aktif' ? 'selected' : '' }}>Tidak Aktif</option>
                    </select>
                </div>

                <div class="space-y-2">
                    <label class="block text-xs font-bold uppercase text-[#004125]">Foto Pengurus</label>
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 rounded-xl bg-gray-100 border border-gray-200 overflow-hidden flex items-center justify-center shrink-0">
                            @if($struktur->foto)
                                <img src="{{ asset('storage/' . $struktur->foto) }}" alt="{{ $struktur->nama }}" class="w-full h-full object-cover">
                            @else
                                <span class="material-symbols-outlined text-gray-400 text-lg">person</span>
                            @endif
                        </div>
                        <div class="flex-1">
                            <input type="file" name="foto" id="foto" accept="image/*"
                                class="w-full text-xs text-gray-500 file:mr-3 file:py-2 file:px-3 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-emerald-50 file:text-[#004125] hover:file:bg-emerald-100">
                        </div>
                    </div>
                </div>
            </div>

            <div class="pt-4 border-t border-gray-100 flex items-center justify-end gap-3">
                <a href="{{ route('admin.struktur.index') }}" class="px-5 py-2.5 rounded-xl border border-gray-300 hover:bg-gray-100 text-gray-700 text-xs font-bold transition">
                    Batal
                </a>
                <button type="submit" class="px-6 py-2.5 rounded-xl bg-[#004125] hover:bg-[#0c5a37] text-white text-xs font-extrabold transition flex items-center gap-1.5 shadow-md">
                    <span class="material-symbols-outlined text-[16px]">save</span>
                    <span>Simpan Perubahan</span>
                </button>
            </div>
        </form>
    </div>

</div>
@endsection
