@extends('layouts.admin')

@section('title', 'Edit Data Kader: ' . $member->nama_lengkap . ' — SIMNU Admin')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">

    <!-- Top Navigation -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <nav class="flex items-center gap-2 text-xs text-gray-500 mb-1">
                <a href="{{ route('admin.dashboard') }}" class="hover:text-emerald-800">Admin</a>
                <span>/</span>
                <a href="{{ route('admin.anggota.index') }}" class="hover:text-emerald-800">Kader</a>
                <span>/</span>
                <span class="text-gray-900 font-bold font-mono">{{ $member->nomor_anggota }}</span>
            </nav>
            <h1 class="text-2xl font-black text-[#004125]">Edit Data Anggota / Kader</h1>
            <p class="text-xs text-[#526350]">Perbarui informasi identitas, afiliasi kepengurusan, atau pas foto kader.</p>
        </div>

        <a href="{{ route('admin.anggota.index') }}" class="w-full sm:w-auto px-4 py-2.5 rounded-xl border border-gray-300 hover:bg-gray-100 text-gray-700 text-xs font-bold transition flex items-center justify-center gap-1.5 min-h-[44px]">
            <span class="material-symbols-outlined text-[16px]">arrow_back</span>
            <span>Kembali</span>
        </a>
    </div>

    <!-- KTA Status Quick Banner -->
    <div class="p-4 rounded-2xl bg-white border border-[#e6eeff] shadow-sm flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl bg-emerald-50 text-[#004125] flex items-center justify-center shrink-0">
                <span class="material-symbols-outlined text-[20px]">id_card</span>
            </div>
            <div>
                <span class="text-[11px] font-bold uppercase text-gray-400">Status KTA Anggota</span>
                <div class="text-sm font-extrabold text-gray-900">
                    @if($member->kta)
                        Nomor Seri: <span class="font-mono text-emerald-800">{{ $member->kta->nomor_kta }}</span>
                        ({{ $member->kta->status }})
                    @else
                        Belum Diterbitkan KTA
                    @endif
                </div>
            </div>
        </div>

        <div>
            @if($member->kta)
                <a href="{{ route('admin.kta.show', $member->kta->id) }}" class="px-3 py-2 rounded-xl bg-emerald-50 hover:bg-emerald-100 text-emerald-900 text-xs font-bold transition flex items-center gap-1">
                    <span class="material-symbols-outlined text-[15px]">visibility</span>
                    <span>Buka KTA Studio</span>
                </a>
            @else
                <form action="{{ route('admin.kta.generate', $member->id) }}" method="POST">
                    @csrf
                    <button type="submit" class="px-3.5 py-2 rounded-xl bg-[#0c5a37] hover:bg-[#004125] text-white text-xs font-bold transition flex items-center gap-1 shadow-sm">
                        <span class="material-symbols-outlined text-[15px]">auto_fix_high</span>
                        <span>Terbitkan KTA Sekarang</span>
                    </button>
                </form>
            @endif
        </div>
    </div>

    <!-- Edit Form Card -->
    <div class="bg-white rounded-3xl p-6 sm:p-8 border border-[#e6eeff] shadow-sm">
        <form action="{{ route('admin.anggota.update', $member->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PUT')

            <!-- Section 1 -->
            <div class="space-y-4">
                <h3 class="text-sm font-bold text-[#004125] flex items-center gap-2 border-b border-gray-100 pb-2">
                    <span class="material-symbols-outlined text-emerald-600 text-base">account_tree</span>
                    <span>1. Afiliasi Badan Otonom & Organisasi</span>
                </h3>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div class="space-y-1">
                        <label for="banom_id" class="block text-xs font-bold uppercase text-[#004125]">
                            Badan Otonom (BANOM) <span class="text-red-500">*</span>
                        </label>
                        <select name="banom_id" id="banom_id" required class="w-full py-2.5 px-3 text-xs rounded-xl border border-gray-200 focus:border-[#0c5a37]">
                            @foreach($banoms as $b)
                                <option value="{{ $b->id }}" {{ old('banom_id', $member->banom_id) == $b->id ? 'selected' : '' }}>
                                    {{ $b->singkatan }} - {{ $b->nama }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="space-y-1">
                        <label for="nomor_anggota" class="block text-xs font-bold uppercase text-[#004125]">
                            Nomor Induk Anggota (NIA) <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="nomor_anggota" id="nomor_anggota" value="{{ old('nomor_anggota', $member->nomor_anggota) }}" required
                            class="w-full py-2.5 px-3 text-xs rounded-xl border border-gray-200 focus:border-[#0c5a37] font-mono font-bold text-gray-800">
                    </div>
                </div>
            </div>

            <!-- Section 2 -->
            <div class="space-y-4 pt-2">
                <h3 class="text-sm font-bold text-[#004125] flex items-center gap-2 border-b border-gray-100 pb-2">
                    <span class="material-symbols-outlined text-emerald-600 text-base">person</span>
                    <span>2. Identitas Kader Pribadi</span>
                </h3>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div class="space-y-1 sm:col-span-2">
                        <label for="nama_lengkap" class="block text-xs font-bold uppercase text-[#004125]">
                            Nama Lengkap <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="nama_lengkap" id="nama_lengkap" value="{{ old('nama_lengkap', $member->nama_lengkap) }}" required
                            class="w-full py-2.5 px-3 text-xs rounded-xl border border-gray-200 focus:border-[#0c5a37] font-semibold text-gray-900">
                    </div>

                    <div class="space-y-1">
                        <label for="jenis_kelamin" class="block text-xs font-bold uppercase text-[#004125]">
                            Jenis Kelamin <span class="text-red-500">*</span>
                        </label>
                        <select name="jenis_kelamin" id="jenis_kelamin" required class="w-full py-2.5 px-3 text-xs rounded-xl border border-gray-200 focus:border-[#0c5a37]">
                            <option value="Laki-laki" {{ old('jenis_kelamin', $member->jenis_kelamin) == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                            <option value="Perempuan" {{ old('jenis_kelamin', $member->jenis_kelamin) == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                        </select>
                    </div>

                    <div class="space-y-1">
                        <label for="tempat_lahir" class="block text-xs font-bold uppercase text-[#004125]">
                            Tempat Lahir
                        </label>
                        <input type="text" name="tempat_lahir" id="tempat_lahir" value="{{ old('tempat_lahir', $member->tempat_lahir) }}"
                            class="w-full py-2.5 px-3 text-xs rounded-xl border border-gray-200 focus:border-[#0c5a37]">
                    </div>

                    <div class="space-y-1">
                        <label for="tanggal_lahir" class="block text-xs font-bold uppercase text-[#004125]">
                            Tanggal Lahir
                        </label>
                        <input type="date" name="tanggal_lahir" id="tanggal_lahir" value="{{ old('tanggal_lahir', $member->tanggal_lahir ? $member->tanggal_lahir->format('Y-m-d') : '') }}"
                            class="w-full py-2.5 px-3 text-xs rounded-xl border border-gray-200 focus:border-[#0c5a37]">
                    </div>

                    <div class="space-y-1">
                        <label for="nomor_telepon" class="block text-xs font-bold uppercase text-[#004125]">
                            Nomor WhatsApp / Telepon
                        </label>
                        <input type="text" name="nomor_telepon" id="nomor_telepon" value="{{ old('nomor_telepon', $member->nomor_telepon) }}"
                            class="w-full py-2.5 px-3 text-xs rounded-xl border border-gray-200 focus:border-[#0c5a37]">
                    </div>

                    <div class="space-y-1 sm:col-span-2">
                        <label for="alamat" class="block text-xs font-bold uppercase text-[#004125]">
                            Alamat Domisili Lengkap
                        </label>
                        <textarea name="alamat" id="alamat" rows="2"
                            class="w-full py-2 px-3 text-xs rounded-xl border border-gray-200 focus:border-[#0c5a37]">{{ old('alamat', $member->alamat) }}</textarea>
                    </div>
                </div>
            </div>

            <!-- Section 3 -->
            <div class="space-y-4 pt-2">
                <h3 class="text-sm font-bold text-[#004125] flex items-center gap-2 border-b border-gray-100 pb-2">
                    <span class="material-symbols-outlined text-emerald-600 text-base">work</span>
                    <span>3. Amanah & Status Keaktifan</span>
                </h3>

                @if($member->activeOfficer)
                    <div class="p-3 bg-emerald-50 border border-emerald-200 rounded-xl flex items-center gap-2 text-xs text-emerald-900">
                        <span class="material-symbols-outlined text-emerald-700 text-base">verified</span>
                        <span>Anggota ini terdaftar sebagai <strong>Pengurus Aktif: {{ $member->activeOfficer->display_jabatan }}</strong> di <strong>{{ $member->activeOfficer->banom->singkatan }}</strong>. Jabatan resmi KTA akan otomatis mengikuti kepengurusan ini.</span>
                    </div>
                @endif

                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <div class="space-y-1">
                        <label for="status_keanggotaan" class="block text-xs font-bold uppercase text-[#004125]">
                            Status Keanggotaan <span class="text-red-500">*</span>
                        </label>
                        <select name="status_keanggotaan" id="status_keanggotaan" required class="w-full py-2.5 px-3 text-xs rounded-xl border border-gray-200 focus:border-[#0c5a37]">
                            <option value="Anggota" {{ old('status_keanggotaan', $member->status_keanggotaan ?? 'Anggota') == 'Anggota' ? 'selected' : '' }}>Anggota</option>
                            <option value="Kader" {{ old('status_keanggotaan', $member->status_keanggotaan ?? 'Kader') == 'Kader' ? 'selected' : '' }}>Kader</option>
                            <option value="Simpatisan" {{ old('status_keanggotaan', $member->status_keanggotaan ?? '') == 'Simpatisan' ? 'selected' : '' }}>Simpatisan</option>
                        </select>
                        <p class="text-[10px] text-gray-500">Jabatan struktural resmi dikelola melalui menu <strong>Pengurus</strong>.</p>
                    </div>

                    <div class="space-y-1">
                        <label for="tahun_masuk" class="block text-xs font-bold uppercase text-[#004125]">
                            Tahun Masuk / Bai'at
                        </label>
                        <input type="number" name="tahun_masuk" id="tahun_masuk" value="{{ old('tahun_masuk', $member->tahun_masuk) }}" min="1950" max="2050"
                            class="w-full py-2.5 px-3 text-xs rounded-xl border border-gray-200 focus:border-[#0c5a37]">
                    </div>

                    <div class="space-y-1">
                        <label for="status" class="block text-xs font-bold uppercase text-[#004125]">
                            Status Keaktifan <span class="text-red-500">*</span>
                        </label>
                        <select name="status" id="status" required class="w-full py-2.5 px-3 text-xs rounded-xl border border-gray-200 focus:border-[#0c5a37]">
                            <option value="Aktif" {{ old('status', $member->status) == 'Aktif' ? 'selected' : '' }}>Aktif</option>
                            <option value="Tidak Aktif" {{ old('status', $member->status) == 'Tidak Aktif' ? 'selected' : '' }}>Tidak Aktif</option>
                            <option value="Alumni" {{ old('status', $member->status) == 'Alumni' ? 'selected' : '' }}>Alumni</option>
                        </select>
                    </div>
                </div>
            </div>

            <!-- Section 4: Foto Profil -->
            <div class="space-y-4 pt-2">
                <h3 class="text-sm font-bold text-[#004125] flex items-center gap-2 border-b border-gray-100 pb-2">
                    <span class="material-symbols-outlined text-emerald-600 text-base">photo_camera</span>
                    <span>4. Pas Foto Kader</span>
                </h3>

                <div class="flex items-center gap-6">
                    <div class="w-20 h-24 rounded-2xl bg-gray-100 border border-gray-200 overflow-hidden flex items-center justify-center shrink-0">
                        @if($member->foto)
                            <img src="{{ asset('storage/' . $member->foto) }}" alt="{{ $member->nama_lengkap }}" class="w-full h-full object-cover">
                        @else
                            <span class="material-symbols-outlined text-gray-400 text-4xl">person</span>
                        @endif
                    </div>

                    <div class="space-y-2 flex-1">
                        <label for="foto" class="block text-xs font-bold uppercase text-[#004125]">
                            Ganti Pas Foto (Opsional)
                        </label>
                        <input type="file" name="foto" id="foto" accept="image/*"
                            class="w-full text-xs text-gray-500 file:mr-3 file:py-2 file:px-3 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-emerald-50 file:text-[#004125] hover:file:bg-emerald-100">
                        <p class="text-[10px] text-gray-400">Kosongkan jika tidak ingin mengubah foto saat ini.</p>
                    </div>
                </div>
            </div>

            <!-- Submit -->
            <div class="pt-4 border-t border-gray-100 flex flex-col sm:flex-row items-stretch sm:items-center justify-end gap-3">
                <a href="{{ route('admin.anggota.index') }}" class="px-5 py-2.5 rounded-xl border border-gray-300 hover:bg-gray-100 text-gray-700 text-xs font-bold transition text-center min-h-[44px] flex items-center justify-center">
                    Batal
                </a>
                <button type="submit" class="px-6 py-2.5 rounded-xl bg-[#004125] hover:bg-[#0c5a37] text-white text-xs font-extrabold transition flex items-center justify-center gap-1.5 shadow-md min-h-[44px]">
                    <span class="material-symbols-outlined text-[16px]">save</span>
                    <span>Simpan Perubahan</span>
                </button>
            </div>

        </form>
    </div>

</div>
@endsection
