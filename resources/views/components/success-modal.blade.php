@props(['trigger' => null, 'title' => 'Berhasil', 'message' => ''])

<div
    x-data="{ showModal: false }"
    @if($trigger)
        x-on:{{ $trigger }}.window="showModal = true;"
    @else
        x-init="showModal = true"
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
                    class="inline size-28 text-success"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"
                    ></path>
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
                        class="btn mt-6 bg-success font-medium text-white hover:bg-success-focus focus:bg-success-focus active:bg-success-focus/90"
                    >
                        Tutup
                    </button>
                </div>
            </div>
        </div>
    </template>
</div>
