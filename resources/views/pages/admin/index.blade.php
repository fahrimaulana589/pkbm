<?php
use function Laravel\Folio\{name};

name('admin.dashboard');

?>

<x-app-layout title="Dashboard" is-sidebar-open="true" is-header-blur="true">
    <!-- Main Content Wrapper -->
    <main class="main-content w-full px-[var(--margin-x)] pb-8">
        <div class="mt-4">
            @livewire('admin-dashboard-stats')
        </div>
    </main>
</x-app-layout>