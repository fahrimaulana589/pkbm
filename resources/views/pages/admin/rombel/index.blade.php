<?php

use function Laravel\Folio\{name};

name('admin.rombel.index');

?>

<x-app-layout title="Rombel" is-sidebar-open="true" is-header-blur="true">
    <main class="main-content w-full px-[var(--margin-x)] pb-8">
        @livewire('class-group-table')
    </main>
</x-app-layout>