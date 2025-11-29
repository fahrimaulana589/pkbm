@props(['trigger' => null, 'title' => 'Konfirmasi', 'message' => '', 'action' => null])

<div x-data="{ showModal: false }" @if($trigger) x-on:{{ $trigger }}.window="showModal = true" @endif>
    <template x-teleport="#x-teleport-target">
        <div class="fixed inset-0 z-[100] flex flex-col items-center justify-center overflow-hidden px-4 py-6 sm:px-5"
            x-show="showModal" role="dialog" @keydown.window.escape="showModal = false">
            <div class="absolute inset-0 bg-slate-900/60 transition-opacity duration-300" @click="showModal = false"
                x-show="showModal" x-transition:enter="ease-out" x-transition:enter-start="opacity-0"
                x-transition:enter-end="opacity-100" x-transition:leave="ease-in" x-transition:leave-start="opacity-100"
                x-transition:leave-end="opacity-0"></div>
            <div class="relative max-w-md rounded-lg bg-white pt-10 pb-4 text-center transition-all duration-300 dark:bg-navy-700"
                x-show="showModal" x-transition:enter="easy-out"
                x-transition:enter-start="opacity-0 [transform:translate3d(0,1rem,0)]"
                x-transition:enter-end="opacity-100 [transform:translate3d(0,0,0)]" x-transition:leave="easy-in"
                x-transition:leave-start="opacity-100 [transform:translate3d(0,0,0)]"
                x-transition:leave-end="opacity-0 [transform:translate3d(0,1rem,0)]">
                <div class="avatar size-20">
                    <img class="rounded-full" src="{{ asset('images/200x200.png') }}" alt="avatar" />
                    <div
                        class="absolute right-0 m-1 size-4 rounded-full border-2 border-white bg-primary dark:border-navy-700 dark:bg-accent">
                    </div>
                </div>
                <div class="mt-4 px-4 sm:px-12">
                    <h3 class="text-lg text-slate-800 dark:text-navy-50">
                        {{ $title }}
                    </h3>
                    <p class="mt-1 text-slate-500 dark:text-navy-200">
                        {{ $message }}
                    </p>
                    {{ $slot }}
                </div>
                <div class="my-4 mt-16 h-px bg-slate-200 dark:bg-navy-500"></div>

                <div class="space-x-3">
                    <button @click="showModal = false"
                        class="btn min-w-[7rem] rounded-full border border-slate-300 font-medium text-slate-800 hover:bg-slate-150 focus:bg-slate-150 active:bg-slate-150/80 dark:border-navy-450 dark:text-navy-50 dark:hover:bg-navy-500 dark:focus:bg-navy-500 dark:active:bg-navy-500/90">
                        Batal
                    </button>
                    <button @if($action) wire:click="{{ $action }}" @endif @click="showModal = false"
                        class="btn min-w-[7rem] rounded-full bg-primary font-medium text-white hover:bg-primary-focus focus:bg-primary-focus active:bg-primary-focus/90 dark:bg-accent dark:hover:bg-accent-focus dark:focus:bg-accent-focus dark:active:bg-accent/90">
                        Ya
                    </button>
                </div>
            </div>
        </div>
    </template>
</div>