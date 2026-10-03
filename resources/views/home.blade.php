@extends('layouts.app')

@section('title', 'NU Ranting Banjaranyar — Merawat Tradisi, Meneguhkan Aswaja, Melayani Ummat')

@section('content')
<!-- 1. HERO SECTION WITH ASYMMETRICAL EDITORIAL COMPOSITION -->
<section class="relative w-full overflow-hidden bg-[#004125] text-white">
    <!-- Ambient Glow Decorative Elements -->
    <div class="absolute -top-32 -right-32 w-96 h-96 rounded-full bg-[#0c5a37]/60 blur-3xl pointer-events-none"></div>
    <div class="absolute top-1/2 -left-24 w-80 h-80 rounded-full bg-[#fe932c]/20 blur-3xl pointer-events-none"></div>

    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 lg:py-24 flex flex-col gap-12">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 items-center">
            
            <!-- Left Text Column (7 cols) -->
            <div class="lg:col-span-7 flex flex-col gap-5">
                <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-white/10 w-fit backdrop-blur-sm border border-white/10">
                    <span class="w-2.5 h-2.5 rounded-full bg-[#fe932c]"></span>
                    <span class="text-xs font-bold text-[#aaf2c4] uppercase tracking-wider">Khidmah Jam'iyyah & Jemaah Desa</span>
                </div>

                <h1 class="text-3xl sm:text-5xl lg:text-5xl font-extrabold tracking-tight leading-tight">
                    Merawat Tradisi, Meneguhkan Aswaja, <span class="text-[#fe932c]">Melayani Ummat.</span>
                </h1>

                <p class="text-base sm:text-lg text-emerald-100/90 max-w-2xl leading-relaxed">
                    Pusat informasi resmi Nahdlatul Ulama Ranting Banjaranyar, Kecamatan Baureno, Kabupaten Bojonegoro. Mengokohkan pilar Ahlussunnah wal Jama'ah An-Nahdliyyah demi keharmonisan sosial dan kemandirian warga desa.
                </p>

                <div class="flex flex-wrap items-center gap-3 pt-2">
                    <a href="{{ route('profile') }}" class="inline-flex items-center gap-2 bg-[#fe932c] hover:bg-[#904d00] text-[#2f1500] hover:text-white font-bold text-sm px-6 py-3.5 rounded-xl shadow-md transition-all transform hover:-translate-y-0.5">
                        <span class="material-symbols-outlined text-[20px]">account_balance</span>
                        <span>Lihat Profil Organisasi</span>
                    </a>
                    <a href="{{ route('post.index') }}" class="inline-flex items-center gap-2 bg-white/10 hover:bg-white/20 text-white font-semibold text-sm px-6 py-3.5 rounded-xl backdrop-blur-md transition-colors border border-white/10">
                        <span class="material-symbols-outlined text-[20px]">feed</span>
                        <span>Jelajahi Warta Ranting</span>
                    </a>
                </div>
            </div>

            <!-- Right Visual Column (5 cols) -->
            <div class="lg:col-span-5 relative">
                <div class="relative mx-auto max-w-md lg:max-w-none rounded-2xl overflow-hidden shadow-2xl bg-white/5 p-3 backdrop-blur-md border border-white/10">
                    <div class="relative h-72 sm:h-84 rounded-xl overflow-hidden bg-[#0c5a37] flex flex-col justify-end p-6">
                        <div class="absolute inset-0 bg-gradient-to-t from-[#002110] via-[#004125]/60 to-transparent"></div>
                        <div class="relative z-10 space-y-2">
                            <div class="flex items-center gap-2 text-[#aaf2c4]">
                                <span class="material-symbols-outlined text-[20px]">verified</span>
                                <span class="text-xs font-bold uppercase tracking-wider">Aswaja Ranting Banjaranyar</span>
                            </div>
                            <blockquote class="text-sm sm:text-base font-bold text-white italic">
                                "Hubbul Wathon Minal Iman — Mencintai Tanah Air Sebagian dari Iman"
                            </blockquote>
                            <p class="text-xs text-emerald-200">K.H. Hasyim Asy'ari • Muassis Nahdlatul Ulama</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Live Metric Indicators Bento (4 Cards) -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            <div class="bg-white/10 backdrop-blur-md rounded-xl p-5 border border-white/10 hover:bg-white/15 transition-colors">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 rounded-xl bg-white/10 flex items-center justify-center text-[#fe932c] shrink-0">
                        <span class="material-symbols-outlined text-[28px]">groups</span>
                    </div>
                    <div>
                        <div class="text-2xl font-bold text-white">{{ $totalMembers > 0 ? $totalMembers . '+' : '480+' }}</div>
                        <p class="text-xs text-emerald-200">Kader Terdata Aktif</p>
                    </div>
                </div>
            </div>

            <div class="bg-white/10 backdrop-blur-md rounded-xl p-5 border border-white/10 hover:bg-white/15 transition-colors">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 rounded-xl bg-white/10 flex items-center justify-center text-[#fe932c] shrink-0">
                        <span class="material-symbols-outlined text-[28px]">auto_stories</span>
                    </div>
                    <div>
                        <div class="text-lg sm:text-xl font-bold text-white">Malam Ahad</div>
                        <p class="text-xs text-emerald-200">Pengajian Rutin Selapanan</p>
                    </div>
                </div>
            </div>

            <div class="bg-white/10 backdrop-blur-md rounded-xl p-5 border border-white/10 hover:bg-white/15 transition-colors">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 rounded-xl bg-white/10 flex items-center justify-center text-[#fe932c] shrink-0">
                        <span class="material-symbols-outlined text-[28px]">payments</span>
                    </div>
                    <div>
                        <div class="text-2xl font-bold text-white">Rp 48,2 Jt</div>
                        <p class="text-xs text-emerald-200">ZISWAF Koin LAZISNU</p>
                    </div>
                </div>
            </div>

            <div class="bg-white/10 backdrop-blur-md rounded-xl p-5 border border-white/10 hover:bg-white/15 transition-colors">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 rounded-xl bg-white/10 flex items-center justify-center text-[#fe932c] shrink-0">
                        <span class="material-symbols-outlined text-[28px]">mosque</span>
                    </div>
                    <div>
                        <div class="text-2xl font-bold text-white">7 Musholla</div>
                        <p class="text-xs text-emerald-200">& 1 Masjid Jami' Binaan</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- 2. PROFIL SINGKAT & LAYANAN UNGGULAN -->
<section class="py-16 bg-white border-b border-[#e6eeff]">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">
            <div class="lg:col-span-6 space-y-4">
                <div class="inline-flex items-center gap-2 bg-[#eff4ff] text-[#004125] px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wider">
                    <span class="material-symbols-outlined text-[16px]">info</span>
                    <span>Tentang PRNU Banjaranyar</span>
                </div>
                <h2 class="text-2xl sm:text-3xl font-extrabold text-[#004125] tracking-tight">
                    Khidmah Sepenuh Hati untuk Agama, Bangsa, dan Desa
                </h2>
                <p class="text-sm text-[#404942] leading-relaxed">
                    Pengurus Ranting Nahdlatul Ulama Desa Banjaranyar adalah motor penggerak keagamaan dan kemasyarakatan di wilayah Desa Banjaranyar, Baureno, Bojonegoro. Melalui kolaborasi majelis Kiai Sepuh (Mustasyar & Syuriyah) serta pelaksana harian (Tanfidziyah), kami membina tradisi tahlil, istighotsah, zakat infaq produktif, serta kaderisasi generasi penerus bangsa.
                </p>
                <div class="pt-2">
                    <a href="{{ route('profile') }}" class="inline-flex items-center gap-1.5 text-sm font-bold text-[#0c5a37] hover:text-[#004125] transition-colors">
                        <span>Baca Sejarah & Visi Misi Lengkap</span>
                        <span class="material-symbols-outlined text-[18px]">arrow_forward</span>
                    </a>
                </div>
            </div>

            <div class="lg:col-span-6 grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div class="p-5 rounded-2xl bg-[#f8f9ff] border border-[#e6eeff] space-y-2.5">
                    <div class="w-10 h-10 rounded-xl bg-[#aaf2c4] text-[#002110] flex items-center justify-center font-bold">
                        <span class="material-symbols-outlined text-[22px]">diversity_3</span>
                    </div>
                    <h3 class="text-base font-bold text-[#121c2a]">5 Badan Otonom</h3>
                    <p class="text-xs text-[#404942] leading-relaxed">Kaderisasi terarah dari usia pelajar (IPNU-IPPNU), pemudi (Fatayat), hingga kepemudaan (Ansor & Banser).</p>
                </div>

                <div class="p-5 rounded-2xl bg-[#f8f9ff] border border-[#e6eeff] space-y-2.5">
                    <div class="w-10 h-10 rounded-xl bg-[#ffdcc3] text-[#2f1500] flex items-center justify-center font-bold">
                        <span class="material-symbols-outlined text-[22px]">savings</span>
                    </div>
                    <h3 class="text-base font-bold text-[#121c2a]">LAZISNU Berdaya</h3>
                    <p class="text-xs text-[#404942] leading-relaxed">Gerakan Koin Infaq Ranting untuk beasiswa yatim, bantuan kesehatan lansia, dan bedah rumah warga.</p>
                </div>

                <div class="p-5 rounded-2xl bg-[#f8f9ff] border border-[#e6eeff] space-y-2.5">
                    <div class="w-10 h-10 rounded-xl bg-[#dce1ff] text-[#00164e] flex items-center justify-center font-bold">
                        <span class="material-symbols-outlined text-[22px]">id_card</span>
                    </div>
                    <h3 class="text-base font-bold text-[#121c2a]">KTA & SIMNU Terpadu</h3>
                    <p class="text-xs text-[#404942] leading-relaxed">Database warga digital dan pencetakan Kartu Tanda Anggota dengan sistem validasi QR Code publik.</p>
                </div>

                <div class="p-5 rounded-2xl bg-[#f8f9ff] border border-[#e6eeff] space-y-2.5">
                    <div class="w-10 h-10 rounded-xl bg-[#eff4ff] text-[#004125] flex items-center justify-center font-bold">
                        <span class="material-symbols-outlined text-[22px]">chat</span>
                    </div>
                    <h3 class="text-base font-bold text-[#121c2a]">Kotak Aspirasi Jamaah</h3>
                    <p class="text-xs text-[#404942] leading-relaxed">Wadah aduan sosial dan usulan program kemakmuran masjid dengan jaminan kerahasiaan identitas.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- 3. BADAN OTONOM (BANOM) SHOWCASE -->
<section class="py-16 bg-[#f8f9ff]">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-10">
        <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-4">
            <div>
                <span class="text-xs font-bold text-[#904d00] uppercase tracking-wider block">Garda Perjuangan Organisasi</span>
                <h2 class="text-2xl sm:text-3xl font-extrabold text-[#004125] tracking-tight">5 Badan Otonom (BANOM) NU</h2>
            </div>
            <a href="{{ route('banom.index') }}" class="text-sm font-bold text-[#0c5a37] hover:underline flex items-center gap-1">
                <span>Lihat Seluruh BANOM</span>
                <span class="material-symbols-outlined text-[16px]">arrow_forward</span>
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-5">
            @foreach ($banoms as $banom)
                <div class="bg-white rounded-2xl p-5 shadow-sm border border-[#e6eeff] flex flex-col justify-between hover:shadow-md transition-all hover:-translate-y-1">
                    <div class="space-y-4">
                        <div class="flex items-center justify-between">
                            <span class="px-2.5 py-1 rounded-full text-[11px] font-bold text-white" style="background-color: {{ $banom->warna_primer ?? '#0c5a37' }};">
                                {{ $banom->singkatan }}
                            </span>
                            <span class="material-symbols-outlined text-[22px] text-gray-400">shield</span>
                        </div>
                        <div>
                            <h3 class="text-base font-bold text-[#121c2a] leading-snug">{{ $banom->nama }}</h3>
                            <p class="text-xs text-[#404942] mt-2 line-clamp-3 leading-relaxed">{{ $banom->deskripsi }}</p>
                        </div>
                    </div>
                    <div class="pt-5 mt-4 border-t border-[#eff4ff] flex items-center justify-between">
                        <span class="text-[11px] text-[#404942] font-semibold">{{ $banom->members_count ?? $banom->members()->count() }} Kader</span>
                        <a href="{{ route('banom.show', $banom->slug) }}" class="text-xs font-bold text-[#0c5a37] hover:underline flex items-center gap-1">
                            <span>Profil</span>
                            <span class="material-symbols-outlined text-[14px]">arrow_forward</span>
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

<!-- 4. BERITA TERBARU & WARTA RANTING -->
<section class="py-16 bg-white border-t border-b border-[#e6eeff]">
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
                <article class="bg-white rounded-2xl overflow-hidden border border-[#e6eeff] shadow-sm hover:shadow-md transition-all flex flex-col justify-between">
                    <div>
                        <!-- Thumbnail -->
                        <div class="h-44 w-full bg-[#eff4ff] flex items-center justify-center overflow-hidden relative">
                            @if ($post->thumbnail)
                                <img src="{{ asset('storage/' . $post->thumbnail) }}" alt="{{ $post->title }}" class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full bg-gradient-to-br from-[#0c5a37] to-[#002110] flex items-center justify-center text-white/40">
                                    <span class="material-symbols-outlined text-[48px]">newspaper</span>
                                </div>
                            @endif
                            <span class="absolute top-3 left-3 px-2.5 py-1 rounded-full text-[10px] font-bold text-white bg-[#004125]/90 backdrop-blur-sm">
                                {{ $post->banom ? $post->banom->singkatan : $post->kategori }}
                            </span>
                        </div>

                        <!-- Content -->
                        <div class="p-4 space-y-2">
                            <span class="text-[11px] text-[#707971] font-medium flex items-center gap-1">
                                <span class="material-symbols-outlined text-[13px]">calendar_today</span>
                                <span>{{ $post->published_at ? $post->published_at->format('d M Y') : $post->created_at->format('d M Y') }}</span>
                            </span>
                            <h3 class="text-sm font-bold text-[#121c2a] line-clamp-2 hover:text-[#004125] transition-colors leading-snug">
                                <a href="{{ route('post.show', $post->slug) }}">{{ $post->title }}</a>
                            </h3>
                            <p class="text-xs text-[#404942] line-clamp-2 leading-relaxed">
                                {{ $post->excerpt ?? Str::limit(strip_tags($post->content), 80) }}
                            </p>
                        </div>
                    </div>

                    <div class="p-4 pt-0">
                        <a href="{{ route('post.show', $post->slug) }}" class="text-xs font-bold text-[#0c5a37] hover:underline flex items-center gap-1">
                            <span>Baca Selengkapnya</span>
                            <span class="material-symbols-outlined text-[14px]">arrow_forward</span>
                        </a>
                    </div>
                </article>
            @empty
                <div class="col-span-4 p-8 text-center bg-[#eff4ff] rounded-2xl text-xs text-[#404942]">
                    Belum ada warta berita yang diterbitkan.
                </div>
            @endforelse
        </div>
    </div>
</section>

<!-- 5. AGENDA TERDEKAT & WIDGET JADWAL SHOLAT -->
<section class="py-16 bg-[#f8f9ff]">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 items-start">
            
            <!-- Left: Upcoming Events (8 cols) -->
            <div class="lg:col-span-8 space-y-6">
                <div class="flex items-center justify-between">
                    <div>
                        <span class="text-xs font-bold text-[#904d00] uppercase tracking-wider block">Jadwal & Pengajian</span>
                        <h2 class="text-2xl font-extrabold text-[#004125] tracking-tight">Agenda Terdekat Ranting</h2>
                    </div>
                    <a href="{{ route('event.index') }}" class="text-sm font-bold text-[#0c5a37] hover:underline">Lihat Semua →</a>
                </div>

                <div class="space-y-4">
                    @forelse ($events as $event)
                        <div class="bg-white rounded-2xl p-5 border border-[#e6eeff] shadow-sm flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 hover:border-[#0c5a37] transition-all">
                            <div class="flex items-start gap-4">
                                <div class="w-14 h-14 rounded-2xl bg-[#eff4ff] text-[#004125] flex flex-col items-center justify-center shrink-0 border border-[#dee9fc]">
                                    <span class="text-xs font-bold uppercase">{{ $event->tanggal->format('M') }}</span>
                                    <span class="text-lg font-extrabold leading-none">{{ $event->tanggal->format('d') }}</span>
                                </div>
                                <div>
                                    <div class="flex items-center gap-2 mb-1">
                                        <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-[#eff4ff] text-[#004125]">
                                            {{ $event->banom ? $event->banom->singkatan : 'PRNU Induk' }}
                                        </span>
                                        @if ($event->waktu_mulai)
                                            <span class="text-[11px] text-[#707971] flex items-center gap-0.5">
                                                <span class="material-symbols-outlined text-[13px]">schedule</span>
                                                <span>{{ date('H:i', strtotime($event->waktu_mulai)) }} WIB</span>
                                            </span>
                                        @endif
                                    </div>
                                    <h3 class="text-base font-bold text-[#121c2a]">{{ $event->title }}</h3>
                                    <p class="text-xs text-[#404942] flex items-center gap-1 mt-1">
                                        <span class="material-symbols-outlined text-[14px] text-[#904d00]">location_on</span>
                                        <span>{{ $event->lokasi }}</span>
                                    </p>
                                </div>
                            </div>
                            <a href="{{ route('event.show', $event->slug) }}" class="shrink-0 px-4 py-2 rounded-xl bg-[#eff4ff] text-[#004125] hover:bg-[#0c5a37] hover:text-white font-bold text-xs transition-colors">
                                Detail
                            </a>
                        </div>
                    @empty
                        <div class="p-6 text-center bg-white rounded-2xl border border-[#e6eeff] text-xs text-[#404942]">
                            Belum ada agenda terdekat yang dijadwalkan.
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- Right: Widget Jadwal Sholat & KTA Quick Banner (4 cols) -->
            <div class="lg:col-span-4 space-y-6">
                <!-- Jadwal Sholat Widget -->
                <div class="bg-white rounded-2xl p-6 border-t-4 border-[#0c5a37] shadow-sm border-x border-b border-[#e6eeff] space-y-4">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-2">
                            <span class="material-symbols-outlined text-[#004125] text-[22px]">schedule</span>
                            <h3 class="text-sm font-bold text-[#004125]">Jadwal Sholat Hari Ini</h3>
                        </div>
                        <span class="text-[11px] font-semibold text-[#904d00]">Bojonegoro & Sekitarnya</span>
                    </div>

                    <div class="divide-y divide-[#eff4ff] text-xs">
                        <div class="py-2 flex items-center justify-between">
                            <span class="text-[#404942]">Subuh</span>
                            <span class="font-bold text-[#121c2a]">04:22 WIB</span>
                        </div>
                        <div class="py-2 flex items-center justify-between">
                            <span class="text-[#404942]">Dzuhur</span>
                            <span class="font-bold text-[#121c2a]">11:46 WIB</span>
                        </div>
                        <div class="py-2 flex items-center justify-between bg-[#fef3c7] px-2 rounded-lg text-[#92400e]">
                            <span class="font-bold">Ashar (Berikutnya)</span>
                            <span class="font-extrabold">15:18 WIB</span>
                        </div>
                        <div class="py-2 flex items-center justify-between">
                            <span class="text-[#404942]">Maghrib</span>
                            <span class="font-bold text-[#121c2a]">17:54 WIB</span>
                        </div>
                        <div class="py-2 flex items-center justify-between">
                            <span class="text-[#404942]">Isya</span>
                            <span class="font-bold text-[#121c2a]">19:04 WIB</span>
                        </div>
                    </div>

                    <p class="text-[10px] text-[#707971] text-center italic">Rujukan hisab & rukyat resmi Lembaga Falakiyah NU</p>
                </div>

                <!-- KTA Verification CTA Card -->
                <div class="bg-gradient-to-br from-[#0c5a37] to-[#002110] rounded-2xl p-6 text-white space-y-3 shadow-md">
                    <div class="flex items-center gap-2 text-[#aaf2c4]">
                        <span class="material-symbols-outlined text-[20px]">qr_code_scanner</span>
                        <span class="text-xs font-bold uppercase tracking-wider">Verifikasi KTA SIMNU</span>
                    </div>
                    <h3 class="text-lg font-bold">Punya Kartu Anggota NU?</h3>
                    <p class="text-xs text-emerald-100/90 leading-relaxed">
                        Pindai QR Code pada e-KTA digital atau fisik untuk memvalidasi nomor registrasi keanggotaan kader secara instan.
                    </p>
                    <div class="pt-2">
                        <a href="{{ route('kta.verify.search') }}" class="inline-flex items-center justify-center w-full gap-2 px-4 py-2.5 rounded-xl bg-[#fe932c] hover:bg-[#904d00] text-[#2f1500] hover:text-white font-bold text-xs transition-colors">
                            <span class="material-symbols-outlined text-[16px]">verified</span>
                            <span>Verifikasi KTA Sekarang</span>
                        </a>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>

<!-- 6. BANNER KOTAK ASPIRASI WARGA -->
<section class="py-14 bg-gradient-to-r from-[#004125] via-[#0c5a37] to-[#004125] text-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col lg:flex-row items-center justify-between gap-8">
            <div class="space-y-2 max-w-2xl text-center lg:text-left">
                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-white/10 text-xs font-semibold text-[#aaf2c4]">
                    <span class="material-symbols-outlined text-[15px]">shield</span>
                    <span>Transparansi & Tabayyun Jamaah</span>
                </span>
                <h2 class="text-2xl sm:text-3xl font-extrabold tracking-tight">Sampaikan Aspirasi, Kritik & Masukan Desa</h2>
                <p class="text-sm text-emerald-100/90 leading-relaxed">
                    Wadah resmi warga nahdliyin Banjaranyar untuk menyampaikan gagasan pembangunan tempat ibadah, usulan kegiatan, dan pengaduan sosial dengan kerahasiaan identitas terjamin.
                </p>
            </div>
            <div class="flex flex-wrap items-center gap-3 shrink-0">
                <a href="{{ route('aspirasi.create') }}" class="inline-flex items-center gap-2 bg-[#fe932c] hover:bg-[#904d00] text-[#2f1500] hover:text-white font-bold text-sm px-6 py-3.5 rounded-xl shadow-lg transition-all">
                    <span class="material-symbols-outlined text-[20px]">chat</span>
                    <span>Tulis Aspirasi Warga</span>
                </a>
                <a href="{{ route('aspirasi.track') }}" class="inline-flex items-center gap-2 bg-white/10 hover:bg-white/20 text-white font-semibold text-sm px-5 py-3.5 rounded-xl border border-white/20 transition-colors">
                    <span class="material-symbols-outlined text-[18px]">manage_search</span>
                    <span>Lacak Status Tiket</span>
                </a>
            </div>
        </div>
    </div>
</section>
@endsection
