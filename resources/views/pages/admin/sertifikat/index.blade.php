<?php

use function Laravel\Folio\{name};

name('admin.sertifikat.index');

?>

<x-app-layout title="Sertifikat" is-sidebar-open="true" is-header-blur="true">
    <main class="main-content w-full px-[var(--margin-x)] pb-8">
        @livewire('certificate-table')
    </main>
</x-app-layout>