@extends('layouts.admin')

@section('title', 'Struktur Organisasi & Pengurus — SIMNU Admin')

@section('content')
<div class="space-y-6">

    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <div class="flex items-center gap-2">
                <span class="px-2.5 py-0.5 rounded-full text-xs font-bold uppercase tracking-wider bg-emerald-100 text-[#004125]">
                    Amanah Khidmat
                </span>
            </div>
            <h1 class="text-2xl font-black text-[#004125] mt-1">Struktur Kepengurusan Ranting & BANOM</h1>
            <p class="text-xs text-[#526350]">Kelola jajaran Mustasyar, Syuriyah, Tanfidziyah, Lembaga, serta pimpinan 5 Badan Otonom.</p>
        </div>

        <a href="{{ route('admin.struktur.create') }}" class="w-full sm:w-auto min-h-[44px] px-4 py-2.5 rounded-xl bg-[#004125] hover:bg-[#0c5a37] text-white text-xs font-bold transition flex items-center justify-center gap-1.5 shadow-sm">
            <span class="material-symbols-outlined text-[16px]">person_add</span>
            <span>Tambah Pengurus</span>
        </a>
    </div>

    <!-- Filter Console -->
    <div class="bg-white rounded-2xl p-4 sm:p-5 border border-[#e6eeff] shadow-sm">
        <form action="{{ route('admin.struktur.index') }}" method="GET" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-12 gap-3 items-center">
            
            <div class="lg:col-span-5">
                <select name="banom_id" class="w-full py-2.5 px-3 text-xs sm:text-sm rounded-xl border border-gray-200 focus:border-[#0c5a37] text-gray-800">
                    <option value="">Semua Tingkatan (PRNU & BANOM)</option>
                    <option value="prnu" {{ request('banom_id') === 'prnu' ? 'selected' : '' }}>Pengurus Ranting NU (Pusat Ranting)</option>
                    @foreach($banoms as $b)
                        <option value="{{ $b->id }}" {{ request('banom_id') == $b->id ? 'selected' : '' }}>
                            BANOM {{ $b->singkatan }} - {{ $b->nama }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="lg:col-span-4">
                <select name="hierarki" class="w-full py-2.5 px-3 text-xs sm:text-sm rounded-xl border border-gray-200 focus:border-[#0c5a37] text-gray-800">
                    <option value="">Semua Kategori Hierarki</option>
                    <option value="mustasyar" {{ request('hierarki') === 'mustasyar' ? 'selected' : '' }}>Mustasyar (Penasihat)</option>
                    <option value="syuriyah" {{ request('hierarki') === 'syuriyah' ? 'selected' : '' }}>Syuriyah (Pimpinan Tertinggi)</option>
                    <option value="tanfidziyah" {{ request('hierarki') === 'tanfidziyah' ? 'selected' : '' }}>Tanfidziyah (Pelaksana)</option>
                    <option value="lembaga" {{ request('hierarki') === 'lembaga' ? 'selected' : '' }}>Lembaga / Lajnah</option>
                    <option value="banom" {{ request('hierarki') === 'banom' ? 'selected' : '' }}>Pimpinan BANOM</option>
                </select>
            </div>

            <div class="lg:col-span-3 flex items-center gap-2">
                <button type="submit" class="flex-1 min-h-[44px] py-2 px-3 rounded-xl bg-[#004125] hover:bg-[#0c5a37] text-white text-xs font-bold transition flex items-center justify-center gap-1">
                    <span class="material-symbols-outlined text-[16px]">filter_list</span>
                    <span>Terapkan</span>
                </button>
                @if(request()->anyFilled(['banom_id', 'hierarki']))
                    <a href="{{ route('admin.struktur.index') }}" class="min-h-[44px] px-3.5 rounded-xl border border-gray-200 hover:bg-gray-50 text-gray-600 text-xs font-semibold flex items-center justify-center" title="Reset">
                        <span class="material-symbols-outlined text-[16px]">restart_alt</span>
                    </a>
                @endif
            </div>

        </form>
    </div>

    <!-- Structures Table -->
    <div class="bg-white rounded-3xl border border-[#e6eeff] shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead>
                    <tr class="border-b border-gray-100 text-[#526350] font-bold uppercase tracking-wider text-[10px] bg-gray-50/50">
                        <th class="py-3.5 px-4">Urutan</th>
                        <th class="py-3.5 px-3">Nama Pengurus</th>
                        <th class="py-3.5 px-3">Jabatan / Amanah</th>
                        <th class="py-3.5 px-3">Hierarki</th>
                        <th class="py-3.5 px-3">Afiliasi</th>
                        <th class="py-3.5 px-3">Status</th>
                        <th class="py-3.5 px-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($structures as $st)
                        <tr class="hover:bg-emerald-50/20 transition">
                            <td class="py-3 px-4 font-mono font-bold text-gray-500">
                                #{{ $st->urutan }}
                            </td>
                            <td class="py-3 px-3">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-xl bg-gray-100 border border-gray-200 overflow-hidden shrink-0 flex items-center justify-center">
                                        @if($st->foto)
                                            <img src="{{ asset('storage/' . $st->foto) }}" alt="{{ $st->nama }}" class="w-full h-full object-cover">
                                        @else
                                            <span class="material-symbols-outlined text-gray-400 text-lg">person</span>
                                        @endif
                                    </div>
                                    <div>
                                        <div class="font-bold text-gray-900 text-sm">{{ $st->nama }}</div>
                                        <div class="text-[10px] text-gray-400 line-clamp-1">{{ $st->deskripsi ?? 'Amanah Khidmat' }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="py-3 px-3 font-semibold text-gray-800">
                                {{ $st->jabatan }}
                            </td>
                            <td class="py-3 px-3">
                                <span class="px-2 py-0.5 rounded-full text-[10px] font-bold uppercase tracking-wider
                                    {{ $st->kategori_hierarki === 'syuriyah' ? 'bg-emerald-100 text-emerald-900' : '' }}
                                    {{ $st->kategori_hierarki === 'tanfidziyah' ? 'bg-blue-100 text-blue-900' : '' }}
                                    {{ $st->kategori_hierarki === 'mustasyar' ? 'bg-amber-100 text-amber-900' : '' }}
                                    {{ $st->kategori_hierarki === 'banom' ? 'bg-teal-100 text-teal-900' : '' }}
                                    {{ $st->kategori_hierarki === 'lembaga' ? 'bg-purple-100 text-purple-900' : '' }}">
                                    {{ $st->kategori_hierarki }}
                                </span>
                            </td>
                            <td class="py-3 px-3">
                                @if($st->banom)
                                    <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-gray-100 text-gray-800">
                                        {{ $st->banom->singkatan }}
                                    </span>
                                @else
                                    <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-emerald-50 text-[#004125] border border-emerald-200">
                                        PRNU Ranting
                                    </span>
                                @endif
                            </td>
                            <td class="py-3 px-3">
                                <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[10px] font-extrabold {{ $st->status === 'Aktif' ? 'bg-emerald-100 text-emerald-800' : 'bg-gray-100 text-gray-600' }}">
                                    <span class="w-1.5 h-1.5 rounded-full {{ $st->status === 'Aktif' ? 'bg-emerald-600' : 'bg-gray-400' }}"></span>
                                    <span>{{ $st->status }}</span>
                                </span>
                            </td>
                            <td class="py-3 px-4 text-right">
                                <div class="flex items-center justify-end gap-1.5">
                                    <a href="{{ route('admin.struktur.edit', $st->id) }}" class="p-1.5 rounded-lg bg-gray-100 hover:bg-emerald-100 text-[#004125] transition" title="Edit">
                                        <span class="material-symbols-outlined text-[16px]">edit</span>
                                    </a>
                                    <form action="{{ route('admin.struktur.destroy', $st->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data pengurus ini?')">
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
                            <td colspan="7" class="text-center py-10 text-gray-400 font-semibold">Belum ada struktur pengurus yang sesuai filter.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="p-4 border-t border-gray-100">
            {{ $structures->links() }}
        </div>
    </div>

</div>
@endsection
