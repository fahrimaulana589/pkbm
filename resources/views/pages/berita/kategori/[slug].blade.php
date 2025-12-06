<?php

use function Laravel\Folio\name;

name('berita.category');

?>

<x-landing-layout>
    @livewire('landing.news-index', ['category' => $slug])
</x-landing-layout>