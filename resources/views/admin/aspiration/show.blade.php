@extends('layouts.admin')

@section('title', 'Tindak Lanjut Aspirasi: ' . $aspiration->kode_tiket . ' — SIMNU Admin')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">

    <div class="flex items-center justify-between">
        <div>
            <nav class="flex items-center gap-2 text-xs text-gray-500 mb-1">
                <a href="{{ route('admin.dashboard') }}" class="hover:text-emerald-800">Admin</a>
                <span>/</span>
                <a href="{{ route('admin.aspirasi.index') }}" class="hover:text-emerald-800">Aspirasi</a>
                <span>/</span>
                <span class="text-gray-900 font-bold font-mono">{{ $aspiration->kode_tiket }}</span>
            </nav>
            <h1 class="text-2xl font-black text-[#004125]">Tindak Lanjut Aspirasi Warga</h1>
            <p class="text-xs text-[#526350]">Tinjau isi pesan masyarakat dan perbarui status penanganan oleh pengurus ranting.</p>
        </div>

        <a href="{{ route('admin.aspirasi.index') }}" class="px-3.5 py-2 rounded-xl border border-gray-300 hover:bg-gray-100 text-gray-700 text-xs font-bold transition flex items-center gap-1.5">
            <span class="material-symbols-outlined text-[16px]">arrow_back</span>
            <span>Kembali</span>
        </a>
    </div>

    <!-- 2 Column Layout: Citizen Message (7 cols) + Action Form (5 cols) -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">
        
        <!-- Left: Detail Pesan Warga (7 cols) -->
        <div class="lg:col-span-7 bg-white rounded-3xl p-6 sm:p-8 border border-[#e6eeff] shadow-sm space-y-6">
            <div class="border-b border-gray-100 pb-4 flex items-center justify-between">
                <div>
                    <span class="text-[10px] font-bold font-mono uppercase bg-emerald-50 text-[#004125] px-2 py-0.5 rounded">
                        TIKET: {{ $aspiration->kode_tiket }}
                    </span>
                    <h2 class="text-lg font-bold text-gray-900 mt-2">{{ $aspiration->subjek }}</h2>
                </div>
                <span class="px-2.5 py-0.5 rounded-full text-xs font-bold uppercase
                    {{ $aspiration->kategori === 'Pengaduan' ? 'bg-rose-100 text-rose-800' : 'bg-emerald-100 text-emerald-800' }}">
                    {{ $aspiration->kategori }}
                </span>
            </div>

            <!-- Sender Info -->
            <div class="grid grid-cols-2 gap-4 p-4 rounded-2xl bg-gray-50 text-xs">
                <div>
                    <span class="text-gray-400 block font-semibold text-[10px] uppercase">Nama Pengirim</span>
                    <strong class="text-gray-900 text-sm">{{ $aspiration->nama }}</strong>
                </div>
                <div>
                    <span class="text-gray-400 block font-semibold text-[10px] uppercase">Kontak / WhatsApp</span>
                    <div class="flex items-center gap-1 text-gray-800 font-medium">
                        <span>{{ $aspiration->kontak ?? '-' }}</span>
                        @if($aspiration->kontak && preg_match('/^[0-9+]+$/', $aspiration->kontak))
                            <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $aspiration->kontak) }}" target="_blank" class="text-emerald-700 hover:text-emerald-900" title="Kirim Pesan WhatsApp">
                                <span class="material-symbols-outlined text-sm">chat</span>
                            </a>
                        @endif
                    </div>
                </div>
                <div>
                    <span class="text-gray-400 block font-semibold text-[10px] uppercase">Waktu Kirim</span>
                    <span class="text-gray-700">{{ $aspiration->created_at->translatedFormat('d F Y, H:i') }} WIB</span>
                </div>
                <div>
                    <span class="text-gray-400 block font-semibold text-[10px] uppercase">Status Saat Ini</span>
                    <span class="font-bold text-emerald-800">{{ $aspiration->status }}</span>
                </div>
            </div>

            <!-- Content Message -->
            <div class="space-y-2">
                <span class="text-xs font-bold uppercase tracking-wider text-[#526350]">Uraian Pesan / Masukan Jama'ah:</span>
                <div class="p-4 rounded-2xl border border-gray-100 bg-[#fbfcfe] text-sm text-gray-800 leading-relaxed whitespace-pre-line">
                    {{ $aspiration->pesan }}
                </div>
            </div>
        </div>

        <!-- Right: Status Update Form & Internal Notes (5 cols) -->
        <div class="lg:col-span-5 space-y-6">
            
            <div class="bg-white rounded-3xl p-6 border border-[#e6eeff] shadow-sm space-y-5">
                <div class="flex items-center gap-2 border-b border-gray-100 pb-3">
                    <span class="material-symbols-outlined text-emerald-600 text-lg">admin_panel_settings</span>
                    <h3 class="text-sm font-bold text-[#004125]">Tindak Lanjut & Catatan Ranting</h3>
                </div>

                <form action="{{ route('admin.aspirasi.status', $aspiration->id) }}" method="POST" class="space-y-4">
                    @csrf
                    @method('PATCH')

                    <div class="space-y-1">
                        <label for="status" class="block text-xs font-bold uppercase text-[#004125]">
                            Perbarui Status <span class="text-red-500">*</span>
                        </label>
                        <select name="status" id="status" required class="w-full py-2.5 px-3 text-xs rounded-xl border border-gray-200 focus:border-[#0c5a37] text-gray-800 font-semibold">
                            <option value="Baru" {{ old('status', $aspiration->status) === 'Baru' ? 'selected' : '' }}>Baru (Baru Diterima)</option>
                            <option value="Dibaca" {{ old('status', $aspiration->status) === 'Dibaca' ? 'selected' : '' }}>Dibaca (Telah Dibaca)</option>
                            <option value="Diproses" {{ old('status', $aspiration->status) === 'Diproses' ? 'selected' : '' }}>Diproses (Sedang Ditindaklanjuti)</option>
                            <option value="Selesai" {{ old('status', $aspiration->status) === 'Selesai' ? 'selected' : '' }}>Selesai (Tuntas Ditangani)</option>
                        </select>
                    </div>

                    <div class="space-y-1">
                        <label for="catatan_admin" class="block text-xs font-bold uppercase text-[#004125]">
                            Catatan Tindak Lanjut / Tanggapan
                        </label>
                        <textarea name="catatan_admin" id="catatan_admin" rows="5" placeholder="Tuliskan catatan internal rapat pengurus atau tanggapan resmi yang dapat dilihat warga via lacak tiket..."
                            class="w-full py-2.5 px-3 text-xs rounded-xl border border-gray-200 focus:border-[#0c5a37] leading-relaxed">{{ old('catatan_admin', $aspiration->catatan_admin) }}</textarea>
                    </div>

                    <button type="submit" class="w-full py-2.5 px-4 rounded-xl bg-[#004125] hover:bg-[#0c5a37] text-white text-xs font-bold transition flex items-center justify-center gap-1.5 shadow-md">
                        <span class="material-symbols-outlined text-[16px]">save</span>
                        <span>Simpan Status & Tanggapan</span>
                    </button>
                </form>
            </div>

            <!-- Delete Danger Zone -->
            <div class="p-4 rounded-2xl bg-rose-50 border border-rose-200 flex items-center justify-between">
                <div>
                    <span class="text-xs font-bold text-rose-950 block">Hapus Aspirasi</span>
                    <span class="text-[11px] text-rose-800">Tindakan ini tidak dapat dibatalkan</span>
                </div>
                <form action="{{ route('admin.aspirasi.destroy', $aspiration->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data aspirasi ini?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="px-3 py-1.5 rounded-xl bg-rose-600 hover:bg-rose-700 text-white text-xs font-bold transition">
                        Hapus
                    </button>
                </form>
            </div>

        </div>

    </div>

</div>
@endsection
