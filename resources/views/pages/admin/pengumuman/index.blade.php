<?php

use function Laravel\Folio\name;

name('admin.pengumuman');

?>
<x-app-layout title="Pengumuman" is-sidebar-open="true" is-header-blur="true">
    <!-- Main Content Wrapper -->
    <main class="main-content w-full px-[var(--margin-x)] pb-8">
        <!-- Content kosong seperti pada admin/index.blade.php -->
        @livewire('announcement-table')
    </main>
</x-app-layout>