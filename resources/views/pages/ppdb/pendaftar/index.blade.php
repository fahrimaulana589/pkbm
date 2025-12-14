<?php
use function Laravel\Folio\{name, middleware};

name('ppdb.pendaftar.index');
middleware(['auth', 'verified']);

?>

<x-app-layout title="Data Pendaftar" is-sidebar-open="true" is-header-blur="true">
    <main class="main-content w-full px-[var(--margin-x)] pb-8">


        @livewire('pendaftar-table')
    </main>
</x-app-layout>