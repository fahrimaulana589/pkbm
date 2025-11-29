<?php
use function Laravel\Folio\{name};
 
name('admin.tutor.index');

?>
<x-app-layout title="Tutor" is-sidebar-open="true" is-header-blur="true">
    <!-- Main Content Wrapper -->
    <main class="main-content w-full px-[var(--margin-x)] pb-8">
        @livewire('tutor-table')     
    </main>
</x-app-layout>
