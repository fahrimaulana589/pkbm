<?php

use function Livewire\Volt\{state, mount};
use App\Models\Gallery;

state(['gallery' => null]);

mount(function ($id) {
    $this->gallery = Gallery::with([
        'photos' => function ($query) {
            $query->orderBy('urutan', 'asc');
        }
    ])->findOrFail($id);
});

?>

<section class="py-16 sm:py-20 bg-white dark:bg-navy-900 min-h-screen">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">


        {{-- Header --}}
        <div class="text-center mb-12">
            <h1 class="text-3xl font-extrabold tracking-tight text-slate-900 dark:text-white sm:text-4xl mb-4">
                {{ $gallery->judul }}
            </h1>
            <div class="flex items-center justify-center space-x-4 text-sm text-slate-500 dark:text-slate-400">
                <span class="flex items-center">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                    {{ $gallery->tanggal->format('d M Y') }}
                </span>
                <span class="flex items-center">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                    </svg>
                    {{ ucfirst($gallery->kategori) }}
                </span>
            </div>
            <div class="mt-6 max-w-3xl mx-auto prose dark:prose-invert">
                <p>{{ $gallery->deskripsi }}</p>
            </div>
        </div>

        {{-- Photos Grid --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            @forelse($gallery->photos as $photo)
                <div
                    class="group relative aspect-square bg-slate-100 dark:bg-navy-800 rounded-xl overflow-hidden shadow-md hover:shadow-xl transition-all duration-300">
                    <img src="{{ asset('storage/' . $photo->file_path) }}" alt="{{ $photo->caption ?? $gallery->judul }}"
                        class="w-full h-full object-cover transform group-hover:scale-110 transition-transform duration-500">

                    {{-- Overlay --}}
                    <div
                        class="absolute inset-0 bg-black/0 group-hover:bg-black/40 transition-colors duration-300 flex items-center justify-center opacity-0 group-hover:opacity-100">
                        <a href="{{ asset('storage/' . $photo->file_path) }}" target="_blank"
                            class="p-2 bg-white/20 backdrop-blur-sm rounded-full text-white hover:bg-white/40 transition-colors">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7" />
                            </svg>
                        </a>
                    </div>

                    @if($photo->caption)
                        <div
                            class="absolute bottom-0 left-0 right-0 p-4 bg-gradient-to-t from-black/80 to-transparent translate-y-full group-hover:translate-y-0 transition-transform duration-300">
                            <p class="text-white text-sm font-medium truncate">{{ $photo->caption }}</p>
                        </div>
                    @endif
                </div>
            @empty
                <div class="col-span-full text-center py-12">
                    <div
                        class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-slate-100 dark:bg-navy-800 mb-4">
                        <svg class="w-8 h-8 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <p class="text-slate-500 dark:text-slate-400">Belum ada foto dalam galeri ini.</p>
                </div>
            @endforelse
        </div>
    </div>
</section>