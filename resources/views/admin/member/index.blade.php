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
            <p class="text-xs text-[#526350] font-medium mt-0.5">Buku induk warga dan kader, tanpa batas jumlah</p>
        </div>

        <div class="flex items-center gap-2">
            <a href="{{ route('admin.anggota.create') }}" class="px-4 py-2.5 rounded-xl bg-[#004125] hover:bg-[#0c5a37] text-white text-xs font-bold transition flex items-center gap-1.5 shadow-sm">
                <span class="material-symbols-outlined text-[16px]">person_add</span>
                <span>Tambah Kader Baru</span>
            </a>
        </div>
    </div>

    <!-- Teks Bantuan Singkat / Info Banner -->
    <div class="p-3.5 bg-emerald-50 border border-emerald-200 rounded-2xl flex items-center gap-3 text-xs text-[#004125]">
        <span class="material-symbols-outlined text-emerald-700 text-xl shrink-0">info</span>
        <div>
            <span class="font-bold">Buku induk warga dan kader, tanpa batas jumlah:</span>
            <span class="text-emerald-900"> Menu ini menampung seluruh database anggota, kader, dan simpatisan desa tanpa batasan kuota. Gelar jabatan struktural di KTA otomatis diambil dari menu <strong>Pengurus</strong> jika anggota aktif menjabat.</span>
        </div>
    </div>

    <!-- 5 Stats Cards -->
    <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-3 sm:gap-4">
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
        <div class="bg-white rounded-2xl p-4 border border-[#e6eeff] shadow-sm col-span-2 sm:col-span-1">
            <span class="text-[10px] font-bold uppercase tracking-wider text-blue-600">Memiliki KTA</span>
            <div class="text-2xl font-black text-blue-800 mt-1">{{ number_format($stats['has_kta']) }}</div>
        </div>
    </div>

    <!-- Search & Filter Bar -->
    <div class="bg-white rounded-2xl p-4 sm:p-5 border border-[#e6eeff] shadow-sm">
        <form action="{{ route('admin.anggota.index') }}" method="GET" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-12 gap-3 items-center">
            
            <div class="lg:col-span-4 relative">
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
                <select name="status_keanggotaan" class="w-full py-2 px-3 text-xs rounded-xl border border-gray-200 focus:border-[#0c5a37] text-gray-800">
                    <option value="">Status Keanggotaan</option>
                    <option value="Anggota" {{ request('status_keanggotaan') == 'Anggota' ? 'selected' : '' }}>Anggota</option>
                    <option value="Kader" {{ request('status_keanggotaan') == 'Kader' ? 'selected' : '' }}>Kader</option>
                    <option value="Simpatisan" {{ request('status_keanggotaan') == 'Simpatisan' ? 'selected' : '' }}>Simpatisan</option>
                </select>
            </div>

            <div class="lg:col-span-2">
                <select name="status" class="w-full py-2 px-3 text-xs rounded-xl border border-gray-200 focus:border-[#0c5a37] text-gray-800">
                    <option value="">Keaktifan</option>
                    <option value="Aktif" {{ request('status') == 'Aktif' ? 'selected' : '' }}>Aktif</option>
                    <option value="Tidak Aktif" {{ request('status') == 'Tidak Aktif' ? 'selected' : '' }}>Tidak Aktif</option>
                    <option value="Alumni" {{ request('status') == 'Alumni' ? 'selected' : '' }}>Alumni</option>
                </select>
            </div>

            <div class="lg:col-span-1 flex items-center gap-1.5 w-full">
                <button type="submit" class="flex-1 py-2 px-3 min-h-[44px] rounded-xl bg-[#004125] hover:bg-[#0c5a37] text-white text-xs font-bold transition flex items-center justify-center gap-1">
                    <span class="material-symbols-outlined text-[16px]">filter_list</span>
                </button>
                @if(request()->anyFilled(['q', 'banom_id', 'status', 'status_keanggotaan']))
                    <a href="{{ route('admin.anggota.index') }}" class="py-2 px-2.5 min-h-[44px] flex items-center justify-center rounded-xl border border-gray-200 hover:bg-gray-50 text-gray-600 text-xs font-semibold" title="Reset">
                        <span class="material-symbols-outlined text-[16px]">restart_alt</span>
                    </a>
                @endif
            </div>

        </form>
    </div>

    <!-- Data Table & Mobile Cards -->
    <div class="bg-white rounded-3xl border border-[#e6eeff] shadow-sm overflow-hidden">
        <!-- Mobile Stacked Card View (sm:hidden) -->
        <div class="sm:hidden p-4 space-y-3 bg-[#fbfcfe]">
            @forelse($members as $index => $m)
                <div class="bg-white rounded-2xl p-4 border border-[#e6eeff] shadow-xs space-y-3">
                    <div class="flex items-start gap-3">
                        <div class="w-12 h-12 rounded-xl bg-emerald-50 border border-emerald-100 overflow-hidden shrink-0 flex items-center justify-center text-emerald-800 font-bold">
                            @if($m->foto)
                                <img src="{{ asset('storage/' . $m->foto) }}" alt="{{ $m->nama_lengkap }}" class="w-full h-full object-cover">
                            @else
                                <span class="material-symbols-outlined text-xl">person</span>
                            @endif
                        </div>
                        <div class="min-w-0 flex-1">
                            <a href="{{ route('admin.anggota.show', $m->id) }}" class="font-extrabold text-gray-900 hover:text-emerald-700 text-sm block break-words">
                                {{ $m->nama_lengkap }}
                            </a>
                            <div class="text-[11px] text-gray-400 font-mono mt-0.5">NIA: {{ $m->nomor_anggota }}</div>
                            <div class="mt-1">
                                <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-emerald-100 text-[#004125]">
                                    {{ $m->banom->singkatan ?? '-' }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Details (label kiri, isi kanan) -->
                    <div class="bg-[#f8f9ff] rounded-xl p-3 border border-[#dee9fc] divide-y divide-gray-100 text-xs">
                        <div class="flex items-center justify-between py-1.5">
                            <span class="text-gray-500 font-medium">Keanggotaan:</span>
                            <span class="px-2 py-0.5 rounded-full text-[10px] font-bold {{ $m->status_keanggotaan === 'Kader' ? 'bg-amber-100 text-amber-900' : ($m->status_keanggotaan === 'Simpatisan' ? 'bg-blue-100 text-blue-900' : 'bg-gray-100 text-gray-800') }}">
                                {{ $m->status_keanggotaan ?? 'Anggota' }}
                            </span>
                        </div>

                        <div class="flex items-center justify-between py-1.5">
                            <span class="text-gray-500 font-medium">Amanah / Jabatan:</span>
                            <div class="text-right">
                                @if($m->activeOfficer)
                                    <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[10px] font-extrabold bg-emerald-100 text-[#004125] border border-emerald-300">
                                        <span class="material-symbols-outlined text-[12px] text-emerald-700">verified</span>
                                        <span>{{ $m->activeOfficer->display_jabatan }}</span>
                                    </span>
                                @else
                                    <span class="text-gray-400 text-[11px] italic">Warga / Kader Biasa</span>
                                @endif
                            </div>
                        </div>

                        <div class="flex items-center justify-between py-1.5">
                            <span class="text-gray-500 font-medium">Kontak & Wilayah:</span>
                            <span class="font-bold text-gray-800 text-right text-[11px]">{{ $m->nomor_telepon ?? '-' }} ({{ $m->alamat ?? 'Banjaranyar' }})</span>
                        </div>

                        <div class="flex items-center justify-between py-1.5">
                            <span class="text-gray-500 font-medium">Status Keaktifan:</span>
                            <span>
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
                            </span>
                        </div>

                        <div class="flex items-center justify-between py-1.5">
                            <span class="text-gray-500 font-medium">Status KTA:</span>
                            <div class="text-right">
                                @if($m->kta)
                                    <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[10px] font-bold bg-emerald-50 text-emerald-800 border border-emerald-200">
                                        <span class="material-symbols-outlined text-[12px] text-emerald-600">check_circle</span>
                                        <span>{{ $m->kta->nomor_kta }}</span>
                                    </span>
                                @else
                                    <span class="text-amber-700 text-[10px] font-bold">Belum Ada KTA</span>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Action buttons row -->
                    <div class="grid grid-cols-3 gap-2 pt-1">
                        <a href="{{ route('admin.anggota.show', $m->id) }}" class="min-h-[44px] rounded-xl bg-blue-50 hover:bg-blue-100 text-blue-700 font-bold text-xs flex items-center justify-center gap-1 border border-blue-200 transition">
                            <span class="material-symbols-outlined text-[16px]">visibility</span>
                            <span>Detail</span>
                        </a>

                        <a href="{{ route('admin.anggota.edit', $m->id) }}" class="min-h-[44px] rounded-xl bg-emerald-50 hover:bg-emerald-100 text-[#004125] font-bold text-xs flex items-center justify-center gap-1 border border-emerald-200 transition">
                            <span class="material-symbols-outlined text-[16px]">edit</span>
                            <span>Edit</span>
                        </a>

                        <form action="{{ route('admin.anggota.destroy', $m->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data kader ini?')" class="w-full">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="w-full min-h-[44px] rounded-xl bg-rose-50 hover:bg-rose-100 text-rose-700 font-bold text-xs flex items-center justify-center gap-1 border border-rose-200 transition">
                                <span class="material-symbols-outlined text-[16px]">delete</span>
                                <span>Hapus</span>
                            </button>
                        </form>
                    </div>

                    @if(!$m->kta)
                        <form action="{{ route('admin.kta.generate', $m->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="w-full min-h-[44px] flex items-center justify-center gap-1.5 text-xs font-bold text-white bg-[#0c5a37] hover:bg-[#004125] px-3 py-2 rounded-xl shadow-xs transition">
                                <span class="material-symbols-outlined text-[16px]">auto_fix_high</span>
                                <span>Generate KTA Sekarang</span>
                            </button>
                        </form>
                    @endif
                </div>
            @empty
                <div class="text-center py-10 text-gray-400">
                    <div class="w-12 h-12 rounded-full bg-gray-100 text-gray-400 flex items-center justify-center mx-auto mb-2">
                        <span class="material-symbols-outlined text-2xl">person_off</span>
                    </div>
                    <p class="font-semibold text-xs">Belum ada data kader yang sesuai kriteria.</p>
                </div>
            @endforelse
        </div>

        <!-- Desktop & Tablet Table (hidden sm:block) -->
        <div class="hidden sm:block overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead>
                    <tr class="border-b border-gray-100 text-[#526350] font-bold uppercase tracking-wider text-[10px] bg-gray-50/50">
                        <th class="py-3.5 px-4">No</th>
                        <th class="py-3.5 px-3">Kader & NIA</th>
                        <th class="py-3.5 px-3">BANOM</th>
                        <th class="py-3.5 px-3">Keanggotaan & Amanah</th>
                        <th class="py-3.5 px-3">Kontak & Wilayah</th>
                        <th class="py-3.5 px-3">Keaktifan</th>
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
                                        <a href="{{ route('admin.anggota.show', $m->id) }}" class="font-bold text-gray-900 hover:text-emerald-700 text-sm block">
                                            {{ $m->nama_lengkap }}
                                        </a>
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
                                <div class="flex flex-col gap-1 items-start">
                                    <div class="flex items-center gap-1.5">
                                        <span class="px-2 py-0.5 rounded-full text-[10px] font-bold {{ $m->status_keanggotaan === 'Kader' ? 'bg-amber-100 text-amber-900' : ($m->status_keanggotaan === 'Simpatisan' ? 'bg-blue-100 text-blue-900' : 'bg-gray-100 text-gray-800') }}">
                                            {{ $m->status_keanggotaan ?? 'Anggota' }}
                                        </span>
                                        <span class="text-[10px] text-gray-400">Masuk: {{ $m->tahun_masuk ?? '-' }}</span>
                                    </div>
                                    @if($m->activeOfficer)
                                        <div>
                                            <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[10px] font-extrabold bg-emerald-100 text-[#004125] border border-emerald-300">
                                                <span class="material-symbols-outlined text-[12px] text-emerald-700">verified</span>
                                                <span>Pengurus: {{ $m->activeOfficer->display_jabatan }}</span>
                                            </span>
                                        </div>
                                    @else
                                        <div>
                                            <a href="{{ route('admin.banoms.officers.create', [$m->banom_id, 'member_id' => $m->id]) }}" class="inline-flex items-center gap-1 text-[10px] font-bold text-emerald-700 hover:text-[#004125] bg-emerald-50 hover:bg-emerald-100 border border-emerald-200 px-2 py-0.5 rounded-lg transition" title="Jadikan Pengurus di {{ $m->banom->singkatan }}">
                                                <span class="material-symbols-outlined text-[12px]">person_add</span>
                                                <span>Jadikan Pengurus</span>
                                            </a>
                                        </div>
                                    @endif
                                </div>
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
                                    <a href="{{ route('admin.anggota.show', $m->id) }}" class="p-1.5 rounded-lg bg-gray-100 hover:bg-blue-100 text-blue-700 transition" title="Lihat Profil Lengkap">
                                        <span class="material-symbols-outlined text-[16px]">visibility</span>
                                    </a>
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
