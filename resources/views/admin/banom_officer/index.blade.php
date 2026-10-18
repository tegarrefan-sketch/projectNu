@extends('layouts.admin')

@section('title', 'Kelola Pengurus — ' . $banom->singkatan . ' — SIMNU Admin')

@section('content')
<div class="space-y-6">

    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 bg-white p-6 rounded-2xl border border-[#e6eeff] shadow-sm">
        <div>
            <nav class="flex items-center gap-2 text-xs text-[#707971] mb-1">
                <a href="{{ route('admin.banoms.index') }}" class="hover:underline">Struktur Organisasi</a>
                <span>/</span>
                <span class="text-[#004125] font-semibold">{{ $banom->singkatan }}</span>
                <span>/</span>
                <span class="text-gray-400">Pengurus</span>
            </nav>
            <h1 class="text-2xl font-black text-[#004125] tracking-tight">Pengurus {{ $banom->nama }} ({{ $banom->singkatan }})</h1>
            <p class="text-xs text-[#526350] font-medium mt-0.5">Susunan resmi organisasi dan jabatan</p>
        </div>

        <div class="flex flex-wrap items-center gap-2">
            <a href="{{ route('admin.banoms.officers.bulk-create', $banom->id) }}" class="inline-flex items-center gap-1.5 px-4 py-2.5 rounded-xl bg-emerald-50 hover:bg-emerald-100 text-[#004125] border border-emerald-300 text-xs font-black shadow-xs transition">
                <span class="material-symbols-outlined text-[18px]">group_add</span>
                <span>Tambah Banyak Sekaligus</span>
            </a>

            <a href="{{ route('admin.banoms.officers.create', $banom->id) }}" class="inline-flex items-center gap-1.5 px-5 py-2.5 rounded-xl bg-[#0c5a37] hover:bg-[#004125] text-white text-xs font-black shadow-sm transition">
                <span class="material-symbols-outlined text-[18px]">person_add</span>
                <span>Tambah Pengurus Baru</span>
            </a>
        </div>
    </div>

    <!-- Teks Bantuan Singkat / Info Banner -->
    <div class="p-3.5 bg-emerald-50 border border-emerald-200 rounded-2xl flex items-center gap-3 text-xs text-[#004125]">
        <span class="material-symbols-outlined text-emerald-700 text-xl shrink-0">verified_user</span>
        <div>
            <span class="font-bold">Susunan resmi organisasi dan jabatan:</span>
            <span class="text-emerald-900"> Pengurus yang didaftarkan dan diaktifkan di sini akan otomatis terhubung ke KTA anggota (format: <em>Jabatan - Organisasi</em>) dan tunduk pada aturan kuota resmi (maksimal 1 Ketua/Rais).</span>
        </div>
    </div>

    <!-- Banom Switcher Strip -->
    <div class="bg-white p-4 rounded-2xl border border-[#e6eeff] shadow-sm">
        <div class="text-[11px] font-bold text-[#526350] mb-2 px-1">Pilih Organisasi / Badan Otonom:</div>
        <div class="flex flex-wrap items-center gap-2">
            @foreach($allBanoms as $b)
                <a href="{{ route('admin.banoms.officers.index', $b->id) }}" class="px-3.5 py-2 rounded-xl text-xs font-black transition-all flex items-center gap-2 {{ ($banom->id === $b->id) ? 'bg-[#004125] text-white shadow-sm' : 'bg-[#f8f9ff] text-gray-700 hover:bg-[#eff4ff] border border-[#dee9fc]' }}">
                    <span>{{ $b->singkatan }}</span>
                    <span class="text-[10px] px-1.5 py-0.2 rounded-full {{ ($banom->id === $b->id) ? 'bg-white/20 text-white' : 'bg-gray-200 text-gray-700' }}">
                        {{ $b->banomOfficers()->where('is_active', true)->count() }}
                    </span>
                </a>
            @endforeach
        </div>
    </div>

    <!-- Quick Stats Strip -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
        <div class="bg-white p-4 rounded-2xl border border-[#e6eeff] shadow-sm flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl bg-emerald-50 text-[#004125] flex items-center justify-center font-black">
                <span class="material-symbols-outlined text-[22px]">groups</span>
            </div>
            <div>
                <span class="text-[11px] text-[#707971] font-semibold block">Total Terdaftar</span>
                <span class="text-lg font-black text-[#121c2a]">{{ $officers->count() }} Personil</span>
            </div>
        </div>

        <div class="bg-white p-4 rounded-2xl border border-[#e6eeff] shadow-sm flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl bg-green-50 text-green-700 flex items-center justify-center font-black">
                <span class="material-symbols-outlined text-[22px]">check_circle</span>
            </div>
            <div>
                <span class="text-[11px] text-[#707971] font-semibold block">Status Aktif</span>
                <span class="text-lg font-black text-green-700">{{ $officers->where('is_active', true)->count() }} Orang</span>
            </div>
        </div>

        <div class="bg-white p-4 rounded-2xl border border-[#e6eeff] shadow-sm flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl bg-amber-50 text-amber-700 flex items-center justify-center font-black">
                <span class="material-symbols-outlined text-[22px]">workspace_premium</span>
            </div>
            <div>
                <span class="text-[11px] text-[#707971] font-semibold block">Jabatan Terisi</span>
                <span class="text-lg font-black text-amber-700">{{ $groupedOfficers->count() }} Posisi</span>
            </div>
        </div>
    </div>

    <!-- Jabatan Inti yang Belum Terisi -->
    @if($emptyCorePositions->isNotEmpty())
        <div class="bg-amber-50/70 border border-amber-200 rounded-2xl p-5 space-y-3">
            <div class="flex items-center gap-2">
                <span class="material-symbols-outlined text-[20px] text-amber-700">warning</span>
                <h3 class="text-xs font-black text-amber-900 uppercase tracking-wider">Jabatan Inti Belum Terisi</h3>
            </div>
            <p class="text-xs text-amber-800">Terdapat posisi inti yang belum memiliki pejabat aktif di {{ $banom->singkatan }}:</p>
            <div class="flex flex-wrap items-center gap-2 pt-1">
                @foreach($emptyCorePositions as $emptyPos)
                    <div class="inline-flex items-center gap-2 bg-white px-3 py-1.5 rounded-xl border border-amber-300 shadow-xs text-xs">
                        <span class="font-bold text-gray-800">{{ $emptyPos->nama }}</span>
                        <span class="text-[10px] text-red-600 font-extrabold bg-red-50 px-2 py-0.5 rounded">Belum terisi</span>
                        <a href="{{ route('admin.banoms.officers.create', ['banom' => $banom->id, 'position_id' => $emptyPos->id]) }}" class="inline-flex items-center gap-1 text-[11px] font-black text-white bg-[#0c5a37] hover:bg-[#004125] px-2.5 py-1 rounded-lg transition">
                            <span class="material-symbols-outlined text-[13px]">add</span>
                            <span>Isi</span>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    @endif

    <!-- Search & Filter Bar -->
    <div class="bg-white p-5 rounded-2xl border border-[#e6eeff] shadow-sm">
        <form action="{{ route('admin.banoms.officers.index', $banom->id) }}" method="GET" class="flex flex-col sm:flex-row items-center justify-between gap-4">
            <div class="w-full sm:w-72 relative">
                <span class="material-symbols-outlined absolute left-3.5 top-1/2 -translate-y-1/2 text-gray-400 text-[20px]">search</span>
                <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari nama pengurus..." class="w-full pl-11 pr-4 py-2.5 rounded-xl text-xs bg-[#f8f9ff] border border-[#dee9fc] focus:bg-white focus:outline-none focus:border-[#004125]">
            </div>

            <div class="flex flex-wrap items-center gap-3 w-full sm:w-auto">
                <select name="position_id" onchange="this.form.submit()" class="bg-[#f8f9ff] border border-[#dee9fc] rounded-xl px-3 py-2 text-xs font-semibold text-[#121c2a] focus:outline-none focus:border-[#004125]">
                    <option value="">Semua Jabatan</option>
                    @foreach($positions as $p)
                        <option value="{{ $p->id }}" {{ request('position_id') == $p->id ? 'selected' : '' }}>{{ $p->nama }}</option>
                    @endforeach
                </select>

                @if($divisions->isNotEmpty())
                    <select name="division_id" onchange="this.form.submit()" class="bg-[#f8f9ff] border border-[#dee9fc] rounded-xl px-3 py-2 text-xs font-semibold text-[#121c2a] focus:outline-none focus:border-[#004125]">
                        <option value="">Semua {{ $banom->label_bagian ?? 'Bagian' }}</option>
                        @foreach($divisions as $d)
                            <option value="{{ $d->id }}" {{ request('division_id') == $d->id ? 'selected' : '' }}>{{ $d->nama }}</option>
                        @endforeach
                    </select>
                @endif

                @if(request()->hasAny(['q', 'position_id', 'division_id']))
                    <a href="{{ route('admin.banoms.officers.index', $banom->id) }}" class="px-3 py-2 rounded-xl bg-gray-100 hover:bg-gray-200 text-gray-700 text-xs font-bold transition">
                        Reset
                    </a>
                @endif
            </div>
        </form>
    </div>

    <!-- Main List of Officers (Grouped by Position) -->
    <div class="bg-white rounded-3xl border border-[#e6eeff] shadow-sm overflow-hidden p-6 sm:p-8 space-y-6">
        
        <form id="bulkForm" action="{{ route('admin.banoms.officers.bulk-action', $banom->id) }}" method="POST">
            @csrf
            
            <!-- Toolbar Aksi Massal & Simpan Urutan -->
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-4 border-b border-gray-100">
                <div class="flex flex-wrap items-center gap-3">
                    <label class="flex items-center gap-2 cursor-pointer text-xs font-bold text-gray-700 min-h-[44px]">
                        <input type="checkbox" id="selectAllCheckbox" onchange="toggleSelectAll(this)" class="w-4 h-4 rounded text-[#0c5a37] focus:ring-[#004125] border-gray-300">
                        <span>Pilih Semua</span>
                    </label>

                    <div class="flex flex-wrap items-center gap-1.5 sm:pl-3 sm:border-l border-gray-200">
                        <select name="action" id="bulkActionSelect" class="bg-[#f8f9ff] border border-[#dee9fc] rounded-xl px-3 py-2 text-xs font-semibold text-[#121c2a] focus:outline-none focus:border-[#004125] min-h-[44px]">
                            <option value="">-- Aksi Massal --</option>
                            <option value="activate">Aktifkan Terpilih</option>
                            <option value="deactivate">Nonaktifkan Terpilih</option>
                            <option value="delete">Hapus Terpilih</option>
                        </select>
                        <button type="submit" onclick="return confirmBulkAction()" class="px-4 py-2 rounded-xl bg-[#0c5a37] text-white text-xs font-bold hover:bg-[#004125] transition min-h-[44px]">
                            Terapkan
                        </button>
                    </div>
                </div>

                <button type="button" onclick="submitReorder()" class="w-full sm:w-auto px-4 py-2.5 rounded-xl border border-emerald-300 text-[#004125] bg-emerald-50 hover:bg-emerald-100 text-xs font-black flex items-center justify-center gap-1.5 transition min-h-[44px]">
                    <span class="material-symbols-outlined text-[16px]">sort</span>
                    <span>Simpan Perubahan Urutan</span>
                </button>
            </div>

            <!-- Grouped Officers List -->
            @if($groupedOfficers->isEmpty())
                <div class="py-16 text-center text-gray-400 space-y-3">
                    <span class="material-symbols-outlined text-5xl text-gray-300">groups</span>
                    <p class="text-sm font-semibold">Belum ada pengurus yang terdaftar untuk {{ $banom->singkatan }}.</p>
                    <div class="flex items-center justify-center gap-2 pt-2">
                        <a href="{{ route('admin.banoms.officers.create', $banom->id) }}" class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl bg-[#0c5a37] text-white text-xs font-bold shadow hover:bg-[#004125] transition">
                            <span class="material-symbols-outlined text-[16px]">add</span>
                            <span>Tambah Pengurus Pertama</span>
                        </a>
                        <a href="{{ route('admin.banoms.officers.bulk-create', $banom->id) }}" class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl bg-emerald-100 text-[#004125] text-xs font-bold hover:bg-emerald-200 transition">
                            <span class="material-symbols-outlined text-[16px]">group_add</span>
                            <span>Tambah Banyak Sekaligus</span>
                        </a>
                    </div>
                </div>
            @else
                <div class="space-y-8 pt-4">
                    @foreach($groupedOfficers as $positionName => $officerList)
                        <div class="space-y-3">
                            @php
                                $posObj = $officerList->first()->position;
                                $activeInGroup = $officerList->where('is_active', true)->count();
                                $inactiveInGroup = $officerList->where('is_active', false)->count();
                                $maksKuota = $posObj?->maks_orang;
                                $isFullGroup = (!is_null($maksKuota) && $posObj?->kategori !== 'Bidang' && $activeInGroup >= $maksKuota);
                            @endphp
                            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2 bg-[#f8f9ff] px-4 py-2.5 rounded-xl border border-[#dee9fc]">
                                <div class="flex flex-wrap items-center gap-2">
                                    <span class="material-symbols-outlined text-[18px] text-[#0c5a37]">military_tech</span>
                                    <h3 class="text-xs font-black text-[#004125] uppercase tracking-wider">{{ $positionName }}</h3>
                                    <span class="text-[10px] font-bold text-gray-500">
                                        ({{ $activeInGroup }} Aktif{{ $inactiveInGroup > 0 ? ', ' . $inactiveInGroup . ' Nonaktif' : '' }}
                                        @if($posObj?->isBatasKeras())
                                            • Batas Keras {{ $maksKuota ?? 1 }} orang
                                        @elseif($posObj?->hasAnjuran())
                                            • Anjuran: {{ $posObj->anjuran_maks }} orang
                                        @else
                                            • Tanpa Batas
                                        @endif
                                        )
                                    </span>
                                </div>
                                <div class="flex items-center gap-2">
                                    @if($isFullGroup)
                                        <span class="text-[10px] font-black text-amber-800 bg-amber-100 border border-amber-300 px-2.5 py-0.5 rounded-full">
                                            Batas Tercapai
                                        </span>
                                    @endif
                                    <span class="text-[10px] font-bold text-gray-700 bg-gray-100 px-2 py-0.5 rounded-full">
                                        {{ $posObj->tipe ? ucfirst($posObj->tipe) : 'Umum' }}
                                    </span>
                                </div>
                            </div>

                            <!-- Mobile Stacked Card View (sm:hidden) -->
                            <div class="sm:hidden space-y-3">
                                @foreach($officerList as $officer)
                                    <div class="bg-white rounded-2xl p-4 border border-[#e6eeff] shadow-xs space-y-3">
                                        <!-- Header Card: Checkbox + Avatar + Nama & NIA -->
                                        <div class="flex items-start gap-3">
                                            <div class="pt-1">
                                                <input type="checkbox" name="officer_ids[]" value="{{ $officer->id }}" class="officer-checkbox w-5 h-5 rounded text-[#0c5a37] focus:ring-[#004125] border-gray-300">
                                            </div>
                                            <div class="w-12 h-12 rounded-xl bg-gray-100 border border-gray-200 overflow-hidden flex items-center justify-center text-gray-400 shrink-0">
                                                @if($officer->display_foto)
                                                    <img src="{{ $officer->display_foto }}" alt="{{ $officer->display_nama }}" loading="lazy" class="w-full h-full object-cover">
                                                @else
                                                    <span class="material-symbols-outlined text-[24px]">person</span>
                                                @endif
                                            </div>
                                            <div class="min-w-0 flex-1">
                                                <div class="font-extrabold text-[#121c2a] text-sm break-words">
                                                    {{ $officer->display_nama }}
                                                    @if($officer->urutan_wakil)
                                                        <span class="text-[10px] font-mono text-emerald-800 bg-emerald-50 px-1.5 py-0.2 rounded font-bold">
                                                            Ke-{{ $officer->urutan_wakil }}
                                                        </span>
                                                    @endif
                                                </div>
                                                @if($officer->member)
                                                    <div class="text-[11px] text-gray-500 font-mono mt-0.5">
                                                        NIA: {{ $officer->member->nomor_anggota }}
                                                    </div>
                                                @else
                                                    <span class="text-[9px] text-amber-700 bg-amber-50 px-1.5 py-0.2 rounded font-bold">Manual</span>
                                                @endif
                                            </div>
                                        </div>

                                        <!-- Detail Grid: Label di Kiri, Isi di Kanan -->
                                        <div class="bg-[#f8f9ff] rounded-xl p-3 border border-[#dee9fc] divide-y divide-gray-100 text-xs">
                                            <div class="flex items-center justify-between py-1.5">
                                                <span class="text-gray-500 font-medium">{{ $banom->label_bagian ?? 'Bidang / Seksi' }}:</span>
                                                <span class="font-bold text-[#fe932c] text-right">
                                                    @if($officer->division)
                                                        {{ $officer->division->nama }}
                                                    @elseif($officer->bidang)
                                                        {{ $officer->bidang }}
                                                    @else
                                                        -
                                                    @endif
                                                </span>
                                            </div>
                                            <div class="flex items-center justify-between py-1.5">
                                                <span class="text-gray-500 font-medium">Status:</span>
                                                <span class="px-2.5 py-0.5 rounded-full text-[10px] font-extrabold uppercase border {{ $officer->is_active ? 'bg-emerald-50 text-emerald-800 border-emerald-200' : 'bg-gray-100 text-gray-500 border-gray-200' }}">
                                                    {{ $officer->is_active ? 'Aktif' : 'Nonaktif' }}
                                                </span>
                                            </div>
                                            <div class="flex items-center justify-between py-1.5">
                                                <span class="text-gray-500 font-medium">Urutan Tampilan:</span>
                                                <div class="flex items-center gap-1.5">
                                                    <input type="number" name="orders[{{ $officer->id }}]" value="{{ $officer->urutan }}" class="order-input w-16 px-2 py-1 text-center font-mono text-xs rounded-lg border border-gray-300 bg-white focus:outline-none focus:border-[#004125]">
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Action Buttons: Easy touch (>= 44px) -->
                                        <div class="grid grid-cols-2 gap-2 pt-1">
                                            <a href="{{ route('admin.banoms.officers.edit', [$banom->id, $officer->id]) }}" class="min-h-[44px] rounded-xl bg-emerald-50 hover:bg-emerald-100 text-[#004125] font-bold text-xs flex items-center justify-center gap-1.5 border border-emerald-200 transition">
                                                <span class="material-symbols-outlined text-[18px]">edit</span>
                                                <span>Edit</span>
                                            </a>

                                            <form action="{{ route('admin.banoms.officers.destroy', [$banom->id, $officer->id]) }}" method="POST" onsubmit="return confirm('Hapus pengurus {{ $officer->display_nama }}?');" class="w-full">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="w-full min-h-[44px] rounded-xl bg-red-50 hover:bg-red-100 text-red-600 font-bold text-xs flex items-center justify-center gap-1.5 border border-red-200 transition">
                                                    <span class="material-symbols-outlined text-[18px]">delete</span>
                                                    <span>Hapus</span>
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            <!-- Desktop & Tablet Table (hidden sm:block) -->
                            <div class="hidden sm:block overflow-x-auto rounded-xl border border-gray-100">
                                <table class="w-full text-left border-collapse text-xs">
                                    <thead>
                                        <tr class="bg-gray-50 border-b border-gray-100 text-[10px] uppercase font-bold text-gray-500 tracking-wider">
                                            <th class="py-2.5 px-3 w-10 text-center">Pilih</th>
                                            <th class="py-2.5 px-3 w-14">Foto</th>
                                            <th class="py-2.5 px-3">Nama Pengurus</th>
                                            <th class="py-2.5 px-3">{{ $banom->label_bagian ?? 'Bidang / Seksi' }}</th>
                                            <th class="py-2.5 px-3 text-center w-24">Status</th>
                                            <th class="py-2.5 px-3 text-center w-28">Urutan</th>
                                            <th class="py-2.5 px-3 text-right w-24">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-100">
                                        @foreach($officerList as $officer)
                                            <tr class="hover:bg-[#fafcff] transition-colors">
                                                <td class="py-2.5 px-3 text-center">
                                                    <input type="checkbox" name="officer_ids[]" value="{{ $officer->id }}" class="officer-checkbox w-4 h-4 rounded text-[#0c5a37] focus:ring-[#004125] border-gray-300">
                                                </td>
                                                <td class="py-2.5 px-3">
                                                    <div class="w-10 h-10 rounded-xl bg-gray-100 border border-gray-200 overflow-hidden flex items-center justify-center text-gray-400 shrink-0">
                                                        @if($officer->display_foto)
                                                            <img src="{{ $officer->display_foto }}" alt="{{ $officer->display_nama }}" loading="lazy" class="w-full h-full object-cover">
                                                        @else
                                                            <span class="material-symbols-outlined text-[20px]">person</span>
                                                        @endif
                                                    </div>
                                                </td>
                                                <td class="py-2.5 px-3">
                                                    <div class="font-extrabold text-[#121c2a] text-xs break-words">
                                                        {{ $officer->display_nama }}
                                                        @if($officer->urutan_wakil)
                                                            <span class="text-[10px] font-mono text-emerald-800 bg-emerald-50 px-1.5 py-0.2 rounded font-bold">
                                                                Ke-{{ $officer->urutan_wakil }}
                                                            </span>
                                                        @endif
                                                    </div>
                                                    @if($officer->member)
                                                        <div class="text-[10px] text-gray-400 font-mono flex items-center gap-1">
                                                            <span>NIA: {{ $officer->member->nomor_anggota }}</span>
                                                        </div>
                                                    @else
                                                        <span class="text-[9px] text-amber-700 bg-amber-50 px-1.5 py-0.2 rounded font-bold">Manual</span>
                                                    @endif
                                                </td>
                                                <td class="py-2.5 px-3">
                                                    @if($officer->division)
                                                        <span class="font-bold text-[#fe932c] text-xs bg-orange-50 px-2 py-0.5 rounded-md border border-orange-200">
                                                            {{ $officer->division->nama }}
                                                        </span>
                                                    @elseif($officer->bidang)
                                                        <span class="font-bold text-[#fe932c] text-xs bg-orange-50 px-2 py-0.5 rounded-md border border-orange-200">
                                                            {{ $officer->bidang }}
                                                        </span>
                                                    @else
                                                        <span class="text-gray-300 italic">-</span>
                                                    @endif
                                                </td>
                                                <td class="py-2.5 px-3 text-center">
                                                    <span class="px-2 py-0.5 rounded-full text-[10px] font-extrabold uppercase border {{ $officer->is_active ? 'bg-emerald-50 text-emerald-800 border-emerald-200' : 'bg-gray-100 text-gray-500 border-gray-200' }}">
                                                        {{ $officer->is_active ? 'Aktif' : 'Nonaktif' }}
                                                    </span>
                                                </td>
                                                <td class="py-2.5 px-3 text-center">
                                                    <input type="number" name="orders[{{ $officer->id }}]" value="{{ $officer->urutan }}" class="order-input w-16 px-2 py-1 text-center font-mono text-xs rounded-lg border border-gray-200 bg-[#f8f9ff] focus:bg-white focus:outline-none focus:border-[#004125]">
                                                </td>
                                                <td class="py-2.5 px-3 text-right">
                                                    <div class="flex items-center justify-end gap-1">
                                                        <a href="{{ route('admin.banoms.officers.edit', [$banom->id, $officer->id]) }}" class="p-1.5 rounded text-emerald-700 hover:bg-emerald-50 transition" title="Edit Pengurus">
                                                            <span class="material-symbols-outlined text-[16px]">edit</span>
                                                        </a>

                                                        <form action="{{ route('admin.banoms.officers.destroy', [$banom->id, $officer->id]) }}" method="POST" onsubmit="return confirm('Hapus pengurus {{ $officer->display_nama }}?');" class="inline">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="p-1.5 rounded text-red-600 hover:bg-red-50 transition" title="Hapus">
                                                                <span class="material-symbols-outlined text-[16px]">delete</span>
                                                            </button>
                                                        </form>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif

        </form>

        <!-- Form Tersembunyi untuk Simpan Urutan -->
        <form id="reorderForm" action="{{ route('admin.banoms.officers.reorder', $banom->id) }}" method="POST" class="hidden">
            @csrf
            <div id="reorderInputs"></div>
        </form>

    </div>

</div>

@push('scripts')
<script>
    function toggleSelectAll(master) {
        document.querySelectorAll('.officer-checkbox').forEach(cb => {
            cb.checked = master.checked;
        });
    }

    function confirmBulkAction() {
        const action = document.getElementById('bulkActionSelect').value;
        const selected = document.querySelectorAll('.officer-checkbox:checked').length;

        if (!action) {
            alert('Pilih aksi massal terlebih dahulu.');
            return false;
        }

        if (selected === 0) {
            alert('Pilih minimal satu pengurus.');
            return false;
        }

        if (action === 'delete') {
            return confirm(`Yakin ingin menghapus ${selected} pengurus terpilih? Foto lama juga akan dibersihkan.`);
        }

        return confirm(`Terapkan aksi pada ${selected} pengurus terpilih?`);
    }

    function submitReorder() {
        const inputsContainer = document.getElementById('reorderInputs');
        inputsContainer.innerHTML = '';

        let index = 0;
        document.querySelectorAll('.order-input').forEach(input => {
            const officerId = input.name.match(/\[(\d+)\]/)[1];
            const urutanVal = input.value;

            const idField = document.createElement('input');
            idField.type = 'hidden';
            idField.name = `orders[${index}][id]`;
            idField.value = officerId;
            inputsContainer.appendChild(idField);

            const urutanField = document.createElement('input');
            urutanField.type = 'hidden';
            urutanField.name = `orders[${index}][urutan]`;
            urutanField.value = urutanVal;
            inputsContainer.appendChild(urutanField);

            index++;
        });

        document.getElementById('reorderForm').submit();
    }
</script>
@endpush
@endsection
