<?php

use function Laravel\Folio\{name};

name('admin.jadwal.index');

?>

<x-app-layout title="Jadwal Belajar" is-sidebar-open="true" is-header-blur="true">
    <main class="main-content w-full px-[var(--margin-x)] pb-8">
        @livewire('schedule-table')
    </main>
</x-app-layout>