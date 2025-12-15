<?php

use function Livewire\Volt\{state, mount};
use App\Models\Ppdb;
use App\Models\Setting;

state([
    'setting' => null,
    'activePpdb' => null,
]);

mount(function () {
    $this->setting = Setting::first();
    $this->activePpdb = Ppdb::where('status', 'open')->latest()->first();
});

?>

<div>
    @if($activePpdb)
        @if($setting)
            {{-- Sambutan Section (Matches Profile Sambutan Style) --}}
            <div
                class="mx-auto grid max-w-2xl grid-cols-1 gap-x-8 gap-y-10 lg:mx-0 lg:max-w-none lg:grid-cols-2 items-center mb-16">
                <div class="lg:pr-8">
                    <div class="lg:max-w-lg">
                        <h2 class="text-base font-semibold leading-7 text-primary">Informasi PPDB</h2>
                        <p class="mt-2 text-3xl font-bold tracking-tight text-slate-900 dark:text-white sm:text-4xl">
                            Selamat Datang
                        </p>
                        <div class="mt-6 text-lg leading-8 text-slate-600 dark:text-slate-300 prose dark:prose-invert">
                            {!! nl2br(e($setting->ppdb_sambutan ?? 'Belum ada informasi sambutan PPDB.')) !!}
                        </div>
                    </div>
                </div>

                <div class="relative">
                    @if($setting->ppdb_foto)
                        <img src="{{ Storage::url($setting->ppdb_foto) }}" alt="PPDB Photo"
                            class="w-full rounded-xl shadow-xl ring-1 ring-gray-400/10 object-cover aspect-[4/3]">
                    @else
                        <div
                            class="w-full aspect-[4/3] bg-slate-100 dark:bg-navy-800 rounded-xl flex items-center justify-center ring-1 ring-gray-400/10">
                            <span class="text-slate-400">Foto tidak tersedia</span>
                        </div>
                    @endif
                </div>
            </div>

            {{-- Alur Section (Matches Profile Visi Misi / Latar Belakang Style) --}}
            @if($setting->ppdb_alur)
                <div class="mx-auto max-w-7xl">
                    <div
                        class="flex flex-col gap-y-6 rounded-3xl bg-white dark:bg-navy-800 p-8 ring-1 ring-gray-200 dark:ring-navy-700 shadow-sm">
                        <dt class="flex items-center gap-x-3 text-base font-semibold leading-7 text-slate-900 dark:text-white">
                            <div class="h-10 w-10 flex items-center justify-center rounded-lg bg-primary">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                </svg>
                            </div>
                            Alur Pendaftaran ({{ $activePpdb->tahun }})
                        </dt>
                        <dd class="flex flex-auto flex-col text-base leading-7 text-slate-600 dark:text-slate-300">
                            <div class="prose prose-slate dark:prose-invert max-w-none">
                                {!! nl2br(e($setting->ppdb_alur)) !!}
                            </div>
                            <div class="mt-8 flex justify-center">
                                <a href="{{ route('ppdb.daftar') }}" wire:navigate
                                    class="rounded-md bg-primary px-3.5 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-primary-focus focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-primary transition-colors">
                                    Daftar Sekarang
                                </a>
                            </div>
                        </dd>
                    </div>
                </div>
            @endif
        @else
            <div
                class="py-12 text-center bg-white dark:bg-navy-800 rounded-xl shadow-sm border border-slate-150 dark:border-navy-700">
                <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-slate-100 dark:bg-navy-700 mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 text-slate-400" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <h3 class="text-lg font-medium text-slate-900 dark:text-white">Informasi Belum Tersedia</h3>
                <p class="text-slate-500 mt-2">Pengaturan PPDB belum dikonfigurasi oleh admin.</p>
            </div>
        @endif
    @else
        <div class="mx-auto max-w-7xl">
            <div class="flex flex-col items-center justify-center py-12 text-center">
                <div class="bg-warning/10 text-warning rounded-full p-4 mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-slate-800 dark:text-navy-100 mb-2">Pendaftaran Ditutup</h3>
                <p class="text-slate-500 dark:text-slate-300 max-w-lg mx-auto">
                    Saat ini tidak ada periode Penerimaan Peserta Didik Baru (PPDB) yang sedang dibuka.
                    Silakan kembali lagi nanti untuk informasi terbaru.
                </p>
            </div>
        </div>
    @endif
</div>