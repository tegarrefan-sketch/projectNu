@extends('layouts.app')

@section('title', $post->title . ' — Warta NU Banjaranyar')
@section('meta_description', $post->excerpt ?? Str::limit(strip_tags($post->content), 150))

@section('content')
<!-- Header & Breadcrumbs -->
<div class="bg-white border-b border-[#e6eeff] py-4">
    <div class="max-w-4xl mx-auto px-4 sm:px-6">
        <nav class="flex items-center gap-2 text-xs text-[#707971]">
            <a href="{{ route('home') }}" class="hover:text-[#004125] flex items-center gap-1">
                <span class="material-symbols-outlined text-[14px]">home</span>
                <span>Beranda</span>
            </a>
            <span>/</span>
            <a href="{{ route('post.index') }}" class="hover:text-[#004125]">Warta & Berita</a>
            <span>/</span>
            <span class="text-[#004125] font-semibold truncate">{{ Str::limit($post->title, 40) }}</span>
        </nav>
    </div>
</div>

<article class="max-w-4xl mx-auto px-4 sm:px-6 py-10 space-y-8">
    
    <!-- Meta Header -->
    <header class="space-y-4">
        <div class="flex items-center gap-2 flex-wrap">
            <span class="px-3 py-1 rounded-full text-xs font-bold text-white bg-[#004125]">
                {{ $post->banom ? $post->banom->singkatan : $post->kategori }}
            </span>
            <span class="text-xs text-[#707971] flex items-center gap-1">
                <span class="material-symbols-outlined text-[14px]">calendar_today</span>
                <span>{{ $post->published_at ? $post->published_at->format('d F Y, H:i') : $post->created_at->format('d F Y') }} WIB</span>
            </span>
            <span class="text-xs text-[#707971]">• Oleh {{ $post->author }}</span>
            <span class="text-xs text-[#707971] flex items-center gap-1 ml-auto">
                <span class="material-symbols-outlined text-[14px]">visibility</span>
                <span>{{ $post->views }} tayangan</span>
            </span>
        </div>

        <h1 class="text-2xl sm:text-4xl font-extrabold text-[#121c2a] leading-tight tracking-tight">
            {{ $post->title }}
        </h1>

        @if ($post->excerpt)
            <p class="text-sm sm:text-base text-[#404942] italic bg-[#eff4ff] p-4 rounded-xl border-l-4 border-[#0c5a37] leading-relaxed">
                {{ $post->excerpt }}
            </p>
        @endif
    </header>

    <!-- Thumbnail Image -->
    @if ($post->thumbnail)
        <div class="rounded-3xl overflow-hidden shadow-sm border border-[#e6eeff] max-h-[480px]">
            <img src="{{ asset('storage/' . $post->thumbnail) }}" alt="{{ $post->title }}" class="w-full h-full object-cover">
        </div>
    @endif

    <!-- Article Content -->
    <div class="bg-white rounded-3xl p-6 sm:p-10 border border-[#e6eeff] shadow-sm text-sm sm:text-base text-[#121c2a] leading-relaxed space-y-4">
        {!! $post->content !!}
    </div>

    <!-- Share Widget -->
    <div class="bg-white rounded-2xl p-5 border border-[#e6eeff] shadow-sm flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <span class="text-xs font-bold text-[#121c2a] uppercase tracking-wider">Bagikan Warta Ini:</span>
        <div class="flex items-center gap-2">
            <a href="https://api.whatsapp.com/send?text={{ urlencode($post->title . ' ' . url()->current()) }}" target="_blank" class="px-3.5 py-2 rounded-xl bg-emerald-600 text-white text-xs font-bold flex items-center gap-1.5 hover:bg-emerald-700 transition-colors">
                <span class="material-symbols-outlined text-[16px]">share</span>
                <span>WhatsApp</span>
            </a>
            <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url()->current()) }}" target="_blank" class="px-3.5 py-2 rounded-xl bg-blue-600 text-white text-xs font-bold flex items-center gap-1.5 hover:bg-blue-700 transition-colors">
                <span>Facebook</span>
            </a>
            <button onclick="navigator.clipboard.writeText(window.location.href); alert('Tautan warta berhasil disalin!');" class="px-3.5 py-2 rounded-xl bg-[#eff4ff] text-[#004125] text-xs font-bold flex items-center gap-1.5 hover:bg-[#dee9fc] transition-colors">
                <span class="material-symbols-outlined text-[16px]">content_copy</span>
                <span>Salin Tautan</span>
            </button>
        </div>
    </div>

    <!-- Related Articles -->
    @if ($relatedPosts->isNotEmpty())
        <div class="space-y-4 pt-6">
            <h2 class="text-lg font-bold text-[#004125]">Warta Terkait Lainnya</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                @foreach ($relatedPosts as $rel)
                    <div class="bg-white rounded-2xl p-4 border border-[#e6eeff] shadow-sm space-y-2">
                        <span class="text-[10px] text-[#707971]">{{ $rel->published_at ? $rel->published_at->format('d M Y') : $rel->created_at->format('d M Y') }}</span>
                        <h3 class="text-xs font-bold text-[#121c2a] line-clamp-2">
                            <a href="{{ route('post.show', $rel->slug) }}" class="hover:text-[#004125] transition-colors">{{ $rel->title }}</a>
                        </h3>
                    </div>
                @endforeach
            </div>
        </div>
    @endif

</article>
@endsection
