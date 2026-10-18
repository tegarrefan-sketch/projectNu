@extends('layouts.app')

@section('title', 'NU Ranting Banjaranyar — Merawat Tradisi, Meneguhkan Aswaja, Melayani Ummat')

@section('content')
<!-- 1. HERO SECTION WITH PROMINENT ELDER-FRIENDLY QUICK ACTIONS -->
<section class="relative w-full overflow-hidden bg-gradient-to-b from-[#003820] to-[#004125] text-white">
    <!-- Ambient Glow Decorative Elements -->
    <div class="absolute -top-32 -right-32 w-96 h-96 rounded-full bg-[#0c5a37]/60 blur-3xl pointer-events-none"></div>
    <div class="absolute top-1/2 -left-24 w-80 h-80 rounded-full bg-[#fe932c]/20 blur-3xl pointer-events-none"></div>

    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 sm:py-16 lg:py-20 flex flex-col gap-10">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-12 items-center">
            
            <!-- Left Text & Two Massive Quick Buttons Column (7 cols) -->
            <div class="lg:col-span-7 flex flex-col gap-6 animate-slide-up">
                <div class="inline-flex items-center gap-2.5 px-4 py-2 rounded-full bg-white/10 w-fit backdrop-blur-md border border-white/15">
                    <span class="w-3 h-3 rounded-full bg-[#fe932c] animate-pulse"></span>
                    <span class="text-xs sm:text-sm font-bold text-[#aaf2c4] tracking-wide">Portal Resmi Warga Nahdliyin Banjaranyar</span>
                </div>

                <h1 class="text-3xl sm:text-5xl lg:text-5xl font-black tracking-tight leading-tight">
                    Merawat Tradisi, Meneguhkan Aswaja, <span class="text-[#fe932c]">Melayani Ummat.</span>
                </h1>

                <p class="text-base sm:text-lg text-emerald-100 leading-relaxed max-w-2xl">
                    Pusat informasi dan layanan digital Nahdlatul Ulama Ranting Banjaranyar, Kec. Baureno, Kab. Bojonegoro. Khidmah jam'iyyah untuk keharmonisan, keagamaan, dan kemandirian warga desa.
                </p>

                <!-- ================= 2 TOMBOL BESAR UTAMA UNTUK ORANG TUA / WARGA ================= -->
                <div class="pt-2">
                    <p class="text-xs sm:text-sm font-bold uppercase tracking-wider text-[#ffdcc3] mb-3 flex items-center gap-1.5">
                        <span class="material-symbols-outlined text-[18px]">touch_app</span>
                        <span>Akses Cepat Menu Terpenting:</span>
                    </p>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <!-- Tombol 1: Lihat Agenda -->
                        <a href="{{ route('event.index') }}" class="flex items-center justify-center gap-3.5 bg-[#fe932c] hover:bg-[#ff8000] text-[#2f1500] font-black text-lg sm:text-xl px-6 py-4 sm:py-5 rounded-2xl shadow-xl hover:shadow-2xl transition-all transform hover:-translate-y-1 active:translate-y-0 border-2 border-[#ffdcc3]">
                            <span class="material-symbols-outlined text-[32px] sm:text-[36px] text-[#2f1500]">event_available</span>
                            <span class="tracking-tight">Lihat Agenda</span>
                        </a>

                        <!-- Tombol 2: Baca Warta/Berita -->
                        <a href="{{ route('post.index') }}" class="flex items-center justify-center gap-3.5 bg-white hover:bg-emerald-50 text-[#004125] font-black text-lg sm:text-xl px-6 py-4 sm:py-5 rounded-2xl shadow-xl hover:shadow-2xl transition-all transform hover:-translate-y-1 active:translate-y-0 border-2 border-emerald-200">
                            <span class="material-symbols-outlined text-[32px] sm:text-[36px] text-[#004125]">newspaper</span>
                            <span class="tracking-tight">Baca Warta / Berita</span>
                        </a>
                    </div>
                </div>

                <!-- Tombol Sekunder yang Lebih Kecil di Bawah -->
                <div class="flex flex-wrap items-center gap-3 pt-1 border-t border-white/10">
                    <span class="text-xs text-emerald-200">Menu lainnya:</span>
                    <a href="{{ route('profile') }}" class="inline-flex items-center gap-1.5 bg-white/10 hover:bg-white/20 text-white font-semibold text-xs sm:text-sm px-4 py-2 rounded-xl backdrop-blur-md transition-colors border border-white/15">
                        <span class="material-symbols-outlined text-[18px]">account_balance</span>
                        <span>Profil Organisasi</span>
                    </a>
                    <a href="{{ route('structure.index') }}" class="inline-flex items-center gap-1.5 bg-white/10 hover:bg-white/20 text-white font-semibold text-xs sm:text-sm px-4 py-2 rounded-xl backdrop-blur-md transition-colors border border-white/15">
                        <span class="material-symbols-outlined text-[18px]">badge</span>
                        <span>Struktur Pengurus</span>
                    </a>
                </div>
            </div>

            <!-- Right Visual Column (5 cols) -->
            <div class="lg:col-span-5 relative animate-fade-in">
                <div class="relative mx-auto max-w-md lg:max-w-none rounded-3xl overflow-hidden shadow-2xl bg-white/5 p-3.5 backdrop-blur-md border border-white/15">
                    <div class="relative h-72 sm:h-84 rounded-2xl overflow-hidden bg-[#0c5a37] flex flex-col justify-end p-6 sm:p-8">
                        <div class="absolute inset-0 bg-gradient-to-t from-[#002110] via-[#004125]/70 to-transparent"></div>
                        <div class="relative z-10 space-y-3">
                            <div class="flex items-center gap-2 text-[#aaf2c4]">
                                <span class="material-symbols-outlined text-[24px]">verified</span>
                                <span class="text-xs font-extrabold uppercase tracking-wider">Aswaja Ranting Banjaranyar</span>
                            </div>
                            <blockquote class="text-base sm:text-lg font-bold text-white italic leading-snug">
                                "Hubbul Wathon Minal Iman — Mencintai Tanah Air adalah Sebagian dari Iman"
                            </blockquote>
                            <p class="text-xs text-emerald-200 font-medium">Hadratusysyaikh KH. M. Hasyim Asy'ari • Muassis NU</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Live Metric Indicators Bento (4 Cards) -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 pt-4">
            <div class="bg-white/10 backdrop-blur-md rounded-2xl p-5 border border-white/15 card-hover">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 rounded-xl bg-[#fe932c] text-[#2f1500] flex items-center justify-center shrink-0 shadow-md">
                        <span class="material-symbols-outlined text-[28px]">groups</span>
                    </div>
                    <div>
                        <div class="text-2xl font-extrabold text-white">{{ $totalMembers > 0 ? $totalMembers . '+' : '500+' }}</div>
                        <p class="text-xs text-emerald-200 font-medium">Kader Terdata Aktif</p>
                    </div>
                </div>
            </div>

            <div class="bg-white/10 backdrop-blur-md rounded-2xl p-5 border border-white/15 card-hover">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 rounded-xl bg-white/20 text-[#aaf2c4] flex items-center justify-center shrink-0 shadow-md">
                        <span class="material-symbols-outlined text-[28px]">diversity_3</span>
                    </div>
                    <div>
                        <div class="text-2xl font-extrabold text-white">6 BANOM</div>
                        <p class="text-xs text-emerald-200 font-medium">Sayap Organisasi Desa</p>
                    </div>
                </div>
            </div>

            <div class="bg-white/10 backdrop-blur-md rounded-2xl p-5 border border-white/15 card-hover">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 rounded-xl bg-[#fe932c] text-[#2f1500] flex items-center justify-center shrink-0 shadow-md">
                        <span class="material-symbols-outlined text-[28px]">volunteer_activism</span>
                    </div>
                    <div>
                        <div class="text-xl sm:text-2xl font-extrabold text-white">Rp {{ number_format($totalInfaqTerkumpul > 0 ? $totalInfaqTerkumpul : 48200000, 0, ',', '.') }}</div>
                        <p class="text-xs text-emerald-200 font-medium">Infaq Terhimpun LAZISNU</p>
                    </div>
                </div>
            </div>

            <div class="bg-white/10 backdrop-blur-md rounded-2xl p-5 border border-white/15 card-hover">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 rounded-xl bg-white/20 text-[#aaf2c4] flex items-center justify-center shrink-0 shadow-md">
                        <span class="material-symbols-outlined text-[28px]">mosque</span>
                    </div>
                    <div>
                        <div class="text-2xl font-extrabold text-white">8 Titik</div>
                        <p class="text-xs text-emerald-200 font-medium">Masjid & Musholla Binaan</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ================= 2. LAYANAN YANG MUNGKIN ANDA CARI (GRID KARTU BESAR TEPAT DI BAWAH HERO) ================= -->
<section class="py-14 sm:py-18 bg-[#f8f9ff] border-b border-[#e6eeff]">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">
        <div class="text-center max-w-2xl mx-auto space-y-2">
            <span class="px-3.5 py-1 rounded-full bg-[#eff4ff] text-[#004125] text-xs font-extrabold uppercase tracking-wider inline-block">
                Pusat Pelayanan Warga Desa
            </span>
            <h2 class="text-2xl sm:text-3xl font-black text-[#004125] tracking-tight">
                Layanan yang Mungkin Anda Cari
            </h2>
            <p class="text-sm sm:text-base text-[#404942]">
                Satu klik langsung menuju fitur yang sering digunakan oleh warga Nahdliyin Banjaranyar:
            </p>
        </div>

        <!-- 8 Big Action Cards Grid (Responsive, clear icons, big touch target) -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5 sm:gap-6">
            
            <!-- Card 1: Lihat Agenda -->
            <a href="{{ route('event.index') }}" class="group bg-white p-6 sm:p-7 rounded-3xl border-2 border-[#e6eeff] hover:border-[#0c5a37] card-hover flex flex-col justify-between shadow-sm">
                <div class="space-y-4">
                    <div class="w-16 h-16 rounded-2xl bg-emerald-50 text-[#004125] group-hover:bg-[#004125] group-hover:text-white flex items-center justify-center transition-colors shadow-sm">
                        <span class="material-symbols-outlined text-[34px]">calendar_month</span>
                    </div>
                    <div>
                        <h3 class="text-lg font-black text-[#121c2a] group-hover:text-[#004125] transition-colors">Lihat Agenda</h3>
                        <p class="text-xs sm:text-sm text-[#526350] mt-1.5 leading-relaxed">
                            Jadwal pengajian rutin, istighotsah kubro, dan kegiatan ranting terkini.
                        </p>
                    </div>
                </div>
                <div class="pt-5 mt-4 border-t border-[#eff4ff] flex items-center text-xs sm:text-sm font-bold text-[#0c5a37]">
                    <span>Buka Jadwal</span>
                    <span class="material-symbols-outlined text-[18px] ml-1 group-hover:translate-x-1 transition-transform">arrow_forward</span>
                </div>
            </a>

            <!-- Card 2: Baca Warta -->
            <a href="{{ route('post.index') }}" class="group bg-white p-6 sm:p-7 rounded-3xl border-2 border-[#e6eeff] hover:border-[#0c5a37] card-hover flex flex-col justify-between shadow-sm">
                <div class="space-y-4">
                    <div class="w-16 h-16 rounded-2xl bg-amber-50 text-[#904d00] group-hover:bg-[#904d00] group-hover:text-white flex items-center justify-center transition-colors shadow-sm">
                        <span class="material-symbols-outlined text-[34px]">newspaper</span>
                    </div>
                    <div>
                        <h3 class="text-lg font-black text-[#121c2a] group-hover:text-[#904d00] transition-colors">Baca Warta</h3>
                        <p class="text-xs sm:text-sm text-[#526350] mt-1.5 leading-relaxed">
                            Kabar berita, artikel dakwah santun, dan liputan syiar warga desa.
                        </p>
                    </div>
                </div>
                <div class="pt-5 mt-4 border-t border-[#eff4ff] flex items-center text-xs sm:text-sm font-bold text-[#904d00]">
                    <span>Buka Berita</span>
                    <span class="material-symbols-outlined text-[18px] ml-1 group-hover:translate-x-1 transition-transform">arrow_forward</span>
                </div>
            </a>

            <!-- Card 3: Cek Kartu Anggota -->
            <a href="{{ route('kta.verify.search') }}" class="group bg-white p-6 sm:p-7 rounded-3xl border-2 border-[#e6eeff] hover:border-[#0c5a37] card-hover flex flex-col justify-between shadow-sm">
                <div class="space-y-4">
                    <div class="w-16 h-16 rounded-2xl bg-blue-50 text-[#123181] group-hover:bg-[#123181] group-hover:text-white flex items-center justify-center transition-colors shadow-sm">
                        <span class="material-symbols-outlined text-[34px]">manage_search</span>
                    </div>
                    <div>
                        <h3 class="text-lg font-black text-[#121c2a] group-hover:text-[#123181] transition-colors">Cek Kartu Anggota</h3>
                        <p class="text-xs sm:text-sm text-[#526350] mt-1.5 leading-relaxed">
                            Cari data kader dan cek keabsahan status keanggotaan SIMNU online.
                        </p>
                    </div>
                </div>
                <div class="pt-5 mt-4 border-t border-[#eff4ff] flex items-center text-xs sm:text-sm font-bold text-[#123181]">
                    <span>Cek Nomor KTA</span>
                    <span class="material-symbols-outlined text-[18px] ml-1 group-hover:translate-x-1 transition-transform">arrow_forward</span>
                </div>
            </a>

            <!-- Card 4: Cetak Kartu Anggota -->
            <a href="{{ route('kta.verify.search') }}" class="group bg-white p-6 sm:p-7 rounded-3xl border-2 border-[#e6eeff] hover:border-[#0c5a37] card-hover flex flex-col justify-between shadow-sm">
                <div class="space-y-4">
                    <div class="w-16 h-16 rounded-2xl bg-teal-50 text-[#005230] group-hover:bg-[#005230] group-hover:text-white flex items-center justify-center transition-colors shadow-sm">
                        <span class="material-symbols-outlined text-[34px]">print</span>
                    </div>
                    <div>
                        <h3 class="text-lg font-black text-[#121c2a] group-hover:text-[#005230] transition-colors">Cetak Kartu Anggota</h3>
                        <p class="text-xs sm:text-sm text-[#526350] mt-1.5 leading-relaxed">
                            Cetak fisik ukuran kartu standar (85.6 x 54 mm) atau simpan sebagai PDF.
                        </p>
                    </div>
                </div>
                <div class="pt-5 mt-4 border-t border-[#eff4ff] flex items-center text-xs sm:text-sm font-bold text-[#005230]">
                    <span>Cetak Sekarang</span>
                    <span class="material-symbols-outlined text-[18px] ml-1 group-hover:translate-x-1 transition-transform">arrow_forward</span>
                </div>
            </a>

            <!-- Card 5: Infaq Online -->
            <a href="{{ route('infaq.index') }}" class="group bg-white p-6 sm:p-7 rounded-3xl border-2 border-[#e6eeff] hover:border-[#0c5a37] card-hover flex flex-col justify-between shadow-sm">
                <div class="space-y-4">
                    <div class="w-16 h-16 rounded-2xl bg-orange-50 text-[#fe932c] group-hover:bg-[#fe932c] group-hover:text-[#2f1500] flex items-center justify-center transition-colors shadow-sm">
                        <span class="material-symbols-outlined text-[34px]">volunteer_activism</span>
                    </div>
                    <div>
                        <h3 class="text-lg font-black text-[#121c2a] group-hover:text-[#fe932c] transition-colors">Infaq Online</h3>
                        <p class="text-xs sm:text-sm text-[#526350] mt-1.5 leading-relaxed">
                            Salurkan infaq & sedekah koin LAZISNU via Transfer Bank atau QRIS.
                        </p>
                    </div>
                </div>
                <div class="pt-5 mt-4 border-t border-[#eff4ff] flex items-center text-xs sm:text-sm font-bold text-[#fe932c]">
                    <span>Salurkan Infaq</span>
                    <span class="material-symbols-outlined text-[18px] ml-1 group-hover:translate-x-1 transition-transform">arrow_forward</span>
                </div>
            </a>

            <!-- Card 6: Kirim Aspirasi -->
            <a href="{{ route('aspirasi.create') }}" class="group bg-white p-6 sm:p-7 rounded-3xl border-2 border-[#e6eeff] hover:border-[#0c5a37] card-hover flex flex-col justify-between shadow-sm">
                <div class="space-y-4">
                    <div class="w-16 h-16 rounded-2xl bg-emerald-50 text-[#0c5a37] group-hover:bg-[#0c5a37] group-hover:text-white flex items-center justify-center transition-colors shadow-sm">
                        <span class="material-symbols-outlined text-[34px]">campaign</span>
                    </div>
                    <div>
                        <h3 class="text-lg font-black text-[#121c2a] group-hover:text-[#0c5a37] transition-colors">Kirim Aspirasi</h3>
                        <p class="text-xs sm:text-sm text-[#526350] mt-1.5 leading-relaxed">
                            Sampaikan usulan kemakmuran masjid, masukan dakwah, atau pesan warga.
                        </p>
                    </div>
                </div>
                <div class="pt-5 mt-4 border-t border-[#eff4ff] flex items-center text-xs sm:text-sm font-bold text-[#0c5a37]">
                    <span>Kirim Saran</span>
                    <span class="material-symbols-outlined text-[18px] ml-1 group-hover:translate-x-1 transition-transform">arrow_forward</span>
                </div>
            </a>

            <!-- Card 7: Galeri Kegiatan -->
            <a href="{{ route('galeri.index') }}" class="group bg-white p-6 sm:p-7 rounded-3xl border-2 border-[#e6eeff] hover:border-[#0c5a37] card-hover flex flex-col justify-between shadow-sm">
                <div class="space-y-4">
                    <div class="w-16 h-16 rounded-2xl bg-purple-50 text-purple-700 group-hover:bg-purple-700 group-hover:text-white flex items-center justify-center transition-colors shadow-sm">
                        <span class="material-symbols-outlined text-[34px]">photo_library</span>
                    </div>
                    <div>
                        <h3 class="text-lg font-black text-[#121c2a] group-hover:text-purple-700 transition-colors">Galeri Kegiatan</h3>
                        <p class="text-xs sm:text-sm text-[#526350] mt-1.5 leading-relaxed">
                            Dokumentasi foto-foto kegiatan khidmah jam'iyyah dan majelis dzikir desa.
                        </p>
                    </div>
                </div>
                <div class="pt-5 mt-4 border-t border-[#eff4ff] flex items-center text-xs sm:text-sm font-bold text-purple-700">
                    <span>Lihat Foto</span>
                    <span class="material-symbols-outlined text-[18px] ml-1 group-hover:translate-x-1 transition-transform">arrow_forward</span>
                </div>
            </a>

            <!-- Card 8: Struktur Pengurus -->
            <a href="{{ route('structure.index') }}" class="group bg-white p-6 sm:p-7 rounded-3xl border-2 border-[#e6eeff] hover:border-[#0c5a37] card-hover flex flex-col justify-between shadow-sm">
                <div class="space-y-4">
                    <div class="w-16 h-16 rounded-2xl bg-slate-100 text-[#121c2a] group-hover:bg-[#004125] group-hover:text-white flex items-center justify-center transition-colors shadow-sm">
                        <span class="material-symbols-outlined text-[34px]">account_tree</span>
                    </div>
                    <div>
                        <h3 class="text-lg font-black text-[#121c2a] group-hover:text-[#004125] transition-colors">Struktur Pengurus</h3>
                        <p class="text-xs sm:text-sm text-[#526350] mt-1.5 leading-relaxed">
                            Susunan pengurus Syuriyah, Tanfidziyah, dan 6 Badan Otonom masa khidmah.
                        </p>
                    </div>
                </div>
                <div class="pt-5 mt-4 border-t border-[#eff4ff] flex items-center text-xs sm:text-sm font-bold text-[#004125]">
                    <span>Buka Struktur</span>
                    <span class="material-symbols-outlined text-[18px] ml-1 group-hover:translate-x-1 transition-transform">arrow_forward</span>
                </div>
            </a>

        </div>
    </div>
</section>

<!-- 3. AGENDA TERDEKAT (AKAN DATANG SAJA) -->
<section class="py-16 bg-white border-b border-[#e6eeff] reveal">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-10">
        <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-4">
            <div>
                <span class="text-xs font-bold text-[#904d00] uppercase tracking-wider block">Jadwal & Agenda Terdekat</span>
                <h2 class="text-2xl sm:text-3xl font-extrabold text-[#004125] tracking-tight">Agenda Mendatang Jam'iyyah</h2>
            </div>
            <div class="flex items-center gap-3">
                <a href="{{ route('event.archive') }}" class="text-xs sm:text-sm font-semibold text-[#526350] hover:text-[#004125] hover:underline">
                    Lihat Arsip Lampau →
                </a>
                <a href="{{ route('event.index') }}" class="px-4 py-2 rounded-xl bg-[#0c5a37] hover:bg-[#004125] text-white text-xs sm:text-sm font-bold transition shadow-sm">
                    Semua Agenda Aktif
                </a>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse ($events as $event)
                <div class="bg-white rounded-3xl p-6 border-2 border-[#e6eeff] hover:border-[#0c5a37] card-hover flex flex-col justify-between shadow-sm">
                    <div class="space-y-4">
                        <div class="flex items-start justify-between gap-4">
                            <div class="w-16 h-16 rounded-2xl bg-[#eff4ff] text-[#004125] flex flex-col items-center justify-center shrink-0 border border-[#dee9fc]">
                                <span class="text-xs font-bold uppercase tracking-wider">{{ $event->tanggal->translatedFormat('M') }}</span>
                                <span class="text-2xl font-black leading-none">{{ $event->tanggal->format('d') }}</span>
                            </div>
                            <span class="px-3 py-1 rounded-full text-xs font-extrabold bg-emerald-100 text-[#004125]">
                                {{ $event->banom ? $event->banom->singkatan : 'PRNU Induk' }}
                            </span>
                        </div>

                        <div>
                            <h3 class="text-base sm:text-lg font-bold text-[#121c2a] line-clamp-2 leading-snug">
                                <a href="{{ route('event.show', $event->slug) }}" class="hover:text-[#004125] transition-colors">{{ $event->title }}</a>
                            </h3>
                            <div class="mt-3 space-y-1.5 text-xs text-[#526350]">
                                <div class="flex items-center gap-2">
                                    <span class="material-symbols-outlined text-[16px] text-[#fe932c]">schedule</span>
                                    <span>{{ $event->waktu_mulai ? date('H:i', strtotime($event->waktu_mulai)) . ' WIB' : 'Waktu menyesuaikan' }}</span>
                                </div>
                                <div class="flex items-center gap-2">
                                    <span class="material-symbols-outlined text-[16px] text-[#fe932c]">location_on</span>
                                    <span class="truncate">{{ $event->lokasi ?? 'Banjaranyar' }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="pt-5 mt-4 border-t border-[#eff4ff] flex items-center justify-between">
                        <span class="text-xs font-semibold text-emerald-800 bg-emerald-50 px-2.5 py-1 rounded-lg">Akan Datang</span>
                        <a href="{{ route('event.show', $event->slug) }}" class="text-xs font-bold text-[#0c5a37] hover:underline flex items-center gap-1">
                            <span>Detail Agenda</span>
                            <span class="material-symbols-outlined text-[14px]">arrow_forward</span>
                        </a>
                    </div>
                </div>
            @empty
                <div class="col-span-3 p-10 text-center bg-[#eff4ff] rounded-3xl text-sm text-[#404942]">
                    Belum ada agenda terdekat yang dijadwalkan dalam waktu dekat.
                </div>
            @endforelse
        </div>
    </div>
</section>

<!-- 4. WARTA & BERITA TERKINI -->
<section class="py-16 bg-[#f8f9ff] border-b border-[#e6eeff] reveal">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-10">
        <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-4">
            <div>
                <span class="text-xs font-bold text-[#904d00] uppercase tracking-wider block">Publikasi Resmi & Liputan</span>
                <h2 class="text-2xl sm:text-3xl font-extrabold text-[#004125] tracking-tight">Warta Ranting & Amaliyah</h2>
            </div>
            <a href="{{ route('post.index') }}" class="text-sm font-bold text-[#0c5a37] hover:underline flex items-center gap-1">
                <span>Semua Warta & Buletin</span>
                <span class="material-symbols-outlined text-[16px]">arrow_forward</span>
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            @forelse ($posts as $post)
                <article class="bg-white rounded-3xl overflow-hidden border border-[#e6eeff] shadow-sm hover:shadow-lg transition-all flex flex-col justify-between card-hover">
                    <div>
                        <!-- Thumbnail -->
                        <div class="h-48 w-full bg-[#eff4ff] flex items-center justify-center overflow-hidden relative">
                            @if ($post->thumbnail)
                                <img src="{{ asset('storage/' . $post->thumbnail) }}" alt="{{ $post->title }}" class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full bg-gradient-to-br from-[#0c5a37] to-[#002110] flex items-center justify-center text-white/40">
                                    <span class="material-symbols-outlined text-[54px]">newspaper</span>
                                </div>
                            @endif
                            <span class="absolute top-3 left-3 px-3 py-1 rounded-full text-[11px] font-bold text-white bg-[#004125]/90 backdrop-blur-sm">
                                {{ $post->banom ? $post->banom->singkatan : $post->kategori }}
                            </span>
                        </div>

                        <!-- Content -->
                        <div class="p-5 space-y-2.5">
                            <span class="text-[11px] text-[#707971] font-semibold flex items-center gap-1.5">
                                <span class="material-symbols-outlined text-[14px]">calendar_today</span>
                                <span>{{ $post->published_at ? $post->published_at->translatedFormat('d M Y') : $post->created_at->translatedFormat('d M Y') }}</span>
                            </span>
                            <h3 class="text-base font-bold text-[#121c2a] line-clamp-2 hover:text-[#004125] transition-colors leading-snug">
                                <a href="{{ route('post.show', $post->slug) }}">{{ $post->title }}</a>
                            </h3>
                            <p class="text-xs text-[#526350] line-clamp-2 leading-relaxed">
                                {{ $post->excerpt ?? Str::limit(strip_tags($post->content), 85) }}
                            </p>
                        </div>
                    </div>

                    <div class="p-5 pt-0">
                        <a href="{{ route('post.show', $post->slug) }}" class="text-xs font-bold text-[#0c5a37] hover:underline flex items-center gap-1">
                            <span>Baca Lengkap</span>
                            <span class="material-symbols-outlined text-[14px]">arrow_forward</span>
                        </a>
                    </div>
                </article>
            @empty
                <div class="col-span-4 p-8 text-center bg-white rounded-3xl border border-[#e6eeff] text-xs text-[#404942]">
                    Belum ada warta berita yang diterbitkan.
                </div>
            @endforelse
        </div>
    </div>
</section>

<!-- ================= 5. CUPLIKAN GALERI KEGIATAN (FITUR BARU) ================= -->
<section class="py-16 bg-white border-b border-[#e6eeff] reveal">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-10">
        <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-4">
            <div>
                <span class="text-xs font-bold text-[#904d00] uppercase tracking-wider block">Dokumentasi & Arsip Visual</span>
                <h2 class="text-2xl sm:text-3xl font-extrabold text-[#004125] tracking-tight">Galeri Kegiatan Ranting</h2>
                <p class="text-xs sm:text-sm text-[#526350] mt-1">Momen kebersamaan, pengajian, apel banser, dan kaderisasi warga Banjaranyar</p>
            </div>
            <a href="{{ route('galeri.index') }}" class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-[#004125] hover:bg-[#0c5a37] text-white font-bold text-xs sm:text-sm shadow-md transition-all shrink-0">
                <span class="material-symbols-outlined text-[18px]">photo_library</span>
                <span>Lihat Semua Galeri Kegiatan →</span>
            </a>
        </div>

        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4">
            @forelse ($latestPhotos as $photo)
                <div class="group relative rounded-2xl overflow-hidden aspect-square bg-[#eff4ff] border border-[#e6eeff] shadow-sm card-hover">
                    <img src="{{ asset('storage/' . $photo->foto) }}" alt="{{ $photo->caption ?? 'Dokumentasi NU' }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300" loading="lazy">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity p-3 flex flex-col justify-end text-white text-[11px]">
                        <p class="font-bold line-clamp-2 leading-tight">{{ $photo->caption ?? $photo->gallery->judul }}</p>
                        <span class="text-[9px] text-[#ffdcc3] mt-1">{{ $photo->gallery->tanggal->translatedFormat('d M Y') }}</span>
                    </div>
                </div>
            @empty
                <div class="col-span-6 p-8 text-center bg-[#f8f9ff] rounded-2xl text-xs text-[#526350]">
                    Belum ada foto galeri yang diunggah.
                </div>
            @endforelse
        </div>
    </div>
</section>

<!-- 6. 6 BADAN OTONOM (BANOM) SHOWCASE -->
<section class="py-16 bg-[#f8f9ff] border-b border-[#e6eeff] reveal">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-10">
        <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-4">
            <div>
                <span class="text-xs font-bold text-[#904d00] uppercase tracking-wider block">Garda Perjuangan Organisasi</span>
                <h2 class="text-2xl sm:text-3xl font-extrabold text-[#004125] tracking-tight">Badan Otonom (BANOM) NU</h2>
            </div>
            <a href="{{ route('structure.index', ['tab' => 'banom']) }}" class="text-sm font-bold text-[#0c5a37] hover:underline flex items-center gap-1">
                <span>Buka Rincian BANOM</span>
                <span class="material-symbols-outlined text-[16px]">arrow_forward</span>
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach ($banoms as $banom)
                <div class="bg-white rounded-3xl p-6 shadow-sm border border-[#e6eeff] flex flex-col justify-between card-hover">
                    <div class="space-y-4">
                        <div class="flex items-center justify-between">
                            <span class="px-3 py-1 rounded-full text-xs font-bold text-white shadow-sm" style="background-color: {{ $banom->warna_primer ?? '#0c5a37' }};">
                                {{ $banom->singkatan }}
                            </span>
                            <span class="material-symbols-outlined text-[24px] text-gray-400">shield</span>
                        </div>
                        <div>
                            <h3 class="text-lg font-bold text-[#121c2a] leading-snug">{{ $banom->nama }}</h3>
                            <p class="text-xs sm:text-sm text-[#526350] mt-2 line-clamp-3 leading-relaxed">{{ $banom->deskripsi }}</p>
                        </div>
                    </div>
                    <div class="pt-5 mt-4 border-t border-[#eff4ff] flex items-center justify-between">
                        <span class="text-xs text-[#526350] font-semibold">{{ $banom->members_count ?? $banom->members()->count() }} Kader</span>
                        <a href="{{ route('banom.show', $banom->slug) }}" class="text-xs font-bold text-[#0c5a37] hover:underline flex items-center gap-1">
                            <span>Profil Lengkap</span>
                            <span class="material-symbols-outlined text-[14px]">arrow_forward</span>
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

<!-- ================= 7. BANNER KIRIM ASPIRASI WARGA (SATU SAJA, TIDAK DOBEL) ================= -->
<section class="py-16 bg-gradient-to-r from-[#003820] via-[#0c5a37] to-[#003820] text-white reveal">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col lg:flex-row items-center justify-between gap-8">
            <div class="space-y-3 max-w-2xl text-center lg:text-left">
                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-white/10 text-xs font-bold text-[#aaf2c4]">
                    <span class="material-symbols-outlined text-[16px]">campaign</span>
                    <span>Suara Jamaah & Warga Desa</span>
                </span>
                <h2 class="text-2xl sm:text-4xl font-black tracking-tight leading-snug">Kirim Aspirasi & Gagasan Kemakmuran Desa</h2>
                <p class="text-sm sm:text-base text-emerald-100 leading-relaxed">
                    Wadah resmi khidmat warga Nahdliyin Banjaranyar untuk menyampaikan saran, ide kegiatan, usulan sarana ibadah, atau masukan sosial dengan amanah dan transparan.
                </p>
            </div>
            <div class="flex flex-wrap items-center justify-center gap-4 shrink-0">
                <a href="{{ route('aspirasi.create') }}" class="inline-flex items-center gap-2.5 bg-[#fe932c] hover:bg-[#ff8000] text-[#2f1500] font-black text-base px-7 py-4 rounded-2xl shadow-xl hover:shadow-2xl transition-all transform hover:-translate-y-0.5">
                    <span class="material-symbols-outlined text-[24px]">edit_note</span>
                    <span>Kirim Aspirasi Sekarang</span>
                </a>
                <a href="{{ route('aspirasi.track') }}" class="inline-flex items-center gap-2 bg-white/10 hover:bg-white/20 text-white font-bold text-sm px-5 py-4 rounded-2xl border border-white/20 transition-colors">
                    <span class="material-symbols-outlined text-[20px]">manage_search</span>
                    <span>Lacak Status Tiket</span>
                </a>
            </div>
        </div>
    </div>
</section>
@endsection
