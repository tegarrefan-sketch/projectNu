@extends('layouts.admin')

@section('title', 'Tambah Pengurus — ' . $banom->singkatan . ' — SIMNU Admin')

@section('content')
<div class="max-w-2xl mx-auto space-y-6">

    <!-- Header -->
    <div class="flex items-center justify-between bg-white p-6 rounded-2xl border border-[#e6eeff] shadow-sm">
        <div>
            <nav class="flex items-center gap-2 text-xs text-[#707971] mb-1">
                <a href="{{ route('admin.banoms.index') }}" class="hover:underline">{{ $banom->singkatan }}</a>
                <span>/</span>
                <a href="{{ route('admin.banoms.officers.index', $banom->id) }}" class="hover:underline">Pengurus</a>
                <span>/</span>
                <span class="text-[#004125] font-semibold">Tambah</span>
            </nav>
            <h1 class="text-2xl font-black text-[#004125] tracking-tight">Tambah Pengurus {{ $banom->singkatan }}</h1>
            <p class="text-xs text-[#526350] mt-0.5">Daftarkan personil baru ke dalam susunan kepengurusan {{ $banom->nama }}.</p>
        </div>

        <a href="{{ route('admin.banoms.officers.index', $banom->id) }}" class="px-4 py-2 rounded-xl bg-gray-100 hover:bg-gray-200 text-gray-700 text-xs font-bold transition flex items-center gap-1.5">
            <span class="material-symbols-outlined text-[16px]">arrow_back</span>
            <span>Kembali</span>
        </a>
    </div>

    <!-- Form Card -->
    <div class="bg-white p-6 sm:p-8 rounded-2xl border border-[#e6eeff] shadow-sm">
        <form id="officerForm" action="{{ route('admin.banoms.officers.store', $banom->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf

            <!-- 1. SUMBER IDENTITAS PENGURUS -->
            <div class="p-4 bg-[#f8f9ff] rounded-2xl border border-[#dee9fc] space-y-4">
                <div class="flex items-center justify-between">
                    <span class="text-xs font-bold text-[#004125] uppercase tracking-wider block">1. Sumber Identitas Pengurus</span>
                    <div class="flex items-center gap-4 text-xs font-semibold">
                        <label class="flex items-center gap-1.5 cursor-pointer">
                            <input type="radio" name="source_type" value="member" checked onchange="toggleSourceType('member')" class="text-[#0c5a37] focus:ring-[#004125]">
                            <span>Pilih Anggota</span>
                        </label>
                        <label class="flex items-center gap-1.5 cursor-pointer">
                            <input type="radio" name="source_type" value="manual" onchange="toggleSourceType('manual')" class="text-[#0c5a37] focus:ring-[#004125]">
                            <span>Ketik Manual</span>
                        </label>
                    </div>
                </div>

                <!-- Bagian Pilih Anggota -->
                <div id="sectionMember" class="space-y-2">
                    <label class="block text-xs font-bold text-[#121c2a]">
                        Pilih dari Basis Data Anggota:
                    </label>

                    <input type="hidden" name="member_id" id="member_id" value="{{ $selectedMember?->id ?? old('member_id', request('member_id', '')) }}">

                    <!-- Card data anggota terpilih -->
                    <div id="selectedMemberCard" class="{{ $selectedMember ? '' : 'hidden' }} p-3.5 bg-emerald-50/80 border border-emerald-200 rounded-2xl flex items-center justify-between gap-3 shadow-xs">
                        <div class="flex items-center gap-3 min-w-0">
                            <div class="w-11 h-11 rounded-xl bg-white border border-emerald-200 flex items-center justify-center shrink-0 overflow-hidden shadow-xs">
                                <img id="selectedMemberImg" src="{{ $selectedMember?->foto ? asset('storage/' . $selectedMember->foto) : '' }}" alt="Foto" class="w-full h-full object-cover {{ $selectedMember?->foto ? '' : 'hidden' }}">
                                <span id="selectedMemberIcon" class="material-symbols-outlined text-emerald-700 text-2xl {{ $selectedMember?->foto ? 'hidden' : '' }}">person</span>
                            </div>
                            <div class="min-w-0">
                                <div class="flex items-center gap-2 flex-wrap">
                                    <span id="selectedMemberName" class="font-black text-[#004125] text-sm truncate block">{{ $selectedMember?->nama_lengkap ?? '' }}</span>
                                    <span id="selectedMemberNia" class="px-2 py-0.5 rounded-md bg-white border border-emerald-300 font-mono text-[11px] font-bold text-emerald-800">
                                        {{ $selectedMember?->nomor_anggota ? 'NIA: ' . $selectedMember->nomor_anggota : '' }}
                                    </span>
                                </div>
                                <div class="text-[11px] text-[#526350] truncate mt-0.5" id="selectedMemberSub">
                                    {{ $selectedMember ? ($selectedMember->banom?->singkatan ?? 'PRNU') . ($selectedMember->jabatan ? ' • ' . $selectedMember->jabatan : '') : '' }}
                                </div>
                            </div>
                        </div>
                        <button type="button" onclick="clearSelectedMember()" class="shrink-0 px-3 py-1.5 rounded-xl bg-white hover:bg-rose-50 border border-gray-200 hover:border-rose-300 text-rose-600 text-xs font-bold transition flex items-center gap-1 shadow-xs" title="Ganti Anggota">
                            <span class="material-symbols-outlined text-[16px]">swap_horiz</span>
                            <span>Ganti</span>
                        </button>
                    </div>

                    <!-- Input Pencarian (autocomplete) -->
                    <div id="memberSearchContainer" class="{{ $selectedMember ? 'hidden' : '' }} relative">
                        <div class="relative">
                            <span class="material-symbols-outlined absolute left-3.5 top-1/2 -translate-y-1/2 text-gray-400 text-lg">search</span>
                            <input type="text" id="memberSearchInput" autocomplete="off" placeholder="Ketik NIA atau Nama Anggota untuk mencari..." class="w-full pl-10 pr-10 py-3 rounded-xl text-xs sm:text-sm bg-white border border-[#dee9fc] focus:outline-none focus:border-[#004125] shadow-xs">
                            <span id="memberSearchSpinner" class="hidden material-symbols-outlined absolute right-3.5 top-1/2 -translate-y-1/2 text-emerald-700 text-lg animate-spin">progress_activity</span>
                        </div>

                        <!-- Dropdown Hasil Pencarian -->
                        <div id="memberSearchResults" class="hidden absolute left-0 right-0 top-full mt-1.5 bg-white rounded-2xl shadow-xl border border-gray-200 max-h-72 overflow-y-auto divide-y divide-gray-100 z-50 p-1">
                        </div>
                    </div>

                    @error('member_id')
                        <p class="text-[11px] text-red-500 mt-1 font-semibold">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Bagian Input Nama Manual -->
                <div id="sectionManual" class="space-y-2 hidden">
                    <label for="nama" class="block text-xs font-bold text-[#121c2a]">
                        Nama Lengkap Pengurus <span class="text-red-500">*</span>
                    </label>
                    <input type="text" id="nama" name="nama" value="{{ old('nama') }}" placeholder="Ketik nama lengkap beserta gelar..." class="w-full px-4 py-3 rounded-xl text-xs sm:text-sm bg-white border border-[#dee9fc] focus:outline-none focus:border-[#004125]">
                    @error('nama')
                        <p class="text-[11px] text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- 2. PILIH JABATAN & BAGIAN -->
            <div class="space-y-4">
                <span class="text-xs font-bold text-[#004125] uppercase tracking-wider block">2. Posisi & Jabatan</span>

                <!-- Dropdown Jabatan (Hanya jabatan yang sesuai banom ini) -->
                <div>
                    <label for="position_id" class="block text-xs font-bold text-[#121c2a] mb-1.5">
                        Jabatan Resmi <span class="text-red-500">*</span>
                    </label>
                    @php
                        $selectedPositionId = old('position_id', request('position_id'));
                    @endphp
                    <select id="position_id" name="position_id" required onchange="onPositionChanged(this)" class="w-full px-4 py-3 rounded-xl text-xs sm:text-sm bg-[#f8f9ff] border @error('position_id') border-red-500 @else border-[#dee9fc] @enderror focus:bg-white focus:outline-none focus:border-[#004125]">
                        <option value="">-- Pilih Jabatan Organisasi --</option>
                        @foreach($positions as $p)
                            @php
                                $usedCount = $activeOfficersByPosition[$p->id] ?? 0;
                                $isBatasKeras = $p->isBatasKeras() || (!is_null($p->maks_orang) && $p->maks_orang === 1);
                                $isFull = ($isBatasKeras && $usedCount >= ($p->maks_orang ?? 1));
                                $officerNames = $activeOfficerNamesByPosition[$p->id] ?? '';
                            @endphp
                            <option value="{{ $p->id }}" 
                                data-kategori="{{ $p->kategori }}" 
                                data-maks="{{ $p->maks_orang }}"
                                data-keras="{{ $isBatasKeras ? '1' : '0' }}"
                                data-anjuran="{{ $p->anjuran_maks ?? '' }}"
                                data-used="{{ $usedCount }}"
                                data-full="{{ $isFull ? '1' : '0' }}"
                                data-officer-names="{{ $officerNames }}"
                                {{ $selectedPositionId == $p->id ? 'selected' : '' }}>
                                {{ $p->nama }} 
                                @if($isFull)
                                    [SUDAH TERISI: {{ $usedCount }}/{{ $p->maks_orang ?? 1 }} orang]
                                @elseif($isBatasKeras)
                                    (Batas Keras: {{ $p->maks_orang ?? 1 }} orang)
                                @elseif($p->hasAnjuran())
                                    (Anjuran: {{ $p->anjuran_maks }} orang, saat ini {{ $usedCount }})
                                @else
                                    (Tanpa Batas Kuota)
                                @endif
                            </option>
                        @endforeach
                    </select>

                    <!-- Alert Peringatan Jika Jabatan Terisi Penuh -->
                    <div id="fullPositionWarning" class="hidden mt-3 p-4 bg-amber-50 border border-amber-300 rounded-2xl text-amber-950 text-xs space-y-3">
                        <div class="flex items-start gap-2.5">
                            <span class="material-symbols-outlined text-[20px] text-amber-700 shrink-0">info</span>
                            <div>
                                <span class="font-bold block text-sm text-amber-900" id="fullPositionTitle">Jabatan ini sudah terisi</span>
                                <span id="fullPositionMsg" class="text-xs text-amber-800 leading-relaxed block mt-0.5"></span>
                            </div>
                        </div>

                        <!-- Opsi Pergantian Otomatis untuk Jabatan Batas Keras (mis. Ketua, Kasatkorkel) -->
                        <div id="replaceOptionBox" class="hidden p-3 bg-white rounded-xl border border-amber-200 shadow-xs">
                            <label class="flex items-start gap-2.5 cursor-pointer">
                                <input type="checkbox" name="replace_current" id="chkReplaceCurrent" value="1" onchange="checkCanSubmit()" class="mt-0.5 w-4 h-4 rounded text-[#0c5a37] focus:ring-[#004125] border-gray-300">
                                <div>
                                    <span class="font-bold text-xs text-[#004125] block">Gantikan pengurus saat ini (Pengurus lama otomatis dinonaktifkan)</span>
                                    <span class="text-[11px] text-[#526350] block mt-0.5">
                                        Pengurus lama (<strong id="replaceTargetName"></strong>) akan otomatis dinonaktifkan agar jabatan tetap terisi 1 orang tanpa bentrok.
                                    </span>
                                </div>
                            </label>
                        </div>
                    </div>

                    @error('position_id')
                        <p class="text-[11px] text-red-500 mt-1 font-semibold">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Bagian / Divisi (Muncul jika ada divisions untuk banom ini) -->
                @if($divisions->isNotEmpty())
                    <div>
                        <label for="division_id" class="block text-xs font-bold text-[#121c2a] mb-1.5">
                            {{ $banom->label_bagian ?? 'Bagian / Divisi' }}
                        </label>
                        <select id="division_id" name="division_id" class="w-full px-4 py-3 rounded-xl text-xs sm:text-sm bg-[#f8f9ff] border @error('division_id') border-red-500 @else border-[#dee9fc] @enderror focus:bg-white focus:outline-none focus:border-[#004125]">
                            <option value="">-- Tanpa {{ $banom->label_bagian ?? 'Bagian' }} (Pengurus Harian/Umum) --</option>
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
                @endif

                <!-- Urutan Wakil (untuk Wakil Ketua I, II) -->
                <div id="urutanWakilBox" class="hidden">
                    <label for="urutan_wakil" class="block text-xs font-bold text-[#121c2a] mb-1.5">
                        Tingkat / Urutan Wakil (Opsional)
                    </label>
                    <input type="number" id="urutan_wakil" name="urutan_wakil" value="{{ old('urutan_wakil') }}" min="1" max="10" placeholder="Misal: 1 untuk Wakil I, 2 untuk Wakil II" class="w-full px-4 py-3 rounded-xl text-xs sm:text-sm bg-[#f8f9ff] border border-[#dee9fc] focus:bg-white focus:outline-none focus:border-[#004125]">
                    <p class="text-[11px] text-[#707971] mt-1">Isi angka 1, 2, atau 3 jika jabatan memiliki tingkatan (Wakil I, Wakil II, dst).</p>
                </div>
            </div>

            <!-- 3. FOTO, URUTAN & STATUS -->
            <div class="space-y-4 pt-2 border-t border-gray-100">
                <span class="text-xs font-bold text-[#004125] uppercase tracking-wider block">3. Foto & Pengaturan Tampilan</span>

                <!-- Upload Foto dengan Kompresi Otomatis 10MB -->
                <div>
                    <label for="foto" class="block text-xs font-bold text-[#121c2a] mb-1.5">
                        Foto Pengurus
                    </label>
                    <input type="file" id="foto" name="foto" accept=".jpg,.jpeg,.png,.webp" onchange="previewSelectedPhoto(this)" class="w-full text-xs text-gray-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-[#eff4ff] file:text-[#004125] hover:file:bg-[#dee9fc] border border-[#dee9fc] rounded-xl p-2 bg-[#f8f9ff]">
                    <p class="text-[11px] text-[#004125] font-semibold mt-1">
                        Maksimal 10 MB, sistem akan mengecilkan otomatis. Format: JPG, JPEG, PNG, WEBP.
                    </p>
                    @error('foto')
                        <p class="text-[11px] text-red-500 mt-1 font-semibold">{{ $message }}</p>
                    @enderror

                    <!-- Preview Foto yang Dipilih -->
                    <div id="photoPreviewContainer" class="hidden mt-3 p-3 bg-[#f8f9ff] border border-[#dee9fc] rounded-xl flex items-center gap-3">
                        <img id="photoPreviewImg" src="" alt="Pratinjau Foto" class="w-16 h-16 rounded-xl object-cover border border-gray-200">
                        <div class="text-xs text-gray-600">
                            <span class="font-bold text-[#004125] block">Pratinjau Foto Terpilih</span>
                            <span class="text-[11px] text-[#707971]">Sistem akan menyesuaikan orientasi EXIF dan mengubah resolusi menjadi ramah web.</span>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5 items-center">
                    <!-- Urutan Tampilan -->
                    <div>
                        <label for="urutan" class="block text-xs font-bold text-[#121c2a] mb-1.5">
                            Urutan Tampilan
                        </label>
                        <input type="number" id="urutan" name="urutan" value="{{ old('urutan', $nextUrutan) }}" min="0" required class="w-full px-4 py-3 rounded-xl text-xs sm:text-sm bg-[#f8f9ff] border @error('urutan') border-red-500 @else border-[#dee9fc] @enderror focus:bg-white focus:outline-none focus:border-[#004125]">
                        @error('urutan')
                            <p class="text-[11px] text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Status Aktif Checkbox -->
                    <div class="pt-4 sm:pt-6">
                        <label class="flex items-center gap-3 cursor-pointer">
                            <input type="checkbox" name="is_active" id="is_active" value="1" onchange="checkCanSubmit()" {{ old('is_active', true) ? 'checked' : '' }} class="w-5 h-5 rounded text-[#0c5a37] focus:ring-[#004125] border-gray-300">
                            <span class="text-xs font-bold text-[#121c2a]">Status Aktif</span>
                        </label>
                        <p class="text-[11px] text-[#707971] mt-1 pl-8">Nonaktifkan jika pengurus demisioner.</p>
                    </div>
                </div>
            </div>

            <!-- Submit Buttons with Processing Indicator -->
            <div class="pt-5 border-t border-[#f2f4f8] flex items-center justify-end gap-3">
                <a href="{{ route('admin.banoms.officers.index', $banom->id) }}" class="px-5 py-2.5 rounded-xl border border-gray-300 text-gray-700 text-xs font-bold hover:bg-gray-50 transition">
                    Batal
                </a>
                <button type="submit" id="btnSubmitOfficer" class="px-6 py-2.5 rounded-xl bg-[#0c5a37] hover:bg-[#004125] text-white text-xs font-black shadow-md transition flex items-center gap-2">
                    <span id="btnIcon" class="material-symbols-outlined text-[18px]">person_add</span>
                    <span id="btnText">Simpan Pengurus</span>
                </button>
            </div>
        </form>
    </div>

</div>

@push('scripts')
<script>
    function toggleSourceType(type) {
        const secMember = document.getElementById('sectionMember');
        const secManual = document.getElementById('sectionManual');

        if (type === 'member') {
            secMember.classList.remove('hidden');
            secManual.classList.add('hidden');
        } else {
            secMember.classList.add('hidden');
            secManual.classList.remove('hidden');
            clearSelectedMember();
        }
    }

    let memberDebounceTimer;
    const memberSearchInput = document.getElementById('memberSearchInput');
    const memberSearchResults = document.getElementById('memberSearchResults');
    const memberSearchSpinner = document.getElementById('memberSearchSpinner');

    if (memberSearchInput) {
        memberSearchInput.addEventListener('input', function() {
            clearTimeout(memberDebounceTimer);
            const q = this.value.trim();
            if (q.length === 0) {
                memberSearchResults.innerHTML = '';
                memberSearchResults.classList.add('hidden');
                return;
            }
            memberSearchSpinner.classList.remove('hidden');
            memberDebounceTimer = setTimeout(() => {
                fetch(`{{ route('admin.anggota.search') }}?q=` + encodeURIComponent(q))
                    .then(res => res.json())
                    .then(data => {
                        memberSearchSpinner.classList.add('hidden');
                        memberSearchResults.innerHTML = '';
                        if (!data || data.length === 0) {
                            memberSearchResults.innerHTML = `
                                <div class="p-4 text-center text-xs text-gray-500 font-medium">
                                    <span class="material-symbols-outlined text-gray-400 text-2xl block mb-1">person_search</span>
                                    Anggota tidak ditemukan
                                </div>
                            `;
                            memberSearchResults.classList.remove('hidden');
                            return;
                        }

                        data.forEach(m => {
                            const item = document.createElement('div');
                            item.className = 'p-2.5 rounded-xl hover:bg-emerald-50/80 cursor-pointer transition flex items-center justify-between gap-3 text-xs';
                            item.innerHTML = `
                                <div class="flex items-center gap-2.5 min-w-0">
                                    <div class="w-8 h-8 rounded-lg bg-gray-100 border border-gray-200 flex items-center justify-center shrink-0 overflow-hidden">
                                        ${m.foto ? `<img src="${m.foto}" class="w-full h-full object-cover">` : `<span class="material-symbols-outlined text-gray-400 text-[18px]">person</span>`}
                                    </div>
                                    <div class="min-w-0">
                                        <div class="font-bold text-[#121c2a] truncate">${m.nama_lengkap}</div>
                                        <div class="text-[10px] text-gray-500 truncate">${m.banom || 'PRNU'} ${m.jabatan ? '• ' + m.jabatan : ''}</div>
                                    </div>
                                </div>
                                <span class="px-2 py-0.5 rounded bg-gray-100 font-mono text-[10px] font-bold text-gray-700 shrink-0">
                                    ${m.nomor_anggota ? 'NIA: ' + m.nomor_anggota : '-'}
                                </span>
                            `;
                            item.addEventListener('click', () => selectMember(m));
                            memberSearchResults.appendChild(item);
                        });
                        memberSearchResults.classList.remove('hidden');
                    })
                    .catch(() => {
                        memberSearchSpinner.classList.add('hidden');
                    });
            }, 300);
        });
    }

    function selectMember(m) {
        document.getElementById('member_id').value = m.id;
        document.getElementById('selectedMemberName').innerText = m.nama_lengkap;
        document.getElementById('selectedMemberNia').innerText = m.nomor_anggota ? 'NIA: ' + m.nomor_anggota : '';
        document.getElementById('selectedMemberSub').innerText = (m.banom || 'PRNU') + (m.jabatan ? ' • ' + m.jabatan : '');
        
        const img = document.getElementById('selectedMemberImg');
        const icon = document.getElementById('selectedMemberIcon');
        if (m.foto) {
            img.src = m.foto;
            img.classList.remove('hidden');
            icon.classList.add('hidden');
        } else {
            img.src = '';
            img.classList.add('hidden');
            icon.classList.remove('hidden');
        }

        document.getElementById('selectedMemberCard').classList.remove('hidden');
        document.getElementById('memberSearchContainer').classList.add('hidden');
        memberSearchResults.classList.add('hidden');
        memberSearchResults.innerHTML = '';
        if (memberSearchInput) memberSearchInput.value = '';
    }

    function clearSelectedMember() {
        document.getElementById('member_id').value = '';
        document.getElementById('selectedMemberCard').classList.add('hidden');
        document.getElementById('memberSearchContainer').classList.remove('hidden');
        if (memberSearchInput) {
            memberSearchInput.value = '';
            memberSearchInput.focus();
        }
    }

    document.addEventListener('click', function(e) {
        if (!document.getElementById('memberSearchContainer')?.contains(e.target)) {
            memberSearchResults?.classList.add('hidden');
        }
    });

    function onPositionChanged(sel) {
        const opt = sel.options[sel.selectedIndex];
        const warnBox = document.getElementById('fullPositionWarning');
        const replaceBox = document.getElementById('replaceOptionBox');
        const replaceTarget = document.getElementById('replaceTargetName');
        const wakilBox = document.getElementById('urutanWakilBox');

        if (!opt || !opt.value) {
            warnBox.classList.add('hidden');
            if (wakilBox) wakilBox.classList.add('hidden');
            return;
        }

        const isFull = opt.dataset.full === '1';
        const isKeras = opt.dataset.keras === '1';
        const maks = parseInt(opt.dataset.maks) || 1;
        const officerNames = opt.dataset.officerNames || '';
        const positionName = opt.text.split('(')[0].split('[')[0].trim();

        // Toggle urutan wakil jika nama mengandung "Wakil"
        if (wakilBox) {
            if (positionName.toLowerCase().includes('wakil')) {
                wakilBox.classList.remove('hidden');
            } else {
                wakilBox.classList.add('hidden');
            }
        }

        if (isFull && isKeras) {
            warnBox.classList.remove('hidden');
            document.getElementById('fullPositionTitle').innerText = `Jabatan ${positionName} sudah terisi`;
            document.getElementById('fullPositionMsg').innerText = `Jabatan ini sudah dipegang oleh: ${officerNames}.`;

            if (maks === 1) {
                replaceBox.classList.remove('hidden');
                replaceTarget.innerText = officerNames;
            } else {
                replaceBox.classList.add('hidden');
            }
        } else {
            warnBox.classList.add('hidden');
            replaceBox.classList.add('hidden');
        }

        checkCanSubmit();
    }

    function checkCanSubmit() {
        const sel = document.getElementById('position_id');
        const opt = sel.options[sel.selectedIndex];
        const btn = document.getElementById('btnSubmitOfficer');

        if (!opt || !opt.value) return;

        const isFull = opt.dataset.full === '1';
        const isKeras = opt.dataset.keras === '1';
        const isActive = document.getElementById('is_active').checked;
        const replaceChecked = document.getElementById('chkReplaceCurrent') ? document.getElementById('chkReplaceCurrent').checked : false;

        if (isFull && isKeras && isActive && !replaceChecked) {
            btn.disabled = true;
            btn.classList.add('opacity-50', 'cursor-not-allowed');
            btn.title = 'Jabatan ini sudah terisi, ubah atau nonaktifkan pengurus lama terlebih dahulu.';
        } else {
            btn.disabled = false;
            btn.classList.remove('opacity-50', 'cursor-not-allowed');
            btn.title = '';
        }
    }

    function previewSelectedPhoto(input) {
        const container = document.getElementById('photoPreviewContainer');
        const img = document.getElementById('photoPreviewImg');

        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                img.src = e.target.result;
                container.classList.remove('hidden');
            };
            reader.readAsDataURL(input.files[0]);
        } else {
            container.classList.add('hidden');
        }
    }

    // Submit handler with "Sedang memproses..."
    document.getElementById('officerForm').addEventListener('submit', function() {
        const btn = document.getElementById('btnSubmitOfficer');
        btn.disabled = true;
        btn.classList.add('opacity-75');
        document.getElementById('btnIcon').innerText = 'sync';
        document.getElementById('btnIcon').classList.add('animate-spin');
        document.getElementById('btnText').innerText = 'Sedang memproses...';
    });

    document.addEventListener('DOMContentLoaded', function() {
        const sel = document.getElementById('position_id');
        if (sel && sel.value) {
            onPositionChanged(sel);
        }
    });
</script>
@endpush
@endsection
