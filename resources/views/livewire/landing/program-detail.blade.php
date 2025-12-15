<?php

use Livewire\Volt\Component;
use App\Models\Program;

new class extends Component {
    public $program;

    public function mount($id)
    {
        $this->program = Program::findOrFail($id);
    }
}; ?>

<div class="py-12 bg-white dark:bg-navy-900 min-h-screen">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="mb-8">
            <a href="/program" wire:navigate
                class="inline-flex items-center text-sm font-medium text-slate-500 hover:text-primary dark:text-slate-400 dark:hover:text-accent">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd"
                        d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z"
                        clip-rule="evenodd" />
                </svg>
                Kembali ke Daftar Program
            </a>
        </div>

        <div class="bg-white dark:bg-navy-800 rounded-2xl shadow-xl overflow-hidden">
            <div class="p-8 sm:p-12">
                <div class="flex items-center space-x-4 mb-6">
                    <span class="inline-flex items-center justify-center p-3 bg-primary rounded-lg shadow-lg">
                        <svg class="h-8 w-8 text-white" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path d="M12 14l9-5-9-5-9 5 9 5z" />
                            <path
                                d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14zm-4 6v-7.5l4-2.222" />
                        </svg>
                    </span>
                    <div>
                        <h1 class="text-3xl font-extrabold text-slate-900 dark:text-white sm:text-4xl">
                            {{ $this->program->nama_program }}
                        </h1>
                        <div class="mt-2 flex items-center space-x-4 text-sm text-slate-500 dark:text-slate-400">
                            <span class="flex items-center">
                                <span class="bg-primary/10 text-primary px-2.5 py-0.5 rounded-full font-medium">
                                    {{ $this->program->kategori }}
                                </span>
                            </span>
                            @if($this->program->durasi)
                                <span class="flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    {{ $this->program->durasi }}
                                </span>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="prose prose-slate dark:prose-invert max-w-none">
                    <h3 class="text-xl font-bold text-slate-900 dark:text-white mb-4">Deskripsi Program</h3>
                    <div class="text-slate-600 dark:text-slate-300 leading-relaxed whitespace-pre-line">
                        {{ $this->program->deskripsi }}
                    </div>
                </div>

                <div class="mt-10 pt-8 border-t border-slate-200 dark:border-navy-700">
                    <h3 class="text-lg font-bold text-slate-900 dark:text-white mb-4">Tertarik dengan program ini?</h3>
                    <div class="flex flex-col sm:flex-row gap-4">
                        <a href="/ppdb-daftar" wire:navigate
                            class="inline-flex justify-center items-center px-6 py-3 border border-transparent text-base font-medium rounded-md text-white bg-primary hover:bg-primary-focus focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary shadow-lg hover:shadow-xl transition-all duration-200">
                            Daftar Sekarang
                        </a>
                        <a href="https://wa.me/6281234567890" target="_blank"
                            class="inline-flex justify-center items-center px-6 py-3 border border-slate-300 dark:border-navy-600 text-base font-medium rounded-md text-slate-700 dark:text-slate-200 bg-white dark:bg-navy-700 hover:bg-slate-50 dark:hover:bg-navy-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary transition-all duration-200">
                            <svg class="h-5 w-5 mr-2 text-green-500" fill="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.52.151-.174.2-.297.3-.495.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.008-.57-.008-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413z" />
                            </svg>
                            Konsultasi via WA
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>