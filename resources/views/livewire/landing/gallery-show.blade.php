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
        <div x-data="{
                lightboxOpen: false,
                activeImage: 0,
                images: {{ \Illuminate\Support\Js::from($gallery->photos->map(fn($photo) => [
    'src' => asset('storage/' . $photo->file_path),
    'caption' => $photo->caption ?? ''
])) }},
                openLightbox(index) {
                    this.activeImage = index;
                    this.lightboxOpen = true;
                    document.body.style.overflow = 'hidden';
                },
                closeLightbox() {
                    this.lightboxOpen = false;
                    document.body.style.overflow = '';
                },
                nextImage() {
                    this.activeImage = (this.activeImage + 1) % this.images.length;
                },
                prevImage() {
                    this.activeImage = (this.activeImage - 1 + this.images.length) % this.images.length;
                },
                touchStartX: 0,
                touchEndX: 0,
                handleSwipe() {
                    if (this.touchEndX < this.touchStartX - 50) this.nextImage();
                    if (this.touchEndX > this.touchStartX + 50) this.prevImage();
                }
            }" @keydown.escape.window="closeLightbox()" @keydown.arrow-right.window="nextImage()"
            @keydown.arrow-left.window="prevImage()">

            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                @forelse($gallery->photos as $index => $photo)
                    <div
                        class="group relative aspect-square bg-slate-100 dark:bg-navy-800 rounded-xl overflow-hidden shadow-md hover:shadow-xl transition-all duration-300">
                        <img src="{{ asset('storage/' . $photo->file_path) }}"
                            alt="{{ $photo->caption ?? $gallery->judul }}"
                            class="w-full h-full object-cover transform group-hover:scale-110 transition-transform duration-500">

                        {{-- Overlay --}}
                        <div
                            class="absolute inset-0 bg-black/0 group-hover:bg-black/40 transition-colors duration-300 flex items-center justify-center opacity-0 group-hover:opacity-100">
                            <button @click="openLightbox({{ $index }})"
                                class="p-2 bg-white/20 backdrop-blur-sm rounded-full text-white hover:bg-white/40 transition-colors cursor-pointer"
                                title="Perbesar Foto">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7" />
                                </svg>
                            </button>
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

            {{-- Lightbox Modal --}}
            <div x-show="lightboxOpen" x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100"
                x-transition:leave-end="opacity-0"
                class="fixed inset-0 z-[100] flex items-center justify-center bg-black/95 backdrop-blur-sm"
                @touchstart="touchStartX = $event.changedTouches[0].screenX"
                @touchend="touchEndX = $event.changedTouches[0].screenX; handleSwipe()" style="display: none;">

                {{-- Main Image Container (Clicking background closes lightbox) --}}
                <div class="relative w-full h-full flex items-center justify-center p-4" @click="closeLightbox()">

                    {{-- Close Button --}}
                    <button @click.stop="closeLightbox()"
                        class="absolute top-4 right-4 text-white/70 hover:text-white z-50 p-2">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>

                    {{-- Prev Button --}}
                    <button @click.stop="prevImage()" class="absolute left-4 text-white/70 hover:text-white z-50 p-2">
                        <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                        </svg>
                    </button>

                    {{-- Next Button --}}
                    <button @click.stop="nextImage()" class="absolute right-4 text-white/70 hover:text-white z-50 p-2">
                        <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </button>

                    {{-- Image (Clicking image does NOT close) --}}
                    <img :src="images[activeImage].src" @click.stop
                        class="max-w-full max-h-full object-contain shadow-2xl rounded-sm" alt="Lightbox Image">

                    {{-- Caption --}}
                    <div x-show="images[activeImage].caption"
                        class="absolute bottom-8 left-0 right-0 text-center px-4 pointer-events-none">
                        <p x-text="images[activeImage].caption"
                            class="text-white/90 text-lg font-medium drop-shadow-md bg-black/50 inline-block px-4 py-2 rounded-full backdrop-blur-sm">
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>