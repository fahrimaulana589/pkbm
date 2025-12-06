<?php

use function Livewire\Volt\{state, mount};
use App\Models\PkbmProfile;

state(['profile' => null]);

mount(function () {
    $this->profile = PkbmProfile::first();
});

?>

<section id="profil" class="py-12 bg-slate-50 dark:bg-navy-800">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="lg:text-center">
            <h2 class="text-base text-primary font-semibold tracking-wide uppercase">Profil</h2>
            <p class="mt-2 text-3xl leading-8 font-extrabold tracking-tight text-slate-900 dark:text-white sm:text-4xl">
                Tentang {{ $profile->nama_pkbm ?? 'PKBM SekolahKita' }}
            </p>
            <p class="mt-4 text-xl text-slate-500 dark:text-slate-300 lg:mx-auto">
                {{ $profile->visi ?? 'Menjadi pusat kegiatan belajar masyarakat yang unggul dan berdaya saing.' }}
            </p>
        </div>

        <div class="mt-10">
            <dl class="space-y-10 md:space-y-0 md:grid md:grid-cols-2 md:gap-x-8 md:gap-y-10">
                <div class="relative">
                    <dt>
                        <div
                            class="absolute flex items-center justify-center h-12 w-12 rounded-md bg-primary text-white">
                            <!-- Heroicon name: outline/globe-alt -->
                            <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9" />
                            </svg>
                        </div>
                        <p class="ml-16 text-lg leading-6 font-medium text-slate-900 dark:text-white">Visi</p>
                    </dt>
                    <dd class="mt-2 ml-16 text-base text-slate-500 dark:text-slate-300">
                        {{ $profile->visi ?? 'Belum ada data visi.' }}
                    </dd>
                </div>

                <div class="relative">
                    <dt>
                        <div
                            class="absolute flex items-center justify-center h-12 w-12 rounded-md bg-primary text-white">
                            <!-- Heroicon name: outline/scale -->
                            <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 6l3 1m0 0l-3 9a5.002 5.002 0 006.001 0M6 7l3 9M6 7l6-2m6 2l3-1m-3 1l-3 9a5.002 5.002 0 006.001 0M18 7l3 9m-3-9l-6-2m0-2v2m0 16V5m0 16H9m3 0h3" />
                            </svg>
                        </div>
                        <p class="ml-16 text-lg leading-6 font-medium text-slate-900 dark:text-white">Misi</p>
                    </dt>
                    <dd class="mt-2 ml-16 text-base text-slate-500 dark:text-slate-300">
                        {{ $profile->misi ?? 'Belum ada data misi.' }}
                    </dd>
                </div>
            </dl>
        </div>
    </div>
</section>