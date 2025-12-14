<?php
use function Laravel\Folio\name;
name('ppdb.pengumuman');
?>
<x-landing-layout>
    <div class="container mx-auto px-4 py-8">
        <h1 class="text-3xl font-bold text-center mb-8">Pengumuman PPDB</h1>
        <x-landing.ppdb-nav />
        @livewire('landing.announcement-index')
    </div>
</x-landing-layout>