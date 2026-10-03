@extends('layouts.admin')

@section('title', 'Database Anggota / Kader — SIMNU Admin')

@section('content')
<div class="space-y-6">

    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <div class="flex items-center gap-2">
                <span class="px-2.5 py-0.5 rounded-full text-xs font-bold uppercase tracking-wider bg-emerald-100 text-[#004125]">
                    Basis Data Terpadu
                </span>
            </div>
            <h1 class="text-2xl font-black text-[#004125] mt-1">Anggota & Kader Nahdlatul Ulama</h1>
            <p class="text-xs text-[#526350]">Database seluruh kader PRNU Banjaranyar lintas 5 Badan Otonom beserta status keanggotaan dan KTA.</p>
        </div>

        <div class="flex items-center gap-2">
            <a href="{{ route('admin.anggota.create') }}" class="px-4 py-2.5 rounded-xl bg-[#004125] hover:bg-[#0c5a37] text-white text-xs font-bold transition flex items-center gap-1.5 shadow-sm">
                <span class="material-symbols-outlined text-[16px]">person_add</span>
                <span>Tambah Kader Baru</span>
            </a>
        </div>
    </div>

    <!-- 4 Stats Cards -->
    <div class="grid grid-cols-2 sm:grid-cols-5 gap-4">
        <div class="bg-white rounded-2xl p-4 border border-[#e6eeff] shadow-sm">
            <span class="text-[10px] font-bold uppercase tracking-wider text-gray-400">Total Kader</span>
            <div class="text-2xl font-black text-[#004125] mt-1">{{ number_format($stats['total']) }}</div>
        </div>
        <div class="bg-white rounded-2xl p-4 border border-[#e6eeff] shadow-sm">
            <span class="text-[10px] font-bold uppercase tracking-wider text-emerald-600">Kader Aktif</span>
            <div class="text-2xl font-black text-emerald-700 mt-1">{{ number_format($stats['aktif']) }}</div>
        </div>
        <div class="bg-white rounded-2xl p-4 border border-[#e6eeff] shadow-sm">
            <span class="text-[10px] font-bold uppercase tracking-wider text-gray-500">Tidak Aktif</span>
            <div class="text-2xl font-black text-gray-700 mt-1">{{ number_format($stats['tidak_aktif']) }}</div>
        </div>
        <div class="bg-white rounded-2xl p-4 border border-[#e6eeff] shadow-sm">
            <span class="text-[10px] font-bold uppercase tracking-wider text-indigo-500">Alumni</span>
            <div class="text-2xl font-black text-indigo-700 mt-1">{{ number_format($stats['alumni']) }}</div>
        </div>
        <div class="bg-white rounded-2xl p-4 border border-[#e6eeff] shadow-sm">
            <span class="text-[10px] font-bold uppercase tracking-wider text-blue-600">Memiliki KTA</span>
            <div class="text-2xl font-black text-blue-800 mt-1">{{ number_format($stats['has_kta']) }}</div>
        </div>
    </div>

    <!-- Search & Filter Bar -->
    <div class="bg-white rounded-2xl p-4 sm:p-5 border border-[#e6eeff] shadow-sm">
        <form action="{{ route('admin.anggota.index') }}" method="GET" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-12 gap-3 items-center">
            
            <div class="lg:col-span-5 relative">
                <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-lg">search</span>
                <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari nama kader, NIA, telepon, alamat..." 
                    class="w-full pl-9 pr-3 py-2 text-xs rounded-xl border border-gray-200 focus:border-[#0c5a37] focus:ring-1 focus:ring-[#0c5a37] text-gray-800">
            </div>

            <div class="lg:col-span-3">
                <select name="banom_id" class="w-full py-2 px-3 text-xs rounded-xl border border-gray-200 focus:border-[#0c5a37] text-gray-800">
                    <option value="">Semua BANOM</option>
                    @foreach($banoms as $b)
                        <option value="{{ $b->id }}" {{ request('banom_id') == $b->id ? 'selected' : '' }}>
                            {{ $b->singkatan }} - {{ $b->nama }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="lg:col-span-2">
                <select name="status" class="w-full py-2 px-3 text-xs rounded-xl border border-gray-200 focus:border-[#0c5a37] text-gray-800">
                    <option value="">Semua Status</option>
                    <option value="Aktif" {{ request('status') == 'Aktif' ? 'selected' : '' }}>Aktif</option>
                    <option value="Tidak Aktif" {{ request('status') == 'Tidak Aktif' ? 'selected' : '' }}>Tidak Aktif</option>
                    <option value="Alumni" {{ request('status') == 'Alumni' ? 'selected' : '' }}>Alumni</option>
                </select>
            </div>

            <div class="lg:col-span-2 flex items-center gap-2">
                <button type="submit" class="flex-1 py-2 px-3 rounded-xl bg-[#004125] hover:bg-[#0c5a37] text-white text-xs font-bold transition flex items-center justify-center gap-1">
                    <span class="material-symbols-outlined text-[16px]">filter_list</span>
                    <span>Filter</span>
                </button>
                @if(request()->anyFilled(['q', 'banom_id', 'status']))
                    <a href="{{ route('admin.anggota.index') }}" class="py-2 px-2.5 rounded-xl border border-gray-200 hover:bg-gray-50 text-gray-600 text-xs font-semibold" title="Reset">
                        <span class="material-symbols-outlined text-[16px]">restart_alt</span>
                    </a>
                @endif
            </div>

        </form>
    </div>

    <!-- Data Table -->
    <div class="bg-white rounded-3xl border border-[#e6eeff] shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead>
                    <tr class="border-b border-gray-100 text-[#526350] font-bold uppercase tracking-wider text-[10px] bg-gray-50/50">
                        <th class="py-3.5 px-4">No</th>
                        <th class="py-3.5 px-3">Kader & NIA</th>
                        <th class="py-3.5 px-3">BANOM</th>
                        <th class="py-3.5 px-3">Jabatan / Amanah</th>
                        <th class="py-3.5 px-3">Kontak & Wilayah</th>
                        <th class="py-3.5 px-3">Status</th>
                        <th class="py-3.5 px-3">Status KTA</th>
                        <th class="py-3.5 px-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($members as $index => $m)
                        <tr class="hover:bg-emerald-50/20 transition">
                            <td class="py-3 px-4 text-gray-400 font-mono">
                                {{ $members->firstItem() + $index }}
                            </td>
                            <td class="py-3 px-3">
                                <div class="flex items-center gap-3">
                                    <div class="w-9 h-9 rounded-xl bg-emerald-50 border border-emerald-100 overflow-hidden shrink-0 flex items-center justify-center text-emerald-800 font-bold">
                                        @if($m->foto)
                                            <img src="{{ asset('storage/' . $m->foto) }}" alt="{{ $m->nama_lengkap }}" class="w-full h-full object-cover">
                                        @else
                                            <span class="material-symbols-outlined text-lg">person</span>
                                        @endif
                                    </div>
                                    <div>
                                        <div class="font-bold text-gray-900 text-sm">{{ $m->nama_lengkap }}</div>
                                        <div class="text-[10px] text-gray-400 font-mono">{{ $m->nomor_anggota }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="py-3 px-3">
                                <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-emerald-100 text-[#004125]">
                                    {{ $m->banom->singkatan ?? '-' }}
                                </span>
                            </td>
                            <td class="py-3 px-3">
                                <div class="font-medium text-gray-800">{{ $m->jabatan }}</div>
                                <div class="text-[10px] text-gray-400">Masuk: {{ $m->tahun_masuk ?? '-' }}</div>
                            </td>
                            <td class="py-3 px-3">
                                <div class="text-gray-700">{{ $m->nomor_telepon ?? '-' }}</div>
                                <div class="text-[10px] text-gray-400 truncate max-w-[140px]">{{ $m->alamat ?? 'Banjaranyar' }}</div>
                            </td>
                            <td class="py-3 px-3">
                                @if($m->status === 'Aktif')
                                    <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[10px] font-extrabold bg-emerald-100 text-emerald-800">
                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-600"></span>
                                        <span>Aktif</span>
                                    </span>
                                @elseif($m->status === 'Tidak Aktif')
                                    <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[10px] font-semibold bg-gray-100 text-gray-700">
                                        <span class="w-1.5 h-1.5 rounded-full bg-gray-400"></span>
                                        <span>Tidak Aktif</span>
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[10px] font-semibold bg-indigo-100 text-indigo-800">
                                        <span class="w-1.5 h-1.5 rounded-full bg-indigo-500"></span>
                                        <span>Alumni</span>
                                    </span>
                                @endif
                            </td>
                            <td class="py-3 px-3">
                                @if($m->kta)
                                    <div class="space-y-1">
                                        <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[10px] font-bold bg-emerald-50 text-emerald-800 border border-emerald-200">
                                            <span class="material-symbols-outlined text-[12px] text-emerald-600">check_circle</span>
                                            <span>{{ $m->kta->nomor_kta }}</span>
                                        </span>
                                        <div class="flex items-center gap-1.5 text-[10px]">
                                            <a href="{{ route('admin.kta.show', $m->kta->id) }}" class="text-emerald-700 hover:underline">Lihat</a>
                                            <span class="text-gray-300">|</span>
                                            <a href="{{ route('admin.kta.print', $m->kta->id) }}" target="_blank" class="text-gray-600 hover:underline">Cetak</a>
                                        </div>
                                    </div>
                                @else
                                    <form action="{{ route('admin.kta.generate', $m->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="inline-flex items-center gap-1 text-[10px] font-bold text-white bg-[#0c5a37] hover:bg-[#004125] px-2.5 py-1 rounded-lg shadow-sm">
                                            <span class="material-symbols-outlined text-[13px]">auto_fix_high</span>
                                            <span>Generate KTA</span>
                                        </button>
                                    </form>
                                @endif
                            </td>
                            <td class="py-3 px-4 text-right">
                                <div class="flex items-center justify-end gap-1.5">
                                    <a href="{{ route('admin.anggota.edit', $m->id) }}" class="p-1.5 rounded-lg bg-gray-100 hover:bg-emerald-100 text-[#004125] transition" title="Edit Data">
                                        <span class="material-symbols-outlined text-[16px]">edit</span>
                                    </a>
                                    <form action="{{ route('admin.anggota.destroy', $m->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data kader ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-1.5 rounded-lg bg-rose-50 hover:bg-rose-600 hover:text-white text-rose-700 transition" title="Hapus Data">
                                            <span class="material-symbols-outlined text-[16px]">delete</span>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center py-10 text-gray-400">
                                <div class="w-12 h-12 rounded-full bg-gray-100 text-gray-400 flex items-center justify-center mx-auto mb-2">
                                    <span class="material-symbols-outlined text-2xl">person_off</span>
                                </div>
                                <p class="font-semibold">Belum ada data kader yang sesuai kriteria.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="p-4 border-t border-gray-100">
            {{ $members->links() }}
        </div>
    </div>

</div>
@endsection
