<?php

use function Livewire\Volt\{state, with, uses};
use App\Models\Announcement;
use Livewire\WithPagination;

uses(WithPagination::class);

with(fn() => [
    'announcements' => Announcement::with('penulis')
        ->where('status', 'dipublikasikan')
        ->orderBy('created_at', 'desc')
        ->paginate(10),
]);

?>

<section id="announcements" class="py-16 sm:py-20 bg-white dark:bg-navy-900 min-h-screen">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-base text-primary font-semibold tracking-wide uppercase">Pengumuman</h2>
            <p class="mt-2 text-3xl leading-8 font-extrabold tracking-tight text-slate-900 dark:text-white sm:text-4xl">
                Informasi Terbaru
            </p>
            <p class="mt-4 max-w-2xl text-xl text-slate-500 dark:text-slate-300 mx-auto">
                Dapatkan informasi terbaru seputar kegiatan dan pengumuman penting sekolah.
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

            <div class="mt-10 grid gap-8 lg:grid-cols-2 sm:grid-cols-1"
                wire:loading.class="opacity-50 pointer-events-none">
                @forelse($announcements as $announcement)
                    <div
                        class="flex flex-col rounded-lg shadow-lg overflow-hidden hover:shadow-xl transition-shadow duration-300 bg-white dark:bg-navy-800 border border-slate-100 dark:border-navy-700">
                        @if($announcement->thumbnail)
                            <div class="flex-shrink-0 h-64 w-full relative">
                                <img class="h-full w-full object-cover" src="{{ asset('storage/' . $announcement->thumbnail) }}"
                                    alt="{{ $announcement->judul }}">
                                <div class="absolute top-4 right-4">
                                    @php
                                        $priorityClass = match ($announcement->prioritas) {
                                            'Penting' => 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200',
                                            'Tinggi' => 'bg-orange-100 text-orange-800 dark:bg-orange-900 dark:text-orange-200',
                                            default => 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200',
                                        };
                                    @endphp
                                    <span
                                        class="inline-flex items-center px-3 py-0.5 rounded-full text-sm font-medium {{ $priorityClass }}">
                                        {{ $announcement->prioritas }}
                                    </span>
                                </div>
                            </div>
                        @endif

                        <div class="flex-1 p-6 flex flex-col justify-between">
                            <div class="flex-1">
                                <div class="flex items-center justify-between mb-2">
                                    <p class="text-sm font-medium text-primary">
                                        {{ $announcement->kategori }}
                                    </p>
                                    <time datetime="{{ $announcement->created_at }}"
                                        class="text-sm text-slate-500 dark:text-slate-400">
                                        {{ $announcement->created_at->format('d M Y') }}
                                    </time>
                                </div>

                                <h3 class="text-xl font-bold text-slate-900 dark:text-white mb-4">
                                    {{ $announcement->judul }}
                                </h3>

                                <div class="prose dark:prose-invert max-w-none text-slate-500 dark:text-slate-300 mb-6">
                                    {!! nl2br(e($announcement->isi)) !!}
                                </div>
                            </div>

                            <div
                                class="mt-6 flex items-center justify-between border-t border-slate-100 dark:border-navy-700 pt-4">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0">
                                        <div
                                            class="h-10 w-10 rounded-full bg-slate-200 dark:bg-navy-700 flex items-center justify-center text-slate-500 dark:text-slate-300">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                            </svg>
                                        </div>
                                    </div>
                                    <div class="ml-3">
                                        <p class="text-sm font-medium text-slate-900 dark:text-white">
                                            {{ $announcement->penulis->name ?? 'Admin' }}
                                        </p>
                                    </div>
                                </div>

                                @if($announcement->lampiran_file)
                                    <a href="{{ asset('storage/' . $announcement->lampiran_file) }}" target="_blank"
                                        class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-primary hover:bg-primary-focus focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary transition-colors">
                                        <svg class="-ml-1 mr-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                                        </svg>
                                        Download Lampiran
                                    </a>
                                @endif
                            </div>
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
                        <h3 class="text-lg font-medium text-slate-900 dark:text-white">Belum ada pengumuman</h3>
                        <p class="mt-2 text-slate-500 dark:text-slate-400">
                            Pengumuman terbaru belum tersedia saat ini.
                        </p>
                    </div>
                @endforelse
            </div>
        </div>

        <div class="mt-12">
            {{ $announcements->links(data: ['scrollTo' => '#announcements']) }}
        </div>
    </div>
</section>