<?php
use function Laravel\Folio\name;
name('ppdb.pkbm');
?>
<x-landing-layout>
    <div class="container mx-auto px-4 py-8">
        <h1 class="text-3xl font-bold text-center mb-8 text-slate-800 dark:text-navy-100">Sambutan PPDB</h1>
        <x-landing.ppdb-nav />

        @livewire('landing.ppdb-pkbm')
    </div>
</x-landing-layout>