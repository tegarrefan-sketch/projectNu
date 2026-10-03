@extends('layouts.app')

@section('title', 'Warta & Berita — NU Ranting Banjaranyar')

@section('content')
<!-- Header Banner -->
<section class="bg-gradient-to-r from-[#004125] to-[#0c5a37] text-white py-14">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-4">
        <nav class="flex items-center gap-2 text-xs text-emerald-200">
            <a href="{{ route('home') }}" class="hover:underline flex items-center gap-1">
                <span class="material-symbols-outlined text-[14px]">home</span>
                <span>Beranda</span>
            </a>
            <span>/</span>
            <span class="text-white font-semibold">Warta & Berita</span>
        </nav>

        <div class="flex flex-col lg:flex-row lg:items-end justify-between gap-6 pt-2">
            <div class="space-y-2 max-w-2xl">
                <div class="inline-flex items-center gap-2 bg-white/10 px-3 py-1 rounded-full text-xs font-semibold text-[#aaf2c4]">
                    <span class="material-symbols-outlined text-[15px]">newspaper</span>
                    <span>Warta Resmi & Dokumentasi Khidmah</span>
                </div>
                <h1 class="text-3xl sm:text-4xl font-extrabold tracking-tight">Kabar Ranting & Syiar Nahdliyin</h1>
                <p class="text-xs sm:text-sm text-emerald-100 leading-relaxed">
                    Informasi resmi, liputan amaliyah Aswaja, dan kabar kegiatan 5 Badan Otonom se-Desa Banjaranyar.
                </p>
            </div>

            <!-- Search Form in Header -->
            <form method="GET" action="{{ route('post.index') }}" class="w-full lg:w-80">
                <div class="relative">
                    <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-[18px]">search</span>
                    <input type="text" name="q" value="{{ $search }}" placeholder="Cari warta atau topik..." class="w-full bg-white/10 text-white placeholder-emerald-200/60 pl-9 pr-4 py-2.5 rounded-xl text-xs border border-white/20 focus:outline-none focus:bg-white/20 transition-all">
                </div>
            </form>
        </div>
    </div>
</section>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10 space-y-8">
    
    <!-- Filter Chips & Sorting -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 bg-white p-4 rounded-2xl border border-[#e6eeff] shadow-sm">
        
        <!-- Category Filter Chips -->
        <div class="flex items-center gap-2 overflow-x-auto pb-1 md:pb-0">
            <a href="{{ route('post.index', ['kategori' => 'all', 'q' => $search, 'sort' => $sort]) }}" class="px-3.5 py-2 rounded-full text-xs font-bold whitespace-nowrap transition-all {{ $category === 'all' ? 'bg-[#004125] text-white shadow-sm' : 'bg-[#eff4ff] text-[#404942] hover:bg-[#dee9fc]' }}">
                Semua Warta
            </a>
            <a href="{{ route('post.index', ['kategori' => 'prnu', 'q' => $search, 'sort' => $sort]) }}" class="px-3.5 py-2 rounded-full text-xs font-bold whitespace-nowrap transition-all {{ $category === 'prnu' ? 'bg-[#004125] text-white shadow-sm' : 'bg-[#eff4ff] text-[#404942] hover:bg-[#dee9fc]' }}">
                Kegiatan Ranting
            </a>
            @foreach ($banoms as $b)
                <a href="{{ route('post.index', ['kategori' => $b->slug, 'q' => $search, 'sort' => $sort]) }}" class="px-3.5 py-2 rounded-full text-xs font-bold whitespace-nowrap transition-all {{ $category === $b->slug ? 'bg-[#004125] text-white shadow-sm' : 'bg-[#eff4ff] text-[#404942] hover:bg-[#dee9fc]' }}">
                    {{ $b->singkatan }}
                </a>
            @endforeach
        </div>

        <!-- Sort Select -->
        <form method="GET" action="{{ route('post.index') }}" class="flex items-center gap-2 shrink-0">
            <input type="hidden" name="kategori" value="{{ $category }}">
            <input type="hidden" name="q" value="{{ $search }}">
            <span class="text-xs text-[#707971] font-semibold hidden sm:inline">Urutkan:</span>
            <select name="sort" onchange="this.form.submit()" class="bg-[#eff4ff] text-xs font-semibold text-[#121c2a] px-3 py-2 rounded-xl border border-[#dee9fc] focus:outline-none">
                <option value="terbaru" {{ $sort === 'terbaru' ? 'selected' : '' }}>Terbit Terbaru</option>
                <option value="terpopuler" {{ $sort === 'terpopuler' ? 'selected' : '' }}>Paling Banyak Dibaca</option>
            </select>
        </form>

    </div>

    <!-- Featured Post (if on first page without filter) -->
    @if ($featured)
        <div class="bg-white rounded-3xl overflow-hidden border border-[#e6eeff] shadow-md grid grid-cols-1 lg:grid-cols-12 gap-0">
            <div class="lg:col-span-6 h-64 lg:h-auto bg-[#004125] relative overflow-hidden">
                @if ($featured->thumbnail)
                    <img src="{{ asset('storage/' . $featured->thumbnail) }}" alt="{{ $featured->title }}" class="w-full h-full object-cover">
                @else
                    <div class="w-full h-full flex items-center justify-center text-white/30">
                        <span class="material-symbols-outlined text-[64px]">newspaper</span>
                    </div>
                @endif
                <span class="absolute top-4 left-4 px-3 py-1 rounded-full text-xs font-bold text-white bg-[#004125]/90 backdrop-blur-sm">
                    Sorotan Warta Pilihan
                </span>
            </div>
            <div class="lg:col-span-6 p-6 sm:p-10 flex flex-col justify-between space-y-4">
                <div class="space-y-3">
                    <span class="text-xs text-[#707971] flex items-center gap-1">
                        <span class="material-symbols-outlined text-[14px]">calendar_today</span>
                        <span>{{ $featured->published_at ? $featured->published_at->format('d M Y') : $featured->created_at->format('d M Y') }}</span>
                        <span>• Oleh {{ $featured->author }}</span>
                    </span>
                    <h2 class="text-xl sm:text-2xl font-extrabold text-[#121c2a] hover:text-[#004125] leading-snug">
                        <a href="{{ route('post.show', $featured->slug) }}">{{ $featured->title }}</a>
                    </h2>
                    <p class="text-xs sm:text-sm text-[#404942] leading-relaxed">
                        {{ $featured->excerpt ?? Str::limit(strip_tags($featured->content), 140) }}
                    </p>
                </div>
                <div class="pt-2">
                    <a href="{{ route('post.show', $featured->slug) }}" class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-[#004125] text-white hover:bg-[#0c5a37] text-xs font-bold transition-colors">
                        <span>Baca Liputan Lengkap</span>
                        <span class="material-symbols-outlined text-[16px]">arrow_forward</span>
                    </a>
                </div>
            </div>
        </div>
    @endif

    <!-- News Grid (3 Columns) -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse ($posts as $post)
            <article class="bg-white rounded-2xl overflow-hidden border border-[#e6eeff] shadow-sm hover:shadow-md transition-all flex flex-col justify-between">
                <div>
                    <div class="h-48 w-full bg-[#eff4ff] flex items-center justify-center overflow-hidden relative">
                        @if ($post->thumbnail)
                            <img src="{{ asset('storage/' . $post->thumbnail) }}" alt="{{ $post->title }}" class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full bg-gradient-to-br from-[#0c5a37] to-[#002110] flex items-center justify-center text-white/40">
                                <span class="material-symbols-outlined text-[48px]">article</span>
                            </div>
                        @endif
                        <span class="absolute top-3 left-3 px-2.5 py-1 rounded-full text-[10px] font-bold text-white bg-[#004125]/90 backdrop-blur-sm">
                            {{ $post->banom ? $post->banom->singkatan : $post->kategori }}
                        </span>
                    </div>

                    <div class="p-5 space-y-2">
                        <div class="flex items-center justify-between text-[11px] text-[#707971]">
                            <span>{{ $post->published_at ? $post->published_at->format('d M Y') : $post->created_at->format('d M Y') }}</span>
                            <span class="flex items-center gap-0.5"><span class="material-symbols-outlined text-[13px]">visibility</span> {{ $post->views }}</span>
                        </div>
                        <h3 class="text-base font-bold text-[#121c2a] line-clamp-2 hover:text-[#004125] transition-colors leading-snug">
                            <a href="{{ route('post.show', $post->slug) }}">{{ $post->title }}</a>
                        </h3>
                        <p class="text-xs text-[#404942] line-clamp-2 leading-relaxed">
                            {{ $post->excerpt ?? Str::limit(strip_tags($post->content), 90) }}
                        </p>
                    </div>
                </div>

                <div class="p-5 pt-0">
                    <a href="{{ route('post.show', $post->slug) }}" class="text-xs font-bold text-[#0c5a37] hover:underline flex items-center gap-1">
                        <span>Baca Selengkapnya</span>
                        <span class="material-symbols-outlined text-[14px]">arrow_forward</span>
                    </a>
                </div>
            </article>
        @empty
            <div class="col-span-3 p-12 text-center bg-white rounded-2xl border border-[#e6eeff] text-sm text-[#404942]">
                Tidak ada artikel warta yang ditemukan.
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    <div class="pt-4">
        {{ $posts->links() }}
    </div>

</div>
@endsection
