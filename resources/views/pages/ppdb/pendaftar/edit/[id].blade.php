<?php
use function Laravel\Folio\{name, middleware};

name('ppdb.pendaftar.edit');
middleware(['auth', 'verified']);

?>

<x-app-layout title="Edit Pendaftar" is-sidebar-open="true" is-header-blur="true">
    <main class="main-content w-full px-[var(--margin-x)] pb-8">


        @livewire('pendaftar-form-edit', ['id' => $id])
    </main>
</x-app-layout>