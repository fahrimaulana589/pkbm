<?php
use function Laravel\Folio\name;
name('ppdb.daftar');
?>
<x-landing-layout>
    <div class="container mx-auto px-4 py-8">
        <h1 class="text-3xl font-bold text-center mb-8">Pendaftaran PPDB</h1>
        <x-landing.ppdb-nav />

        <div class="bg-white rounded-lg shadow-sm p-6 text-center text-gray-500">
            Form Pendaftaran akan tampil di sini.
        </div>
    </div>
</x-landing-layout>