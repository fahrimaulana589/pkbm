<?php
use function Laravel\Folio\name;
name('ppdb.pkbm');
?>
<x-landing-layout>
    <div class="bg-white dark:bg-navy-900">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <h1 class="text-3xl font-bold text-center mb-8 text-slate-900 dark:text-white">Sambutan PPDB</h1>
            <x-landing.ppdb-nav />

            @livewire('landing.ppdb-pkbm')
        </div>
    </div>
</x-landing-layout>