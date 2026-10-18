@extends('layouts.admin')

@section('title', 'Master Jabatan & Hierarki — SIMNU Banjaranyar')

@section('content')
<div class="space-y-6">

    <!-- Page Header -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 bg-white p-6 rounded-2xl border border-[#e6eeff] shadow-sm">
        <div>
            <nav class="flex items-center gap-2 text-xs text-[#707971] mb-1">
                <span>SIMNU Admin</span>
                <span>/</span>
                <span class="text-[#004125] font-semibold">Kelola Jabatan</span>
            </nav>
            <h1 class="text-2xl font-black text-[#004125] tracking-tight">Kelola Jabatan Organisasi</h1>
            <p class="text-xs text-[#526350] mt-0.5">Kelola daftar jabatan resmi, kategori, tipe, kuota batas keras, anjuran kuota, dan urutan hierarki.</p>
        </div>

        <a href="{{ route('admin.positions.create') }}" class="w-full sm:w-auto min-h-[44px] inline-flex items-center justify-center gap-2 px-5 py-2.5 rounded-xl bg-[#0c5a37] hover:bg-[#004125] text-white text-xs font-extrabold shadow-sm hover:shadow transition">
            <span class="material-symbols-outlined text-[18px]">add_circle</span>
            <span>Tambah Jabatan Baru</span>
        </a>
    </div>

    <!-- Filter & Search Toolbar -->
    <div class="bg-white p-5 rounded-2xl border border-[#e6eeff] shadow-sm">
        <form action="{{ route('admin.positions.index') }}" method="GET" class="flex flex-col sm:flex-row items-stretch sm:items-center justify-between gap-4">
            <div class="w-full sm:w-72 relative">
                <span class="material-symbols-outlined absolute left-3.5 top-1/2 -translate-y-1/2 text-gray-400 text-[20px]">search</span>
                <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari nama jabatan..." class="w-full pl-11 pr-4 py-2.5 text-xs sm:text-sm rounded-xl bg-[#f8f9ff] border border-[#dee9fc] focus:bg-white focus:outline-none focus:border-[#004125]">
            </div>

            <div class="flex flex-wrap items-center gap-3 w-full sm:w-auto">
                <div class="flex-1 sm:flex-initial flex items-center gap-2">
                    <span class="text-xs font-bold text-[#526350] shrink-0">Tipe:</span>
                    <select name="tipe" onchange="this.form.submit()" class="w-full sm:w-auto bg-[#f8f9ff] border border-[#dee9fc] rounded-xl px-3 py-2 text-xs sm:text-sm font-semibold text-[#121c2a] focus:outline-none focus:border-[#004125]">
                        <option value="">Semua Tipe</option>
                        @foreach($types as $key => $label)
                            <option value="{{ $key }}" {{ request('tipe') === $key ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="flex-1 sm:flex-initial flex items-center gap-2">
                    <span class="text-xs font-bold text-[#526350] shrink-0">Kategori:</span>
                    <select name="kategori" onchange="this.form.submit()" class="w-full sm:w-auto bg-[#f8f9ff] border border-[#dee9fc] rounded-xl px-3 py-2 text-xs sm:text-sm font-semibold text-[#121c2a] focus:outline-none focus:border-[#004125]">
                        <option value="">Semua Kategori</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat }}" {{ request('kategori') === $cat ? 'selected' : '' }}>{{ $cat }}</option>
                        @endforeach
                    </select>
                </div>

                @if(request()->hasAny(['q', 'kategori', 'tipe']))
                    <a href="{{ route('admin.positions.index') }}" class="min-h-[44px] px-3.5 rounded-xl bg-gray-100 hover:bg-gray-200 text-gray-700 text-xs font-bold transition flex items-center justify-center">
                        Reset
                    </a>
                @endif
            </div>
        </form>
    </div>

    <!-- Data Table -->
    <div class="bg-white rounded-2xl border border-[#e6eeff] shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-[#f8f9ff] border-b border-[#e6eeff] text-[11px] font-black uppercase tracking-wider text-[#526350]">
                        <th class="py-3.5 px-4 w-16 text-center">Urutan</th>
                        <th class="py-3.5 px-4">Nama Jabatan</th>
                        <th class="py-3.5 px-4">Tipe Jabatan</th>
                        <th class="py-3.5 px-4 text-center">Aturan Batas / Kuota</th>
                        <th class="py-3.5 px-4 text-center">Jumlah Terpakai</th>
                        <th class="py-3.5 px-4 text-right w-32">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#f2f4f8] text-xs">
                    @forelse($positions as $item)
                        <tr class="hover:bg-[#fafcff] transition-colors">
                            <td class="py-3 px-4 text-center">
                                <span class="w-7 h-7 rounded-lg bg-gray-100 font-mono font-bold text-[#004125] inline-flex items-center justify-center text-xs">
                                    {{ $item->urutan }}
                                </span>
                            </td>
                            <td class="py-3 px-4">
                                <div class="font-extrabold text-[#121c2a]">{{ $item->nama }}</div>
                                <div class="text-[10px] text-gray-400 mt-0.5">Kategori: {{ $item->kategori }}</div>
                            </td>
                            <td class="py-3 px-4">
                                @php
                                    $tipeBadge = match($item->tipe) {
                                        'inti' => 'bg-red-50 text-red-700 border-red-200',
                                        'wakil' => 'bg-amber-50 text-amber-800 border-amber-200',
                                        'anggota' => 'bg-emerald-50 text-emerald-800 border-emerald-200',
                                        default => 'bg-gray-100 text-gray-700 border-gray-200',
                                    };
                                    $tipeLabel = match($item->tipe) {
                                        'inti' => 'Pimpinan Inti',
                                        'wakil' => 'Wakil Pimpinan',
                                        'anggota' => 'Anggota',
                                        default => ucfirst($item->tipe ?? 'Umum'),
                                    };
                                @endphp
                                <span class="px-2.5 py-1 rounded-full text-[10px] font-bold border {{ $tipeBadge }}">
                                    {{ $tipeLabel }}
                                </span>
                            </td>
                            <td class="py-3 px-4 text-center">
                                @if($item->isBatasKeras())
                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg bg-red-100 text-red-900 font-bold text-[10px] border border-red-200" title="Batas keras: sistem menolak jika terisi lebih dari angka ini">
                                        <span class="material-symbols-outlined text-[12px]">lock</span>
                                        <span>Batas Keras: {{ $item->maks_orang ?? 1 }} orang</span>
                                    </span>
                                @elseif($item->hasAnjuran())
                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg bg-amber-50 text-amber-900 font-bold text-[10px] border border-amber-200" title="Anjuran lunak: hanya peringatan kuning, data tetap tersimpan">
                                        <span class="material-symbols-outlined text-[12px]">info</span>
                                        <span>Anjuran: {{ $item->anjuran_maks }} orang</span>
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg bg-emerald-50 text-emerald-800 font-bold text-[10px] border border-emerald-200">
                                        <span class="material-symbols-outlined text-[12px]">all_inclusive</span>
                                        <span>Tanpa Batas</span>
                                    </span>
                                @endif
                            </td>
                            <td class="py-3 px-4 text-center">
                                @php
                                    $activeCount = $item->banomOfficers->count();
                                @endphp
                                @if($activeCount > 0)
                                    <span class="px-2.5 py-0.5 rounded-full text-xs font-black bg-emerald-50 text-emerald-800 border border-emerald-200">
                                        {{ $activeCount }} Orang
                                    </span>
                                @else
                                    <span class="px-2.5 py-0.5 rounded-full text-xs font-semibold bg-gray-100 text-gray-400">
                                        0 Orang
                                    </span>
                                @endif
                            </td>
                            <td class="py-3 px-4 text-right">
                                <div class="flex items-center justify-end gap-1.5">
                                    <a href="{{ route('admin.positions.edit', $item->id) }}" class="p-1.5 rounded-lg text-emerald-700 hover:bg-emerald-50 transition" title="Edit Jabatan">
                                        <span class="material-symbols-outlined text-[18px]">edit</span>
                                    </a>

                                    <form action="{{ route('admin.positions.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus jabatan {{ $item->nama }}?');" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-1.5 rounded-lg text-red-600 hover:bg-red-50 transition" title="Hapus Jabatan">
                                            <span class="material-symbols-outlined text-[18px]">delete</span>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-10 text-center text-gray-400">
                                Tidak ada data jabatan yang ditemukan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($positions->hasPages())
            <div class="p-4 border-t border-[#e6eeff]">
                {{ $positions->links() }}
            </div>
        @endif
    </div>

</div>
@endsection
