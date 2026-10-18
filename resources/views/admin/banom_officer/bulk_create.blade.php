@extends('layouts.admin')

@section('title', 'Tambah Banyak Pengurus Sekaligus — ' . $banom->singkatan . ' — SIMNU Admin')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">

    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 bg-white p-6 rounded-2xl border border-[#e6eeff] shadow-sm">
        <div>
            <nav class="flex items-center gap-2 text-xs text-[#707971] mb-1">
                <a href="{{ route('admin.banoms.index') }}" class="hover:underline">{{ $banom->singkatan }}</a>
                <span>/</span>
                <a href="{{ route('admin.banoms.officers.index', $banom->id) }}" class="hover:underline">Pengurus</a>
                <span>/</span>
                <span class="text-[#004125] font-semibold">Tambah Banyak Sekaligus</span>
            </nav>
            <h1 class="text-2xl font-black text-[#004125] tracking-tight">Tambah Banyak Pengurus Sekaligus</h1>
            <p class="text-xs text-[#526350] mt-0.5">Pilih jabatan dan bagian satu kali, lalu centang puluhan hingga ratusan anggota untuk ditambahkan secara instan ke {{ $banom->nama }}.</p>
        </div>

        <a href="{{ route('admin.banoms.officers.index', $banom->id) }}" class="w-full sm:w-auto px-4 py-2 rounded-xl bg-gray-100 hover:bg-gray-200 text-gray-700 text-xs font-bold transition flex items-center justify-center gap-1.5 min-h-[44px]">
            <span class="material-symbols-outlined text-[16px]">arrow_back</span>
            <span>Kembali</span>
        </a>
    </div>

    <!-- Bulk Form Card -->
    <div class="bg-white p-6 sm:p-8 rounded-3xl border border-[#e6eeff] shadow-sm">
        <form id="bulkStoreForm" action="{{ route('admin.banoms.officers.bulk-store', $banom->id) }}" method="POST" class="space-y-6">
            @csrf

            <!-- 1. JABATAN & BAGIAN TARGET -->
            <div class="p-5 bg-[#f8f9ff] rounded-2xl border border-[#dee9fc] space-y-4">
                <span class="text-xs font-black text-[#004125] uppercase tracking-wider block">1. Tentukan Jabatan & Bagian Target</span>
                
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <!-- Jabatan -->
                    <div>
                        <label for="position_id" class="block text-xs font-bold text-[#121c2a] mb-1.5">
                            Jabatan yang Ditetapkan <span class="text-red-500">*</span>
                        </label>
                        <select id="position_id" name="position_id" required class="w-full px-4 py-3 rounded-xl text-xs sm:text-sm bg-white border @error('position_id') border-red-500 @else border-[#dee9fc] @enderror focus:outline-none focus:border-[#004125] shadow-xs">
                            <option value="">-- Pilih Jabatan --</option>
                            @foreach($positions as $p)
                                <option value="{{ $p->id }}" {{ old('position_id') == $p->id ? 'selected' : '' }}>
                                    {{ $p->nama }} 
                                    @if($p->isBatasKeras())
                                        (Batas Keras: {{ $p->maks_orang ?? 1 }} org)
                                    @elseif($p->hasAnjuran())
                                        (Anjuran: {{ $p->anjuran_maks }} org)
                                    @else
                                        (Tanpa Batas Kuota)
                                    @endif
                                </option>
                            @endforeach
                        </select>
                        @error('position_id')
                            <p class="text-[11px] text-red-500 mt-1 font-semibold">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Bagian / Divisi -->
                    <div>
                        <label for="division_id" class="block text-xs font-bold text-[#121c2a] mb-1.5">
                            {{ $banom->label_bagian ?? 'Bagian / Divisi' }} (Opsional)
                        </label>
                        <select id="division_id" name="division_id" class="w-full px-4 py-3 rounded-xl text-xs sm:text-sm bg-white border border-[#dee9fc] focus:outline-none focus:border-[#004125] shadow-xs">
                            <option value="">-- Tanpa {{ $banom->label_bagian ?? 'Bagian' }} (Umum) --</option>
                            @foreach($divisions as $div)
                                <option value="{{ $div->id }}" {{ old('division_id') == $div->id ? 'selected' : '' }}>
                                    {{ $div->nama }}
                                </option>
                            @endforeach
                        </select>
                        @error('division_id')
                            <p class="text-[11px] text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="pt-2">
                    <label class="flex items-center gap-3 cursor-pointer">
                        <input type="checkbox" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }} class="w-4 h-4 rounded text-[#0c5a37] focus:ring-[#004125] border-gray-300">
                        <span class="text-xs font-bold text-[#121c2a]">Tetapkan Status Aktif untuk Seluruh Anggota Terpilih</span>
                    </label>
                </div>
            </div>

            <!-- 2. MULTI-SELECT ANGGOTA -->
            <div class="space-y-4">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                    <div>
                        <span class="text-xs font-black text-[#004125] uppercase tracking-wider block">2. Pilih Anggota / Kader</span>
                        <p class="text-[11px] text-[#707971]">Centang nama anggota yang akan dimasukkan ke jabatan tersebut.</p>
                    </div>

                    <div class="flex flex-wrap items-center gap-2">
                        <span id="selectedCountBadge" class="px-3 py-1.5 rounded-full text-xs font-black bg-emerald-100 text-emerald-900 border border-emerald-300">
                            0 Anggota Dipilih
                        </span>
                        <button type="button" onclick="selectAllFiltered(true)" class="px-3 py-2 rounded-lg bg-gray-100 hover:bg-gray-200 text-gray-700 text-xs font-bold transition min-h-[44px]">
                            Pilih Semua
                        </button>
                        <button type="button" onclick="selectAllFiltered(false)" class="px-3 py-2 rounded-lg bg-gray-100 hover:bg-gray-200 text-gray-700 text-xs font-bold transition min-h-[44px]">
                            Batal Pilih
                        </button>
                    </div>
                </div>

                <!-- Live Search Box -->
                <div class="relative">
                    <span class="material-symbols-outlined absolute left-3.5 top-1/2 -translate-y-1/2 text-gray-400 text-[20px]">search</span>
                    <input type="text" id="memberSearchInput" onkeyup="filterMemberList()" placeholder="Cari nama anggota atau nomor anggota (NIA)..." class="w-full pl-11 pr-4 py-2.5 rounded-xl text-xs bg-[#f8f9ff] border border-[#dee9fc] focus:bg-white focus:outline-none focus:border-[#004125]">
                </div>

                @error('member_ids')
                    <p class="text-xs text-red-500 font-bold">{{ $message }}</p>
                @enderror

                <!-- Scrollable Checkbox List -->
                <div class="border border-gray-200 rounded-2xl max-h-96 overflow-y-auto divide-y divide-gray-100 p-2 bg-[#fafcff]">
                    @forelse($members as $m)
                        <label class="member-item flex items-center justify-between p-3 rounded-xl hover:bg-white transition cursor-pointer select-none" data-search="{{ strtolower($m->nama_lengkap . ' ' . $m->nomor_anggota) }}">
                            <div class="flex items-center gap-3">
                                <input type="checkbox" name="member_ids[]" value="{{ $m->id }}" onchange="updateSelectedCount()" class="member-checkbox w-4 h-4 rounded text-[#0c5a37] focus:ring-[#004125] border-gray-300">
                                
                                <div class="w-8 h-8 rounded-lg bg-gray-100 border border-gray-200 flex items-center justify-center shrink-0 overflow-hidden">
                                    @if($m->foto)
                                        <img src="{{ asset('storage/' . $m->foto) }}" alt="{{ $m->nama_lengkap }}" class="w-full h-full object-cover">
                                    @else
                                        <span class="material-symbols-outlined text-gray-400 text-[18px]">person</span>
                                    @endif
                                </div>

                                <div>
                                    <div class="text-xs font-bold text-[#121c2a]">{{ $m->nama_lengkap }}</div>
                                    <div class="text-[10px] text-gray-400 font-mono">NIA: {{ $m->nomor_anggota }}</div>
                                </div>
                            </div>

                            <span class="text-[10px] text-emerald-800 bg-emerald-50 px-2 py-0.5 rounded font-bold border border-emerald-200">
                                Anggota Aktif
                            </span>
                        </label>
                    @empty
                        <div class="p-8 text-center text-gray-400 text-xs">
                            Belum ada data anggota aktif di basis data.
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- Submit Button with Indicator -->
            <div class="pt-5 border-t border-[#f2f4f8] flex flex-col sm:flex-row items-stretch sm:items-center justify-between gap-4">
                <span class="text-xs text-gray-500">
                    *Data akan diproses secara bertahap (chunk batch insert) tanpa membebani server.
                </span>

                <div class="flex items-center gap-3 w-full sm:w-auto">
                    <a href="{{ route('admin.banoms.officers.index', $banom->id) }}" class="flex-1 sm:flex-initial px-5 py-2.5 rounded-xl border border-gray-300 text-gray-700 text-xs font-bold hover:bg-gray-50 transition text-center min-h-[44px] flex items-center justify-center">
                        Batal
                    </a>
                    <button type="submit" id="btnSubmitBulk" class="flex-1 sm:flex-initial px-6 py-2.5 rounded-xl bg-[#0c5a37] hover:bg-[#004125] text-white text-xs font-black shadow-md transition flex items-center justify-center gap-2 min-h-[44px]">
                        <span id="btnBulkIcon" class="material-symbols-outlined text-[18px]">save</span>
                        <span id="btnBulkText">Simpan Pengurus Terpilih</span>
                    </button>
                </div>
            </div>
        </form>
    </div>

</div>

@push('scripts')
<script>
    function filterMemberList() {
        const query = document.getElementById('memberSearchInput').value.toLowerCase().trim();
        document.querySelectorAll('.member-item').forEach(item => {
            const searchData = item.dataset.search || '';
            if (searchData.includes(query)) {
                item.classList.remove('hidden');
            } else {
                item.classList.add('hidden');
            }
        });
    }

    function selectAllFiltered(check) {
        document.querySelectorAll('.member-item:not(.hidden) .member-checkbox').forEach(cb => {
            cb.checked = check;
        });
        updateSelectedCount();
    }

    function updateSelectedCount() {
        const count = document.querySelectorAll('.member-checkbox:checked').length;
        document.getElementById('selectedCountBadge').innerText = `${count} Anggota Dipilih`;
    }

    document.getElementById('bulkStoreForm').addEventListener('submit', function(e) {
        const count = document.querySelectorAll('.member-checkbox:checked').length;
        if (count === 0) {
            e.preventDefault();
            alert('Pilih minimal satu anggota sebelum menyimpan.');
            return false;
        }

        const btn = document.getElementById('btnSubmitBulk');
        btn.disabled = true;
        btn.classList.add('opacity-75');
        document.getElementById('btnBulkIcon').innerText = 'sync';
        document.getElementById('btnBulkIcon').classList.add('animate-spin');
        document.getElementById('btnBulkText').innerText = `Sedang menyimpan ${count} pengurus...`;
    });
</script>
@endpush
@endsection
