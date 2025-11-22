<?php

use function Livewire\Volt\{state,rules,mount};

state('user');
state('name');
state('email');

mount(function ($user) {
    $this->name = $user->name;
    $this->email = $user->email;
});

rules(fn() => [
    'name'  => 'required|string|max:255',
    'email' => 'required|string|email|max:255|unique:users,email,' . $this->user->id,
]);

$submit = function () {
    $this->validate();
    $this->user->fill([
        'name'  => $this->name,
        'email' => $this->email,
    ])->save();
    $this->dispatch('profile-updated');
};

?>

<div>
    <!-- Basic Input Text -->
    <div class="card px-4 pb-4 sm:px-5">
        <div class="my-3 flex h-8 items-center justify-between">
            <h2
            class="font-medium tracking-wide text-slate-700 line-clamp-1 dark:text-navy-100 lg:text-base"
            >
            {{ __('Profile Information') }}
            </h2>
        </div>

        <div class="max-w-xl">
            <p>
            {{ __("Update your account's profile information and email address.") }}
            </p>
            <form method="post" wire:submit.prevent="submit" class="mt-5 flex flex-col gap-4">
            @csrf
            @method('patch')
            <label class="block">
                <span>Name</span>
                <input
                @error('name')
                class="form-input mt-1.5 w-full rounded-lg border border-error bg-transparent px-3 py-2 placeholder:text-slate-400/70"                   
                @else
                class="form-input mt-1.5 w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"                    
                @enderror
                placeholder="Name"
                type="text"
                name="name"
                wire:model="name"
                value="{{ old('name') ?? $user->name }}"
                />
                @error('name')    
                <span class="text-tiny+ text-error">{{ $message }}</span>
                @enderror
            </label>
            <label class="block">
                <span>Email</span>
                <input
                @error('email')
                class="form-input mt-1.5 w-full rounded-lg border border-error bg-transparent px-3 py-2 placeholder:text-slate-400/70"                   
                @else
                class="form-input mt-1.5 w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"                    
                @enderror
                placeholder="Email"
                type="text"
                name="email"
                wire:model="email"
                value="{{ old('email') ?? $user->email }}"
                />
                @error('email')    
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
        x-on:profile-updated.window="showModal = true"
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
              Success Message
            </h2>
            <p class="mt-2">
              Profile Updated Successfully.
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

