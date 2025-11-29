@props(['trigger' => null, 'title' => 'Error', 'message' => ''])

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
                    class="inline size-28 text-error"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor"
                >
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 2c5.523 0 10 4.477 10 10s-4.477 10-10 10S2 17.523 2 12 6.477 2 12 2z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M15 9l-6 6M9 9l6 6" />
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
                        class="btn mt-6 bg-error font-medium text-white hover:bg-error-focus focus:bg-error-focus active:bg-error-focus/90"
                    >
                        Tutup
                    </button>
                </div>
            </div>
        </div>
    </template>
</div>
