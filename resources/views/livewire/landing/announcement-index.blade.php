<?php

use function Livewire\Volt\{state, with, uses};
use App\Models\Announcement;
use Livewire\WithPagination;

uses(WithPagination::class);

with(fn() => [
    'announcements' => Announcement::where('status', 'dipublikasikan')
        ->orderBy('created_at', 'desc')
        ->paginate(9),
]);

?>

<section class="py-16 sm:py-20 bg-white dark:bg-navy-900 min-h-screen">
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

        <div class="mt-10 grid gap-8 lg:grid-cols-3 md:grid-cols-2 sm:grid-cols-1">
            @forelse($announcements as $announcement)
                <div
                    class="flex flex-col rounded-lg shadow-lg overflow-hidden hover:shadow-xl transition-shadow duration-300">
                    <div class="flex-1 bg-white dark:bg-navy-800 p-6 flex flex-col justify-between">
                        <div class="flex-1">
                            <p class="text-sm font-medium text-primary">
                                <span class="hover:underline">
                                    {{ $announcement->kategori }}
                                </span>
                            </p>
                            <a href="#" class="block mt-2">
                                <p class="text-xl font-semibold text-slate-900 dark:text-white">
                                    {{ $announcement->judul }}
                                </p>
                                <p class="mt-3 text-base text-slate-500 dark:text-slate-300">
                                    {{ Str::limit(strip_tags($announcement->isi), 150) }}
                                </p>
                            </a>
                        </div>
                        <div class="mt-6 flex items-center">
                            <div class="flex-shrink-0">
                                <span class="sr-only">{{ $announcement->penulis->name ?? 'Admin' }}</span>
                                <div
                                    class="h-10 w-10 rounded-full bg-slate-200 dark:bg-navy-700 flex items-center justify-center text-slate-500 dark:text-slate-300">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                    </svg>
                                </div>
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
                <div class="col-span-full text-center text-slate-500">
                    Belum ada pengumuman terbaru.
                </div>
            @endforelse
        </div>

        <div class="mt-12">
            {{ $announcements->links(data: ['scrollTo' => false]) }}
        </div>
    </div>
</section>