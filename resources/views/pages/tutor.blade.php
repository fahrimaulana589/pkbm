<x-landing-layout>
    <div class="bg-gray-100 dark:bg-navy-800 py-4">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <nav class="flex text-sm font-medium text-slate-500 dark:text-slate-400" aria-label="Breadcrumb">
                <ol class="flex items-center space-x-2">
                    <li>
                        <a href="/" class="hover:text-primary dark:hover:text-accent transition-colors">Beranda</a>
                    </li>
                    <li>
                        <span class="text-slate-400">/</span>
                    </li>
                    <li class="text-primary dark:text-accent font-semibold" aria-current="page">Tutor</li>
                </ol>
            </nav>
        </div>
    </div>
    @livewire('landing.tutor-index')
</x-landing-layout>