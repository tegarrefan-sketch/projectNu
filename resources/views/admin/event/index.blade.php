@extends('layouts.admin')

@section('title', 'Manajemen Agenda Kegiatan — SIMNU Admin')

@section('content')
<div class="space-y-6">

    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <div class="flex items-center gap-2">
                <span class="px-2.5 py-0.5 rounded-full text-xs font-bold uppercase tracking-wider bg-emerald-100 text-[#004125]">
                    Aktivitas & Syiar
                </span>
            </div>
            <h1 class="text-2xl font-black text-[#004125] mt-1">Agenda & Jadwal Kegiatan</h1>
            <p class="text-xs text-[#526350]">Kelola jadwal pengajian rutin, rapat koordinasi, diklat kaderisasi BANOM, dan peringatan hari besar Islam (PHBI).</p>
        </div>

        <a href="{{ route('admin.agenda.create') }}" class="px-4 py-2.5 rounded-xl bg-[#004125] hover:bg-[#0c5a37] text-white text-xs font-bold transition flex items-center gap-1.5 shadow-sm">
            <span class="material-symbols-outlined text-[16px]">add_circle</span>
            <span>Tambah Agenda Baru</span>
        </a>
    </div>

    <!-- 3 Metrics Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
        <div class="bg-white rounded-2xl p-4 border border-[#e6eeff] shadow-sm">
            <span class="text-[10px] font-bold uppercase tracking-wider text-gray-400">Total Agenda</span>
            <div class="text-2xl font-black text-[#004125] mt-1">{{ number_format($stats['total']) }}</div>
        </div>
        <div class="bg-white rounded-2xl p-4 border border-[#e6eeff] shadow-sm">
            <span class="text-[10px] font-bold uppercase tracking-wider text-emerald-600">Akan Datang (Mendatang)</span>
            <div class="text-2xl font-black text-emerald-700 mt-1">{{ number_format($stats['upcoming']) }}</div>
        </div>
        <div class="bg-white rounded-2xl p-4 border border-[#e6eeff] shadow-sm">
            <span class="text-[10px] font-bold uppercase tracking-wider text-gray-500">Telah Terlaksana</span>
            <div class="text-2xl font-black text-gray-700 mt-1">{{ number_format($stats['past']) }}</div>
        </div>
    </div>

    <!-- Filter Console -->
    <div class="bg-white rounded-2xl p-4 sm:p-5 border border-[#e6eeff] shadow-sm">
        <form action="{{ route('admin.agenda.index') }}" method="GET" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-12 gap-3 items-center">
            
            <div class="lg:col-span-6 relative">
                <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-lg">search</span>
                <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari nama agenda, lokasi, atau deskripsi kegiatan..." 
                    class="w-full pl-9 pr-3 py-2 text-xs rounded-xl border border-gray-200 focus:border-[#0c5a37] text-gray-800">
            </div>

            <div class="lg:col-span-4">
                <select name="banom_id" class="w-full py-2 px-3 text-xs rounded-xl border border-gray-200 focus:border-[#0c5a37] text-gray-800">
                    <option value="">Semua Penyelenggara (PRNU & BANOM)</option>
                    <option value="prnu" {{ request('banom_id') === 'prnu' ? 'selected' : '' }}>Pusat Ranting Banjaranyar</option>
                    @foreach($banoms as $b)
                        <option value="{{ $b->id }}" {{ request('banom_id') == $b->id ? 'selected' : '' }}>
                            BANOM {{ $b->singkatan }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="lg:col-span-2 flex items-center gap-2">
                <button type="submit" class="flex-1 py-2 px-3 rounded-xl bg-[#004125] hover:bg-[#0c5a37] text-white text-xs font-bold transition flex items-center justify-center gap-1">
                    <span class="material-symbols-outlined text-[16px]">filter_list</span>
                    <span>Filter</span>
                </button>
                @if(request()->anyFilled(['q', 'banom_id']))
                    <a href="{{ route('admin.agenda.index') }}" class="py-2 px-2.5 rounded-xl border border-gray-200 hover:bg-gray-50 text-gray-600 text-xs font-semibold" title="Reset">
                        <span class="material-symbols-outlined text-[16px]">restart_alt</span>
                    </a>
                @endif
            </div>

        </form>
    </div>

    <!-- Events Table -->
    <div class="bg-white rounded-3xl border border-[#e6eeff] shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead>
                    <tr class="border-b border-gray-100 text-[#526350] font-bold uppercase tracking-wider text-[10px] bg-gray-50/50">
                        <th class="py-3.5 px-4">Tanggal & Waktu</th>
                        <th class="py-3.5 px-3">Agenda Kegiatan</th>
                        <th class="py-3.5 px-3">Lokasi Tempat</th>
                        <th class="py-3.5 px-3">Penyelenggara</th>
                        <th class="py-3.5 px-3">Status</th>
                        <th class="py-3.5 px-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($events as $ev)
                        <tr class="hover:bg-emerald-50/20 transition">
                            <td class="py-3 px-4">
                                <div class="font-bold text-gray-900">{{ $ev->tanggal->translatedFormat('d M Y') }}</div>
                                <div class="text-[10px] text-gray-400">
                                    {{ $ev->waktu_mulai ? substr($ev->waktu_mulai, 0, 5) : '08:00' }} - {{ $ev->waktu_selesai ? substr($ev->waktu_selesai, 0, 5) : 'Selesai' }} WIB
                                </div>
                            </td>
                            <td class="py-3 px-3">
                                <div class="font-bold text-gray-900 text-sm hover:text-[#004125] line-clamp-1">
                                    {{ $ev->title }}
                                </div>
                                <div class="text-[10px] text-gray-400 line-clamp-1">
                                    {{ $ev->description ?? 'Tidak ada deskripsi rinci' }}
                                </div>
                            </td>
                            <td class="py-3 px-3">
                                <div class="text-gray-700 flex items-center gap-1">
                                    <span class="material-symbols-outlined text-[14px] text-emerald-600">location_on</span>
                                    <span>{{ $ev->lokasi }}</span>
                                </div>
                            </td>
                            <td class="py-3 px-3">
                                @if($ev->banom)
                                    <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-gray-100 text-gray-800">
                                        {{ $ev->banom->singkatan }}
                                    </span>
                                @else
                                    <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-emerald-50 text-[#004125] border border-emerald-200">
                                        PRNU Ranting
                                    </span>
                                @endif
                            </td>
                            <td class="py-3 px-3">
                                <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[10px] font-extrabold
                                    {{ $ev->status === 'Akan Datang' ? 'bg-emerald-100 text-emerald-800' : '' }}
                                    {{ $ev->status === 'Selesai' ? 'bg-gray-100 text-gray-700' : '' }}
                                    {{ $ev->status === 'Dibatalkan' ? 'bg-rose-100 text-rose-800' : '' }}">
                                    <span>{{ $ev->status }}</span>
                                </span>
                            </td>
                            <td class="py-3 px-4 text-right">
                                <div class="flex items-center justify-end gap-1.5">
                                    <a href="{{ route('event.show', $ev->slug) }}" target="_blank" class="p-1.5 rounded-lg bg-gray-100 hover:bg-emerald-100 text-[#004125] transition" title="Lihat Publik">
                                        <span class="material-symbols-outlined text-[16px]">open_in_new</span>
                                    </a>
                                    <a href="{{ route('admin.agenda.edit', $ev->id) }}" class="p-1.5 rounded-lg bg-gray-100 hover:bg-emerald-100 text-[#004125] transition" title="Edit">
                                        <span class="material-symbols-outlined text-[16px]">edit</span>
                                    </a>
                                    <form action="{{ route('admin.agenda.destroy', $ev->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus agenda ini?')">
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
                            <td colspan="6" class="text-center py-10 text-gray-400 font-semibold">Belum ada agenda kegiatan yang sesuai kriteria.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="p-4 border-t border-gray-100">
            {{ $events->links() }}
        </div>
    </div>

</div>
@endsection
