<?php

use function Livewire\Volt\{state,rules};

state('user');
state('current_password');
state('new_password');
state('new_password_confirmation');

rules(fn() => [
    'current_password' => 'required|string|current_password',
    'new_password'              => 'required|string|min:8|confirmed',
    'new_password_confirmation' => 'required|string|min:8',
]);

$submit = function () {
    $this->validate();

    // Update the user's password
    $this->user->password = bcrypt($this->new_password);
    $this->user->save();

    $this->dispatch('profile-updated-password');
};

?>

<div>
    <!-- Basic Input Text -->
    <div class="card px-4 pb-4 sm:px-5">
        <div class="my-3 flex h-8 items-center justify-between">
            <h2
            class="font-medium tracking-wide text-slate-700 line-clamp-1 dark:text-navy-100 lg:text-base"
            >
            {{ __('Update Password') }}
            </h2>
        </div>

        <div class="max-w-xl">
            <p>
            {{ __("Ensure your account is using a long, random password to stay secure.") }}
            </p>
            <form method="post" wire:submit.prevent="submit" class="mt-5 flex flex-col gap-4">
            @csrf
            @method('patch')
            <label class="block">
                <span>Current Password</span>
                <input
                @error('current_password')
                class="form-input mt-1.5 w-full rounded-lg border border-error bg-transparent px-3 py-2 placeholder:text-slate-400/70"                   
                @else
                class="form-input mt-1.5 w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"                    
                @enderror
                placeholder="Current Password"
                type="password"
                name="current_password"
                wire:model="current_password"
                value="{{ old('current_password') ?? $user->current_password }}"
                />
                @error('current_password')    
                <span class="text-tiny+ text-error">{{ $message }}</span>
                @enderror
            </label>
            <label class="block">
                <span>New Password</span>
                <input
                @error('new_password')
                class="form-input mt-1.5 w-full rounded-lg border border-error bg-transparent px-3 py-2 placeholder:text-slate-400/70"                   
                @else
                class="form-input mt-1.5 w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"                    
                @enderror
                placeholder="New Password"
                type="password"
                name="new_password"
                wire:model="new_password"
                value="{{ old('new_password') ?? $user->new_password }}"
                />
                @error('new_password')    
                <span class="text-tiny+ text-error">{{ $message }}</span>
                @enderror
            </label>
            <label class="block">
                <span>Confirm New Password</span>
                <input
                @error('new_password_confirmation')
                class="form-input mt-1.5 w-full rounded-lg border border-error bg-transparent px-3 py-2 placeholder:text-slate-400/70"                   
                @else
                class="form-input mt-1.5 w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"                    
                @enderror
                placeholder="Confirm New Password"
                type="password"
                name="new_password_confirmation"
                wire:model="new_password_confirmation"
                value="{{ old('new_password_confirmation') ?? $user->new_password_confirmation }}"
                />
                @error('new_password_confirmation')    
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
        x-on:profile-updated-password.window="showModal = true"
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
              Password Updated Successfully
            </h2>
            <p class="mt-2">
              Your password has been updated.
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
