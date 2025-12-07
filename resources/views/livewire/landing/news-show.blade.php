<?php

use function Livewire\Volt\{state, mount};
use App\Models\News;

state(['news' => null, 'recentNews' => []]);

mount(function ($slug) {
    $this->news = News::with(['category', 'tags'])
        ->where('slug', $slug)
        ->where('status', 'published')
        ->firstOrFail();

    $this->recentNews = News::where('status', 'published')
        ->where('id', '!=', $this->news->id)
        ->orderBy('created_at', 'desc')
        ->take(3)
        ->get();
});

?>

<section class="py-24 bg-slate-50 dark:bg-navy-900 min-h-screen">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-12">
            <!-- Main Content -->
            <div class="lg:col-span-2">
                <article
                    class="bg-white dark:bg-navy-800 rounded-2xl shadow-sm border border-slate-100 dark:border-navy-700 overflow-hidden">
                    <div class="relative h-64 sm:h-96 w-full">
                        <img class="w-full h-full object-cover"
                            src="{{ $news->gambar ? asset('storage/' . $news->gambar) : 'https://images.unsplash.com/photo-1496128858413-b36217c2ce36?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=crop&w=1679&q=80' }}"
                            alt="{{ $news->judul }}">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
                        <div class="absolute bottom-6 left-6 right-6">
                            <a href="/berita/kategori/{{ $news->category->slug ?? '#' }}" wire:navigate.hover
                                class="px-3 py-1 text-xs font-semibold rounded-full bg-primary text-white shadow-sm mb-3 inline-block hover:bg-primary-focus transition-colors">
                                {{ $news->category->nama_kategori ?? 'Umum' }}
                            </a>
                            <h1 class="text-2xl sm:text-3xl font-bold text-white leading-tight">
                                {{ $news->judul }}
                            </h1>
                        </div>
                    </div>

                    <div class="p-8">
                        <div
                            class="flex items-center text-sm text-slate-500 dark:text-slate-400 mb-8 pb-8 border-b border-slate-100 dark:border-navy-700">
                            <div class="flex items-center mr-6">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                {{ $news->created_at->translatedFormat('d F Y') }}
                            </div>
                            <div class="flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                {{ $news->created_at->format('H:i') }} WIB
                            </div>
                        </div>

                        <div class="prose prose-slate dark:prose-invert max-w-none">
                            {!! $news->konten !!}
                        </div>

                        @if($news->tags->count() > 0)
                            <div class="mt-8 pt-8 border-t border-slate-100 dark:border-navy-700">
                                <h3 class="text-sm font-semibold text-slate-900 dark:text-white mb-3">Tags:</h3>
                                <div class="flex flex-wrap gap-2">
                                    @foreach($news->tags as $tag)
                                        <a href="/berita/tag/{{ $tag->slug }}" wire:navigate.hover
                                            class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-slate-100 text-slate-700 dark:bg-navy-700 dark:text-slate-300 hover:bg-primary/10 hover:text-primary transition-colors">
                                            #{{ $tag->nama_tag }}
                                        </a>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    </div>
                </article>
            </div>

            <!-- Sidebar -->
            <div class="lg:col-span-1">
                <div class="sticky top-24 space-y-8">
                    <!-- Recent News -->
                    <div
                        class="bg-white dark:bg-navy-800 rounded-2xl shadow-sm border border-slate-100 dark:border-navy-700 p-6">
                        <h3
                            class="text-lg font-bold text-slate-900 dark:text-white mb-6 pb-4 border-b border-slate-100 dark:border-navy-700">
                            Berita Lainnya
                        </h3>
                        <div class="space-y-6">
                            @forelse($recentNews as $item)
                                <a href="/berita/{{ $item->slug }}" wire:navigate.hover class="flex gap-4 group">
                                    <div class="flex-shrink-0 w-20 h-20 rounded-lg overflow-hidden">
                                        <img class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300"
                                            src="{{ $item->gambar ? asset('storage/' . $item->gambar) : 'https://images.unsplash.com/photo-1496128858413-b36217c2ce36?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=crop&w=1679&q=80' }}"
                                            alt="{{ $item->judul }}">
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <h4
                                            class="text-sm font-semibold text-slate-900 dark:text-white group-hover:text-primary transition-colors line-clamp-2 mb-1">
                                            {{ $item->judul }}
                                        </h4>
                                        <p class="text-xs text-slate-500 dark:text-slate-400">
                                            {{ $item->created_at->translatedFormat('d M Y') }}
                                        </p>
                                    </div>
                                </a>
                            @empty
                                <p class="text-sm text-slate-500 dark:text-slate-400">Belum ada berita lainnya.</p>
                            @endforelse
                        </div>
                        <div class="mt-6 pt-6 border-t border-slate-100 dark:border-navy-700">
                            <a href="/berita" wire:navigate.hover
                                class="block w-full text-center px-4 py-2 border border-slate-300 dark:border-navy-600 rounded-lg text-sm font-medium text-slate-700 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-navy-700 transition-colors">
                                Lihat Semua Berita
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>