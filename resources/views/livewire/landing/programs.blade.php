<?php

use function Livewire\Volt\{state, mount};
use App\Models\Program;

state(['programs' => [], 'limitDescription' => true]);

mount(function ($limitDescription = true) {
    $this->programs = Program::where('status', 'aktif')->get();
    $this->limitDescription = $limitDescription;
});

?>

<section id="program" class="py-16 sm:py-20 bg-white dark:bg-navy-900">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center">
            <h2 class="text-base text-primary font-semibold tracking-wide uppercase">Program Pendidikan</h2>
            <p class="mt-2 text-3xl leading-8 font-extrabold tracking-tight text-slate-900 dark:text-white sm:text-4xl">
                Pilihan Program Belajar
            </p>
            <p class="mt-4 max-w-2xl text-xl text-slate-500 dark:text-slate-300 lg:mx-auto">
                Kami menyediakan berbagai program pendidikan kesetaraan dan keterampilan sesuai kebutuhan Anda.
            </p>
        </div>

        <div class="mt-10">
            <div class="grid grid-cols-1 gap-8 sm:grid-cols-2 lg:grid-cols-3">
                @forelse($programs as $program)
                    <div class="pt-6 h-full flex flex-col">
                        <div class="bg-slate-50 dark:bg-navy-800 rounded-lg px-6 pb-8 flex-1 flex flex-col relative">
                            <div class="-mt-6 flex-1 flex flex-col">
                                <div>
                                    <span
                                        class="inline-flex items-center justify-center p-3 bg-primary rounded-md shadow-lg">
                                        <!-- Heroicon name: outline/academic-cap -->
                                        <svg class="h-6 w-6 text-white" xmlns="http://www.w3.org/2000/svg" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                            <path d="M12 14l9-5-9-5-9 5 9 5z" />
                                            <path
                                                d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14zm-4 6v-7.5l4-2.222" />
                                        </svg>
                                    </span>
                                </div>
                                <h3 class="mt-8 text-lg font-medium text-slate-900 dark:text-white tracking-tight">
                                    {{ $program->nama_program }}
                                </h3>
                                <p class="mt-5 text-base text-slate-500 dark:text-slate-300 line-clamp-3">
                                    {{ $program->deskripsi }}
                                </p>
                                <div class="flex-1"></div>
                                <div class="mt-4">
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-primary/10 text-primary">
                                        {{ $program->kategori }}
                                    </span>
                                    @if($program->durasi)
                                        <span class="ml-2 text-sm text-slate-500 dark:text-slate-400">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 inline-block mr-1"
                                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                            {{ $program->durasi }}
                                        </span>
                                    @endif
                                </div>
                                <div class="mt-6">
                                    <a href="/program/{{ $program->id }}" wire:navigate.hover
                                        class="inline-flex items-center justify-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-primary hover:bg-primary-focus focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary w-full">
                                        Lihat Detail
                                    </a>
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
                        <h3 class="text-lg font-medium text-slate-900 dark:text-white">Belum ada program</h3>
                        <p class="mt-2 text-slate-500 dark:text-slate-400">
                            Program pendidikan belum tersedia saat ini.
                        </p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</section>