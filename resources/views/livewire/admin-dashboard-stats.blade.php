<?php

use App\Models\Announcement;
use App\Models\Certificate;
use App\Models\ClassGroup;
use App\Models\Gallery;
use App\Models\News;
use App\Models\PkbmProfile;
use App\Models\Program;
use App\Models\Schedule;
use App\Models\Student;
use App\Models\Tutor;
use function Livewire\Volt\{computed, state};

$stats = computed(function () {
    return [
        'pkbm' => PkbmProfile::count(),
        'tutors' => Tutor::count(),
        'students' => Student::count(),
        'programs' => Program::count(),
        'rombels' => ClassGroup::count(),
        'schedules' => Schedule::count(),
        'certificates' => Certificate::count(),
        'announcements' => Announcement::count(),
        'news' => News::count(),
        'galleries' => Gallery::count(),
    ];
});

?>

<div class="grid grid-cols-12 gap-4 sm:gap-5 lg:gap-6">
    <!-- Stats -->
    <div class="col-span-12 grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4 lg:gap-6">
        <!-- PKBM Card -->
        <div class="card p-4 transition-all duration-200 hover:shadow-lg hover:shadow-primary/20 cursor-pointer">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-xs+ font-medium uppercase text-slate-500 dark:text-navy-200">Profil PKBM</p>
                    <div class="mt-2 flex items-baseline space-x-1">
                        <span class="text-2xl font-bold text-slate-700 dark:text-navy-100">{{ $this->stats['pkbm'] }}</span>
                    </div>
                </div>
                <div class="flex size-10 items-center justify-center rounded-lg bg-primary/10 text-primary dark:bg-accent/10 dark:text-accent-light">
                    <svg xmlns="http://www.w3.org/2000/svg" class="size-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                    </svg>
                </div>
            </div>
        </div>

        <!-- Tutors Card -->
        <div class="card p-4 transition-all duration-200 hover:shadow-lg hover:shadow-secondary/20 cursor-pointer">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-xs+ font-medium uppercase text-slate-500 dark:text-navy-200">Guru</p>
                    <div class="mt-2 flex items-baseline space-x-1">
                        <span class="text-2xl font-bold text-slate-700 dark:text-navy-100">{{ $this->stats['tutors'] }}</span>
                    </div>
                </div>
                <div class="flex size-10 items-center justify-center rounded-lg bg-secondary/10 text-secondary dark:bg-accent/10 dark:text-accent-light">
                    <svg xmlns="http://www.w3.org/2000/svg" class="size-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                    </svg>
                </div>
            </div>
        </div>

        <!-- Students Card -->
        <div class="card p-4 transition-all duration-200 hover:shadow-lg hover:shadow-info/20 cursor-pointer">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-xs+ font-medium uppercase text-slate-500 dark:text-navy-200">Warga Belajar</p>
                    <div class="mt-2 flex items-baseline space-x-1">
                        <span class="text-2xl font-bold text-slate-700 dark:text-navy-100">{{ $this->stats['students'] }}</span>
                    </div>
                </div>
                <div class="flex size-10 items-center justify-center rounded-lg bg-info/10 text-info dark:bg-accent/10 dark:text-accent-light">
                    <svg xmlns="http://www.w3.org/2000/svg" class="size-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                </div>
            </div>
        </div>

        <!-- Programs Card -->
        <div class="card p-4 transition-all duration-200 hover:shadow-lg hover:shadow-warning/20 cursor-pointer">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-xs+ font-medium uppercase text-slate-500 dark:text-navy-200">Program</p>
                    <div class="mt-2 flex items-baseline space-x-1">
                        <span class="text-2xl font-bold text-slate-700 dark:text-navy-100">{{ $this->stats['programs'] }}</span>
                    </div>
                </div>
                <div class="flex size-10 items-center justify-center rounded-lg bg-warning/10 text-warning dark:bg-accent/10 dark:text-accent-light">
                    <svg xmlns="http://www.w3.org/2000/svg" class="size-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                    </svg>
                </div>
            </div>
        </div>

        <!-- Rombel Card -->
        <div class="card p-4 transition-all duration-200 hover:shadow-lg hover:shadow-success/20 cursor-pointer">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-xs+ font-medium uppercase text-slate-500 dark:text-navy-200">Rombel</p>
                    <div class="mt-2 flex items-baseline space-x-1">
                        <span class="text-2xl font-bold text-slate-700 dark:text-navy-100">{{ $this->stats['rombels'] }}</span>
                    </div>
                </div>
                <div class="flex size-10 items-center justify-center rounded-lg bg-success/10 text-success dark:bg-accent/10 dark:text-accent-light">
                    <svg xmlns="http://www.w3.org/2000/svg" class="size-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                </div>
            </div>
        </div>

        <!-- Schedule Card -->
        <div class="card p-4 transition-all duration-200 hover:shadow-lg hover:shadow-error/20 cursor-pointer">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-xs+ font-medium uppercase text-slate-500 dark:text-navy-200">Jadwal Belajar</p>
                    <div class="mt-2 flex items-baseline space-x-1">
                        <span class="text-2xl font-bold text-slate-700 dark:text-navy-100">{{ $this->stats['schedules'] }}</span>
                    </div>
                </div>
                <div class="flex size-10 items-center justify-center rounded-lg bg-error/10 text-error dark:bg-accent/10 dark:text-accent-light">
                    <svg xmlns="http://www.w3.org/2000/svg" class="size-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                </div>
            </div>
        </div>

        <!-- Certificate Card -->
        <div class="card p-4 transition-all duration-200 hover:shadow-lg hover:shadow-secondary/20 cursor-pointer">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-xs+ font-medium uppercase text-slate-500 dark:text-navy-200">Sertifikat</p>
                    <div class="mt-2 flex items-baseline space-x-1">
                        <span class="text-2xl font-bold text-slate-700 dark:text-navy-100">{{ $this->stats['certificates'] }}</span>
                    </div>
                </div>
                <div class="flex size-10 items-center justify-center rounded-lg bg-secondary/10 text-secondary dark:bg-accent/10 dark:text-accent-light">
                    <svg xmlns="http://www.w3.org/2000/svg" class="size-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>
        </div>

        <!-- Announcement Card -->
        <div class="card p-4 transition-all duration-200 hover:shadow-lg hover:shadow-info/20 cursor-pointer">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-xs+ font-medium uppercase text-slate-500 dark:text-navy-200">Pengumuman</p>
                    <div class="mt-2 flex items-baseline space-x-1">
                        <span class="text-2xl font-bold text-slate-700 dark:text-navy-100">{{ $this->stats['announcements'] }}</span>
                    </div>
                </div>
                <div class="flex size-10 items-center justify-center rounded-lg bg-info/10 text-info dark:bg-accent/10 dark:text-accent-light">
                    <svg xmlns="http://www.w3.org/2000/svg" class="size-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z" />
                    </svg>
                </div>
            </div>
        </div>

        <!-- News Card -->
        <div class="card p-4 transition-all duration-200 hover:shadow-lg hover:shadow-warning/20 cursor-pointer">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-xs+ font-medium uppercase text-slate-500 dark:text-navy-200">Berita & Artikel</p>
                    <div class="mt-2 flex items-baseline space-x-1">
                        <span class="text-2xl font-bold text-slate-700 dark:text-navy-100">{{ $this->stats['news'] }}</span>
                    </div>
                </div>
                <div class="flex size-10 items-center justify-center rounded-lg bg-warning/10 text-warning dark:bg-accent/10 dark:text-accent-light">
                    <svg xmlns="http://www.w3.org/2000/svg" class="size-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z" />
                    </svg>
                </div>
            </div>
        </div>

        <!-- Gallery Card -->
        <div class="card p-4 transition-all duration-200 hover:shadow-lg hover:shadow-success/20 cursor-pointer">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-xs+ font-medium uppercase text-slate-500 dark:text-navy-200">Galeri</p>
                    <div class="mt-2 flex items-baseline space-x-1">
                        <span class="text-2xl font-bold text-slate-700 dark:text-navy-100">{{ $this->stats['galleries'] }}</span>
                    </div>
                </div>
                <div class="flex size-10 items-center justify-center rounded-lg bg-success/10 text-success dark:bg-accent/10 dark:text-accent-light">
                    <svg xmlns="http://www.w3.org/2000/svg" class="size-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                </div>
            </div>
        </div>
    </div>
</div>