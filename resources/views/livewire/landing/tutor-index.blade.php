<?php

use function Livewire\Volt\{state, with, uses};
use App\Models\Tutor;
use Livewire\WithPagination;

uses(WithPagination::class);

with(fn() => [
    'tutors' => Tutor::where('status', 'aktif')->paginate(12),
]);

?>

<section class="py-16 sm:py-20 bg-slate-50 dark:bg-navy-900 min-h-screen">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-base text-primary font-semibold tracking-wide uppercase">Tutor</h2>
            <p class="mt-2 text-3xl leading-8 font-extrabold tracking-tight text-slate-900 dark:text-white sm:text-4xl">
                Tenaga Pengajar Profesional
            </p>
            <p class="mt-4 max-w-2xl text-xl text-slate-500 dark:text-slate-300 mx-auto">
                Dibimbing oleh tutor yang berpengalaman dan berdedikasi tinggi dalam dunia pendidikan.
            </p>
        </div>

        <div class="mt-10">
            <ul role="list" class="grid grid-cols-1 gap-6 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4">
                @forelse($tutors as $tutor)
                    <li
                        class="col-span-1 flex flex-col text-center bg-white dark:bg-navy-700 rounded-lg shadow divide-y divide-slate-200 dark:divide-navy-600 hover:shadow-lg transition-shadow duration-300">
                        <div class="flex-1 flex flex-col p-8">
                            <img class="w-32 h-32 flex-shrink-0 mx-auto rounded-full object-cover"
                                src="https://ui-avatars.com/api/?name={{ urlencode($tutor->nama) }}&background=random"
                                alt="{{ $tutor->nama }}">
                            <h3 class="mt-6 text-slate-900 dark:text-white text-sm font-medium">{{ $tutor->nama }}</h3>
                            <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">{{ $tutor->pendidikan_terakhir }}</p>
                            <dl class="mt-1 flex-grow flex flex-col justify-between">
                                <dt class="sr-only">Title</dt>
                                <dd class="text-slate-500 dark:text-slate-300 text-sm">{{ $tutor->keahlian }}</dd>
                            </dl>
                        </div>
                    </li>
                @empty
                    <div class="col-span-full text-center text-slate-500">
                        Belum ada data tutor.
                    </div>
                @endforelse
            </ul>
        </div>

        <div class="mt-12">
            {{ $tutors->links(data: ['scrollTo' => false]) }}
        </div>
    </div>
</section>