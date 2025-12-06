<?php

use function Livewire\Volt\{state, mount};
use App\Models\PkbmProfile;

state(['mobileMenuOpen' => false, 'profile' => null]);

mount(function () {
    $this->profile = PkbmProfile::first();
});

?>

<nav x-data="{ mobileMenuOpen: false, darkMode: localStorage.getItem('theme') === 'dark' }"
    x-init="$watch('darkMode', val => localStorage.setItem('theme', val ? 'dark' : 'light')); 
             if (localStorage.getItem('theme') === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
                 darkMode = true;
                 document.documentElement.classList.add('dark');
             } else {
                 darkMode = false;
                 document.documentElement.classList.remove('dark');
             }
             $watch('darkMode', val => val ? document.documentElement.classList.add('dark') : document.documentElement.classList.remove('dark'))"
    class="sticky top-0 z-50 w-full bg-white/80 dark:bg-navy-900/80 backdrop-blur-md border-b border-slate-200 dark:border-navy-700 shadow-sm transition-all duration-300">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16">
            <!-- Logo & Brand -->
            <div class="flex-shrink-0 flex items-center gap-3 cursor-pointer" onclick="window.location.href='/'">
                @if($profile && $profile->logo)
                    <img src="{{ asset('storage/' . $profile->logo) }}" alt="Logo {{ $profile->nama_pkbm }}"
                        class="w-10 h-10 object-contain">
                @else
                    <div
                        class="w-10 h-10 bg-primary/10 rounded-xl flex items-center justify-center text-primary transition-transform hover:scale-105">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M4.26 10.147a60.436 60.436 0 00-.491 6.347A48.627 48.627 0 0112 20.904a48.627 48.627 0 018.232-4.41 60.46 60.46 0 00-.491-6.347m-15.482 0a50.57 50.57 0 00-2.658-.813A59.905 59.905 0 0112 3.493a59.902 59.902 0 0110.499 5.516 50.552 50.552 0 00-2.658.813m-15.482 0A50.697 50.697 0 0112 13.489a50.702 50.702 0 017.74-3.342M6.75 15a.75.75 0 100-1.5.75.75 0 000 1.5zm0 0v-3.675A55.378 55.378 0 0112 8.443m-7.007 11.55A5.981 5.981 0 006.75 15.75v-1.5" />
                        </svg>
                    </div>
                @endif
                <span class="font-bold text-xl text-slate-800 dark:text-white tracking-tight">
                    {{ $profile->nama_pkbm ?? 'SekolahKita' }}
                </span>
            </div>

            <!-- Desktop Menu -->
            <div class="hidden md:flex items-center space-x-8">
                <a href="#profil"
                    class="text-sm font-medium text-slate-600 dark:text-slate-300 hover:text-primary dark:hover:text-primary transition-colors duration-200">Profil</a>
                <a href="#program"
                    class="text-sm font-medium text-slate-600 dark:text-slate-300 hover:text-primary dark:hover:text-primary transition-colors duration-200">Program</a>
                <a href="#tutor"
                    class="text-sm font-medium text-slate-600 dark:text-slate-300 hover:text-primary dark:hover:text-primary transition-colors duration-200">Tutor</a>
                <a href="/jadwal" wire:navigate
                    class="text-sm font-medium text-slate-600 dark:text-slate-300 hover:text-primary dark:hover:text-primary transition-colors duration-200">Jadwal</a>
                <a href="#pengumuman"
                    class="text-sm font-medium text-slate-600 dark:text-slate-300 hover:text-primary dark:hover:text-primary transition-colors duration-200">Pengumuman</a>
                <a href="#berita"
                    class="text-sm font-medium text-slate-600 dark:text-slate-300 hover:text-primary dark:hover:text-primary transition-colors duration-200">Berita</a>
                <a href="#galeri"
                    class="text-sm font-medium text-slate-600 dark:text-slate-300 hover:text-primary dark:hover:text-primary transition-colors duration-200">Galeri</a>
            </div>

            <!-- Right Side (Dark Mode & CTA) -->
            <div class="hidden md:flex items-center gap-4">
                <!-- Dark Mode Toggle -->
                <button @click="darkMode = !darkMode" type="button"
                    class="p-2 text-slate-500 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-navy-700 rounded-lg transition-colors focus:outline-none">
                    <svg x-show="!darkMode" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
                    </svg>
                    <svg x-show="darkMode" x-cloak class="w-5 h-5" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                </button>

                <a href="/login"
                    class="inline-flex items-center justify-center px-5 py-2.5 text-sm font-semibold text-white transition-all duration-200 bg-primary rounded-lg hover:bg-primary-focus focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary shadow-lg shadow-primary/30 hover:shadow-primary/40">
                    Masuk
                </a>
            </div>

            <!-- Mobile Menu Button -->
            <div class="flex items-center md:hidden gap-4">
                <!-- Dark Mode Toggle Mobile -->
                <button @click="darkMode = !darkMode" type="button"
                    class="p-2 text-slate-500 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-navy-700 rounded-lg transition-colors focus:outline-none">
                    <svg x-show="!darkMode" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
                    </svg>
                    <svg x-show="darkMode" x-cloak class="w-5 h-5" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                </button>

                <button @click="mobileMenuOpen = !mobileMenuOpen" type="button"
                    class="inline-flex items-center justify-center p-2 rounded-md text-slate-500 dark:text-slate-400 hover:text-slate-700 dark:hover:text-white hover:bg-slate-100 dark:hover:bg-navy-700 focus:outline-none transition-colors"
                    aria-controls="mobile-menu" aria-expanded="false">
                    <span class="sr-only">Open main menu</span>
                    <!-- Icon when menu is closed -->
                    <svg x-show="!mobileMenuOpen" class="block h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                    </svg>
                    <!-- Icon when menu is open -->
                    <svg x-show="mobileMenuOpen" x-cloak class="block h-6 w-6" xmlns="http://www.w3.org/2000/svg"
                        fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile Menu -->
    <div x-show="mobileMenuOpen" x-cloak x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0 -translate-y-2" x-transition:enter-end="opacity-100 translate-y-0"
        x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 translate-y-0"
        x-transition:leave-end="opacity-0 -translate-y-2"
        class="md:hidden border-t border-slate-100 dark:border-navy-700 bg-white dark:bg-navy-800" id="mobile-menu">
        <div class="px-4 pt-2 pb-6 space-y-1">
            <a href="#profil"
                class="block px-3 py-3 rounded-md text-base font-medium text-slate-700 dark:text-slate-300 hover:text-primary dark:hover:text-primary hover:bg-slate-50 dark:hover:bg-navy-700 transition-colors">Profil</a>
            <a href="#program"
                class="block px-3 py-3 rounded-md text-base font-medium text-slate-700 dark:text-slate-300 hover:text-primary dark:hover:text-primary hover:bg-slate-50 dark:hover:bg-navy-700 transition-colors">Program</a>
            <a href="#tutor"
                class="block px-3 py-3 rounded-md text-base font-medium text-slate-700 dark:text-slate-300 hover:text-primary dark:hover:text-primary hover:bg-slate-50 dark:hover:bg-navy-700 transition-colors">Tutor</a>
            <a href="/jadwal" wire:navigate
                class="block px-3 py-3 rounded-md text-base font-medium text-slate-700 dark:text-slate-300 hover:text-primary dark:hover:text-primary hover:bg-slate-50 dark:hover:bg-navy-700 transition-colors">Jadwal</a>
            <a href="#pengumuman"
                class="block px-3 py-3 rounded-md text-base font-medium text-slate-700 dark:text-slate-300 hover:text-primary dark:hover:text-primary hover:bg-slate-50 dark:hover:bg-navy-700 transition-colors">Pengumuman</a>
            <a href="#berita"
                class="block px-3 py-3 rounded-md text-base font-medium text-slate-700 dark:text-slate-300 hover:text-primary dark:hover:text-primary hover:bg-slate-50 dark:hover:bg-navy-700 transition-colors">Berita</a>
            <a href="#galeri"
                class="block px-3 py-3 rounded-md text-base font-medium text-slate-700 dark:text-slate-300 hover:text-primary dark:hover:text-primary hover:bg-slate-50 dark:hover:bg-navy-700 transition-colors">Galeri</a>
            <div class="pt-4 mt-4 border-t border-slate-100 dark:border-navy-700">
                <a href="/login"
                    class="block w-full text-center px-5 py-3 text-base font-semibold text-white bg-primary rounded-lg hover:bg-primary-focus shadow-md shadow-primary/20">
                    Masuk
                </a>
            </div>
        </div>
    </div>
</nav>