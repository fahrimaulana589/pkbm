<?php

use function Livewire\Volt\{state, mount};
use App\Models\Gallery;
use App\Models\PkbmProfile;

state(['galleries' => []]);

mount(function () {
    // Profile is shared via View::share in AppServiceProvider
    $this->galleries = Gallery::with(['photos' => function($query) {
            $query->orderBy('urutan', 'asc')->take(4);
        }])
        ->where('status', 'aktif')
        ->take(3)
        ->orderBy('created_at', 'desc')
        ->get();
});

?>

<section id="galeri" class="py-12 bg-white dark:bg-navy-900">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-base text-primary font-semibold tracking-wide uppercase">Galeri</h2>
            <p class="mt-2 text-3xl leading-8 font-extrabold tracking-tight text-slate-900 dark:text-white sm:text-4xl">
                Album Kegiatan
            </p>
            <p class="mt-4 max-w-2xl text-xl text-slate-500 dark:text-slate-300 lg:mx-auto">
                Dokumentasi kegiatan dan acara di {{ $profile->nama_pkbm ?? 'PKBM SekolahKita' }}.
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @forelse($galleries as $gallery)
                <a href="/galeri/{{ $gallery->id }}"
                    class="group block bg-white dark:bg-navy-800 rounded-2xl shadow-sm hover:shadow-xl transition-all duration-300 overflow-hidden border border-slate-100 dark:border-navy-700">
                    {{-- Grid Foto Preview (2x2) --}}
                    <div class="aspect-[4/3] grid grid-cols-2 gap-0.5 bg-slate-100 dark:bg-navy-900">
                        @php
                            $photos = $gallery->photos->take(4);
                            $photoCount = $photos->count();
                        @endphp

                        @foreach($photos as $index => $photo)
                            <div
                                class="relative overflow-hidden {{ $photoCount === 1 ? 'col-span-2 row-span-2' : '' }} {{ $photoCount === 2 ? 'col-span-1 row-span-2' : '' }} {{ $photoCount === 3 && $index === 0 ? 'col-span-2' : '' }}">
                                <img src="{{ asset('storage/' . $photo->file_path) }}"
                                    alt="{{ $photo->caption ?? $gallery->judul }}"
                                    class="w-full h-full object-cover transform group-hover:scale-110 transition-transform duration-700">
                                @if($index === 3 && $gallery->photos->count() > 4)
                                    <div class="absolute inset-0 bg-black/50 flex items-center justify-center">
                                        <span class="text-white font-bold text-lg">+{{ $gallery->photos->count() - 4 }}</span>
                                    </div>
                                @endif
                            </div>
                        @endforeach

                        @if($photoCount === 0)
                            <div class="col-span-2 row-span-2 flex items-center justify-center text-slate-400">
                                <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                            </div>
                        @endif
                    </div>

                    <div class="p-5">
                        <div class="flex items-center justify-between mb-3">
                            <span
                                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-primary/10 text-primary">
                                {{ ucfirst($gallery->kategori) }}
                            </span>
                            <span class="text-xs text-slate-500 dark:text-slate-400 flex items-center">
                                <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                {{ $gallery->created_at->format('d M Y') }}
                            </span>
                        </div>

                        <h3
                            class="text-lg font-bold text-slate-900 dark:text-white mb-2 line-clamp-1 group-hover:text-primary transition-colors">
                            {{ $gallery->judul }}
                        </h3>

                        <p class="text-sm text-slate-500 dark:text-slate-400 line-clamp-2 mb-4">
                            {{ $gallery->deskripsi }}
                        </p>

                        <div
                            class="flex items-center text-sm font-medium text-primary group-hover:translate-x-1 transition-transform">
                            Lihat Galeri
                            <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17 8l4 4m0 0l-4 4m4-4H3" />
                            </svg>
                        </div>
                    </div>
                </a>
            @empty
                <div class="col-span-full text-center py-12">
                    <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-slate-100 dark:bg-navy-700 mb-4">
                        <svg class="w-8 h-8 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    </div>
                    <p class="text-slate-500 dark:text-slate-400 text-lg">Belum ada album galeri.</p>
                </div>
            @endforelse
        </div>
    </div>
</section>