<?php

use function Laravel\Folio\name;

name('berita.show');

?>

<x-landing-layout>
    @livewire('landing.news-show', ['slug' => $slug])
</x-landing-layout>