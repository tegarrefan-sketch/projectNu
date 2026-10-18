@extends('layouts.admin')

@section('title', 'Bagian (Bidang / Departemen / Seksi) — SIMNU Admin')

@section('content')
<div class="space-y-6">

    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 bg-white p-6 rounded-2xl border border-[#e6eeff] shadow-sm">
        <div>
            <nav class="flex items-center gap-2 text-xs text-[#707971] mb-1">
                <span>SIMNU Admin</span>
                <span>/</span>
                <span class="text-[#004125] font-semibold">Bagian Organisasi</span>
            </nav>
            <h1 class="text-2xl font-black text-[#004125] tracking-tight">Bagian (Bidang / Departemen / Seksi / Unit)</h1>
            <p class="text-xs text-[#526350] mt-0.5">Kelola nama-nama bidang kerja, unit biro, departemen, dan seksi pada masing-masing Badan Otonom.</p>
        </div>

        @if($selectedBanom)
            <a href="{{ route('admin.divisions.create', ['banom_id' => $selectedBanom->id]) }}" class="w-full sm:w-auto min-h-[44px] inline-flex items-center justify-center gap-2 px-5 py-2.5 rounded-xl bg-[#0c5a37] hover:bg-[#004125] text-white text-xs font-extrabold shadow-sm hover:shadow transition">
                <span class="material-symbols-outlined text-[18px]">add_circle</span>
                <span>Tambah Bagian Baru</span>
            </a>
        @endif
    </div>

    <!-- Alert Note Sesuai Regulasi -->
    <div class="p-4 bg-amber-50 rounded-2xl border border-amber-200 flex items-start gap-3">
        <span class="material-symbols-outlined text-amber-700 text-[20px] shrink-0 mt-0.5">info</span>
        <div class="text-xs text-amber-900 leading-relaxed">
            <span class="font-bold">Catatan Penataan Organisasi:</span> Nama bidang dapat disesuaikan dengan SK pengurus ranting. Admin dapat menambah, mengubah, mengurutkan, dan menghapus bidang/departemen/seksi sesuai kebutuhan masing-masing banom.
        </div>
    </div>

    <!-- Banom Selector Tabs -->
    <div class="bg-white p-4 rounded-2xl border border-[#e6eeff] shadow-sm">
        <div class="text-xs font-bold text-[#526350] mb-3 px-1">Pilih Organisasi / Badan Otonom:</div>
        <div class="flex flex-wrap items-center gap-2">
            @foreach($banoms as $b)
                <a href="{{ route('admin.divisions.index', ['banom_id' => $b->id]) }}" class="px-4 py-2 rounded-xl text-xs font-black transition-all flex items-center gap-2 {{ ($selectedBanom && $selectedBanom->id === $b->id) ? 'bg-[#004125] text-white shadow-sm' : 'bg-[#f8f9ff] text-gray-700 hover:bg-[#eff4ff] border border-[#dee9fc]' }}">
                    <span>{{ $b->singkatan }}</span>
                    <span class="text-[10px] px-1.5 py-0.2 rounded-full {{ ($selectedBanom && $selectedBanom->id === $b->id) ? 'bg-white/20 text-white' : 'bg-gray-200 text-gray-700' }}">
                        {{ $b->label_bagian ?? 'Bidang' }}
                    </span>
                </a>
            @endforeach
        </div>
    </div>

    <!-- Divisions Table for Selected Banom -->
    @if($selectedBanom)
        <div class="bg-white rounded-2xl border border-[#e6eeff] shadow-sm overflow-hidden p-6 space-y-4">
            <div class="flex items-center justify-between pb-3 border-b border-gray-100">
                <div>
                    <h3 class="text-base font-black text-[#004125]">Daftar {{ $selectedBanom->label_bagian ?? 'Bidang' }} di {{ $selectedBanom->nama }} ({{ $selectedBanom->singkatan }})</h3>
                    <p class="text-xs text-[#707971]">Label Bagian: <span class="font-bold text-[#004125]">{{ $selectedBanom->label_bagian ?? 'Bidang' }}</span></p>
                </div>

                <a href="{{ route('admin.divisions.create', ['banom_id' => $selectedBanom->id]) }}" class="px-3.5 py-2 rounded-xl bg-emerald-50 text-[#004125] hover:bg-emerald-100 text-xs font-bold transition flex items-center gap-1.5">
                    <span class="material-symbols-outlined text-[16px]">add</span>
                    <span>Tambah {{ $selectedBanom->label_bagian ?? 'Bagian' }}</span>
                </a>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse text-xs">
                    <thead>
                        <tr class="bg-[#f8f9ff] border-b border-[#e6eeff] text-[11px] font-black uppercase tracking-wider text-[#526350]">
                            <th class="py-3 px-4 w-16 text-center">Urutan</th>
                            <th class="py-3 px-4">Nama {{ $selectedBanom->label_bagian ?? 'Bagian' }}</th>
                            <th class="py-3 px-4">Deskripsi / Catatan</th>
                            <th class="py-3 px-4 text-center">Pengurus Aktif</th>
                            <th class="py-3 px-4 text-right w-32">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-[#f2f4f8]">
                        @forelse($divisions as $div)
                            <tr class="hover:bg-[#fafcff] transition-colors">
                                <td class="py-3 px-4 text-center">
                                    <span class="w-7 h-7 rounded-lg bg-gray-100 font-mono font-bold text-[#004125] inline-flex items-center justify-center text-xs">
                                        {{ $div->urutan }}
                                    </span>
                                </td>
                                <td class="py-3 px-4">
                                    <span class="font-extrabold text-[#121c2a] text-sm">{{ $div->nama }}</span>
                                </td>
                                <td class="py-3 px-4 text-gray-500">
                                    {{ $div->deskripsi ?: '-' }}
                                </td>
                                <td class="py-3 px-4 text-center">
                                    @if($div->officers_count > 0)
                                        <span class="px-2.5 py-0.5 rounded-full text-xs font-bold bg-emerald-50 text-emerald-800 border border-emerald-200">
                                            {{ $div->officers_count }} Orang
                                        </span>
                                    @else
                                        <span class="px-2.5 py-0.5 rounded-full text-xs font-semibold bg-gray-100 text-gray-400">
                                            0 Orang
                                        </span>
                                    @endif
                                </td>
                                <td class="py-3 px-4 text-right">
                                    <div class="flex items-center justify-end gap-1.5">
                                        <a href="{{ route('admin.divisions.edit', $div->id) }}" class="p-1.5 rounded-lg text-emerald-700 hover:bg-emerald-50 transition" title="Edit Bagian">
                                            <span class="material-symbols-outlined text-[18px]">edit</span>
                                        </a>

                                        <form action="{{ route('admin.divisions.destroy', $div->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus bagian {{ $div->nama }}?');" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="p-1.5 rounded-lg text-red-600 hover:bg-red-50 transition" title="Hapus Bagian">
                                                <span class="material-symbols-outlined text-[18px]">delete</span>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="py-10 text-center text-gray-400">
                                    Belum ada {{ strtolower($selectedBanom->label_bagian ?? 'bagian') }} yang ditambahkan untuk {{ $selectedBanom->singkatan }}.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    @endif

</div>
@endsection
