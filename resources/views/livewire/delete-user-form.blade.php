<?php

use function Livewire\Volt\{state};

state('user');

$confim = function () {
    // Here you can implement password confirmation logic if needed
    $this->dispatch('delete-user-confirmed');
};

$delete = function () {
    // Delete the user's account
    $this->user->delete();

    // Redirect to homepage or goodbye page after deletion
    return $this->redirectRoute('login', [], navigate: true);
};

?>

<div>
    <!-- Basic Input Text -->
    <div class="card px-4 pb-4 sm:px-5">
        <div class="my-3 flex h-8 items-center justify-between">
            <h2
            class="font-medium tracking-wide text-slate-700 line-clamp-1 dark:text-navy-100 lg:text-base"
            >
            {{ __('Delete Account') }}
            </h2>
        </div>

        <div class="max-w-xl">
            <p>
            {{ __("Once your account is deleted, all of its resources and data will be permanently deleted. Please enter your password to confirm you would like to permanently delete your account.") }}
            </p>
            <form method="post" wire:submit.prevent="confim" class="mt-5 flex flex-col gap-4">
            <div>
            <button
                class="btn bg-red-100 font-medium text-slate-800 hover:bg-red-200 focus:bg-red-200 active:bg-red-200/80 dark:bg-red-600 dark:text-navy-50 dark:hover:bg-red-500 dark:focus:bg-red-500 dark:active:bg-red-450/90"
                >
                Delete Account
            </button>
            </div>
            
            </form>
        </div>
    </div>
   
    <div 
        x-data="{showModal:false}"
        x-on:delete-user-confirmed.window="showModal = true"
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
          class="relative max-w-md rounded-lg bg-white pt-10 pb-4 text-center transition-all duration-300 dark:bg-navy-700"
          x-show="showModal"
          x-transition:enter="easy-out"
          x-transition:enter-start="opacity-0 [transform:translate3d(0,1rem,0)]"
          x-transition:enter-end="opacity-100 [transform:translate3d(0,0,0)]"
          x-transition:leave="easy-in"
          x-transition:leave-start="opacity-100 [transform:translate3d(0,0,0)]"
          x-transition:leave-end="opacity-0 [transform:translate3d(0,1rem,0)]"
        >
          <div class="avatar size-20">
            <img
              class="rounded-full"
              src="images/200x200.png"
              alt="avatar"
            />
            <div
              class="absolute right-0 m-1 size-4 rounded-full border-2 border-white bg-primary dark:border-navy-700 dark:bg-accent"
            ></div>
          </div>
          <div class="mt-4 px-4 sm:px-12">
            <h3 class="text-lg text-slate-800 dark:text-navy-50">
              Delete Account confirmation
            </h3>
            <p class="mt-1 text-slate-500 dark:text-navy-200">
              Your account has been successfully deleted. Thank you for being with us.
            </p>
          </div>
          <div class="my-4 mt-16 h-px bg-slate-200 dark:bg-navy-500"></div>

          <div class="space-x-3">
            <button
              @click="showModal = false"
              class="btn min-w-[7rem] rounded-full border border-slate-300 font-medium text-slate-800 hover:bg-slate-150 focus:bg-slate-150 active:bg-slate-150/80 dark:border-navy-450 dark:text-navy-50 dark:hover:bg-navy-500 dark:focus:bg-navy-500 dark:active:bg-navy-500/90"
            >
              Cancel
            </button>
            <button
              wire:click="delete"
              class="btn min-w-[7rem] rounded-full bg-primary font-medium text-white hover:bg-primary-focus focus:bg-primary-focus active:bg-primary-focus/90 dark:bg-accent dark:hover:bg-accent-focus dark:focus:bg-accent-focus dark:active:bg-accent/90"
            >
              Apply
            </button>
          </div>
        </div>
      </div>
    </template>
    </div>
</div>
