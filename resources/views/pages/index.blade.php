<?php

use function Laravel\Folio\name;

name('landing');

?>

<x-landing-layout>
    @livewire('landing.hero')
    @livewire('landing.profile')
    @livewire('landing.programs')
    @livewire('landing.tutors')
    @livewire('landing.schedules')
    @livewire('landing.announcements')
    @livewire('landing.news')
    @livewire('landing.gallery')
</x-landing-layout>