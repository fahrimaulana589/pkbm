<?php

use function Livewire\Volt\{state, mount};
use App\Models\Gallery;
use App\Models\PkbmProfile;

state(['galleries' => [], 'profile' => null]);

mount(function () {
    $this->profile = PkbmProfile::first();
    $this->galleries = Gallery::with(['photos' => function($query) {
            $query->orderBy('urutan', 'asc')->take(4);
        }])
        ->where('status', 'aktif')
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
                <div class="bg-slate-50 dark:bg-navy-800 rounded-2xl overflow-hidden shadow-lg hover:shadow-xl transition-shadow duration-300 group">
                    <!-- Album Preview Grid -->
                    <div class="aspect-w-4 aspect-h-3 bg-slate-200 dark:bg-navy-700 relative overflow-hidden">
                        @if($gallery->photos->count() > 0)
                            <div class="grid grid-cols-2 grid-rows-2 gap-0.5 h-full w-full">
                                @foreach($gallery->photos as $index => $photo)
                                    @php
                                        // Layout logic:
                                        // If 1 photo: Full width/height
                                        // If 2 photos: Split vertically
                                        // If 3 photos: 1 big left, 2 small right
                                        // If 4+ photos: 4 grid
                                        $classes = 'w-full h-full object-cover';
                                        if ($gallery->photos->count() == 1) {
                                            $classes .= ' col-span-2 row-span-2';
                                        } elseif ($gallery->photos->count() == 2) {
                                            $classes .= ' col-span-1 row-span-2';
                                        } elseif ($gallery->photos->count() == 3 && $index == 0) {
                                            $classes .= ' col-span-1 row-span-2';
                                        }
                                    @endphp
                                    <img src="{{ asset('storage/'.$photo->file_path) }}" 
                                         alt="{{ $photo->caption }}" 
                                         class="{{ $classes }} transition-transform duration-500 group-hover:scale-105">
                                @endforeach
                            </div>
                        @else
                            <div class="flex items-center justify-center h-full w-full text-slate-400">
                                <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            </div>
                        @endif
                        
                        <!-- Overlay with Title -->
                        <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent flex flex-col justify-end p-6">
                            <h3 class="text-xl font-bold text-white mb-1">{{ $gallery->judul }}</h3>
                            <p class="text-sm text-slate-300">{{ $gallery->photos->count() }} Foto &bull; {{ $gallery->created_at->format('d M Y') }}</p>
                        </div>
                    </div>
                </div>
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