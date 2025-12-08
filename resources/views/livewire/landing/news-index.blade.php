<?php

use function Livewire\Volt\{state, with, uses, mount};
use App\Models\News;
use App\Models\NewsCategory;
use App\Models\NewsTag;
use Livewire\WithPagination;

uses(WithPagination::class);

state(['categorySlug' => null, 'tagSlug' => null]);

mount(function ($category = null, $tag = null) {
    $this->categorySlug = $category;
    $this->tagSlug = $tag;
});

with(fn() => [
    'news' => News::with(['category', 'tags'])
        ->where('status', 'published')
        ->when($this->categorySlug, function ($query) {
            $query->whereHas('category', function ($q) {
                $q->where('slug', $this->categorySlug);
            });
        })
        ->when($this->tagSlug, function ($query) {
            $query->whereHas('tags', function ($q) {
                $q->where('slug', $this->tagSlug);
            });
        })
        ->orderBy('created_at', 'desc')
        ->paginate(10),
    'currentCategory' => $this->categorySlug ? NewsCategory::where('slug', $this->categorySlug)->first() : null,
    'currentTag' => $this->tagSlug ? NewsTag::where('slug', $this->tagSlug)->first() : null,
]);

?>

<section id="news" class="py-16 sm:py-20 bg-slate-50 dark:bg-navy-900 min-h-screen">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-base text-primary font-semibold tracking-wide uppercase">Berita</h2>
            <p class="mt-2 text-3xl leading-8 font-extrabold tracking-tight text-slate-900 dark:text-white sm:text-4xl">
                @if($currentCategory)
                    Kategori: {{ $currentCategory->nama_kategori }}
                @elseif($currentTag)
                    Tag: {{ $currentTag->nama_tag }}
                @else
                    Kabar Sekolah Terbaru
                @endif
            </p>
            <p class="mt-4 max-w-2xl text-xl text-slate-500 dark:text-slate-400 mx-auto">
                @if($currentCategory || $currentTag)
                    Menampilkan berita untuk
                    {{ $currentCategory ? 'kategori ' . $currentCategory->nama_kategori : 'tag ' . $currentTag->nama_tag }}
                    <br>
                    <a href="/berita" wire:navigate.hover class="text-primary hover:underline text-base mt-2 inline-block">
                        &larr; Kembali ke semua berita
                    </a>
                @else
                    Ikuti perkembangan terbaru dan informasi penting seputar kegiatan sekolah kami.
                @endif
            </p>
        </div>

        <div class="relative">
            <div wire:loading.flex
                class="absolute inset-0 z-10 items-center justify-center bg-white/50 dark:bg-navy-900/50 backdrop-blur-sm transition-all duration-300">
                <div class="flex items-center space-x-2">
                    <svg class="animate-spin h-8 w-8 text-primary" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4">
                        </circle>
                        <path class="opacity-75" fill="currentColor"
                            d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                        </path>
                    </svg>
                    <span class="text-primary font-medium">Memuat...</span>
                </div>
            </div>

            <div class="mt-10 grid gap-8 lg:grid-cols-3 md:grid-cols-2 sm:grid-cols-1"
                wire:loading.class="opacity-50 pointer-events-none">
                @forelse($news as $item)
                    <div
                        class="flex flex-col rounded-xl shadow-sm border border-slate-100 dark:border-navy-700 overflow-hidden bg-white dark:bg-navy-800 hover:shadow-md transition-shadow duration-300">
                        <div class="flex-shrink-0 relative h-48">
                            <img class="w-full h-full object-cover"
                                src="{{ $item->gambar ? asset('storage/' . $item->gambar) : 'https://images.unsplash.com/photo-1496128858413-b36217c2ce36?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=crop&w=1679&q=80' }}"
                                alt="{{ $item->judul }}">
                            <div class="absolute top-4 left-4">
                                <a href="/berita/kategori/{{ $item->category->slug ?? '#' }}" wire:navigate.hover
                                    class="px-3 py-1 text-xs font-semibold rounded-full bg-white/90 text-primary shadow-sm backdrop-blur-sm hover:bg-white transition-colors">
                                    {{ $item->category->nama_kategori ?? 'Umum' }}
                                </a>
                            </div>
                        </div>
                        <div class="flex-1 p-6 flex flex-col justify-between">
                            <div class="flex-1">
                                <div class="flex items-center text-xs text-slate-500 dark:text-slate-400 mb-3">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                    {{ $item->created_at->translatedFormat('d F Y') }}
                                </div>
                                <a href="/berita/{{ $item->slug }}" wire:navigate.hover class="block group">
                                    <h3
                                        class="text-xl font-bold text-slate-900 dark:text-white group-hover:text-primary transition-colors line-clamp-2">
                                        {{ $item->judul }}
                                    </h3>
                                    <p class="mt-3 text-base text-slate-500 dark:text-slate-400 line-clamp-3">
                                        {{ Str::limit(strip_tags($item->konten), 120) }}
                                    </p>
                                </a>
                            </div>

                            @if($item->tags->count() > 0)
                                <div class="mt-4 pt-4 border-t border-slate-100 dark:border-navy-700 flex flex-wrap gap-2">
                                    @foreach($item->tags->take(3) as $tag)
                                        <a href="/berita/tag/{{ $tag->slug }}" wire:navigate.hover
                                            class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-slate-100 text-slate-600 dark:bg-navy-700 dark:text-slate-300 hover:bg-primary/10 hover:text-primary transition-colors">
                                            #{{ $tag->nama_tag }}
                                        </a>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    </div>
                @empty
                    <div class="col-span-full text-center py-12">
                        <div
                            class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-slate-100 dark:bg-navy-700 mb-4">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-slate-400" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z" />
                            </svg>
                        </div>
                        <h3 class="text-lg font-medium text-slate-900 dark:text-white">Belum ada berita</h3>
                        <p class="mt-2 text-slate-500 dark:text-slate-400">
                            @if($currentCategory || $currentTag)
                                Tidak ada berita ditemukan untuk filter ini.
                            @else
                                Berita terbaru belum tersedia saat ini.
                            @endif
                        </p>
                        @if($currentCategory || $currentTag)
                            <a href="/berita" wire:navigate.hover class="mt-4 inline-block text-primary hover:underline">
                                Lihat semua berita
                            </a>
                        @endif
                    </div>
                @endforelse
            </div>
        </div>

        <div class="mt-12">
            {{ $news->links(data: ['scrollTo' => '#news']) }}
        </div>
    </div>
</section>