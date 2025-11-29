<?php

use function Laravel\Folio\{name};

name('admin.program.index');

?>

<x-app-layout title="Program Pendidikan" is-sidebar-open="true" is-header-blur="true">
    <main class="main-content w-full px-[var(--margin-x)] pb-8">
        @livewire('program-table')
    </main>
</x-app-layout>