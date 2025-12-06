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
                <div class="flex flex-col rounded-lg shadow-lg overflow-hidden">
                    <div class="flex-shrink-0">
                        <img class="h-48 w-full object-cover"
                            src="{{ $item->gambar ? asset('storage/' . $item->gambar) : 'https://images.unsplash.com/photo-1496128858413-b36217c2ce36?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=crop&w=1679&q=80' }}"
                            alt="{{ $item->judul }}">
                    </div>
                    <div class="flex-1 bg-white dark:bg-navy-700 p-6 flex flex-col justify-between">
                        <div class="flex-1">
                            <p class="text-sm font-medium text-primary">
                                <a href="#" class="hover:underline">
                                    {{ $item->category->nama_kategori ?? 'Umum' }}
                                </a>
                            </p>
                            <a href="#" class="block mt-2">
                                <p class="text-xl font-semibold text-slate-900 dark:text-white">
                                    {{ $item->judul }}
                                </p>
                                <p class="mt-3 text-base text-slate-500 dark:text-slate-300">
                                    {{ Str::limit(strip_tags($item->konten), 100) }}
                                </p>
                            </a>

                            @if($item->tags->count() > 0)
                                <div class="mt-4 flex flex-wrap gap-2">
                                    @foreach($item->tags as $tag)
                                        <span
                                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-primary/10 text-primary dark:bg-primary/20 dark:text-primary-focus">
                                            #{{ $tag->nama_tag }}
                                        </span>
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
    </div>
</section>