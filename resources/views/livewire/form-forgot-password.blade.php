<?php

use function Livewire\Volt\{state, rules};
use Illuminate\Support\Facades\Password;

state('email');

rules(fn() => [
    'email'    => 'required|string|email|exists:users,email',
]);

$submit = function () {
    $this->validate();
    $status = Password::sendResetLink(
        ['email' => $this->email]
    );
    if ($status == Password::RESET_LINK_SENT) {
        $this->dispatch('password-reset-link-sent');
    }
    else if($status == Password::RESET_THROTTLED){
        $this->dispatch('password-reset-link-throttled', ['status' => __($status)]);
    } 
    else {
        $this->dispatch('password-reset-link-failed', ['status' => __($status)]);
    }
};

?>

<main class="flex w-full flex-col items-center bg-white dark:bg-navy-700 lg:max-w-md">
    <div class="flex w-full max-w-sm grow flex-col justify-center p-5">
        <div class="text-center">
            <img class="mx-auto size-16 lg:hidden" src="{{ asset('images/app-logo.svg') }}" alt="logo" />
            <div class="mt-4">
                <h2 class="text-2xl font-semibold text-slate-600 dark:text-navy-100">
                    Welcome Back
                </h2>
                <p class="text-slate-400 dark:text-navy-300">
                    Please reset your password to continue
                </p>
            </div>
        </div>
        <form class="mt-16" wire:submit.prevent="submit" method="post">
            <div>
                <label class="relative flex">
                    <input
                        class="form-input peer w-full rounded-lg bg-slate-150 px-3 py-2 pl-9 ring-primary/50 placeholder:text-slate-400 hover:bg-slate-200 focus:ring dark:bg-navy-900/90 dark:ring-accent/50 dark:placeholder:text-navy-300 dark:hover:bg-navy-900 dark:focus:bg-navy-900"
                        placeholder="Username or email" type="text" name="email"
                        wire:model="email"
                        value="{{ old('email')}}" />
                    <span
                        class="pointer-events-none absolute flex h-full w-10 items-center justify-center text-slate-400 peer-focus:text-primary dark:text-navy-300 dark:peer-focus:text-accent">
                        <svg xmlns="http://www.w3.org/2000/svg" class="size-5 transition-colors duration-200"
                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                    </span>
                </label>
                @error('email')
                    <span class="text-tiny+ text-error">{{ $message }}</span>
                @enderror
            </div>

            <button type="submit"
                class="btn mt-10 h-10 w-full bg-primary font-medium text-white hover:bg-primary-focus focus:bg-primary-focus active:bg-primary-focus/90 dark:bg-accent dark:hover:bg-accent-focus dark:focus:bg-accent-focus dark:active:bg-accent/90">
                Reset Password
            </button>
        </form>
    </div>
    <div class="my-5 flex justify-center text-xs text-slate-400 dark:text-navy-300">
        <a href="#">Privacy Notice</a>
        <div class="mx-3 my-1 w-px bg-slate-200 dark:bg-navy-500"></div>
        <a href="#">Term of service</a>
    </div>

    <div 
        x-data="{showModal:false}"
        x-on:password-reset-link-sent.window="showModal = true"
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
              Password Reset Link Sent Successfully
            </h2>
            <p class="mt-2">
              A password reset link has been sent to your email address.
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

    <div 
        x-data="{showModal:false}"
        x-on:password-reset-link-failed.window="showModal = true"
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
            class="inline size-28 text-red-500"
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
              Password Reset Link Failed
            </h2>
            <p class="mt-2">
              Failed to send a password reset link to your email address.
            </p>
            <button
              @click="showModal = false"
              class="btn mt-6 bg-red-500 font-medium text-white hover:bg-red-600 focus:bg-red-600 active:bg-red-600/90"
            >
              Close
            </button>
          </div>
        </div>
      </div>
    </template>
    </div>

     <div 
        x-data="{showModal:false}"
        x-on:password-reset-link-throttled.window="showModal = true"
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
            class="inline size-28 text-amber-400"
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
              Password Reset Link Throttled
            </h2>
            <p class="mt-2">
              You have requested a password reset link too many times. Please try again later.
            </p>
            <button
              @click="showModal = false"
              class="btn mt-6 bg-amber-400 font-medium text-white hover:bg-amber-500 focus:bg-amber-500 active:bg-amber-500/90"
            >
              Close
            </button>
          </div>
        </div>
      </div>
    </template>
    </div>
</main>
