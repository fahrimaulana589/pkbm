<?php

use function Livewire\Volt\{state, mount};
use App\Models\Schedule;
use App\Models\ClassGroup;

state(['schedules' => [], 'classes' => [], 'classId' => null, 'className' => '']);

mount(function ($classId = null) {
    // If getting classId via query string or route parameter
    // If used in a page with ?classId=, Livewire might not automatically bind it if not in signature
    // specific to Folio, route params are passed to mount.

    $this->classId = $classId ?? request()->query('classId');

    if ($this->classId) {
        $daysOrder = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'];

        $classGroup = ClassGroup::find($this->classId);
        $this->className = $classGroup ? $classGroup->nama_rombel : '';

        $this->schedules = Schedule::with(['classGroup.tutor', 'tutor'])
            ->where('rombel_id', $this->classId)
            ->orderBy('jam_mulai', 'asc')
            ->get()
            ->groupBy('hari')
            ->sortBy(function ($schedules, $key) use ($daysOrder) {
                return array_search($key, $daysOrder);
            })
            ->all();
    } else {
        // If no class selected, fetch all active classes
        $this->classes = ClassGroup::with(['program', 'tutor'])->get();
    }
});

?>

<section class="py-16 sm:py-20 bg-slate-50 dark:bg-navy-900 min-h-screen">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        @if(!$classId)
            {{-- Class Selection View --}}
            <div class="text-center mb-12">
                <h2 class="text-base text-primary font-semibold tracking-wide uppercase">Pilih Kelas</h2>
                <p class="mt-2 text-3xl leading-8 font-extrabold tracking-tight text-slate-900 dark:text-white sm:text-4xl">
                    Daftar Kelas Tersedia
                </p>
                <p class="mt-4 max-w-2xl text-xl text-slate-500 dark:text-slate-400 mx-auto">
                    Silakan pilih kelas untuk melihat jadwal kegiatan belajar mengajar.
                </p>
            </div>

            @if($classes->isNotEmpty())
                <div class="grid gap-5 lg:grid-cols-3 sm:grid-cols-2">
                    @foreach($classes as $class)
                        <a href="/jadwal/kelas/{{ $class->id }}" wire:navigate
                            class="group block bg-white dark:bg-navy-800 rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-all duration-300 transform hover:-translate-y-1">
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
                                    <div class="flex items-center mt-4 pt-4 border-t border-slate-100 dark:border-navy-700">
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
                <div class="text-center py-12">
                    <div
                        class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-slate-100 dark:bg-navy-700 mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-slate-400" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 0 011 1v5m-4 0h4" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-medium text-slate-900 dark:text-white">Belum ada data kelas</h3>
                </div>
            @endif

        @else
            {{-- Schedule View --}}
            <div class="text-center mb-12">
                <h2 class="text-base text-primary font-semibold tracking-wide uppercase">
                    Jadwal Kelas
                </h2>
                <p class="mt-2 text-3xl leading-8 font-extrabold tracking-tight text-slate-900 dark:text-white sm:text-4xl">
                    {{ $className }}
                </p>
                <p class="mt-4 max-w-2xl text-xl text-slate-500 dark:text-slate-400 mx-auto">
                    Berikut adalah jadwal kegiatan belajar untuk kelas {{ $className }}
                </p>
            </div>

            <div class="mt-10">
                @forelse($schedules as $hari => $dailySchedules)
                    <div class="mb-12">
                        <div class="flex items-center mb-6">
                            <div class="h-8 w-1 bg-primary rounded-full mr-3"></div>
                            <h3 class="text-2xl font-bold text-slate-900 dark:text-white">
                                {{ $hari }}
                            </h3>
                        </div>

                        <div class="grid gap-6 lg:grid-cols-3 sm:grid-cols-2">
                            @foreach($dailySchedules as $schedule)
                                <div
                                    class="bg-white dark:bg-navy-800 rounded-xl shadow-sm border border-slate-100 dark:border-navy-700 overflow-hidden hover:shadow-md transition-shadow duration-300">
                                    <div class="p-6">
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
                                        <h4 class="text-lg font-bold text-slate-900 dark:text-white mb-2">
                                            {{ $schedule->materi }}
                                        </h4>

                                        @if($schedule->teacher)
                                            <div class="flex items-center mt-4 pt-4 border-t border-slate-100 dark:border-navy-700">
                                                <div
                                                    class="flex-shrink-0 h-10 w-10 rounded-full bg-slate-200 dark:bg-navy-600 flex items-center justify-center text-sm font-bold text-slate-600 dark:text-slate-300">
                                                    {{ substr($schedule->teacher->nama ?? 'T', 0, 1) }}
                                                </div>
                                                <div class="ml-3">
                                                    <p class="text-sm font-medium text-slate-900 dark:text-white">
                                                        {{ $schedule->teacher->nama ?? 'Tutor' }}
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
                    </div>
                @empty
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
                        <p class="mt-2 text-slate-500 dark:text-slate-400 max-w-sm mx-auto">
                            Jadwal kegiatan belajar belum tersedia untuk kelas ini.
                        </p>
                    </div>
                @endforelse
            </div>

            <div class="mt-8 text-center">
                <a href="/jadwal" wire:navigate
                    class="inline-flex items-center justify-center px-6 py-3 border border-gray-300 dark:border-navy-600 shadow-sm text-base font-medium rounded-md text-slate-700 dark:text-slate-200 bg-white dark:bg-navy-700 hover:bg-gray-50 dark:hover:bg-navy-600 transition-colors duration-300">
                    <svg xmlns="http://www.w3.org/2000/svg" class="mr-2 -ml-1 h-5 w-5" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Kembali ke Daftar Kelas
                </a>
            </div>
        @endif
    </div>
</section>