<?php

use function Livewire\Volt\{state, mount};
use App\Models\PkbmProfile;

state(['isFullPage' => false]);

mount(function ($isFullPage = false) {
    // Profile is shared via View::share in AppServiceProvider
    $this->isFullPage = $isFullPage;
});

?>

<div class="w-full">
    @if(!$isFullPage)
        {{-- Landing Page View (Summary) --}}
        <section id="profil" class="py-12 bg-slate-50 dark:bg-navy-800">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="lg:text-center">
                    <h2 class="text-base text-primary font-semibold tracking-wide uppercase">Profil</h2>
                    <p
                        class="mt-2 text-3xl leading-8 font-extrabold tracking-tight text-slate-900 dark:text-white sm:text-4xl">
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
                                    <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor">
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
                                    <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor">
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
    @else
        {{-- Dedicated Full Page View (Redesigned) --}}
        <div class="bg-white dark:bg-navy-900">
            @if($profile)
                {{-- Hero Section --}}
                <div class="relative bg-slate-900 py-16 sm:py-20 overflow-hidden">
                    <div class="absolute inset-0">
                        <img src="https://images.unsplash.com/photo-1523050854058-8df90110c9f1?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=crop&w=1950&q=80"
                            alt="Background" class="w-full h-full object-cover opacity-20">
                        <div
                            class="absolute inset-0 bg-gradient-to-r from-slate-900 via-slate-900/90 to-slate-900/50 mix-blend-multiply">
                        </div>
                    </div>
                    <div class="relative max-w-7xl mx-auto px-6 lg:px-8">
                        <div class="max-w-2xl">
                            <h1 class="text-3xl font-bold tracking-tight text-white sm:text-5xl">Profil Lembaga</h1>
                            <p class="mt-4 text-lg leading-8 text-slate-300">
                                Mengenal lebih dekat {{ $profile->nama_pkbm ?? 'PKBM SekolahKita' }}. Dedikasi kami untuk
                                pendidikan masyarakat yang berkualitas dan berdaya saing.
                            </p>
                        </div>
                    </div>
                </div>

                {{-- Sambutan Section --}}
                @if($profile->kata_sambutan)
                    <section class="py-12 bg-white dark:bg-navy-900">
                        <div class="max-w-7xl mx-auto px-6 lg:px-8">
                            <div
                                class="mx-auto grid max-w-2xl grid-cols-1 gap-x-8 gap-y-10 lg:mx-0 lg:max-w-none lg:grid-cols-2 items-center">
                                <div class="lg:pr-8">
                                    <div class="lg:max-w-lg">
                                        <h2 class="text-base font-semibold leading-7 text-primary">Sambutan Kepala PKBM</h2>
                                        <p
                                            class="mt-2 text-3xl font-bold tracking-tight text-slate-900 dark:text-white sm:text-4xl">
                                            {{ $profile->kepala_pkbm }}
                                        </p>
                                        <div
                                            class="mt-6 text-lg leading-8 text-slate-600 dark:text-slate-300 prose dark:prose-invert">
                                            {!! nl2br(e($profile->kata_sambutan)) !!}
                                        </div>
                                    </div>
                                </div>
                                <div class="relative">
                                    @if($profile->foto_sambutan)
                                        <img src="{{ asset('storage/' . $profile->foto_sambutan) }}" alt="Kepala PKBM"
                                            class="w-full rounded-xl shadow-xl ring-1 ring-gray-400/10 object-cover aspect-[4/3]"
                                            width="2432" height="1442">
                                    @else
                                        <div
                                            class="w-full aspect-[4/3] bg-slate-100 dark:bg-navy-800 rounded-xl flex items-center justify-center">
                                            <span class="text-slate-400">Foto tidak tersedia</span>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </section>
                @endif

                {{-- Visi Misi Section --}}
                <section class="py-12 bg-slate-50 dark:bg-navy-800">
                    <div class="max-w-7xl mx-auto px-6 lg:px-8">
                        <div class="mx-auto max-w-2xl text-center">
                            <h2 class="text-3xl font-bold tracking-tight text-slate-900 dark:text-white sm:text-4xl">Visi & Misi
                            </h2>
                            <p class="mt-2 text-lg leading-8 text-slate-600 dark:text-slate-300">Landasan kami dalam melangkah
                                dan berkarya.</p>
                        </div>
                        <div
                            class="mx-auto mt-10 grid max-w-2xl grid-cols-1 gap-6 sm:mt-20 lg:mx-0 lg:max-w-none lg:grid-cols-2">
                            <div
                                class="flex flex-col gap-y-6 rounded-3xl bg-white dark:bg-navy-700 p-8 ring-1 ring-gray-200 dark:ring-navy-600 shadow-sm hover:shadow-md transition-shadow">
                                <dt
                                    class="flex items-center gap-x-3 text-base font-semibold leading-7 text-slate-900 dark:text-white">
                                    <div class="h-10 w-10 flex items-center justify-center rounded-lg bg-primary">
                                        <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                            stroke="currentColor" aria-hidden="true">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        </svg>
                                    </div>
                                    Visi
                                </dt>
                                <dd class="flex flex-auto flex-col text-base leading-7 text-slate-600 dark:text-slate-300">
                                    <p class="flex-auto">{{ $profile->visi ?? 'Belum ada data visi.' }}</p>
                                </dd>
                            </div>
                            <div
                                class="flex flex-col gap-y-6 rounded-3xl bg-white dark:bg-navy-700 p-8 ring-1 ring-gray-200 dark:ring-navy-600 shadow-sm hover:shadow-md transition-shadow">
                                <dt
                                    class="flex items-center gap-x-3 text-base font-semibold leading-7 text-slate-900 dark:text-white">
                                    <div class="h-10 w-10 flex items-center justify-center rounded-lg bg-primary">
                                        <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                            stroke="currentColor" aria-hidden="true">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M3.75 13.5l10.5-11.25L12 10.5h8.25L9.75 21.75 12 13.5H3.75z" />
                                        </svg>
                                    </div>
                                    Misi
                                </dt>
                                <dd class="flex flex-auto flex-col text-base leading-7 text-slate-600 dark:text-slate-300">
                                    <p class="flex-auto">{{ $profile->misi ?? 'Belum ada data misi.' }}</p>
                                </dd>
                            </div>
                        </div>
                    </div>
                </section>

                {{-- Details Grid --}}
                <section class="py-12 bg-white dark:bg-navy-900">
                    <div class="max-w-7xl mx-auto px-6 lg:px-8">
                        <div class="mx-auto max-w-2xl lg:max-w-none">
                            <div class="grid grid-cols-1 gap-8 lg:grid-cols-3">
                                {{-- Identity Card --}}
                                <div class="rounded-2xl bg-slate-50 dark:bg-navy-800 p-8">
                                    <h3 class="text-lg font-semibold leading-8 text-primary">Identitas</h3>
                                    <dl class="mt-4 space-y-4 text-base leading-7 text-slate-600 dark:text-slate-300">
                                        <div class="flex gap-x-4">
                                            <dt class="flex-none">
                                                <span class="sr-only">Nama</span>
                                                <svg class="h-6 w-5 text-slate-400" viewBox="0 0 20 20" fill="currentColor"
                                                    aria-hidden="true">
                                                    <path fill-rule="evenodd"
                                                        d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                                                        clip-rule="evenodd" />
                                                </svg>
                                            </dt>
                                            <dd>{{ $profile->nama_pkbm }}</dd>
                                        </div>
                                        <div class="flex gap-x-4">
                                            <dt class="flex-none">
                                                <span class="sr-only">NPSN</span>
                                                <svg class="h-6 w-5 text-slate-400" viewBox="0 0 20 20" fill="currentColor"
                                                    aria-hidden="true">
                                                    <path fill-rule="evenodd"
                                                        d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 3.414L15.586 7A2 2 0 0116 8.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4zm2 6a1 1 0 011-1h6a1 1 0 110 2H7a1 1 0 01-1-1zm1 3a1 1 0 100 2h6a1 1 0 100-2H7z"
                                                        clip-rule="evenodd" />
                                                </svg>
                                            </dt>
                                            <dd>NPSN: {{ $profile->npsn ?? '-' }}</dd>
                                        </div>
                                    </dl>
                                </div>

                                {{-- Contact Card --}}
                                <div class="rounded-2xl bg-slate-50 dark:bg-navy-800 p-8">
                                    <h3 class="text-lg font-semibold leading-8 text-primary">Kontak</h3>
                                    <dl class="mt-4 space-y-4 text-base leading-7 text-slate-600 dark:text-slate-300">
                                        <div class="flex gap-x-4">
                                            <dt class="flex-none">
                                                <span class="sr-only">Telepon</span>
                                                <svg class="h-7 w-6 text-slate-400" fill="none" viewBox="0 0 24 24"
                                                    stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 002.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 01-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 00-1.091-.852H4.5A2.25 2.25 0 002.25 4.5v2.25z" />
                                                </svg>
                                            </dt>
                                            <dd><a class="hover:text-slate-900 dark:hover:text-white"
                                                    href="tel:{{ $profile->telepon }}">{{ $profile->telepon ?? '-' }}</a></dd>
                                        </div>
                                        <div class="flex gap-x-4">
                                            <dt class="flex-none">
                                                <span class="sr-only">Email</span>
                                                <svg class="h-7 w-6 text-slate-400" fill="none" viewBox="0 0 24 24"
                                                    stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75" />
                                                </svg>
                                            </dt>
                                            <dd><a class="hover:text-slate-900 dark:hover:text-white"
                                                    href="mailto:{{ $profile->email }}">{{ $profile->email ?? '-' }}</a></dd>
                                        </div>
                                    </dl>
                                </div>

                                {{-- Address Card --}}
                                <div class="rounded-2xl bg-slate-50 dark:bg-navy-800 p-8">
                                    <h3 class="text-lg font-semibold leading-8 text-primary">Lokasi</h3>
                                    <dl class="mt-4 space-y-4 text-base leading-7 text-slate-600 dark:text-slate-300">
                                        <div class="flex gap-x-4">
                                            <dt class="flex-none">
                                                <span class="sr-only">Alamat</span>
                                                <svg class="h-7 w-6 text-slate-400" fill="none" viewBox="0 0 24 24"
                                                    stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z" />
                                                </svg>
                                            </dt>
                                            <dd>
                                                {{ $profile->alamat }}<br>
                                                {{ $profile->desa ? 'Desa ' . $profile->desa . ',' : '' }}
                                                {{ $profile->kecamatan ? 'Kec. ' . $profile->kecamatan . ',' : '' }}<br>
                                                {{ $profile->kota ? $profile->kota . ',' : '' }}
                                                {{ $profile->provinsi }}
                                            </dd>
                                        </div>
                                    </dl>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            @else
                <div class="py-24 text-center">
                    <p class="text-slate-500">Data profil belum tersedia.</p>
                </div>
            @endif
        </div>
    @endif
</div>