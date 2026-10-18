@extends('layouts.app')

@section('title', $gallery->judul . ' — Galeri NU Ranting Banjaranyar')

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
            <a href="{{ route('galeri.index') }}" class="hover:underline">Galeri</a>
            <span>/</span>
            <span class="text-white font-semibold truncate max-w-xs">{{ $gallery->judul }}</span>
        </nav>

        <div class="flex flex-col lg:flex-row lg:items-end justify-between gap-6 pt-2">
            <div class="space-y-2 max-w-3xl">
                <span class="inline-flex items-center gap-2 bg-white/10 px-3.5 py-1.5 rounded-full text-xs font-bold text-[#aaf2c4]">
                    <span class="material-symbols-outlined text-[16px]">image</span>
                    <span>Album {{ $gallery->kategori }}</span>
                </span>
                <h1 class="text-2xl sm:text-4xl font-black tracking-tight leading-snug">{{ $gallery->judul }}</h1>
                <div class="flex flex-wrap items-center gap-4 text-xs sm:text-sm text-emerald-100 pt-1">
                    <span class="flex items-center gap-1.5">
                        <span class="material-symbols-outlined text-[16px] text-[#fe932c]">calendar_today</span>
                        <span>{{ $gallery->tanggal->translatedFormat('l, d F Y') }}</span>
                    </span>
                    @if ($gallery->lokasi)
                        <span class="flex items-center gap-1.5">
                            <span class="material-symbols-outlined text-[16px] text-[#fe932c]">location_on</span>
                            <span>{{ $gallery->lokasi }}</span>
                        </span>
                    @endif
                    <span class="flex items-center gap-1.5 font-bold text-[#aaf2c4]">
                        <span class="material-symbols-outlined text-[16px]">photo_library</span>
                        <span>{{ $gallery->photos->count() }} Foto Dokumentasi</span>
                    </span>
                </div>
            </div>

            <a href="{{ route('galeri.index') }}" class="inline-flex items-center gap-2 px-5 py-3 rounded-2xl bg-white text-[#004125] font-black text-xs sm:text-sm shadow-md hover:bg-emerald-50 transition-all shrink-0">
                <span class="material-symbols-outlined text-[18px]">arrow_back</span>
                <span>Kembali ke Semua Album</span>
            </a>
        </div>
    </div>
</section>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10 space-y-12">
    
    @if ($gallery->deskripsi)
        <!-- Album Description Box -->
        <div class="bg-white p-6 sm:p-8 rounded-3xl border border-[#e6eeff] shadow-sm space-y-2 max-w-4xl">
            <h2 class="text-sm font-bold text-[#004125] uppercase tracking-wider">Catatan Kegiatan</h2>
            <p class="text-sm sm:text-base text-[#404942] leading-relaxed">
                {{ $gallery->deskripsi }}
            </p>
        </div>
    @endif

    <!-- Album Photos Grid -->
    <div class="space-y-6">
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-2.5">
                <span class="w-3 h-7 rounded-full bg-[#0c5a37]"></span>
                <h2 class="text-xl sm:text-2xl font-black text-[#121c2a]">Foto Dokumentasi Album</h2>
            </div>
            <span class="text-xs text-[#526350]">Klik foto untuk membuka layar penuh</span>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            @forelse ($gallery->photos as $index => $photo)
                <div class="group bg-white rounded-3xl overflow-hidden border border-[#e6eeff] shadow-sm hover:shadow-xl transition-all cursor-pointer card-hover flex flex-col justify-between" onclick="openAlbumLightbox({{ $index }})">
                    <div class="relative aspect-4/3 overflow-hidden bg-slate-100">
                        <img src="{{ asset('storage/' . $photo->foto) }}" alt="{{ $photo->caption ?? $gallery->judul }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300" loading="lazy">
                        <div class="absolute inset-0 bg-black/30 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center text-white">
                            <span class="material-symbols-outlined text-4xl">zoom_in</span>
                        </div>
                    </div>

                    @if ($photo->caption)
                        <div class="p-4 bg-white text-xs font-semibold text-[#526350] line-clamp-2">
                            {{ $photo->caption }}
                        </div>
                    @endif
                </div>
            @empty
                <div class="col-span-4 p-12 text-center bg-white rounded-3xl border border-[#e6eeff] text-sm text-[#404942]">
                    Belum ada foto yang diunggah ke album ini.
                </div>
            @endforelse
        </div>
    </div>

</div>

<!-- ================= LIGHTBOX MODAL (BESAR, BISA GESER KIRI-KANAN) ================= -->
<div id="albumLightboxModal" class="hidden fixed inset-0 z-50 bg-black/95 backdrop-blur-md flex flex-col justify-between p-4 sm:p-8 select-none" role="dialog" aria-modal="true">
    <!-- Top Bar -->
    <div class="flex items-center justify-between text-white z-10">
        <div class="flex items-center gap-2">
            <span class="material-symbols-outlined text-[#fe932c] text-[24px]">photo</span>
            <span id="albLbCounter" class="text-sm sm:text-base font-extrabold tracking-wide">Foto 1 dari 1</span>
        </div>

        <button type="button" onclick="closeAlbumLightbox()" aria-label="Tutup Galeri" class="w-12 h-12 rounded-2xl bg-white/10 hover:bg-white/20 text-white flex items-center justify-center transition-all hover:scale-105">
            <span class="material-symbols-outlined text-[32px]">close</span>
        </button>
    </div>

    <!-- Center: Main Image with Prev / Next -->
    <div class="relative flex-1 flex items-center justify-center my-4 overflow-hidden">
        <!-- Prev Arrow -->
        <button type="button" onclick="prevAlbumImage()" aria-label="Foto Sebelumnya" class="absolute left-2 sm:left-4 z-20 w-12 h-12 sm:w-16 sm:h-16 rounded-2xl bg-white/15 hover:bg-white/30 text-white flex items-center justify-center transition-all hover:scale-105 shadow-xl backdrop-blur-sm">
            <span class="material-symbols-outlined text-[36px] sm:text-[44px]">chevron_left</span>
        </button>

        <!-- Current Image -->
        <div class="max-w-5xl max-h-[70vh] flex items-center justify-center p-2">
            <img id="albLbMainImg" src="" alt="Foto Galeri" class="max-w-full max-h-[70vh] object-contain rounded-2xl shadow-2xl transition-opacity duration-200">
        </div>

        <!-- Next Arrow -->
        <button type="button" onclick="nextAlbumImage()" aria-label="Foto Selanjutnya" class="absolute right-2 sm:right-4 z-20 w-12 h-12 sm:w-16 sm:h-16 rounded-2xl bg-white/15 hover:bg-white/30 text-white flex items-center justify-center transition-all hover:scale-105 shadow-xl backdrop-blur-sm">
            <span class="material-symbols-outlined text-[36px] sm:text-[44px]">chevron_right</span>
        </button>
    </div>

    <!-- Bottom Bar: Caption -->
    <div class="text-center text-white z-10 max-w-2xl mx-auto space-y-1 bg-black/40 px-6 py-3 rounded-2xl backdrop-blur-sm border border-white/10">
        <p id="albLbCaption" class="text-sm sm:text-base font-bold leading-snug"></p>
        <p class="text-xs text-emerald-300">{{ $gallery->judul }}</p>
    </div>
</div>

@php
    $albumPhotosData = $gallery->photos->map(function($p) use ($gallery) {
        return [
            'src' => asset('storage/' . $p->foto),
            'caption' => $p->caption ?? $gallery->judul,
        ];
    })->values();
@endphp

@push('scripts')
<script>
    const albumPhotos = @json($albumPhotosData);

    let currentAlbIdx = 0;
    const albModal = document.getElementById('albumLightboxModal');
    const albMainImg = document.getElementById('albLbMainImg');
    const albCounter = document.getElementById('albLbCounter');
    const albCaption = document.getElementById('albLbCaption');

    function openAlbumLightbox(index) {
        if (!albumPhotos || albumPhotos.length === 0) return;
        currentAlbIdx = index;
        updateAlbumLbView();
        albModal.classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }

    function closeAlbumLightbox() {
        albModal.classList.add('hidden');
        document.body.style.overflow = '';
    }

    function updateAlbumLbView() {
        const item = albumPhotos[currentAlbIdx];
        albMainImg.src = item.src;
        albCounter.textContent = `Foto ${currentAlbIdx + 1} dari ${albumPhotos.length}`;
        albCaption.textContent = item.caption;
    }

    function prevAlbumImage() {
        currentAlbIdx = (currentAlbIdx - 1 + albumPhotos.length) % albumPhotos.length;
        updateAlbumLbView();
    }

    function nextAlbumImage() {
        currentAlbIdx = (currentAlbIdx + 1) % albumPhotos.length;
        updateAlbumLbView();
    }

    // Keyboard navigation
    document.addEventListener('keydown', (e) => {
        if (albModal.classList.contains('hidden')) return;
        if (e.key === 'Escape') closeAlbumLightbox();
        if (e.key === 'ArrowLeft') prevAlbumImage();
        if (e.key === 'ArrowRight') nextAlbumImage();
    });
</script>
@endpush
@endsection
