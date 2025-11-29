@props(['trigger' => null, 'title' => 'Warning', 'message' => ''])

<div
    x-data="{ showModal: false }"
    @if($trigger)
        x-on:{{ $trigger }}.window="showModal = true; setTimeout(() => showModal = false, 3000)"
    @else
        x-init="showModal = true; setTimeout(() => showModal = false, 3000)"
    @endif
>
    <template x-teleport="#x-teleport-target">
        <div
            class="fixed inset-0 z-[100] flex flex-col items-center justify-center overflow-hidden px-4 py-6 sm:px-5"
            x-show="showModal"
            role="dialog"
            @keydown.window.escape="showModal = false"
        >
            <div
                class="absolute inset-0 bg-slate-900/60 transition-opacity duration-300"
                @click="showModal = false"
                x-show="showModal"
                x-transition:enter="ease-out"
                x-transition:enter-start="opacity-0"
                x-transition:enter-end="opacity-100"
                x-transition:leave="ease-in"
                x-transition:leave-start="opacity-100"
                x-transition:leave-end="opacity-0"
            ></div>
            <div
                class="relative max-w-lg rounded-lg bg-white px-4 py-10 text-center transition-opacity duration-300 dark:bg-navy-700 sm:px-5"
                x-show="showModal"
                x-transition:enter="ease-out"
                x-transition:enter-start="opacity-0"
                x-transition:enter-end="opacity-100"
                x-transition:leave="ease-in"
                x-transition:leave-start="opacity-100"
                x-transition:leave-end="opacity-0"
            >
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    class="inline size-28 text-warning"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor"
                >
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 9v4m0 4h.01" />
                </svg>

                <div class="mt-4">
                    <h2 class="text-2xl text-slate-700 dark:text-navy-100">
                        {{ $title }}
                    </h2>
                    <p class="mt-2">
                        {{ $message }}
                        {{ $slot }}
                    </p>
                    <button
                        @click="showModal = false"
                        class="btn mt-6 bg-warning font-medium text-white hover:bg-warning-focus focus:bg-warning-focus active:bg-warning-focus/90"
                    >
                        Tutup
                    </button>
                </div>
            </div>
        </div>
    </template>
</div>
