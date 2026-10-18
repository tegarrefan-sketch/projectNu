@extends('layouts.app')

@section('title', 'Galeri Kegiatan & Dokumentasi — NU Ranting Banjaranyar')

@section('content')
<!-- Header Banner -->
<section class="bg-gradient-to-r from-[#003820] to-[#0c5a37] text-white py-14">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-4">
        <nav class="flex items-center gap-2 text-xs text-emerald-200">
            <a href="{{ route('home') }}" class="hover:underline flex items-center gap-1">
                <span class="material-symbols-outlined text-[14px]">home</span>
                <span>Beranda</span>
            </a>
            <span>/</span>
            <span class="text-white font-semibold">Galeri Kegiatan</span>
        </nav>

        <div class="flex flex-col lg:flex-row lg:items-end justify-between gap-6 pt-2">
            <div class="space-y-2 max-w-2xl">
                <div class="inline-flex items-center gap-2 bg-white/10 px-3.5 py-1.5 rounded-full text-xs font-bold text-[#aaf2c4]">
                    <span class="material-symbols-outlined text-[16px]">photo_library</span>
                    <span>Arsip Visual & Syiar Jam'iyyah</span>
                </div>
                <h1 class="text-3xl sm:text-4xl font-extrabold tracking-tight">Galeri Foto & Dokumentasi</h1>
                <p class="text-xs sm:text-sm text-emerald-100 leading-relaxed">
                    Dokumentasi visual kegiatan pengajian, istighotsah kubro, bakti sosial LAZISNU, apel siaga Banser, dan kaderisasi di Desa Banjaranyar.
                </p>
            </div>

            <!-- Search Form -->
            <form method="GET" action="{{ route('galeri.index') }}" class="w-full lg:w-80">
                <div class="relative">
                    <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-[18px]">search</span>
                    <input type="text" name="q" value="{{ $search }}" placeholder="Cari album kegiatan..." class="w-full bg-white/10 text-white placeholder-emerald-200/60 pl-9 pr-4 py-2.5 rounded-xl text-xs sm:text-sm border border-white/20 focus:outline-none focus:bg-white/20 transition-all">
                </div>
            </form>
        </div>
    </div>
</section>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10 space-y-10">
    
    <!-- Category Filter Chips -->
    <div class="flex items-center gap-2 overflow-x-auto pb-1 bg-white p-3 rounded-2xl border border-[#e6eeff] shadow-sm">
        <a href="{{ route('galeri.index', ['q' => $search]) }}" class="px-4 py-2 rounded-xl text-xs font-bold whitespace-nowrap transition-all {{ empty($kategori) ? 'bg-[#004125] text-white shadow-sm' : 'bg-[#eff4ff] text-[#404942] hover:bg-[#dee9fc]' }}">
            Semua Album
        </a>
        @foreach ($categories as $cat)
            <a href="{{ route('galeri.index', ['kategori' => $cat, 'q' => $search]) }}" class="px-4 py-2 rounded-xl text-xs font-bold whitespace-nowrap transition-all {{ $kategori === $cat ? 'bg-[#004125] text-white shadow-sm' : 'bg-[#eff4ff] text-[#404942] hover:bg-[#dee9fc]' }}">
                {{ $cat }}
            </a>
        @endforeach
    </div>

    <!-- Album Cards Grid (Responsive, clear gap, elder friendly) -->
    <div class="space-y-6">
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-2.5">
                <span class="w-3 h-7 rounded-full bg-[#0c5a37]"></span>
                <h2 class="text-xl sm:text-2xl font-black text-[#121c2a]">Daftar Album Kegiatan</h2>
            </div>
            <span class="text-xs text-[#526350] font-semibold">{{ $galleries->total() }} Album Tersedia</span>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @forelse ($galleries as $gallery)
                <div class="bg-white rounded-3xl overflow-hidden border-2 border-[#e6eeff] hover:border-[#0c5a37] shadow-sm hover:shadow-xl transition-all duration-300 flex flex-col justify-between card-hover">
                    <div>
                        <!-- Album Cover Preview -->
                        <div class="relative h-56 bg-slate-100 overflow-hidden group">
                            @if ($gallery->cover)
                                <img src="{{ asset('storage/' . $gallery->cover) }}" alt="{{ $gallery->judul }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300" loading="lazy">
                            @elseif ($gallery->photos->first())
                                <img src="{{ asset('storage/' . $gallery->photos->first()->foto) }}" alt="{{ $gallery->judul }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300" loading="lazy">
                            @else
                                <div class="w-full h-full bg-gradient-to-br from-[#004125] to-[#0c5a37] flex items-center justify-center text-white/50">
                                    <span class="material-symbols-outlined text-6xl">photo_library</span>
                                </div>
                            @endif

                            <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-transparent to-transparent"></div>

                            <span class="absolute top-3 left-3 px-3 py-1 rounded-full text-xs font-extrabold text-white bg-[#004125]/90 backdrop-blur-md">
                                {{ $gallery->kategori }}
                            </span>

                            <span class="absolute bottom-3 right-3 px-2.5 py-1 rounded-xl text-xs font-bold text-white bg-black/60 backdrop-blur-md flex items-center gap-1">
                                <span class="material-symbols-outlined text-[16px]">image</span>
                                <span>{{ $gallery->photos->count() }} Foto</span>
                            </span>
                        </div>

                        <!-- Info -->
                        <div class="p-6 space-y-2.5">
                            <span class="text-xs font-semibold text-[#0c5a37] flex items-center gap-1.5">
                                <span class="material-symbols-outlined text-[15px]">calendar_today</span>
                                <span>{{ $gallery->tanggal->translatedFormat('d F Y') }}</span>
                            </span>

                            <h3 class="text-lg font-black text-[#121c2a] leading-snug line-clamp-2 hover:text-[#004125] transition-colors">
                                <a href="{{ route('galeri.show', $gallery->slug) }}">{{ $gallery->judul }}</a>
                            </h3>

                            @if ($gallery->lokasi)
                                <p class="text-xs text-[#526350] flex items-center gap-1.5">
                                    <span class="material-symbols-outlined text-[16px] text-[#fe932c]">location_on</span>
                                    <span class="truncate">{{ $gallery->lokasi }}</span>
                                </p>
                            @endif

                            <p class="text-xs text-[#707971] line-clamp-2 leading-relaxed pt-1">
                                {{ $gallery->deskripsi ?? 'Dokumentasi resmi PRNU Banjaranyar.' }}
                            </p>
                        </div>
                    </div>

                    <div class="p-6 pt-0">
                        <a href="{{ route('galeri.show', $gallery->slug) }}" class="inline-flex items-center justify-center w-full gap-2 px-5 py-3 rounded-2xl bg-[#eff4ff] hover:bg-[#004125] text-[#004125] hover:text-white font-extrabold text-xs transition-colors shadow-sm">
                            <span>Buka Foto Album ({{ $gallery->photos->count() }})</span>
                            <span class="material-symbols-outlined text-[16px]">arrow_forward</span>
                        </a>
                    </div>
                </div>
            @empty
                <div class="col-span-3 p-12 text-center bg-white rounded-3xl border border-[#e6eeff] space-y-2">
                    <span class="material-symbols-outlined text-gray-400 text-5xl">photo_library</span>
                    <h3 class="text-base font-bold text-[#121c2a]">Belum Ada Album Foto</h3>
                    <p class="text-xs text-[#526350]">Dokumentasi kegiatan akan segera ditambahkan oleh pengurus.</p>
                </div>
            @endforelse
        </div>

        <div class="pt-4">
            {{ $galleries->links() }}
        </div>
    </div>

    <!-- Photostream Preview Grid with Instant Lightbox Trigger -->
    @if ($recentPhotos->isNotEmpty())
        <div class="space-y-6 pt-6 border-t border-[#e6eeff]">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-2.5">
                    <span class="w-3 h-7 rounded-full bg-[#fe932c]"></span>
                    <h2 class="text-xl sm:text-2xl font-black text-[#121c2a]">Foto Dokumentasi Terbaru</h2>
                </div>
                <span class="text-xs text-[#526350]">Klik gambar untuk memperbesar</span>
            </div>

            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-4" id="photostreamGrid">
                @foreach ($recentPhotos as $index => $rp)
                    <div class="group relative rounded-2xl overflow-hidden aspect-square bg-slate-100 border border-[#e6eeff] shadow-sm cursor-pointer card-hover" onclick="openLightbox({{ $index }})">
                        <img src="{{ asset('storage/' . $rp->foto) }}" alt="{{ $rp->caption ?? $rp->gallery->judul }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300" loading="lazy">
                        <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center text-white">
                            <span class="material-symbols-outlined text-3xl">zoom_in</span>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif

</div>

<!-- ================= LIGHTBOX MODAL (BESAR, BISA GESER KIRI-KANAN, RAMAH ORANG TUA) ================= -->
<div id="lightboxModal" class="hidden fixed inset-0 z-50 bg-black/95 backdrop-blur-md flex flex-col justify-between p-4 sm:p-8 select-none" role="dialog" aria-modal="true">
    <!-- Top Bar: Counter & Big Close Button -->
    <div class="flex items-center justify-between text-white z-10">
        <div class="flex items-center gap-2">
            <span class="material-symbols-outlined text-[#fe932c] text-[24px]">photo</span>
            <span id="lbCounter" class="text-sm sm:text-base font-extrabold tracking-wide">Foto 1 dari 1</span>
        </div>

        <button type="button" onclick="closeLightbox()" aria-label="Tutup Galeri" class="w-12 h-12 rounded-2xl bg-white/10 hover:bg-white/20 text-white flex items-center justify-center transition-all hover:scale-105">
            <span class="material-symbols-outlined text-[32px]">close</span>
        </button>
    </div>

    <!-- Center: Main Image with Prev / Next Navigation -->
    <div class="relative flex-1 flex items-center justify-center my-4 overflow-hidden">
        <!-- Prev Arrow (Big, Left) -->
        <button type="button" onclick="prevLightboxImage()" aria-label="Foto Sebelumnya" class="absolute left-2 sm:left-4 z-20 w-12 h-12 sm:w-16 sm:h-16 rounded-2xl bg-white/15 hover:bg-white/30 text-white flex items-center justify-center transition-all hover:scale-105 shadow-xl backdrop-blur-sm">
            <span class="material-symbols-outlined text-[36px] sm:text-[44px]">chevron_left</span>
        </button>

        <!-- Current Image -->
        <div class="max-w-5xl max-h-[70vh] flex items-center justify-center p-2">
            <img id="lbMainImg" src="" alt="Foto Galeri" class="max-w-full max-h-[70vh] object-contain rounded-2xl shadow-2xl transition-opacity duration-200">
        </div>

        <!-- Next Arrow (Big, Right) -->
        <button type="button" onclick="nextLightboxImage()" aria-label="Foto Selanjutnya" class="absolute right-2 sm:right-4 z-20 w-12 h-12 sm:w-16 sm:h-16 rounded-2xl bg-white/15 hover:bg-white/30 text-white flex items-center justify-center transition-all hover:scale-105 shadow-xl backdrop-blur-sm">
            <span class="material-symbols-outlined text-[36px] sm:text-[44px]">chevron_right</span>
        </button>
    </div>

    <!-- Bottom Bar: Caption and Album info -->
    <div class="text-center text-white z-10 max-w-2xl mx-auto space-y-1 bg-black/40 px-6 py-3 rounded-2xl backdrop-blur-sm border border-white/10">
        <p id="lbCaption" class="text-sm sm:text-base font-bold leading-snug"></p>
        <p id="lbAlbumTitle" class="text-xs text-emerald-300"></p>
    </div>
</div>

@php
    $lightboxData = $recentPhotos->map(function($p) {
        return [
            'src' => asset('storage/' . $p->foto),
            'caption' => $p->caption ?? $p->gallery->judul,
            'album' => $p->gallery->judul . ' (' . $p->gallery->tanggal->translatedFormat('d M Y') . ')',
        ];
    })->values();
@endphp

@push('scripts')
<script>
    // Photostream data for lightbox
    const lightboxPhotos = @json($lightboxData);

    let currentLbIndex = 0;
    const modal = document.getElementById('lightboxModal');
    const mainImg = document.getElementById('lbMainImg');
    const counter = document.getElementById('lbCounter');
    const caption = document.getElementById('lbCaption');
    const albumTitle = document.getElementById('lbAlbumTitle');

    function openLightbox(index) {
        if (!lightboxPhotos || lightboxPhotos.length === 0) return;
        currentLbIndex = index;
        updateLightboxView();
        modal.classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }

    function closeLightbox() {
        modal.classList.add('hidden');
        document.body.style.overflow = '';
    }

    function updateLightboxView() {
        const item = lightboxPhotos[currentLbIndex];
        mainImg.src = item.src;
        counter.textContent = `Foto ${currentLbIndex + 1} dari ${lightboxPhotos.length}`;
        caption.textContent = item.caption;
        albumTitle.textContent = item.album;
    }

    function prevLightboxImage() {
        currentLbIndex = (currentLbIndex - 1 + lightboxPhotos.length) % lightboxPhotos.length;
        updateLightboxView();
    }

    function nextLightboxImage() {
        currentLbIndex = (currentLbIndex + 1) % lightboxPhotos.length;
        updateLightboxView();
    }

    // Keyboard navigation
    document.addEventListener('keydown', (e) => {
        if (modal.classList.contains('hidden')) return;
        if (e.key === 'Escape') closeLightbox();
        if (e.key === 'ArrowLeft') prevLightboxImage();
        if (e.key === 'ArrowRight') nextLightboxImage();
    });
</script>
@endpush
@endsection
