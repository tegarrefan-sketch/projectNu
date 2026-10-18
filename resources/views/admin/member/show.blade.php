@extends('layouts.admin')

@section('title', 'Detail Anggota: ' . $member->nama_lengkap . ' — SIMNU Admin')

@section('content')
<div class="space-y-6">

    <!-- Header & Breadcrumbs -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 bg-white p-6 rounded-2xl border border-[#e6eeff] shadow-sm">
        <div>
            <nav class="flex items-center gap-2 text-xs text-[#707971] mb-1">
                <a href="{{ route('admin.anggota.index') }}" class="hover:underline">Basis Data Anggota</a>
                <span>/</span>
                <span class="text-[#004125] font-semibold">{{ $member->banom->singkatan ?? 'NU' }}</span>
                <span>/</span>
                <span class="text-gray-400">Detail Profil</span>
            </nav>
            <div class="flex flex-wrap items-center gap-3">
                <h1 class="text-2xl font-black text-[#004125] tracking-tight">{{ $member->nama_lengkap }}</h1>
                @if($member->activeOfficer)
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-extrabold bg-emerald-100 text-[#004125] border border-emerald-300">
                        <span class="material-symbols-outlined text-[16px] text-emerald-700">verified</span>
                        <span>Pengurus: {{ $member->activeOfficer->display_jabatan }} ({{ $member->activeOfficer->banom->singkatan }})</span>
                    </span>
                @else
                    <span class="px-3 py-1 rounded-full text-xs font-bold {{ $member->status_keanggotaan === 'Kader' ? 'bg-amber-100 text-amber-900' : ($member->status_keanggotaan === 'Simpatisan' ? 'bg-blue-100 text-blue-900' : 'bg-gray-100 text-gray-800') }}">
                        Status: {{ $member->status_keanggotaan ?? 'Anggota' }}
                    </span>
                @endif
            </div>
            <p class="text-xs text-[#526350] mt-1 font-mono">NIA: {{ $member->nomor_anggota }}</p>
        </div>

        <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-2 w-full sm:w-auto">
            @if(!$member->activeOfficer)
                <a href="{{ route('admin.banoms.officers.create', [$member->banom_id, 'member_id' => $member->id]) }}" class="w-full sm:w-auto min-h-[44px] inline-flex items-center justify-center gap-1.5 px-4 py-2.5 rounded-xl bg-[#0c5a37] hover:bg-[#004125] text-white text-xs font-black shadow-sm transition">
                    <span class="material-symbols-outlined text-[18px]">group_add</span>
                    <span>Jadikan Pengurus</span>
                </a>
            @else
                <a href="{{ route('admin.banoms.officers.index', $member->activeOfficer->banom_id) }}" class="w-full sm:w-auto min-h-[44px] inline-flex items-center justify-center gap-1.5 px-4 py-2.5 rounded-xl bg-emerald-50 hover:bg-emerald-100 text-[#004125] border border-emerald-300 text-xs font-black shadow-xs transition">
                    <span class="material-symbols-outlined text-[18px]">badge</span>
                    <span>Kelola di Pengurus</span>
                </a>
            @endif

            <a href="{{ route('admin.anggota.edit', $member->id) }}" class="w-full sm:w-auto min-h-[44px] inline-flex items-center justify-center gap-1.5 px-4 py-2.5 rounded-xl bg-gray-100 hover:bg-gray-200 text-gray-800 text-xs font-bold transition">
                <span class="material-symbols-outlined text-[18px]">edit</span>
                <span>Edit Data</span>
            </a>
            <a href="{{ route('admin.anggota.index') }}" class="min-h-[44px] px-3.5 py-2.5 rounded-xl border border-gray-200 hover:bg-gray-50 text-gray-600 transition flex items-center justify-center" title="Kembali ke Daftar">
                <span class="material-symbols-outlined text-[18px]">arrow_back</span>
            </a>
        </div>
    </div>

    <!-- Main Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">

        <!-- Left Column: Photo & Quick Status (4 cols) -->
        <div class="lg:col-span-4 space-y-6">
            <div class="bg-white rounded-3xl p-6 border border-[#e6eeff] shadow-sm text-center">
                <div class="w-32 h-32 mx-auto rounded-2xl bg-emerald-50 border-2 border-emerald-200 overflow-hidden flex items-center justify-center text-emerald-800 shadow-inner">
                    @if($member->foto)
                        <img src="{{ asset('storage/' . $member->foto) }}" alt="{{ $member->nama_lengkap }}" class="w-full h-full object-cover">
                    @else
                        <span class="material-symbols-outlined text-6xl text-emerald-400">person</span>
                    @endif
                </div>

                <h2 class="text-lg font-black text-[#004125] mt-4">{{ $member->nama_lengkap }}</h2>
                <div class="text-xs font-mono text-gray-400">{{ $member->nomor_anggota }}</div>

                <div class="mt-4 pt-4 border-t border-gray-100 flex flex-wrap justify-center gap-2">
                    <span class="px-2.5 py-1 rounded-full text-xs font-bold bg-emerald-100 text-[#004125]">
                        {{ $member->banom->singkatan }} - {{ $member->banom->nama }}
                    </span>
                    <span class="px-2.5 py-1 rounded-full text-xs font-bold {{ $member->status === 'Aktif' ? 'bg-emerald-100 text-emerald-800' : 'bg-gray-100 text-gray-700' }}">
                        Keaktifan: {{ $member->status }}
                    </span>
                </div>
            </div>

            <!-- KTA Card Status -->
            <div class="bg-white rounded-3xl p-6 border border-[#e6eeff] shadow-sm space-y-4">
                <div class="flex items-center justify-between border-b border-gray-100 pb-3">
                    <h3 class="text-xs font-bold uppercase tracking-wider text-[#004125]">Kartu Tanda Anggota (KTA)</h3>
                    <span class="material-symbols-outlined text-emerald-600">id_card</span>
                </div>

                @if($member->kta)
                    <div class="p-4 rounded-2xl bg-emerald-50/70 border border-emerald-200 space-y-2">
                        <div class="text-[11px] text-gray-500">Nomor KTA Resmi:</div>
                        <div class="font-mono font-black text-sm text-[#004125]">{{ $member->kta->nomor_kta }}</div>
                        <div class="text-[11px] text-gray-600">
                            Jabatan pada KTA: <strong class="text-emerald-800">{{ $member->jabatan_kta }}</strong>
                        </div>
                        <div class="pt-2 flex items-center gap-2">
                            <a href="{{ route('admin.kta.show', $member->kta->id) }}" class="flex-1 py-1.5 px-3 rounded-xl bg-[#004125] text-white text-[11px] font-bold text-center hover:bg-[#0c5a37] transition">
                                Lihat KTA
                            </a>
                            <a href="{{ route('admin.kta.print', $member->kta->id) }}" target="_blank" class="py-1.5 px-3 rounded-xl border border-emerald-300 text-emerald-800 text-[11px] font-bold text-center hover:bg-emerald-100 transition">
                                Cetak
                            </a>
                        </div>
                    </div>
                @else
                    <div class="text-center py-4 space-y-3">
                        <p class="text-xs text-gray-500">Anggota ini belum diterbitkan KTA fisik / digital.</p>
                        <form action="{{ route('admin.kta.generate', $member->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl bg-[#004125] hover:bg-[#0c5a37] text-white text-xs font-bold transition shadow-sm">
                                <span class="material-symbols-outlined text-[16px]">auto_fix_high</span>
                                <span>Terbitkan KTA Sekarang</span>
                            </button>
                        </form>
                    </div>
                @endif
            </div>
        </div>

        <!-- Right Column: Detail Information (8 cols) -->
        <div class="lg:col-span-8 space-y-6">

            <!-- Detail Data Diri -->
            <div class="bg-white rounded-3xl p-6 border border-[#e6eeff] shadow-sm space-y-4">
                <h3 class="text-sm font-bold text-[#004125] flex items-center gap-2 border-b border-gray-100 pb-3">
                    <span class="material-symbols-outlined text-emerald-600 text-lg">person</span>
                    <span>Informasi Data Diri & Keanggotaan</span>
                </h3>

                <dl class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-xs">
                    <div class="p-3 rounded-xl bg-gray-50/70">
                        <dt class="text-gray-400 font-semibold mb-0.5">Nama Lengkap</dt>
                        <dd class="font-bold text-gray-900">{{ $member->nama_lengkap }}</dd>
                    </div>

                    <div class="p-3 rounded-xl bg-gray-50/70">
                        <dt class="text-gray-400 font-semibold mb-0.5">Badan Otonom (BANOM)</dt>
                        <dd class="font-bold text-emerald-800">{{ $member->banom->nama ?? '-' }} ({{ $member->banom->singkatan ?? '-' }})</dd>
                    </div>

                    <div class="p-3 rounded-xl bg-gray-50/70">
                        <dt class="text-gray-400 font-semibold mb-0.5">Status Keanggotaan</dt>
                        <dd class="font-bold text-gray-900">
                            <span class="px-2 py-0.5 rounded-full text-[11px] font-bold {{ $member->status_keanggotaan === 'Kader' ? 'bg-amber-100 text-amber-900' : ($member->status_keanggotaan === 'Simpatisan' ? 'bg-blue-100 text-blue-900' : 'bg-gray-100 text-gray-800') }}">
                                {{ $member->status_keanggotaan ?? 'Anggota' }}
                            </span>
                        </dd>
                    </div>

                    <div class="p-3 rounded-xl bg-gray-50/70">
                        <dt class="text-gray-400 font-semibold mb-0.5">Tahun Masuk / Bai'at</dt>
                        <dd class="font-bold text-gray-900">{{ $member->tahun_masuk ?? '-' }}</dd>
                    </div>

                    <div class="p-3 rounded-xl bg-gray-50/70">
                        <dt class="text-gray-400 font-semibold mb-0.5">Jenis Kelamin</dt>
                        <dd class="font-bold text-gray-900">{{ $member->jenis_kelamin }}</dd>
                    </div>

                    <div class="p-3 rounded-xl bg-gray-50/70">
                        <dt class="text-gray-400 font-semibold mb-0.5">Tempat & Tanggal Lahir</dt>
                        <dd class="font-bold text-gray-900">
                            {{ $member->tempat_lahir ?? '-' }}, {{ $member->tanggal_lahir ? $member->tanggal_lahir->translatedFormat('d F Y') : '-' }}
                        </dd>
                    </div>

                    <div class="p-3 rounded-xl bg-gray-50/70">
                        <dt class="text-gray-400 font-semibold mb-0.5">Nomor Telepon / WhatsApp</dt>
                        <dd class="font-bold text-gray-900">{{ $member->nomor_telepon ?? '-' }}</dd>
                    </div>

                    <div class="p-3 rounded-xl bg-gray-50/70">
                        <dt class="text-gray-400 font-semibold mb-0.5">Email</dt>
                        <dd class="font-bold text-gray-900">{{ $member->email ?? '-' }}</dd>
                    </div>

                    <div class="p-3 rounded-xl bg-gray-50/70 sm:col-span-2">
                        <dt class="text-gray-400 font-semibold mb-0.5">Alamat Domisili</dt>
                        <dd class="font-medium text-gray-800">{{ $member->alamat ?? '-' }}</dd>
                    </div>

                    @if($member->keterangan)
                        <div class="p-3 rounded-xl bg-gray-50/70 sm:col-span-2">
                            <dt class="text-gray-400 font-semibold mb-0.5">Catatan / Keterangan</dt>
                            <dd class="font-medium text-gray-800">{{ $member->keterangan }}</dd>
                        </div>
                    @endif
                </dl>
            </div>

            <!-- Riwayat Kepengurusan Organisasi -->
            <div class="bg-white rounded-3xl p-6 border border-[#e6eeff] shadow-sm space-y-4">
                <div class="flex items-center justify-between border-b border-gray-100 pb-3">
                    <h3 class="text-sm font-bold text-[#004125] flex items-center gap-2">
                        <span class="material-symbols-outlined text-emerald-600 text-lg">account_tree</span>
                        <span>Riwayat / Penugasan di Struktur Pengurus</span>
                    </h3>
                    @if(!$member->activeOfficer)
                        <a href="{{ route('admin.banoms.officers.create', [$member->banom_id, 'member_id' => $member->id]) }}" class="inline-flex items-center gap-1 text-xs font-bold text-emerald-700 hover:text-emerald-900">
                            <span class="material-symbols-outlined text-sm">add</span>
                            <span>Tugaskan Sebagai Pengurus</span>
                        </a>
                    @endif
                </div>

                @if($member->officers && $member->officers->count() > 0)
                    <div class="space-y-3">
                        @foreach($member->officers as $officer)
                            <div class="p-4 rounded-2xl border {{ $officer->is_active ? 'border-emerald-200 bg-emerald-50/50' : 'border-gray-200 bg-gray-50/50' }} flex items-center justify-between gap-4">
                                <div>
                                    <div class="flex items-center gap-2">
                                        <span class="font-bold text-sm text-[#004125]">{{ $officer->display_jabatan }}</span>
                                        <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-white text-gray-700 border border-gray-200">
                                            {{ $officer->banom->singkatan }}
                                        </span>
                                        @if($officer->is_active)
                                            <span class="px-2 py-0.5 rounded-full text-[10px] font-extrabold bg-emerald-600 text-white">
                                                Aktif Menjabat
                                            </span>
                                        @else
                                            <span class="px-2 py-0.5 rounded-full text-[10px] font-semibold bg-gray-200 text-gray-600">
                                                Tidak Aktif / Demisioner
                                            </span>
                                        @endif
                                    </div>
                                    <div class="text-[11px] text-gray-500 mt-1">
                                        {{ $officer->banom->nama }}
                                        @if($officer->division) • Bagian: {{ $officer->division->nama }} @endif
                                    </div>
                                </div>
                                <div>
                                    <a href="{{ route('admin.banoms.officers.edit', [$officer->banom_id, $officer->id]) }}" class="px-3 py-1.5 rounded-xl bg-white border border-gray-200 hover:bg-emerald-50 hover:text-[#004125] text-xs font-bold text-gray-700 transition">
                                        Kelola
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="p-6 text-center text-gray-400 space-y-2">
                        <span class="material-symbols-outlined text-4xl text-gray-300">badge</span>
                        <p class="text-xs">Anggota ini belum pernah didaftarkan sebagai pengurus resmi di struktur organisasi.</p>
                        <a href="{{ route('admin.banoms.officers.create', [$member->banom_id, 'member_id' => $member->id]) }}" class="inline-flex items-center gap-1 text-xs font-bold text-[#004125] hover:underline">
                            <span class="material-symbols-outlined text-[14px]">person_add</span>
                            <span>Buka Form Pengurus untuk anggota ini</span>
                        </a>
                    </div>
                @endif
            </div>

        </div>
    </div>

</div>
@endsection
