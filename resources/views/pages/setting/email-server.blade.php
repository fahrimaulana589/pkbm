<?php
use function Laravel\Folio\{name};

name('setting.email-server');

?>
<x-app-layout title="Email Server Settings" is-sidebar-open="true" is-header-blur="true">
    <main class="main-content w-full px-[var(--margin-x)] pb-8">
        <div class="flex items-center space-x-4 py-5 lg:py-6">
          <h2
            class="text-xl font-medium text-slate-800 dark:text-navy-50 lg:text-2xl"
          >
            Email Server Settings
          </h2>
        </div>
        <div class="grid grid-cols-1 gap-4 sm:gap-5 lg:gap-6">
            @livewire('settingemailserver')
        </div> 
    </main>
</x-app-layout>
