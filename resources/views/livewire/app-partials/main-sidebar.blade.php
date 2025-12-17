<?php
use Illuminate\Support\Facades\Storage;
use function Livewire\Volt\{state, mount};

state('routePrefix');

$changeRoutePrefix = function ($newPrefix) {
    $this->routePrefix = $newPrefix;
    $this->dispatch('change-menu', $newPrefix);
};

?>
<div class="main-sidebar">
    <div
        class="flex h-full w-full flex-col items-center border-r border-slate-150 bg-white dark:border-navy-700 dark:bg-navy-800">
        <!-- Application Logo -->
        <div class="flex pt-4">
            <a href="/" wire:navigate x-tooltip.placement.right="'{{ $profile->nama_pkbm ?? config('app.name') }}'">
                @if(isset($profile) && $profile && $profile->logo)
                    <img class="size-11 transition-transform duration-500 ease-in-out hover:rotate-[360deg] rounded-lg"
                        src="{{ Storage::url($profile->logo) }}" alt="logo" />
                @else
                    <img class="size-11 transition-transform duration-500 ease-in-out hover:rotate-[360deg]"
                        src="{{ asset('images/app-logo.svg') }}" alt="logo" />
                @endif
            </a>
        </div>

        <!-- Main Sections Links -->
        <div class="is-scrollbar-hidden flex grow flex-col space-y-4 overflow-y-auto pt-6">
            <!-- Dashobards -->
            <button wire:click="changeRoutePrefix('admin')"
                class="flex size-11 items-center justify-center rounded-lg outline-none transition-colors duration-200 {{ $this->routePrefix === 'admin' ? 'text-primary hover:bg-primary/20 focus:bg-primary/20 active:bg-primary/25 dark:bg-navy-600 bg-primary/10 dark:text-accent-light dark:hover:bg-navy-450 dark:focus:bg-navy-450 dark:active:bg-navy-450/90' : 'hover:bg-primary/20 focus:bg-primary/20 active:bg-primary/25 dark:hover:bg-navy-300/20 dark:focus:bg-navy-300/20 dark:active:bg-navy-300/25' }}"
                x-tooltip.placement.right="'Dashboards'">
                <svg class="size-7" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <path fill="currentColor" fill-opacity=".3"
                        d="M5 14.059c0-1.01 0-1.514.222-1.945.221-.43.632-.724 1.453-1.31l4.163-2.974c.56-.4.842-.601 1.162-.601.32 0 .601.2 1.162.601l4.163 2.974c.821.586 1.232.88 1.453 1.31.222.43.222.935.222 1.945V19c0 .943 0 1.414-.293 1.707C18.414 21 17.943 21 17 21H7c-.943 0-1.414 0-1.707-.293C5 20.414 5 19.943 5 19v-4.94Z" />
                    <path fill="currentColor"
                        d="M3 12.387c0 .267 0 .4.084.441.084.041.19-.04.4-.204l7.288-5.669c.59-.459.885-.688 1.228-.688.343 0 .638.23 1.228.688l7.288 5.669c.21.163.316.245.4.204.084-.04.084-.174.084-.441v-.409c0-.48 0-.72-.102-.928-.101-.208-.291-.355-.67-.65l-7-5.445c-.59-.459-.885-.688-1.228-.688-.343 0-.638.23-1.228.688l-7 5.445c-.379.295-.569.442-.67.65-.102.208-.102.448-.102.928v.409Z" />
                    <path fill="currentColor" d="M11.5 15.5h1A1.5 1.5 0 0 1 14 17v3.5h-4V17a1.5 1.5 0 0 1 1.5-1.5Z" />
                    <path fill="currentColor"
                        d="M17.5 5h-1a.5.5 0 0 0-.5.5v3a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-3a.5.5 0 0 0-.5-.5Z" />
                </svg>
            </button>

            <!-- PPDB -->
            <button wire:click="changeRoutePrefix('ppdb')"
                class="flex size-11 items-center justify-center rounded-lg outline-none transition-colors duration-200 {{ $this->routePrefix === 'ppdb' ? 'text-primary hover:bg-primary/20 focus:bg-primary/20 active:bg-primary/25 dark:bg-navy-600 bg-primary/10 dark:text-accent-light dark:hover:bg-navy-450 dark:focus:bg-navy-450 dark:active:bg-navy-450/90' : 'hover:bg-primary/20 focus:bg-primary/20 active:bg-primary/25 dark:hover:bg-navy-300/20 dark:focus:bg-navy-300/20 dark:active:bg-navy-300/25' }}"
                x-tooltip.placement.right="'PPDB'">
                <svg class="size-7" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                    <path fill-opacity=".3"
                        d="M5.25 6.375a4.125 4.125 0 1 1 8.25 0 4.125 4.125 0 0 1-8.25 0ZM2.25 19.125a7.125 7.125 0 0 1 14.25 0v.003l-.001.119a.75.75 0 0 1-.363.63 13.067 13.067 0 0 1-6.761 1.873c-2.472 0-4.786-.684-6.76-1.873a.75.75 0 0 1-.364-.63l-.001-.122Z" />
                    <path
                        d="M18.75 7.5a.75.75 0 0 0-1.5 0v2.25H15a.75.75 0 0 0 0 1.5h2.25v2.25a.75.75 0 0 0 1.5 0v-2.25H21a.75.75 0 0 0 0-1.5h-2.25V7.5Z" />
                </svg>
            </button>

        </div>

        <!-- Bottom Links -->
        <div class="flex flex-col items-center space-y-3 py-3">
            <!-- Settings -->
            <button wire:click="changeRoutePrefix('setting')"
                class="flex size-11 items-center justify-center rounded-lg outline-none transition-colors duration-200 hover:bg-primary/20 focus:bg-primary/20 active:bg-primary/25 dark:hover:bg-navy-300/20 dark:focus:bg-navy-300/20 dark:active:bg-navy-300/25 {{ $this->routePrefix === 'setting' ? 'text-primary hover:bg-primary/20 focus:bg-primary/20 active:bg-primary/25 dark:bg-navy-600 bg-primary/10 dark:text-accent-light dark:hover:bg-navy-450 dark:focus:bg-navy-450 dark:active:bg-navy-450/90' : 'hover:bg-primary/20 focus:bg-primary/20 active:bg-primary/25 dark:hover:bg-navy-300/20 dark:focus:bg-navy-300/20 dark:active:bg-navy-300/25' }}">
                <svg class="size-7" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path fill-opacity="0.3" fill="currentColor"
                        d="M2 12.947v-1.771c0-1.047.85-1.913 1.899-1.913 1.81 0 2.549-1.288 1.64-2.868a1.919 1.919 0 0 1 .699-2.607l1.729-.996c.79-.474 1.81-.192 2.279.603l.11.192c.9 1.58 2.379 1.58 3.288 0l.11-.192c.47-.795 1.49-1.077 2.279-.603l1.73.996a1.92 1.92 0 0 1 .699 2.607c-.91 1.58-.17 2.868 1.639 2.868 1.04 0 1.899.856 1.899 1.912v1.772c0 1.047-.85 1.912-1.9 1.912-1.808 0-2.548 1.288-1.638 2.869.52.915.21 2.083-.7 2.606l-1.729.997c-.79.473-1.81.191-2.279-.604l-.11-.191c-.9-1.58-2.379-1.58-3.288 0l-.11.19c-.47.796-1.49 1.078-2.279.605l-1.73-.997a1.919 1.919 0 0 1-.699-2.606c.91-1.58.17-2.869-1.639-2.869A1.911 1.911 0 0 1 2 12.947Z" />
                    <path fill="currentColor"
                        d="M11.995 15.332c1.794 0 3.248-1.464 3.248-3.27 0-1.807-1.454-3.272-3.248-3.272-1.794 0-3.248 1.465-3.248 3.271 0 1.807 1.454 3.271 3.248 3.271Z" />
                </svg>
            </button>
            <!-- Profile -->
            <div x-data="usePopper({ placement: 'right-end', offset: 12 })"
                @click.outside="if(isShowPopper) isShowPopper = false" class="flex">
                <button @click="isShowPopper = !isShowPopper" x-ref="popperRef" class="avatar size-12">
                    <img class="rounded-full" src="{{ asset('images/200x200.png') }}" alt="avatar" />
                    <span
                        class="absolute right-0 size-3.5 rounded-full border-2 border-white bg-success dark:border-navy-700"></span>
                </button>
                <div :class="isShowPopper && 'show'" class="popper-root fixed" x-ref="popperRoot">
                    <div
                        class="popper-box w-64 rounded-lg border border-slate-150 bg-white shadow-soft dark:border-navy-600 dark:bg-navy-700">
                        <div class="flex items-center space-x-4 rounded-t-lg bg-slate-100 py-5 px-4 dark:bg-navy-800">
                            <div class="avatar size-14">
                                <img class="rounded-full" src="{{ asset('images/200x200.png') }}" alt="avatar" />
                            </div>
                            <div>
                                <a href="#"
                                    class="text-base font-medium text-slate-700 hover:text-primary focus:text-primary dark:text-navy-100 dark:hover:text-accent-light dark:focus:text-accent-light">
                                    Travis Fuller
                                </a>
                                <p class="text-xs text-slate-400 dark:text-navy-300">
                                    Product Designer
                                </p>
                            </div>
                        </div>
                        <div class="flex flex-col pt-2 pb-5">
                            <a href="{{ route('admin.profile') }}" wire:navigate.hover
                                class="group flex items-center space-x-3 py-2 px-4 tracking-wide outline-none transition-all hover:bg-slate-100 focus:bg-slate-100 dark:hover:bg-navy-600 dark:focus:bg-navy-600">
                                <div class="flex size-8 items-center justify-center rounded-lg bg-warning text-white">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="size-4.5" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                    </svg>
                                </div>

                                <div>
                                    <h2
                                        class="font-medium text-slate-700 transition-colors group-hover:text-primary group-focus:text-primary dark:text-navy-100 dark:group-hover:text-accent-light dark:group-focus:text-accent-light">
                                        Profile
                                    </h2>
                                    <div class="text-xs text-slate-400 line-clamp-1 dark:text-navy-300">
                                        Your profile setting
                                    </div>
                                </div>
                            </a>
                            @livewire('user-logout')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>