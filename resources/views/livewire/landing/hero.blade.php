<?php

use function Livewire\Volt\{state, mount};
use App\Models\PkbmProfile;

// state(['profile' => null]); // Removed as it is shared via View::share

mount(function () {
    // Profile is shared via View::share in AppServiceProvider
});

?>

<section class="relative bg-white dark:bg-navy-900 overflow-hidden py-10 lg:py-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
            <!-- Text Content -->
            <div class="relative z-10">
                <h1
                    class="text-4xl tracking-tight font-extrabold text-slate-900 dark:text-white sm:text-5xl md:text-6xl leading-tight">
                    <span class="block">Wujudkan Masa Depan</span>
                    <span class="block text-primary">Generasi Emas</span>
                </h1>
                <p class="mt-4 text-lg text-slate-600 dark:text-slate-300 sm:mt-6">
                    {{ $profile->kata_sambutan ?? 'Sekolah Pelita Nusantara berkomitmen mencetak pemimpin masa depan yang cerdas, berintegritas, dan siap bersaing di kancah global.' }}
                </p>

                <div class="mt-8 flex flex-wrap gap-4">
                    <div
                        class="inline-flex items-center px-4 py-2 rounded-lg border border-slate-200 dark:border-navy-700 bg-white dark:bg-navy-800 shadow-sm">
                        <div
                            class="flex-shrink-0 w-8 h-8 rounded-full bg-green-100 text-green-600 flex items-center justify-center mr-3">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20"
                                fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                    clip-rule="evenodd" />
                            </svg>
                        </div>
                        <span class="text-sm font-medium text-slate-700 dark:text-slate-200">Akreditasi A</span>
                    </div>
                    <div
                        class="inline-flex items-center px-4 py-2 rounded-lg border border-slate-200 dark:border-navy-700 bg-white dark:bg-navy-800 shadow-sm">
                        <div
                            class="flex-shrink-0 w-8 h-8 rounded-full bg-yellow-100 text-yellow-600 flex items-center justify-center mr-3">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20"
                                fill="currentColor">
                                <path
                                    d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                            </svg>
                        </div>
                        <span class="text-sm font-medium text-slate-700 dark:text-slate-200">Program Unggulan</span>
                    </div>
                    <div
                        class="inline-flex items-center px-4 py-2 rounded-lg border border-slate-200 dark:border-navy-700 bg-white dark:bg-navy-800 shadow-sm">
                        <div
                            class="flex-shrink-0 w-8 h-8 rounded-full bg-red-100 text-red-600 flex items-center justify-center mr-3">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20"
                                fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z"
                                    clip-rule="evenodd" />
                            </svg>
                        </div>
                        <span class="text-sm font-medium text-slate-700 dark:text-slate-200">Ramah Anak</span>
                    </div>
                </div>
            </div>

            <!-- Image Content -->
            <div class="relative mt-10 lg:mt-0">
                <div class="relative rounded-2xl overflow-hidden shadow-xl">
                    <img class="w-full h-full object-cover"
                        src="{{ $profile && $profile->foto_sambutan ? asset('storage/' . $profile->foto_sambutan) : 'https://images.unsplash.com/photo-1523050854058-8df90110c9f1?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=crop&w=1350&q=80' }}"
                        alt="Welcome Photo">
                </div>

                <!-- Floating Stats Card -->
                <div
                    class="absolute -bottom-6 -left-6 bg-white dark:bg-navy-800 p-4 rounded-xl shadow-lg border border-slate-100 dark:border-navy-700 flex items-center gap-4 animate-bounce-slow">
                    <div class="w-12 h-12 rounded-full bg-green-100 text-green-600 flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path d="M12 14l9-5-9-5-9 5 9 5z" />
                            <path
                                d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14zm-4 6v-7.5l4-2.222" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-2xl font-bold text-slate-800 dark:text-white">1000+</p>
                        <p class="text-sm text-slate-500 dark:text-slate-400">Alumni Sukses</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>