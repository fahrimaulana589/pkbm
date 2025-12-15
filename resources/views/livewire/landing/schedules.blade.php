<?php

use function Livewire\Volt\{state, mount};
use App\Models\Schedule;
use Carbon\Carbon;

state(['schedules' => [], 'currentDate' => '']);

mount(function () {
    Carbon::setLocale('id');
    $now = Carbon::now();
    $today = $now->translatedFormat('l');
    $this->currentDate = $now->translatedFormat('l, d F Y');

    $this->schedules = Schedule::with('classGroup.tutor')
        ->where('hari', $today)
        ->orderBy('jam_mulai', 'asc')
        ->get();
});

?>

<section id="jadwal" class="py-12 bg-slate-50 dark:bg-navy-800">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center">
            <h2 class="text-base text-primary font-semibold tracking-wide uppercase">Jadwal</h2>
            <p class="mt-2 text-3xl leading-8 font-extrabold tracking-tight text-slate-900 dark:text-white sm:text-4xl">
                Jadwal Hari Ini
            </p>
            <p class="mt-2 text-lg text-slate-600 dark:text-slate-300">
                {{ $currentDate }}
            </p>
        </div>

        <div class="mt-10">
            @if($schedules->isNotEmpty())
                <div class="grid gap-5 lg:grid-cols-3 sm:grid-cols-2">
                    @foreach($schedules as $schedule)
                        <div
                            class="bg-white dark:bg-navy-700 rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow duration-300">
                            <div class="p-5">
                                <div class="flex items-center justify-between mb-4">
                                    <span class="px-3 py-1 text-xs font-semibold rounded-full bg-primary/10 text-primary">
                                        {{ $schedule->classGroup->nama_rombel ?? 'Umum' }}
                                    </span>
                                    <div class="flex items-center text-sm text-slate-500 dark:text-slate-400">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        {{ \Carbon\Carbon::parse($schedule->jam_mulai)->format('H:i') }} -
                                        {{ \Carbon\Carbon::parse($schedule->jam_selesai)->format('H:i') }}
                                    </div>
                                </div>
                                <h4 class="text-lg font-semibold text-slate-900 dark:text-white mb-2">
                                    {{ $schedule->materi }}
                                </h4>
                                @if($schedule->classGroup && $schedule->classGroup->tutor)
                                    <div class="flex items-center mt-3 pt-3 border-t border-slate-100 dark:border-navy-600">
                                        <div
                                            class="flex-shrink-0 h-8 w-8 rounded-full bg-slate-200 dark:bg-navy-600 flex items-center justify-center text-xs font-bold text-slate-600 dark:text-slate-300">
                                            {{ substr($schedule->classGroup->tutor->nama ?? 'T', 0, 1) }}
                                        </div>
                                        <div class="ml-3">
                                            <p class="text-sm font-medium text-slate-900 dark:text-white">
                                                {{ $schedule->classGroup->tutor->nama ?? 'Tutor' }}
                                            </p>
                                            <p class="text-xs text-slate-500 dark:text-slate-400">
                                                Pengajar
                                            </p>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            @else

                <div class="col-span-full text-center py-12">
                    <div
                        class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-slate-100 dark:bg-navy-700 mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-slate-400" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-medium text-slate-900 dark:text-white">Belum ada jadwal</h3>
                    <p class="mt-2 text-slate-500 dark:text-slate-400">
                        Jadwal kegiatan belajar belum tersedia untuk hari ini.
                    </p>
                </div>
            @endif
        </div>
    </div>
</section>