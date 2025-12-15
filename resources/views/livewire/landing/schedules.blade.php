<?php

use function Livewire\Volt\{state, mount};
use App\Models\ClassGroup;

state(['classes' => []]);

mount(function () {
    $this->classes = ClassGroup::with(['program', 'tutor'])
        ->get();
});

?>

<section id="jadwal" class="py-12 bg-slate-50 dark:bg-navy-800">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center">
            <h2 class="text-base text-primary font-semibold tracking-wide uppercase">Jadwal Kelas</h2>
            <p class="mt-2 text-3xl leading-8 font-extrabold tracking-tight text-slate-900 dark:text-white sm:text-4xl">
                Jadwal Kegiatan Belajar
            </p>
            <p class="mt-2 text-lg text-slate-600 dark:text-slate-300">
                Pilih kelas untuk melihat jadwal pelajaran
            </p>
        </div>

        <div class="mt-10">
            @if($classes->isNotEmpty())
                <div class="grid gap-5 lg:grid-cols-3 sm:grid-cols-2">
                    @foreach($classes as $class)
                        <a href="/jadwal/kelas/{{ $class->id }}" wire:navigate
                            class="group block bg-white dark:bg-navy-700 rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-all duration-300 transform hover:-translate-y-1">
                            <div class="p-6">
                                <div class="flex items-center justify-between mb-4">
                                    <span class="px-3 py-1 text-xs font-semibold rounded-full bg-primary/10 text-primary">
                                        {{ $class->program->nama_program ?? 'Program' }}
                                    </span>
                                    <span class="text-sm text-slate-500 dark:text-slate-400">
                                        {{ $class->periode ?? '' }}
                                    </span>
                                </div>
                                <h4
                                    class="text-xl font-bold text-slate-900 dark:text-white mb-2 group-hover:text-primary transition-colors">
                                    {{ $class->nama_rombel }}
                                </h4>

                                @if($class->tutor)
                                    <div class="flex items-center mt-4 pt-4 border-t border-slate-100 dark:border-navy-600">
                                        <div
                                            class="flex-shrink-0 h-10 w-10 rounded-full bg-slate-200 dark:bg-navy-600 flex items-center justify-center text-sm font-bold text-slate-600 dark:text-slate-300">
                                            {{ substr($class->tutor->nama, 0, 1) }}
                                        </div>
                                        <div class="ml-3">
                                            <p class="text-sm font-medium text-slate-900 dark:text-white">
                                                {{ $class->tutor->nama }}
                                            </p>
                                            <p class="text-xs text-slate-500 dark:text-slate-400">
                                                Wali Kelas
                                            </p>
                                        </div>
                                    </div>
                                @endif

                                <div class="mt-4 flex justify-end">
                                    <span class="text-sm font-medium text-primary flex items-center">
                                        Lihat Jadwal
                                        <svg xmlns="http://www.w3.org/2000/svg"
                                            class="h-4 w-4 ml-1 group-hover:translate-x-1 transition-transform" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 5l7 7-7 7" />
                                        </svg>
                                    </span>
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>
            @else
                <div class="col-span-full text-center py-12">
                    <div
                        class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-slate-100 dark:bg-navy-700 mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-slate-400" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-medium text-slate-900 dark:text-white">Belum ada kelas</h3>
                    <p class="mt-2 text-slate-500 dark:text-slate-400">
                        Data kelas belum tersedia saat ini.
                    </p>
                </div>
            @endif
        </div>

        <div class="mt-10 text-center">
            <a href="/jadwal" wire:navigate
                class="inline-flex items-center justify-center px-6 py-3 border border-transparent text-base font-medium rounded-md text-primary bg-primary/10 hover:bg-primary/20 transition-colors duration-300">
                Lihat Semua Jadwal
                <svg xmlns="http://www.w3.org/2000/svg" class="ml-2 -mr-1 h-5 w-5" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M17 8l4 4m0 0l-4 4m4-4H3" />
                </svg>
            </a>
        </div>
    </div>
</section>