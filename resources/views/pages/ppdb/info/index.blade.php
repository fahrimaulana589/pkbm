<?php
use function Laravel\Folio\{name, middleware};
name('ppdb.info.index');
middleware(['auth', 'verified']);
?>
<x-app-layout title="Info PPDB" is-sidebar-open="true" is-header-blur="true">
    <main class="main-content w-full px-[var(--margin-x)] pb-8">
        @livewire('ppdb-info-table')
    </main>
</x-app-layout>