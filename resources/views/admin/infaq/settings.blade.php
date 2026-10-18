@extends('layouts.admin')

@section('title', 'Pengaturan Rekening & QRIS Infaq — SIMNU Admin')

@section('content')
<div class="space-y-6 max-w-4xl">

    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <a href="{{ route('admin.infaq.index') }}" class="text-xs text-[#0c5a37] hover:underline flex items-center gap-1 mb-1 font-bold">
                <span class="material-symbols-outlined text-[16px]">arrow_back</span>
                <span>Kembali ke Audit Infaq</span>
            </a>
            <h1 class="text-2xl font-black text-[#004125]">Pengaturan Rekening & QRIS Infaq</h1>
            <p class="text-xs text-[#526350]">Atur nomor rekening tujuan transfer donasi dan gambar QRIS resmi PRNU Banjaranyar.</p>
        </div>
    </div>

    <!-- Settings Form Card -->
    <div class="bg-white rounded-3xl p-6 sm:p-8 border border-[#e6eeff] shadow-sm">
        <form action="{{ route('admin.infaq.settings.update') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PUT')

            <!-- Nama Program -->
            <div>
                <label for="nama_program" class="block text-xs font-bold text-gray-800 mb-1.5">
                    Nama Program Infaq <span class="text-red-500">*</span>
                </label>
                <input type="text" name="nama_program" id="nama_program" value="{{ old('nama_program', $setting->nama_program) }}" required class="w-full px-4 py-2.5 rounded-xl text-xs sm:text-sm border border-gray-200 focus:border-[#0c5a37] focus:outline-none">
            </div>

            <!-- Rekening Utama (BSI) -->
            <div class="p-5 rounded-2xl bg-[#f8f9ff] border border-[#dee9fc] space-y-4">
                <div class="flex items-center gap-2">
                    <span class="material-symbols-outlined text-[#004125]">account_balance</span>
                    <h3 class="text-xs font-bold text-[#004125] uppercase tracking-wider">Rekening Bank Utama</h3>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <div>
                        <label for="bank_utama_nama" class="block text-xs font-bold text-gray-800 mb-1">
                            Nama Bank <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="bank_utama_nama" id="bank_utama_nama" value="{{ old('bank_utama_nama', $setting->bank_utama_nama) }}" required class="w-full px-3 py-2 text-xs rounded-xl border border-gray-200 focus:border-[#0c5a37]">
                    </div>

                    <div>
                        <label for="bank_utama_rekening" class="block text-xs font-bold text-gray-800 mb-1">
                            Nomor Rekening <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="bank_utama_rekening" id="bank_utama_rekening" value="{{ old('bank_utama_rekening', $setting->bank_utama_rekening) }}" required class="w-full px-3 py-2 text-xs font-mono rounded-xl border border-gray-200 focus:border-[#0c5a37]">
                    </div>

                    <div>
                        <label for="bank_utama_atas_nama" class="block text-xs font-bold text-gray-800 mb-1">
                            Atas Nama (Rekening) <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="bank_utama_atas_nama" id="bank_utama_atas_nama" value="{{ old('bank_utama_atas_nama', $setting->bank_utama_atas_nama) }}" required class="w-full px-3 py-2 text-xs rounded-xl border border-gray-200 focus:border-[#0c5a37]">
                    </div>
                </div>
            </div>

            <!-- Rekening Kedua (Bank Jatim / Lokal) -->
            <div class="p-5 rounded-2xl bg-[#f8f9ff] border border-[#dee9fc] space-y-4">
                <div class="flex items-center gap-2">
                    <span class="material-symbols-outlined text-[#004125]">account_balance</span>
                    <h3 class="text-xs font-bold text-[#004125] uppercase tracking-wider">Rekening Bank Cadangan / Lokal</h3>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <div>
                        <label for="bank_kedua_nama" class="block text-xs font-bold text-gray-800 mb-1">Nama Bank</label>
                        <input type="text" name="bank_kedua_nama" id="bank_kedua_nama" value="{{ old('bank_kedua_nama', $setting->bank_kedua_nama) }}" class="w-full px-3 py-2 text-xs rounded-xl border border-gray-200 focus:border-[#0c5a37]">
                    </div>

                    <div>
                        <label for="bank_kedua_rekening" class="block text-xs font-bold text-gray-800 mb-1">Nomor Rekening</label>
                        <input type="text" name="bank_kedua_rekening" id="bank_kedua_rekening" value="{{ old('bank_kedua_rekening', $setting->bank_kedua_rekening) }}" class="w-full px-3 py-2 text-xs font-mono rounded-xl border border-gray-200 focus:border-[#0c5a37]">
                    </div>

                    <div>
                        <label for="bank_kedua_atas_nama" class="block text-xs font-bold text-gray-800 mb-1">Atas Nama (Rekening)</label>
                        <input type="text" name="bank_kedua_atas_nama" id="bank_kedua_atas_nama" value="{{ old('bank_kedua_atas_nama', $setting->bank_kedua_atas_nama) }}" class="w-full px-3 py-2 text-xs rounded-xl border border-gray-200 focus:border-[#0c5a37]">
                    </div>
                </div>
            </div>

            <!-- QRIS Upload & WhatsApp Kontak -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                <!-- QRIS Image -->
                <div class="border border-gray-200 p-4 rounded-2xl space-y-3">
                    <label class="block text-xs font-bold text-gray-800">
                        Gambar QRIS Infaq Resmi
                    </label>
                    @if($setting->qris_image)
                        <div class="w-28 h-28 rounded-xl border border-gray-300 p-1 bg-white">
                            <img src="{{ asset('storage/' . $setting->qris_image) }}" alt="QRIS" class="w-full h-full object-contain">
                        </div>
                    @endif
                    <input type="file" name="qris_image" accept="image/*" class="text-xs text-gray-600 file:mr-3 file:py-1 file:px-2.5 file:rounded-lg file:border-0 file:text-xs file:font-bold file:bg-[#eff4ff] file:text-[#004125]">
                </div>

                <!-- WhatsApp Konfirmasi -->
                <div>
                    <label for="nomor_whatsapp_konfirmasi" class="block text-xs font-bold text-gray-800 mb-1.5">
                        Nomor WhatsApp Sekretariat LAZISNU
                    </label>
                    <input type="text" name="nomor_whatsapp_konfirmasi" id="nomor_whatsapp_konfirmasi" value="{{ old('nomor_whatsapp_konfirmasi', $setting->nomor_whatsapp_konfirmasi) }}" placeholder="Contoh: 081234567890" class="w-full px-4 py-2.5 rounded-xl text-xs sm:text-sm border border-gray-200 focus:border-[#0c5a37]">
                </div>
            </div>

            <!-- Pesan Amanah & Transparansi -->
            <div>
                <label for="pesan_amanah" class="block text-xs font-bold text-gray-800 mb-1.5">
                    Kalimat Komitmen Amanah & Transparansi
                </label>
                <textarea name="pesan_amanah" id="pesan_amanah" rows="3" class="w-full px-4 py-2.5 rounded-xl text-xs sm:text-sm border border-gray-200 focus:border-[#0c5a37]">{{ old('pesan_amanah', $setting->pesan_amanah) }}</textarea>
            </div>

            <!-- Submit Button -->
            <div class="pt-4 border-t border-gray-100 flex flex-col-reverse sm:flex-row items-stretch sm:items-center justify-end gap-3">
                <a href="{{ route('admin.infaq.index') }}" class="min-h-[44px] px-5 py-2.5 rounded-xl border border-gray-300 text-gray-700 text-xs font-bold hover:bg-gray-100 transition flex items-center justify-center">
                    Batal
                </a>
                <button type="submit" class="min-h-[44px] px-6 py-2.5 rounded-xl bg-[#004125] hover:bg-[#0c5a37] text-white text-xs font-bold transition shadow-md flex items-center justify-center gap-2">
                    <span class="material-symbols-outlined text-[18px]">save</span>
                    <span>Simpan Pengaturan Infaq</span>
                </button>
            </div>
        </form>
    </div>

</div>
@endsection
