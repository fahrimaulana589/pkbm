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
                <div class="col-span-3 text-center text-slate-500">
                    Belum ada pengumuman terbaru.
                </div>
            @endforelse
        </div>
    </div>
</section>