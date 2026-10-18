@extends('layouts.admin')

@section('title', 'Edit Jabatan — ' . $position->nama . ' — SIMNU Banjaranyar')

@section('content')
<div class="max-w-2xl mx-auto space-y-6">

    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 bg-white p-6 rounded-2xl border border-[#e6eeff] shadow-sm">
        <div>
            <nav class="flex items-center gap-2 text-xs text-[#707971] mb-1">
                <a href="{{ route('admin.positions.index') }}" class="hover:underline">Kelola Jabatan</a>
                <span>/</span>
                <span class="text-[#004125] font-semibold">Edit</span>
            </nav>
            <h1 class="text-2xl font-black text-[#004125] tracking-tight">Edit Jabatan: {{ $position->nama }}</h1>
            <p class="text-xs text-[#526350] mt-0.5">Perbarui pengaturan kuota, tipe hierarki, dan urutan tampilan.</p>
        </div>

        <a href="{{ route('admin.positions.index') }}" class="w-full sm:w-auto min-h-[44px] px-4 py-2 rounded-xl bg-gray-100 hover:bg-gray-200 text-gray-700 text-xs font-bold transition flex items-center justify-center gap-1.5">
            <span class="material-symbols-outlined text-[16px]">arrow_back</span>
            <span>Kembali</span>
        </a>
    </div>

    @if($activeOfficersCount > 0)
        <div class="p-4 bg-emerald-50 rounded-2xl border border-emerald-200 flex items-center gap-3">
            <span class="material-symbols-outlined text-emerald-700 text-[22px]">info</span>
            <div class="text-xs text-emerald-900">
                Jabatan ini saat ini aktif digunakan oleh <strong>{{ $activeOfficersCount }} pengurus</strong> di {{ $banomCount }} organisasi/badan otonom.
            </div>
        </div>
    @endif

    <!-- Form Card -->
    <div class="bg-white p-6 sm:p-8 rounded-2xl border border-[#e6eeff] shadow-sm">
        <form action="{{ route('admin.positions.update', $position->id) }}" method="POST" class="space-y-5">
            @csrf
            @method('PUT')

            <!-- Nama Jabatan -->
            <div>
                <label for="nama" class="block text-xs font-bold text-[#121c2a] mb-1.5">
                    Nama Jabatan <span class="text-red-500">*</span>
                </label>
                <input type="text" id="nama" name="nama" value="{{ old('nama', $position->nama) }}" required class="w-full px-4 py-3 rounded-xl text-xs sm:text-sm bg-[#f8f9ff] border @error('nama') border-red-500 @else border-[#dee9fc] @enderror focus:bg-white focus:outline-none focus:border-[#004125]">
                @error('nama')
                    <p class="text-[11px] text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Grid Kategori & Tipe -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label for="kategori" class="block text-xs font-bold text-[#121c2a] mb-1.5">
                        Kategori Hierarki <span class="text-red-500">*</span>
                    </label>
                    <select id="kategori" name="kategori" required class="w-full px-4 py-3 rounded-xl text-xs sm:text-sm bg-[#f8f9ff] border @error('kategori') border-red-500 @else border-[#dee9fc] @enderror focus:bg-white focus:outline-none focus:border-[#004125]">
                        @foreach($categories as $cat)
                            <option value="{{ $cat }}" {{ old('kategori', $position->kategori) === $cat ? 'selected' : '' }}>{{ $cat }}</option>
                        @endforeach
                    </select>
                    @error('kategori')
                        <p class="text-[11px] text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="tipe" class="block text-xs font-bold text-[#121c2a] mb-1.5">
                        Tipe Jabatan <span class="text-red-500">*</span>
                    </label>
                    <select id="tipe" name="tipe" required class="w-full px-4 py-3 rounded-xl text-xs sm:text-sm bg-[#f8f9ff] border @error('tipe') border-red-500 @else border-[#dee9fc] @enderror focus:bg-white focus:outline-none focus:border-[#004125]">
                        @foreach($types as $tKey => $tLabel)
                            <option value="{{ $tKey }}" {{ old('tipe', $position->tipe ?? 'anggota') === $tKey ? 'selected' : '' }}>{{ $tLabel }}</option>
                        @endforeach
                    </select>
                    @error('tipe')
                        <p class="text-[11px] text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Batas Keras Toggle Box -->
            <div class="p-4 rounded-xl bg-[#f8f9ff] border border-[#dee9fc] space-y-3">
                <label class="flex items-center gap-3 cursor-pointer">
                    <input type="checkbox" id="batas_keras" name="batas_keras" value="1" {{ old('batas_keras', $position->batas_keras) ? 'checked' : '' }} class="w-5 h-5 rounded text-[#0c5a37] focus:ring-[#004125] border-gray-300">
                    <div>
                        <span class="text-xs font-bold text-[#121c2a] block">Terapkan Batas Keras (Hard Limit)</span>
                        <span class="text-[11px] text-[#707971]">Centang jika jabatan ini strictly dibatasi (sistem menolak jika kuota penuh, mis. Rais, Ketua, Kasatkorkel, Bendahara).</span>
                    </div>
                </label>
            </div>

            <!-- Grid Maksimal Orang & Anjuran Maks -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label for="maks_orang" class="block text-xs font-bold text-[#121c2a] mb-1.5">
                        Maksimal Orang (Batas Keras)
                    </label>
                    <input type="number" id="maks_orang" name="maks_orang" value="{{ old('maks_orang', $position->maks_orang) }}" min="1" placeholder="Kosongkan jika Tanpa Batas" class="w-full px-4 py-3 rounded-xl text-xs sm:text-sm bg-[#f8f9ff] border @error('maks_orang') border-red-500 @else border-[#dee9fc] @enderror focus:bg-white focus:outline-none focus:border-[#004125]">
                    @error('maks_orang')
                        <p class="text-[11px] text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                    <p class="text-[11px] text-[#707971] mt-1">Kosongkan jika Tanpa Batas (maks_orang = NULL).</p>
                </div>

                <div>
                    <label for="anjuran_maks" class="block text-xs font-bold text-[#121c2a] mb-1.5">
                        Anjuran Maksimal (Batas Lunak)
                    </label>
                    <input type="number" id="anjuran_maks" name="anjuran_maks" value="{{ old('anjuran_maks', $position->anjuran_maks) }}" min="1" placeholder="Mis. 2 orang untuk Wakil" class="w-full px-4 py-3 rounded-xl text-xs sm:text-sm bg-[#f8f9ff] border @error('anjuran_maks') border-red-500 @else border-[#dee9fc] @enderror focus:bg-white focus:outline-none focus:border-[#004125]">
                    @error('anjuran_maks')
                        <p class="text-[11px] text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                    <p class="text-[11px] text-[#707971] mt-1">Hanya memunculkan notifikasi kuning; data tetap tersimpan.</p>
                </div>
            </div>

            <!-- Urutan Hierarki -->
            <div>
                <label for="urutan" class="block text-xs font-bold text-[#121c2a] mb-1.5">
                    Urutan Tampilan
                </label>
                <input type="number" id="urutan" name="urutan" value="{{ old('urutan', $position->urutan) }}" min="0" required class="w-full px-4 py-3 rounded-xl text-xs sm:text-sm bg-[#f8f9ff] border @error('urutan') border-red-500 @else border-[#dee9fc] @enderror focus:bg-white focus:outline-none focus:border-[#004125]">
                @error('urutan')
                    <p class="text-[11px] text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Submit Button -->
            <div class="pt-4 border-t border-[#f2f4f8] flex flex-col-reverse sm:flex-row items-stretch sm:items-center justify-end gap-3">
                <a href="{{ route('admin.positions.index') }}" class="min-h-[44px] px-5 py-2.5 rounded-xl border border-gray-300 text-gray-700 text-xs font-bold hover:bg-gray-50 transition flex items-center justify-center">
                    Batal
                </a>
                <button type="submit" class="min-h-[44px] px-6 py-2.5 rounded-xl bg-[#0c5a37] hover:bg-[#004125] text-white text-xs font-black shadow-md transition flex items-center justify-center gap-2">
                    <span class="material-symbols-outlined text-[18px]">save</span>
                    <span>Perbarui Jabatan</span>
                </button>
            </div>
        </form>
    </div>

</div>
@endsection
