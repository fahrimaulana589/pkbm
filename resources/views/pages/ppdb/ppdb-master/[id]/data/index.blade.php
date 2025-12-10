<?php
use function Laravel\Folio\{name};
name('admin.ppdb.master.data.index');
?>

<x-app-layout title="Data Atribut PPDB" is-sidebar-open="true" is-header-blur="true">
    <main class="main-content w-full px-[var(--margin-x)] pb-8">




        @livewire('data-ppdb-table', ['ppdbId' => $id])
    </main>
</x-app-layout>