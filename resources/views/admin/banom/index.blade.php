@extends('layouts.admin')

@section('title', 'Manajemen Badan Otonom (BANOM) — SIMNU Admin')

@section('content')
<div class="space-y-6">

    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 bg-white p-6 rounded-2xl border border-[#e6eeff] shadow-sm">
        <div>
            <nav class="flex items-center gap-2 text-xs text-[#707971] mb-1">
                <span>SIMNU Admin</span>
                <span>/</span>
                <span class="text-[#004125] font-semibold">Badan Otonom</span>
            </nav>
            <h1 class="text-2xl font-black text-[#004125] tracking-tight">Badan Otonom (BANOM) Nahdlatul Ulama</h1>
            <p class="text-xs text-[#526350] mt-0.5">Kelola data profil, logo, status aktif, dan jajaran pengurus Banom Ranting Banjaranyar.</p>
        </div>

        <a href="{{ route('admin.banoms.create') }}" class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-[#0c5a37] hover:bg-[#004125] text-white text-xs font-extrabold shadow-sm hover:shadow transition">
            <span class="material-symbols-outlined text-[18px]">add_circle</span>
            <span>Tambah Banom Baru</span>
        </a>
    </div>

    <!-- Search & Filter Bar -->
    <div class="bg-white p-5 rounded-2xl border border-[#e6eeff] shadow-sm">
        <form action="{{ route('admin.banoms.index') }}" method="GET" class="flex flex-col sm:flex-row items-center justify-between gap-4">
            <div class="w-full sm:w-80 relative">
                <span class="material-symbols-outlined absolute left-3.5 top-1/2 -translate-y-1/2 text-gray-400 text-[20px]">search</span>
                <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari nama atau singkatan Banom..." class="w-full pl-11 pr-4 py-2.5 rounded-xl text-xs bg-[#f8f9ff] border border-[#dee9fc] focus:bg-white focus:outline-none focus:border-[#004125]">
            </div>

            <div class="flex flex-wrap items-center gap-3 w-full sm:w-auto">
                <select name="status" onchange="this.form.submit()" class="bg-[#f8f9ff] border border-[#dee9fc] rounded-xl px-3 py-2 text-xs font-semibold text-[#121c2a] focus:outline-none focus:border-[#004125]">
                    <option value="">Semua Status</option>
                    <option value="aktif" {{ request('status') === 'aktif' ? 'selected' : '' }}>Aktif</option>
                    <option value="nonaktif" {{ request('status') === 'nonaktif' ? 'selected' : '' }}>Nonaktif</option>
                </select>

                <select name="sort" onchange="this.form.submit()" class="bg-[#f8f9ff] border border-[#dee9fc] rounded-xl px-3 py-2 text-xs font-semibold text-[#121c2a] focus:outline-none focus:border-[#004125]">
                    <option value="urutan" {{ request('sort') === 'urutan' ? 'selected' : '' }}>Urut: Hierarki Urutan</option>
                    <option value="singkatan" {{ request('sort') === 'singkatan' ? 'selected' : '' }}>Urut: Singkatan A-Z</option>
                    <option value="created_at" {{ request('sort') === 'created_at' ? 'selected' : '' }}>Urut: Terbaru</option>
                </select>

                @if(request()->hasAny(['q', 'status', 'sort']))
                    <a href="{{ route('admin.banoms.index') }}" class="px-3 py-2 rounded-xl bg-gray-100 hover:bg-gray-200 text-gray-700 text-xs font-bold transition">
                        Reset
                    </a>
                @endif
            </div>
        </form>
    </div>

    <!-- BANOM Cards Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($banoms as $banom)
            <div class="bg-white rounded-3xl p-6 border-2 border-[#e6eeff] hover:border-[#0c5a37] shadow-sm transition-all flex flex-col justify-between space-y-5">
                
                <div class="space-y-4">
                    <!-- Top Info: Logo, Singkatan, Status, Urutan -->
                    <div class="flex items-start justify-between gap-3">
                        <div class="flex items-center gap-3">
                            <div class="w-14 h-14 rounded-2xl bg-[#f8f9ff] border border-[#dee9fc] flex items-center justify-center p-2 shrink-0 shadow-sm overflow-hidden">
                                @if($banom->logo)
                                    <img src="{{ asset('storage/' . $banom->logo) }}" alt="{{ $banom->singkatan }}" class="w-full h-full object-contain">
                                @else
                                    <span class="text-sm font-black text-[#004125]">{{ $banom->singkatan }}</span>
                                @endif
                            </div>
                            <div>
                                <div class="flex items-center gap-1.5">
                                    <h3 class="text-lg font-black text-[#004125]">{{ $banom->singkatan }}</h3>
                                    <span class="text-[10px] font-mono px-2 py-0.5 rounded bg-gray-100 text-gray-600 font-bold" title="Urutan Tampilan">
                                        #{{ $banom->urutan }}
                                    </span>
                                </div>
                                <p class="text-xs text-[#526350] line-clamp-1 font-semibold">{{ $banom->nama }}</p>
                            </div>
                        </div>

                        <span class="px-2.5 py-1 rounded-full text-[10px] font-extrabold uppercase border {{ $banom->is_active ? 'bg-emerald-50 text-emerald-800 border-emerald-200' : 'bg-gray-100 text-gray-600 border-gray-200' }}">
                            {{ $banom->is_active ? 'Aktif' : 'Nonaktif' }}
                        </span>
                    </div>

                    <!-- Description -->
                    <p class="text-xs text-[#404942] line-clamp-2 leading-relaxed">
                        {{ $banom->deskripsi ?: 'Belum ada deskripsi profil untuk badan otonom ini.' }}
                    </p>

                    <!-- Metric Box -->
                    <div class="grid grid-cols-2 gap-3 py-3 px-4 rounded-2xl bg-[#f8f9ff] border border-[#e6eeff] text-center">
                        <div>
                            <span class="text-[10px] font-bold text-[#707971] uppercase tracking-wider block">Pengurus</span>
                            <span class="text-base font-black text-[#004125]">{{ $banom->banom_officers_count }} Personil</span>
                        </div>
                        <div>
                            <span class="text-[10px] font-bold text-[#707971] uppercase tracking-wider block">Kader Terdata</span>
                            <span class="text-base font-black text-gray-800">{{ $banom->members_count }} Anggota</span>
                        </div>
                    </div>
                </div>

                <!-- Action Footer -->
                <div class="pt-4 border-t border-[#f2f4f8] space-y-2">
                    <!-- Tombol Utama: Kelola Pengurus -->
                    <a href="{{ route('admin.banoms.officers.index', $banom->id) }}" class="w-full py-2.5 px-4 rounded-xl bg-[#0c5a37] hover:bg-[#004125] text-white font-extrabold text-xs flex items-center justify-center gap-1.5 shadow-sm transition">
                        <span class="material-symbols-outlined text-[16px] text-[#fe932c]">groups</span>
                        <span>Kelola Pengurus ({{ $banom->banom_officers_count }})</span>
                    </a>

                    <div class="grid grid-cols-3 gap-1.5">
                        <a href="{{ route('admin.banoms.show', $banom->id) }}" class="py-2 px-2.5 rounded-lg bg-gray-100 hover:bg-gray-200 text-gray-800 font-bold text-[11px] flex items-center justify-center gap-1 transition" title="Lihat Detail Profil & Pengurus">
                            <span class="material-symbols-outlined text-[14px]">visibility</span>
                            <span>Detail</span>
                        </a>

                        <a href="{{ route('admin.banoms.edit', $banom->id) }}" class="py-2 px-2.5 rounded-lg bg-emerald-50 hover:bg-emerald-100 text-emerald-800 font-bold text-[11px] flex items-center justify-center gap-1 transition" title="Edit Profil Banom">
                            <span class="material-symbols-outlined text-[14px]">edit</span>
                            <span>Edit</span>
                        </a>

                        <form action="{{ route('admin.banoms.destroy', $banom->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus Banom {{ $banom->singkatan }}? Semua pengurus di dalamnya juga akan terhapus.');" class="w-full">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="w-full py-2 px-2.5 rounded-lg bg-red-50 hover:bg-red-100 text-red-700 font-bold text-[11px] flex items-center justify-center gap-1 transition" title="Hapus Banom">
                                <span class="material-symbols-outlined text-[14px]">delete</span>
                                <span>Hapus</span>
                            </button>
                        </form>
                    </div>
                </div>

            </div>
        @empty
            <div class="col-span-3 bg-white p-12 rounded-3xl border border-[#e6eeff] text-center text-gray-400">
                <span class="material-symbols-outlined text-4xl mb-2 text-gray-300">account_tree</span>
                <p class="text-sm">Tidak ada Badan Otonom yang ditemukan.</p>
            </div>
        @endforelse
    </div>

    @if($banoms->hasPages())
        <div class="bg-white p-4 rounded-2xl border border-[#e6eeff] shadow-sm">
            {{ $banoms->links() }}
        </div>
    @endif

</div>
@endsection
