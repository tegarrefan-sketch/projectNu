@extends('layouts.admin')

@section('title', 'Manajemen KTA Digital & Fisik — SIMNU Admin')

@section('content')
<div class="space-y-6">

    <!-- Header & Quick Info -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <div class="flex items-center gap-2">
                <span class="px-2.5 py-0.5 rounded-full text-xs font-bold uppercase tracking-wider bg-emerald-100 text-[#004125]">
                    Modul Legalitas Kader
                </span>
            </div>
            <h1 class="text-2xl font-black text-[#004125] mt-1">Kartu Tanda Anggota (KTA) Nahdlatul Ulama</h1>
            <p class="text-xs text-[#526350]">Kelola penerbitan nomor KTA otomatis, cetak kartu PVC standar ISO ID-1, serta monitoring QR Code verifikasi.</p>
        </div>

        <div class="flex items-center gap-2">
            @if($unassignedMembersCount > 0)
                <a href="{{ route('admin.anggota.index', ['has_kta' => 'no']) }}" class="px-3.5 py-2.5 rounded-xl bg-amber-500 hover:bg-amber-600 text-white text-xs font-bold transition flex items-center gap-1.5 shadow-sm">
                    <span class="material-symbols-outlined text-[16px]">pending_actions</span>
                    <span>{{ $unassignedMembersCount }} Kader Belum Ber-KTA</span>
                </a>
            @endif
        </div>
    </div>

    <!-- 4 KPI Metrics KTA -->
    <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
        <div class="bg-white rounded-2xl p-4 border border-[#e6eeff] shadow-sm">
            <span class="text-[10px] font-bold uppercase tracking-wider text-gray-400">Total KTA Terbit</span>
            <div class="text-2xl font-black text-[#004125] mt-1">{{ number_format($stats['total']) }}</div>
        </div>
        <div class="bg-white rounded-2xl p-4 border border-[#e6eeff] shadow-sm">
            <span class="text-[10px] font-bold uppercase tracking-wider text-emerald-600">KTA Aktif</span>
            <div class="text-2xl font-black text-emerald-700 mt-1">{{ number_format($stats['aktif']) }}</div>
        </div>
        <div class="bg-white rounded-2xl p-4 border border-[#e6eeff] shadow-sm">
            <span class="text-[10px] font-bold uppercase tracking-wider text-gray-500">Tidak Aktif</span>
            <div class="text-2xl font-black text-gray-700 mt-1">{{ number_format($stats['tidak_aktif']) }}</div>
        </div>
        <div class="bg-white rounded-2xl p-4 border border-[#e6eeff] shadow-sm">
            <span class="text-[10px] font-bold uppercase tracking-wider text-rose-500">Kadaluarsa</span>
            <div class="text-2xl font-black text-rose-600 mt-1">{{ number_format($stats['kadaluarsa']) }}</div>
        </div>
    </div>

    <!-- Filter & Search Console -->
    <div class="bg-white rounded-2xl p-4 sm:p-5 border border-[#e6eeff] shadow-sm">
        <form action="{{ route('admin.kta.index') }}" method="GET" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-12 gap-3 items-center">
            
            <!-- Search Text -->
            <div class="lg:col-span-4 relative">
                <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-lg">search</span>
                <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari nomor KTA, nama, atau NIA..." 
                    class="w-full pl-9 pr-3 py-2 text-xs rounded-xl border border-gray-200 focus:border-[#0c5a37] focus:ring-1 focus:ring-[#0c5a37] text-gray-800">
            </div>

            <!-- BANOM Filter -->
            <div class="lg:col-span-3">
                <select name="banom_id" class="w-full py-2 px-3 text-xs rounded-xl border border-gray-200 focus:border-[#0c5a37] text-gray-800">
                    <option value="">Semua BANOM (IPNU, Fatayat, dll)</option>
                    @foreach($banoms as $b)
                        <option value="{{ $b->id }}" {{ request('banom_id') == $b->id ? 'selected' : '' }}>
                            {{ $b->singkatan }} - {{ $b->nama }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Status Filter -->
            <div class="lg:col-span-2">
                <select name="status" class="w-full py-2 px-3 text-xs rounded-xl border border-gray-200 focus:border-[#0c5a37] text-gray-800">
                    <option value="">Semua Status</option>
                    <option value="Aktif" {{ request('status') == 'Aktif' ? 'selected' : '' }}>Aktif</option>
                    <option value="Tidak Aktif" {{ request('status') == 'Tidak Aktif' ? 'selected' : '' }}>Tidak Aktif</option>
                    <option value="Kadaluarsa" {{ request('status') == 'Kadaluarsa' ? 'selected' : '' }}>Kadaluarsa</option>
                </select>
            </div>

            <!-- Action Buttons -->
            <div class="lg:col-span-3 flex items-center gap-2">
                <button type="submit" class="flex-1 py-2 px-3 rounded-xl bg-[#004125] hover:bg-[#0c5a37] text-white text-xs font-bold transition flex items-center justify-center gap-1">
                    <span class="material-symbols-outlined text-[16px]">filter_list</span>
                    <span>Terapkan</span>
                </button>
                @if(request()->anyFilled(['q', 'banom_id', 'status', 'year']))
                    <a href="{{ route('admin.kta.index') }}" class="py-2 px-2.5 rounded-xl border border-gray-200 hover:bg-gray-50 text-gray-600 text-xs font-semibold" title="Reset Filter">
                        <span class="material-symbols-outlined text-[16px]">restart_alt</span>
                    </a>
                @endif
            </div>
        </form>
    </div>

    <!-- Main Table Card with Bulk Action Support -->
    <form id="bulkPrintForm" action="{{ route('admin.kta.bulk-print') }}" method="POST">
        @csrf
        <div class="bg-white rounded-3xl border border-[#e6eeff] shadow-sm overflow-hidden space-y-3">
            
            <!-- Table Action Toolbar -->
            <div class="p-4 sm:px-6 border-b border-gray-100 flex flex-wrap items-center justify-between gap-3 bg-[#fafcff]">
                <div class="flex items-center gap-3 text-xs font-semibold text-gray-600">
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" id="selectAllCheckbox" class="w-4 h-4 rounded text-[#0c5a37] focus:ring-[#0c5a37] border-gray-300">
                        <span>Pilih Semua Halaman Ini</span>
                    </label>
                    <span class="text-gray-300">|</span>
                    <span id="selectedCountText" class="text-[#004125] font-bold">0 KTA terpilih</span>
                </div>

                <div class="flex items-center gap-2">
                    <button type="submit" id="bulkPrintBtn" disabled
                        class="px-4 py-2 rounded-xl bg-[#0c5a37] disabled:bg-gray-300 disabled:cursor-not-allowed hover:bg-[#004125] text-white text-xs font-bold transition flex items-center gap-1.5 shadow-sm">
                        <span class="material-symbols-outlined text-[16px]">print</span>
                        <span>Cetak KTA Terpilih</span>
                    </button>
                </div>
            </div>

            <!-- Table Responsive -->
            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs">
                    <thead>
                        <tr class="border-b border-gray-100 text-[#526350] font-bold uppercase tracking-wider text-[10px] bg-gray-50/50">
                            <th class="py-3 px-4 w-10 text-center">#</th>
                            <th class="py-3 px-3">No</th>
                            <th class="py-3 px-3">Nomor KTA</th>
                            <th class="py-3 px-3">Nama Kader</th>
                            <th class="py-3 px-3">BANOM</th>
                            <th class="py-3 px-3">Terbit</th>
                            <th class="py-3 px-3">Berlaku</th>
                            <th class="py-3 px-3">Status</th>
                            <th class="py-3 px-4 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($ktas as $index => $kta)
                            <tr class="hover:bg-emerald-50/30 transition">
                                <td class="py-3 px-4 text-center">
                                    <input type="checkbox" name="kta_ids[]" value="{{ $kta->id }}" 
                                        class="kta-row-checkbox w-4 h-4 rounded text-[#0c5a37] focus:ring-[#0c5a37] border-gray-300">
                                </td>
                                <td class="py-3 px-3 text-gray-500 font-mono">
                                    {{ $ktas->firstItem() + $index }}
                                </td>
                                <td class="py-3 px-3">
                                    <div class="font-mono font-bold text-[#004125] bg-emerald-50 px-2 py-0.5 rounded-md inline-block">
                                        {{ $kta->nomor_kta }}
                                    </div>
                                    <div class="text-[10px] text-gray-400 mt-0.5">
                                        <a href="{{ route('kta.verify', $kta->nomor_kta) }}" target="_blank" class="hover:underline hover:text-emerald-800 flex items-center gap-0.5">
                                            <span class="material-symbols-outlined text-[11px]">open_in_new</span>
                                            <span>Verifikasi Publik</span>
                                        </a>
                                    </div>
                                </td>
                                <td class="py-3 px-3">
                                    <div class="font-bold text-gray-900 text-sm">
                                        {{ $kta->member->nama_lengkap ?? 'Kader Dihapus' }}
                                    </div>
                                    <div class="text-[10px] text-gray-500">
                                        NIA: {{ $kta->member->nomor_anggota ?? '-' }}
                                    </div>
                                </td>
                                <td class="py-3 px-3">
                                    <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-emerald-100 text-[#004125]">
                                        {{ $kta->member->banom->singkatan ?? '-' }}
                                    </span>
                                </td>
                                <td class="py-3 px-3 text-gray-600">
                                    {{ $kta->tanggal_terbit ? $kta->tanggal_terbit->format('d/m/Y') : '-' }}
                                </td>
                                <td class="py-3 px-3 text-gray-600">
                                    {{ $kta->tanggal_berlaku ? $kta->tanggal_berlaku->format('d/m/Y') : 'Seumur Hidup' }}
                                </td>
                                <td class="py-3 px-3">
                                    @if($kta->status === 'Aktif')
                                        <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[10px] font-extrabold bg-emerald-100 text-emerald-800">
                                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-600"></span>
                                            <span>Aktif</span>
                                        </span>
                                    @elseif($kta->status === 'Tidak Aktif')
                                        <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[10px] font-semibold bg-gray-100 text-gray-700">
                                            <span class="w-1.5 h-1.5 rounded-full bg-gray-400"></span>
                                            <span>Tidak Aktif</span>
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[10px] font-semibold bg-rose-100 text-rose-800">
                                            <span class="w-1.5 h-1.5 rounded-full bg-rose-500"></span>
                                            <span>Kadaluarsa</span>
                                        </span>
                                    @endif
                                </td>
                                <td class="py-3 px-4 text-right">
                                    <div class="flex items-center justify-end gap-1.5">
                                        <!-- Show / Interactive Studio -->
                                        <a href="{{ route('admin.kta.show', $kta->id) }}" class="p-1.5 rounded-lg bg-gray-100 hover:bg-emerald-100 text-[#004125] transition" title="Lihat Kartu 3D & Detil">
                                            <span class="material-symbols-outlined text-[16px]">visibility</span>
                                        </a>

                                        <!-- Direct Print Single -->
                                        <a href="{{ route('admin.kta.print', $kta->id) }}" target="_blank" class="p-1.5 rounded-lg bg-emerald-50 hover:bg-emerald-600 hover:text-white text-emerald-800 transition" title="Cetak KTA Satuan (PVC)">
                                            <span class="material-symbols-outlined text-[16px]">print</span>
                                        </a>

                                        <!-- Download PDF -->
                                        <a href="{{ route('admin.kta.download', $kta->id) }}" class="p-1.5 rounded-lg bg-blue-50 hover:bg-blue-600 hover:text-white text-blue-800 transition" title="Unduh PDF / File Cetak">
                                            <span class="material-symbols-outlined text-[16px]">download</span>
                                        </a>

                                        <!-- Nonaktifkan / Revoke form -->
                                        <button type="button" onclick="confirmDeleteKta('{{ $kta->id }}', '{{ $kta->nomor_kta }}')" class="p-1.5 rounded-lg bg-rose-50 hover:bg-rose-600 hover:text-white text-rose-700 transition" title="Cabut KTA">
                                            <span class="material-symbols-outlined text-[16px]">delete</span>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="text-center py-10 text-gray-400">
                                    <div class="w-12 h-12 rounded-full bg-gray-100 text-gray-400 flex items-center justify-center mx-auto mb-2">
                                        <span class="material-symbols-outlined text-2xl">credit_card_off</span>
                                    </div>
                                    <p class="font-semibold">Belum ada KTA yang sesuai dengan filter pencarian.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination Bar -->
            <div class="p-4 border-t border-gray-100">
                {{ $ktas->links() }}
            </div>

        </div>
    </form>

</div>

<!-- Hidden Delete Form -->
<form id="deleteKtaForm" action="" method="POST" class="hidden">
    @csrf
    @method('DELETE')
</form>

<script>
    // Bulk selection handler
    const selectAllCheckbox = document.getElementById('selectAllCheckbox');
    const rowCheckboxes = document.querySelectorAll('.kta-row-checkbox');
    const bulkPrintBtn = document.getElementById('bulkPrintBtn');
    const countText = document.getElementById('selectedCountText');

    function updateBulkState() {
        const checked = document.querySelectorAll('.kta-row-checkbox:checked');
        const count = checked.length;
        countText.textContent = count + ' KTA terpilih';
        bulkPrintBtn.disabled = count === 0;
    }

    if (selectAllCheckbox) {
        selectAllCheckbox.addEventListener('change', function () {
            rowCheckboxes.forEach(cb => cb.checked = selectAllCheckbox.checked);
            updateBulkState();
        });
    }

    rowCheckboxes.forEach(cb => {
        cb.addEventListener('change', function () {
            updateBulkState();
            if (!this.checked && selectAllCheckbox) selectAllCheckbox.checked = false;
        });
    });

    function confirmDeleteKta(id, nomor) {
        if (confirm(`Apakah Anda yakin ingin mencabut dan menonaktifkan KTA nomor ${nomor}?`)) {
            const form = document.getElementById('deleteKtaForm');
            form.action = `/admin/kta/${id}`;
            form.submit();
        }
    }
</script>
@endsection
