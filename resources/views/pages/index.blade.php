<?php

use function Laravel\Folio\name;

name('landing');

?>

<x-landing-layout>
    @livewire('landing.hero')
    @livewire('landing.profile')
    @livewire('landing.programs')
    @livewire('landing.tutors')
    @livewire('landing.announcements')
    @livewire('landing.news')
    @livewire('landing.gallery')
    @livewire('landing.stats')
    @livewire('landing.footer')
</x-landing-layout>