@extends('layouts.admin')

@section('title', 'Manajemen Warta & Berita — SIMNU Admin')

@section('content')
<div class="space-y-6">

    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <div class="flex items-center gap-2">
                <span class="px-2.5 py-0.5 rounded-full text-xs font-bold uppercase tracking-wider bg-emerald-100 text-[#004125]">
                    Publikasi & Literasi
                </span>
            </div>
            <h1 class="text-2xl font-black text-[#004125] mt-1">Warta & Artikel Nahdlatul Ulama</h1>
            <p class="text-xs text-[#526350]">Kelola warta kegiatan ke-NU-an, rilis pers BANOM, opini keagamaan, serta pengumuman resmi ranting.</p>
        </div>

        <a href="{{ route('admin.berita.create') }}" class="px-4 py-2.5 rounded-xl bg-[#004125] hover:bg-[#0c5a37] text-white text-xs font-bold transition flex items-center gap-1.5 shadow-sm">
            <span class="material-symbols-outlined text-[16px]">add_circle</span>
            <span>Tulis Warta Baru</span>
        </a>
    </div>

    <!-- 4 Stats Cards -->
    <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
        <div class="bg-white rounded-2xl p-4 border border-[#e6eeff] shadow-sm">
            <span class="text-[10px] font-bold uppercase tracking-wider text-gray-400">Total Warta</span>
            <div class="text-2xl font-black text-[#004125] mt-1">{{ number_format($stats['total']) }}</div>
        </div>
        <div class="bg-white rounded-2xl p-4 border border-[#e6eeff] shadow-sm">
            <span class="text-[10px] font-bold uppercase tracking-wider text-emerald-600">Diterbitkan</span>
            <div class="text-2xl font-black text-emerald-700 mt-1">{{ number_format($stats['published']) }}</div>
        </div>
        <div class="bg-white rounded-2xl p-4 border border-[#e6eeff] shadow-sm">
            <span class="text-[10px] font-bold uppercase tracking-wider text-amber-500">Draf / Menunggu</span>
            <div class="text-2xl font-black text-amber-600 mt-1">{{ number_format($stats['draft']) }}</div>
        </div>
        <div class="bg-white rounded-2xl p-4 border border-[#e6eeff] shadow-sm">
            <span class="text-[10px] font-bold uppercase tracking-wider text-blue-600">Total Pembaca</span>
            <div class="text-2xl font-black text-blue-800 mt-1">{{ number_format($stats['views']) }}</div>
        </div>
    </div>

    <!-- Search & Filter Console -->
    <div class="bg-white rounded-2xl p-4 sm:p-5 border border-[#e6eeff] shadow-sm">
        <form action="{{ route('admin.berita.index') }}" method="GET" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-12 gap-3 items-center">
            
            <div class="lg:col-span-5 relative">
                <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-lg">search</span>
                <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari judul, kutipan warta, atau isi berita..." 
                    class="w-full pl-9 pr-3 py-2 text-xs rounded-xl border border-gray-200 focus:border-[#0c5a37] text-gray-800">
            </div>

            <div class="lg:col-span-3">
                <select name="banom_id" class="w-full py-2 px-3 text-xs rounded-xl border border-gray-200 focus:border-[#0c5a37] text-gray-800">
                    <option value="">Semua Kategori BANOM</option>
                    <option value="prnu" {{ request('banom_id') === 'prnu' ? 'selected' : '' }}>Warta Umum Ranting NU</option>
                    @foreach($banoms as $b)
                        <option value="{{ $b->id }}" {{ request('banom_id') == $b->id ? 'selected' : '' }}>
                            BANOM {{ $b->singkatan }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="lg:col-span-2">
                <select name="status" class="w-full py-2 px-3 text-xs rounded-xl border border-gray-200 focus:border-[#0c5a37] text-gray-800">
                    <option value="">Semua Status</option>
                    <option value="published" {{ request('status') === 'published' ? 'selected' : '' }}>Published</option>
                    <option value="draft" {{ request('status') === 'draft' ? 'selected' : '' }}>Draft</option>
                </select>
            </div>

            <div class="lg:col-span-2 flex items-center gap-2">
                <button type="submit" class="flex-1 py-2 px-3 rounded-xl bg-[#004125] hover:bg-[#0c5a37] text-white text-xs font-bold transition flex items-center justify-center gap-1">
                    <span class="material-symbols-outlined text-[16px]">filter_list</span>
                    <span>Filter</span>
                </button>
                @if(request()->anyFilled(['q', 'banom_id', 'status']))
                    <a href="{{ route('admin.berita.index') }}" class="py-2 px-2.5 rounded-xl border border-gray-200 hover:bg-gray-50 text-gray-600 text-xs font-semibold" title="Reset">
                        <span class="material-symbols-outlined text-[16px]">restart_alt</span>
                    </a>
                @endif
            </div>

        </form>
    </div>

    <!-- Posts Table -->
    <div class="bg-white rounded-3xl border border-[#e6eeff] shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead>
                    <tr class="border-b border-gray-100 text-[#526350] font-bold uppercase tracking-wider text-[10px] bg-gray-50/50">
                        <th class="py-3.5 px-4">No</th>
                        <th class="py-3.5 px-3">Judul Berita & Kutipan</th>
                        <th class="py-3.5 px-3">Kategori & BANOM</th>
                        <th class="py-3.5 px-3">Penulis / Redaksi</th>
                        <th class="py-3.5 px-3">Status</th>
                        <th class="py-3.5 px-3">Dilihat</th>
                        <th class="py-3.5 px-3">Tanggal Terbit</th>
                        <th class="py-3.5 px-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($posts as $index => $p)
                        <tr class="hover:bg-emerald-50/20 transition">
                            <td class="py-3 px-4 text-gray-400 font-mono">
                                {{ $posts->firstItem() + $index }}
                            </td>
                            <td class="py-3 px-3">
                                <div class="flex items-center gap-3">
                                    <div class="w-12 h-9 rounded-lg bg-gray-100 overflow-hidden shrink-0 flex items-center justify-center">
                                        @if($p->thumbnail)
                                            <img src="{{ asset('storage/' . $p->thumbnail) }}" alt="{{ $p->title }}" class="w-full h-full object-cover">
                                        @else
                                            <span class="material-symbols-outlined text-gray-400 text-base">image</span>
                                        @endif
                                    </div>
                                    <div class="min-w-0 max-w-sm">
                                        <div class="font-bold text-gray-900 text-sm line-clamp-1 hover:text-[#004125]">
                                            {{ $p->title }}
                                        </div>
                                        <div class="text-[10px] text-gray-400 line-clamp-1">
                                            {{ $p->excerpt ?? Str::limit(strip_tags($p->content), 80) }}
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="py-3 px-3">
                                <div class="flex flex-col gap-0.5">
                                    <span class="font-semibold text-gray-800">{{ $p->kategori }}</span>
                                    @if($p->banom)
                                        <span class="text-[10px] text-emerald-700 font-bold">({{ $p->banom->singkatan }})</span>
                                    @else
                                        <span class="text-[10px] text-gray-400">Umum Ranting</span>
                                    @endif
                                </div>
                            </td>
                            <td class="py-3 px-3 text-gray-700 font-medium">
                                {{ $p->author }}
                            </td>
                            <td class="py-3 px-3">
                                <form action="{{ route('admin.berita.toggle-publish', $p->id) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[10px] font-extrabold uppercase transition
                                        {{ $p->status === 'published' ? 'bg-emerald-100 text-emerald-800 hover:bg-emerald-200' : 'bg-amber-100 text-amber-800 hover:bg-amber-200' }}"
                                        title="Klik untuk beralih status publikasi">
                                        <span class="w-1.5 h-1.5 rounded-full {{ $p->status === 'published' ? 'bg-emerald-600' : 'bg-amber-500' }}"></span>
                                        <span>{{ $p->status }}</span>
                                    </button>
                                </form>
                            </td>
                            <td class="py-3 px-3 font-mono text-gray-600">
                                {{ number_format($p->views) }}x
                            </td>
                            <td class="py-3 px-3 text-gray-600">
                                {{ $p->published_at ? $p->published_at->format('d/m/Y H:i') : '-' }}
                            </td>
                            <td class="py-3 px-4 text-right">
                                <div class="flex items-center justify-end gap-1.5">
                                    <a href="{{ route('post.show', $p->slug) }}" target="_blank" class="p-1.5 rounded-lg bg-gray-100 hover:bg-emerald-100 text-[#004125] transition" title="Lihat Publik">
                                        <span class="material-symbols-outlined text-[16px]">open_in_new</span>
                                    </a>
                                    <a href="{{ route('admin.berita.edit', $p->id) }}" class="p-1.5 rounded-lg bg-gray-100 hover:bg-emerald-100 text-[#004125] transition" title="Edit">
                                        <span class="material-symbols-outlined text-[16px]">edit</span>
                                    </a>
                                    <form action="{{ route('admin.berita.destroy', $p->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus warta ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-1.5 rounded-lg bg-rose-50 hover:bg-rose-600 hover:text-white text-rose-700 transition" title="Hapus">
                                            <span class="material-symbols-outlined text-[16px]">delete</span>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center py-10 text-gray-400 font-semibold">Belum ada warta berita yang sesuai filter.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="p-4 border-t border-gray-100">
            {{ $posts->links() }}
        </div>
    </div>

</div>
@endsection
