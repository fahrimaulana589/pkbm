<?php

use function Livewire\Volt\{state, with, layout};
use App\Models\Contact;

layout('layouts.landing');

with(fn() => [
    'contacts' => Contact::all()
        ->groupBy('kategori')
        ->sortBy(function ($items, $key) {
            return strtolower($key) === 'peta' ? 1 : 0; // Move 'peta' to the end
        })
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

        <div
            class="mt-8 bg-white dark:bg-navy-800 rounded-2xl shadow-sm border border-slate-100 dark:border-navy-700 p-8 sm:p-12">

            <div class="text-left space-y-12">

                @forelse($contacts as $category => $items)
                    <div class="border-t border-slate-100 dark:border-navy-700 pt-8 first:border-0 first:pt-0">
                        <h4
                            class="text-lg font-bold text-slate-900 dark:text-white underline decoration-2 decoration-primary underline-offset-4 mb-6">
                            {{ ucfirst($category) }}
                        </h4>

                        <div class="space-y-4">
                            @foreach($items as $item)
                                @if(in_array($item->type, [\App\Enums\ContactType::ADDRESS]))
                                    <div class="mb-4">
                                        <p class="text-slate-700 dark:text-slate-300 leading-relaxed max-w-3xl">
                                            {{ $item->value }}
                                        </p>
                                    </div>
                                @elseif(in_array($item->type, [\App\Enums\ContactType::MAP]))
                                    @php
                                        $src = $item->value;
                                        if (str_contains($src, '<iframe')) {
                                            preg_match('/src="([^"]+)"/', $src, $match);
                                            $src = $match[1] ?? $src;
                                        }
                                    @endphp
                                    <div
                                        class="aspect-w-16 aspect-h-9 rounded-lg overflow-hidden border border-slate-200 dark:border-navy-600 mt-4">
                                        <iframe src="{{ $src }}" width="100%" height="450" style="border:0;" allowfullscreen=""
                                            loading="lazy" class="w-full h-96 sm:h-[450px]"></iframe>
                                    </div>
                                @else
                                    <div class="grid grid-cols-1 sm:grid-cols-[150px_1fr] gap-2 sm:gap-4">
                                        <span class="font-bold text-slate-800 dark:text-slate-200">
                                            {{ $item->label }} :
                                        </span>
                                        <span class="text-slate-600 dark:text-slate-300">
                                            @if($item->type === \App\Enums\ContactType::EMAIL)
                                                <a href="mailto:{{ $item->value }}"
                                                    class="text-primary hover:underline hover:text-primary-focus transition-colors">{{ $item->value }}</a>
                                            @elseif($item->type === \App\Enums\ContactType::PHONE)
                                                <a href="tel:{{ $item->value }}"
                                                    class="text-primary hover:underline hover:text-primary-focus transition-colors">{{ $item->value }}</a>
                                            @elseif($item->type === \App\Enums\ContactType::WHATSAPP)
                                                <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $item->value) }}" target="_blank"
                                                    class="text-primary hover:underline hover:text-primary-focus transition-colors">{{ $item->value }}</a>
                                            @elseif(in_array($item->type, [\App\Enums\ContactType::LINK, \App\Enums\ContactType::SOCIAL]))
                                                <a href="{{ $item->value }}" target="_blank"
                                                    class="text-primary hover:underline hover:text-primary-focus transition-colors">{{ $item->value }}</a>
                                            @else
                                                {{ $item->value }}
                                            @endif
                                        </span>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </div>
                @empty
                    <p class="text-slate-500 italic">Belum ada data kontak.</p>
                @endforelse

            </div>
        </div>
    </div>
</section>