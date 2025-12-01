<?php

use function Laravel\Folio\{name};

name('admin.kategori-berita.index');

?>

<x-app-layout title="Kategori Berita" is-sidebar-open="true" is-header-blur="true">
    <main class="main-content w-full px-[var(--margin-x)] pb-8">
        @livewire('news-category-table')
    </main>
</x-app-layout>