<?php

use function Livewire\Volt\{state, mount};
use App\Models\Announcement;

state(['announcements' => []]);

mount(function () {
    $this->announcements = Announcement::with('penulis')
        ->where('status', 'dipublikasikan')
        ->orderBy('created_at', 'desc')
        ->take(3)
        ->get();
});

?>

<section id="pengumuman" class="py-12 bg-white dark:bg-navy-900">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center">
            <h2 class="text-base text-primary font-semibold tracking-wide uppercase">Pengumuman</h2>
            <p class="mt-2 text-3xl leading-8 font-extrabold tracking-tight text-slate-900 dark:text-white sm:text-4xl">
                Informasi Terbaru
            </p>
        </div>

        <div class="mt-10 max-w-lg mx-auto grid gap-5 lg:grid-cols-3 lg:max-w-none">
            @forelse($announcements as $announcement)
                <div class="flex flex-col rounded-lg shadow-lg overflow-hidden">
                    <div class="flex-1 bg-white dark:bg-navy-800 p-6 flex flex-col justify-between">
                        <div class="flex-1">
                            <p class="text-sm font-medium text-primary">
                                <a href="#" class="hover:underline">
                                    {{ $announcement->kategori }}
                                </a>
                            </p>
                            <a href="#" class="block mt-2">
                                <p class="text-xl font-semibold text-slate-900 dark:text-white">
                                    {{ $announcement->judul }}
                                </p>
                                <p class="mt-3 text-base text-slate-500 dark:text-slate-300">
                                    {{ Str::limit(strip_tags($announcement->isi), 100) }}
                                </p>
                            </a>
                        </div>
                        <div class="mt-6 flex items-center">
                            <div class="flex-shrink-0">
                                <span class="sr-only">{{ $announcement->penulis->name ?? 'Admin' }}</span>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm font-medium text-slate-900 dark:text-white">
                                    {{ $announcement->penulis->name ?? 'Admin' }}
                                </p>
                                <div class="flex space-x-1 text-sm text-slate-500 dark:text-slate-400">
                                    <time datetime="{{ $announcement->created_at }}">
                                        {{ $announcement->created_at->format('d M Y') }}
                                    </time>
                                </div>
                            </div>
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
</section>