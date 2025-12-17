<?php
use function Laravel\Folio\{name, middleware};

name('password.request');

?>
<x-guest-layout title="forgot password">
    <div class="fixed top-0 hidden p-6 lg:block lg:px-12">
        <a href="#" class="flex items-center space-x-2">
            @if($profile && $profile->logo)
                <img class="size-12 rounded-lg" src="{{ \Illuminate\Support\Facades\Storage::url($profile->logo) }}"
                    alt="logo" />
            @else
                <img class="size-12" src="{{ asset('images/app-logo.svg') }}" alt="logo" />
            @endif
            <p class="text-xl font-semibold uppercase text-slate-700 dark:text-navy-100">
                {{ $profile->nama_pkbm ?? config('app.name') }}
            </p>
        </a>
    </div>
    <div class="hidden w-full place-items-center lg:grid">
        <div class="w-full max-w-lg p-6">
            <img class="w-full" x-show="!$store.global.isDarkModeEnabled"
                src="{{ asset('images/illustrations/dashboard-check.svg') }}" alt="image" />
            <img class="w-full" x-show="$store.global.isDarkModeEnabled"
                src="{{ asset('images/illustrations/dashboard-check-dark.svg') }}" alt="image" />
        </div>
    </div>
    @livewire('form-forgot-password')
</x-guest-layout>