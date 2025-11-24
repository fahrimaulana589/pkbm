<?php

use function Livewire\Volt\{state,rules,mount};
use App\Models\Setting;

state('email_server');
state('email_port');
state('email_username');
state('email_password');

rules(fn() => [
    'email_server' => 'required|string',
    'email_port' => 'required|integer',
    'email_username' => 'required|string',
    'email_password' => 'required|string',
]);

mount(function () {
    $settings = Setting::find(1);
    if ($settings) {
        $this->email_server = $settings->email_server;
        $this->email_port = $settings->email_port;
        $this->email_username = $settings->email_username;
        $this->email_password = $settings->email_password;
        // Note: For security reasons, you might not want to load the password directly
    }
});

$submit = function () {
    $this->validate();

    // Update the email server settings
    // (Implementation depends on how settings are stored in your application)
    Setting::updateOrCreate(
        ['id' => 1],
        [
            'email_server' => $this->email_server,
            'email_port' => $this->email_port,
            'email_username' => $this->email_username,
            'email_password' => $this->email_password,
        ]
    );

    $this->dispatch('email-server-updated');
};

?>

<div>
    <!-- Basic Input Text -->
    <div class="card px-4 pb-4 sm:px-5">
        <div class="my-3 flex h-8 items-center justify-between">
            <h2
            class="font-medium tracking-wide text-slate-700 line-clamp-1 dark:text-navy-100 lg:text-base"
            >
            {{ __('Update Email Server') }}
            </h2>
        </div>

        <div class="max-w-xl">
            <p>
            {{ __("Ensure your email server settings are correct to stay connected.") }}
            </p>
            <form method="post" wire:submit.prevent="submit" class="mt-5 flex flex-col gap-4">
            <label class="block">
                <span>Email Server</span>
                <input
                @error('email_server')
                class="form-input mt-1.5 w-full rounded-lg border border-error bg-transparent px-3 py-2 placeholder:text-slate-400/70"                   
                @else
                class="form-input mt-1.5 w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"                    
                @enderror
                placeholder="Email Server"
                type="text"
                name="email_server"
                wire:model="email_server"
                value="{{ old('email_server')}}"
                />
                @error('email_server')    
                <span class="text-tiny+ text-error">{{ $message }}</span>
                @enderror
            </label>
            <label class="block">
                <span>Email Port</span>
                <input
                @error('email_port')
                class="form-input mt-1.5 w-full rounded-lg border border-error bg-transparent px-3 py-2 placeholder:text-slate-400/70"                   
                @else
                class="form-input mt-1.5 w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"                    
                @enderror
                placeholder="Email Port"
                type="text"
                name="email_port"
                wire:model="email_port"
                value="{{ old('email_port')}}"
                />
                @error('email_port')    
                <span class="text-tiny+ text-error">{{ $message }}</span>
                @enderror
            </label>
            <label class="block">
                <span>Email Username</span>
                <input
                @error('email_username')
                class="form-input mt-1.5 w-full rounded-lg border border-error bg-transparent px-3 py-2 placeholder:text-slate-400/70"                   
                @else
                class="form-input mt-1.5 w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"                    
                @enderror
                placeholder="Email Username"
                type="text"
                name="email_username"
                wire:model="email_username"
                value="{{ old('email_username')}}"
                />
                @error('email_username')    
                <span class="text-tiny+ text-error">{{ $message }}</span>
                @enderror
            </label>
            <label class="block">
                <span>Email Password</span>
                <input
                @error('email_password')
                class="form-input mt-1.5 w-full rounded-lg border border-error bg-transparent px-3 py-2 placeholder:text-slate-400/70"                   
                @else
                class="form-input mt-1.5 w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"                    
                @enderror
                placeholder="Email Password"
                type="text"
                name="email_password"
                wire:model="email_password"
                value="{{ old('email_password')}}"
                />
                @error('email_password')    
                <span class="text-tiny+ text-error">{{ $message }}</span>
                @enderror
            </label>
            <div>
            <button
                class="btn bg-slate-150 font-medium text-slate-800 hover:bg-slate-200 focus:bg-slate-200 active:bg-slate-200/80 dark:bg-navy-500 dark:text-navy-50 dark:hover:bg-navy-450 dark:focus:bg-navy-450 dark:active:bg-navy-450/90"
                >
                Save
            </button>
            </div>
            
            </form>
        </div>
    </div>
   
    <div 
        x-data="{showModal:false}"
        x-on:email-server-updated.window="showModal = true"
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
              Email Server Updated Successfully
            </h2>
            <p class="mt-2">
              Your email server settings have been updated.
            </p>
            <button
              @click="showModal = false"
              class="btn mt-6 bg-success font-medium text-white hover:bg-success-focus focus:bg-success-focus active:bg-success-focus/90"
            >
              Close
            </button>
          </div>
        </div>
      </div>
    </template>
    </div>
</div>
