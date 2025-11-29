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

    <x-success-modal 
        trigger="password-reset-link-sent" 
        title="Password Reset Link Sent Successfully" 
        message="A password reset link has been sent to your email address." 
    />

    <x-error-modal 
        trigger="password-reset-link-failed" 
        title="Password Reset Link Failed" 
        message="Failed to send a password reset link to your email address." 
    />

    <x-warning-modal 
        trigger="password-reset-link-throttled" 
        title="Password Reset Link Throttled" 
        message="You have requested a password reset link too many times. Please try again later." 
    />
</main>
