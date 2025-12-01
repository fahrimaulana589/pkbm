<?php

use function Laravel\Folio\{name};

name('admin.tag-berita.index');

?>

<x-app-layout title="Tag Berita" is-sidebar-open="true" is-header-blur="true">
    <main class="main-content w-full px-[var(--margin-x)] pb-8">
        @livewire('news-tag-table')
    </main>
</x-app-layout>