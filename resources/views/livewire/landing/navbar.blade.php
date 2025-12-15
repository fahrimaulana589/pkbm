<?php

use function Livewire\Volt\{state, mount};
use App\Models\PkbmProfile;

state(['mobileMenuOpen' => false]);

mount(function () {
    // Profile is shared via View::share in AppServiceProvider
});

?>

<nav x-data="{ mobileMenuOpen: false }"
    class="sticky top-0 z-50 w-full bg-white/80 dark:bg-navy-900/80 backdrop-blur-md border-b border-slate-200 dark:border-navy-700 shadow-sm transition-all duration-300">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16">
            <!-- Logo & Brand -->
            <div class="flex-shrink-0 flex items-center gap-3">
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
                <a href="/" wire:navigate.hover
                    class="font-bold text-xl text-slate-800 dark:text-white tracking-tight hover:text-primary">
                    {{ $profile->nama_pkbm ?? 'SekolahKita' }}
                </a>
            </div>



            <!-- Desktop Menu (Inline lg) -->
            <div class="hidden lg:flex items-center space-x-8">
                @php
                    $navClass = 'text-sm font-medium transition-colors duration-200';
                    $activeClass = 'text-primary dark:text-primary font-semibold';
                    $inactiveClass = 'text-slate-600 dark:text-slate-300 hover:text-primary dark:hover:text-primary';
                @endphp

                <a href="/" wire:navigate.hover
                    class="{{ $navClass }} {{ request()->is('/') ? $activeClass : $inactiveClass }}">Beranda</a>
                <a href="{{ route('ppdb.pkbm') }}" wire:navigate.hover
                    class="{{ $navClass }} {{ request()->routeIs('ppdb.*') ? $activeClass : $inactiveClass }}">PPDB</a>
                <a href="/profil" wire:navigate.hover
                    class="{{ $navClass }} {{ request()->is('profil') ? $activeClass : $inactiveClass }}">Profil</a>
                <a href="/program" wire:navigate.hover
                    class="{{ $navClass }} {{ request()->is('program') ? $activeClass : $inactiveClass }}">Program</a>
                <a href="/kegiatan" wire:navigate.hover
                    class="{{ $navClass }} {{ request()->is('kegiatan') ? $activeClass : $inactiveClass }}">Kegiatan</a>
                <a href="/pengumuman" wire:navigate.hover
                    class="{{ $navClass }} {{ request()->is('pengumuman*') ? $activeClass : $inactiveClass }}">Pengumuman</a>
                <a href="/berita" wire:navigate.hover
                    class="{{ $navClass }} {{ request()->is('berita*') ? $activeClass : $inactiveClass }}">Berita</a>
                <a href="/kontak" wire:navigate.hover
                    class="{{ $navClass }} {{ request()->is('kontak*') ? $activeClass : $inactiveClass }}">Kontak</a>
                <a href="/ppdb/pendaftar" wire:navigate.hover
                    class="{{ $navClass }} {{ request()->is('ppdb/pendaftar*') ? $activeClass : $inactiveClass }}">Daftar</a>
                <a href="/galeri" wire:navigate.hover
                    class="{{ $navClass }} {{ request()->is('galeri*') ? $activeClass : $inactiveClass }}">Galeri</a>
            </div>

            <!-- Right Side (Dark Mode & CTA) -->
            <div class="hidden md:flex items-center gap-4">
                <!-- Dark Mode Toggle -->
                <button
                    @click="$store.global.isDarkModeEnabled = !$store.global.isDarkModeEnabled;$store.darkMode.toggle()"
                    class="btn size-8 rounded-full p-0 hover:bg-slate-300/20 focus:bg-slate-300/20 active:bg-slate-300/25 dark:hover:bg-navy-300/20 dark:focus:bg-navy-300/20 dark:active:bg-navy-300/25">
                    <svg x-show="$store.global.isDarkModeEnabled"
                        x-transition:enter="transition-transform duration-200 ease-out absolute origin-top"
                        x-transition:enter-start="scale-75" x-transition:enter-end="scale-100 static"
                        class="size-6 text-amber-400" fill="currentColor" viewBox="0 0 24 24">
                        <path
                            d="M11.75 3.412a.818.818 0 01-.07.917 6.332 6.332 0 00-1.4 3.971c0 3.564 2.98 6.494 6.706 6.494a6.86 6.86 0 002.856-.617.818.818 0 011.1 1.047C19.593 18.614 16.218 21 12.283 21 7.18 21 3 16.973 3 11.956c0-4.563 3.46-8.31 7.925-8.948a.818.818 0 01.826.404z" />
                    </svg>
                    <svg xmlns="http://www.w3.org/2000/svg" x-show="!$store.global.isDarkModeEnabled"
                        x-transition:enter="transition-transform duration-200 ease-out absolute origin-top"
                        x-transition:enter-start="scale-75" x-transition:enter-end="scale-100 static"
                        class="size-6 text-amber-400" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd"
                            d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.12-10.607a1 1 0 010 1.414l-.706.707a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.414 0zM17 11a1 1 0 100-2h-1a1 1 0 100 2h1zm-7 4a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zM5.05 6.464A1 1 0 106.465 5.05l-.708-.707a1 1 0 00-1.414 1.414l.707.707zm1.414 8.486l-.707.707a1 1 0 01-1.414-1.414l.707-.707a1 1 0 011.414 1.414zM4 11a1 1 0 100-2H3a1 1 0 000 2h1z"
                            clip-rule="evenodd" />
                    </svg>
                </button>
                <!-- Monochrome Mode Toggle -->
                <button
                    @click="$store.global.isMonochromeModeEnabled = !$store.global.isMonochromeModeEnabled;$store.monochrome.toggle()"
                    class="btn size-8 rounded-full p-0 hover:bg-slate-300/20 focus:bg-slate-300/20 active:bg-slate-300/25 dark:hover:bg-navy-300/20 dark:focus:bg-navy-300/20 dark:active:bg-navy-300/25">
                    <i
                        class="fa-solid fa-palette bg-gradient-to-r from-sky-400 to-blue-600 bg-clip-text text-lg font-semibold text-transparent"></i>
                </button>

                @auth
                    <a href="{{ route('admin.dashboard') }}" wire:navigate
                        class="inline-flex items-center justify-center px-5 py-2.5 text-sm font-semibold text-white transition-all duration-200 bg-primary rounded-lg hover:bg-primary-focus focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary shadow-lg shadow-primary/30 hover:shadow-primary/40">
                        Dashboard
                    </a>
                @else
                    <a href="/login" wire:navigate
                        class="inline-flex items-center justify-center px-5 py-2.5 text-sm font-semibold text-white transition-all duration-200 bg-primary rounded-lg hover:bg-primary-focus focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary shadow-lg shadow-primary/30 hover:shadow-primary/40">
                        Masuk
                    </a>
                @endauth
            </div>

            <!-- Mobile Menu Button -->
            <div class="flex items-center md:hidden gap-4">
                <!-- Dark Mode Toggle -->

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

        <!-- Desktop Menu (Stacked md only) -->
        <div class="hidden md:flex lg:hidden items-center space-x-8 pb-4">
            @php
                $navClass = 'text-sm font-medium transition-colors duration-200';
                $activeClass = 'text-primary dark:text-primary font-semibold';
                $inactiveClass = 'text-slate-600 dark:text-slate-300 hover:text-primary dark:hover:text-primary';
            @endphp

            <a href="/" wire:navigate.hover
                class="{{ $navClass }} {{ request()->is('/') ? $activeClass : $inactiveClass }}">Beranda</a>
            <a href="{{ route('ppdb.pkbm') }}" wire:navigate.hover
                class="{{ $navClass }} {{ request()->routeIs('ppdb.*') ? $activeClass : $inactiveClass }}">PPDB</a>
            <a href="/profil" wire:navigate.hover
                class="{{ $navClass }} {{ request()->is('profil') ? $activeClass : $inactiveClass }}">Profil</a>
            <a href="/program" wire:navigate.hover
                class="{{ $navClass }} {{ request()->is('program') ? $activeClass : $inactiveClass }}">Program</a>
            <a href="/tutor" wire:navigate.hover
                class="{{ $navClass }} {{ request()->is('tutor') ? $activeClass : $inactiveClass }}">Tutor</a>
            <a href="/jadwal" wire:navigate.hover
                class="{{ $navClass }} {{ request()->is('jadwal') ? $activeClass : $inactiveClass }}">Jadwal</a>
            <a href="/pengumuman" wire:navigate.hover
                class="{{ $navClass }} {{ request()->is('pengumuman*') ? $activeClass : $inactiveClass }}">Pengumuman</a>
            <a href="/berita" wire:navigate.hover
                class="{{ $navClass }} {{ request()->is('berita*') ? $activeClass : $inactiveClass }}">Berita</a>
            <a href="/galeri" wire:navigate.hover
                class="{{ $navClass }} {{ request()->is('galeri*') ? $activeClass : $inactiveClass }}">Galeri</a>
        </div>
    </div>

    <!-- Mobile Menu -->
    <div x-show="mobileMenuOpen" x-cloak x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0 -translate-y-2" x-transition:enter-end="opacity-100 translate-y-0"
        x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 translate-y-0"
        x-transition:leave-end="opacity-0 -translate-y-2"
        class="md:hidden border-t border-slate-100 dark:border-navy-700 bg-white dark:bg-navy-800" id="mobile-menu">
        <div class="px-4 pt-2 pb-6 space-y-1">
            @php
                $mobileNavClass = 'block px-3 py-3 rounded-md text-base font-medium transition-colors';
                $mobileActiveClass = 'text-primary dark:text-primary bg-slate-50 dark:bg-navy-700';
                $mobileInactiveClass = 'text-slate-700 dark:text-slate-300 hover:text-primary dark:hover:text-primary hover:bg-slate-50 dark:hover:bg-navy-700';
            @endphp

            <a href="/" wire:navigate.hover
                class="{{ $mobileNavClass }} {{ request()->is('/') ? $mobileActiveClass : $mobileInactiveClass }}">Beranda</a>
            <a href="{{ route('ppdb.pkbm') }}" wire:navigate.hover
                class="{{ $mobileNavClass }} {{ request()->routeIs('ppdb.*') ? $mobileActiveClass : $mobileInactiveClass }}">PPDB</a>
            <a href="/profil" wire:navigate.hover
                class="{{ $mobileNavClass }} {{ request()->is('profil') ? $mobileActiveClass : $mobileInactiveClass }}">Profil</a>
            <a href="/program" wire:navigate.hover
                class="{{ $mobileNavClass }} {{ request()->is('program') ? $mobileActiveClass : $mobileInactiveClass }}">Program</a>
            <a href="/kegiatan" wire:navigate.hover
                class="{{ $mobileNavClass }} {{ request()->is('kegiatan') ? $mobileActiveClass : $mobileInactiveClass }}">Kegiatan</a>
            <a href="/pengumuman" wire:navigate.hover
                class="{{ $mobileNavClass }} {{ request()->is('pengumuman*') ? $mobileActiveClass : $mobileInactiveClass }}">Pengumuman</a>
            <a href="/berita" wire:navigate.hover
                class="{{ $mobileNavClass }} {{ request()->is('berita*') ? $mobileActiveClass : $mobileInactiveClass }}">Berita</a>
            <a href="/kontak" wire:navigate.hover
                class="{{ $mobileNavClass }} {{ request()->is('kontak*') ? $mobileActiveClass : $mobileInactiveClass }}">Kontak</a>
            <a href="/ppdb/pendaftar" wire:navigate.hover
                class="{{ $mobileNavClass }} {{ request()->is('ppdb/pendaftar*') ? $mobileActiveClass : $mobileInactiveClass }}">Daftar</a>
            <a href="/galeri" wire:navigate.hover
                class="{{ $mobileNavClass }} {{ request()->is('galeri*') ? $mobileActiveClass : $mobileInactiveClass }}">Galeri</a>
            <div class="pt-4 mt-4 border-t border-slate-100 dark:border-navy-700">
                @auth
                    <a href="/dashboard" wire:navigate
                        class="block w-full text-center px-5 py-3 text-base font-semibold text-white bg-primary rounded-lg hover:bg-primary-focus shadow-md shadow-primary/20">
                        Dashboard
                    </a>
                @else
                    <a href="/login" wire:navigate
                        class="block w-full text-center px-5 py-3 text-base font-semibold text-white bg-primary rounded-lg hover:bg-primary-focus shadow-md shadow-primary/20">
                        Masuk
                    </a>
                @endauth
            </div>
        </div>

        <div class="px-4 py-3 border-t border-slate-100 dark:border-navy-700">
            <div class="flex items-center justify-between px-3">
                <span class="text-base font-medium text-slate-700 dark:text-slate-300">Tampilan</span>
                <div class="flex items-center gap-4">
                    <!-- Dark Mode Toggle -->
                    <button
                        @click="$store.global.isDarkModeEnabled = !$store.global.isDarkModeEnabled;$store.darkMode.toggle()"
                        class="btn size-8 rounded-full p-0 hover:bg-slate-100 focus:bg-slate-100 active:bg-slate-200 dark:hover:bg-navy-700 dark:focus:bg-navy-700 dark:active:bg-navy-600 transition-colors">
                        <svg x-show="$store.global.isDarkModeEnabled"
                            x-transition:enter="transition-transform duration-200 ease-out absolute origin-top"
                            x-transition:enter-start="scale-75" x-transition:enter-end="scale-100 static"
                            class="size-6 text-amber-400" fill="currentColor" viewBox="0 0 24 24">
                            <path
                                d="M11.75 3.412a.818.818 0 01-.07.917 6.332 6.332 0 00-1.4 3.971c0 3.564 2.98 6.494 6.706 6.494a6.86 6.86 0 002.856-.617.818.818 0 011.1 1.047C19.593 18.614 16.218 21 12.283 21 7.18 21 3 16.973 3 11.956c0-4.563 3.46-8.31 7.925-8.948a.818.818 0 01.826.404z" />
                        </svg>
                        <svg xmlns="http://www.w3.org/2000/svg" x-show="!$store.global.isDarkModeEnabled"
                            x-transition:enter="transition-transform duration-200 ease-out absolute origin-top"
                            x-transition:enter-start="scale-75" x-transition:enter-end="scale-100 static"
                            class="size-6 text-amber-400" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd"
                                d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.12-10.607a1 1 0 010 1.414l-.706.707a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.414 0zM17 11a1 1 0 100-2h-1a1 1 0 100 2h1zm-7 4a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zM5.05 6.464A1 1 0 106.465 5.05l-.708-.707a1 1 0 00-1.414 1.414l.707.707zm1.414 8.486l-.707.707a1 1 0 01-1.414-1.414l.707-.707a1 1 0 011.414 1.414zM4 11a1 1 0 100-2H3a1 1 0 000 2h1z"
                                clip-rule="evenodd" />
                        </svg>
                    </button>
                    <!-- Monochrome Mode Toggle -->
                    <button
                        @click="$store.global.isMonochromeModeEnabled = !$store.global.isMonochromeModeEnabled;$store.monochrome.toggle()"
                        class="btn size-8 rounded-full p-0 hover:bg-slate-100 focus:bg-slate-100 active:bg-slate-200 dark:hover:bg-navy-700 dark:focus:bg-navy-700 dark:active:bg-navy-600 transition-colors">
                        <i
                            class="fa-solid fa-palette bg-gradient-to-r from-sky-400 to-blue-600 bg-clip-text text-lg font-semibold text-transparent"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>
</nav>