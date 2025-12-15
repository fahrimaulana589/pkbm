<?php
use function Laravel\Folio\name;
name('ppdb.daftar');
?>
<x-landing-layout>
    <div class="container mx-auto px-4 py-8">
        <h1 class="text-3xl font-bold text-center mb-8 text-slate-800 dark:text-navy-100">Pendaftaran PPDB</h1>
        <x-landing.ppdb-nav />

        <div class="max-w-3xl mx-auto">
            @livewire('landing.ppdb-register-form')
        </div>
    </div>
</x-landing-layout>