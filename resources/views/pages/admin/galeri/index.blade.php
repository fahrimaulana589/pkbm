<?php

use function Laravel\Folio\{name};

name('admin.galeri.index');

?>

<x-app-layout title="Galeri" is-sidebar-open="true" is-header-blur="true">
    <main class="main-content w-full px-[var(--margin-x)] pb-8">
        @livewire('gallery-table')
    </main>
</x-app-layout>