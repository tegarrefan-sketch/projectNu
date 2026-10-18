@extends('layouts.admin')

@section('title', 'Kelola Profil Organisasi PRNU — SIMNU Admin')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">

    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <nav class="flex items-center gap-2 text-xs text-gray-500 mb-1">
                <a href="{{ route('admin.dashboard') }}" class="hover:text-emerald-800">Admin</a>
                <span>/</span>
                <span class="text-gray-900 font-bold">Profil Organisasi</span>
            </nav>
            <h1 class="text-2xl font-black text-[#004125]">Pengaturan Profil & Identitas Ranting</h1>
            <p class="text-xs text-[#526350]">Kelola narasi sejarah, visi, misi, nilai Aswaja, SK kepengurusan, dan alamat resmi PRNU Banjaranyar.</p>
        </div>

        <a href="{{ route('profile') }}" target="_blank" class="self-start sm:self-auto px-3.5 py-2 rounded-xl border border-gray-300 hover:bg-gray-100 text-gray-700 text-xs font-bold transition flex items-center gap-1.5 min-h-[44px]">
            <span class="material-symbols-outlined text-[16px]">open_in_new</span>
            <span>Lihat Halaman Publik</span>
        </a>
    </div>

    <!-- Edit Form Card -->
    <div class="bg-white rounded-3xl p-6 sm:p-8 border border-[#e6eeff] shadow-sm">
        <form action="{{ route('admin.profil.update') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PUT')

            <!-- Section 1: Identitas Pokok -->
            <div class="space-y-4">
                <h3 class="text-sm font-bold text-[#004125] flex items-center gap-2 border-b border-gray-100 pb-2">
                    <span class="material-symbols-outlined text-emerald-600 text-base">corporate_fare</span>
                    <span>1. Identitas Pokok Kepengurusan Ranting</span>
                </h3>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div class="space-y-1 sm:col-span-2">
                        <label for="nama_organisasi" class="block text-xs font-bold uppercase text-[#004125]">
                            Nama Resmi Organisasi <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="nama_organisasi" id="nama_organisasi" value="{{ old('nama_organisasi', $profile->nama_organisasi) }}" required
                            class="w-full py-2.5 px-3 text-xs rounded-xl border border-gray-200 focus:border-[#0c5a37] font-bold text-gray-900">
                    </div>

                    <div class="space-y-1">
                        <label for="tingkat" class="block text-xs font-bold uppercase text-[#004125]">
                            Tingkatan Organisasi <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="tingkat" id="tingkat" value="{{ old('tingkat', $profile->tingkat) }}" required
                            class="w-full py-2.5 px-3 text-xs rounded-xl border border-gray-200 focus:border-[#0c5a37]">
                    </div>

                    <div class="space-y-1">
                        <label for="masa_khidmat" class="block text-xs font-bold uppercase text-[#004125]">
                            Masa Khidmat Amanah
                        </label>
                        <input type="text" name="masa_khidmat" id="masa_khidmat" value="{{ old('masa_khidmat', $profile->masa_khidmat) }}" placeholder="Contoh: 2024 - 2029"
                            class="w-full py-2.5 px-3 text-xs rounded-xl border border-gray-200 focus:border-[#0c5a37]">
                    </div>

                    <div class="space-y-1">
                        <label for="kecamatan" class="block text-xs font-bold uppercase text-[#004125]">Kecamatan <span class="text-red-500">*</span></label>
                        <input type="text" name="kecamatan" id="kecamatan" value="{{ old('kecamatan', $profile->kecamatan) }}" required
                            class="w-full py-2.5 px-3 text-xs rounded-xl border border-gray-200 focus:border-[#0c5a37]">
                    </div>

                    <div class="space-y-1">
                        <label for="kabupaten" class="block text-xs font-bold uppercase text-[#004125]">Kabupaten / Kota <span class="text-red-500">*</span></label>
                        <input type="text" name="kabupaten" id="kabupaten" value="{{ old('kabupaten', $profile->kabupaten) }}" required
                            class="w-full py-2.5 px-3 text-xs rounded-xl border border-gray-200 focus:border-[#0c5a37]">
                    </div>

                    <div class="space-y-1">
                        <label for="provinsi" class="block text-xs font-bold uppercase text-[#004125]">Provinsi <span class="text-red-500">*</span></label>
                        <input type="text" name="provinsi" id="provinsi" value="{{ old('provinsi', $profile->provinsi) }}" required
                            class="w-full py-2.5 px-3 text-xs rounded-xl border border-gray-200 focus:border-[#0c5a37]">
                    </div>

                    <div class="space-y-1">
                        <label for="sk_nomor" class="block text-xs font-bold uppercase text-[#004125]">Nomor SK Pengesahan PCNU</label>
                        <input type="text" name="sk_nomor" id="sk_nomor" value="{{ old('sk_nomor', $profile->sk_nomor) }}"
                            class="w-full py-2.5 px-3 text-xs rounded-xl border border-gray-200 focus:border-[#0c5a37]">
                    </div>

                    <div class="space-y-1 sm:col-span-2">
                        <label for="deskripsi_singkat" class="block text-xs font-bold uppercase text-[#004125]">
                            Deskripsi Singkat (Tampil di Hero Beranda)
                        </label>
                        <textarea name="deskripsi_singkat" id="deskripsi_singkat" rows="2"
                            class="w-full py-2 px-3 text-xs rounded-xl border border-gray-200 focus:border-[#0c5a37]">{{ old('deskripsi_singkat', $profile->deskripsi_singkat) }}</textarea>
                    </div>
                </div>
            </div>

            <!-- Section 2: Visi, Misi, Nilai & Sejarah -->
            <div class="space-y-4 pt-2">
                <h3 class="text-sm font-bold text-[#004125] flex items-center gap-2 border-b border-gray-100 pb-2">
                    <span class="material-symbols-outlined text-emerald-600 text-base">auto_stories</span>
                    <span>2. Visi, Misi, Nilai Aswaja & Sejarah</span>
                </h3>

                <div class="space-y-4">
                    <div class="space-y-1">
                        <label for="visi" class="block text-xs font-bold uppercase text-[#004125]">Visi Organisasi</label>
                        <textarea name="visi" id="visi" rows="2"
                            class="w-full py-2 px-3 text-xs rounded-xl border border-gray-200 focus:border-[#0c5a37]">{{ old('visi', $profile->visi) }}</textarea>
                    </div>

                    <div class="space-y-1">
                        <label for="misi" class="block text-xs font-bold uppercase text-[#004125]">Misi Organisasi</label>
                        <textarea name="misi" id="misi" rows="4"
                            class="w-full py-2 px-3 text-xs rounded-xl border border-gray-200 focus:border-[#0c5a37]">{{ old('misi', $profile->misi) }}</textarea>
                    </div>

                    <div class="space-y-1">
                        <label for="tujuan" class="block text-xs font-bold uppercase text-[#004125]">Tujuan Khidmat</label>
                        <textarea name="tujuan" id="tujuan" rows="3"
                            class="w-full py-2 px-3 text-xs rounded-xl border border-gray-200 focus:border-[#0c5a37]">{{ old('tujuan', $profile->tujuan) }}</textarea>
                    </div>

                    <div class="space-y-1">
                        <label for="nilai_organisasi" class="block text-xs font-bold uppercase text-[#004125]">Prinsip / Nilai-Nilai Dasar (Tawassuth, Tawazun, I'tidal, Tasamuh)</label>
                        <textarea name="nilai_organisasi" id="nilai_organisasi" rows="3"
                            class="w-full py-2 px-3 text-xs rounded-xl border border-gray-200 focus:border-[#0c5a37]">{{ old('nilai_organisasi', $profile->nilai_organisasi) }}</textarea>
                    </div>

                    <div class="space-y-1">
                        <label for="sejarah" class="block text-xs font-bold uppercase text-[#004125]">Sejarah Berdirinya NU di Desa Banjaranyar</label>
                        <textarea name="sejarah" id="sejarah" rows="5"
                            class="w-full py-2 px-3 text-xs rounded-xl border border-gray-200 focus:border-[#0c5a37] leading-relaxed">{{ old('sejarah', $profile->sejarah) }}</textarea>
                    </div>
                </div>
            </div>

            <!-- Section 3: Kontak & Sekretariat -->
            <div class="space-y-4 pt-2">
                <h3 class="text-sm font-bold text-[#004125] flex items-center gap-2 border-b border-gray-100 pb-2">
                    <span class="material-symbols-outlined text-emerald-600 text-base">contact_phone</span>
                    <span>3. Kontak & Alamat Sekretariat</span>
                </h3>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div class="space-y-1 sm:col-span-2">
                        <label for="alamat" class="block text-xs font-bold uppercase text-[#004125]">Alamat Lengkap Sekretariat <span class="text-red-500">*</span></label>
                        <input type="text" name="alamat" id="alamat" value="{{ old('alamat', $profile->alamat) }}" required
                            class="w-full py-2.5 px-3 text-xs rounded-xl border border-gray-200 focus:border-[#0c5a37]">
                    </div>

                    <div class="space-y-1">
                        <label for="kontak_telepon" class="block text-xs font-bold uppercase text-[#004125]">Nomor Telepon / WhatsApp <span class="text-red-500">*</span></label>
                        <input type="text" name="kontak_telepon" id="kontak_telepon" value="{{ old('kontak_telepon', $profile->kontak_telepon) }}" required
                            class="w-full py-2.5 px-3 text-xs rounded-xl border border-gray-200 focus:border-[#0c5a37]">
                    </div>

                    <div class="space-y-1">
                        <label for="kontak_email" class="block text-xs font-bold uppercase text-[#004125]">Alamat Email Resmi <span class="text-red-500">*</span></label>
                        <input type="email" name="kontak_email" id="kontak_email" value="{{ old('kontak_email', $profile->kontak_email) }}" required
                            class="w-full py-2.5 px-3 text-xs rounded-xl border border-gray-200 focus:border-[#0c5a37]">
                    </div>
                </div>
            </div>

            <!-- Section 4: Gambar & Banner -->
            <div class="space-y-4 pt-2">
                <h3 class="text-sm font-bold text-[#004125] flex items-center gap-2 border-b border-gray-100 pb-2">
                    <span class="material-symbols-outlined text-emerald-600 text-base">photo_library</span>
                    <span>4. Logo & Banner Beranda</span>
                </h3>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    <div class="space-y-2">
                        <label class="block text-xs font-bold uppercase text-[#004125]">Logo Resmi Ranting</label>
                        <div class="flex items-center gap-3">
                            <div class="w-14 h-14 rounded-2xl bg-gray-50 border border-gray-200 flex items-center justify-center p-2 shrink-0">
                                @if($profile->logo)
                                    <img src="{{ asset('storage/' . $profile->logo) }}" alt="Logo" class="w-full h-full object-contain">
                                @else
                                    <span class="material-symbols-outlined text-emerald-700 text-2xl">mosque</span>
                                @endif
                            </div>
                            <input type="file" name="logo" id="logo" accept="image/*" class="w-full text-xs text-gray-500 file:mr-2 file:py-1.5 file:px-2.5 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-emerald-50 file:text-[#004125]">
                        </div>
                    </div>

                    <div class="space-y-2">
                        <label class="block text-xs font-bold uppercase text-[#004125]">Banner Hero Beranda</label>
                        <div class="flex items-center gap-3">
                            <div class="w-20 h-14 rounded-xl bg-gray-50 border border-gray-200 flex items-center justify-center overflow-hidden shrink-0">
                                @if($profile->hero_image)
                                    <img src="{{ asset('storage/' . $profile->hero_image) }}" alt="Hero" class="w-full h-full object-cover">
                                @else
                                    <span class="material-symbols-outlined text-gray-400 text-lg">panorama</span>
                                @endif
                            </div>
                            <input type="file" name="hero_image" id="hero_image" accept="image/*" class="w-full text-xs text-gray-500 file:mr-2 file:py-1.5 file:px-2.5 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-emerald-50 file:text-[#004125]">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Submit -->
            <div class="pt-4 border-t border-gray-100 flex items-center justify-end gap-3">
                <button type="submit" class="px-6 py-2.5 rounded-xl bg-[#004125] hover:bg-[#0c5a37] text-white text-xs font-extrabold transition flex items-center gap-1.5 shadow-md">
                    <span class="material-symbols-outlined text-[16px]">save</span>
                    <span>Simpan Profil Organisasi</span>
                </button>
            </div>
        </form>
    </div>

</div>
@endsection
