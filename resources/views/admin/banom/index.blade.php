@extends('layouts.admin')

@section('title', 'Manajemen 5 Badan Otonom (BANOM) — SIMNU Admin')

@section('content')
<div class="space-y-6">

    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <div class="flex items-center gap-2">
                <span class="px-2.5 py-0.5 rounded-full text-xs font-bold uppercase tracking-wider bg-emerald-100 text-[#004125]">
                    Sayap Organisasi
                </span>
            </div>
            <h1 class="text-2xl font-black text-[#004125] mt-1">Badan Otonom (BANOM) Nahdlatul Ulama</h1>
            <p class="text-xs text-[#526350]">Kelola profil, visi misi, struktur kepengurusan, dan logo resmi 5 BANOM Ranting Desa Banjaranyar.</p>
        </div>

        <a href="{{ route('admin.banom.create') }}" class="px-4 py-2.5 rounded-xl bg-[#004125] hover:bg-[#0c5a37] text-white text-xs font-bold transition flex items-center gap-1.5 shadow-sm">
            <span class="material-symbols-outlined text-[16px]">add_circle</span>
            <span>Tambah BANOM</span>
        </a>
    </div>

    <!-- BANOM Cards Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($banoms as $banom)
            <div class="bg-white rounded-3xl p-6 border border-[#e6eeff] shadow-sm hover:border-emerald-300 transition-all flex flex-col justify-between space-y-5">
                
                <div class="space-y-4">
                    <!-- Card Top -->
                    <div class="flex items-start justify-between">
                        <div class="flex items-center gap-3">
                            <div class="w-12 h-12 rounded-2xl bg-[#f4fbf7] border border-emerald-100 flex items-center justify-center p-2 shrink-0 shadow-sm">
                                @if($banom->logo)
                                    <img src="{{ asset('storage/' . $banom->logo) }}" alt="{{ $banom->singkatan }}" class="w-full h-full object-contain">
                                @else
                                    <span class="text-xs font-black text-[#004125]">{{ $banom->singkatan }}</span>
                                @endif
                            </div>
                            <div>
                                <h3 class="text-base font-extrabold text-[#004125]">{{ $banom->singkatan }}</h3>
                                <p class="text-xs text-gray-500 line-clamp-1">{{ $banom->nama }}</p>
                            </div>
                        </div>

                        <span class="px-2.5 py-0.5 rounded-full text-[10px] font-extrabold uppercase {{ $banom->status === 'Aktif' ? 'bg-emerald-100 text-emerald-800' : 'bg-gray-100 text-gray-600' }}">
                            {{ $banom->status }}
                        </span>
                    </div>

                    <!-- Description -->
                    <p class="text-xs text-[#526350] line-clamp-2 leading-relaxed">
                        {{ $banom->deskripsi ?? 'Belum ada deskripsi profil untuk badan otonom ini.' }}
                    </p>

                    <!-- Counts Matrix -->
                    <div class="grid grid-cols-3 gap-2 py-3 border-y border-gray-100 text-center">
                        <div class="bg-gray-50 p-2 rounded-xl">
                            <span class="text-[10px] font-semibold text-gray-400 block">Kader</span>
                            <span class="text-sm font-black text-gray-900">{{ $banom->members_count }}</span>
                        </div>
                        <div class="bg-gray-50 p-2 rounded-xl">
                            <span class="text-[10px] font-semibold text-gray-400 block">Pengurus</span>
                            <span class="text-sm font-black text-[#004125]">{{ $banom->organization_structures_count }}</span>
                        </div>
                        <div class="bg-gray-50 p-2 rounded-xl">
                            <span class="text-[10px] font-semibold text-gray-400 block">Warta</span>
                            <span class="text-sm font-black text-gray-900">{{ $banom->posts_count }}</span>
                        </div>
                    </div>

                    <!-- Contact & Address -->
                    <div class="space-y-1 text-xs text-gray-600">
                        <div class="flex items-center gap-1.5 truncate">
                            <span class="material-symbols-outlined text-[14px] text-emerald-700">call</span>
                            <span>{{ $banom->kontak ?? 'Belum ada kontak' }}</span>
                        </div>
                        <div class="flex items-center gap-1.5 truncate text-[11px] text-gray-400">
                            <span class="material-symbols-outlined text-[14px] text-emerald-700">location_on</span>
                            <span>{{ $banom->alamat ?? 'Banjaranyar, Baureno' }}</span>
                        </div>
                    </div>
                </div>

                <!-- Card Actions -->
                <div class="pt-3 border-t border-gray-100 flex items-center justify-between gap-2">
                    <a href="{{ route('banom.show', $banom->slug) }}" target="_blank" class="text-xs font-bold text-gray-600 hover:text-emerald-800 flex items-center gap-1">
                        <span class="material-symbols-outlined text-[14px]">open_in_new</span>
                        <span>Lihat Publik</span>
                    </a>

                    <div class="flex items-center gap-1.5">
                        <a href="{{ route('admin.banom.edit', $banom->id) }}" class="px-3 py-1.5 rounded-xl bg-emerald-50 hover:bg-emerald-100 text-[#004125] text-xs font-bold transition flex items-center gap-1">
                            <span class="material-symbols-outlined text-[14px]">edit</span>
                            <span>Kelola</span>
                        </a>

                        @if($banom->members_count == 0 && $banom->organization_structures_count == 0)
                            <form action="{{ route('admin.banom.destroy', $banom->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus BANOM ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="p-1.5 rounded-xl bg-rose-50 hover:bg-rose-600 hover:text-white text-rose-700 transition" title="Hapus">
                                    <span class="material-symbols-outlined text-[14px]">delete</span>
                                </button>
                            </form>
                        @endif
                    </div>
                </div>

            </div>
        @endforeach
    </div>

</div>
@endsection
