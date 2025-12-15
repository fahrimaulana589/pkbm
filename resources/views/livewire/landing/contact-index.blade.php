<?php

use function Livewire\Volt\{state, with, layout};
use App\Models\Contact;

layout('layouts.landing');

with(fn() => [
    'contacts' => Contact::all()->groupBy('kategori')
]);

?>

<section id="contact" class="py-16 sm:py-20 bg-white dark:bg-navy-900 min-h-screen">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center">
            <h2 class="text-base text-primary font-semibold tracking-wide uppercase">Kontak</h2>
            <p class="mt-2 text-3xl leading-8 font-extrabold tracking-tight text-slate-900 dark:text-white sm:text-4xl">
                Hubungi Kami
            </p>
            <p class="mt-4 max-w-2xl text-xl text-slate-500 dark:text-slate-300 lg:mx-auto">
                Silakan hubungi kami melalui saluran berikut untuk informasi lebih lanjut.
            </p>
        </div>

        <div class="mt-10">
            <div class="grid gap-8 lg:grid-cols-3 md:grid-cols-2 sm:grid-cols-1">
                @forelse($contacts as $category => $items)
                    <div
                        class="flex flex-col rounded-lg shadow-sm border border-slate-100 dark:border-navy-700 overflow-hidden bg-slate-50 dark:bg-navy-800 p-6 hover:shadow-md transition-shadow duration-300">
                        <h3
                            class="text-xl font-bold text-slate-900 dark:text-white mb-4 border-b border-slate-200 dark:border-navy-700 pb-2">
                            {{ ucfirst($category) }}
                        </h3>
                        <ul class="space-y-4">
                            @foreach($items as $item)
                                <li class="flex items-start">
                                    <div class="flex-shrink-0">
                                        @if($item->type == 'email')
                                            <svg class="h-6 w-6 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                            </svg>
                                        @elseif($item->type == 'phone' || $item->type == 'whatsapp')
                                            <svg class="h-6 w-6 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                            </svg>
                                        @elseif($item->type == 'social')
                                            <svg class="h-6 w-6 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1" />
                                            </svg>
                                        @elseif($item->type == 'location' || $item->type == 'address')
                                            <svg class="h-6 w-6 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                            </svg>
                                        @else
                                            <svg class="h-6 w-6 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                        @endif
                                    </div>
                                    <div class="ml-3">
                                        <p class="text-sm font-medium text-slate-900 dark:text-white">
                                            {{ $item->label }}
                                        </p>
                                        <p class="text-base text-slate-500 dark:text-slate-400">
                                            @if($item->type == 'email')
                                                <a href="mailto:{{ $item->value }}"
                                                    class="hover:text-primary transition-colors">{{ $item->value }}</a>
                                            @elseif($item->type == 'phone')
                                                <a href="tel:{{ $item->value }}"
                                                    class="hover:text-primary transition-colors">{{ $item->value }}</a>
                                            @elseif($item->type == 'whatsapp')
                                                <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $item->value) }}"
                                                    target="_blank"
                                                    class="hover:text-primary transition-colors">{{ $item->value }}</a>
                                            @elseif($item->type == 'link' || $item->type == 'social')
                                                <a href="{{ $item->value }}" target="_blank"
                                                    class="hover:text-primary transition-colors">{{ $item->value }}</a>
                                            @else
                                                {{ $item->value }}
                                            @endif
                                        </p>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @empty
                    <div class="col-span-full text-center py-12">
                        <div
                            class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-slate-100 dark:bg-navy-700 mb-4">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-slate-400" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                            </svg>
                        </div>
                        <h3 class="text-lg font-medium text-slate-900 dark:text-white">Belum ada data kontak</h3>
                        <p class="mt-2 text-slate-500 dark:text-slate-400">
                            Informasi kontak belum tersedia saat ini.
                        </p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</section>