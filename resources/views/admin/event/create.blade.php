@extends('layouts.admin')

@section('title', 'Tambah Agenda Baru — SIMNU Admin')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">

    <div class="flex items-center justify-between">
        <div>
            <nav class="flex items-center gap-2 text-xs text-gray-500 mb-1">
                <a href="{{ route('admin.dashboard') }}" class="hover:text-emerald-800">Admin</a>
                <span>/</span>
                <a href="{{ route('admin.agenda.index') }}" class="hover:text-emerald-800">Agenda</a>
                <span>/</span>
                <span class="text-gray-900 font-bold">Tambah Baru</span>
            </nav>
            <h1 class="text-2xl font-black text-[#004125]">Jadwalkan Agenda Baru</h1>
            <p class="text-xs text-[#526350]">Tambahkan jadwal pengajian, apel banser, rapat kerja, atau peringatan hari besar Islam.</p>
        </div>

        <a href="{{ route('admin.agenda.index') }}" class="px-3.5 py-2 rounded-xl border border-gray-300 hover:bg-gray-100 text-gray-700 text-xs font-bold transition flex items-center gap-1.5">
            <span class="material-symbols-outlined text-[16px]">arrow_back</span>
            <span>Kembali</span>
        </a>
    </div>

    <div class="bg-white rounded-3xl p-6 sm:p-8 border border-[#e6eeff] shadow-sm">
        <form action="{{ route('admin.agenda.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div class="space-y-1 sm:col-span-2">
                    <label for="title" class="block text-xs font-bold uppercase text-[#004125]">
                        Nama / Judul Kegiatan <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="title" id="title" value="{{ old('title') }}" required placeholder="Contoh: Majelis Dzikir & Shalawat Rijalul Ansor Ranting Banjaranyar"
                        class="w-full py-2.5 px-3 text-xs rounded-xl border border-gray-200 focus:border-[#0c5a37] font-bold text-gray-900 text-sm">
                    @error('title') <p class="text-[11px] text-red-600">{{ $message }}</p> @enderror
                </div>

                <div class="space-y-1">
                    <label for="tanggal" class="block text-xs font-bold uppercase text-[#004125]">
                        Tanggal Pelaksanaan <span class="text-red-500">*</span>
                    </label>
                    <input type="date" name="tanggal" id="tanggal" value="{{ old('tanggal', now()->addDays(3)->format('Y-m-d')) }}" required
                        class="w-full py-2.5 px-3 text-xs rounded-xl border border-gray-200 focus:border-[#0c5a37]">
                    @error('tanggal') <p class="text-[11px] text-red-600">{{ $message }}</p> @enderror
                </div>

                <div class="space-y-1">
                    <label for="banom_id" class="block text-xs font-bold uppercase text-[#004125]">
                        Penyelenggara / Terkait BANOM
                    </label>
                    <select name="banom_id" id="banom_id" class="w-full py-2.5 px-3 text-xs rounded-xl border border-gray-200 focus:border-[#0c5a37]">
                        <option value="">-- Pengurus Pusat Ranting NU (PRNU) --</option>
                        @foreach($banoms as $b)
                            <option value="{{ $b->id }}" {{ old('banom_id') == $b->id ? 'selected' : '' }}>
                                BANOM {{ $b->singkatan }} - {{ $b->nama }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="space-y-1">
                    <label for="waktu_mulai" class="block text-xs font-bold uppercase text-[#004125]">
                        Waktu Mulai
                    </label>
                    <input type="time" name="waktu_mulai" id="waktu_mulai" value="{{ old('waktu_mulai', '19:30') }}"
                        class="w-full py-2.5 px-3 text-xs rounded-xl border border-gray-200 focus:border-[#0c5a37]">
                </div>

                <div class="space-y-1">
                    <label for="waktu_selesai" class="block text-xs font-bold uppercase text-[#004125]">
                        Waktu Selesai (Opsional)
                    </label>
                    <input type="time" name="waktu_selesai" id="waktu_selesai" value="{{ old('waktu_selesai', '22:00') }}"
                        class="w-full py-2.5 px-3 text-xs rounded-xl border border-gray-200 focus:border-[#0c5a37]">
                </div>

                <div class="space-y-1 sm:col-span-2">
                    <label for="lokasi" class="block text-xs font-bold uppercase text-[#004125]">
                        Lokasi / Tempat Pelaksanaan <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="lokasi" id="lokasi" value="{{ old('lokasi') }}" required placeholder="Contoh: Gedung TPQ Ranting Banjaranyar / Masjid Jami'"
                        class="w-full py-2.5 px-3 text-xs rounded-xl border border-gray-200 focus:border-[#0c5a37]">
                    @error('lokasi') <p class="text-[11px] text-red-600">{{ $message }}</p> @enderror
                </div>

                <div class="space-y-1 sm:col-span-2">
                    <label for="description" class="block text-xs font-bold uppercase text-[#004125]">
                        Deskripsi / Rincian Acara & Susunan Kegiatan
                    </label>
                    <textarea name="description" id="description" rows="5" placeholder="Tuliskan keterangan lengkap kegiatan, pembicara, ketentuan dresscode, dll..."
                        class="w-full py-2.5 px-3 text-xs rounded-xl border border-gray-200 focus:border-[#0c5a37] leading-relaxed">{{ old('description') }}</textarea>
                </div>

                <div class="space-y-1">
                    <label for="status" class="block text-xs font-bold uppercase text-[#004125]">
                        Status Kegiatan <span class="text-red-500">*</span>
                    </label>
                    <select name="status" id="status" required class="w-full py-2.5 px-3 text-xs rounded-xl border border-gray-200 focus:border-[#0c5a37]">
                        <option value="Akan Datang" {{ old('status', 'Akan Datang') === 'Akan Datang' ? 'selected' : '' }}>Akan Datang (Mendatang)</option>
                        <option value="Selesai" {{ old('status') === 'Selesai' ? 'selected' : '' }}>Telah Terlaksana (Selesai)</option>
                        <option value="Dibatalkan" {{ old('status') === 'Dibatalkan' ? 'selected' : '' }}>Dibatalkan / Ditunda</option>
                    </select>
                </div>

                <div class="space-y-1">
                    <label for="thumbnail" class="block text-xs font-bold uppercase text-[#004125]">
                        Poster / Pamflet Kegiatan
                    </label>
                    <input type="file" name="thumbnail" id="thumbnail" accept="image/*"
                        class="w-full text-xs text-gray-500 file:mr-3 file:py-2 file:px-3 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-emerald-50 file:text-[#004125] hover:file:bg-emerald-100">
                </div>
            </div>

            <div class="pt-4 border-t border-gray-100 flex items-center justify-end gap-3">
                <a href="{{ route('admin.agenda.index') }}" class="px-5 py-2.5 rounded-xl border border-gray-300 hover:bg-gray-100 text-gray-700 text-xs font-bold transition">
                    Batal
                </a>
                <button type="submit" class="px-6 py-2.5 rounded-xl bg-[#004125] hover:bg-[#0c5a37] text-white text-xs font-extrabold transition flex items-center gap-1.5 shadow-md">
                    <span class="material-symbols-outlined text-[16px]">save</span>
                    <span>Jadwalkan Agenda</span>
                </button>
            </div>
        </form>
    </div>

</div>
@endsection
