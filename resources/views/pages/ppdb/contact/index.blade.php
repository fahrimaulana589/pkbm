<?php

use function Laravel\Folio\name;

name('ppdb.contact.index');

?>
<x-app-layout title="Data Kontak" is-sidebar-open="true" is-header-blur="true">
    <main class="main-content w-full px-[var(--margin-x)] pb-8">
        <div class="flex items-center space-x-4 py-5 lg:py-6">
            <h2 class="text-xl font-medium text-slate-800 dark:text-navy-50 lg:text-2xl">
                Data Kontak
            </h2>
        </div>

        @livewire('contact-table')
    </main>
</x-app-layout>