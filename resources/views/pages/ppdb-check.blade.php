<?php
use function Laravel\Folio\name;
name('ppdb.check');
?>
<x-landing-layout>
    <div class="container mx-auto px-4 py-8 max-w-3xl">
        <h1 class="text-3xl font-bold text-center mb-8 text-slate-800 dark:text-navy-100">Pengecekan Status PPDB</h1>
        <x-landing.ppdb-nav />

        @livewire('landing.ppdb-check-form')
    </div>
</x-landing-layout>