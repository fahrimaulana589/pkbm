<?php
use function Laravel\Folio\name;
name('ppdb.info');
?>
<x-landing-layout>
    <div class="container mx-auto px-4 py-8">
        <h1 class="text-3xl font-bold text-center mb-8">Info PPDB</h1>
        <x-landing.ppdb-nav />
        @livewire('landing.ppdb-info-index')
    </div>
</x-landing-layout>