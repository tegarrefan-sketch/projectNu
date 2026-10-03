@extends('layouts.admin')

@section('title', 'KTA Studio & Preview: ' . $kta->nomor_kta . ' — SIMNU Admin')

@push('styles')
<style>
    .card-perspective {
        perspective: 1200px;
    }
    .card-flipper {
        transition: transform 0.6s cubic-bezier(0.4, 0.2, 0.2, 1);
        transform-style: preserve-3d;
    }
    .card-flipper.is-flipped {
        transform: rotateY(180deg);
    }
    .card-face {
        backface-visibility: hidden;
        -webkit-backface-visibility: hidden;
    }
    .card-back {
        transform: rotateY(180deg);
    }
</style>
@endpush

@section('content')
<div class="space-y-8">
    
    <!-- Top Bar Navigation & Actions -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <nav class="flex items-center gap-2 text-xs text-gray-500 mb-1">
                <a href="{{ route('admin.dashboard') }}" class="hover:text-emerald-800">Admin</a>
                <span>/</span>
                <a href="{{ route('admin.kta.index') }}" class="hover:text-emerald-800">KTA</a>
                <span>/</span>
                <span class="text-gray-900 font-bold font-mono">{{ $kta->nomor_kta }}</span>
            </nav>
            <h1 class="text-2xl font-black text-[#004125] flex items-center gap-2">
                <span>Studio Desain & Validasi KTA</span>
                <span class="px-2.5 py-0.5 rounded-full text-xs font-bold uppercase tracking-wider {{ $kta->status === 'Aktif' ? 'bg-emerald-100 text-emerald-800' : 'bg-gray-100 text-gray-700' }}">
                    {{ $kta->status }}
                </span>
            </h1>
        </div>

        <!-- Action Buttons -->
        <div class="flex flex-wrap items-center gap-2">
            <button type="button" onclick="flipCard()" class="px-3.5 py-2.5 rounded-xl border border-gray-200 bg-white hover:bg-gray-50 text-gray-700 text-xs font-bold transition flex items-center gap-1.5 shadow-sm">
                <span class="material-symbols-outlined text-[16px] text-emerald-700">flip</span>
                <span>Balik Kartu (Depan / Belakang)</span>
            </button>
            <a href="{{ route('admin.kta.print', $kta->id) }}" target="_blank" class="px-3.5 py-2.5 rounded-xl bg-[#0c5a37] hover:bg-[#004125] text-white text-xs font-bold transition flex items-center gap-1.5 shadow-sm">
                <span class="material-symbols-outlined text-[16px]">print</span>
                <span>Cetak PVC Satuan</span>
            </a>
            <a href="{{ route('admin.kta.download', $kta->id) }}" class="px-3.5 py-2.5 rounded-xl bg-blue-600 hover:bg-blue-700 text-white text-xs font-bold transition flex items-center gap-1.5 shadow-sm">
                <span class="material-symbols-outlined text-[16px]">download</span>
                <span>Unduh File Cetak / PDF</span>
            </a>
        </div>
    </div>

    <!-- 2 Column Layout: Interactive 3D Card Studio (7 cols) + Details & Status Config (5 cols) -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
        
        <!-- Left Column: Card Stage (7 cols) -->
        <div class="lg:col-span-7 bg-[#f2f4f8] rounded-3xl p-6 sm:p-10 border border-[#e6eeff] flex flex-col items-center justify-center space-y-6">
            
            <div class="flex items-center justify-between w-full max-w-[480px]">
                <div class="flex items-center gap-2">
                    <span class="w-2.5 h-2.5 rounded-full bg-emerald-600"></span>
                    <span class="text-xs font-bold text-gray-700" id="cardSideLabel">Tampak Sisi Depan (Front)</span>
                </div>
                <span class="text-[11px] text-gray-500 font-mono">ISO/IEC 7810 ID-1 (85.6 × 54 mm)</span>
            </div>

            <!-- Perspective Container -->
            <div class="card-perspective w-full max-w-[460px] aspect-[85.6/54] relative cursor-pointer" onclick="flipCard()" title="Klik untuk membalik kartu">
                
                <div id="cardFlipper" class="card-flipper w-full h-full relative">
                    
                    <!-- ================= CARD FRONT ================= -->
                    <div class="card-face absolute inset-0 rounded-2xl bg-gradient-to-br from-[#003820] via-[#004d2c] to-[#012616] text-white p-5 sm:p-6 shadow-2xl border border-emerald-500/40 flex flex-col justify-between overflow-hidden select-none">
                        <!-- Background Gold & Green Watermarks -->
                        <div class="absolute -right-12 -bottom-12 w-48 h-48 rounded-full bg-emerald-500/10 blur-2xl pointer-events-none"></div>
                        <div class="absolute -left-10 -top-10 w-40 h-40 rounded-full bg-[#fe932c]/10 blur-2xl pointer-events-none"></div>
                        <div class="absolute inset-0 bg-[radial-gradient(#ffffff_0.5px,transparent_0.5px)] [background-size:12px_12px] opacity-10 pointer-events-none"></div>

                        <!-- Card Header -->
                        <div class="relative z-10 flex items-center justify-between border-b border-white/15 pb-2.5">
                            <div class="flex items-center gap-2.5">
                                <div class="w-9 h-9 rounded-full bg-white/10 flex items-center justify-center p-1 border border-white/20">
                                    @if($kta->member->banom && $kta->member->banom->logo)
                                        <img src="{{ asset('storage/' . $kta->member->banom->logo) }}" alt="Logo" class="w-full h-full object-contain">
                                    @else
                                        <span class="material-symbols-outlined text-emerald-200 text-lg">mosque</span>
                                    @endif
                                </div>
                                <div>
                                    <div class="text-[9px] uppercase tracking-wider text-emerald-200 font-bold">Nahdlatul Ulama Ranting Banjaranyar</div>
                                    <div class="text-xs sm:text-sm font-black tracking-tight text-[#fe932c]">KARTU TANDA ANGGOTA</div>
                                </div>
                            </div>
                            <span class="text-[10px] font-black uppercase px-2.5 py-0.5 rounded bg-white/15 border border-white/20 text-[#aaf2c4]">
                                {{ $kta->member->banom->singkatan ?? 'NU' }}
                            </span>
                        </div>

                        <!-- Card Body -->
                        <div class="relative z-10 grid grid-cols-12 gap-3 items-center my-auto">
                            <!-- Photo -->
                            <div class="col-span-4 flex justify-center">
                                <div class="w-20 h-26 sm:w-22 sm:h-28 rounded-xl bg-emerald-950/60 border-2 border-emerald-400/50 overflow-hidden shadow-lg flex items-center justify-center">
                                    @if($kta->member->foto)
                                        <img src="{{ asset('storage/' . $kta->member->foto) }}" alt="{{ $kta->member->nama_lengkap }}" class="w-full h-full object-cover">
                                    @else
                                        <span class="material-symbols-outlined text-emerald-300/40 text-5xl">person</span>
                                    @endif
                                </div>
                            </div>

                            <!-- Identity Details -->
                            <div class="col-span-8 space-y-1.5 pl-1">
                                <div class="text-sm sm:text-base font-black text-white leading-tight line-clamp-1">
                                    {{ $kta->member->nama_lengkap }}
                                </div>
                                <div class="text-[10px] sm:text-xs font-mono text-[#fe932c] font-extrabold tracking-wide">
                                    {{ $kta->nomor_kta }}
                                </div>
                                <div class="text-[9px] sm:text-[10px] text-emerald-100 flex items-center gap-1">
                                    <span class="material-symbols-outlined text-[11px] text-emerald-300">work</span>
                                    <span class="truncate">{{ $kta->member->jabatan ?? 'Kader / Anggota Aktif' }}</span>
                                </div>
                                <div class="text-[9px] text-emerald-200/90 flex items-center gap-2">
                                    <span>Berlaku s/d:</span>
                                    <strong class="text-white">{{ $kta->tanggal_berlaku ? $kta->tanggal_berlaku->format('Y') : 'Seumur Hidup' }}</strong>
                                </div>
                            </div>
                        </div>

                        <!-- Card Footer -->
                        <div class="relative z-10 flex items-center justify-between pt-1.5 border-t border-white/10 text-[8px] sm:text-[9px] text-emerald-200/80">
                            <span>PRNU Desa Banjaranyar, Bojonegoro</span>
                            <span class="font-mono tracking-widest text-[#aaf2c4]">KADER RESMI</span>
                        </div>
                    </div>

                    <!-- ================= CARD BACK ================= -->
                    <div class="card-face card-back absolute inset-0 rounded-2xl bg-gradient-to-br from-[#0c2415] via-[#05170d] to-[#020b06] text-white p-5 sm:p-6 shadow-2xl border border-emerald-800/40 flex flex-col justify-between overflow-hidden select-none">
                        <!-- Watermark -->
                        <div class="absolute inset-0 bg-[radial-gradient(#ffffff_0.5px,transparent_0.5px)] [background-size:12px_12px] opacity-10 pointer-events-none"></div>

                        <!-- Back Header -->
                        <div class="relative z-10 flex items-center justify-between border-b border-white/10 pb-2">
                            <span class="text-[9px] sm:text-[10px] font-bold text-emerald-300">PENGURUS RANTING NAHDLATUL ULAMA</span>
                            <span class="text-[8px] uppercase tracking-wider text-gray-400 font-mono">SIMNU-AUTH-V1</span>
                        </div>

                        <!-- Back Body (Terms + QR Code) -->
                        <div class="relative z-10 flex items-center justify-between gap-4 my-auto">
                            <div class="space-y-1.5 text-[8px] sm:text-[9px] text-emerald-100/90 leading-relaxed max-w-[65%]">
                                <p class="font-bold text-white uppercase text-[8px]">Ketentuan Pemegang KTA:</p>
                                <ul class="list-disc list-inside space-y-1 text-[7.5px] sm:text-[8px] text-gray-300">
                                    <li>KTA ini adalah tanda pengenal legal keanggotaan NU Ranting Banjaranyar.</li>
                                    <li>Wajib menjaga muru'ah & nilai Ahlussunnah wal Jama'ah An-Nahdliyyah.</li>
                                    <li>Apabila kartu ini hilang, segera laporkan ke sekretariat PRNU.</li>
                                    <li>Pindai QR Code di samping untuk verifikasi online 24 jam.</li>
                                </ul>
                            </div>

                            <!-- QR Code Box -->
                            <div class="flex flex-col items-center gap-1 shrink-0">
                                <div class="w-20 h-20 sm:w-22 sm:h-22 bg-white p-1 rounded-xl shadow-md flex items-center justify-center">
                                    @if($kta->qr_code)
                                        <img src="{{ $kta->qr_code }}" alt="QR KTA" class="w-full h-full object-contain">
                                    @else
                                        <span class="material-symbols-outlined text-gray-400 text-4xl">qr_code</span>
                                    @endif
                                </div>
                                <span class="text-[7px] text-emerald-300 font-mono">PINDAI UNTUK VALIDASI</span>
                            </div>
                        </div>

                        <!-- Back Footer -->
                        <div class="relative z-10 flex items-center justify-between pt-1.5 border-t border-white/10 text-[8px] text-emerald-200/70 font-mono">
                            <span>nu-banjaranyar.or.id</span>
                            <span class="text-[#fe932c]">ENCRYPTED QR SHA256</span>
                        </div>
                    </div>

                </div>

            </div>

            <p class="text-xs text-gray-500 flex items-center gap-1.5">
                <span class="material-symbols-outlined text-sm text-emerald-600">touch_app</span>
                <span>Klik kartu di atas atau tombol "Balik Kartu" untuk melihat sisi sebaliknya.</span>
            </p>
        </div>

        <!-- Right Column: Details, Verification link & Status Config (5 cols) -->
        <div class="lg:col-span-5 space-y-6">
            
            <!-- Metadata Card -->
            <div class="bg-white rounded-3xl p-6 border border-[#e6eeff] shadow-sm space-y-4">
                <div class="flex items-center justify-between border-b border-[#e6eeff] pb-3">
                    <h3 class="text-sm font-bold text-[#004125]">Spesifikasi Data Kartu</h3>
                    <span class="material-symbols-outlined text-emerald-600 text-lg">verified</span>
                </div>

                <dl class="divide-y divide-gray-100 text-xs">
                    <div class="py-2.5 flex justify-between">
                        <dt class="text-gray-500">Nomor KTA Resmi:</dt>
                        <dd class="font-mono font-bold text-[#004125]">{{ $kta->nomor_kta }}</dd>
                    </div>
                    <div class="py-2.5 flex justify-between">
                        <dt class="text-gray-500">Nama Lengkap:</dt>
                        <dd class="font-bold text-gray-900">{{ $kta->member->nama_lengkap }}</dd>
                    </div>
                    <div class="py-2.5 flex justify-between">
                        <dt class="text-gray-500">Badan Otonom:</dt>
                        <dd class="font-semibold text-emerald-800">{{ $kta->member->banom->nama ?? '-' }} ({{ $kta->member->banom->singkatan ?? '-' }})</dd>
                    </div>
                    <div class="py-2.5 flex justify-between">
                        <dt class="text-gray-500">Nomor Induk Anggota (NIA):</dt>
                        <dd class="font-mono text-gray-800">{{ $kta->member->nomor_anggota }}</dd>
                    </div>
                    <div class="py-2.5 flex justify-between">
                        <dt class="text-gray-500">Tanggal Terbit:</dt>
                        <dd class="text-gray-800">{{ $kta->tanggal_terbit ? $kta->tanggal_terbit->translatedFormat('d F Y') : '-' }}</dd>
                    </div>
                    <div class="py-2.5 flex justify-between">
                        <dt class="text-gray-500">Masa Berlaku:</dt>
                        <dd class="font-semibold text-gray-900">{{ $kta->tanggal_berlaku ? $kta->tanggal_berlaku->translatedFormat('d F Y') : 'Seumur Hidup' }}</dd>
                    </div>
                    <div class="py-2.5 flex justify-between">
                        <dt class="text-gray-500">Status Kartu:</dt>
                        <dd>
                            <span class="px-2 py-0.5 rounded-full text-[10px] font-extrabold uppercase {{ $kta->status === 'Aktif' ? 'bg-emerald-100 text-emerald-800' : 'bg-gray-100 text-gray-700' }}">
                                {{ $kta->status }}
                            </span>
                        </dd>
                    </div>
                </dl>

                <!-- Public Verify Quick Test -->
                <div class="p-3.5 rounded-2xl bg-emerald-50/70 border border-emerald-200 text-xs space-y-2">
                    <div class="font-bold text-[#004125] flex items-center justify-between">
                        <span>URL QR Code Verifikasi Publik:</span>
                        <a href="{{ route('kta.verify', $kta->nomor_kta) }}" target="_blank" class="text-emerald-700 hover:underline flex items-center gap-0.5 text-[11px]">
                            <span>Buka</span>
                            <span class="material-symbols-outlined text-[13px]">open_in_new</span>
                        </a>
                    </div>
                    <div class="font-mono text-[11px] text-gray-600 bg-white p-2 rounded-lg border border-emerald-100 break-all select-all">
                        {{ url("/kta/verify/{$kta->nomor_kta}") }}
                    </div>
                </div>
            </div>

            <!-- Status Form Switcher -->
            <div class="bg-white rounded-3xl p-6 border border-[#e6eeff] shadow-sm space-y-4">
                <h3 class="text-sm font-bold text-[#004125]">Ubah Status KTA</h3>
                
                <form action="{{ route('admin.kta.status', $kta->id) }}" method="POST" class="space-y-3">
                    @csrf
                    @method('PATCH')

                    <div>
                        <select name="status" class="w-full py-2.5 px-3 text-xs rounded-xl border border-gray-200 focus:border-[#0c5a37] text-gray-800">
                            <option value="Aktif" {{ $kta->status === 'Aktif' ? 'selected' : '' }}>Aktif (Legalitas Berlaku)</option>
                            <option value="Tidak Aktif" {{ $kta->status === 'Tidak Aktif' ? 'selected' : '' }}>Tidak Aktif (Dinonaktifkan Sementara)</option>
                            <option value="Kadaluarsa" {{ $kta->status === 'Kadaluarsa' ? 'selected' : '' }}>Kadaluarsa (Habis Masa Amanah)</option>
                        </select>
                    </div>

                    <button type="submit" class="w-full py-2.5 px-4 rounded-xl bg-gray-900 hover:bg-black text-white text-xs font-bold transition flex items-center justify-center gap-1.5">
                        <span class="material-symbols-outlined text-[16px]">save</span>
                        <span>Simpan Perubahan Status</span>
                    </button>
                </form>
            </div>

        </div>

    </div>

</div>

<script>
    let isFlipped = false;
    function flipCard() {
        const flipper = document.getElementById('cardFlipper');
        const label = document.getElementById('cardSideLabel');
        isFlipped = !isFlipped;
        if (isFlipped) {
            flipper.classList.add('is-flipped');
            label.textContent = 'Tampak Sisi Belakang (Back + QR)';
        } else {
            flipper.classList.remove('is-flipped');
            label.textContent = 'Tampak Sisi Depan (Front)';
        }
    }
</script>
@endsection
