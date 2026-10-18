@extends('layouts.admin')

@section('title', 'Manajemen Galeri Kegiatan — SIMNU Admin')

@section('content')
<div class="space-y-6">

    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <div class="flex items-center gap-2">
                <span class="px-2.5 py-0.5 rounded-full text-xs font-bold uppercase tracking-wider bg-emerald-100 text-[#004125]">
                    Dokumentasi & Publikasi
                </span>
            </div>
            <h1 class="text-2xl font-black text-[#004125] mt-1">Galeri Kegiatan & Arsip Foto</h1>
            <p class="text-xs text-[#526350]">Kelola album dokumentasi kegiatan ranting, pengajian, aksi sosial, dan apel BANOM.</p>
        </div>

        <a href="{{ route('admin.galeri.create') }}" class="w-full sm:w-auto min-h-[44px] px-4 py-2.5 rounded-xl bg-[#004125] hover:bg-[#0c5a37] text-white text-xs font-bold transition flex items-center justify-center gap-1.5 shadow-sm">
            <span class="material-symbols-outlined text-[18px]">add_photo_alternate</span>
            <span>Tambah Album Baru</span>
        </a>
    </div>

    <!-- Search / Filter -->
    <div class="bg-white rounded-2xl p-4 sm:p-5 border border-[#e6eeff] shadow-sm">
        <form action="{{ route('admin.galeri.index') }}" method="GET" class="flex flex-col sm:flex-row gap-3">
            <div class="relative flex-1">
                <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-lg">search</span>
                <input type="text" name="q" value="{{ $search }}" placeholder="Cari judul album atau lokasi..." 
                    class="w-full pl-9 pr-3 py-2.5 text-xs sm:text-sm rounded-xl border border-gray-200 focus:border-[#0c5a37] text-gray-800">
            </div>
            <button type="submit" class="min-h-[44px] px-5 py-2.5 rounded-xl bg-[#0c5a37] text-white text-xs font-bold hover:bg-[#004125] transition flex items-center justify-center">
                Cari Album
            </button>
            @if($search)
                <a href="{{ route('admin.galeri.index') }}" class="min-h-[44px] px-4 py-2.5 rounded-xl border border-gray-300 text-gray-700 text-xs font-bold hover:bg-gray-100 transition flex items-center justify-center">
                    Reset
                </a>
            @endif
        </form>
    </div>

    <!-- Album Table -->
    <div class="bg-white rounded-2xl border border-[#e6eeff] shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead class="bg-[#f8f9ff] text-gray-600 font-bold border-b border-[#e6eeff] uppercase tracking-wider text-[11px]">
                    <tr>
                        <th class="py-3.5 px-4">Album & Cover</th>
                        <th class="py-3.5 px-4">Tanggal</th>
                        <th class="py-3.5 px-4">Kategori / Lokasi</th>
                        <th class="py-3.5 px-4 text-center">Jumlah Foto</th>
                        <th class="py-3.5 px-4 text-center">Status</th>
                        <th class="py-3.5 px-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#e6eeff] text-gray-800">
                    @forelse ($galleries as $g)
                        <tr class="hover:bg-[#f8f9ff] transition-colors">
                            <td class="py-3.5 px-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-14 h-14 rounded-xl bg-slate-100 overflow-hidden shrink-0 border border-gray-200">
                                        @if($g->cover)
                                            <img src="{{ asset('storage/' . $g->cover) }}" alt="{{ $g->judul }}" class="w-full h-full object-cover">
                                        @else
                                            <div class="w-full h-full flex items-center justify-center text-gray-400">
                                                <span class="material-symbols-outlined text-xl">image</span>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="min-w-0">
                                        <a href="{{ route('admin.galeri.edit', $g->id) }}" class="font-bold text-sm text-[#004125] hover:underline block truncate">
                                            {{ $g->judul }}
                                        </a>
                                        <span class="text-[11px] text-gray-400 font-mono">/galeri/{{ $g->slug }}</span>
                                    </div>
                                </div>
                            </td>
                            <td class="py-3.5 px-4 whitespace-nowrap font-medium text-gray-600">
                                {{ $g->tanggal->translatedFormat('d M Y') }}
                            </td>
                            <td class="py-3.5 px-4">
                                <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-[#eff4ff] text-[#004125] inline-block mb-0.5">
                                    {{ $g->kategori }}
                                </span>
                                <div class="text-[11px] text-gray-500 truncate">{{ $g->lokasi ?? '-' }}</div>
                            </td>
                            <td class="py-3.5 px-4 text-center font-bold text-sm text-emerald-800">
                                {{ $g->photos_count }} Foto
                            </td>
                            <td class="py-3.5 px-4 text-center">
                                @if($g->status === 'Publik')
                                    <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-emerald-100 text-emerald-800">Publik</span>
                                @else
                                    <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-amber-100 text-amber-800">Draf</span>
                                @endif
                            </td>
                            <td class="py-3.5 px-4 text-right whitespace-nowrap">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('galeri.show', $g->slug) }}" target="_blank" class="p-1.5 rounded-lg bg-gray-100 hover:bg-gray-200 text-gray-700 transition" title="Lihat Tampilan Publik">
                                        <span class="material-symbols-outlined text-[16px]">visibility</span>
                                    </a>
                                    <a href="{{ route('admin.galeri.edit', $g->id) }}" class="p-1.5 rounded-lg bg-emerald-50 hover:bg-emerald-100 text-[#004125] transition font-bold" title="Edit Album / Foto">
                                        <span class="material-symbols-outlined text-[16px]">edit</span>
                                    </a>
                                    <form action="{{ route('admin.galeri.destroy', $g->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus album ini beserta seluruh fotonya?');" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-1.5 rounded-lg bg-red-50 hover:bg-red-100 text-red-600 transition" title="Hapus Album">
                                            <span class="material-symbols-outlined text-[16px]">delete</span>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-12 text-center text-gray-400">
                                Belum ada album kegiatan. Klik "Tambah Album Baru" untuk mengunggah dokumentasi.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="p-4 border-t border-[#e6eeff]">
            {{ $galleries->links() }}
        </div>
    </div>

</div>
@endsection
