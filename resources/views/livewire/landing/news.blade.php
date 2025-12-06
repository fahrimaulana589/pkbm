<?php

use function Livewire\Volt\{state, mount};
use App\Models\News;

state(['news' => []]);

mount(function () {
    $this->news = News::with(['category', 'tags'])
        ->where('status', 'published')
        ->orderBy('created_at', 'desc')
        ->take(3)
        ->get();
});

?>

<section id="berita" class="py-12 bg-slate-50 dark:bg-navy-800">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center">
            <h2 class="text-base text-primary font-semibold tracking-wide uppercase">Berita</h2>
            <p class="mt-2 text-3xl leading-8 font-extrabold tracking-tight text-slate-900 dark:text-white sm:text-4xl">
                Kabar Sekolah
            </p>
        </div>

        <div class="mt-10 max-w-lg mx-auto grid gap-5 lg:grid-cols-3 lg:max-w-none">
            @forelse($news as $item)
                <div class="flex flex-col rounded-lg shadow-lg overflow-hidden group">
                    <div class="flex-shrink-0">
                        <a href="/berita/{{ $item->slug }}" wire:navigate class="block overflow-hidden">
                            <img class="h-48 w-full object-cover group-hover:scale-110 transition-transform duration-300"
                                src="{{ $item->gambar ? asset('storage/' . $item->gambar) : 'https://images.unsplash.com/photo-1496128858413-b36217c2ce36?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=crop&w=1679&q=80' }}"
                                alt="{{ $item->judul }}">
                        </a>
                    </div>
                    <div class="flex-1 bg-white dark:bg-navy-700 p-6 flex flex-col justify-between">
                        <div class="flex-1">
                            <p class="text-sm font-medium text-primary">
                                <a href="/berita/kategori/{{ $item->category->slug ?? '#' }}" wire:navigate
                                    class="hover:underline">
                                    {{ $item->category->nama_kategori ?? 'Umum' }}
                                </a>
                            </p>
                            <a href="/berita/{{ $item->slug }}" wire:navigate class="block mt-2">
                                <p
                                    class="text-xl font-semibold text-slate-900 dark:text-white group-hover:text-primary transition-colors">
                                    {{ $item->judul }}
                                </p>
                                <p class="mt-3 text-base text-slate-500 dark:text-slate-300">
                                    {{ Str::limit(strip_tags($item->konten), 100) }}
                                </p>
                            </a>

                            @if($item->tags->count() > 0)
                                <div class="mt-4 flex flex-wrap gap-2">
                                    @foreach($item->tags as $tag)
                                        <a href="/berita/tag/{{ $tag->slug }}" wire:navigate
                                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-primary/10 text-primary dark:bg-primary/20 dark:text-primary-focus hover:bg-primary/20 transition-colors">
                                            #{{ $tag->nama_tag }}
                                        </a>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-3 text-center text-slate-500">
                    Belum ada berita terbaru.
                </div>
            @endforelse
        </div>

        <div class="mt-12 text-center">
            <a href="/berita" wire:navigate
                class="inline-flex items-center justify-center px-6 py-3 border border-transparent text-base font-medium rounded-md text-white bg-primary hover:bg-primary-focus transition-colors duration-200 shadow-lg shadow-primary/30 hover:shadow-primary/40">
                Lihat Berita Selengkapnya
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-2" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M17 8l4 4m0 0l-4 4m4-4H3" />
                </svg>
            </a>
        </div>
    </div>
</section>