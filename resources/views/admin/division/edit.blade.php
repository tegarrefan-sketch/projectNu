@extends('layouts.admin')

@section('title', 'Edit Bagian — ' . $division->nama . ' — SIMNU Admin')

@section('content')
<div class="max-w-2xl mx-auto space-y-6">

    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 bg-white p-6 rounded-2xl border border-[#e6eeff] shadow-sm">
        <div>
            <nav class="flex items-center gap-2 text-xs text-[#707971] mb-1">
                <a href="{{ route('admin.divisions.index', ['banom_id' => $division->banom_id]) }}" class="hover:underline">Bagian Organisasi</a>
                <span>/</span>
                <span class="text-[#004125] font-semibold">Edit</span>
            </nav>
            <h1 class="text-2xl font-black text-[#004125] tracking-tight">Edit Bagian: {{ $division->nama }}</h1>
            <p class="text-xs text-[#526350] mt-0.5">Perbarui nama atau urutan {{ strtolower($division->banom->label_bagian ?? 'bagian') }} untuk {{ $division->banom->singkatan }}.</p>
        </div>

        <a href="{{ route('admin.divisions.index', ['banom_id' => $division->banom_id]) }}" class="w-full sm:w-auto min-h-[44px] px-4 py-2 rounded-xl bg-gray-100 hover:bg-gray-200 text-gray-700 text-xs font-bold transition flex items-center justify-center gap-1.5">
            <span class="material-symbols-outlined text-[16px]">arrow_back</span>
            <span>Kembali</span>
        </a>
    </div>

    @if($activeOfficersCount > 0)
        <div class="p-4 bg-emerald-50 rounded-2xl border border-emerald-200 flex items-center gap-3">
            <span class="material-symbols-outlined text-emerald-700 text-[22px]">info</span>
            <div class="text-xs text-emerald-900">
                Bagian ini saat ini terhubung dengan <strong>{{ $activeOfficersCount }} pengurus</strong> aktif di {{ $division->banom->singkatan }}.
            </div>
        </div>
    @endif

    <!-- Form Card -->
    <div class="bg-white p-6 sm:p-8 rounded-2xl border border-[#e6eeff] shadow-sm">
        <form action="{{ route('admin.divisions.update', $division->id) }}" method="POST" class="space-y-5">
            @csrf
            @method('PUT')

            <!-- Pilih Organisasi / Banom -->
            <div>
                <label for="banom_id" class="block text-xs font-bold text-[#121c2a] mb-1.5">
                    Organisasi / Badan Otonom <span class="text-red-500">*</span>
                </label>
                <select id="banom_id" name="banom_id" required class="w-full px-4 py-3 rounded-xl text-xs sm:text-sm bg-[#f8f9ff] border @error('banom_id') border-red-500 @else border-[#dee9fc] @enderror focus:bg-white focus:outline-none focus:border-[#004125]">
                    @foreach($banoms as $b)
                        <option value="{{ $b->id }}" {{ (old('banom_id', $division->banom_id) == $b->id) ? 'selected' : '' }}>
                            {{ $b->singkatan }} — {{ $b->nama }}
                        </option>
                    @endforeach
                </select>
                @error('banom_id')
                    <p class="text-[11px] text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Nama Bagian -->
            <div>
                <label for="nama" class="block text-xs font-bold text-[#121c2a] mb-1.5">
                    Nama Bagian / Bidang / Departemen / Seksi <span class="text-red-500">*</span>
                </label>
                <input type="text" id="nama" name="nama" value="{{ old('nama', $division->nama) }}" required class="w-full px-4 py-3 rounded-xl text-xs sm:text-sm bg-[#f8f9ff] border @error('nama') border-red-500 @else border-[#dee9fc] @enderror focus:bg-white focus:outline-none focus:border-[#004125]">
                @error('nama')
                    <p class="text-[11px] text-red-500 mt-1">{{ $message }}</p>
                @enderror
                <p class="text-[11px] text-[#707971] mt-1 italic">
                    *Nama bidang dapat disesuaikan dengan SK pengurus ranting.
                </p>
            </div>

            <!-- Urutan -->
            <div>
                <label for="urutan" class="block text-xs font-bold text-[#121c2a] mb-1.5">
                    Urutan Tampilan
                </label>
                <input type="number" id="urutan" name="urutan" value="{{ old('urutan', $division->urutan) }}" min="0" required class="w-full px-4 py-3 rounded-xl text-xs sm:text-sm bg-[#f8f9ff] border @error('urutan') border-red-500 @else border-[#dee9fc] @enderror focus:bg-white focus:outline-none focus:border-[#004125]">
                @error('urutan')
                    <p class="text-[11px] text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Deskripsi / Catatan Tambahan -->
            <div>
                <label for="deskripsi" class="block text-xs font-bold text-[#121c2a] mb-1.5">
                    Deskripsi / Catatan Bagian (Opsional)
                </label>
                <textarea id="deskripsi" name="deskripsi" rows="3" class="w-full px-4 py-3 rounded-xl text-xs sm:text-sm bg-[#f8f9ff] border border-[#dee9fc] focus:bg-white focus:outline-none focus:border-[#004125]">{{ old('deskripsi', $division->deskripsi) }}</textarea>
                @error('deskripsi')
                    <p class="text-[11px] text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Submit Button -->
            <div class="pt-4 border-t border-[#f2f4f8] flex flex-col-reverse sm:flex-row items-stretch sm:items-center justify-end gap-3">
                <a href="{{ route('admin.divisions.index', ['banom_id' => $division->banom_id]) }}" class="min-h-[44px] px-5 py-2.5 rounded-xl border border-gray-300 text-gray-700 text-xs font-bold hover:bg-gray-50 transition flex items-center justify-center">
                    Batal
                </a>
                <button type="submit" class="min-h-[44px] px-6 py-2.5 rounded-xl bg-[#0c5a37] hover:bg-[#004125] text-white text-xs font-black shadow-md transition flex items-center justify-center gap-2">
                    <span class="material-symbols-outlined text-[18px]">save</span>
                    <span>Perbarui Bagian</span>
                </button>
            </div>
        </form>
    </div>

</div>
@endsection
