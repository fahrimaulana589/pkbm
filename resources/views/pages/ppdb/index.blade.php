<?php
use function Laravel\Folio\{name};

name('ppdb.dashboard');

?>
<x-app-layout title="Dashboard" is-sidebar-open="true" is-header-blur="true">
  <!-- Main Content Wrapper -->
  <main class="main-content w-full px-[var(--margin-x)] pb-8">
    <div class="mt-4">
      @livewire('ppdb-dashboard-stats')
    </div>
  </main>
</x-app-layout>