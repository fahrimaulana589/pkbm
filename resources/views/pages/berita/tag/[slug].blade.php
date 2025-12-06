<?php

use function Laravel\Folio\name;

name('berita.tag');

?>

<x-landing-layout>
    @livewire('landing.news-index', ['tag' => $slug])
</x-landing-layout>