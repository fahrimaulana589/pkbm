<?php

use function Laravel\Folio\{name};

name('admin.student.index');

?>

<x-app-layout title="Warga Belajar" is-sidebar-open="true" is-header-blur="true">
    <main class="main-content w-full px-[var(--margin-x)] pb-8">
        @livewire('student-table')
    </main>
</x-app-layout>