<?php
use function Laravel\Folio\{name};

name('ppdb.ppdb.index');

?>
<x-app-layout title="Data PPDB" is-sidebar-open="true" is-header-blur="true">
    <!-- Main Content Wrapper -->
    <main class="main-content w-full px-[var(--margin-x)] pb-8">
        @livewire('ppdb-table')
    </main>
</x-app-layout>