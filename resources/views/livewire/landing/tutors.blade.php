<?php

use function Livewire\Volt\{state, mount};
use App\Models\Tutor;

state(['tutors' => []]);

mount(function () {
    $this->tutors = Tutor::where('status', 'aktif')->take(4)->get();
});

?>

<section id="tutor" class="py-12 bg-slate-50 dark:bg-navy-800">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center">
            <h2 class="text-base text-primary font-semibold tracking-wide uppercase">Tutor</h2>
            <p class="mt-2 text-3xl leading-8 font-extrabold tracking-tight text-slate-900 dark:text-white sm:text-4xl">
                Tenaga Pengajar Profesional
            </p>
            <p class="mt-4 max-w-2xl text-xl text-slate-500 dark:text-slate-300 lg:mx-auto">
                Dibimbing oleh tutor yang berpengalaman dan berdedikasi tinggi dalam dunia pendidikan.
            </p>
        </div>

        <div class="mt-10">
            <ul role="list" class="grid grid-cols-1 gap-6 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4">
                @forelse($tutors as $tutor)
                    <li
                        class="col-span-1 flex flex-col text-center bg-white dark:bg-navy-700 rounded-lg shadow divide-y divide-slate-200 dark:divide-navy-600">
                        <div class="flex-1 flex flex-col p-8">
                            <img class="w-32 h-32 flex-shrink-0 mx-auto rounded-full object-cover"
                                src="https://ui-avatars.com/api/?name={{ urlencode($tutor->nama) }}&background=random"
                                alt="{{ $tutor->nama }}">
                            <h3 class="mt-6 text-slate-900 dark:text-white text-sm font-medium">{{ $tutor->nama }}</h3>
                            <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">{{ $tutor->pendidikan_terakhir }}</p>
                            <dl class="mt-1 flex-grow flex flex-col justify-between">
                                <dt class="sr-only">Title</dt>
                                <dd class="text-slate-500 dark:text-slate-300 text-sm">{{ $tutor->keahlian }}</dd>
                            </dl>
                        </div>
                    </li>
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
                        <h3 class="text-lg font-medium text-slate-900 dark:text-white">Belum ada data tutor</h3>
                        <p class="mt-2 text-slate-500 dark:text-slate-400">
                            Data tutor belum tersedia saat ini.
                        </p>
                    </div>
                @endforelse
            </ul>
        </div>
        <div class="mt-10 text-center">
            <a href="/tutor" wire:navigate
                class="inline-flex items-center justify-center px-6 py-3 border border-transparent text-base font-medium rounded-md text-primary bg-primary/10 hover:bg-primary/20 transition-colors duration-300">
                Lihat Semua Tutor
                <svg xmlns="http://www.w3.org/2000/svg" class="ml-2 -mr-1 h-5 w-5" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M17 8l4 4m0 0l-4 4m4-4H3" />
                </svg>
            </a>
        </div>
    </div>
</section>